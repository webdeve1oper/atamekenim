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
                            <a data-toggle="collapse" class="collapsed" href="#collapse99">Регион оказания помощи (выберите один или несколько вариантов)
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
                                    @include('backend.fond_cabinet.edit.blocks.regions')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse999">Введите текст, отражающий
                                миссию Вашей организации <i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse999" class="panel-collapse collapse">
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
                                                {!! Auth::user()->about_ru !!}
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
                                                {!! Auth::user()->about_kz !!}
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
                                <i class="fas fa-angle-up"></i>
                            </a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 d-table">
                                        <div class="form-group pb-5">
                                            <?php $requisites = Auth::user()->requisites; ?>
                                            @include('backend.fond_cabinet.edit.blocks.requisite')
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
                                            <?php
                                            $offices = Auth::user()->offices;
                                            ?>
                                            <table class="table table-bordered">
                                                @if(count($offices) > 0)
                                                    <thead>
                                                    <tr>
                                                        <th><b>Руководитель:</b></th>
                                                        <th><b>Адрес:</b></th>
                                                        <th><b>Телефон:</b></th>
                                                        <th><b>Электронная почта:</b></th>
                                                        <th><b>Часы работы:</b></th>
                                                        <th class="text-center" colspan="2"><b>Действие</b></th>
                                                    </tr>
                                                    </thead>
                                                    @foreach($offices as $i=> $office)
                                                        @include('backend.fond_cabinet.edit.blocks.office')
                                                    @endforeach
                                                    <p class="btn btn-default float-right mt-2 mb-5 d-table" data-toggle="modal" data-target="#newOffice">
                                                        + добавить еще один центральный офис
                                                    </p>
                                                @else
                                                    <p class="btn btn-default float-right mt-2 mb-5 d-table" data-toggle="modal" data-target="#newOffice">
                                                        + добавить центральный офис
                                                    </p>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
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

    <div class="modal fade" id="newRequiesite" tabindex="-1" aria-labelledby="newRequiesite" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Реквизиты</h5>
                </div>
                <div class="modal-body">
                    <div class="requisites">
                        <form action="{{route('requisite_create')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">БИН:*</label>
                                <input type="text" name="bin" data-key="bin" value=""
                                       class="form-control bin">
                            </div>
                            <div class="form-group">
                                <label for="">ИИК:*</label>
                                <input type="text" name="iik" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">БИК:*</label>
                                <input type="text" name="bik" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Название банка:*</label>
                                <input type="text" name="name" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Руководитель:*</label>
                                <input type="text" name="leader" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Юридический адрес:*</label>
                                <input type="text" name="yur_address" value="" class="form-control">
                            </div>
                            <div class="payment">
                                Выражаю согласие от имени моей организации на сбор онлайн-переводов на сайте atamekenim.kz
                                <input type="checkbox" name="aggree">
                            </div>
                            <div class="form-group mt-2">
                                <input type="submit" value="сохранить" class="btn btn-default ">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newOffice" tabindex="-1" aria-labelledby="newOffice" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Офисы</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('office_create')}}" method="post">
                        @csrf
                        <div class="office">
                            <div class="form-group">
                                <label for="">Руководитель:</label>
                                <input type="text" name="leader" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Адрес:</label>
                                <input type="text" name="address" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Телефон:</label>
                                <input type="text" name="phone" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Электронная почта:</label>
                                <input type="text" name="email" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Часы работы :</label>
                                <input type="text" name="time" value="" class="form-control">
                            </div>
                            <div class="central">
                                Данный филиал является центральным офисом
                                <input type="checkbox" name="central"/>
                            </div>
                            <input type="hidden" name="longitude" id="longitude" value="" class="form-control">
                            <input type="hidden" name="latitude" id="latitude" value="" class="form-control">
                            <div class="form-group">
                                <div id="map0" class="w-100" style="height: 300px;"></div>
                            </div>
                            <div class="form-group mt-2">
                                <input type="submit" value="сохранить" class="btn btn-default ">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach($offices as $i=> $office)
        <div class="modal fade" id="office{{$i}}" tabindex="-1" aria-labelledby="office{{$i}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Офисы</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('office_edit', [$office->id])}}" method="post">
                            @csrf
                            <div class="office">
                                <div class="form-group">
                                    <label for="">Руководитель:</label>
                                    <input type="text" name="leader" value="{{$office['leader']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Адрес:</label>
                                    <input type="text" name="address" value="{{$office['address']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Телефон:</label>
                                    <input type="text" name="phone" value="{{$office['phone']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Электронная почта:</label>
                                    <input type="text" name="email" value="{{$office['email']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Часы работы :</label>
                                    <input type="text" name="time" value="{{$office['time']}}" class="form-control">
                                </div>
                                <input type="hidden" name="longitude" id="longitude{{$office->id}}" value="{{$office['longitude']}}" class="form-control">
                                <input type="hidden" name="latitude" id="latitude{{$office->id}}" value="{{$office['latitude']}}" class="form-control">
                                <div class="form-group">
                                    <div id="map{{$office->id}}" class="w-100" style="height: 300px;"></div>
                                </div>
                                <div class="central">
                                    Данный филиал является центральным офисом
                                    <input type="checkbox" name="central" @if($office['central']) checked @endif />
                                </div>
                                <div class="form-group mt-2">
                                    <input type="submit" value="сохранить" class="btn btn-default ">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach($requisites as $i=> $requisite)
        <div class="modal fade" id="requisite{{$i}}" tabindex="-1" aria-labelledby="requisite" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Реквизиты</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('requisite_edit', [$requisite->id])}}" method="post">
                            @csrf
                            <div class="requisites">
                                <div class="form-group">
                                    <label for="">БИН:*</label>
                                    <input type="text" name="bin" value="{{$requisite['bin']}}" class="form-control bin">
                                </div>
                                <div class="form-group">
                                    <label for="">ИИК:*</label>
                                    <input type="text" name="iik" value="{{$requisite['iik']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">БИК:*</label>
                                    <input type="text" name="bik" value="{{$requisite['bik']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Название банка:*</label>
                                    <input type="text" name="name" value="{{$requisite['name']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Руководитель:*</label>
                                    <input type="text" name="leader" value="{{$requisite['leader']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Юридический адрес:*</label>
                                    <input type="text" name="yur_address" value="{{$requisite['yur_address']}}" class="form-control">
                                </div>
                                <div class="payment">
                                    Выражаю согласие от имени моей организации на сбор онлайн-переводов на сайте atamekenim.kz
                                    <input type="checkbox" @if($requisite['aggree']) checked @endif  name="aggree">
                                </div>
                                <div class="form-group mt-2">
                                    <input type="submit" value="сохранить" class="btn btn-default ">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="/js/selecttree.js"></script>
    <link rel="stylesheet" href="/css/selecttree.css">
    @include('backend.fond_cabinet.edit.blocks.script')
    <style>
        .fa-angle-up {
            float: right;
        }

        .collapsed .fa-angle-up::before {
            content: "\f107";
        }
        .card a{
            color: rgb(0 83 165);
            font-weight: 600;
        }
    </style>
@endsection
