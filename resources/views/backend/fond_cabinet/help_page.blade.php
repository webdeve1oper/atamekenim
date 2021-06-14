@extends('backend.fond_cabinet.layout')
@section('content')
    <div class="container-fluid default breadCrumbs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('fond_cabinet') }}">Кабинет</a></li>
                        <li><a>Заявка id:{{ getHelpId($help->id) }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 pt-3">
                @include('frontend.alerts')
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
                        <p class="name">{{ $help->user->last_name }} {{ $help->user->first_name }}, @if($help->region_id != null){{ $help->region->title_ru }}@endif @if($help->district_id != null)
                                , {{ $help->district->title_ru }}@endif @if($help->city_id != null), {{ $help->city->title_ru }}@endif </p>
                        <div class="text">
                            {{ $help->body }}
                        </div>
                    </div>
                    <p class="share"><span>Поделиться</span><a href=""><img src="/img/share2.svg" alt=""></a></p>
                </div>
                <div class="col-sm-5">
                    @if($help->fond_status == 'process')
                        <div class="row pb-4">
                            <div class="col-auto pr-0">
                                <button class="btn-default blue"  data-target="#finish" data-toggle="modal">{{trans('fond-cab.well-done')}}</button>
                            </div>
                            <div class="col">
                                <button class="btn-default" data-target="#cause" data-toggle="modal">Отклонить</button>
                            </div>
                        </div>
                    @endif

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
                                @case('cancel')
                                отклонен
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
                        <p><span>Место оказания помощи:</span>@if($help->region_id != null){{ $help->region->title_ru }}@endif @if($help->district_id != null)
                                , {{ $help->district->title_ru }}@endif @if($help->city_id != null), {{ $help->city->title_ru }}@endif</p>
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
    @if($help->fond_status == 'process')
        <div id="cause" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" style="position:absolute; right: 30px;">&times;</button>
                        <h6 class=" text-center d-table m-auto">Просим Вас указать причину отклонения заявки в комментарии.</h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('cancel_help', $help->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="help_id" value="{{$help->id}}">
                            <textarea name="desc" class="form-control mb-3" id="" cols="30" placeholder="" rows="10"></textarea>
                            <input type="submit" class="btn btn-default" value="отклонить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="finish" class="modal fade" role="dialog">
            <div class="modal-dialog" style="max-width: 800px; width: initial">
                <!-- Modal content-->
                <div class="modal-content w-100">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" style="position:absolute; right: 30px;">&times;</button>
                        <h6 class=" text-center d-table m-auto">Просим Вас заполнить данные об оказанной помощи для того, чтобы ни одно доброе дело не осталось незамеченным.</h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('finish_help', $help->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="help_id" value="{{$help->id}}">
                            <div class="form-group mb-3">
                                <label for="">Укажите дату получения помощи заявителем <span style="color: red">*</span></label>
                                <input type="date" name="help_date" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Заявка была реализована в рамках Проекта <span style="color: red">*</span></label>
                                <?php $projects = Auth::user()->projects; ?>
                                <select name="project" id="" class="form-control">
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">
                                    Укажите тип помощи, оказанный заявителю Вашей благотворительной организацией без участия благотворителей.
                                    Информация по благотворителям указывается ниже (выбрать из списка) <span style="color: red">*</span>
                                </label>
                                <select name="cashHelpType[]" class="select2 w-100" multiple placeholder="{{trans('fonds.type-rendered-help')}}" id="cashHelpTypes">
                                    @foreach($cashHelpTypes as $destination)
                                        <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                    @endforeach
                                </select>
                                <script>
                                    $('#cashHelpTypes').select2({
                                        width: '100%',
                                        placeholder: 'Виды оказываемой помощи'
                                    });
                                </script>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Укажите сумму оказанной благотворительной помощи <span style="color: red">*</span></label>
                                <input type="text" name="amount" class="form-control" placeholder="тенге (KZT)">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Внесите информацию о благотворителях при необходимости <span style="color: red">*</span></label><br>
                                <div class="helper">
                                    <div class="form-group mb-3">
                                        <label for="">Благотворитель</label>
                                        <select name="type[]" onchange="faceType($(this).val(), $(this))" class="form-control">
                                            <option value="fiz">Физическое лицо (отдельный человек)</option>
                                            <option value="yur">Юридическое лицо (компания или организация)</option>
                                        </select>
                                        <input type="text" name="fio[]" class="form-control mt-2 fio" placeholder="Напишите ФИО благотворителя">
                                        <input type="text" name="iin[]" class="form-control mt-2 iin" placeholder="Укажите ИИН благотворителя">
                                        <input type="text" name="bin[]" class="form-control bin mt-2" style="display: none;" placeholder="Внесите БИН юридического лица">
                                        <input type="text" name="title[]" class="form-control title mt-2" style="display: none;" placeholder="Напишите название юридического лица">
                                        <input type="text" name="total[]" class="form-control total mt-2" placeholder="Укажите сумму оказанной благотворительной помощи ">
                                        <input type="hidden" name="anonim[]" value="">
                                        <input type="checkbox" class="mt-2" onclick="$(this).prev().val($(this).prop('checked'))"> <label onclick="$(this).prev().prop('checked', !$(this).prev().prop('checked'));$(this).prev().prev().val($(this).prev().prop('checked'))"> Хочет остаться анонимом</label>
                                        <br><label for="">
                                            Какую помощь оказал благотворитель
                                        </label>
                                        <select name="cashHelpTypes[]" class="select2 cashHelpTypes2 w-100" multiple placeholder="{{trans('fonds.type-rendered-help')}}" id="cashHelpType">
                                            @foreach($cashHelpTypes as $destination)
                                                <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <script>
                                    $('#cashHelpType').select2({
                                        width: '100%',
                                        placeholder: 'Виды оказываемой помощи'
                                    });
                                </script>
                                <p class="btn btn-default"  onclick="
                                if($('.helper').length <5){
                                   var count = $('.helper').length;
                                    $(helper).insertBefore(this).find('.cashHelpTypes2').attr('id', 'cashHelpTypes'+count).attr('name', 'cashHelpTypes['+count+'][]');
                                    $('#cashHelpTypes'+count).select2({ width: '100%', placeholder: 'Виды оказываемой помощи'});
                                }">
                                    Добавить
                                </p>
                            </div>
                            <script>
                                var select = '<label for="">Какую помощь оказал благотворитель</label><select name="cashHelpTypes[]" class="select2 cashHelpTypes2 w-100" multiple id="cashHelpTypes">@foreach($cashHelpTypes as $destination)<option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>@endforeach</select>';
                                var helper = '<div class="helper"><div class="form-group mb-3"><label for="">Благотворитель</label><select name="type[]" onclick="faceType($(this).val(), $(this))" class="form-control"><option value="fiz">Физическое лицо (отдельный человек)</option><option value="yur">Юридическое лицо (компания или организация)</option></select>\n' +
                                    '<input type="text" name="fio[]" class="form-control fio mt-2" placeholder="Напишите ФИО благотворителя">' +
                                    '<input type="text" name="iin[]" class="form-control iin mt-2" placeholder="Укажите ИИН благотворителя">' +
                                    '<input type="text" name="title[]" class="form-control title mt-2" style="display: none;" placeholder="Напишите название юридического лица">' +
                                    '<input type="text" name="bin[]" class="form-control bin mt-2" style="display: none;" placeholder="Внесите БИН юридического лица">' +
                                    '<input type="text" name="total[]" class="form-control total mt-2" placeholder="Укажите сумму оказанной благотворительной помощи ">' +
                                    '<input type="hidden" name="anonim[]" value="">' +
                                    '<input type="checkbox" name="anonim" class="mt-2" onclick="$(this).prev().val($(this).prop(\'checked\'))"><label onclick="$(this).prev().prop(\'checked\', !$(this).prev().prop(\'checked\'));$(this).prev().prev().val($(this).prev().prop(\'checked\'))"> Хочет остаться анонимом</label><br>' + select +'</div>' +
                                    '<span style="color:#0053a5" class="delete-helper" onclick="$(this).parent().remove()"><i class="far fa-window-close"></i></span>\n' +
                                    '</div>';
                            </script>
                            <div class="form-group mb-3">
                                <label for="">Загрузите фото процесса оказания помощи </label>
                                <div class="input-group">
                                    <input type="file" id="file" name="photo[]" class="form-control photo">
                                    <div class="input-group-append" style="display: none;">
                                        <button class="btn btn-default p-2" type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-default p-2 mt-2" onclick="if($('.photo').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();} return false;">+ Добавить еще</button>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Вставьте ссылку на видео процесса оказания помощи (youtube) </label>
                                <input type="text" name="link" class="form-control" placeholder="Ссылка">
                            </div>
                            <input type="submit" class="btn btn-default" value="{{trans('fond-cab.well-done')}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .helper{
                border: 1px solid #ededed;
                margin-bottom: 10px;
                padding: 15px;
                position: relative;
            }

            #finish .form-group{
                margin-bottom: 20px;
            }

            .delete-helper i{
                font-size: 20px;
            }

            .delete-helper{
                position: absolute;
                right: 15px;
                top: 10px;
            }

            .delete-helper:hover{
                cursor: pointer;
            }
        </style>
        <script>
            function faceType(val, that){
                if(val == 'yur'){
                    that.parents('.helper').find('.bin').show();
                    that.parents('.helper').find('.title').show();
                    that.parents('.helper').find('.iin').hide();
                    that.parents('.helper').find('.fio').hide();
                }else{
                    that.parents('.helper').find('.iin').show();
                    that.parents('.helper').find('.fio').show();
                    that.parents('.helper').find('.bin').hide();
                    that.parents('.helper').find('.title').hide();
                }
            }
        </script>
    @endif
@endsection
