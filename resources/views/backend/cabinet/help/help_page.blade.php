@extends('frontend.layout')
@section('content')
    <div class="container-fluid default breadCrumbs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        @if(Auth::check())
                        <li><a href="{{ route('cabinet') }}">Кабинет</a></li>
                        @endif
                        <li><a>Заявка id:{{ getHelpId($help->id) }}</a></li>
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
{{--                            <a href="" class="fondImg"><img src="/img/nophoto.jpg" alt=""></a>--}}
{{--                            <a href="" class="fondImg openGallery"><img src="/img/nophoto.jpg" alt=""><span>+20</span></a>--}}
                        </div>
                    </div>
                    <div class="greyContent">
                        <p class="name">{{ $help->user->last_name }} {{ $help->user->first_name }}, @if($help->region_id != null){{ $help->region->title_ru }}@endif @if($help->district_id != null), {{ $help->district->title_ru }}@endif @if($help->city_id != null), {{ $help->city->title_ru }}@endif</p>
                        <div class="text">
                           {{ $help->body }}
                        </div>
                    </div>
                    <p class="share"><span>Поделиться</span><a href=""><img src="/img/share2.svg" alt=""></a></p>
                </div>
                <div class="col-sm-5">
                    @if(Auth::check())
                    @if($help->user_id == Auth::user()->id)
                        <div class="helpEditBlock">
                            <a href="{{ route('cabinet_edit_page',$help->id) }}" class="btn btn-info mb-4">Редактировать заявку</a>
                        </div>
                    @endif
                    @endif
                    <div class="infoBlock">
                        <p><span>Регион:</span>{{ $help->region->title_ru }}</p>
                        @foreach($help->destinations as $destination)<p><span>{{config('destinations')[$destination->parent_id]}}</span> {{$destination->name_ru}}</p>@endforeach
                        <p><span>Статус заявки:</span>
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
                            @endswitch
                        </p>
                        <p><span>Сфера необходимой помощи:</span>@foreach($help->addHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>
                        <p><span>Тип помощи:</span>@foreach($help->cashHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>
                        <p><span>Сумма необходимой помощи:</span>{{ $help->cashHelpSize->name_ru }}</p>
                        <p><span>Срочность:</span><?php
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
                        <p><span>Документы по запрашиваемой помощи: </span>@foreach($help->docs as $doc)<a href="{{$doc->path}}">{{$doc->original_name}}</a>@endforeach</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
