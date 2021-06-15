@section('content')
    <div class="container-fluid default organInfoBlock projectPage">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <img src="{{ $project->logo }}" alt="" class="logotype d-block d-sm-none">
                    <h1>{{ $project->title }} - Проект общественного объединения "Менің Атамекенім"</h1>
                </div>
                <div class="col-sm-8">
                    <div class="projectInfo">
                        <p>Название проекта: <span>{{ $project->title }}</span></p>
                        <p>Сектор: <span>@if($project->addHelpType) @foreach($project->addHelpType as $item) {{ $item->name_ru }}, @endforeach @endif</span></p>
                        <p>Веб-сайт: <a href="{{ $project->website }}">{{ $project->website }}</a></p>
                        <p>Дата создания проекта: <span>{{ $project->date_created }}</span></p>
                        <p>Статус: <span>
                            <?php
                                switch ($project->status) {
                                    case 'indefinite':
                                        echo "Бессрочный";
                                        break;
                                    case 'active':
                                        echo "Действующий";
                                        break;
                                    case 'finished':
                                        echo "Завершен: ".$project->finished_date;
                                        break;
                                }
                            ?>
                            </span></p>
                        <p>Бенефициары проекта: <span>
                                @if($project->scenarios)
                                    @foreach($project->scenarios as $item)
                                        @switch($item->id)
                                            @case(2)
                                            отдельные лица (адресная помощь),
                                            @break
                                            @case(1)
                                            семьи,
                                            @break
                                            @case(4)
                                            сообщества,
                                            @break
                                            @case(5)
                                            организации,
                                            @case(6)
                                            животные,
                                            @break
                                        @endswitch
                                    @endforeach
                                @endif
                            </span></p>
                        <p>География ведения проекта: <span>--</span></p>
                        {{--<p>Главный партнер проекта: <a>ТОО "English.kz"</a></p>--}}
                        <p>Партнеры:
                            @if($project->hasPartners)
                                @foreach($project->hasPartners as $item)<a href="@if($item->url){{ $item->url }}@endif">{{ $item->name }}</a>, @endforeach
                            @endif
                        </p>
                        <p>Спонсоры:
                            @if($project->hasSponsors)
                                @foreach($project->hasSponsors as $item)<a href="@if($item->url){{ $item->url }}@endif">{{ $item->name }}</a>, @endforeach
                            @endif
                        </p>
                        {{--<p>Количество людей, получивших помощь: <span>35 человек</span></p>--}}
                        <p>Проект в социальных сетях:
                            @if($project->instagram)<a href="{{ $project->instagram }}" class="socialButtonGlobal"><i class="fab fa-instagram"></i></a>@endif
                            @if($project->facebook)<a href="{{ $project->facebook }}" class="socialButtonGlobal"><i class="fab fa-facebook-f"></i></a>@endif
                            @if($project->youtube)<a href="{{ $project->youtube }}" class="socialButtonGlobal"><i class="fab fa-youtube"></i></a>@endif
                            @if($project->whatsapp)<a href="{{ $project->whatsapp }}" class="socialButtonGlobal"><i class="fab fa-whatsapp"></i></a>@endif
                            @if($project->telegram)<a href="{{ $project->telegram }}" class="socialButtonGlobal"><i class="fab fa-telegram-plane"></i></a>@endif
                        </p>
                        <p>Поделиться
                            <a href="" class="socialButtonGlobal"><i class="fas fa-share-alt"></i></a>
                        </p>

                        {{--<a href="" class="btn-default blue absol">Отчеты по проекту</a>--}}
                    </div>
                    <div class="ptojectContent">
                        <p class="name">Описание проекта:</p>
                        <p class="descr">
                            <span>
                                {!! $project->about !!}
                            </span>
                            <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).siblings('span').css('height','auto');$(this).remove();">Читать описание проекта <i class="fas fa-chevron-down"></i></button>
                        </p>
                    </div>
                    @if(count($project->hasGallery) > 0)
                        <div class="galleryBlock">
                            <h3>Фотоархив проекта</h3>
                            <div class="row">
                                    @foreach($project->hasGallery as $item)
                                        <div class="col-sm-2 col-6"><a href="" class="fondImg"><img src="{{ $item->img }}" alt=""></a></div>
                                    @endforeach
                                {{--<div class="col-sm-2 col-6"><a href="" class="fondImg openGallery"><img src="/img/about.png" alt=""><span>+20</span></a></div>--}}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="{{ $project->logo }}" alt="" class="logotype">
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
                        <div class="col-sm-12">
                            <a href="" class="btn-default allReviews">Все отзывы</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








    {{--<div class="container-fluid default helperBlock helpInProjectPage d-none d-sm-block">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-sm-12">--}}
                    {{--<h4>Реализованные заявки в рамках проекта</h4>--}}
                    {{--<a href="" class="readMore">Смотреть все <span class="miniArrow">›</span></a>--}}
                {{--</div>--}}
                {{--<div class="col-sm-3">--}}
                    {{--<div class="helpBlock">--}}
                        {{--<div class="content">--}}
                            {{--<p>Помощь: <span class="tag blue">Образование</span></p>--}}
                            {{--<p>Организация: <img src="/img/logo.svg" alt=""></p>--}}
                            {{--<p>Кому: <span>Кайрат Жомарт</span></p>--}}
                            {{--<p>Сумма: <span>1,150,000 тг.</span></p>--}}
                            {{--<a href="" class="more">Подробнее <span class="miniArrow">›</span></a>--}}
                        {{--</div>--}}
                        {{--<p class="date">19.10.2019</p>--}}
                        {{--<img src="/img/support1.svg" alt="" class="bkg">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-3">--}}
                    {{--<div class="helpBlock">--}}
                        {{--<div class="content">--}}
                            {{--<p>Помощь: <span class="tag green">Образование</span></p>--}}
                            {{--<p>Организация: <img src="/img/logo.svg" alt=""></p>--}}
                            {{--<p>Кому: <span>Кайрат Жомарт</span></p>--}}
                            {{--<p>Сумма: <span>1,150,000 тг.</span></p>--}}
                            {{--<a href="" class="more">Подробнее <span class="miniArrow">›</span></a>--}}
                        {{--</div>--}}
                        {{--<p class="date">19.10.2019</p>--}}
                        {{--<img src="/img/support2.svg" alt="" class="bkg">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-3">--}}
                    {{--<div class="helpBlock">--}}
                        {{--<div class="content">--}}
                            {{--<p>Помощь: <span class="tag red">Образование</span></p>--}}
                            {{--<p>Организация: <img src="/img/logo.svg" alt=""></p>--}}
                            {{--<p>Кому: <span>Кайрат Жомарт</span></p>--}}
                            {{--<p>Сумма: <span>1,150,000 тг.</span></p>--}}
                            {{--<a href="" class="more">Подробнее <span class="miniArrow">›</span></a>--}}
                        {{--</div>--}}
                        {{--<p class="date">19.10.2019</p>--}}
                        {{--<img src="/img/support3.svg" alt="" class="bkg">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-3">--}}
                    {{--<div class="helpBlock">--}}
                        {{--<div class="content">--}}
                            {{--<p>Помощь: <span class="tag red">Образование</span></p>--}}
                            {{--<p>Организация: <img src="/img/logo.svg" alt=""></p>--}}
                            {{--<p>Кому: <span>Кайрат Жомарт</span></p>--}}
                            {{--<p>Сумма: <span>1,150,000 тг.</span></p>--}}
                            {{--<a href="" class="more">Подробнее <span class="miniArrow">›</span></a>--}}
                        {{--</div>--}}
                        {{--<p class="date">19.10.2019</p>--}}
                        {{--<img src="/img/support4.svg" alt="" class="bkg">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <script>
        $(document).ready(function () {
            $('.reviewSlick').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        });
    </script>
@endsection

@extends('frontend.layout')
