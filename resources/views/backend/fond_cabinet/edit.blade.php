@extends('backend.fond_cabinet.setting')

@section('setting_content')
    <div class="col-sm-12 pb-5">
        <h1>БАЗОВАЯ ИНФОРМАЦИЯ О ВАШЕЙ ОРГАНИЗАЦИИ</h1>
    </div>
    <form action="{{route('fond_setting')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-sm-3 mb-3">
                @if(Auth::user()->logo)
                    <img src="{{Auth::user()->logo}}" style="max-height: 150px;" alt="" class="logotype">
                @else
                    <img src="/img/no-photo.png" style="max-height: 150px;" alt="" class="logotype">
                @endif
                <input type="file" class="form-control mt-3" name="logo">
                @if($errors->has('logo'))
                    <span class="error">{{ $errors->first('logo') }}</span>
                @endif
                <small class="text-center">
                    Логотип Вашей
                    организации
                    в формате jpeg, png
                </small>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Название организации:</label>
                    <input type="text" name="title_ru" value="{{Auth::user()->title_ru}}"
                           class="form-control">
                    @if($errors->has('title_ru'))
                        <span class="error">{{ $errors->first('title_ru') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Название организации на казахском языке:*
                    </label>
                    <input type="text" name="title_kz" value="{{Auth::user()->title_kz}}"
                           class="form-control">
                    @if($errors->has('title_kz'))
                        <span class="error">{{ $errors->first('title_kz') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Название организации на английском языке:*
                    </label>
                    <input type="text" name="title_en" value="{{Auth::user()->title_en}}"
                           class="form-control">
                    @if($errors->has('title_en'))
                        <span class="error">{{ $errors->first('title_en') }}</span>
                    @endif
                </div>
                <div class="form-group d-none">
                    <label for="">БИН</label>
                    <input type="text" value="{{Auth::user()->bin}}" disabled class="form-control">
                </div>

            </div>
            <div class="col-sm-4">
                <div class="form-group d-none">
                    <label for="">Телефон:</label>
                    <input type="text" name="phone" value="{{Auth::user()->phone}}"
                           class="form-control">
                    @if($errors->has('phone'))
                        <span class="error">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
                <div class="form-group d-none">
                    <label for="">Почта:</label>
                    <input type="text" name="email" value="{{Auth::user()->email}}"
                           class="form-control">
                    @if($errors->has('email'))
                        <span class="error">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Адрес сайта Вашей организации:</label>
                    <input type="text" name="website" value="{{Auth::user()->website}}"
                           class="form-control">
                    @if($errors->has('website'))
                        <span class="error">{{ $errors->first('website') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Информационный
                        видеоролик о Вашей
                        организации:
                    </label>
                    <input type="text" placeholder="Ссылка на видео" value="{{Auth::user()->video}}" class="form-control">
                    @if($errors->has('video'))
                        <span class="error">{{ $errors->first('video') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse0">Информация по страницам Вашей организации в социальных сетях
                                <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse0" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                    <?php $socials = []; ?>
                                    @if(Auth::user()->social)
                                            <div class="row">
                                        <?php
                                        $socials = json_decode(Auth::user()->social, true);
                                        ?>
                                        @foreach($socials as $i=> $social)
                                            @if($i == 0)
                                                    <div class="col-sm-6">
                                            @endif
                                            @if($i == 3)
                                                    </div>
                                                    <div class="col-sm-6">
                                            @endif
                                                <div class="form-group">
                                                    <label for="">{{$social['name']}}:</label>
                                                    <input type="text" name="socials[{{$social['name']}}]" value="{{$social['link']}}"
                                                           class="form-control">
                                                </div>
                                                @if($loop->last)
                                                    </div>
                                                @endif
                                        @endforeach
                                            </div>
                                    @else
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Instagram:</label>
                                                    <input type="text" name="socials[Instagram]" value=""
                                                           class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Facebook:</label>
                                                    <input type="text" name="socials[Facebook]" value=""
                                                           class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Youtube:</label>
                                                    <input type="text" name="socials[Youtube]" value=""
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">WhatsApp:</label>
                                                    <input type="text" name="socials[WhatsApp]" value=""
                                                           class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Telegram:</label>
                                                    <input type="text" name="socials[Telegram]" value=""
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse99">Регион оказания помощи (выберите один или несколько вариантов) *
                                <i class="fas fa-angle-up"></i>
                            </a>
                        </div>
                    </div>
                    <div id="collapse99" class="panel-collapse collapse">
                        <div class="card-body">
                            {{--<select id="locations"  multiple></select>--}}
                            <div class="bigRegionsFather">
                                <div class="regionsBlock" onclick="$('.regionsOpenBlock').toggle();"></div>
                                <div class="regionsOpenBlock">
                                    @foreach($regions as $region)
                                        <!--Регионы-->
                                        @if(count($region['districts'])>0)
                                            <div class="optionBlock">
                                                <a class="toggleButton" onclick="$(this).siblings('.inOptionBlock').toggle();$(this).toggleClass('opened');"><i class="fas fa-chevron-down"></i></a>
                                                <div class="inputBlock" id="region_{{$region->region_id}}"><input id="{{$region->region_id}}" type="checkbox" name="region[]"><span class="regionText">{{$region->text}}</span></div>
                                                <div class="inOptionBlock">
                                                    <!--Район-->
                                                    @foreach($region['districts'] as $district)
                                                        @if(count($district['cities'])>0)
                                                            <div class="optionBlock">
                                                                <a class="toggleButton" onclick="$(this).siblings('.thirdInOptionBlock').toggle();$(this).toggleClass('opened');"><i class="fas fa-chevron-down"></i></a>
                                                                <div class="inputBlock" id="district_{{$district->district_id}}"><input id="{{$district->district_id}}" type="checkbox" name="district[]"><span class="districtText">{{$district->text}}</span></div>
                                                                <div class="inOptionBlock thirdInOptionBlock">
                                                                    <!--Город/Село-->
                                                                    @foreach($district['cities'] as $city)
                                                                        <div class="optionBlock">
                                                                            <div class="inputBlock" id="city_{{$city->city_id}}"><input id="{{$city->city_id}}" type="checkbox" name="city[]"><span class="cityText">{{$city->title_ru}}</span></div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="optionBlock">
                                                                <div class="inputBlock" id="district_{{$district->district_id}}"><input id="{{$district->district_id}}" type="checkbox" name="district[]"><span class="districtText">{{$district->text}}</span></div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <div class="optionBlock">
                                                <div class="inputBlock" id="region_{{$region->region_id}}"><input id="{{$region->region_id}}" type="checkbox" name="region[]"><span class="regionText">{{$region->text}}</span></div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .regionsOpenBlock {
                        width: 100%;
                        display: block;
                        border: 1px solid #eee;
                        border-radius: 3px;
                        display: none;
                    }

                    .regionsOpenBlock .optionBlock {
                        display: table;
                        position: relative;
                        width: 100%;
                    }

                    .regionsOpenBlock .optionBlock .inputBlock {
                        display: table;
                        position: relative;
                        width: 100%;
                        border-bottom: 1px solid #eee;
                        padding-left: 40px;
                    }

                    .regionsOpenBlock .optionBlock .inputBlock span {
                        display: table;
                        position: relative;
                        padding: 10px;
                        width: 100%;
                    }

                    .regionsOpenBlock .optionBlock .inOptionBlock {
                        display: block;
                        padding-left: 25px;
                        display: none;
                    }

                    .regionsOpenBlock .optionBlock .inputBlock input {
                        position: absolute;
                        top: 0;
                        left: 0;
                        height: 100%;
                        width: 100%;
                        z-index: 3;
                        opacity: 0;
                    }

                    .regionsOpenBlock .optionBlock .inputBlock input:hover {
                        cursor: pointer;
                    }

                    .regionsOpenBlock .optionBlock .toggleButton {
                        position: absolute;
                        top: 6px;
                        left: 10px;
                        width: 25px;
                        height: 25px;
                        text-align: center;
                        font-size: 20px;
                        border-radius: 3px;
                        background: #eee;
                        z-index: 5;
                    }

                    .regionsOpenBlock .optionBlock .toggleButton:hover {
                        cursor: pointer;
                        background: #ccc;
                    }

                    .regionsOpenBlock .optionBlock:last-child .inputBlock {
                        border: none;
                    }
                    .regionsOpenBlock .optionBlock .inOptionBlock .optionBlock {
                        background: #f9f9f9;
                    }

                    .regionsOpenBlock .optionBlock .inOptionBlock.thirdInOptionBlock .optionBlock {
                        background: #f1f1f1;
                        width: 98%;
                        margin-left: 2%;
                    }

                    .regionsOpenBlock .optionBlock .inOptionBlock.thirdInOptionBlock .optionBlock .inputBlock {
                        padding-left: 0;
                        border-bottom: 1px solid #e6e6e6;
                    }

                    .regionsOpenBlock .optionBlock .inOptionBlock.thirdInOptionBlock {}

                    .regionsOpenBlock .optionBlock .inputBlock:hover {
                        background: #ccc;
                    }
                    .regionsOpenBlock .optionBlock .toggleButton.opened i {
                        transform: rotate(180deg);
                    }
                    .regionsOpenBlock .optionBlock .toggleButton i {
                        transition: .2s linear;
                        display: table-cell;
                        vertical-align: middle;
                    }

                    .regionsOpenBlock .optionBlock .toggleButton {
                        display: table;
                    }
                    .regionsOpenBlock {
                        max-height: 400px;
                        overflow-y: scroll;
                    }
                    .bigRegionsFather {
                        display: block;
                        position: relative;
                        width: 100%;
                    }

                    .bigRegionsFather .regionsBlock {
                        display: table;
                        width: 100%;
                        min-height: 40px;
                        border: 1px solid #eee;
                        border-radius: 3px;
                        padding: 10px;
                        position: relative;
                    }

                    .bigRegionsFather .regionsBlock:hover {
                        cursor: pointer;
                        box-shadow: 0 0 13px #eee;
                    }

                    .regionsOpenBlock {
                        position: absolute;
                        top: 100%;
                        left: 0;
                        width: 100%;
                        background: #fff;
                        z-index: 10;
                        margin: 6px 0 0;
                    }
                    .bigRegionsFather .regionsBlock .inputBlock {
                        display: inline-table;
                        margin: 5px 10px 5px 0;
                    }

                    .bigRegionsFather .regionsBlock .inputBlock input {
                        display: none;
                    }

                    .bigRegionsFather .regionsBlock .inputBlock span {
                        display: table;
                        margin: 0;
                        padding: 8px 12px;
                        background: #ccc;
                        border-radius: 3px;
                        color: #fff;
                    }
                    .bigRegionsFather .regionsBlock .inputBlock span.regionText {
                        background: #925e11;
                    }

                    .bigRegionsFather .regionsBlock .inputBlock span.districtText {
                        background: #19ad3a;
                    }

                    .bigRegionsFather .regionsBlock .inputBlock span.cityText {
                        background: #03a9f4;
                    }
                    .regionsOpenBlock .optionBlock .inputBlock.active {
                        background: #999;
                        color: #fff;
                    }
                    .bigRegionsFather .regionsBlock .inputBlock span {
                        position: relative;
                    }

                    .bigRegionsFather .regionsBlock .inputBlock span:after {content: 'x';padding: 1px 0 0;width: 20px;height: 20px;display: table;float: right;background: #fff;border-radius: 50%;color: #dc3545;text-align: center;margin-left: 15px;font-weight: 600;}
                </style>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse99">Введите текст, отражающий
                                миссию Вашей организации <i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="card-body">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#mission_rus">Русский</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#mission_kzs">Казахский</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane container active" id="mission_rus">
                                        <div class="form-group">
                                                        <textarea name="mission_ru" id="mission_ru" class="form-control"
                                                                  cols="30" rows="10">
                                                            {{Auth::user()->mission_ru}}
                                                         </textarea>
                                            @if($errors->has('mission_ru'))
                                                <span class="error">{{ $errors->first('mission_ru') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane container" id="mission_kzs">
                                        <div class="form-group">
                                                        <textarea name="mission_kz" id="mission_kz" class="form-control"
                                                                  cols="30" rows="10">
                                                            {{Auth::user()->mission_kz}}
                                                         </textarea>
                                            @if($errors->has('mission_ru'))
                                                <span class="error">{{ $errors->first('mission_ru') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse3">Введите текст о Вашей организации <i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="card-body">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#about_rus">Русский</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#about_kzs">Казахский</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane container active" id="about_rus">
                                        <div class="form-group">
                                            <textarea name="about_ru" id="about_ru" class="form-control"
                                                      cols="30" rows="10">
                                                {{Auth::user()->about_ru}}
                                             </textarea>
                                            @if($errors->has('about_ru'))
                                                <span class="error">{{ $errors->first('about_ru') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane container" id="about_kzs">
                                        <div class="form-group">
                                            <textarea name="about_kz" id="about_kz" class="form-control"
                                                      cols="30" rows="10">
                                                {{Auth::user()->about_kz}}
                                             </textarea>
                                            @if($errors->has('about_kz'))
                                                <span class="error">{{ $errors->first('about_kz') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse1">Информация по реквизитам поможет потенциальному благотворителю оказать финансовую помощь Вашей организации.
                                <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 d-table">
                                        <div class="form-group pb-5">
                                            <?php $requisites = []; ?>
                                            @if(Auth::user()->requisites)
                                                <?php
                                                $requisites = json_decode(Auth::user()->requisites, true);

                                                ?>
                                                @foreach($requisites as $i=> $requisite)
                                                        <div class="requisites">
                                                            <div class="form-group">
                                                                <label for="">БИН:*</label>
                                                                <input type="text"  name="requisites[{{$i}}][bin]" data-key="bin" value=@if($i == 0)"{{Auth::user()->bin}}" disabled @else"{{$requisite['bin']}}" @endif" class="form-control bin">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">ИИК:*</label>
                                                                <input type="text" name="requisites[{{$i}}][address]" data-key="address" value="{{$requisite['address']}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">БИК:*</label>
                                                                <input type="text" name="requisites[{{$i}}][phone]" data-key="phone" value="{{$requisite['phone']}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Название банка:*</label>
                                                                <input type="text" name="requisites[{{$i}}][email]" data-key="email" value="{{$requisite['email']}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Руководитель:*</label>
                                                                <input type="text" name="requisites[{{$i}}][leader]" data-key="leader" value="{{$requisite['leader']}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Юридический адрес:*</label>
                                                                <input type="text" name="requisites[{{$i}}][address]" data-key="address" value="{{$requisite['address']}}" class="form-control">
                                                            </div>

                                                            @if($i == 0)
{{--                                                            <div class="payment">--}}
{{--                                                                Выражаю согласие от имени моей организации на сбор онлайн-переводов на сайте atamekenim.kz--}}
{{--                                                                <input type="checkbox" @if($requisite['payment'] == 'on') checked @endif name="requisites[{{$i}}][payment]">--}}
{{--                                                            </div>--}}
                                                            @endif
                                                            <hr class="mt-3 mb-2">
                                                        </div>
                                                @endforeach
                                            @else
                                                <div class="requisites">
                                                    <div class="form-group">
                                                        <label for="">БИН:*</label>
                                                        <input type="text" disabled name="requisites[0][bin]" data-key="bin" value="{{Auth::user()->bin}}" class="form-control bin">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">ИИК:*</label>
                                                        <input type="text" name="requisites[0][address]" data-key="address" value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">БИК:*</label>
                                                        <input type="text" name="requisites[0][phone]" data-key="phone" value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Название банка:*</label>
                                                        <input type="text" name="requisites[0][email]" data-key="email" value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Руководитель:*</label>
                                                        <input type="text" name="requisites[0][leader]" data-key="leader" value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Юридический адрес:*</label>
                                                        <input type="text" name="requisites[0][address]" data-key="address" value="" class="form-control">
                                                    </div>
{{--                                                    <div class="payment">--}}
{{--                                                        Выражаю согласие от имени моей организации на сбор онлайн-переводов на сайте atamekenim.kz--}}
{{--                                                        <input type="checkbox" name="requisites[0][payment]">--}}
{{--                                                    </div>--}}
                                                    <hr class="mt-3 mb-2">
                                                </div>
                                            @endif
                                                <p class="btn btn-default float-right mt-2 mb-5 d-table"
                                                        onclick="if($('.requisites').length <5){
                                                            var office = $(this).prev().clone();
                                                            office.find('input').each(function(value, index){
                                                                var key = $(index).attr('data-key');
                                                                $(index).attr('name', 'requisites['+$('.requisites').length + ']['+key+']').val('');
                                                            });
                                                            office
                                                            .find('.bin').val('')
                                                            .removeAttr('disabled')
                                                            .parents('.requisites')
                                                            .find('.payment').remove();
                                                            $(office).insertBefore(this)
                                                        } return false;">
                                                + добавить еще один счет
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse11">Внесите информацию по филиалам организации (при наличии офиса)<i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse11" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 d-table">
                                        <div class="form-group pb-5">
                                            <?php $offices = []; ?>
                                            @if(Auth::user()->offices)
                                                <?php
                                                $offices = json_decode(Auth::user()->offices, true);
                                                ?>
                                                @foreach($offices as $i=> $requisite)
                                                        <div class="office">
                                                            <div class="form-group">
                                                                <label for="">Руководитель:</label>
                                                                <input type="text" name="offices[{{$i}}][leader]" data-key="leader" value="{{$requisite['leader']}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Адрес:</label>
                                                                <input type="text" name="offices[{{$i}}][address]" data-key="address" value="{{$requisite['address']}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Телефон:</label>
                                                                <input type="text" name="offices[{{$i}}][phone]" data-key="phone" value="{{$requisite['phone']}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Электронная почта:</label>
                                                                <input type="text" name="offices[{{$i}}][email]" data-key="email" value="{{$requisite['email']}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Часы работы :</label>
                                                                <input type="text" name="offices[{{$i}}][work_time]" data-key="work_time" value="{{$requisite['work_time']}}" class="form-control">
                                                            </div>
                                                            @if($i == 0)
{{--                                                            <div class="central">--}}
{{--                                                                Данный филиал является центральным офисом--}}
{{--                                                                <input type="checkbox" @if($requisite['central'] == 'on') checked @endif data-key="central" name="offices[{{$i}}][central]">--}}
{{--                                                            </div>--}}
                                                            @endif
                                                            <hr class="mt-3 mb-2">
                                                        </div>
                                                @endforeach
                                            @else
                                                <div class="office">
                                                    <div class="form-group">
                                                        <label for="">Руководитель:</label>
                                                        <input type="text" name="offices[0][leader]" data-key="leader" value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Адрес:</label>
                                                        <input type="text" name="offices[0][address]" data-key="address" value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Телефон:</label>
                                                        <input type="text" name="offices[0][phone]" data-key="phone" value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Электронная почта:</label>
                                                        <input type="text" name="offices[0][email]" data-key="email" value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Часы работы :</label>
                                                        <input type="text" name="offices[0][work_time]" data-key="work_time" value="" class="form-control">
                                                    </div>
{{--                                                    <div class="central">--}}
{{--                                                        Данный филиал является центральным офисом--}}
{{--                                                        <input type="checkbox" name="offices[0][central]" data-key="central">--}}
{{--                                                    </div>--}}
                                                    <hr class="mt-3 mb-2">
                                                </div>
                                            @endif
                                            <p class="btn btn-default float-right mt-2 mb-5 d-table"
                                                    onclick="if($('.office').length <5){var office = $(this).prev().clone();
                                                            office.find('input').each(function(value, index){
                                                                var key = $(index).attr('data-key');
                                                                $(index).attr('name', 'offices['+$('.office').length + ']['+key+']').val('');
                                                            });
                                                            office
                                                            .parents('.office')
                                                            .find('.central').remove(); $(office).insertBefore(this)}return false;">
                                                + добавить еще один центральный офис
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="card-header">
                                <a data-toggle="collapse" class="collapsed" href="#collapse5">Укажите
                                    расположение организации на карте <i class="fas fa-angle-up"></i></a>
                            </div>
                            <div id="collapse5" class="panel-collapse collapse">
                                <div class="form-group">
                                    <input type="hidden" name="longitude"
                                           value="{{Auth::user()->longitude}}" id="longitude">
                                    <input type="hidden" name="latitude"
                                           value="{{Auth::user()->latitude}}" id="latitude">
                                    <div id="map" class="w-100" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <input type="submit" class="btn btn-default" value="Сохранить">
            </div>
        </div>

    </form>

    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="/js/selecttree.js"></script>
    <link rel="stylesheet" href="/css/selecttree.css">
    {{--<script>--}}
        {{--var json = {!! $regions->toJson() !!};--}}

        {{--var locations = [--}}
                {{--@foreach($regions as $region){--}}
                    {{--id:"{{$region->region_id}}", text: "{{$region->text}}",  inc: [--}}
                    {{--@if(count($region['districts'])>0)--}}
                        {{--@foreach($region['districts'] as $district)--}}
                            {{--@if(count($district['cities'])>0)--}}
                                {{--{id:"{{$district->district_id}}", text: "{{$district->text}}", class: "non-leaf", inc: []},--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                {{--]--}}
            {{--},--}}

                {{--@endforeach--}}
        {{--];--}}

        {{--var cities = [--}}
                {{--@foreach($regions as $region)--}}
                        {{--@if(count($region['districts'])>0)--}}
                        {{--@foreach($region['districts'] as $district)--}}
                {{--{"{{$district->district_id}}": [--}}
                                {{--@if(count($district['cities'])>0)--}}
                                {{--@foreach($district['cities'] as $city)--}}
                            {{--{id:"{{$city->city_id}}", text: "{{ str_replace("\n", "", $city->title_ru)}}"},--}}
                            {{--@endforeach--}}
                            {{--@endif--}}
                {{--]},--}}
                    {{--@endforeach--}}
                    {{--@endif--}}
            {{--@endforeach--}}
        {{--];--}}
        {{--console.log(locations);--}}
        {{--$("#locations").select2ToTree({treeData: {dataArr:locations}, width: '100%',closeOnSelect: false});--}}
        {{--var options = {--}}
            {{--toolbar: [--}}
                {{--{name: 'clipboard', items: ['Cut', 'Copy', 'Undo', 'Redo']},--}}
                {{--{name: 'tools', items: ['Maximize', 'ShowBlocks']},--}}
                {{--{name: 'others', items: ['-']},--}}
            {{--]--}}
        {{--};--}}
        {{--CKEDITOR.replace('mission_ru', options);--}}
        {{--CKEDITOR.replace('mission_kz', options);--}}
        {{--CKEDITOR.replace('about_ru', options);--}}
        {{--CKEDITOR.replace('about_kz', options);--}}

        {{--function ckeditor(id) {--}}
            {{--CKEDITOR.replace(id, options);--}}
            {{--CKEDITOR.instances[id].setData('');--}}
        {{--}--}}
    {{--</script>--}}
    <script>
        $(document).ready(function () {
            $('.regionsOpenBlock input[type="checkbox"]').click(function(){
                var inputs = $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').clone();
                $('.regionsBlock').html(inputs);
                $('.regionsOpenBlock input[type="checkbox"]').parents('.inputBlock').removeClass("active");
                $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').addClass("active");
                $('.regionsBlock .inputBlock').click(function(){
                    var id = $(this).attr("id");
                    $('.regionsOpenBlock #'+id).find('input').prop( "checked", false );
                    $('.regionsOpenBlock input[type="checkbox"]').parents('.inputBlock').removeClass("active");
                    $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').addClass("active");
                    $(this).remove();
                });
            });
            $('.regionsBlock .inputBlock').click(function(){
                var id = $(this).attr("id");
                $('.regionsOpenBlock #'+id).find('input').prop( "checked", false );
                $('.regionsOpenBlock input[type="checkbox"]').parents('.inputBlock').removeClass("active");
                $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').addClass("active");
                $(this).remove();
            });
        });
    </script>
    <script>
        ymaps.ready(init);

        function init() {
            var myPlacemark,
                myMap = new ymaps.Map('map', {
                    @if(Auth::user()->longitude && Auth::user()->latitude)
                    center: [{{Auth::user()->longitude}}, {{Auth::user()->latitude}}],
                    zoom: 15,
                    @else
                    center: [48.045133, 67.492732],
                    zoom: 5,
                    @endif
                    controls: ['searchControl']
                }, {
                    searchControlProvider: 'yandex#search'
                });

            @if(Auth::user()->longitude && Auth::user()->latitude)
                myPlacemark = createPlacemark([{{Auth::user()->longitude}}, {{Auth::user()->latitude}}]);
            myMap.geoObjects.add(myPlacemark);
            @endif
            // Слушаем клик на карте.
            myMap.events.add('click', function (e) {
                var coords = e.get('coords');

                // Если метка уже создана – просто передвигаем ее.
                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                }
                // Если нет – создаем.
                else {
                    myPlacemark = createPlacemark(coords);
                    myMap.geoObjects.add(myPlacemark);
                    // Слушаем событие окончания перетаскивания на метке.
                    myPlacemark.events.add('dragend', function () {
                        getAddress(myPlacemark.geometry.getCoordinates());
                    });
                }
                getAddress(coords);
            });

            // Создание метки.
            function createPlacemark(coords) {
                return new ymaps.Placemark(coords, {
                    iconCaption: 'поиск...'
                }, {
                    preset: 'islands#violetDotIconWithCaption',
                    draggable: true
                });
            }

            // Определяем адрес по координатам (обратное геокодирование).
            function getAddress(coords) {
                $('#longitude').val(coords[0]);
                $('#latitude').val(coords[1]);
                myPlacemark.properties.set('iconCaption', 'поиск...');
                ymaps.geocode(coords).then(function (res) {
                    var firstGeoObject = res.geoObjects.get(0);

                    myPlacemark.properties
                        .set({
                            // Формируем строку с данными об объекте.
                            iconCaption: [
                                // Название населенного пункта или вышестоящее административно-территориальное образование.
                                firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                                // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                                firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                            ].filter(Boolean).join(', '),
                            // В качестве контента балуна задаем строку с адресом объекта.
                            balloonContent: firstGeoObject.getAddressLine()
                        });
                });
            }
        }
    </script>
    <style>
        .fa-angle-up {
            float: right;
        }

        .collapsed .fa-angle-up::before {
            content: "\f107";
        }
    </style>
@endsection
