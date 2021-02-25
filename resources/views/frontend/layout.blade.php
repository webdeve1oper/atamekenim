<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Реестр Фондов</title>
    <meta name="description" content="">
    <link rel="shortcut icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="{{asset('/css/main.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=71df108d-a882-4434-8f23-c86cb89e565b&lang=ru_RU" type="text/javascript"></script>
</head>
<body>
<header>
    <a class="d-block d-sm-none burger" onclick="$('header ul.menu').slideToggle();"><i class="fas fa-stream"></i></a>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <a href="/" class="logo"><img src="/img/logo.svg" alt=""></a>
                <ul class="menu">
                    <li><a href="/o-proekte">О проекте</a></li>
                    <li><a href="/novosti">Новости</a></li>
                    <li><a href="/vopros-otvet">Вопрос-ответ</a></li>
                    <li><a href="/kontakty">Контакты</a></li>
                </ul>
                <ul class="socials">
                    <li><a href="" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="" target="_blank"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
            <div class="col-sm-6">
                <ul class="control">
                    <li>
                        <p class="share"><span>Поделиться</span><a href=""><i class="fas fa-share-alt"></i></a></p>
                    </li>
                    <li>
                        <p class="call"><span>Call-центр</span><a href="tel:1432">1432</a></p>
                    </li>
                    <li>
                        <p class="call"><span>Call-центр</span><a href="tel:+77763337766">+7 776 333 77 66</a></p>
                    </li>
                    <li>
                        <a href="" class="langSwitcher">RU<i class="fas fa-chevron-down"></i></a>
                    </li>
                    <li>
                        @if(Auth::guard('fond')->check())
                            <a href="{{route('fond_cabinet')}}" class="btn-default mr-1"><span class="fas fa-building"></span></a>
                            <a href="{{route('logout_fond')}}" class="login btn-default blue"><i class="fas fa-sign-out-alt"></i> Выйти</a>
                        @elseif(Auth::user())
                            <a href="{{route('cabinet')}}" class="btn-default mr-1"><span class="fa fa-user"></span></a>
                            <a href="{{route('logout_user')}}" class="login btn-default blue"><i class="fas fa-sign-out-alt"></i> Выйти</a>
                        @else
                            <a href="{{route('registration_user')}}" class="register btn-default transparent">Регистрация</a>
                            <a href="{{route('login')}}" class="login btn-default blue"><img src="/img/lofin.svg" alt="">Войти</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid blueBlock">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <ul class="menu2">
                        <li><a href="{{route('fonds')}}">Реестр благотворительных фондов</a></li>
                        <li><a href="{{route('helps')}}">Им нужна помощь</a></li>
                        <li><a href="">Помочь проекту</a></li>
                        <li><a href="">Карта благотворительности</a></li>
                        <li><a href="">Нас поддержали</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <form class="searchBlock">
                        <input type="text" name="search" placeholder="Поиск по сайту">
                        <button><img src="/img/search.svg" alt=""></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
@yield('content')

<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="/img/logo2.svg" alt="" class="logo2">
                    </div>
                    <div class="col-sm-6">
                        <ul>
                            <li><a href="">О проекте</a></li>
                            <li><a href="{{route('news')}}">Новости</a></li>
                            <li><a href="">Отзывы</a></li>
                            <li><a href="">Вопрос-ответ</a></li>
                            <li><a href="">Контакты</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <ul>
                    <li><a href="{{route('fonds')}}">Реестр благотворительных фондов</a></li>
                    <li><a href="">Им нужна помощь</a></li>
                    <li><a href="">Помочь проекту</a></li>
                    <li><a href="">Карта благотворительности</a></li>
                    <li><a href="">Нас поддержали</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <button class="share"><span>Поделиться в соц. сетях</span><img src="/img/share.svg" alt=""></button>
                <form action="">
                    <input type="text" placeholder="Поиск по сайту">
                    <button><img src="/img/search.svg" alt=""></button>
                </form>
                <a href="{{route('registration_user')}}" class="authButton">Зарегистрироваться</a>
                <a href="{{route('login')}}" class="authButton login">Войти</a>
            </div>
            <div class="col-sm-2">
                <ul>
                    <li><a href="">Call- центр</a></li>
                    <li><a href="">Социальные сети</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid foot">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="siteCopyr"><span>Все права на сайт принадлежат:</span><img src="/img/logo2.svg" alt=""></div>
                </div>
                <div class="col-sm-6">
                    <div class="siteCopyr realCopyright"><span>Создание и разработка сайтов: </span><img src="/img/conversion.svg" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</footer>


<script >
    var liner = $('body').offset().top;
    $(window).scroll(function() {
        if ($(this).scrollTop() > liner) {
            $('header').addClass("fixed");
        }else{
            $('header').removeClass("fixed");

        }
    });
</script>
{!! $script??'' !!}
<script>
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
<script>
    $(document).ready(function () {
        if(window.innerWidth < 678) {
            $('header ul.menu li a').click(function(){
                $('header ul.menu').hide();
            });
            $(window).scroll(function() {
                $('header ul.menu').hide();
            });
        }
    });
</script>
</body>
</html>
