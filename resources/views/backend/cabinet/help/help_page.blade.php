@extends('frontend.layout')
@section('content')
    <div class="container-fluid default breadCrumbs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('cabinet') }}">Кабинет</a></li>
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
                    <p class="blueName">Заявка ID: <span>{{ $help->id }}</p>
                </div>
                <div class="col-sm-12 mb-4">
                </div>
                <div class="col-sm-7">
                    <div class="applicationGallery">
                        <div class="bigImage">
                            <a href=""><img src="/img/nophoto.jpg" alt=""></a>
                        </div>
                        <div class="galleryBlock">
                            <a href="" class="fondImg"><img src="/img/nophoto.jpg" alt=""></a>
                            <a href="" class="fondImg"><img src="/img/nophoto.jpg" alt=""></a>
                            <a href="" class="fondImg openGallery"><img src="/img/nophoto.jpg" alt=""><span>+20</span></a>
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
                    @if($help->user_id == Auth::user()->id)
                        <div class="helpEditBlock">
                            <a href="{{ route('cabinet_edit_page',$help->id) }}" class="btn btn-info mb-4">Редактировать заявку</a>
                        </div>
                    @endif
                    <div class="infoBlock">
                        <p><span>Регион:</span>{{ $help->region->title_ru }}</p>
                        @foreach($help->destinations as $destination)<p><span>{{config('destinations')[$destination->parent_id]}}</span> {{$destination->name_ru}}</p>@endforeach
                        <p><span>Статус заявки:</span>{{ $help->fond_status }}</p>
                        <p><span>Сфера необходимой помощи:</span>@foreach($help->addHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>
                        <p><span>Тип помощи:</span>{{ $help->cashHelpTypes[0]->name_ru }}</p>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
