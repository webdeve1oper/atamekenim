@extends('backend.admin.layout')

@section('content')
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-5 mt-2 mb-2">
            <h1>Обращение: ID{{ getHelpId($help->id) }}</h1>
        </div>
        <div class="col-sm-7">
            @if(is_operator() && $help->admin_status == 'moderate' or is_operator() && $help->admin_status == 'edit' or is_admin() && $help->admin_status == 'moderate' or is_admin() && $help->admin_status == 'edit')
                <ul class="controlButton">
                    <li>
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1">Одобрить и отправить фондам</button>
                    </li>
                    <li>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2">Требует правок</button>
                    </li>
                    <li>
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal3">Отклонить</button>
                    </li>
                    <li>
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal4">Отправить модератору КХ</button>
                    </li>
                </ul>
            @elseif(is_moderator() && $help->admin_status == 'finished' && $help->status_kh == \App\Help::STATUS_KH_POSSIBLY)
                <ul class="controlButton">
                    <li>
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1">Одобрить и отправить фондам</button>
                    </li>
                    <li>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2">Требует правок</button>
                    </li>
                    <li>
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal3">Отклонить</button>
                    </li>
                    <li>
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal5">Одобрено от КХ</button>
                    </li>
                </ul>
            @else
                <div class="alert alert-info" role="alert">
                    Статус указанный оператора - <strong>{{ $help->admin_status }}</strong><br>
                    Статус указанный модератор КХ - <strong>{{ $help->status_kh }}</strong>
                </div>
            @endif
        </div>
        <div class="col-12">
            <p><span>Статус Админа:</span> {{ $help->admin_status }},<br><span>Статус Фонда:</span>  {{ $help->fond_status }}</p>
            <p><span>Благотворительная организация, которой адресован запрос:</span><span class="fondNames">@foreach($help->fonds as $fond) Фонд: {{$fond->title_ru}}<br> @endforeach</span></p>
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
            @if($help->phone)<p><span>Телефон: </span>{{ $help->phone }}</p>@endif
            @if($help->email)<p><span>E-mail: </span>{{ $help->email }}</p>@endif
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
                $user = \App\User::find($help->user_id)->first();
                $images = $help->images;
                ?></p>
            <p><span>Описание необходимой помощи:</span> </p>


            <form action="{{ route('update_help_from_admin',$help->id) }}" method="POST">
                @csrf
                <textarea name="help_body" id="helpBody" style="width: 100%;height: 400px" placeholder="Введите описание">
                    {{ $help->body }}
                </textarea>
                <button class="btn btn-primary" type="submit" style="margin-top: 15px">Изменить описание</button>
            </form>
            <br>
            <br>



            <p><span>Фотографии получателя помощи:</span> @if($images)
                <ul class="justify-content-start d-flex list-unstyled">
                    @foreach($images as $image)
                        <li class="mr-4" style="position: relative;">
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{$image->image}}" class="img-fluid" style="max-width: 200px; height: 100px; object-fit: cover;" alt="">
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @endif</p>
            <p><span>Видео получателя помощи:</span> {{$help->video ?? 'отсутствует'}}</p>
            <p><span>Документы:</span> <br>@foreach($help->docs as $doc)<a href="{{$doc->path}}">{{$doc->original_name}}</a> <br>@endforeach</p>
            <p><span>Контакты заявителя:</span> {{$help->user->phone ?? 'Данные отсутствуют'}}</p>
            <p><span>E-mail:</span> {{$help->user->email ?? 'Данные отсутствуют'}}</p>


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
                                        Направляется всем фондам, кроме фонда “Қазақстан Халқына”
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Одобрить и отправить фондам</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Одобрить запрос Возможно КХ -->
            <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input class="form-check-input d-none" type="radio" name="status_name" id="flexRadioDefault1" value="kh" checked="checked">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Направляется на рассмотрение модераторам “Қазақстан Халқына”
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Отправить модератору КХ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Одобрить запрос железно с КХ от КХ -->
            <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input class="form-check-input d-none" type="radio" name="status_name" id="flexRadioDefault1" value="kh_approved" checked="checked">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Направляется на рассмотрение фондам
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Одобрено от КХ</button>
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
                                        Отправить на доработку
                                    </label>
                                    <!--select-->
                                    <div class="form-floating mt-2">
                                        <select class="form-select" id="floatingSelect" aria-label="Причина доработок?" name="whyedit">
                                            <option disabled selected>Выбрать причину:</option>
                                            <option value="Дубликат заявки">Доработка контактные данные</option>
                                            <option value="Доработка документы">Доработка документы</option>
                                            <option value="Доработка описание">Доработка описание</option>
                                            <option value="Иное">Иное</option>
                                        </select>
                                        <label for="floatingSelect">Причина отклонения?</label>
                                    </div>
                                    <!--editor-->
                                    <div class="form-floating mt-2">
                                        <textarea class="form-control" name="comment_edit" placeholder="Комментарий" id="floatingTextarea"></textarea>
                                        <label for="floatingTextarea">Комментарий?</label>
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
                                        Отклонить запрос
                                    </label>

                                    <!--select-->
                                    <div class="form-floating mt-2">
                                        <select class="form-select" id="floatingSelect" aria-label="Причина отклонения?" name="whycancel">
                                            <option disabled selected>Выбрать причину:</option>
                                            <option value="Дубликат заявки">Дубликат заявки</option>
                                            <option value="Иное">Иное</option>
                                        </select>
                                        <label for="floatingSelect">Причина отклонения?</label>
                                    </div>
                                    <div class="form-floating mt-2">
                                        <textarea class="form-control" name="comment_cancel" placeholder="Комментарий" id="floatingTextarea"></textarea>
                                        <label for="floatingTextarea">Комментарий</label>
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
