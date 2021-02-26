@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default breadCrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href="/">Главная</a></li>
                            <li><a href="{{route('fonds')}}">Реестр благотворительных организаций</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid default pageTitle">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Реестр благотворительных организаций</h1>
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
                        <p class="bigName">Фильтр поиска</p>

                        <div class="siteBarFilter">
                            <form action="{{route('fonds')}}" id="fonds_filter">
                                <input type="text" class="normal" name="bin" placeholder="Поиск по названию/БИН" autocomplete="off">
                                <p class="text">
                                    Укажите название / БИН организации
                                    или укажите пункты поиска
                                </p>
                                <div class="siteBarList active">
                                    <p class="categoryName" onclick="$(this).parents('.siteBarList').toggleClass('active')">Характеристика адресата/благополучателя<i class="fas fa-chevron-down"></i></p>
                                    <div class="listBlock">
                                        <p class="grey">Выберите один или несколько</p>
                                        <div class="content">
                                            <input type="checkbox" name="destination_attribute[]" value="all" id="destination_attribute0"><label for="destination_attribute0">Все</label>
                                        </div>
                                        @foreach($destionationsAttributes as  $destination)
                                            <div class="content">
                                                <input type="checkbox" name="destination_attribute[]" value="{{$destination['id']}}" id="destination_attribute{{$destination['id']}}">
                                                <label for="destination_attribute{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="siteBarList">
                                    <p class="categoryName" onclick="$(this).parents('.siteBarList').toggleClass('active')">Адресат/Благополучатель <i class="fas fa-chevron-down"></i></p>
                                    <div class="listBlock">
                                        <p class="grey">Выберите один или несколько</p>
                                        <div class="content"><input type="checkbox" name="destination[]" value="all" id="destination0"><label for="check7">Все</label></div>
                                        @foreach($destionations as $destination)
                                            <div class="content">
                                                <input type="checkbox" name="destination[]" value="{{$destination['id']}}" id="destination{{$destination['id']}}">
                                                <label for="destination{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="siteBarList">
                                    <p class="categoryName" onclick="$(this).parents('.siteBarList').toggleClass('active')">Регион <i class="fas fa-chevron-down"></i></p>
                                    <div class="listBlock">
                                        <p class="grey">Выберите один или несколько</p>
                                        @foreach($cities as $id => $city)
                                            <div class="content"><input type="checkbox" name="city[]" id="city{{$id}}" value="{{$id}}"><label for="city{{$id}}">{{$city}}</label></div>
                                        @endforeach
                                        @foreach($regions as $id => $city)
                                            <div class="content"><input type="checkbox" name="regions[]" id="regions{{$id}}" value="{{$id}}"><label for="regions{{$id}}">{{$city}}</label></div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="siteBarList">
                                    <p class="categoryName" onclick="$(this).parents('.siteBarList').toggleClass('active')">Категория помощи <i class="fas fa-chevron-down"></i></p>
                                    <div class="listBlock">
                                        <p class="grey">Выберите один или несколько</p>
                                        @foreach($baseHelpTypes as $help)
                                            <div class="content"><input type="checkbox" name="baseHelpTypes[]" id="baseHelpTypes{{$help->id}}" value="{{$help->id}}"><label for="baseHelpTypes{{$help->id}}">{{$help['name_'.app()->getLocale()]}}</label></div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="submit" class="btn-default blue">Найти</button>
                                <span class="searchText">Найдено:<br>{{$fonds->total()}} организаций</span>
                            </form>
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="bigName">найдено {{$fonds->total()}} НПО</p>
                            </div>
                            <div class="col-sm-6 rightBlock">
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
                        <script>
                            $('#fonds_filter').submit(function(){
                                var data = $(this).serialize();
                                $.ajax({
                                    url:'{{route('fonds')}}',
                                    method: 'get',
                                    data: data,
                                    success: function(data){
                                        $('#fond_lists').html(data);
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
    @if(Auth::user())

        <div id="helpCallback" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title text-center">Подача заявления на получение помощи</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('helpfond')}}" id="helpfond" method="post">
                            @csrf
                            <input type="hidden" name="fond[]" id="fond_id" value="">
                            <input type="text" name="title" class="form-control mb-3" value="{{old('title')}}" placeholder="Заголовок помощи">
                            @if($errors->has('title'))
                                <span class="error">{{ $errors->first('title') }}</span>
                            @endif
                            <p>
                                <select name="baseHelpTypes[]" class="select2 w-100" placeholder="Тип помощи" multiple id="baseHelp">
                                    @foreach($baseHelpTypes as $baseHelpType)
                                        <option value="{{$baseHelpType->id}}">{{$baseHelpType->name_ru}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p>
                                <select name="addHelpTypes[]" class="select2 w-100" multiple id="addHelp">
                                    @foreach($addHelpTypes as $addHelpType)
                                        <option value="{{$addHelpType->id}}">{{$addHelpType->name_ru}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <textarea name="body" placeholder="Описание помощи" class="form-control mb-3" id="helpBody" cols="30" rows="10">{{old('body')}}</textarea>
                            <input type="submit" class="btn btn-primary m-auto d-table" value="Отправить">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>

            </div>
        </div>
    @endif
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
@extends('frontend.layout' , ['script'=>$script])
