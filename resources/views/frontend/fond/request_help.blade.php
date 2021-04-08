@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" />
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
                                    <div class="form-group">
                                        <label for="who_need_help">Кому нужна помощь:</label>
                                        <select name="who_need_help" id="who_need_help" class="form-control">
                                            @foreach($scenarios as $value => $scenario)
                                                <option value="{{$scenario['id']}}">{{$scenario['name_'.app()->getLocale()] ?? $scenario['name_ru']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!--destination 1-->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="destinations1">Выберите подходящий статус получателя помощи* (выберите один или несколько вариантов)</label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="Выберите подходящий статус получателя помощи* " id="destinations1">
                                        </select>
                                        <small class="form-text text-muted">Укажите адресата помощи</small>
                                    </div>
                                </div>

                                <!--destination 2-->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="destinations2">Отметьте при необходимости жизненную ситуацию получателя помощи (выберите один или несколько вариантов)</label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="Отметьте при необходимости жизненную ситуацию получателя помощи (выберите один или несколько вариантов)" id="destinations2">

                                        </select>
                                        <small class="form-text text-muted">Укажите адресата помощи</small>
                                    </div>
                                </div>

                                <!--destination 3-->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="destinations3">Отметьте при необходимости происхождение получателя помощи (только один вариант из предложенных)</label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="Отметьте при необходимости происхождение получателя помощи (только один вариант из предложенных)" id="destinations3">

                                        </select>
                                        <small class="form-text text-muted">Укажите адресата помощи</small>
                                    </div>
                                </div>

                                <!--destination 4-->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="destinations4">Отметьте при необходимости статус по здоровью получателя помощи (выберите один или несколько вариантов)</label>
                                        <select name="destinations[]" class="select2 w-100" multiple placeholder="Отметьте при необходимости статус по здоровью получателя помощи (выберите один или несколько вариантов)" id="destinations4">

                                        </select>
                                        <small class="form-text text-muted">Укажите адресата помощи</small>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="regions">В каком регионе необходима помощь:</label>
                                        <select name="region_id" class="select2 w-100" placeholder="Тип помощи" id="regions">
                                            @foreach($regions as $region)
                                                <option value="{{$region->region_id}}">{{$region->text}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Район</label>
                                        <select name="districts[]" class="select2 w-100" placeholder="Тип помощи" id="districts"></select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Город/Село</label>
                                        <select name="cities[]" class="select2 w-100" placeholder="Тип помощи" id="cities"></select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="baseHelpTypes">Какая помощь необходима:</label>
                                <select name="baseHelpTypes[]" class="select2 w-100" multiple placeholder="Сфера необходимой помощи" id="baseHelpTypes">
                                    @foreach($baseHelpTypes as $destionation)
                                        <option value="{{$destionation->id}}">{{$destionation->name_ru}}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Сфера необходимой помощи</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Виды оказываемой помощи (выберите один или несколько):</label>
                                <select name="cashHelpTypes[]" class="select2 w-100" multiple placeholder="Виды оказываемой помощи" id="cashHelpTypes">
                                    @foreach($cashHelpTypes as $destination)
                                        <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Укажите тпи помощи</small>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Укажите срочность необходимой помощи* :</label>
                                <select name="helpUrgencyDate" class="select2 w-100" placeholder="Укажите срочность необходимой помощи" id="helpUrgencyDate">
                                    <option value="1">в течение 1 месяца</option>
                                    <option value="2">в течение 3 месяцев</option>
                                    <option value="3">в течение 6 месяцев</option>
                                    <option value="4">в течение 1 года</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Прикрепите фото/видео получателя помощи или его проблемы:</label>
                                <br><br>
                                <input type="file" id="file" name="photo[]"><br><br>
                                <input type="text" name="videoUrl" placeholder="Ссылка на видео">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Прикрепите при необходимости подтверждающие документы по запрашиваемой помощи (например, медицинские справки, выписки, справка с места учебы, работы и т.д.) Укажите название документа и прикрепите файл в формате doc, jpeg или pdf.:</label>
                                <br>
                                <input type="file" id="file" name="doc[]">
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Необхадимая сумма:</label>
                                <select name="cashHelpSizes[]" class="select2 w-100" placeholder="Виды оказываемой помощи" id="cashHelpSizes">
                                    @foreach($cashHelpSizes as $destination)
                                        <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <script>
                                var json = {!! $regions->toJson() !!};
                                var jsonHelps = {!! $baseHelpTypes->toJson() !!};
                                var scenarios = {!! json_encode($scenarios) !!};
                                $('#destionations').select2({
                                    width: '100%',
                                    placeholder: 'Адресат помощи'
                                });
                                $('#regions').select2({
                                    width: '100%',
                                    placeholder: 'Область'
                                });
                                $('#cities').select2({
                                    width: '100%',
                                    placeholder: 'Город/Село'
                                });
                                $('#cashHelpTypes').select2({
                                    width: '100%',
                                    placeholder: 'Виды оказываемой помощи'
                                });
                                $('#cashHelpSizes').select2({
                                    width: '100%',
                                    placeholder: 'Виды оказываемой помощи'
                                });
                                $('#helpUrgencyDate').select2({
                                    width: '100%',
                                    placeholder: 'Виды оказываемой помощи'
                                });
                                $('#baseHelpTypes').select2({
                                    width: '100%',
                                    placeholder: 'Сфера необходимой помощи'
                                });
                                $('#baseHelp').select2({
                                    width: '100%',
                                    placeholder: 'Выберите сектор помощи'
                                });
                                $('#addHelp').select2({
                                    width: '100%',
                                    placeholder: 'Выберите подробный сектор помощи'
                                });
                                console.log(jsonHelps);

                                $('#who_need_help').change(function(){
                                    var scenario_id = $('#who_need_help').children('option:selected').val();
                                    var datas = [];
                                    var firstDestinations = [];
                                    var secondDestinations = [];
                                    var thirdDestinations = [];
                                    var fourDestinations = [];
                                    var scenario_index = 0;
                                    scenarios.forEach(function(value,index){
                                        if(value.id == scenario_id){
                                            scenario_index = index;
                                        }
                                    });
                                    $('#destinations1').empty();
                                    $('#destinations2').empty();
                                    $('#destinations3').empty();
                                    $('#destinations4').empty();
                                    firstDestinations.push({id:'0', text: '-'});
                                    secondDestinations.push({id:'0', text: '-'});
                                    thirdDestinations.push({id:'0', text: '-'});
                                    fourDestinations.push({id:'0', text: '-'});
                                    for (let [key, value] of Object.entries(scenarios[scenario_index].destinations)){
                                        if(value.parent_id == 0 ){
                                            firstDestinations.push({id:value.id, text: value.name_ru});
                                        }
                                        if(value.parent_id == 1 ){
                                            secondDestinations.push({id:value.id, text: value.name_ru});
                                        }
                                        if(value.parent_id == 2 ){
                                            thirdDestinations.push({id:value.id, text: value.name_ru});
                                        }
                                        if(value.parent_id == 3 ){
                                            fourDestinations.push({id:value.id, text: value.name_ru});
                                        }
                                    }
                                    $('#destinations1').select2({data: firstDestinations, allowClear: true});
                                    $('#destinations2').select2({data: secondDestinations, allowClear: true});
                                    $('#destinations3').select2({data: thirdDestinations, allowClear: true});
                                    $('#destinations4').select2({data: fourDestinations, allowClear: true});

                                    var datas2 = [];
                                    $('#baseHelpTypes').empty();
                                    datas2.push({id:'0', text: '-'});
                                    for (let [key, value] of Object.entries(scenarios[scenario_index].add_help_types)){
                                        datas2.push({id:value.id, text: value.name_ru});
                                    }
                                    $('#baseHelpTypes').select2({data: datas2, allowClear: true});
                                });




                                $('#regions').change(function(){
                                    var ind = $('#regions').children('option:selected').val();
                                    var datas = [];
                                    json.forEach(function(value,index){
                                        if(value.region_id == ind){
                                            ind = index;
                                        }
                                    });

                                    $('#districts').empty();
                                    datas.push({id:'0', text: '-'});
                                    for (let [key, value] of Object.entries(json[ind].districts)){
                                        datas.push({id:value.district_id, text: value.text});
                                    }
                                    $('#districts').select2({data: datas, allowClear: true});
                                });

                                $('#districts').change(function(){
                                    var region_id = $('#regions').children('option:selected').val();
                                    var district_id = $('#districts').children('option:selected').val();
                                    var datas = [];
                                    json.forEach(function(value,index){
                                        if(value.region_id == region_id){
                                            region_id = index;
                                            value.districts.forEach(function(v,i){
                                                if(v.district_id == district_id){
                                                    district_id = i;
                                                }
                                            });
                                        }
                                    });

                                    $('#cities').empty();
                                    datas.push({id:'0', text: '-'});
                                    for (let [key, value] of Object.entries(json[region_id].districts[district_id].cities)){
                                        datas.push({id:value.city_id, text: value.title_ru});
                                    }
                                    $('#cities').select2({data: datas, allowClear: true});
                                });

                                $(document).ready(function () {
                                    $("#who_need_help option:first").change();
                                });
                            </script>
                            <textarea name="body" placeholder="Описание помощи" class="form-control mb-3" id="helpBody" cols="30" rows="10">{{old('body')}}</textarea>
                            <input type="submit" class="btn btn-primary m-auto d-table" value="Найти">
                        </form>
                        <script>
                            $('#request_help').submit(function(){
                               $.ajax({
                                  method: 'post',
                                   url: '{{route('request_help')}}',
                                   data: $('request_help').serialize(),
                                   success: function(data){
                                       console.log(data);
                                   }
                               });
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
