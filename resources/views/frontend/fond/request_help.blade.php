@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous"/>
    <div class="fatherBlock">
        <div class="container-fluid default breadCrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href="/">Главная</a></li>
                            <li><a href="{{route('fonds')}}">Реестр благотворительных организаций</a></li>
                            <li><a href="#">Подать заявку на получение помощи</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default organInfoBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Подать заявку на получение помощи</h1>
                        <form action="{{route('helpfond')}}" method="post" id="request_help">
                            @csrf
                            @if($errors->has('title'))
                                <span class="error">{{ $errors->first('title') }}</span>
                            @endif
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <label for="who_need_help">Кому необходима помощь?*</label>
                                        <select name="who_need_help" id="who_need_help" class="form-control">
                                            @foreach($scenarios as $value => $scenario)
                                                <option value="{{$scenario['id']}}">{{$scenario['name_'.app()->getLocale()] ?? $scenario['name_ru']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!--destination 1-->
                                <div class="col-sm-12 destinations1">
                                    <div class="form-group mb-4 ">
                                        <label for="destinations1">Выберите подходящий статус получателя помощи* (выберите один или несколько вариантов)</label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="Выберите подходящий статус получателя помощи* " id="destinations1"></select>
                                    </div>
                                </div>

                                <!--destination 2-->
                                <div class="col-sm-12 destinations2">
                                    <div class="form-group mb-4">
                                        <label for="destinations2">Отметьте при необходимости жизненную ситуацию получателя помощи (выберите один или несколько вариантов)</label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="Отметьте при необходимости жизненную ситуацию получателя помощи (выберите один или несколько вариантов)" id="destinations2"></select>
                                    </div>
                                </div>

                                <!--destination 3-->
                                <div class="col-sm-12 destinations3">
                                    <div class="form-group mb-4">
                                        <label for="destinations3">Отметьте при необходимости происхождение получателя помощи (только один вариант из предложенных)</label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="Отметьте при необходимости происхождение получателя помощи (только один вариант из предложенных)" id="destinations3"></select>
                                    </div>
                                </div>

                                <!--destination 4-->
                                <div class="col-sm-12 destinations4">
                                    <div class="form-group mb-4">
                                        <label for="destinations4">Отметьте при необходимости статус по здоровью получателя помощи (выберите один или несколько вариантов)</label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="Отметьте при необходимости статус по здоровью получателя помощи (выберите один или несколько вариантов)" id="destinations4"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 regions">
                                    <div class="form-group mb-4">
                                        <label for="regions">Укажите место оказания помощи?* </label>
                                        <select name="region_id" class="select2 w-100" placeholder="Тип помощи" id="regions">
                                            @foreach($regions as $region)
                                                <option value="{{$region->region_id}}">{{$region->text}}</option>
                                            @endforeach
                                        </select>
                                        <small>название населенного пункта</small>
                                    </div>
                                </div>

                                <div class="col-sm-4 districts" style="display: none">
                                    <div class="form-group mb-4">
                                        <label for="">Район</label>
                                        <select name="districts[]" class="select2 w-100" placeholder="Тип помощи" id="districts"></select>
                                    </div>
                                </div>

                                <div class="col-sm-4 cities" style="display: none">
                                    <div class="form-group mb-4">
                                        <label for="">Город/Село</label>
                                        <select name="cities[]" class="select2 w-100" placeholder="Тип помощи" id="cities"></select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mb-4 baseHelpTypes">
                                <label for="baseHelpTypes">Отметьте сферу необходимой помощи* (один вариант из предложенных)</label>
                                <select name="baseHelpTypes[]" class="select2 w-100" placeholder="Сфера необходимой помощи" id="baseHelpTypes">
                                    @foreach($baseHelpTypes as $destionation)
                                        <option value="{{$destionation->id}}">{{$destionation->name_ru}}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Сфера необходимой помощи</small>
                            </div>

                            <div class="form-group mb-4 cashHelpTypes">
                                <label for="exampleInputEmail1">Отметьте вид необходимой помощи * (выберите один или несколько вариантов)</label>
                                <select name="cashHelpTypes[]" class="select2 w-100" multiple placeholder="Виды оказываемой помощи" id="cashHelpTypes">
                                    @foreach($cashHelpTypes as $destination)
                                        <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4 cashHelpSizes">
                                <label for="exampleInputEmail1">Укажите сумму необходимой помощи* (один вариант из предложенных):</label>
                                <select name="cashHelpSizes[]" class="select2 w-100" placeholder="Виды оказываемой помощи" id="cashHelpSizes">
                                    @foreach($cashHelpSizes as $destination)
                                        <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="exampleInputEmail1">Укажите срочность необходимой помощи* :</label>
                                <select name="helpUrgencyDate" class="select2 w-100" placeholder="Укажите срочность необходимой помощи" id="helpUrgencyDate">
                                    <option value="1">в течение 1 месяца</option>
                                    <option value="2">в течение 3 месяцев</option>
                                    <option value="3">в течение 6 месяцев</option>
                                    <option value="4">в течение 1 года</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="exampleInputEmail1">Прикрепите фото/видео получателя помощи или его проблемы:</label>
                                <br>
                                <div class="input-group">
                                    <input type="file" id="file" name="photo[]" class="form-control photo">
                                    <div class="input-group-append" style="display: none;">
                                        <button class="btn btn-default p-2" type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-default p-2 mt-2" onclick="if($('.photo').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();} return false;">+ Добавить еще</button>
                            </div>

                            <div class="form-group mb-4">
                                <label for="">Видео (загрузите ссылку на видеообращение в социальных сетях или средствах массовой информации)</label>
                                <input type="text" name="videoUrl" class="form-control" placeholder="Ссылка на видео">
                            </div>

                            <div class="form-group mb-4">
                                <label for="exampleInputEmail1">Прикрепите при необходимости подтверждающие документы по запрашиваемой помощи (например, медицинские справки, выписки, справка с места учебы, работы и т.д.) Укажите название документа и
                                    прикрепите файл в формате doc, jpeg или pdf.:</label>
                                <br>
                                <div class="input-group">
                                    <input type="file"  class="form-control docs" name="doc[]">
                                    <div class="input-group-append" style="display: none;">
                                        <button class="btn btn-default p-2" type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-default p-2 mt-2" onclick="if($('.docs').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();} return false;">+ Добавить еще</button>
                            </div>

                            <textarea name="body" placeholder="Описание помощи" class="form-control mb-3" id="helpBody" cols="20" rows="10">{{old('body')}}</textarea>
                            <input type="submit" class="btn btn-default m-auto d-table" value="Найти">
                        </form>
                        @include('frontend.fond.script')
                        <script>
                            $('#request_help').submit(function () {
                                $.ajax({
                                    method: 'get',
                                    url: '{{route('request_help')}}',
                                    data: $('#request_help').serialize(),
                                    success: function (data) {
                                        console.log(data);
                                    }
                                });
                                return false;
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<?php
$script = "<script>
    $(document).ready(function () {
        $('.newsSlick').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [
                {
                    breakpoint: 679,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        rows: 1,
                        infinite: true,
                    }
                }
            ]
        });
    });
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js' integrity='sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==' crossorigin='anonymous'></script>
";
?>

@extends('frontend.layout', ['script'=>$script])
