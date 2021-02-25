@extends('backend.fond_cabinet.layout')

@section('fond_content')
        <div class="container-fluid default myOrganizationContent">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="greyInfoBlock firstBig">
                            <div class="row">
                                <div class="col-sm-3">
                                    @if($fond->logo)
                                        <img src="{{$fond->logo}}" alt="" class="logotype">
                                    @else
                                        <img src="/img/no-photo.png" alt="" class="logotype">
                                    @endif
                                </div>
                                <div class="col-sm-9">
                                    <h1>Общественное объединение {{$fond->title}}</h1>
                                    <p class="descr">Поздравляем, в {{date('Y')}} году Вы реализовали {{$fond->helpsByDate(date('Y'))->count()}} заявок
                                        <span>на общую сумму 1 045 768 тенге</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{route('fond_setting')}}" class="settings">Настройки <img src="/img/settings.svg" alt=""></a>
                    </div>
                    <div class="col-sm-8">
                        <div class="greyInfoBlock mini">
                            <?php $waitHelps = $fond->helpsByStatus('wait')->get();?>
                            <p class="countTag blue">Новые заявки <span>{{$waitHelps->count()}}</span></p>
                            <a href="" class="btn-default">Поиск по всем заявкам</a>
                                @if($waitHelps->count()>0)
                                @foreach($waitHelps as $help)
                                    <div class="applicationBlock">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="tags default blue">{{$help->baseHelpTypes[0]->name_ru}}</p>
{{--                                                <p><span>{{}}</span>, 30 лет</p>--}}
                                                <p>{{$help->region->title_ru}}, {{$help->city->title_ru}}</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="name">Содержание просьбы / заявление</p>
                                                <p>{!! mb_substr($help->body, 0,100) !!}...</p>
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="name">Статус ТЖС:</p>
                                                <p class="tags default mini red">120 баллов</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="" class="btn-default">Подробнее</a>
                                                <form action="{{route('start_help', $help->id)}}" method="post">
                                                    @csrf
                                                    <button class="btn-default blue">Взять в работу</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @endif
                        </div>
                        <?php $processHelps = $fond->helpsByStatus('process')->get(); ?>
                        <div class="greyInfoBlock mini">
                            <p class="countTag red">Заявки в работе <span>{{$processHelps->count()}}</span></p>
                            @if($processHelps->count()>0)
                                @foreach($processHelps as $process)
                                    <div class="applicationBlock">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="tags default blue">{{$process->baseHelpTypes[0]->name_ru}}</p>
                                                {{--<p><span>Мужчина</span>, {{$process->user()->name}} лет</p>--}}
                                                <p>{{$process->region->title_ru}}, {{$process->city->title_ru}}</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="name">Содержание просьбы / заявление</p>
                                                <p>{!! mb_substr($process->body, 0,100) !!}...</p>
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="name">Статус ТЖС:</p>
                                                <p class="tags default mini red">120 баллов</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="name center">Статус:</p>
                                                <p class="tags default mini grey mb-2">В работе с {{\Carbon\Carbon::parse($process->date_fond_start)->format('d.m.Y')}}</p>
                                                <form action="{{route('finish_help', $process->id)}}" method="post">
                                                    @csrf
                                                    <button class="btn-default blue">Выполнена</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="" class="btn-default more">Смотреть все заявки</a>
                            @endif
                        </div>

                        <?php $finishedHelps = $fond->helpsByStatus('finished')->get(); ?>
                        <div class="greyInfoBlock mini">
                            <p class="countTag green">Выполненные заявки <span>{{$finishedHelps->count()}}</span></p>
                            @if($finishedHelps->count()>0)
                            @foreach($finishedHelps as $process)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="tags default blue">{{$process->baseHelpTypes[0]->name_ru}}</p>
                                            <p><span>{{$process->user->gender=='male'?'Мужчина':'Женщина'}}</span>, {{\Carbon\Carbon::parse($process->user->born)->age }} лет </p>
                                            <p>{{$process->region->title_ru}}, {{$process->city->title_ru}}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="name">Содержание просьбы / заявление</p>
                                            <p>{!! mb_substr($process->body, 0,100) !!}...</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">Статус ТЖС:</p>
                                            <p class="tags default mini red">120 баллов</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name center">Статус:</p>
                                            <p class="tags default mini green">Выполнена {{\Carbon\Carbon::parse($process->date_fond_finish)->format('d.m.Y')}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <a href="" class="btn-default more">Смотреть все заявки</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="greyContent">
                            <div class="miniStatusBlock">
                                <p class="greyText">Общий рейтинг:: <span class="green">95%</span></p>
                            </div>
                            <p class="date">Смотреть историю по годам:</p>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    2010-2020
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">2010-2020</a>
                                    <a class="dropdown-item" href="#">2010-2020</a>
                                    <a class="dropdown-item" href="#">2010-2020</a>
                                </div>
                            </div>
                            <div class="content">
                                <p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>
                                <p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>
                                <p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>
                                <p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>
                                <p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>
                                <p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>
                                <p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>
                                <p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>
                                <a href="">Посмотреть похожие благотворительные организации</a>
                                <a href="">Больше аналитики</a>
                                <a href="">Как можно улучшить показатели?</a>
                                <a href="">Из чего формируется рейтинг?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
