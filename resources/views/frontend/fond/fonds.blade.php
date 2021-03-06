@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default breadCrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href="/">{{trans('fonds.main')}}</a></li>
                            <li><a href="{{route('fonds')}}">{{trans('fonds.reestr')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid default pageTitle">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{trans('fonds.reestr')}}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid default d-block d-sm-none mobileFilters">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li>
                                <button><img src="/img/filter1.svg" alt=""><span>Фильтр поиска</span></button>
                            </li>
                            <li>
                                <button><img src="/img/filter2.svg" alt=""><span>По популярности</span></button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid default organizationsInBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <p class="bigName">{{trans('fonds.filtr-search')}}</p>

                        <div class="siteBarFilter">
                            <form action="{{route('fonds')}}" id="fonds_filter">
                                <input type="text" class="normal" name="bin" placeholder="{{trans('fonds.search-bin')}}" autocomplete="off">
                                <p class="text">
                                    {{trans('fonds.filtr-search-text')}}
                                </p>
                                <div class="siteBarList">
                                    <p class="categoryName" onclick="$(this).parents('.siteBarList').toggleClass('active')">{{trans('fonds.sector-activities')}}<i class="fas fa-chevron-down"></i></p>
                                    <div class="listBlock">
                                        {{--<p class="grey">Выберите один или несколько</p>--}}
                                        @foreach($baseHelpTypes as $help)
                                            @if($loop->index == 0)
                                                <p class="categoryName">{{trans('fonds.human-family')}}</p>
                                            @endif
                                            @if($loop->index == 10)
                                                <p class="categoryName">{{trans('fonds.help-soc')}}</p>
                                            @endif
                                            @if($loop->index == 14)
                                                <p class="categoryName">{{trans('fonds.help-animal')}}</p>
                                            @endif
                                            <div class="content"><input type="checkbox" name="baseHelpTypes[]" id="baseHelpTypes{{$help->id}}" value="{{$help->id}}"><label for="baseHelpTypes{{$help->id}}">{{$help['name_'.app()->getLocale()]}}</label></div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="siteBarList">
                                    <p class="categoryName" onclick="$(this).parents('.siteBarList').toggleClass('active')">{{trans('fonds.help-type')}}<i class="fas fa-chevron-down"></i></p>
                                    <div class="listBlock">
                                        {{--<p class="grey">Выберите один или несколько</p>--}}
                                        @foreach($cashHelpTypes as $help)
                                            @if($loop->index == 0)
                                                <p class="categoryName">{{trans('fonds.type-help')}}</p>
                                            @endif
                                            <div class="content"><input type="checkbox" name="cashHelpType[]" id="cashHelpType{{$help->id}}" value="{{$help->id}}"><label for="cashHelpType{{$help->id}}">{{$help['name_'.app()->getLocale()]}}</label></div>
                                        @endforeach
                                        <p class="categoryName">{{trans('fonds.help-size')}}</p>
                                        @foreach($cashHelpSizes as $help_size)
                                            <div class="content"><input type="checkbox" name="cashHelpSize[]" id="cashHelpSize{{$help_size->id}}" value="{{$help_size->id}}"><label for="cashHelpSize{{$help_size->id}}">{{$help_size['name_'.app()->getLocale()]}}</label></div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="siteBarList ">
                                    <p class="categoryName" onclick="$(this).parents('.siteBarList').toggleClass('active')">{{trans('fonds.adresat')}}<i class="fas fa-chevron-down"></i></p>
                                    <div class="listBlock">
                                        {{--<p class="grey">Выберите один или несколько</p>--}}
                                        {{--<div class="content"><input type="checkbox" name="destination[]" value="all" id="destination0"><label for="check7">Все</label></div>--}}
                                        @php $i = 0 @endphp
                                        <p class="categoryName">{{trans('fonds.status')}}</p>
                                        @foreach($destionations as $destination)
                                            @if($i != $destination->paren_id )
                                                @php $i = $destination->paren_id @endphp
                                                <p class="categoryName">{{trans('fonds.status')}}</p>
                                            @endif
                                            @if($loop->index == 16)
                                                <p class="categoryName">{{trans('fonds.life-sit')}}</p>
                                            @endif
                                            @if($loop->index == 24)
                                                <p class="categoryName">{{trans('fonds.origin')}}</p>
                                            @endif
                                            @if($loop->index == 27)
                                                <p class="categoryName">{{trans('fonds.healths')}}</p>
                                            @endif
                                            <div class="content" >
                                                <input type="checkbox" name="destination[]" value="{{$destination['id']}}" id="destination{{$destination['id']}}">
                                                <label for="destination{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="siteBarList">
                                    <p class="categoryName" onclick="$(this).parents('.siteBarList').toggleClass('active')">{{trans('fonds.regions')}} <i class="fas fa-chevron-down"></i></p>
                                    <div class="listBlock">
                                        {{--<p class="grey">Выберите один или несколько</p>--}}
{{--                                        @foreach($cities as $id => $city)--}}
{{--                                            <div class="content">--}}
{{--                                                <input type="checkbox" name="city[]" id="city{{$id}}" value="{{$id}}">--}}
{{--                                                <label for="city{{$id}}">{{$city}}</label>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
                                        @foreach($regions as $id => $city)
                                            <div class="content">
                                                <input type="checkbox" name="regions[]" id="regions{{$city['region_id']}}" value="{{$city['region_id']}}">
                                                <label for="regions{{$city['region_id']}}">{{$city['title_'.app()->getLocale()]}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                                <button type="submit" class="btn-default blue">{{trans('fonds.find')}}</button>
                                <span class="searchText">{{trans('fonds.found')}}:<br><span class="total">{{$fonds->total()}}</span> {{trans('fonds.org')}}</span>
                            </form>
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="bigName">{{trans('fonds.found')}} <b class="total">{{$fonds->total()}}</b> {{trans('fonds.org')}}</p>
                            </div>
                            <div class="col-sm-6 rightBlock d-none">
                                <div class="dropdown organizationDrop">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Сортировка по рейтингу
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="?sort=raiting">Сортировка по рейтингу</a>
                                        <a class="dropdown-item" href="?sort=new">Сортировка по новым</a>
                                        <a class="dropdown-item" href="?sort=summ">Сортировка по сумме</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="fond_lists">
                            @include('frontend.fond.fond_list')
                        </div>
                        <div class="preloader">
                            <div id="preloader">
                                <div id="loader"></div>
                            </div>
                        </div>
                        <script>
                            $('#fonds_filter').submit(function(){
                                var data = $(this).serialize();
                                $.ajax({
                                    url:'{{route('fonds')}}',
                                    method: 'get',
                                    data: data,
                                    beforeSend(){
                                        $('.preloader').show();
                                    },
                                    success: function(data){
                                        setTimeout(function(){
                                            $('.preloader').hide();
                                            $('#fond_lists').html(data);
                                        }, 1000);

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
        $('.reviewSlick').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
        $('.projectSlick').slick({
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
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
    $('#baseHelp, #addHelp').select2({
        maximumSelectionLength: 5,
        width: '100%',
        placeholder: 'Тип помощи'
    });
</script>";
?>
@extends('frontend.layout' , ['script'=>$script, 'title'=> 'Реестр фондов - Реестр благотврорительных организаций РК'])
