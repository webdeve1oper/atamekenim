@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default accountMenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href="">Избранные заявки</a></li>
                            <li><a href="">История заявок</a></li>
                            <li><a href="">Мои поступления</a></li>
                            <li><a href="">Сообщения</a></li>
                            <li><a href="">Мои отзывы</a></li>
                            <li><a href="">Мой кабинет</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default myOrganizationContent">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="greyInfoBlock firstBig">
                            <form action="{{route('fond_setting')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-3">
                                        @if(Auth::user()->logo)
                                            <img src="{{Auth::user()->logo}}" alt="" class="logotype">
                                        @else
                                            <img src="/img/no-photo.png" alt="" class="logotype">
                                        @endif
                                        <input type="file" class="form-control mt-3" name="logo">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <label for="">Название организации</label>
                                            <input type="text" name="title" value="{{Auth::user()->title}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">БИН</label>
                                            <input type="text" name="bin" value="{{Auth::user()->bin}}" disabled class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Сайт:</label>
                                            <input type="text" name="website" value="{{Auth::user()->website}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Почта:</label>
                                            <input type="text" name="bin" value="{{Auth::user()->email}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Адрес:</label>
                                            <input type="text" name="address" value="{{Auth::user()->email}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Соц. сети:</label>

                                        </div>
                                        <div class="form-group">
                                            <label for="">Миссия:</label>
                                            <textarea name="mission" id="mission" class="form-control" cols="30" rows="10">
                                            {{Auth::user()->mission}}
                                        </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">О нас:</label>
                                            <textarea name="mission" id="mission" class="form-control" cols="30" rows="10">
                                            {{Auth::user()->about}}
                                        </textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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


    </div>
@endsection
