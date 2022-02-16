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
        <div class="container-fluid default organInfoBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        @if($help)
                            <h1 class="blueName">Редактирование заявки ID: {{ getHelpId($help->id) }}</h1>
                        @else
                            <h1>{{trans('fonds.req-help')}}</h1>
                        @endif
                        <h2>Доводим до сведения, что заявки по погашения кредитов и по обеспечению жилью не принимаются
                            <br>
                            Кредиттерді өтеу және тұрғын үйді қамтамасыз ету бойынша өтінімдер қабылданбайтынын хабарлаймыз
                        </h2>
                        <style>
                            h2 {
                                font-size: 16px;
                                margin: 0 0 25px;
                                text-decoration: underline;
                                color: #e91e63;
                            }
                        </style>
                        <p>
                            Здравствуйте! Чтобы благотворительные организации получили максимально полную информацию о Вашем случае, заполните форму ниже. Разные организации оказывают помощь разным категориям населения. Чем более точно Вы укажете свои данные, тем выше будет вероятность того, что Ваш случай будет направлен верной организации, тем легче организациям будет принять решение о том, брать ли Ваш случай в работу, и тем вероятнее они это сделают.
                        </p>
                        <form action="{{route('request_help')}}" method="POST" id="request_help" enctype="multipart/form-data">
                            @csrf
                            @if($errors->has('title'))
                                <span class="error">{{ $errors->first('title') }}</span>
                            @endif

                            @if($help)
                                <input type="hidden" name="help_id" value="{{$help->id}}">
                            @endif
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="phone_number">Укажите ваш номер телефона</label>
                                            <?php $phone = ''; if($help){$phone = $help->phone;}else{ $phone= old('phone');}?>
                                            <input type="text" class="form-control" required value="{{$phone}}"  id="phone_number" name="phone" placeholder="Укажите ваш номер телефона">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email">Укажите вашу электронную почту</label>
                                            <input type="text" class="form-control" id="email" name="email"  value="@if($help) {{$help->email}} @else {{old('email')}}  @endif" placeholder="Укажите вашу электронную почту">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-4">
                                    <div class="form-group mb-4">
                                        {{--<label for="who_need_help">{{trans('fonds.who-helps')}}</label>--}}
                                        <label for="destinations1">Пожалуйста, укажите, кому необходима помощь.<br>
                                            <i>
                                                Вы можете подавать заявку от своего имени или от имени своего несовершеннолетнего ребенка. Все остальные заявители должны будут подавать заявки от своего имени через свой аккаунт.
                                            </i>
                                        </label>
                                        <select name="who_need_help" id="who_need_help" class="form-control">
                                            @if($help)
                                                @foreach($scenarios as $value => $scenario)
                                                    <option value="{{$scenario['id']}}" @if($help->whoNeedHelp->id== $scenario['id']) selected @endif>{{$scenario['name_'.app()->getLocale()] ?? $scenario['name_ru']}}</option>
                                                @endforeach
                                            @else
                                                @foreach($scenarios as $value => $scenario)
                                                    <option value="{{$scenario['id']}}">{{$scenario['name_'.app()->getLocale()] ?? $scenario['name_ru']}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <!--destination 1-->
                                <div class="col-sm-12 destinations1">
                                    <div class="form-group mb-4 ">
                                        {{--<label for="destinations1">{{trans('fonds.chois-stat-help')}}</label>--}}
                                        <label for="destinations1">Выберите один или несколько подходящих для Вас (или Вашего ребенка) статусов.<br>
                                            <i>
                                                Ваш социальный статус поможет организациям определить, работают ли они с указанной категорией населения. Например, только с детьми, или только с многодетными матерями.
                                            </i>
                                        </label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.chois-stat-help2')}}" id="destinations1" ></select>

                                    </div>
                                </div>

                                <!--destination 2-->
                                <div class="col-sm-12 destinations2">
                                    <div class="form-group mb-4">
                                        {{--<label for="destinations2">{{trans('fonds.check-tjs-helps')}}</label>--}}
                                        <label for="destinations2">
                                            Укажите, при необходимости, жизненную ситуацию, в которую Вы попали.
                                            <i>Для некоторых организаций при выборе того, кому они оказывают помощь, важен не Ваш социальный статус, а ситуация, в которой Вы оказались. Например, есть организации, которые помогают только жертвам бытового насилия или пострадавшим от стихийных бедствий.</i>
                                        </label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.check-tjs-helps')}}" id="destinations2"></select>
                                    </div>
                                </div>

                                <!--destination 3-->
                                <div class="col-sm-12 destinations3">
                                    <div class="form-group mb-4">
                                        {{--<label for="destinations3">{{trans('fonds.check-origin-help')}}</label>--}}
                                        <label for="destinations3">
                                            Если эта информация важна, укажите свое происхождение.
                                            <i>
                                                Часть организаций оказывают помощь только людям с определенным происхождением.  Например, кандасам или выходцам из сел.
                                            </i>
                                        </label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.check-origin-help')}}" id="destinations3"></select>
                                    </div>
                                </div>

                                <!--destination 4-->
                                <div class="col-sm-12 destinations4">
                                    <div class="form-group mb-4">
                                        {{--<label for="destinations4">{{trans('fonds.check-stat-health')}}</label>--}}
                                        <label for="destinations4">
                                            Если помощь требуется в связи с состоянием здоровья, укажите, какими заболеваниями болеет заявитель.
                                            <i>
                                                Некоторые организации оказывают помощь только людям, имеющим определенное заболевание. Например, только инвалидам или болеющим туберкулезом.
                                            </i>
                                        </label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.check-stat-health')}}" id="destinations4"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 regions">
                                    <div class="form-group mb-4">
                                        {{--<label for="regions">{{trans('fonds.indicate-place-help')}}</label>--}}
                                        <label for="regions">
                                            Укажите, где Вы сейчас проживаете.
                                            <i>
                                                Большинство организаций работают в определенном регионе. После того, как Вы укажете свое место жительства, Вашу заявку получат только те организации, которые работают в Вашем регионе или по всей Республике.
                                            </i>
                                        </label>
                                        <select name="region_id" class="select2 w-100" placeholder="{{trans('fonds.type-help')}}" id="regions" required>
                                            @foreach($regions as $region)
                                                <option value="{{$region->region_id}}">{{$region->text}}</option>
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

                            <div class="form-group mb-4 baseHelpTypes">
                                {{--<label for="baseHelpTypes">{{trans('fonds.check-scope-help')}}</label>--}}
                                <label for="baseHelpTypes">
                                    Укажите, в каком именно вопросе Вам требуется помощь.
                                </label>
                                <select name="baseHelpTypes" class="select2 w-100" placeholder="{{trans('fonds.scope-help')}}" id="baseHelpTypes" required>
                                    @foreach($baseHelpTypes as $destionation)
                                            <option value="{{$destionation->id}}">{{$destionation->name_ru}}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">{{trans('fonds.scope-help')}}</small>
                            </div>

                            <div class="form-group mb-4 cashHelpTypes">
                                {{--<label for="exampleInputEmail1">{{trans('fonds.check-type-help')}}</label>--}}
                                <label for="exampleInputEmail1">
                                    Укажите, какой тип помощи Вам необходим.
                                    <i>
                                        Возможно, Вам нужна финансовая разовая помощь (например, оплатить операцию), или финансовая помощь, но на постоянной основе (например, если Вы мать-одиночка, и Вам нужно каждый месяц содержать детей). Возможно, Вам нужна помощь волонтеров (если Вы одинокий пожилой человек, которому требуется уход), или материальная помощь (например, закупить мебель в детский дом). Возможно, Вам требуется консультация (например, Вы не знаете, как оформить алименты в случае развода), или сопровождение (например, Вы проживаете в селе, но Вам нужно сделать операцию в городе, и у Вас нет возможности добраться до него самостоятельно). Возможно, Вам нужна помощь в логистике (например, привезти закупленные в городе лекарства в Ваше село), или Вам негде жить, и Вам необходимо временное жилье.
                                    </i>
                                </label>
                                <select name="cashHelpTypes[]" class="select2 w-100" multiple placeholder="{{trans('fonds.type-rendered-help')}}" id="cashHelpTypes" required>
                                    @foreach($cashHelpTypes as $destination)
                                        @if($destination['id'] != 3)
                                            <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4 cashHelpSizes">
                                {{--<label for="exampleInputEmail1">{{trans('fonds.indicate-summ-help')}}</label>--}}
                                <label for="exampleInputEmail1">
                                    Укажите примерную сумму требуемой помощи.
                                    <i>
                                        Понимая размер необходимой помощи, организации могут определить, обладают ли они нужными ресурсами, чтобы Вам помочь.
                                    </i>
                                </label>
                                <select name="cash_help_size_id" class="select2 w-100" placeholder="{{trans('fonds.type-rendered-help')}}" id="cashHelpSizes" required>
                                    @foreach($cashHelpSizes as $destination)
                                        <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                {{--<label for="exampleInputEmail1">{{trans('fonds.indicate-urgency-help')}}</label>--}}
                                <label for="exampleInputEmail1">
                                    Укажите, насколько срочным является Ваш случай.
                                    <i>
                                        Понимая, насколько срочным является Ваш случай (например, Вам требуется срочная операция, или, наоборот, Вы не можете позволить оплатить учебу, но поступление будет только через год), организации могут соотнести его со своей загруженностью и принять верное решение (например, организация готова взять Ваш случай, но только через полгода, так как сейчас у нее нет необходимых ресурсов).
                                    </i>
                                </label>
                                <select name="urgency_date" class="select2 w-100" placeholder="{{trans('fonds.indicate-urgency-help2')}}" id="helpUrgencyDate" required>
                                    <option value="1">{{trans('fonds.flow-month-1')}}</option>
                                    <option value="2">{{trans('fonds.flow-month-3')}}</option>
                                    <option value="3">{{trans('fonds.flow-month-6')}}</option>
                                    <option value="4">{{trans('fonds.flow-year')}}</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                {{--<label for="exampleInputEmail1">{{trans('fonds.attach-photo-video')}}</label>--}}
                                <label for="exampleInputEmail1">
                                    Прикрепите фото/видео заявителя или ситуации, в которую Вы попали.
                                    <i>
                                        Так организации смогут убедиться в том, что Вам действительно нужна помощь. Например, Вы можете прикрепить фото сгоревшего дома или своих жилищных условий.
                                    </i>
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
                                    <input type="file" id="file" name="photo[]" class="form-control photo">
                                    <div class="input-group-append" style="display: none;">
                                        <button class="btn btn-default p-2" type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-default p-2 mt-2" onclick="if($('.photo').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();$(this).prev().find('input').val('');} return false;">+ Добавить еще</button>
                            </div>

                            <div class="form-group mb-4">
                                <label for="">{{trans('fonds.video-share')}}</label>
                                <input type="text" name="video" value="@if($help) {{$help->video}} @endif" class="form-control" placeholder="{{trans('fonds.share-video2')}}">
                            </div>

                            <div class="form-group mb-4">
                                {{--<label for="exampleInputEmail1">{{trans('fonds.attach-doc-help')}}</label>--}}
                                <label for="exampleInputEmail1">
                                    Если у Вас есть, прикрепите документы, подтверждающие действительность Вашей ситуации.
                                    <i>
                                        Например, медицинские справки, выписки, справку с места учебы, работы и т. д., подтверждающие правдивость Ваших слов. Укажите название документа и прикрепите файл в формате doc, jpeg или pdf.
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
                                    <input type="file"  class="form-control docs" name="doc[]">
                                    <div class="input-group-append" style="display: none;">
                                        <button class="btn btn-default p-2" type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-default p-2 mt-2" onclick="if($('.docs').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();$(this).prev().find('input').val('');} return false;">+ Добавить еще</button>
                            </div>
                            <input type="hidden" class="form-control" name="help_fond" id="help_fond">
                            <label>
                                Укажите, в каком именно вопросе Вам требуется помощь.<br>
                                <i>
                                    Максимально полно опишите Ваш случай, чтобы организации поняли, как именно они могут Вам помочь.
                                </i>
                            </label>
                            <textarea name="body" placeholder="{{trans('fonds.desc-help')}}*" class="form-control mb-3" id="helpBody" cols="20" rows="10" required>@if($help) {{$help->body}} @else {{old('body')}} @endif</textarea>
                            {{--<input type="submit" class="btn btn-default m-auto d-table" value="{{trans('fonds.find')}}">--}}
                            <button  class="btn btn-default m-auto d-table" id="request_help_button">Подать заявку</button>
                        </form>
                        @include('frontend.fond.script')
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
