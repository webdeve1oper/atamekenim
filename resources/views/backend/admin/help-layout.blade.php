@extends('backend.admin.layout')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-5 mt-2 mb-2">
            <h1>Обращение: ID{{ getHelpId($help->id) }}</h1>
        </div>
        <div class="col-sm-7">
            @if(is_operator() && $help->admin_status == 'moderate' or is_admin() && $help->admin_status == 'moderate')
                <ul class="controlButton">
{{--                    <li>--}}
{{--                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1">Одобрить и отправить фондам</button>--}}
{{--                    </li>--}}
                    <li>
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal3">Отклонить</button>
                    </li>
                    <li>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2">Требует правок</button>
                    </li>
                    <li>
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal4">Отправить модератору КХ</button>
                    </li>
                </ul>
            @elseif(is_moderator() && $help->admin_status == 'finished' && $help->status_kh == \App\Help::STATUS_KH_POSSIBLY)
                <ul class="controlButton">
{{--                    <li>--}}
{{--                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1">Одобрить и отправить фондам</button>--}}
{{--                    </li>--}}
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
            <p><span>Пол:</span> {{ gender($help->user->gender) }}</p>
            <p><span>Возраст:</span> {{  \Carbon\Carbon::parse($help->user->born)->age }}</p>
            <p><span>Дата рождения:</span> {{  \Carbon\Carbon::parse($help->user->born)->format('d-m-Y') }}</p>
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
                use Carbon\Carbon;switch ($help->urgency_date) {
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
                <div class="form-group mb-4 baseHelpTypes  mt-sm-5">
                    <label for="baseHelpTypes">{{trans('fonds.check-scope-help')}}</label>
<!--                    --><?php //$help_add_helps = $help->addHelpTypes->pluck('id')->toArray(); ?>
                    <select name="baseHelpTypes[]" class="select2 w-100" placeholder="{{trans('fonds.scope-help')}}" id="baseHelpTypes">
                        <option value="" selected disabled></option>
                        @foreach($baseHelpTypes as $id=> $baseHelpType)
{{--                            @if(in_array($id, $help_add_helps))--}}
{{--                                <option value="{{$id}}" selected>{{$baseHelpType}}</option>--}}
{{--                            @else--}}
{{--                                <option value="{{$id}}">{{$baseHelpType}}</option>--}}
{{--                            @endif--}}
                                <option value="{{$id}}">{{$baseHelpType}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">{{trans('fonds.scope-help')}}</small>
                </div>
                <div class="row">
                    <div class="col-sm-4 regions">
                        <div class="form-group mb-4">
                            {{--<label for="regions">{{trans('fonds.indicate-place-help')}}</label>--}}
                            <label for="regions">
                                Укажите, где Вы сейчас проживаете.
                            </label>
                            <select name="region_id" class="select2 w-100" placeholder="{{trans('fonds.type-help')}}" id="regions">
                                <option value="" selected disabled>Выбрать из списка</option>
                                @foreach($regions as $region)
                                    @if($region->region_id != 728)
                                        <option value="{{$region->region_id}}">{{$region->text}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small>{{trans('fonds.name-settlement')}}</small>
                        </div>
                    </div>

                    <div class="col-sm-4 districts" style="display: none">
                        <div class="form-group mb-4">
                            <label for="">{{trans('fonds.disctrit')}}</label>
                            <select name="district_id" class="select2 w-100" placeholder="Тип помощи" id="districts">
                                <option value="0"></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 cities" style="display: none">
                        <div class="form-group mb-4">
                            <label for="">{{trans('fonds.city')}}</label>
                            <select name="city_id" class="select2 w-100" placeholder="Тип помощи" id="cities">
                                <option value="0"></option>
                            </select>
                        </div>
                    </div>
                </div>
                <textarea name="help_body" id="helpBody" style="width: 100%;height: 400px" placeholder="Введите описание">
                    {{ $help->body }}
                </textarea>
                <button class="btn btn-primary" type="submit" style="margin-top: 15px">Сохранить изменения</button>
            </form>
            <br>
            <br>



            <p><span>Фотографии получателя помощи:</span> @if($images)
                <ul class="justify-content-start d-flex list-unstyled">
                    @foreach($images as $image)
                        <li class="mr-4" style="position: relative;">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{$image->image}}" target="_blank">
                                        <img src="{{$image->image}}" class="img-fluid" style="max-width: 200px; height: 100px; object-fit: cover;" alt="">
                                    </a>
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
{{--            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                <div class="modal-dialog">--}}
{{--                    <div class="modal-content">--}}
{{--                        <div class="modal-header">--}}
{{--                            <h5 class="modal-title" id="exampleModalLabel">Одобрить запрос {{ $help->id }}</h5>--}}
{{--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                        </div>--}}
{{--                        <div class="modal-body">--}}
{{--                            <form action="{{ route('edit_help_status') }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <input type="text" name="help_id" class="d-none" value="{{ $help->id }}">--}}
{{--                                <div class="form-check my-3 border-bottom pb-3">--}}
{{--                                    <input class="form-check-input d-none" type="radio" name="status_name" id="flexRadioDefault1" value="finished" checked="checked">--}}
{{--                                    <label class="form-check-label" for="flexRadioDefault1">--}}
{{--                                        Направляется всем фондам, кроме фонда “Қазақстан Халқына”--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Одобрить и отправить фондам</button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
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
                                            <option value="1">Доработка контактные данные</option>
                                            <option value="2">Доработка документы</option>
                                            <option value="3">Доработка описание</option>
                                            <option value="4">Доработка сферы</option>
                                            <option value="6">Доработка по описанию болезни ребенка и доп.документы</option>
                                            <option value="5">Иное</option>
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
                                            <option value="1">Дубликат заявки</option>
                                            <option value="3">Лечение зарубежом (онкология)</option>
                                            <option value="4">Лечение, протезирование зубов, ЭКО</option>
                                            <option value="5">Лечение других заболеваний зарубежом</option>
                                            <option value="2">Иное</option>
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
       <div class="history d-none">
           <hr>
           <h5>История оператора</h5>
           <div class="col-12 p-4" style="background-color: #ededed">
               <?php
               $comments = [];
               $histories = $help->adminHistory()->orderBy('created_at', 'desc')->get();
               foreach ($histories as $history) {
                   $exist = false;
                   if(isset($comments[$history->status])){
                       foreach ($comments[$history->status] as $comment) {
                           if($exist){
                               break;
                           }
                           $comm =  Carbon::createFromTimeString($comment->created_at);
                           $comm2 = Carbon::createFromTimeString($history->created_at);

                           if($comm->format('dmy') == $comm2->format('dmy')){
                               if($comm2->diff($comm)->i<=5){
                                   $exist = true;
                               }
                           }
                       }
                   }
                   if (!$exist){
                       $comments[$history->status][] = $history;
                   }
               }
               ?>
               @if(count($comments)>0)
                   @foreach($comments as $comment_types)
                       @if(count($comment_types)>0)
                           @foreach($comment_types as $key=> $comment)
                               @if($comment->admin_id)
                                   <div class="card mb-3" style="border: 1px solid #cfcfff;">
                                       <div class="card-header" style="background: #f9f9ff;">
                                           {{$comment->id}}
                                           <b>
                                               {{$comment->admin->email}} &nbsp;
                                               <span>{{\Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i:s')}}</span>
                                               <span style="display: none">{{getTranslate($comment->status)}}</span>
                                           </b>
                                       </div>
                                       <div class="card-body">
                                           <p>
                                               @if($comment->status == 'edited_by_admin')
                                                   {{trans('home.'.$comment->status)}}
                                               @elseif($comment->cause_value)
                                                   {{trans('home.'.$comment->cause_value)}}
                                               @endif
                                               <br>
                                               <b>Описание:</b>
                                               <br>
                                               {{$comment->desc}}
                                           </p>
                                       </div>
                                   </div>
                               @endif
                           @endforeach
                       @endif
                   @endforeach
               @endif
           </div>
       </div>
    </div>
    <?php
    function getTranslate($status){
        $translate = '';
        switch ($status){
            case 'edit':
                $translate = 'отправлено на доработку';
                break;
            case 'finished':
                $translate = 'Заявка одобрена для фондов';
                break;
            case 'cancel':
                $translate = ' Заявка отклонена';
                break;
            case 'kh':
                $translate = ' Заявка отправлена модератору КХ';
                break;
            case 'kh_approved':
                $translate = ' Заявка одобрена с поддержкой КХ';
                break;
        }
        return $translate;
    }
    ?>

    <script>
        var json = {!! $regions->toJson() !!};
        var region = null;
        var city = null;
        var district = null;
        region = {{$help->region->region_id}};
        city = {!! $help->city->city_id??'""' !!};
        district = {!! $help->district->district_id??'""' !!};
        $(document).ready(function(){
            $('#baseHelpTypes').select2({
                width: '100%',
                placeholder: 'Сфера необходимой помощи',
                minimumResultsForSearch: -1
            });

            $('#regions').change(function () {
                var ind = $('#regions').children('option:selected').val();
                var datas = [];
                json.forEach(function (value, index) {
                    if (value.region_id == ind) {
                        ind = index;
                    }
                });

                $('#districts').empty();
                datas.push({id: '0', text: ''});
                for (let [key, value] of Object.entries(json[ind].districts)) {
                    datas.push({id: value.district_id, text: value.text});
                }


                if(datas.length > 1){
                    $('.districts').show();
                    $('#cities').empty();
                    $('#districts').select2({data: datas, allowClear: true});
                }else{
                    $('.districts').hide();
                    $('#districts').select2({data: [{id: '0', text: ''}], allowClear: true});
                    $('.districts option').first().prop('selected', true);
                    $('.cities').hide();
                    $('.cities option').first().prop('selected', true);
                }
            });

            $('#districts').change(function () {
                var region_id = $('#regions').children('option:selected').val();
                var district_id = $('#districts').children('option:selected').val();
                var datas = [];

                json.forEach(function (value, index) {
                    if (value.region_id == region_id) {
                        region_id = index;
                        value.districts.forEach(function (v, i) {
                            if (v.district_id == district_id) {
                                district_id = i;
                            }
                        });
                    }
                });

                $('#cities').empty();
                datas.push({id: 0, text: '-'});
                for (let [key, value] of Object.entries(json[region_id].districts[district_id].cities)) {
                    datas.push({id: value.city_id, text: value.title_ru});
                }
                if(datas.length > 1){
                    $('.cities').show();
                    $('#cities').select2({data: datas, allowClear: true});
                }else{
                    $('.cities').hide();
                    $('#districts').select2({data: [{id: '0', text: ''}], allowClear: true});
                }

            });
            // if(region){
            //     $("select#regions option[value='"+region+"']").prop('selected', true);
            //     $("select#regions option[value='"+region+"']").change();
            // }
            // if(district){
            //     // Выбор района
            //     $("select#districts option[value='"+district+"']").prop('selected', true);
            //     $("select#districts option[value='"+district+"']").change();
            // }
            // if(city){
            //     // Выбор города
            //     $("select#cities option[value='"+city+"']").prop('selected', true);
            //     $("select#cities option[value='"+city+"']").change();
            // }

        });
        $('#exampleModal2 #floatingSelect').change(function (){
            var new_value = $('#exampleModal2 #floatingSelect option:selected').val();
            if(new_value == '5'){
                $('#exampleModal2 #floatingTextarea').attr('required',true);
            }else{
                $('#exampleModal2 #floatingTextarea').attr('required',false);
            }
        });
    </script>
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
