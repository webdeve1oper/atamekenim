@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default accountMenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Личная страница заявителя</h1>
                        <ul class="myAccountMenu">
                            <li><a href="{{route('history')}}">История обращений</a></li>
                            <li><a href="{{route('reviews')}}">Мои отзывы</a></li>
                            <li><a href="">Сообщения</a></li>
                            <li><a href="">Мои фото</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default myOrganizationContent myAccountPage">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="greyInfoBlock accountInfo">
                            <div class="row">
                                <div class="col-sm-2 col-4">
                                    @if(Auth::user()->avatar)
                                        <img src="{{Auth::user()->avatar}}" alt="" class="avatar">
                                    @else
                                        <img src="/img/no-photo.png" alt="" class="avatar">
                                    @endif
                                </div>
                                <div class="col-sm-10 col-8">
                                    <p class="name">Добро пожаловать, {{Auth::user()->first_name}} {{Auth::user()->patron}}!</p>
                                    <p class="descr">В 2020 г. Вам оказали помощь на сумму в 1 254 000 тенге</p>
                                </div>
                            </div>
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag green">Исполненные <span>{{$finishedHelps->count()}}</span></p>
                            <p class="countTag red">Вы еще не оставили отзывы к выполненным заявкам <span>2</span></p>
                            @foreach($finishedHelps as $help)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="name">Помощь:</p>
                                            <p class="tags default mini blue">{{$help->baseHelpTypes()[0]->name_ru}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">Дата подачи:</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">Содержание просьбы / заявление</p>
                                            <p>{{$help->body}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">Сумма</p>
                                            <p>50 000 - 100 000 тг</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">Кому:</p>
                                            @foreach($help->fonds as $fond)
                                                <p>{{$fond->website}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <a href="" class="btn-default more">Смотреть все заявки</a>
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag blue">В ожидании благотворителя <span>{{$waitHelps->count()}}</span></p>
                                @foreach($waitHelps as $help)
                                    <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="name">Помощь:</p>
                                            @foreach($help->baseHelpTypes as $helps)<p class="tags default mini blue">{{$helps->name_ru}}</p>@endforeach
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">Дата подачи:</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">Содержание просьбы / заявление</p>
                                            <p>{{$help->body}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">Сумма</p>
                                            <p>50 000 - 100 000 тг</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">Кому:</p>
                                            @foreach($help->fonds as $fond)
                                                <p>{{$fond->website}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                    </div>
                                @endforeach
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag red">Заявки в работе <span>{{$processHelps->count()}}</span></p>
                            @foreach($processHelps as $help)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="name">Помощь:</p>
                                            <p class="tags default mini blue">Образование</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">Дата подачи:</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">Содержание просьбы / заявление</p>
                                            <p>{{$help->body}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">Сумма</p>
                                            <p>50 000 - 100 000 тг</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">Кому:</p>
                                            @foreach($help->fonds as $fond)
                                                <p>{{$fond->website}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <a href="" class="btn-default more">Смотреть все заявки в работе</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="greyContent accountGreyContent">
                            <p class="big">Личная информация</p>
                            <a href="{{route('editUser', [Auth::user()->id])}}" class="settings">Редактировать <img src="/img/settings.svg" alt=""></a>
                            <p>
                                <span>Место рождения:</span>
{{--                                <span>{{Auth::user()}}</span>--}}
                            </p>
                            <p>
                                <span>Место проживания:</span>
                                <span>Алматинская область, Талгарский район, г. Талгар</span>
                            </p>
                            <p>
                                <span>Образование:</span>
                                <span>{{Auth::user()->education ?? '-'}}</span>
                            </p>
                            <p>
                                <span>Место работы:</span>
                                <span>{{Auth::user()->job ?? '-'}}</span>
                            </p>
                            <p>
                                <span>Количество детей:</span>
                                <span>{{Auth::user()->children_count == 0? '-':Auth::user()->children_count}}</span>
                            </p>
                            <p>
                                <span>Контакты:</span>
                                <span>{{preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', Auth::user()->phone)}}</span>
                            </p>
                            <p>
                                <span>О себе:</span>
                                <span class="fullText">
                                   {{Auth::user()->about}}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
