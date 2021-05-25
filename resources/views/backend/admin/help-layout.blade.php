@extends('backend.admin.layout')

@section('content')
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-6 mt-2 mb-2">
            <h1>Обращение: ID{{ $help->id }}</h1>
        </div>
        <div class="col-sm-6">
            <ul class="controlButton">
                <li>
                    <button class="btn btn-success">Одобрить</button>
                </li>
                <li>
                    <button class="btn btn-primary">Требует правок</button>
                </li>
                <li>
                    <button class="btn btn-danger">Отклонить</button>
                </li>
            </ul>
        </div>
        <div class="col-12">
            <p><span>Статус:</span> {{ $help->admin_status }} {{ $help->fond_status }}</p>
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
            @if($help->admin_status == 'moderate')
                <button class="btn btn-primary mt-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    Действия
                </button>
            @else
                <div class="alert alert-info" role="alert">
                    Статус указанный админом - <strong>{{ $help->admin_status }}</strong>
                </div>
            @endif

            <!--Control Form-->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Действия</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="mb-5 display-7 border-bottom border-info d-table">
                        Задать статус для запроса: "{{ $help->title }}"
                    </div>
                    <div class="dropdown mt-3">
                        <form action="{{ route('edit_help_status') }}" method="post">
                            @csrf
                            <input type="text" name="help_id" class="d-none" value="{{ $help->id }}">
                            <div class="form-check my-3 border-bottom pb-3">
                                <input class="form-check-input" type="radio" name="status_name" id="flexRadioDefault1" value="finished">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Одобрить запрос
                                </label>
                            </div>
                            <div class="form-check my-3 border-bottom pb-3">
                                <input class="form-check-input" type="radio" name="status_name" id="flexRadioDefault2" value="edit">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Отправить на доработку (необходимо написать причину***)
                                </label>

                                <!--editor-->
                                <div class="form-floating mt-2">
                                    <textarea class="form-control" name="whyfordesc" placeholder="Причина отправки запроса на доработку?" id="floatingTextarea"></textarea>
                                    <label for="floatingTextarea">Причина?</label>
                                </div>
                            </div>

                            <div class="form-check my-3">
                                <input class="form-check-input" type="radio" name="status_name" id="flexRadioDefault3" value="cancel">
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

                            <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Отправить</button>
                        </form>
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
