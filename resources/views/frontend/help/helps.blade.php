@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default organizationsInBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="applicationSearchBlock">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h1>Реестр заявок</h1>
                                    <form action="{{route('helps')}}" id="helpsSearch">
                                        @csrf
                                        <div class="searchBlock">
                                            <input type="text" placeholder="Поис по слову, фонду или другому">
                                            <button class="btn-default blue">Найти</button>
                                        </div>
                                        <ul>
                                            <li>
                                                <input type="checkbox" id="check1">
                                                <label for="check1" onclick="$(this).toggleClass('active');">Новые заявки</label>
                                            </li>
                                            @foreach($baseHelpTypes as $help)
                                                <li>
                                                    <label type="checkbox" id="check{{$help->id}}">{{$help['name_'.app()->getLocale()]}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <a class="btn-default transparent" onclick="$(this).hide();$('.selectBlock').show();$('.rangeBarBlock').show();">Расширенный поиск <i class="fas fa-chevron-down"></i></a>
                                        <div class="selectBlock">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Адресат/благополучатель:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Характеристика адресата/благополучателя:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Регион проживания:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Выбрать расстояние:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Место оказания помощи:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Статус ТЖС:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Категория помощи:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Срочность:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton9" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Дата заявки:
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton9">
                                                    <a class="dropdown-item" href="#">Option1</a>
                                                    <a class="dropdown-item" href="#">Option2</a>
                                                    <a class="dropdown-item" href="#">Option3</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rangeBarBlock">
                                            <p class="rangeName">Необходимая сумма благотворительной помощи</p>
                                            <div class="rangeBlock"></div>
                                            <div class="inputBlock">
                                                <input type="checkbox" id="checker">
                                                <label for="checker">На постоянной основе</label>
                                            </div>
                                            <button class="btn-default blue">Найти</button>
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
@endsection
