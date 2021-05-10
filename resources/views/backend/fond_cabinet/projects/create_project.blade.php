@extends('backend.fond_cabinet.setting')

@section('setting_content')

    <h1>Создать проект</h1>
    <form action="{{route('create_project')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-3">
                <img src="/img/no-photo.png" style="max-height: 150px;" alt="" class="logotype">
                <input type="file" class="form-control mt-3" name="logo">
                @if($errors->has('logo'))
                    <span class="error">{{ $errors->first('logo') }}</span>
                @endif
                <small>Загрузите логотип проекта
                    в формате jpeg, png
                </small>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Название проекта</label>
                    <input type="text" name="title" value=""
                           class="form-control">
                    @if($errors->has('title'))
                        <span class="error">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Регион</label>
                    <select name="help_location_region" id="region" class="form-control">
                        @foreach($regions as $region)
                            <option value="{{$region->region_id}}" >{{$region->title_ru}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Город</label>
                    <select name="help_location_city" id="city" class="form-control">
                        <option value="">Все города</option>
                        @foreach($cities as $city)
                            <option value="{{$city->city_id}}" class="region_{{$city->region_id}}">{{$city->title_ru}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Дата создания проекта:</label>
                    <input type="date" name="date_created" value=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Введите адрес сайта проекта:</label>
                    <input type="text" name="website" value=""
                           class="form-control">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse2">Выберите основную сферу благотворительной деятельности Вашей организации (выберите один или несколько вариантов)* <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <?php $baseHelpTypess = array_column(Auth::user()->baseHelpTypes->toArray(), 'name_ru');?>
                                    @foreach($baseHelpTypes as $destination)
                                        <div class="col-sm-6">
                                            <div class="checkbox">
                                                <label>
                                                    <input @if(in_array($destination['name_ru'], $baseHelpTypess)) checked
                                                           @endif type="checkbox" id="base_help_types{{$destination['id']}}" name="base_help_types[]"
                                                           value="{{$destination['id']}}"> <b>{{$destination['name_ru']}}</b> @if($destination['description_ru'])<p>(<?php echo mb_strtolower($destination['description_ru']) ?> )@endif</p>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 ">
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse0">Соц. сети
                                <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse0" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                        <input name="socials[]" placeholder="Укажите ссылку"
                                               id="socials0" class="socials form-control">
                                    <button class="btn btn-default float-right mt-2 mb-5 d-table"
                                            onclick="var $div = $(this).prev(); var num = parseInt( $div.prop('id').match(/\d+/g), 10 ) +1; $('<input name=\'socials[]\'  placeholder=\'Укажите ссылку\' id=\'socials'+num+'\' class=\'socials form-control\'>').insertAfter($(this).prev()); return false;">
                                        + добавить соц. сеть
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse3">Введите описание проекта <i
                                        class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                            <textarea name="about" id="about" class="form-control" cols="30" rows="10">
                                            </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse4">Отметьте бенефициаров (получателей помощи), исходя из благотворительной деятельности Вашей организации (выберите один или несколько вариантов)*<i
                                        class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($scenarios as $destination)
                                        <div class="col-sm-6 @if($destination['id'] == 3)d-none @endif">
                                            <div class="checkbox">
                                                <label>
                                                    <input @if($destination['id'] == 1) onchange="$('#scenario_id3').prop('checked', $(this).prop('checked'))" @endif type="checkbox" id="scenario_id{{$destination['id']}}" name="scenario_id[]" value="{{$destination['id']}}">
                                                    <b>@switch($destination['id'])
                                                            @case(2)
                                                            отдельные лица (адресная помощь)
                                                            @break
                                                            @case(1)
                                                            семьи
                                                            @break
                                                            @case(4)
                                                            сообщества (например, жителям жилого комплекса, жителям населенного пункта, людям, объединенным по определенным интересам и т.д.)
                                                            @break
                                                            @case(5)
                                                            организации (государственной или частной компании, например, детскому дому, больнице)
                                                            @case(6)
                                                            животные
                                                            @break
                                                        @endswitch
                                                    </b>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 pl-0">
                <div class="panel-group mb-4">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse5">Укажите
                                расположение организации <i class="fas fa-angle-up"></i></a>
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
            <div class="col-sm-12">
                <input type="submit" class="btn btn-default" value="Сохранить">
            </div>
        </div>
    </form>


    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        var options = {
            toolbar: [
                {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo']},
                {
                    name: 'basicstyles',
                    groups: ['basicstyles', 'cleanup'],
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
                },
                {
                    name: 'paragraph',
                    groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']
                },
                {name: 'links', items: ['Link', 'Unlink']},
                {
                    name: 'insert',
                    items: ['Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
                },
                '/',
                {name: 'styles', items: ['Format', 'Font', 'FontSize']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                {name: 'others', items: ['-']},
            ]
        };
        CKEDITOR.replace('mission', options);
        CKEDITOR.replace('about', options);

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
