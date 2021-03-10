@extends('backend.fond_cabinet.layout')

@section('fond_content')
        <div class="container-fluid default myOrganizationContent">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="greyInfoBlock firstBig">
                            <form action="{{route('fond_setting')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-3">
                                        @if(Auth::user()->logo)
                                            <img src="{{Auth::user()->logo}}" alt="" class="logotype">
                                        @else
                                            <img src="/img/no-photo.png" alt="" class="logotype">
                                        @endif
                                        <input type="file" class="form-control mt-3" name="logo">
                                            @if($errors->has('logo'))
                                                <span class="error">{{ $errors->first('logo') }}</span>
                                            @endif
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <label for="">Название организации</label>
                                            <input type="text" name="title" value="{{Auth::user()->title}}" class="form-control">
                                            @if($errors->has('title'))
                                                <span class="error">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">БИН</label>
                                            <input type="text" value="{{Auth::user()->bin}}" disabled class="form-control">
                                            @if($errors->has('bin'))
                                                <span class="error">{{ $errors->first('bin') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">Сайт:</label>
                                            <input type="text" name="website" value="{{Auth::user()->website}}" class="form-control">
                                            @if($errors->has('website'))
                                                <span class="error">{{ $errors->first('website') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">Телефон:</label>
                                            <input type="text" name="phone" value="{{Auth::user()->phone}}" class="form-control">
                                            @if($errors->has('phone'))
                                                <span class="error">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">Почта:</label>
                                            <input type="text" name="email" value="{{Auth::user()->email}}" class="form-control">
                                            @if($errors->has('email'))
                                                <span class="error">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">Адрес:</label>
                                            <input type="text" name="address" value="{{Auth::user()->address}}" class="form-control">
                                            @if($errors->has('address'))
                                                <span class="error">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">Соц. сети:</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Миссия:</label>
                                            <textarea name="mission" id="mission" class="form-control" cols="30" rows="10">
                                                {{Auth::user()->mission}}
                                             </textarea>
                                            @if($errors->has('mission'))
                                                <span class="error">{{ $errors->first('mission') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">О нас:</label>
                                            <textarea name="about" id="about" class="form-control" cols="30" rows="10">
                                                {{Auth::user()->about}}
                                            </textarea>
                                            @if($errors->has('about'))
                                                <span class="error">{{ $errors->first('about') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group pb-5">
                                            <label for="">Реквизиты:</label>
                                            <?php $requisites =[]; ?>
                                        @if(Auth::user()->requisites)
                                            <?php
                                            $requisites = json_decode(Auth::user()->requisites, true);
                                            ?>
                                            @foreach($requisites as $i=> $requisite)
                                                    <textarea name="requisites[]" id="requisites{{$i}}" class="requisites form-control" cols="30" rows="10">{{$requisite['body']}}</textarea>
                                            @endforeach
                                        @else
                                                <textarea name="requisites[]" id="requisites0" class="requisites form-control" cols="30" rows="10"></textarea>
                                        @endif
                                                <button class="btn btn-default float-right mt-2 mb-5 d-table" onclick="var $div = $(this).prev(); var num = parseInt( $div.prop('id').match(/\d+/g), 10 ) +1; $('<textarea name=\'requisites[]\' id=\'requisites'+num+'\' class=\'requisites form-control\'></textarea>').insertAfter($(this).prev()); ckeditor('requisites'+num ); return false;">+ добавить еще один счет</button>
                                            </div>
                                        <div class="form-group">
                                            <label for="">Укажите расположение организации:</label>
                                            <input type="hidden" name="longitude" value="{{Auth::user()->longitude}}" id="longitude">
                                            <input type="hidden" name="latitude" value="{{Auth::user()->latitude}}" id="latitude">
                                            <div id="map" class="w-100" style="height: 300px;"></div>
                                        </div>
                                        <input type="submit" class="btn btn-default" value="Сохранить">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
                    <script>
                        var options = {
                            toolbar: [
                                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'Undo', 'Redo' ] },
                                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                                { name: 'links', items: [ 'Link', 'Unlink' ] },
                                { name: 'insert', items: ['Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                                '/',
                                { name: 'styles', items: ['Format', 'Font', 'FontSize' ] },
                                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                                { name: 'others', items: [ '-' ] },
                            ]
                        };
                        CKEDITOR.replace('mission',options);
                        CKEDITOR.replace('about',options);
                        @if(count($requisites)>0)
                            @foreach($requisites as $i => $requisite)
                        CKEDITOR.replace('requisites{{$i}}',options);
                            @endforeach
                        @else
                        CKEDITOR.replace('requisites0',options);
                        @endif

                        function ckeditor(id){
                            CKEDITOR.replace(id,options);
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
                    <div class="col-sm-4">
                        <div class="greyContent">
                            <div class="miniStatusBlock">
                                <p class="greyText">Общий рейтинг:: <span class="green">95%</span></p>
                            </div>
                            <p class="date">Смотреть историю по годам:</p>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    2010-2020
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">2010-2020</a>
                                    <a class="dropdown-item" href="#">2010-2020</a>
                                    <a class="dropdown-item" href="#">2010-2020</a>
                                </div>
                            </div>
                            <div class="content">
                                <p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>
                                <p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>
                                <p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>
                                <p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>
                                <p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>
                                <p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>
                                <p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>
                                <p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>
                                <a href="">Посмотреть похожие благотворительные организации</a>
                                <a href="">Больше аналитики</a>
                                <a href="">Как можно улучшить показатели?</a>
                                <a href="">Из чего формируется рейтинг?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
