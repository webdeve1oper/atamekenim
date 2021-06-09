@extends('backend.admin.layout')

@section('content')
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-6 mt-2 mb-2">
            <h1>Обращение: ID{{ $help->id }}</h1>
        </div>
        <div class="col-sm-6">
            @if($help->admin_status == 'moderate')
                <ul class="controlButton">
                    <li>
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1">Одобрить</button>
                    </li>
                    <li>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2">Требует правок</button>
                    </li>
                    <li>
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal3">Отклонить</button>
                    </li>
                </ul>
            @else
                <div class="alert alert-info" role="alert">
                    Статус указанный админом - <strong>{{ $help->admin_status }}</strong>
                </div>
            @endif
        </div>
        <div class="col-12">
            <p><span>Статус Админа:</span> {{ $help->admin_status }},<br><span>Статус Фонда:</span>  {{ $help->fond_status }}</p>
            <p><span>Благотворительная организация, которой адресован запрос:</span><span class="fondNames">@foreach($help->fonds as $fond)Фонд: {{$fond->title_ru}}<br>@endforeach</span></p>
            <style>
                span.fondNames {
                    display: table;
                    border: 1px solid #eee;
                    padding: 15px 12px;
                    border-radius: 5px;
                    font-size: 14px;
                    line-height: 1.8;
                }
            </style>
            <p><span>Дата подачи:</span> {{ date('d-m-Y', strtotime($help->created_at)) }}</p>
            <p><span>Кому необходима помощь:</span> {{ $help->whoNeedHelp->name_ru }}</p>
            <p><span>ФИО заявителя:</span> {{ $help->user->last_name }} {{ $help->user->first_name }}</p>
            <hr>
            <p><span>ТЖС:</span> --</p>
            @foreach($help->destinations as $destination)<p><span>{{config('destinations')[$destination->parent_id]}}</span>: {{$destination->name_ru}}</p>@endforeach
            <hr>
            <p><span>Сфера:</span> @foreach($help->addHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>
            <p><span>Место оказания помощи:</span> @if($help->region_id != null){{ $help->region->title_ru }}@endif @if($help->district_id != null), {{ $help->district->title_ru }}@endif @if($help->city_id != null), {{ $help->city->title_ru }}@endif</p>
            <p><span>Тип помощи:</span> @foreach($help->cashHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>
            <p><span>Сумма необходимой помощи:</span> {{ $help->cashHelpSize->name_ru }}</p>
            <p><span>Срочность:</span> <?php
                switch ($help->urgency_date) {
                    case 1:
                        echo "в течение 1 месяца";
                        break;
                    case 2:
                        echo "в течение 3 месяцев";
                        break;
                    case 3:
                        echo "в течение 6 месяцев";
                        break;
                    case 4:
                        echo "в течение 1 года";
                        break;
                }
                ?></p>
            <p><span>Описание необходимой помощи:</span> </p>
            <p>{{ $help->body }}</p>
            <p><span>Фотографии получателя помощи:</span> Отсутствуют</p>
            <p><span>Видео получателя помощи:</span> Отсутствует</p>
            <p><span>Документы:</span> @foreach($help->docs as $doc)<a href="{{$doc->path}}">{{$doc->original_name}}</a>@endforeach</p>
            <p><span>Контакты заявителя:</span> +77012222232</p>
            <p><span>E-mail:</span> ivan@mail.ru</p>


            <!-- Одобрить запрос -->
            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Одобрить запрос {{ $help->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('edit_help_status') }}" method="post">
                                @csrf
                                <input type="text" name="help_id" class="d-none" value="{{ $help->id }}">
                                <div class="form-check my-3 border-bottom pb-3">
                                    <input class="form-check-input d-none" type="radio" name="status_name" id="flexRadioDefault1" value="finished" checked="checked">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Одобрить запрос
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Одобрить запрос</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Отправить на доработку -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabe2" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Отправить на доработку запрос {{ $help->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('edit_help_status') }}" method="post">
                                @csrf
                                <input type="text" name="help_id" class="d-none" value="{{ $help->id }}">
                                <div class="form-check my-3 border-bottom pb-3">
                                    <input class="form-check-input d-none" type="radio" name="status_name" id="flexRadioDefault2" value="edit" checked="checked">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Отправить на доработку (необходимо написать причину***)
                                    </label>

                                    <!--editor-->
                                    <div class="form-floating mt-2">
                                        <textarea class="form-control" name="whyfordesc" placeholder="Причина отправки запроса на доработку?" id="floatingTextarea"></textarea>
                                        <label for="floatingTextarea">Причина?</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4 mx-auto d-table">Отправить на доработку</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Отклонить запрос -->
            <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabe3" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Отклонить запрос {{ $help->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('edit_help_status') }}" method="post">
                                @csrf
                                <input type="text" name="help_id" class="d-none" value="{{ $help->id }}">
                                <div class="form-check my-3">
                                    <input class="form-check-input d-none" type="radio" name="status_name" id="flexRadioDefault3" value="cancel" checked="checked">
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Отклонить запрос (необходимо выбрать причину***)
                                    </label>

                                    <!--select-->
                                    <div class="form-floating mt-2">
                                        <select class="form-select" id="floatingSelect" aria-label="Причина отклонения запроса?" name="whycancel">
                                            <option disabled selected>Выбрать причину:</option>
                                            <option value="Нельзя">Нельзя</option>
                                            <option value="Потому что">Потому что</option>
                                            <option value="Документы">Документы</option>
                                        </select>
                                        <label for="floatingSelect">Причина отклонения запроса?</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-danger mt-4 mx-auto d-table">Отклонить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .controlButton{
        display: table;
        margin: 0;
    }
    .controlButton li{
        display: inline-table;
        vertical-align: middle;
        margin: 0 16px 0 0;
    }
</style>
