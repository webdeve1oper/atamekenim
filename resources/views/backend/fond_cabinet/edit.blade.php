@extends('backend.fond_cabinet.setting')

@section('setting_content')
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
                    <input type="text" name="title" value="{{Auth::user()->title}}"
                           class="form-control">
                    @if($errors->has('title'))
                        <span class="error">{{ $errors->first('title') }}</span>
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
                    <label for="">Название организации на казахском языке:*
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
                    @if($errors->has('bin'))
                        <span class="error">{{ $errors->first('bin') }}</span>
                    @endif
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
            <div class="col-sm-6 ">
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
                                        <?php
                                        $socials = json_decode(Auth::user()->social, true);
                                        ?>
                                        @foreach($socials as $i=> $social)
                                                <div class="form-group">
                                                    <label for="">{{$social['name']}}:</label>
                                                    <input type="text" name="socials[]" value="{{$social['link']}}"
                                                           class="form-control">
                                                </div>
                                        @endforeach
                                    @else
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
                                <div class="form-group">
                                                        <textarea name="mission" id="mission" class="form-control"
                                                                  cols="30" rows="10">
                                                            {{Auth::user()->mission}}
                                                         </textarea>
                                    @if($errors->has('mission'))
                                        <span class="error">{{ $errors->first('mission') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse3">О нас <i
                                        class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="form-group">
                                            <textarea name="about" id="about" class="form-control" cols="30" rows="10">
                                                {{Auth::user()->about}}
                                            </textarea>
                                    @if($errors->has('about'))
                                        <span class="error">{{ $errors->first('about') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse1">Реквизиты
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
                                                    <textarea name="requisites[]"
                                                              id="requisites{{$i}}"
                                                              class="requisites form-control"
                                                              cols="30"
                                                              rows="10">{{$requisite['body']}}</textarea>
                                                @endforeach
                                            @else
                                                <textarea name="requisites[]" id="requisites0"
                                                          class="requisites form-control" cols="30"
                                                          rows="10"></textarea>
                                            @endif
                                            <button class="btn btn-default float-right mt-2 mb-5 d-table"
                                                    onclick="var $div = $(this).prev(); var num = parseInt( $div.prop('id').match(/\d+/g), 10 ) +1; $('<textarea name=\'requisites[]\' id=\'requisites'+num+'\' class=\'requisites form-control\'></textarea>').insertAfter($(this).prev()); ckeditor('requisites'+num ); return false;">
                                                + добавить еще один счет
                                            </button>
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
                            <a data-toggle="collapse" class="collapsed" href="#collapse11">Центральный
                                офис <i class="fas fa-angle-up"></i></a>
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
                                                    <textarea name="offices[]" id="offices{{$i}}"
                                                              class="requisites form-control"
                                                              cols="30"
                                                              rows="10">{{$requisite['body']}}</textarea>
                                                @endforeach
                                            @else
                                                <textarea name="offices[]" id="offices0"
                                                          class="requisites form-control" cols="30"
                                                          rows="10"></textarea>
                                            @endif
                                            <button class="btn btn-default float-right mt-2 mb-5 d-table"
                                                    onclick="var $div = $(this).prev(); var num = parseInt( $div.prop('id').match(/\d+/g), 10 ) +1; $('<textarea name=\'offices[]\' id=\'offices'+num+'\' class=\'requisites form-control\'></textarea>').insertAfter($(this).prev()); ckeditor('offices'+num ); return false;">
                                                + добавить еще один центральный офис
                                            </button>
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
                            <a data-toggle="collapse" class="collapsed" href="#collapse12">Филиал <i
                                        class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse12" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 d-table">
                                        <div class="form-group pb-5">
                                            <?php $affilates = []; ?>
                                            @if(Auth::user()->affilates)
                                                <?php
                                                $affilates = json_decode(Auth::user()->affilates, true);
                                                ?>
                                                @foreach($affilates as $i=> $requisite)
                                                    <textarea name="affilates[]"
                                                              id="affilates{{$i}}"
                                                              class="requisites form-control"
                                                              cols="30"
                                                              rows="10">{{$requisite['body']}}</textarea>
                                                @endforeach
                                            @else
                                                <textarea name="affilates[]" id="affilates0"
                                                          class="requisites form-control"
                                                          cols="30" rows="10"></textarea>
                                            @endif
                                            <button class="btn btn-default float-right mt-2 mb-5 d-table"
                                                    onclick="var $div = $(this).prev(); var num = parseInt( $div.prop('id').match(/\d+/g), 10 ) +1; $('<textarea name=\'affilates[]\' id=\'affilates'+num+'\' class=\'requisites form-control\'></textarea>').insertAfter($(this).prev()); ckeditor('affilates'+num ); return false;">
                                                + добавить еще один филиал
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 pl-0">
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse15">Виды оказываемой помощи <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse15" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $cashHelpTypess = [];
                                        if(Auth::user()->cashHelpTypes){
                                            $cashHelpTypess = array_column(Auth::user()->cashHelpTypes->toArray(), 'name_ru');
                                        }
                                        ?>
                                        @php $i = 0 @endphp
                                        @foreach($cashHelpTypes as $destination)
                                            <div class="checkbox">
                                                <input type="checkbox" @if(in_array($destination['name_ru'], $cashHelpTypess)) checked
                                                       @endif name="cashHelpTypes[]" value="{{$destination['id']}}" id="cashHelpTypes{{$destination['id']}}">
                                                <label for="cashHelpTypes{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse16">Выберите размер оказываемой помощи (выберите один или несколько вариантов) *<i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse16" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $cashHelpSizess = [];
                                        if(Auth::user()->cashHelpSizes){
                                            $cashHelpSizess = array_column(Auth::user()->cashHelpSizes->toArray(), 'name_ru');
                                        }
                                        ?>
                                        @php $i = 0 @endphp
                                        @foreach($cashHelpSizes as $destination)
                                            @if($i != $destination->paren_id )
                                                @php $i = $destination->paren_id @endphp
                                            @endif
                                            <div class="checkbox">
                                                <input type="checkbox" @if(in_array($destination['name_ru'], $cashHelpSizess)) checked
                                                       @endif name="cashHelpTypes[]" value="{{$destination['id']}}" id="cashHelpTypes{{$destination['id']}}">
                                                <label for="cashHelpTypes{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse13">Адресаты <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse13" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $destinationss = [];
                                        if(Auth::user()->destinations){
                                            $destinationss = array_column(Auth::user()->destinations->toArray(), 'name_ru');
                                        }
                                        ?>
                                    @php $i = 0 @endphp
                                    <p><b>{{config('destinations')[$i]}}</b></p>
                                    @foreach($destinations as $destination)
                                        @if($i != $destination->paren_id )
                                            @php $i = $destination->paren_id @endphp
                                            <p><b>{{config('destinations')[$i]}}</b></p>
                                        @endif
                                        <div class="checkbox">
                                            <input type="checkbox" @if(in_array($destination['name_ru'], $destinationss)) checked
                                                   @endif name="destinations[]" value="{{$destination['id']}}" id="destinations{{$destination['id']}}">
                                            <label for="destinations{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse2">Сфера
                                оказываемой помощи <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <?php $baseHelpTypess = array_column(Auth::user()->baseHelpTypes->toArray(), 'name_ru');?>
                                    @foreach($baseHelpTypes as $destination)
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input @if(in_array($destination['name_ru'], $baseHelpTypess)) checked
                                                           @endif type="checkbox" id="base_help_types{{$destination['id']}}" name="base_help_types[]"
                                                           value="{{$destination['id']}}"> {{$destination['name_ru']}}
                                                </label>
                                            </div>
                                            {{--@foreach($destination['children'] as $key => $help)--}}
                                                {{--<div class="checkbox">--}}
                                                    {{--<label>--}}
                                                        {{--<input onChange="this.checked? $('#base_help_types{{$help["base_help_types_id"]}}').prop('checked', true): '';" @if(in_array($help['name_ru'], $baseHelpTypess)) checked--}}
                                                               {{--@endif type="checkbox" name="base_help_types[]"--}}
                                                               {{--value="{{$help['id']}}"> {{$help['name_ru']}}--}}
                                                    {{--</label>--}}
                                                {{--</div>--}}
                                            {{--@endforeach--}}
                                            {{--<hr>--}}
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
                            <a data-toggle="collapse" class="collapsed" href="#collapse6">Дополнительные
                                сферы оказываемой помощи <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse6" class="panel-collapse collapse">
                            <div class="card-body">
                                <?php $addHelpTypess = array_column(Auth::user()->addHelpTypes->toArray(), 'name_ru'); ?>

                                <div class="row">
                                    @foreach($baseHelpTypes as $destination)
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input @if(in_array($destination['name_ru'], $addHelpTypess)) checked
                                                           @endif type="checkbox"  id="add_help_types{{$destination['id']}}" name="add_help_types[]"
                                                           value="{{$destination['id']}}"> {{$destination['name_ru']}}
                                                </label>
                                            </div>
                                            {{--@foreach($destination['children'] as $key => $help)--}}
                                                {{--<div class="checkbox">--}}
                                                    {{--<label>--}}
                                                        {{--<input  onChange="this.checked? $('#add_help_types{{$help["base_help_types_id"]}}').prop('checked', true): '';" @if(in_array($help['name_ru'], $addHelpTypess)) checked--}}
                                                               {{--@endif type="checkbox" name="add_help_types[]"--}}
                                                               {{--value="{{$help['id']}}"> {{$help['name_ru']}}--}}
                                                    {{--</label>--}}
                                                {{--</div>--}}
                                            {{--@endforeach--}}
                                            {{--<hr>--}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
        var json = {!! $regions->toJson() !!};
        $('#regions').select2({
            width: '100%',
            placeholder: 'Область'
        });
        $('#cities').select2({
            width: '100%',
            placeholder: 'Выберите город'
        });
        $('#regions').change(function(){
            var ind = $('#regions').children('option:selected').val();
            var datas = [];
            json.forEach(function(value,index){
                if(value.region_id == ind){
                    ind = index;
                }
            });

            $('#cities').empty();
            datas.push({id:'0', text: '-'});
            for (let [key, value] of Object.entries(json[ind].cities)){
                datas.push({id:value.id, text: value.text});
            }
            $('#cities').select2({data: datas, allowClear: true});
        });
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
        @if(count($requisites)>0)
        @foreach($requisites as $i => $requisite)
        CKEDITOR.replace('requisites{{$i}}', options);
        @endforeach
        @else
        CKEDITOR.replace('requisites0', options);
        @endif

        @if(count($offices)>0)
        @foreach($offices as $i => $requisite)
        CKEDITOR.replace('offices{{$i}}', options);
        @endforeach
        @else
        CKEDITOR.replace('offices0', options);
        @endif

        @if(count($affilates)>0)
        @foreach($affilates as $i => $requisite)
        CKEDITOR.replace('affilates{{$i}}', options);
        @endforeach
        @else
        CKEDITOR.replace('affilates0', options);

        @endif

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
