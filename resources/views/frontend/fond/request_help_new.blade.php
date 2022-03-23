@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous"/>
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
                                            @foreach($regions as $region)
                                                @if($region->region_id != 728)
                                                    <option value="{{$region->region_id}}">{{$region->text}}</option>
                                                @endif
                                            @endforeach
                                        </select>
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
                                        <select name="who_need_help" id="who_need_help" class="">
                                            @if($help)
                                                @foreach($scenarios as $value => $scenario)
                                                    @if($scenario['id'] != 6)
                                                        <option value="{{$scenario['id']}}" @if($help->whoNeedHelp->id== $scenario['id']) selected @endif>{{$scenario['name_'.app()->getLocale()] ?? $scenario['name_ru']}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach($scenarios as $value => $scenario)
                                                    @if($scenario['id'] != 6)
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
                                        <label><span>Укажите, в каком именно вопросе Вам требуется помощь.</span>
                                            <i>Сфера необходимой помощи</i>
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
                                        <label>
                                            <span>Укажите, в каком именно вопросе Вам требуется помощь.</span>
                                        </label>
                                        <textarea name="body" placeholder="{{trans('fonds.desc-help')}}*" id="helpBody" required>@if($help) {{$help->body}} @else {{old('body')}} @endif</textarea>
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Укажите, насколько срочным является Ваш случай.</span>
                                        </label>
                                        <select name="urgency_date" class="select2 w-100" placeholder="{{trans('fonds.indicate-urgency-help2')}}" id="helpUrgencyDate" required>
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
                                        <input type="text" name="video" value="@if($help) {{$help->video}} @endif" class="" placeholder="Выберете один или несколько социальных статусов">
                                        {{--                                        <button>Добавить еще ссылку <img src="" alt=""></button>--}}
                                    </div>
                                    <div class="col-sm-12 formGroup">
                                        <label>
                                            <span>Прикрепите фото/видео заявителя или ситуации, в которую Вы попали.</span>
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
                                                Например, медицинские справки, выписки,  подтверждающие правдивость Ваших слов. <br>Укажите название документа и прикрепите файл в формате doc, jpeg или pdf.  Максимальный вес файла “Сколько то мегабайт”
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
                                        <input type="checkbox" name="agree" id="agreeButton" required>
                                        <p>Согласие на обработку ваших данных <a href="#">Политика конфиденциальности</a></p>
                                        <button type="submit" id="request_help_button" disabled="disabled">Подать заявку</button>
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
