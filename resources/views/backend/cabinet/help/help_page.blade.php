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
                        <p class="name"> @if(Auth::guard('fond')->check())
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
                            {{ hideText($help->body) }}
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
                                @if($help->admin_status == 'edit' || $help->admin_status == 'moderate' || $help->admin_status == 'wait' || $help->fond_status == 'edit' || $help->fond_status == 'moderate' || $help->fond_status == 'wait')
                                    @if($help->admin_status != 'cancel' && $help->fond_status != 'cancel')
                                        <a href="{{ route('cabinet_edit_page',$help->id) }}" class="btn btn-info mb-4">Редактировать заявку</a>
                                    @endif
                                @endif
                                @if($help->admin_status == 'cancel' || $help->fond_status == 'cancel')
                                        <div class="alert alert-danger">
                                            Ваша заявка отклонена!
                                        </div>
                                @endif
                            </div>
                        @endif
                    @endif
                        @if($help->reviews)
                            <button data-target="#review{{$help->reviews->id}}" data-toggle="modal" class="btn-default blue mb-3">Читать отзыв</button>
                            <div id="review{{$help->reviews->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" style="position:absolute; right: 30px;">&times;</button>
                                            <h5 class="modal-title text-center d-table m-auto">{{trans('cabinet-appl.review')}}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p> {{$help->reviews->body}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    <div class="infoBlock">
                        @if($help->phone)<p><span>Телефон:</span>{{ $help->phone }}</p>@endif
                        @if($help->email)<p><span>E-mail:</span>{{ $help->email }}</p>@endif
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
{{--                        <p class="d-none"><span>Тип помощи:</span>@foreach($help->cashHelpTypes as $helps){{$helps->name_ru}}@endforeach</p>--}}
{{--                        <p class="d-none"><span>Сумма необходимой помощи:</span>{{ $help->cashHelpSize->name_ru }}</p>--}}
                        <p><span>Ссылка на видео:</span>--</p>
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
                        @if(Auth::check() and Auth::guard('fond')->check())
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
                                @if($comment->desc)
                                    <div class="card mb-3" style="border: 1px solid #cfcfff;">
                                        <div class="card-header" style="background: #f9f9ff;">Администратор</div>
                                        <div class="card-body">
                                            <p>
                                                @if($comment->cause_value)
                                                    {{trans('home.'.$comment->cause_value)}},
                                                @endif
                                                {{$comment->desc}}</p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if($comment->fond_id)
                                    @if($comment->desc)
                                            <div class="card mb-3" style="border: 1px solid #cfcfff;">
                                                <div class="card-header" style="background: #f9f9ff;">Фонд: {{$comment->fond->title_ru}}</div>
                                                <div class="card-body">
                                                    <p>
                                                        @if($comment->cause_value)
                                                            {{trans('home.'.$comment->cause_value)}},
                                                        @endif
                                                        {{$comment->desc}}</p>
                                                </div>
                                            </div>
                                    @endif
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            @endif
            @endif
            @if($finish_help)
                <style>
                    .finish_help.greyContent h4{
                        font-size: 15px;
                        margin-bottom: 5px;
                    }
                </style>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="greyContent finish_help">
                            @if($finish_help->fond)
                                <h2>{{$finish_help->fond->title_ru ?? ''}}</h2>
                            @endif

                            <h4>
                                дату получения помощи:
                            </h4>
                            <p>{{date('d-m-Y', strtotime($finish_help->help_date))}}</p>
                            <h4>Информация по благотворителям (виды оказанной помоши):</h4>
                            <p>
                                @foreach($finish_help->cashHelpTypes as $cashHelpType)
                                    {{$cashHelpType->name_ru}} @if(!$loop->last), @endif
                                @endforeach
                            </p>
                            <h4>Сумма оказанной благотворительной помощи:</h4>
                            <p>{{$finish_help->amount}}</p>
                            @if(count($finish_help->helpHelpers)>0)
                            <h4>Информация о благотворителях:</h4>
                                <p>
                                    @foreach($finish_help->helpHelpers as $help_helpers)
                                        {{$help_helpers->type == 'fiz' ? 'Физ. лицо': 'Юр.лицо'}},
                                        @if($help_helpers->anonim==0)
                                            @if($help_helpers->fio)
                                               ФИО: {{$help_helpers->fio}},
                                            @endif
                                                @if($help_helpers->iin)
                                                   ИИН: {{$help_helpers->iin}},
                                                @endif
                                                @if($help_helpers->bin)
                                                   БИН: {{$help_helpers->bin}},
                                                @endif
                                            @if($help_helpers->title)
                                            {{$help_helpers->title}},
                                            @endif
                                                сумма оказанной благотворительной помощи:  {{$help_helpers->total}}

                                            @if($help_helpers->cashHelpTypes)
                                                <h5>Помощь которую оказал благотворитель</h5>
                                                @foreach($help_helpers->cashHelpTypes as $help_cash_help)
                                                    {{$help_cash_help->name_ru}} @if(!$loop->last), @endif
                                                @endforeach
                                            @endif
                                        @else
                                            Анонимный благотворитель
                                        @endif
                                        <hr>
                                    @endforeach
                                </p>
                            @endif
                            <h4>Фото процесса оказания помощи:</h4>
                            @if($finish_help->helpImages)
                                <div class="col-12">
                                    <div class="row d-flex">
                                        @foreach($finish_help->helpImages as $image)
                                            <div class="col-3">
                                                <a href="{{$image->photo}}">
                                                    <img src="{{$image->photo}}" class="img-fluid w-100" style="height: 200px;object-fit: cover;" alt="">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src="/js/lightbox.js"></script>
    <link rel="stylesheet" href="/css/lightbox.css">
@endsection
