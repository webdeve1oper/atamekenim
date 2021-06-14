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
                    в формате jpeg, png (при наличии)
                </small>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Введите название проекта</label>
                    <input type="text" name="title" value=""
                           class="form-control">
                    @if($errors->has('title'))
                        <span class="error">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Введите адрес сайта проекта (при наличии):</label>
                    <input type="text" name="website" value=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Введите дату создания проекта:</label>
                    <input type="date" name="date_created" value=""
                           class="form-control">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Введите статус проекта:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="indefinite">Бессрочный</option>
                        <option value="active">Действующий</option>
                        <option value="finished">Завершен</option>
                    </select>
                    <div class="finishedDateBlock mt-4 d-none">
                        <label for="">Выбор даты завершения проекта:</label>
                        <input type="date" name="finished_date" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Ссылка на видео:</label>
                    <input type="text" name="video" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Загрузите отчет по проекту в формате doc, xls, pdf:</label>
                    <input type="file" name="document" value="" class="form-control">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse2">Выберите сферу оказываемой помощи в рамках проекта (выберите один или несколько вариантов)* <i class="fas fa-angle-up"></i></a>
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
                                    <label for="">Instagram</label>
                                    <input name="instagram" placeholder="Instagram url" class="form-control mb-2">
                                    <label for="">Facebook</label>
                                    <input name="facebook" placeholder="Facebook url" class="form-control mb-2">
                                    <label for="">Youtube</label>
                                    <input name="youtube" placeholder="Youtube url" class="form-control mb-2">
                                    <label for="">Whatsapp</label>
                                    <input name="whatsapp" placeholder="Whatsapp url" class="form-control mb-2">
                                    <label for="">Telegram</label>
                                    <input name="telegram" placeholder="Telegram url" class="form-control">
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
                            <a data-toggle="collapse" class="collapsed" href="#collapse4">Выберите бенефициаров проекта (выберите один или несколько вариантов)*<i
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
                                                <div class="inputBlock" id="region_{{$region->region_id}}"><input id="{{$region->region_id}}" type="checkbox" name="region[]"><span class="regionText">{{$region->title_ru}}</span></div>
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
                                                <div class="inputBlock" id="region_{{$region->region_id}}"><input id="{{$region->region_id}}" type="checkbox" name="region[]"><span class="regionText">{{$region->title_ru}}</span></div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse6">Партнеры Вашей организации по проекту <i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse6" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="partnerBlock firstChild">
                                        <button class="close" onclick="$(this).parents('.partnerBlock').remove()">&times;</button>
                                        <label for="">Введите название организации:</label>
                                        <input type="text" name="partnerName[]" class="form-control" placeholder="Введите название организации">
                                        <label for="" class="mt-3">Загрузите логотип:</label>
                                        <input type="file" name="partnerImg[]" class="form-control">
                                        <label for="" class="mt-3">Введите ссылку на сайт партнера при наличии:</label>
                                        <input type="text" name="partnerSite[]" class="form-control" placeholder="Введите ссылку на сайт партнера при наличии">
                                    </div>
                                    <div class="inBlock">
                                    </div>
                                    <a class="btn btn-success mt-1 addCopy" style="color:#fff!important;">+ добавить партнера</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse7">Спонсоры проекта <i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse7" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="partnerBlock firstChild">
                                        <button class="close" onclick="$(this).parents('.partnerBlock').remove()">&times;</button>
                                        <label for="">Введите название организации:</label>
                                        <input type="text" name="sponsorName[]" class="form-control" placeholder="Введите название организации">
                                        <label for="" class="mt-3">Загрузите логотип:</label>
                                        <input type="file" name="sponsorImg[]" class="form-control">
                                        <label for="" class="mt-3">Введите ссылку на сайт спонсора при наличии:</label>
                                        <input type="text" name="sponsorSite[]" class="form-control" placeholder="Введите ссылку на сайт спонсора при наличии">
                                    </div>
                                    <div class="inBlock">
                                    </div>
                                    <a class="btn btn-success mt-1 addCopy" style="color:#fff!important;">+ добавить спонсора</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse8">Компании - благотворители проекта <i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse8" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="partnerBlock firstChild">
                                        <button class="close" onclick="$(this).parents('.partnerBlock').remove()">&times;</button>
                                        <label for="">Введите название организации:</label>
                                        <input type="text" name="companyName[]" class="form-control" placeholder="Введите название организации">
                                        <label for="" class="mt-3">Загрузите логотип в формате jpeg, png:</label>
                                        <input type="file" name="companyImg[]" class="form-control">
                                        <label for="" class="mt-3">Введите ссылку на сайт компании-благотворителя при наличии:</label>
                                        <input type="text" name="companySite[]" class="form-control" placeholder="Введите ссылку на сайт спонсора при наличии">
                                        <label for="" class="mt-3">Сумма оказанной помощи, в тенге:</label>
                                        <input type="number" name="companySumm[]" class="form-control" placeholder="Сумма оказанной помощи, в тенге">
                                    </div>
                                    <div class="inBlock">
                                    </div>
                                    <a class="btn btn-success mt-1 addCopy" style="color:#fff!important;">+ добавить компанию - благотворителя</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse9">Благотворители - частные лица проекта <i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse9" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="partnerBlock firstChild">
                                        <button class="close" onclick="$(this).parents('.partnerBlock').remove()">&times;</button>
                                        <label for="">Введите имя благотворителя:</label>
                                        <input type="text" name="humanName[]" class="form-control" placeholder="Введите имя благотворителя">
                                        <label for="" class="mt-3">Благотворитель пожелал остаться неизвестным (чекбокс):</label>
                                        <input type="checkbox" name="humanIncognito[]" class="form-control" style="width: auto;">
                                        <label for="" class="mt-3">Сумма оказанной помощи, в тенге:</label>
                                        <input type="number" name="humanSumm[]" class="form-control" placeholder="Сумма оказанной помощи, в тенге">
                                    </div>
                                    <div class="inBlock">
                                    </div>
                                    <a class="btn btn-success mt-1 addCopy" style="color:#fff!important;">+ добавить благотворителя - частное лицо</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse10">Загрузите фотографии по проекту <i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse10" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="partnerBlock firstChild">
                                        <button class="close" onclick="$(this).parents('.partnerBlock').remove()">&times;</button>
                                        <input type="file" name="gallery[]" class="form-control">
                                    </div>
                                    <div class="inBlock">
                                    </div>
                                    <a class="btn btn-success mt-1 addCopy" style="color:#fff!important;">+ добавить фото</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
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
    {{--<script>--}}
        {{--var options = {--}}
            {{--toolbar: [--}}
                {{--{name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo']},--}}
                {{--{--}}
                    {{--name: 'basicstyles',--}}
                    {{--groups: ['basicstyles', 'cleanup'],--}}
                    {{--items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']--}}
                {{--},--}}
                {{--{--}}
                    {{--name: 'paragraph',--}}
                    {{--groups: ['list', 'indent', 'blocks', 'align', 'bidi'],--}}
                    {{--items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']--}}
                {{--},--}}
                {{--{name: 'links', items: ['Link', 'Unlink']},--}}
                {{--{--}}
                    {{--name: 'insert',--}}
                    {{--items: ['Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']--}}
                {{--},--}}
                {{--'/',--}}
                {{--{name: 'styles', items: ['Format', 'Font', 'FontSize']},--}}
                {{--{name: 'colors', items: ['TextColor', 'BGColor']},--}}
                {{--{name: 'tools', items: ['Maximize', 'ShowBlocks']},--}}
                {{--{name: 'others', items: ['-']},--}}
            {{--]--}}
        {{--};--}}
        {{--CKEDITOR.replace('mission', options);--}}
        {{--CKEDITOR.replace('about', options);--}}

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
    <script>
        $('.addCopy').click(function () {
            var clone = $(this).siblings('.partnerBlock.firstChild').clone();
            clone.removeClass('firstChild');
            clone.appendTo($(this).siblings('.inBlock'));
        });
        $('select#status').change(function(){
            if($(this).val() == 'finished'){
                $('.finishedDateBlock').removeClass('d-none');
            }else{
                $('.finishedDateBlock').addClass('d-none');
            }
        });
    </script>
    <style>
        .fa-angle-up {
            float: right;
        }
        .collapsed .fa-angle-up::before {
            content: "\f107";
        }
        .partnerBlock {
            display: table;
            border: 1px solid #eee;
            width: 100%;
            padding: 25px;
            margin: 0 0 15px;
            box-shadow: 0 5px 13px #eee;
            background: #eee;
            border-radius: 5px;
            position: relative;
        }
        .partnerBlock .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 26px;
        }
        .partnerBlock.firstChild .close {
            display: none;
        }
    </style>
@endsection
