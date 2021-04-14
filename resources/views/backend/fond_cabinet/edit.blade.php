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
                            <a data-toggle="collapse" class="collapsed" href="#collapse4">Введите текст, отражающий
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
                                                            <div class="payment">
                                                                Выражаю согласие от имени моей организации на сбор онлайн-переводов на сайте atamekenim.kz
                                                                <input type="checkbox" @if($requisite['payment'] == 'on') checked @endif name="requisites[{{$i}}][payment]">
                                                            </div>
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
                                                    <div class="payment">
                                                        Выражаю согласие от имени моей организации на сбор онлайн-переводов на сайте atamekenim.kz
                                                        <input type="checkbox" name="requisites[0][payment]">
                                                    </div>
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
                                                            <div class="central">
                                                                Данный филиал является центральным офисом
                                                                <input type="checkbox" @if($requisite['central'] == 'on') checked @endif data-key="central" name="offices[{{$i}}][central]">
                                                            </div>
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
                                                    <div class="central">
                                                        Данный филиал является центральным офисом
                                                        <input type="checkbox" name="offices[0][central]" data-key="central">
                                                    </div>
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
    <script>
        var json = {!! $regions->toJson() !!};
        $('#regions').select2({
            width: '100%',
            placeholder: 'Область'
        });
        $('#cities').select2({
            width: '100%',
            placeholder: 'Выберите город'
        });
        $('#regions').change(function () {
            var ind = $('#regions').children('option:selected').val();
            var datas = [];
            json.forEach(function (value, index) {
                if (value.region_id == ind) {
                    ind = index;
                }
            });

            $('#cities').empty();
            datas.push({id: '0', text: '-'});
            for (let [key, value] of Object.entries(json[ind].cities)) {
                datas.push({id: value.id, text: value.text});
            }
            $('#cities').select2({data: datas, allowClear: true});
        });
        var options = {
            toolbar: [
                {name: 'clipboard', items: ['Cut', 'Copy', 'Undo', 'Redo']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                {name: 'others', items: ['-']},
            ]
        };
        CKEDITOR.replace('mission_ru', options);
        CKEDITOR.replace('mission_kz', options);
        CKEDITOR.replace('about_ru', options);
        CKEDITOR.replace('about_kz', options);

        function ckeditor(id) {
            CKEDITOR.replace(id, options);
            CKEDITOR.instances[id].setData('');
        }
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
