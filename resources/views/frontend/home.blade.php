@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid slide">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Единая приемная всех благотворительных
                            организаций Казахстана </h1>
                        <p class="descr">Реестр поможет тебе найти организацию, которая решит твою проблему, помочь тем,
                            кто оказался в тяжелой жизненной ситуации, и найти благотворительную организацию, достойную поддержки </p>
                        <button class="btn-default blue">Подать заявку на получение помощи</button>
                        <button class="btn-default">Принять участие</button>
                    </div>
                </div>
                <img src="/img/slide.svg" alt="" class="slideImg">
            </div>
        </div>

        <div class="container-fluid default organizationsBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>Реестр благотворительных организаций</h2>
                        <p class="descr">Для удобного поиска конкретного фонда - используйте фильтр</p>
                    </div>
                    <div class="col-sm-12">
                        <form id="formSearch">
                            <input type="text" name="bin" placeholder="Поиск по названию или БИИН">
                            <select name="baseHelpTypes[]" id="select1">
                                <option value="all">Сектор деятельности</option>
                                @foreach($baseHelpTypes as $help)
                                    <option  value="{{$help->id}}">
                                        {{$help['name_'.app()->getLocale()]}}
                                    </option>
                                @endforeach
                            </select>

                            <select name="destination[]" id="select2">
                                <option value="all">Адресат/благополучатель</option>
                                @foreach($destionations as $destination)
                                    <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                @endforeach
                            </select>

                            <select name="city[]" id="select3">
                                <option value="all">Все города</option>
                                @foreach($cities as $id => $city)
                                    <option value="{{$id}}">{{$city}}</option>
                                @endforeach
                            </select>

                            <button>Найти</button>
                        </form>
                        <a href="{{route('dev')}}" class="btn-default openMap">Карта фондов</a>
                    </div>

                    <div class="col-12" id="fond_lists">
                        @include('frontend.home_fond_list')
                    </div>
                    <div class="col-sm-12">
                        <a class="btn-default" href="{{route('fonds')}}">Смотреть все организации <span class="miniArrow">›</span></a>
                        <button class="btn-default blue">Хочу помочь фонду</button>
                        <a href="{{route('registration_fond')}}" class="btn-default blue">Регистрация в реестре</a>
                    </div>
                    <script>
                        $('#formSearch').submit(function(){
                            var data = $(this).serialize();
                            $.ajax({
                                url: '{{route('home')}}',
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

        <div class="container-fluid default newMembers">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>Новые участники реестра</h2>
                        <a href="{{route('dev')}}" class="readMore">Подробнее <span class="miniArrow">›</span></a>
                    </div>
                    <div class="col-sm-6">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                По сектору деятельности
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <a class="dropdown-item" href="#">За все время</a>
                                <a class="dropdown-item" href="#">За все время</a>
                                <a class="dropdown-item" href="#">За все время</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="paginationBlock">
                            <ul class="pagination">
                                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                <li class="page-item"><a class="page-link" href="">2</a></li>
                                <li class="page-item"><a class="page-link" href="">3</a></li>
                                <li class="page-item"><a class="page-link" href="">4</a></li>
                                <li class="page-item"><a class="page-link" href="">5</a></li>
                                <li class="page-item">
                                    <a class="page-link arrows" href="" rel="prev" aria-label="pagination.previous">‹</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link arrows" href="" rel="next" aria-label="pagination.next">›</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="newOrganizationsBlock">
                            @foreach($newFonds as $key=> $fond)
                                <div class="item">
                                    <ul>
                                        <li><p class="number">{{$key+1}}</p></li>
                                        <li>
                                            @if($fond->logo)
                                                <img src="{{$fond->logo}}" alt="" class="logotype">
                                            @else
                                                <img src="/img/no-photo.png" alt="" class="logotype">
                                            @endif
                                        </li>
                                        <li><a href="" class="name">{{$fond->title}}</a></li>
                                        <li><p>{{$fond->sub_title}}</p></li>
                                        <li><p>{{$fond->foundation_date}}</p></li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default supportBlock">
            <div class="container">
                <div class="row fat">
                    <div class="col-sm-6">
                        <h3>Мне нужна помощь</h3>
                        <form action="" id="helpForm">
                            <div class="inputBlock">
                                <label for="input1">Ваш ИИН</label>
                                <input type="text" id="input1" placeholder="12 цифр">
                            </div>
                            <div class="inputBlock">
                                <label for="citySelector">Ваш регион</label>
                                <select name="" id="citySelector">
                                    <option value="">Выбрать город из списка</option>
                                    <option value="">Выбрать город из списка</option>
                                    <option value="">Выбрать город из списка</option>
                                </select>
                            </div>
                            <div class="inputBlock">
                                <label for="input3">Ваш номер телефона</label>
                                <input type="text" id="input3" placeholder="8 (7**) *** *** **">
                            </div>
                            <div class="inputBlock topper">
                                <button>Подать заявку</button>
                            </div>
                            <div class="inputBlock topper">
                                <p class="regulations">Отправляя заявку, вы соглашаетесь <br>с <a href="">правилами публичной офферты</a></p>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <p class="bigName">Зачем нужна регистрация?</p>
                        <p class="descr">
                            После того, как вы подадите заявку, ее получат все организации, работающие в вашем регионе и занимающиеся решением проблем, аналогичных вашей. Как только какая-либо организация возьмет вашу заявку в работу, вы получите сообщение и с вами свяжутся представители этой организации.
                        </p>
                        <a href="{{route('login')}}" class="btn-default blue"><img src="/img/lofin.svg" alt=""> Войти</a>
                        <a href="{{route('registration_user')}}" class="btn-default transparent">Зарегистрироваться</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default whyRegisterBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <h3>Зачем регистрировать <br>организацию в Реестре?</h3>
                        <p class="descr">После того, как вы зарегистрируете свою организацию в Реестре, она будет отображаться в списке благотворительных организаций Казахстана, пользователи смогут видеть статистику ваших проектов. Через рабочий кабинет вы будете получать заявки на получение помощи, соответствующие вашим региону, сфере деятельности и категориям благополучателей, и брать их в работу.</p>
                        <a href="{{route('dev')}}" class="btn-default blue">Подробнее</a>
                    </div>
                    <div class="col-sm-7">
                        <h3>Преимущества регистрации в Реестре</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="problemBlock">
                                    <div class="imgBlock"><img src="/img/icon1.svg" alt=""></div>
                                    <div class="content">
                                        <p class="name">Признание</p>
                                        <p class="descr">Все пользователи узнают о вашей организации и ее деятельности,
                                            вы сможете участвовать в рейтингах и конкурсах</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="problemBlock">
                                    <div class="imgBlock"><img src="/img/icon2.svg" alt=""></div>
                                    <div class="content">
                                        <p class="name">Цифровизация</p>
                                        <p class="descr">Вы получаете все данные о заявителе за счет связи с государственными информационными базами данных </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="problemBlock">
                                    <div class="imgBlock"><img src="/img/icon1.svg" alt=""></div>
                                    <div class="content">
                                        <p class="name">Удобство</p>
                                        <p class="descr">Вы получаете только заявки, соответствующие вашему региону, сфере деятельности
                                            и категориям благополучателей</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="problemBlock">
                                    <div class="imgBlock"><img src="/img/icon2.svg" alt=""></div>
                                    <div class="content">
                                        <p class="name">Безопасность</p>
                                        <p class="descr">Вы можете быть уверенны, что
                                            с каждой взятой вами заявкой работаете только вы (исключение иждивенчества)  </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default helperBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Кому помогли</h4>
                        <a href="{{route('dev')}}" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
                    </div>
                    <div class="col-sm-6 rightBlock">
                        <p class="status">Всего заявок: <span>{{$helpsCount}}</span></p>
                        <p class="status">Выполнено: <span>{{$helps->total()}}</span></p>
                    </div>
                    @foreach($helps as $help)
                        <div class="col-sm-3">
                            <div class="helpBlock">
                                <div class="content">
                                    <p>Помощь: <span class="tag blue">{{$help->baseHelpTypes()->first()->name_ru}}</span></p>
                                    <p>Кому: <span>
                                @if(Auth::guard('fond')->check())
                                                {{$help->user->first_name}},  {{\Carbon\Carbon::parse($help->user->born)->age }} лет
                                            @else
                                                @if($help->user->gender=='male') Мужчина @elseif($help->user->gender=='female') Женщина @else Не указано @endif
                                            @endif</span></p>
                                    <p>Регион: <span>{{$help->region->title_ru}}</span></p>
                                    <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                                </div>
                                <p class="date">Открытая заявка</p>
                                <img src="/img/support1.svg" alt="" class="bkg">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Новые заявки</h4>
                        <a href="" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
                    </div>
                    <div class="col-sm-6 rightBlock">
                        <p class="status">На расмотрении: <span>{{$newHelps->total()}}</span></p>
                    </div>
                    @foreach($newHelps as $help)
                    <div class="col-sm-3">
                        <div class="helpBlock newHelp">
                            <div class="content">
                                <p>Помощь: <span class="tag blue">{{$help->baseHelpTypes()->first()->name_ru}}</span></p>
                                <p>Кому: <span>
                                @if(Auth::guard('fond')->check())
                                            {{$help->user->first_name}},  {{\Carbon\Carbon::parse($help->user->born)->age }} лет
                                @else
                                    @if($help->user->gender=='male') Мужчина @elseif($help->user->gender=='female') Женщина @else Не указано @endif
                                @endif</span></p>
                                <p>Регион: <span>{{$help->region->title_ru}}</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">Открытая заявка</p>
                            <img src="/img/support1.svg" alt="" class="bkg">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="container-fluid default faqBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Вопрос-ответ</h4>
                        <button class="btn-default blue">Задать вопрос</button>
                        <button class="btn-default">Call-центр</button>
                    </div>
                    <div class="col-sm-12">
                        <div id="accordion">
                            <div class="card active">
                                <div class="card-header" id="headingOne">
                                    <p class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            Как попасть в реесетр? <i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        Мы связываем нуждающихся и благотворителей, чтобы социальные нужды не оставались без ответа и ни одно доброе дело – незамеченным. Если Вы оказались в трудной жизненной ситуации – обратитесь к нам.

                                        К нам регулярно обращаются люди, оказавшиеся в сложной жизненной ситуации, которым мы помогаем с Вашей помощью. Помогите тем, кому действительно необходима помощь.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <p class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            Как подать заявку на получение помощи? <i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        Мы связываем нуждающихся и благотворителей, чтобы социальные нужды не оставались без ответа и ни одно доброе дело – незамеченным. Если Вы оказались в трудной жизненной ситуации – обратитесь к нам.

                                        К нам регулярно обращаются люди, оказавшиеся в сложной жизненной ситуации, которым мы помогаем с Вашей помощью. Помогите тем, кому действительно необходима помощь.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <p class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            Как я могу помочь нуждающимся? <i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        Мы связываем нуждающихся и благотворителей, чтобы социальные нужды не оставались без ответа и ни одно доброе дело – незамеченным. Если Вы оказались в трудной жизненной ситуации – обратитесь к нам.

                                        К нам регулярно обращаются люди, оказавшиеся в сложной жизненной ситуации, которым мы помогаем с Вашей помощью. Помогите тем, кому действительно необходима помощь.
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <p class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            Часто задаваемые вопросы <i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="card-body">
                                        Мы связываем нуждающихся и благотворителей, чтобы социальные нужды не оставались без ответа и ни одно доброе дело – незамеченным. Если Вы оказались в трудной жизненной ситуации – обратитесь к нам.

                                        К нам регулярно обращаются люди, оказавшиеся в сложной жизненной ситуации, которым мы помогаем с Вашей помощью. Помогите тем, кому действительно необходима помощь.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn-default">Посмотреть еще <i class="fas fa-angle-down"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default newsBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Новости</h4>
                    </div>
                    <div class="col-sm-12">
                        <ul class="newsTabs">
                            <li><a href="" class="active">Последние новости</a></li>
                            <li><a href="">Информация для благотворительных фондов</a></li>
                            <li><a href="">Информация для благополучателей</a></li>
                            <div class="paginationBlock">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <button class="page-link arrows" rel="prev" aria-label="pagination.previous" onclick="$('.newsSlick').slick('prev');">‹</button>
                                    </li>
                                    <li class="page-item">
                                        <button class="page-link arrows" rel="next" aria-label="pagination.next" onclick="$('.newsSlick').slick('next');">›</button>
                                    </li>
                                </ul>
                            </div>
                        </ul>
                    </div>
                    <div class="col-sm-12">
                        <div class="newsSlick">
                            @foreach($news as $new)
                                <div>
                                    <div class="block">
                                        <p class="date">{!! date('d.m'.'<b>'.'Y'.'</b>', strtotime($new['public_date'])) !!}</p>
                                        <p class="name"><a href="{{route('new', $new['slug'])}}">{{$new['title_'.app()->getLocale()]??$new['title_ru']}}</a></p>
                                        <p class="descr">{{$new['body_'.app()->getLocale()]??$new['body_ru']}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <a href="{{route('news')}}" class="readMore">Читать все новости <span class="miniArrow">›</span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default ourPartners">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Наши партнеры</h4>
                        <a href="{{route('dev')}}" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
                    </div>
                    <div class="col-sm-12 partners">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="block">
                                    <img src="/img/partner1.svg" alt="">
                                    <p>Министерство образования и науки Республики Казахстан</p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="block">
                                    <img src="/img/partner2.svg" alt="">
                                    <p>Министерство образования и науки Республики Казахстан</p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="block">
                                    <img src="/img/partner3.svg" alt="">
                                    <p>Министерство образования и науки Республики Казахстан</p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="block">
                                    <img src="/img/partner1.svg" alt="">
                                    <p>Министерство образования и науки Республики Казахстан</p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="block">
                                    <img src="/img/partner2.svg" alt="">
                                    <p>Министерство образования и науки Республики Казахстан</p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="block">
                                    <img src="/img/partner3.svg" alt="">
                                    <p>Министерство образования и науки Республики Казахстан</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
