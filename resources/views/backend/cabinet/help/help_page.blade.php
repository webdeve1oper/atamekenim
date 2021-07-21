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
                                <a href="{{$images[0]['image']}}" data-lightbox="gallery"><img src="{{$images[0]['image']}}" alt="" style="object-fit: cover!important"></a>
                                <?php array_shift($images); ?>
                            @else
                                <a href="#"><img src="/img/nophoto.jpg" alt=""></a>
                            @endif
                        </div>
                        <div class="galleryBlock">
                            @if($images)
                                @foreach($images as $image)
                                    <a href="{{$image['image']}}" data-lightbox="gallery"><img src="{{$image['image']}}" alt=""></a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="greyContent">
                        <p class="name"> @if(Auth::check() or Auth::guard('fond')->check())
                                {{ $help->user->last_name }} {{ $help->user->first_name }} @else {{ gender($help->user->gender) }} @endif,
                                    @if($help->region_id != null)
                                        {{ $help->region->title_ru }}
                                    @endif
                                    @if($help->district_id != null)
                                        , {{ $help->district->title_ru }}
                                    @endif
                                    @if($help->city_id != null),
                                        {{ $help->city->title_ru }}
                                    @endif
                            </p>
                        <div class="text">
                            {{ $help->body }}
                        </div>
                    </div>
                    <p class="share"><span>Поделиться</span><a href=""><img src="/img/share2.svg" alt=""></a></p>
                </div>
                <div class="col-sm-5">
                    @if(Auth::check())
                        @if($help->user_id == Auth::user()->id)
                            @if($help->admin_status == 'edit')
                                <div class="alert alert-info">
                                    Ваша заявка не прошла модерацию! Статус - на доработке
                                </div>
                            @endif
                            <div class="helpEditBlock">
                                <a href="{{ route('cabinet_edit_page',$help->id) }}" class="btn btn-info mb-4">Редактировать заявку</a>
                            </div>
                        @endif
                    @endif
                    <div class="infoBlock">
                        <p><span>Регион:</span>{{ $help->region->title_ru }}</p>
                        @foreach($help->destinations as $destination)<p><span>{{config('destinations')[$destination->parent_id]}}</span> {{$destination->name_ru}}</p>@endforeach
                        <p><span>Статус заявки:</span>
                            @if($help->admin_status != 'finished')
                                @switch($help->admin_status)
                                    @case('edit')
                                    на доработке
                                    @break
                                    @case('moderate')
                                    на модерации у администратора
                                    @break
                                    @case('cancel')
                                    Заявка отменена администратором
                                    @break
                                @endswitch
                            @else
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
                            @endif
                        </p>
                        <p><span>Сфера необходимой помощи:</span>@foreach($help->addHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>
                        <p><span>Тип помощи:</span>@foreach($help->cashHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>
                        <p><span>Сумма необходимой помощи:</span>{{ $help->cashHelpSize->name_ru }}</p>
                        <p><span>Ссылка на видео:</span>{{ $help->cashHelpSize->name_ru }}</p>
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
                        @if(Auth::check() or Auth::guard('fond')->check())
                        <p><span>Документы по запрашиваемой помощи: </span>@foreach($help->docs as $doc)<a href="{{$doc->path}}">{{$doc->original_name}}</a>@endforeach</p>
                            @endif
                    </div>
                </div>
            </div>
            @if(Auth::check())
                @if(Auth::user()->id == $help->user_id)
            <div class="row mt-3">
                <div class="col-12">
                    <?php $comments = $help->comments; ?>
                    @if($comments)
                        @foreach($comments as $comment)
                            @if($comment->admin_id)
                                <div class="card mb-3" style="border: 1px solid #cfcfff;">
                                    <div class="card-header" style="background: #f9f9ff;">Администратор</div>
                                    <div class="card-body">
                                        <p>{{$comment->desc}}</p>
                                    </div>
                                </div>
                            @endif
                            @if($comment->fond_id)
                                <div class="card mb-3" style="border: 1px solid #cfcfff;">
                                    <div class="card-header" style="background: #f9f9ff;">Фонд: {{$comment->fond->title_ru}}</div>
                                    <div class="card-body">
                                        <p>{{$comment->desc}}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
    <script src="/js/lightbox.js"></script>
    <link rel="stylesheet" href="/css/lightbox.css">
@endsection
