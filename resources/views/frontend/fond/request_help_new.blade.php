@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.3.1/jquery.maskedinput.min.js" integrity="sha512-D30F0yegJduD5FxOxI3qM1Z0YrbtXE3YLoyNDYvps4Qq63Y0l/ObPmjlsj27pgFx8mLdMQ24I3gGtdYZO741HQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="fatherBlock">
        <div class="container-fluid default breadCrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href="/">{{trans('fonds.main')}}</a></li>
                            <li><a href="{{route('fonds')}}">{{trans('fonds.reestr')}}</a></li>
                            <li><a href="#">{{trans('fonds.req-help')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row"><div class="col-12">@include('frontend.alerts')</div></div>
        </div>
        <div class="container-fluid newRequestHelpPage">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        @if($help)
                            <h1 class="blueName">Редактирование заявки ID: {{ getHelpId($help->id) }}</h1>
                        @else
                            <h1>{{trans('auth.request_title')}}</h1>
                        @endif
                    </div>
                    <div class="col-sm-8">
                        <form action="{{route('request_help')}}" method="POST" id="request_help" enctype="multipart/form-data">
                            @csrf
                            @if($help)
                                <input type="hidden" name="help_id" value="{{$help->id}}">
                            @endif
                            <div class="miniFormBlock">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="headTitle">
                                            Контакты и адрес проживания
                                        </p>
                                    </div>
                                    <div class="col-sm-6 formGroup">
                                        <label class="required"><span>Номер телефона</span></label>
                                        <?php $phone = ''; if($help){$phone = $help->phone;}else{ $phone= old('phone');}?>
                                        <input type="text" class="" required value="{{$phone}}"  id="phone_number" name="phone" placeholder="+7 (000) 000-00-00" required>
                                    </div>
                                    <div class="col-sm-6 formGroup">
                                        <label><span>Укажите вашу электронную почту</span></label>
                                        <input type="text" class="" id="email" name="email"  value="@if($help) {{$help->email}} @else {{old('email')}}  @endif" placeholder="primer@mail.ru">
                                    </div>
                                    <div class="col-sm-6 formGroup">
                                        <label class="required"><span>Регион оказания помощи</span></label>
                                        <select name="region_id" class="select2 w-100" placeholder="Выберете область" id="regions" required>
                                             <option value="" disabled selected>Выбрать из списка</option>Выбрать из списка</option>
                                            @foreach($regions as $region)
                                                @if($region->region_id != 728)
                                                    <option value="{{$region->region_id}}">{{$region->text}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 districts" style="display: none">
                                        <div class="formGroup">
                                            <label><span>{{trans('fonds.disctrit')}}</span></label>
                                            <select name="district_id" class="select2 w-100" placeholder="Тип помощи" id="districts">
                                                <option value="0"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 cities" style="display: none">
                                        <div class="formGroup">
                                            <label><span>{{trans('fonds.city')}}</span></label>
                                            <select name="city_id" class="select2 w-100" placeholder="Тип помощи" id="cities">
                                                <option value="0"></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="miniFormBlock">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="headTitle">
                                            Кому нужна помощь
                                        </p>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label class="required"><span>Пожалуйста, укажите, кому необходима помощь</span>
                                            <i>Вы можете подавать заявку от своего имени или от имени своего несовершеннолетнего ребенка.</i>
                                        </label>
                                        <select name="who_need_help" id="who_need_help" class="" required>
                                             <option value="" disabled selected>Выбрать из списка</option>Выбрать из списка</option>
                                            <?php $show_array1 = [2,3] ?>
                                            @if($help)
                                                @foreach($scenarios as $value => $scenario)
                                                    @if(in_array($scenario['id'], $show_array1))
                                                        <option value="{{$scenario['id']}}" @if($help->whoNeedHelp->id== $scenario['id']) selected @endif>{{$scenario['name_'.app()->getLocale()] ?? $scenario['name_ru']}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach($scenarios as $value => $scenario)
                                                    @if(in_array($scenario['id'], $show_array1))
                                                        <option value="{{$scenario['id']}}">{{$scenario['name_'.app()->getLocale()] ?? $scenario['name_ru']}}</option>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Выберите один или несколько подходящих для Вас (или Вашего ребенка) статусов.</span>
                                        </label>
                                        <select name="destinations[]" class="select2 w-100" multiple id="destinations1" ></select>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Укажите, при необходимости, жизненную ситуацию, в которую Вы попали.</span>
                                        </label>
                                        <select name="destinations[]" class="select2 w-100" multiple id="destinations2"></select>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Если эта информация важна, укажите свое происхождение.</span>
                                        </label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.check-origin-help')}}" id="destinations3"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="miniFormBlock">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="headTitle">
                                            Помощь
                                        </p>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label class="required">
                                            <span>Сфера необходимой помощи</span>
                                        </label>
                                        <select name="baseHelpTypes" class="select2 w-100" placeholder="{{trans('fonds.scope-help')}}" id="baseHelpTypes" required>
                                            @foreach($baseHelpTypes as $destionation)
                                                <option value="{{$destionation->id}}">{{$destionation->name_ru}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Если помощь требуется в связи с состоянием здоровья, укажите, какими заболеваниями болеет заявитель.</span>
                                        </label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.check-stat-health')}}" id="destinations4"></select>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label class="required">
                                            <span>Укажите, в каком именно вопросе Вам требуется помощь.</span>
                                        </label>
                                        <textarea name="body" required placeholder="{{trans('fonds.desc-help')}}*" id="helpBody" required>@if($help){{$help->body}}@else{{old('body')}}@endif</textarea>
                                    </div>

                                    <div class="col-sm-12 formGroup d-none">
                                        <label class="required">
                                            <span>Укажите, какой тип помощи Вам необходим.</span>
                                            <i>Возможно, Вам нужна финансовая разовая помощь (например, оплатить операцию), или финансовая помощь, но на постоянной основе (например, если Вы мать-одиночка, и Вам нужно каждый месяц содержать детей). Возможно, Вам нужна помощь волонтеров (если Вы одинокий пожилой человек, которому требуется уход), или материальная помощь (например, закупить мебель в детский дом). Возможно, Вам требуется консультация (например, Вы не знаете, как оформить алименты в случае развода), или сопровождение (например, Вы проживаете в селе, но Вам нужно сделать операцию в городе, и у Вас нет возможности добраться до него самостоятельно). Возможно, Вам нужна помощь в логистике (например, привезти закупленные в городе лекарства в Ваше село), или Вам негде жить, и Вам необходимо временное жилье.</i>
                                        </label>
                                        <select name="cashHelpTypes[]" class="select2 w-100 " multiple placeholder="{{trans('fonds.type-rendered-help')}}" id="cashHelpTypes" >
                                            @foreach($cashHelpTypes as $destination)
                                                @if($destination['id'] != 3)
                                                    <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 formGroup d-none">
                                        <label class="required">
                                            <span>Укажите примерную сумму требуемой помощи.</span>
                                            <i>Понимая размер необходимой помощи, организации могут определить, обладают ли они нужными ресурсами, чтобы Вам помочь.</i>
                                        </label>
                                        <select name="cash_help_size_id" class="select2 w-100 " placeholder="{{trans('fonds.type-rendered-help')}}" id="cashHelpSizes" >
                                            @foreach($cashHelpSizes as $destination)
                                                <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label class="required">
                                            <span>Укажите, насколько срочным является Ваш случай.</span>
                                        </label>
                                        <select name="urgency_date" class="select2 w-100" placeholder="{{trans('fonds.indicate-urgency-help2')}}" id="helpUrgencyDate" required>
                                             <option value="" disabled selected>Выбрать из списка</option>Выбрать из списка</option>
                                            <option value="1">{{trans('fonds.flow-month-1')}}</option>
                                            <option value="2">{{trans('fonds.flow-month-3')}}</option>
                                            <option value="3">{{trans('fonds.flow-month-6')}}</option>
                                            <option value="4">{{trans('fonds.flow-year')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Видео (загрузите ссылку на видеообращение в социальных сетях или средствах массовой информации)</span>
                                        </label>
                                        <input type="text" name="video" value="@if($help) {{$help->video}} @endif" class="" placeholder="">
                                        {{--                                        <button>Добавить еще ссылку <img src="" alt=""></button>--}}
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Прикрепите фото заявителя или ситуации, в которую Вы попали. (max 2 Mb)</span>
                                            <i>Так организации смогут убедиться в том, что Вам действительно нужна помощь. <br>Например, Вы можете прикрепить фото сгоревшего дома или своих жилищных условий.</i>
                                        </label>
                                        @if($help)
                                            <ul class="justify-content-start d-flex list-unstyled">
                                                @foreach($help->images as $image)
                                                    <li class="mr-4" style="position: relative;" id="file-{{$image->id}}">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <img src="{{$image->image}}" class="img-fluid" style="max-width: 200px; height: 100px; object-fit: cover;" alt="">
                                                                <button class="deletefile" type="button" style="top: 5px;" onclick="deleteImage({{$image->id}});"><i style="color: #0053a5;" class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <br>
                                        <div class="input-group">
                                            <input type="file" id="file" name="photo[]" class=" photo">
                                            <div class="input-group-append" style="display: none;">
                                                <button type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                        <button onclick="if($('.photo').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();$(this).prev().find('input').val('');} return false;">Добавить файл <img src="{{asset('/img/plus.svg')}}" alt=""></button>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Если у Вас есть, прикрепите документы, подтверждающие действительность Вашей ситуации.</span>
                                            <i>
                                                Например, медицинские справки, выписки,  подтверждающие правдивость Ваших слов.
                                                <br>Укажите название документа и прикрепите файл в формате doc, jpeg или pdf. (max 2 Mb)
                                            </i>
                                        </label>
                                        @if($help)
                                            <ul class="justify-content-start d-flex list-unstyled">
                                                @foreach($help->docs as $doc)
                                                    <li class="pr-4"><div class="card p-2 pr-4"><a href="{{$doc->path}}">{{$doc->original_name}}</a><button class="deletefile" type="button" onclick="deleteFile({{$doc->id}});"><i class="fas fa-times" style="color: #0053a5"></i></button></div></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <br>
                                        <div class="input-group">
                                            <input type="file"  class=" docs" name="doc[]">
                                            <div class="input-group-append" style="display: none;">
                                                <button class="btn btn-default p-2" type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                        <button onclick="if($('.docs').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();$(this).prev().find('input').val('');} return false;">Добавить файл <img src="{{asset('/img/plus.svg')}}" alt=""></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="agreeBlock">
{{--                                        <input type="checkbox" name="agree" id="agreeButton" required>--}}
{{--                                        <p>Согласие на обработку ваших данных <a href="#">Политика конфиденциальности</a></p>--}}
                                        <button type="submit" id="request_help_button" style="margin-left: 0" onsubmit="$(this).attr('disabled',true)">Подать заявку</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                        @include('frontend.fond.script')
                    </div>
                    <div class="col-sm-4">
                        <div class="alert danger"><img src="/img/danger.svg" alt=""><span>Несиелерді өтеу және тұрғын үймен қамтамасыз ету бойынша өтінімдер қабылданбайтынын хабарлаймыз</span></div>
                        <div class="alert danger"><img src="/img/danger.svg" alt=""><span>Доводим до ващего сведения, что заявки по погашению кредитов и по обеспечению жильём не принимаются</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        label i {
            display: table;
            margin: 15px 0 0;
            color: #212529;
            font-size: 13px;
            text-decoration: underline;
        }
    </style>
    <style>
        .deletefile{
            position: absolute;
            right: 2px;
            padding: 3px;
            padding-top: 0px;
            background: none;
            border: none;
            box-shadow: none;
        }
    </style>
    <script>
        $('#request_help').submit(function(){
            $('#request_help_button').attr('disabled', true);
        });
        $(document).ready(function(){
            $("#phone_number").mask("+7(999) 999-99-99");
        });
        $('#agreeButton').change(function(){
            if($(this).is(":checked")){
                $('#request_help_button').attr('disabled', false);
            }else{
                $('#request_help_button').attr('disabled', true);
            }
        });
        function deleteImage(id){
            $.ajax({
                url: '{{route('delete_help_image')}}',
                method: 'GET',
                data: {'_token':'{{csrf_token()}}', 'id': id},
                success: function(){
                    $('#image-'+id).fadeOut('slow');
                    setTimeout(function(){
                        $('#image-'+id).remove();
                    }, 600);
                }
            })
        }
        function deleteFile(id){
            $.ajax({
                url: '{{route('delete_help_file')}}',
                method: 'GET',
                data: {'_token':'{{csrf_token()}}', 'id': id},
                success: function(){
                    $('#file-'+id).fadeOut('slow');
                    setTimeout(function(){
                        $('#file-'+id).remove();
                    }, 600);
                }
            })
        }
    </script>
@endsection

@extends('frontend.layout')
