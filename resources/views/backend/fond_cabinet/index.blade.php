@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default accountMenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href="">Избранные заявки</a></li>
                            <li><a href="">История заявок</a></li>
                            <li><a href="">Мои поступления</a></li>
                            <li><a href="">Сообщения</a></li>
                            <li><a href="">Мои отзывы</a></li>
                            <li><a href="">Мой кабинет</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

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
                            <?php $waitHelps = $fond->helpsByStatus('wait'); ?>
                            <p class="countTag blue">Новые заявки <span>{{$waitHelps->count()}}</span></p>
                            <a href="" class="btn-default">Поиск по всем заявкам</a>
                                @if($waitHelps->count()>0)
                                    <?php dd($waitHelps); ?>
                                @foreach($waitHelps as $help)
                                    <div class="applicationBlock">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="tags default blue">Социальная помощь</p>
{{--                                                <p><span>{{}}</span>, 30 лет</p>--}}
                                                <?php dd($help); ?>
                                                <p>Акмолинская область, село Косши</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="name">Содержание просьбы / заявление</p>
                                                <p>Прошу оказать помощь в приобретении ноутбука ребенку для удаленного обучения</p>
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="name">Статус ТЖС:</p>
                                                <p class="tags default mini red">120 баллов</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="" class="btn-default">Подробнее</a>
                                                <button class="btn-default blue">Взять в работу</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @endif
                        </div>
                        <?php $processHelps = $fond->helpsByStatus('process'); ?>
                        <div class="greyInfoBlock mini">
                            <p class="countTag red">Заявки в работе <span>{{$processHelps->count()}}</span></p>
                            @if($processHelps->count()>0)
                                @foreach($processHelps as $process)
                                    <div class="applicationBlock">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="tags default blue">@foreach($process->baseHelpTypes() as $help){{$help}}@endforeach</p>
                                                <p><span>Мужчина</span>, {{$process->user()->name}} лет</p>
                                                <p>Акмолинская область, село Косши</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="name">Содержание просьбы / заявление</p>
                                                <p>Прошу оказать помощь в приобретении ноутбука ребенку для удаленного обучения</p>
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="name">Статус ТЖС:</p>
                                                <p class="tags default mini red">120 баллов</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="name center">Статус:</p>
                                                <p class="tags default mini grey">В работе с 11.11.2020</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="" class="btn-default more">Смотреть все заявки</a>
                            @endif
                        </div>

                        <?php $finishedHelps = $fond->helpsByStatus('finished'); ?>
                        <div class="greyInfoBlock mini">
                            <p class="countTag green">Выполненные заявки <span>{{$finishedHelps->count()}}</span></p>
                            @if($finishedHelps->count()>0)
                            @foreach($finishedHelps as $process)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="tags default blue">@foreach($process->baseHelpTypes() as $help){{$help}}@endforeach</p>
                                            <p><span>Мужчина</span>, 30 лет</p>
                                            <p>Акмолинская область, село Косши</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="name">Содержание просьбы / заявление</p>
                                            <p>Прошу оказать помощь в приобретении ноутбука ребенку для удаленного обучения</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">Статус ТЖС:</p>
                                            <p class="tags default mini red">120 баллов</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name center">Статус:</p>
                                            <p class="tags default mini green">Выполнена 11.11.2020</p>
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


    </div>
@endsection
