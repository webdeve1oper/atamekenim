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
                                            @foreach(config('destinations_attribute') as $value=> $title)
                                                <option value="{{$value}}">{{$title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="destionations">Адресат помощи (выберите один или несколько):</label>
                                        @php $i = 0 @endphp
                                        <select name="destionations[]" class="select2 w-100" multiple placeholder="Адресат помощи" id="destionations">
                                            @foreach($destinations as $destination)
                                                @if($loop->index == 0)
                                                    <optgroup label="{{config('destinations')[$i]}}">
                                                        @endif
                                                        @if($i != $destination->paren_id )
                                                            @php $i = $destination->paren_id @endphp
                                                            <optgroup label="{{config('destinations')[$i]}}">
                                                                @endif
                                                                <option value="{{$destination->id}}">{{$destination->name_ru}}</option>
                                                                @if($i != $destination->paren_id )
                                                            </optgroup>
                                                @endif
                                            @endforeach
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
                                        <label for="">Город/Село</label>
                                        <select name="cities[]" class="select2 w-100" placeholder="Тип помощи" id="cities"></select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="baseHelpTypes">Какая помощь необходима:</label>
                                <select name="baseHelpTypes[]" class="select2 w-100" multiple placeholder="Сфера необходимой помощи" id="baseHelpTypes">
                                    @foreach($baseHelpTypes as $destionation)
                                        <option value="{{$destionation->id}}">{{$destionation->name_ru}} (
                                            @foreach($destionation->children as $child)
                                                {{$child->name_ru}}@if(!$loop->last),@endif
                                            @endforeach
                                            )</option>
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
                                console.log(jsonHelps);
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
