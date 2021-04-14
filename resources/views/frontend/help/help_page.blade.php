@extends('frontend.layout')
@section('content')
    <div class="container-fluid default breadCrumbs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('helps') }}">Кому помогли</a></li>
                        <li><a>Оказание помощи Султанову С.С.</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid default completeApplicationPage">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <p class="blueName">Исполненная заявка</p>
                </div>
                <div class="col-sm-7">
                    <p class="blueName">ID: <span>013245687</span></p>
                </div>
                <div class="col-sm-12">
                    <h1>Оказание помощи Султанову С.С.</h1>
                </div>
                <div class="col-sm-7">
                    <div class="applicationGallery">
                        <div class="bigImage">
                            <a href=""><img src="/img/photo.jpg" alt=""></a>
                        </div>
                        <div class="galleryBlock">
                            <a href="" class="fondImg"><img src="/img/about.png" alt=""></a>
                            <a href="" class="fondImg"><img src="/img/about.png" alt=""></a>
                            <a href="" class="fondImg openGallery"><img src="/img/about.png" alt=""><span>+20</span></a>
                        </div>
                    </div>
                    <div class="greyContent">
                        <p class="name">Султанов С.С., Алматинская область, село Абай</p>
                        <div class="text">
                            <p>
                                Түркістан облысы тұрғыны көпбалалы ана азық-түлікпен, киім-кешекпен және баласының еміне қаржылай көмек сұрайды
                            </p><p>
                                Мен Гаипова Жибек Түркістан облысы Мақтаарал ауданында тұрамын. 7 баланың анасымын. Ұлым Нұрдәулет көздері бірде көріп бірде көрмей ауырады. Баламның көзінің еміне көмектеріңіз керек. Несиелерім бар. Балаларыма азық-түлікпен, киім-кешекпен көмек қажет. Үй алуға көмек керек.
                            </p><p>
                                Егер сіз көмек көрсеткіңіз келсе, біздің 1432 (хабарласу тегін) call-центрына немесе WhatsApp мессенджері арқылы нөмеріміз +7 776 333 77 66 хабарласа аласыз. Сондай-ақ сайтта көмек бергім келеді деген батырма арқылы көмек көрсете аласыз Мен Гаипова Жибек Түркістан облысы Мақтаарал ауданында тұрамын. 7 баланың анасымын. Ұлым Нұрдәулет көздері бірде көріп бірде көрмей ауырады. Баламның көзінің еміне көмектеріңіз керек. Несиелерім бар. Балаларыма азық-түлікпен, киім-кешекпен көмек қажет. Үй алуға көмек керек.
                            </p><p>
                                Егер сіз көмек көрсеткіңіз келсе, біздің 1432 (хабарласу тегін) call-центрына немесе WhatsApp мессенджері арқылы нөмеріміз +7 776 333 77 66 хабарласа аласыз. Сондай-ақ сайтта көмек бергім келеді деген батырма арқылы көмек көрсете аласыз
                            </p>
                        </div>
                    </div>
                    <p class="share"><span>Поделиться</span><a href=""><img src="/img/share2.svg" alt=""></a></p>
                </div>
                <div class="col-sm-5">
                    <div class="infoBlock">
                        <p><span>Сектор:</span>Образование</p>
                        <p><span>Регион:</span>г. Нур-Султан</p>
                    </div>

                    <div class="infoBlock">
                        <p><span>Статус заявки:</span>Исполнена</p>
                        <p><span>Категория помощи:</span>разовая материальная помощь</p>
                        <p><span>Срочность:</span>несрочная</p>
                        <p><span>Сумма благотворительной помощи:</span>100 000 тенге</p>
                    </div>

                    <div class="infoBlock">
                        <p><span>Благополучатель:</span>трудоспособное население</p>
                        <p><span>ТЖС:</span>кризисный 70 баллов</p>
                        <p><span>Характеристика благополучателя:</span>студент</p>
                        <p><span>Возраст:</span>20 лет</p>
                        <p><span>Пол:</span>Мужчина</p>
                    </div>

                    <div class="infoBlock">
                        <p><span>Благотворительная организация:</span><a href="">ОО "Менің Атамекенім"</a></p>
                        <p><span>В рамках проекта:</span><a href="">"Подари удочку"</a></p>
                        <p><span>Благотворитель:</span><a href="">БФ "Мейірім Жақсылық шуағы"</a></p>
                        <p><span>Дата подачи заявки:</span>10.05.2019</p>
                        <p><span>Дата оказания помощи:</span>19.07.2019</p>
                    </div>

                    <div class="infoBlock">
                        <p><span>Тэги:</span><a href="">Исполнена,</a><a href="">Нур-Султан,</a><a href="">Школьники,</a><a href="">Образование</a></p>
                        <p><span>Описание:</span>"Прошу помочь в оплате обучения за 2019-2020 учебный год в колледже "Туран" <a href="">...читать далее</a></p>
                        <p><a href="">Благодарственное письмо благотворителю, pdf</a></p>
                        <p><span>Дата подачи заявки:</span>10.05.2019</p>
                        <p class="mbuts"><span class="spanTable">Посмотреть все новости по заявке в социальных сетях и СМИ:</span>
                            <a href="" class="socialButtonGlobal"><i class="fab fa-facebook-f"></i></a><a href="" class="socialButtonGlobal"><i class="fab fa-instagram"></i></a>
                            <a href="">tengrinews.kz</a><a href="">7news.kz</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>








    <div class="container-fluid default helperBlock helpInProjectPage">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4>Другие исполненные заявки</h4>
                    <a href="{{route('dev')}}" class="readMore">Смотреть все <span class="miniArrow">›</span></a>
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
                                <p>Регион: <span>@if($help->region){{$help->region->title_ru}}@endif</span></p>
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
@endsection
