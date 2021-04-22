@extends('frontend.layout')
@section('content')
    <div class="container-fluid default breadCrumbs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('fond_cabinet') }}">Кабинет</a></li>
                        <li><a>Заявка id:{{ $help->id }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid default completeApplicationPage">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <p class="blueName">Заявка ID: <span>{{ getHelpId($help->id) }}</p>
                </div>
                <div class="col-sm-12 mb-4">
                </div>
                <div class="col-sm-7">
                    <div class="applicationGallery">
                        <div class="bigImage">
                            <?php $images = $help->images->toArray(); ?>
                            @if($images)
                                <a href=""><img src="{{$images[0]['image']}}" alt="" style="object-fit: cover!important"></a>
                                <?php array_shift($images); ?>
                            @else
                                <a href=""><img src="/img/nophoto.jpg" alt=""></a>
                            @endif
                        </div>
                        <div class="galleryBlock">
                            @if($images)
                                @foreach($images as $image)
                                    <a href=""><img src="{{$image['image']}}" alt=""></a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="greyContent">
                        <p class="name">{{ $help->user->last_name }} {{ $help->user->first_name }}, @if($help->region_id != null){{ $help->region->title_ru }}@endif @if($help->district_id != null), {{ $help->district->title_ru }}@endif @if($help->city_id != null), {{ $help->city->title_ru }}@endif </p>
                        <div class="text">
                            {{ $help->body }}
                        </div>
                    </div>
                    <p class="share"><span>Поделиться</span><a href=""><img src="/img/share2.svg" alt=""></a></p>
                </div>
                <div class="col-sm-5">
                    @if($help->fond_status == 'wait')
                    <form action="{{route('start_help', $help->id)}}" method="post" class="mb-4">
                        @csrf
                        <button class="btn-default blue">{{trans('fond-cab.take-work')}}</button>
                    </form>
                    @endif
                    <div class="infoBlock">
                        <p><span>Статус обращения:</span>
                            @switch($help->fond_status)
                                @case('moderate')
                                на модерации
                                @break
                                @case('wait')
                                в ожидании благотворителя
                                @break
                                @case('process')
                                в работе
                                @break
                            @endswitch</p>
                        <p><span>Сфера необходимой помощи:</span>@foreach($help->addHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>
                        <p><span>Тип помощи:</span>{{ $help->cashHelpTypes[0]->name_ru }}</p>
                        <p><span>Сумма необходимой помощи:</span>{{ $help->cashHelpSize->name_ru }}</p>
                        <p><span>Срочность:</span>
                        <?php
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
                            ?>
                        </p>
                    </div>

                    <div class="infoBlock">
                        <p><span>Кому необходима помощь:</span>{{$help->whoNeedHelp->name_ru}}</p>
                        <p><span>ФИО заявителя:</span>{{ $help->user->last_name }} {{ $help->user->first_name }}</p>
                        <p><span>Место оказания помощи:</span>@if($help->region_id != null){{ $help->region->title_ru }}@endif @if($help->district_id != null), {{ $help->district->title_ru }}@endif @if($help->city_id != null), {{ $help->city->title_ru }}@endif</p>
                        <p><span>ТЖС:</span>--</p>
                        <p><span>Год рождения:</span>{{ $help->user->born }}</p>
                        <p><span>Контактный телефон:</span>{{ $help->user->phone }}</p>
                        <p><span>E-mail:</span>{{ $help->user->email }}</p>
                    </div>

                    <div class="infoBlock">
                        @foreach($help->destinations as $destination)<p><span>{{config('destinations')[$destination->parent_id]}}</span> {{$destination->name_ru}}</p>@endforeach
                    </div>

                    <div class="infoBlock">
                        <p><span>Документы:</span>@foreach($help->docs as $doc)<a href="{{$doc->path}}">{{$doc->original_name}}</a>@endforeach</p>
                    </div>
                </div>
            </div>
        </div>
    </div>








    <div class="container-fluid default helperBlock helpInProjectPage">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4>Другие исполненные заявки</h4>
                    <a href="{{route('dev')}}" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
                </div>
                @foreach($finished_helps as $help)
                    <div class="col-sm-3">
                        <div class="helpBlock newHelp">
                            <div class="content">
                                <p>Помощь: <span class="tag blue">@foreach($help->addHelpTypes as $helps){{$helps->name_ru}}@endforeach</span></p>
                                <p>Кому: <span>
                                @if(Auth::guard('fond')->check())
                                            {{$help->user->first_name}},  {{\Carbon\Carbon::parse($help->user->born)->age }} лет
                                        @else
                                            @if($help->user->gender=='male') Мужчина @elseif($help->user->gender=='female') Женщина @else Не указано @endif
                                        @endif</span></p>
                                <p>Регион: <span>@if($help->region){{$help->region->title_ru}}@endif</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">Открытая заявка</p>
                            <img src="/img/support1.svg" alt="" class="bkg">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
