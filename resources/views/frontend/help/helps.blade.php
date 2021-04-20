@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default organizationsInBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="applicationSearchBlock">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h1>{{trans('help-search.reestr-appl')}}</h1>
                                    <form action="{{route('helps')}}" id="helpsSearch">
                                        @csrf
                                        <div class="searchBlock">
                                            <input type="text" placeholder="{{trans('help-search.search-fond')}}">
                                            <button class="btn-default blue">{{trans('help-search.find')}}</button>
                                        </div>
                                        <ul>
                                            <li>
                                                <input type="checkbox" id="check1">
                                                <label for="check1" onclick="$(this).toggleClass('active');">{{trans('help-search.new-appl')}}</label>
                                            </li>
                                            @foreach($baseHelpTypes as $help)
                                                <li>
                                                    <label type="checkbox" id="check{{$help->id}}">{{$help['name_'.app()->getLocale()]}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <a class="btn-default transparent" onclick="$(this).hide();$('.selectBlock').show();$('.rangeBarBlock').show();">{{trans('help-search.ras-search')}} <i class="fas fa-chevron-down"></i></a>
                                        <div class="selectBlock">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{trans('fonds.adresat')}}:
                                                </button>
                                                <div class="dropdown-menu checkbox-menu allow-focus p-2" aria-labelledby="dropdownMenuButton1">
                                                    @foreach($destionations as $destination)
                                                        <div class="content" >
                                                            <input type="checkbox" name="destination[]" value="{{$destination['id']}}" id="destination{{$destination['id']}}">
                                                            <label for="destination{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            {{--<div class="dropdown">--}}
                                                {{--<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                                    {{--Характеристика адресата/благополучателя:--}}
                                                {{--</button>--}}
                                                {{--<div class="dropdown-menu checkbox-menu allow-focus p-2" aria-labelledby="dropdownMenuButton2">--}}
                                                    {{--@foreach($destionationsAttributes as  $destination)--}}
                                                        {{--<div class="content">--}}
                                                            {{--<input type="checkbox" name="destination_attribute[]" value="{{$destination['id']}}" id="destination_attribute{{$destination['id']}}">--}}
                                                            {{--<label for="destination_attribute{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>--}}
                                                        {{--</div>--}}
                                                    {{--@endforeach--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            <div class="dropdown regions">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{trans('fonds.regions')}}:
                                                </button>
                                                <div class="dropdown-menu checkbox-menu allow-focus p-2" aria-labelledby="dropdownMenuButton3">
                                                    @foreach($regions as $id => $city)
                                                        <div class="content"><input type="checkbox" name="regions[]" id="regions{{$id}}" value="{{$id}}">
                                                            <label for="regions{{$id}}">&nbsp;{{$city}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <style>
                                                .regions .dropdown-menu{
                                                    max-height: 300px;
                                                    overflow: auto;
                                                    width: 326px;
                                                }
                                            </style>
                                            <div class="dropdown d-none">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{('help-search.choice-distance')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{trans('help-search.place-help')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown d-none">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{('help-search.status-tjs')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{('help-search.cat-help')}}
                                                </button>
                                                <div class="dropdown-menu checkbox-menu allow-focus p-2" aria-labelledby="dropdownMenuButton9">
                                                    @foreach($baseHelpTypes as $help)
                                                        <div class="content">
                                                            <input type="checkbox" name="baseHelpTypes[]" id="baseHelpTypes{{$help->id}}" value="{{$help->id}}">
                                                            <label for="baseHelpTypes{{$help->id}}"> {{$help['name_'.app()->getLocale()]}}</label></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="dropdown d-none">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{('help-search.urgency')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown d-none">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton9" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{('help-search.date-appl')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton9">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rangeBarBlock">
                                            <p class="rangeName">{{trans('help-search.summ-help')}}</p>
                                            <div class="rangeBlock"></div>
                                            <div class="inputBlock">
                                                <input type="checkbox" id="checker">
                                                <label for="checker">{{trans('help-search.repeat')}}</label>
                                            </div>
                                            <button class="btn-default blue">{{trans('help-search.find')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="row">

                                @include('frontend.help.help_list')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .checkbox-menu li label {
            display: block;
            padding: 3px 10px;
            clear: both;
            font-weight: normal;
            color: #333;
            white-space: nowrap;
            margin:0;
            transition: background-color .4s ease;
        }
        .checkbox-menu li input {
            position: relative;
        }

    </style>
@endsection
<?php
$script = '<script>
$(".checkbox-menu").on("change", "input[type=\'checkbox\']", function() {
   $(this).closest("li").toggleClass("active", this.checked);
});
$(document).on("click", ".allow-focus", function (e) {
  e.stopPropagation();
});
</script>
';
?>
@extends('frontend.layout', ['script'=>$script])