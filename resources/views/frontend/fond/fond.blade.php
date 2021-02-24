@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default breadCrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href="/">Главная</a></li>
                            <li><a href="{{route('fonds')}}">Реестр благотворительных организаций</a></li>
                            <li><a href="/fond/{{$fond->id}}">{{$fond->title}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default organInfoBlock">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @include('frontend.alerts')
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-3">
                                @if($fond->logo)
                                    <img src="{{$fond->logo}}" alt="" class="logotype">
                                @else
                                    <img src="/img/no-photo.png" alt="" class="logotype">
                                @endif

                            </div>
                            <div class="col-sm-9">
                                <div class="miniStatusBlock">
                                    <p class="greyText">Рейтинг: <span class="green">95</span></p>
                                    <a href="" class="socialButtonGlobal"><i class="fas fa-share-alt"></i></a>
                                </div>
                                <h1>{{$fond->title}}</h1>
                                <p class="category">{{$fond->sub_title}}</p>
                                <p>Страна: <span href="">{{$fond->country??'не указано'}}</span></p>
                                <p>Сайт: <a href="">{{$fond->website??'не указан'}}</a></p>
                                <p>Регион оказания помощи: <a href="">{{$fond->help_location_country??'не указано'}}</a></p>
                                <p>Основной сектор деятельности: @foreach($fond->baseHelpTypes as $i => $help){{$help['name_'.app()->getLocale()]}},@endforeach</p>
                                <p>Дополнительные секторы деятельности: @foreach($fond->addHelpTypes as $i => $help){{$help['name_'.app()->getLocale()]}},@endforeach</p>
                                <p>Закрытых заявок: <span>{{$fond->helpsByStatus('finished')->count()}}</span></p>
                                <p>Общая сумма оказанной благотворительной помощи: <span>3 925 647 435 тенге</span></p>
                                <p class="inline">Количество отзывов: <span>{{$fond->reviews()->count()}}</span></p>
                                <p class="inline">Смотреть: <a href="">хорошие/</a><a href="">плохие</a></p>
                                <p>Социальные сети: <a href="" class="socialButtonGlobal"><i class="fab fa-facebook-f"></i></a><a href="" class="socialButtonGlobal"><i class="fab fa-instagram"></i></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="bigName">Последние отзывы</p>
                                <div class="paginationBlock">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <button class="page-link arrows" rel="prev" aria-label="pagination.previous" onclick="$('.reviewSlick').slick('prev');">‹</button>
                                        </li>
                                        <li class="page-item">
                                            <button class="page-link arrows" rel="next" aria-label="pagination.next" onclick="$('.reviewSlick').slick('next');">›</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="reviewSlick">
                                    <div>
                                        <div class="block">
                                            <p class="name">Берик, Алматинская область, село Абай</p>
                                            <p class="descr textContent">Общественная организация «Менің Атамекенім» (далее – ОО МА) –  это некоммерческая организация, целью которого является развитие социальной ответственности бизнеса и изменение отношения бизнеса к решению социальных проблем, а также стратегическое развитие института благотворительности в Казахстане.
                                                Миссия ОО МА – развитие культуры благотворительности среди предпринимателей через позиционирование национальных ценностей в обществе и осознание непреходящих человеческих ценностей.
                                                Приоритетные направления: - концептуальное развитие благотворительной деятельности; - развитие социальной ответственности бизнеса; - развитие волонтерского движения;</p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="block">
                                            <p class="name">Берик, Алматинская область, село Абай</p>
                                            <p class="descr textContent">Общественная организация «Менің Атамекенім» (далее – ОО МА) –  это некоммерческая организация, целью которого является развитие социальной ответственности бизнеса и изменение отношения бизнеса к решению социальных проблем, а также стратегическое развитие института благотворительности в Казахстане.
                                                Миссия ОО МА – развитие культуры благотворительности среди предпринимателей через позиционирование национальных ценностей в обществе и осознание непреходящих человеческих ценностей.
                                                Приоритетные направления: - концептуальное развитие благотворительной деятельности; - развитие социальной ответственности бизнеса; - развитие волонтерского движения;</p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="block">
                                            <p class="name">Берик, Алматинская область, село Абай</p>
                                            <p class="descr textContent">Общественная организация «Менің Атамекенім» (далее – ОО МА) –  это некоммерческая организация, целью которого является развитие социальной ответственности бизнеса и изменение отношения бизнеса к решению социальных проблем, а также стратегическое развитие института благотворительности в Казахстане.
                                                Миссия ОО МА – развитие культуры благотворительности среди предпринимателей через позиционирование национальных ценностей в обществе и осознание непреходящих человеческих ценностей.
                                                Приоритетные направления: - концептуальное развитие благотворительной деятельности; - развитие социальной ответственности бизнеса; - развитие волонтерского движения;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default aboutFond">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <h2>О фонде</h2>
                        <button class="btn-default" @if(Auth::user()) data-toggle="modal" data-target="#helpCallback"@else onclick="window.location = '{{route('login')}}'" @endif>Подать заявку на получение помощи</button>
                        <div class="content">
                            <div class="imgBlock">
                                <img src="/img/about.png" alt="">
                                <p>Помощь сиротам 2020 г. @if($fond->video)<a href="/video/{{$fond->video}}">Смотреть видео</a> @endif</p>
                            </div>
                            <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).toggleClass('active');$('.openContentMobile').slideToggle();">Читать о фонде <i class="fas fa-chevron-down"></i></button>
                            <div class="textContent openContentMobile">
                                {{$fond->about}}
                            </div>
                            <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).toggleClass('active');$('.blueContent').slideToggle();">Читать о миссии фонда <i class="fas fa-chevron-down"></i></button>
                            <div class="blueContent">
                                <p class="name">Миссия организации</p>
                                <p class="textContent">
                                    {{$fond->mission}}
                                </p>
                            </div>

                            <div class="projectsBlock">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="name">Проекты фонда</p>
                                        <a href="" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="paginationBlock">
                                            <ul class="pagination">
                                                <li class="page-item">
                                                    <button class="page-link arrows" rel="prev" aria-label="pagination.previous" onclick="$('.projectSlick').slick('prev');">‹</button>
                                                </li>
                                                <li class="page-item">
                                                    <button class="page-link arrows" rel="next" aria-label="pagination.next" onclick="$('.projectSlick').slick('next');">›</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="projectSlick">
                                            @foreach($fond->projects as $project)
                                                <div>
                                                    <div class="helpBlock">
                                                        <div class="content">
                                                            <p>Помощь: <span class="tag blue">Спорт</span></p>
                                                            <p>Название проекта: <span>{{$project->title}}</span></p>
                                                            <p>Кому: <span>Паралимпийский резерв</span></p>
                                                            <p><b>Описание: </b>{!! substr($project->about, 0, 200) !!}...</p>
                                                            <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                                                        </div>
                                                        <p class="date">Статус: <span>Архив</span></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="redContent">
                            <h2>Поддержать организацию</h2>
                            <p>Пожертвовано: <span>1.000.000 тенге</span></p>
                            <p>Приняли участие: <span>150 человек</span></p>
                            <p>Мы связываем нуждающихся и благотворителей, чтобы
                                социальные нужды не оставались без ответа и ни одно
                                доброе дело – незамеченным.</p>
                            <form action="">
                                <div class="inputBlock">
                                    <span>Указать сумму</span>
                                    <input type="text" name="sum" placeholder="Пожертвовать произвольную сумму">
                                    <label for="sumInput1">100</label>
                                    <label for="sumInput2">1000</label>
                                    <label for="sumInput3">10000</label>
                                    <input type="radio" id="sumInput1" name="sum" value="100">
                                    <input type="radio" id="sumInput2" name="sum" value="1000">
                                    <input type="radio" id="sumInput3" name="sum" value="10000">
                                </div>
                                <div class="inputBlock">
                                    <span>Указать сумму</span>
                                    <label for="dayInput1">Разовое пожертвование</label>
                                    <label for="dayInput2">каждый день</label>
                                    <label for="dayInput3">Ежемесячно</label>
                                    <input type="radio" id="dayInput1" name="day" value="Разовое пожертвование">
                                    <input type="radio" id="dayInput2" name="day" value="Каждый день">
                                    <input type="radio" id="dayInput3" name="day" value="Ежемесячно">
                                </div>
                                <button class="btn-default red">
                                    <img src="/img/help.svg" alt=""> Поддержать благотворительную организацию
                                </button>
                            </form>
                        </div>

                        <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).toggleClass('active');$('.mobileGrayContent').slideToggle();">Смотреть реквизиты <i class="fas fa-chevron-down"></i></button>
                        <div class="grayContent mobileGrayContent">
                            <h3>Реквизиты</h3>
                            <p>БИН: <span>{{$fond->bin}}</span></p>
                            <p>Руководитель: <span>Чинкисбаева Л.А.</span></p>
                            <p>Дата регистрации: <span>май 2018 года (2 года, 6 месяцев)</span></p>
                            <p>Размер компании: <span>(0-5 чел)</span></p>
                            <p>Сайт: <span>{{$fond->website}}</span></p>
                            <p>Адрес: <span>г. Нур-Султан, ул. Достык 5/2, офис 6</span></p>
                            <p>Учредители: <span>10 физических лиц</span></p>
                            <p>Главный орган: <span>Совет учредителей</span></p>
                            <p>Им доверяют: <span>НПП "Атамекен", МОН РК, МТСЗН РК, МИОР РК, ООО "Яндекс"</span></p>
                            <p>Благодарственные письма/награды:<span>"Лучшее НПО" МИОР РК, "Лучшее НПО", НПП "Атамекен"</span></p>
                            <p>СМИ о ОО МА:
                                <a href="">tengrinews.kz/ooma/fastnews</a>
                                <a href="">tengrinews.kz/ooma/fastnews</a>
                            </p>
                            <p>Социальные сети: <a href="" class="socialButtonGlobal"><i class="fab fa-facebook-f"></i></a><a href="" class="socialButtonGlobal"><i class="fab fa-instagram"></i></a></p>
                        </div>
                    </div>


                    <div class="col-sm-8 bottomContent">
                        <h3>Организация на карте</h3>
                        <div class="map"></div>
                        <button class="btn-default blue">Подать заявку на получение помощи</button>
                    </div>
                    <div class="col-sm-4 bottomContent">
                        <div class="galleryBlock">
                            <h3>Фотографии организации</h3>
                            <div class="row">
                                <div class="col-sm-3 col-6"><a href="" class="fondImg"><img src="/img/about.png" alt=""></a></div>
                                <div class="col-sm-3 col-6"><a href="" class="fondImg"><img src="/img/about.png" alt=""></a></div>
                                <div class="col-sm-3 col-6"><a href="" class="fondImg"><img src="/img/about.png" alt=""></a></div>
                                <div class="col-sm-3 col-6"><a href="" class="fondImg openGallery"><img src="/img/about.png" alt=""><span>+20</span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid default helperBlock d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>В работе</h4>
                        <a href="" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
                    </div>
                    <div class="col-sm-6 rightBlock">
                        <p class="d-inline-block mr-3">Сортировка по рейтингу</p>
                        <div class="dropdown organizationDrop">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Сортировка по рейтингу
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Сортировка по рейтингу</a>
                                <a class="dropdown-item" href="#">Сортировка по рейтингу</a>
                                <a class="dropdown-item" href="#">Сортировка по рейтингу</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="helpBlock">
                            <div class="content">
                                <p>Помощь: <span class="tag blue">Образование</span></p>
                                <p>Организация: <img src="/img/logo.svg" alt=""></p>
                                <p>Кому: <span>Кайрат Жомарт</span></p>
                                <p>Сумма: <span>1,150,000 тг.</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">19.10.2019</p>
                            <img src="/img/support1.svg" alt="" class="bkg">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="helpBlock">
                            <div class="content">
                                <p>Помощь: <span class="tag green">Образование</span></p>
                                <p>Организация: <img src="/img/logo.svg" alt=""></p>
                                <p>Кому: <span>Кайрат Жомарт</span></p>
                                <p>Сумма: <span>1,150,000 тг.</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">19.10.2019</p>
                            <img src="/img/support2.svg" alt="" class="bkg">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="helpBlock">
                            <div class="content">
                                <p>Помощь: <span class="tag red">Образование</span></p>
                                <p>Организация: <img src="/img/logo.svg" alt=""></p>
                                <p>Кому: <span>Кайрат Жомарт</span></p>
                                <p>Сумма: <span>1,150,000 тг.</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">19.10.2019</p>
                            <img src="/img/support3.svg" alt="" class="bkg">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="helpBlock">
                            <div class="content">
                                <p>Помощь: <span class="tag red">Образование</span></p>
                                <p>Организация: <img src="/img/logo.svg" alt=""></p>
                                <p>Кому: <span>Кайрат Жомарт</span></p>
                                <p>Сумма: <span>1,150,000 тг.</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">19.10.2019</p>
                            <img src="/img/support4.svg" alt="" class="bkg">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Кому помог фонд</h4>
                    </div>
                    <div class="col-sm-6 rightBlock">
                        <p class="status">Всего заявок: <span>10000</span></p>
                        <p class="status">Выполнено: <span>10000</span></p>
                    </div>
                    <div class="col-sm-3">
                        <div class="helpBlock">
                            <div class="content">
                                <p>Помощь: <span class="tag blue">Образование</span></p>
                                <p>Организация: <img src="/img/logo.svg" alt=""></p>
                                <p>Кому: <span>Кайрат Жомарт</span></p>
                                <p>Сумма: <span>1,150,000 тг.</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">19.10.2019</p>
                            <img src="/img/support1.svg" alt="" class="bkg">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="helpBlock">
                            <div class="content">
                                <p>Помощь: <span class="tag green">Образование</span></p>
                                <p>Организация: <img src="/img/logo.svg" alt=""></p>
                                <p>Кому: <span>Кайрат Жомарт</span></p>
                                <p>Сумма: <span>1,150,000 тг.</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">19.10.2019</p>
                            <img src="/img/support2.svg" alt="" class="bkg">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="helpBlock">
                            <div class="content">
                                <p>Помощь: <span class="tag red">Образование</span></p>
                                <p>Организация: <img src="/img/logo.svg" alt=""></p>
                                <p>Кому: <span>Кайрат Жомарт</span></p>
                                <p>Сумма: <span>1,150,000 тг.</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">19.10.2019</p>
                            <img src="/img/support3.svg" alt="" class="bkg">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="helpBlock">
                            <div class="content">
                                <p>Помощь: <span class="tag red">Образование</span></p>
                                <p>Организация: <img src="/img/logo.svg" alt=""></p>
                                <p>Кому: <span>Кайрат Жомарт</span></p>
                                <p>Сумма: <span>1,150,000 тг.</span></p>
                                <a href="" class="more">Подробнее <span class="miniArrow">›</span></a>
                            </div>
                            <p class="date">19.10.2019</p>
                            <img src="/img/support4.svg" alt="" class="bkg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default organizationsBlock inOrganizationsBlock d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Им доверяют</h4>
                        <a href="" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
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
                        <div class="organizationsList">
                            <div class="item">
                                <ul>
                                    <li><p class="name">Частное лицо</p></li>
                                    <li><p>11.150.000 тг</p></li>
                                    <li><p>20:15, 19.10.2020</p></li>
                                    <li><p>Онлайн перевод</p></li>
                                    <li><a href="">Национальный Музей</a></li>
                                </ul>
                            </div>
                            <div class="item">
                                <ul>
                                    <li><a href="" class="name">Менің Атамекенім</a></li>
                                    <li><p>11.150.000 тг</p></li>
                                    <li><p>20:15, 19.10.2020</p></li>
                                    <li><p>Онлайн перевод</p></li>
                                    <li><a href="">Национальный Музей</a></li>
                                </ul>
                            </div>
                            <div class="item">
                                <ul>
                                    <li><p class="name">Частное лицо</p></li>
                                    <li><p>11.150.000 тг</p></li>
                                    <li><p>20:15, 19.10.2020</p></li>
                                    <li><p>Онлайн перевод</p></li>
                                    <li><a href="">Национальный Музей</a></li>
                                </ul>
                            </div>
                            <div class="item">
                                <ul>
                                    <li><a href="" class="name">Менің Атамекенім</a></li>
                                    <li><p>11.150.000 тг</p></li>
                                    <li><p>20:15, 19.10.2020</p></li>
                                    <li><p>Онлайн перевод</p></li>
                                    <li><a href="">Национальный Музей</a></li>
                                </ul>
                            </div>
                            <div class="item">
                                <ul>
                                    <li><p class="name">Частное лицо</p></li>
                                    <li><p>11.150.000 тг</p></li>
                                    <li><p>20:15, 19.10.2020</p></li>
                                    <li><p>Онлайн перевод</p></li>
                                    <li><a href="">Национальный Музей</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default ourPartners d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Наши партнеры</h4>
                        <a href="" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
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


        <div class="container-fluid default otherOrganizations d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Наши партнеры</h4>
                    </div>
                    <div class="col-sm-3">
                        <div class="block">
                            <img src="/img/bi.png" alt="">
                            <p>"Менің Атамекенім"<span>Корпоративный благотворительный фонд</span></p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="block">
                            <img src="/img/bi.png" alt="">
                            <p>"Менің Атамекенім"<span>Корпоративный благотворительный фонд</span></p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="block">
                            <img src="/img/bi.png" alt="">
                            <p>"Менің Атамекенім"<span>Корпоративный благотворительный фонд</span></p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="block">
                            <img src="/img/bi.png" alt="">
                            <p>"Менің Атамекенім"<span>Корпоративный благотворительный фонд</span></p>
                        </div>
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
                        <form action="{{route('helpfond')}}" method="post">
                            @csrf
                            <input type="hidden" name="fond[]" value="{{$fond->id}}">
                            <input type="text" name="title" class="form-control mb-3" value="{{old('title')}}" placeholder="Заголовок помощи">
                            @if($errors->has('title'))
                                <span class="error">{{ $errors->first('title') }}</span>
                            @endif
                            <p>
                                <select name="baseHelpTypes" class="select2 w-100" placeholder="Тип помощи" id="baseHelp">
                                    @foreach($baseHelpTypes as $baseHelpType)
                                        <option value="{{$baseHelpType->id}}">{{$baseHelpType->text}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p>
                                <select name="addHelpTypes[]" class="select2 w-100" placeholder="Тип помощи" multiple id="addHelp"></select>
                            </p>
                            <p>
                                <select name="region_id" class="select2 w-100" placeholder="Тип помощи" id="regions">
                                    @foreach($regions as $region)
                                        <option value="{{$region->region_id}}">{{$region->text}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p>
                                <select name="city_id" class="select2 w-100" placeholder="Тип помощи" id="cities"></select>
                            </p>
                            <script>
                                var json = {!! $regions->toJson() !!};
                                var jsonHelps = {!! $baseHelpTypes->toJson() !!};
                                console.log(jsonHelps);
                                $('#regions').select2({
                                    width: '100%',
                                    placeholder: 'Область'
                                });
                                $('#cities').select2({
                                    width: '100%',
                                    placeholder: 'Выберите город'
                                });
                                $('#baseHelp').select2({
                                    width: '100%',
                                    placeholder: 'Выберите сектор помощи'
                                });
                                $('#addHelp').select2({
                                    width: '100%',
                                    placeholder: 'Выберите подробный сектор помощи'
                                });

                                $('#baseHelp').change(function(){
                                    var ind = $('#baseHelp').children('option:selected').val();
                                    var datas = [];
                                    jsonHelps.forEach(function(value,index){
                                        if(value.id == ind){
                                            ind = index;
                                        }
                                    });
                                    $('#addHelp').empty();
                                    datas.push({id:'0', text: '-'});
                                    for (let [key, value] of Object.entries(jsonHelps[ind].add_help_types)){
                                        datas.push({id:value.id, text: value.name_ru});
                                    }
                                    $('#addHelp').select2({data: datas, allowClear: true});
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
    <style>
        .modal-header .close{
            position: absolute;
            right: 22px;
        }
        .modal-title{
            margin: auto;
        }
    </style>
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

@extends('frontend.layout', ['script'=>$script])
