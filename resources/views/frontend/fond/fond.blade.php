@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" />
    <div class="fatherBlock">
        <div class="container-fluid default breadCrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href="/">{{trans('fonds-page.main')}}</a></li>
                            <li><a href="{{route('fonds')}}">{{trans('fonds-page.reestr')}}</a></li>
                            <li><a href="/fond/{{$fond->id}}">{{$fond['title_'.app()->getLocale()] ?? $fond['']}}</a></li>
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
                                    {{--<p class="greyText">Рейтинг: <span class="green">95</span></p>--}}
                                    <a href="" class="socialButtonGlobal"><i class="fas fa-share-alt"></i></a>
                                </div>
                                <h1>{{$fond['title_'.app()->getLocale()] ?? $fond['']}}</h1>
                                <p class="category">{{$fond->sub_title}}</p>
                                <p>{{trans('fonds-page.united')}} <span href="">{{$fond->country->title_ru??'Казахстан'}}</span></p>
                                <p>{{trans('fonds-page.site')}} <a href="">{{$fond->website??'не указан'}}</a></p>
                                <p>{{trans('fonds-page.region-helps')}} <a href="">@foreach($fond->regions as $i => $help)<a
                                                href="">{{$help['title_'.app()->getLocale()]}}</a>@if(!$loop->last),@endif @endforeach</a></p>
                                <p>{{trans('fonds-page.add-sector-activity')}}
                                    @foreach($fond->baseHelpTypes as $i => $help)
                                        <a  href="#"> {{$help['name_'.app()->getLocale()]}}</a>@if(!$loop->last),@endif
                                    @endforeach
                                </p>
                                <p>{{trans('fonds-page.united')}} @foreach($fond->addHelpTypes as $i => $help)<a href="">{{$help['name_'.app()->getLocale()]}}</a>@if(!$loop->last),@endif @endforeach</p>
                                <p>{{trans('fonds-page.close-appl')}} <span>{{$fond->helpsByStatus('finished')->count()}}</span></p>
                                <p>{{trans('fonds-page.total-amount')}} <span>{{$fond->help_cash}} тенге</span></p>
                                <p class="inline">{{trans('fonds-page.number-reviews')}} <span>{{$fond->reviews()->count()}}</span></p>
                                <p class="inline">{{trans('fonds-page.see')}} <a href="">{{trans('fonds-page.good')}}</a><a href="">{{trans('fonds-page.bad')}}</a></p>
                                <p>{{trans('fonds-page.social')}}
                                    <?php $socials = []; ?>
                                    @if($fond->social)
                                        <?php
                                        $socials = json_decode($fond->social, true);
                                        ?>
                                        @foreach($socials as $i=> $social)
                                                <a href="{{$social['link']}}">
                                                    @if(strpos($social['link'], 'instagram'))
                                                        <i class="fab fa-instagram"></i>
                                                    @elseif(strpos($social['link'], 'facebook'))
                                                        <i class="fab fa-facebook"></i>
                                                    @elseif(strpos($social['link'], 'vk'))
                                                        <i class="fab fa-vk"></i>
                                                    @endif
                                                </a>
                                        @endforeach
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="bigName">{{trans('fonds-page.last-reviews')}}</p>
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
                                    <div class="nothingReviews">
                                        <div class="block">
                                            <p class="name">{{trans('fonds-page.no-reviews')}}</p>
                                        </div>
                                    </div>
                                    @foreach($fond->helps as $help)
                                        @foreach($help->reviews()->get() as $review)
                                            <div>
                                                <div class="block">
                                                    <p class="name">{{$help->user->first_name}}, {{$help->region->title_ru}}, {{$help->city->title_ru}}</p>
                                                    <p class="descr textContent">
                                                        {{$review->body}}
                                                    </p>
                                                    <script>
                                                        $('.nothingReviews').remove();
                                                    </script>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach


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
                        <h2>{{trans('fonds-page.about-fond')}}</h2>
                        <a href="{{route('request_help')}}" class="btn-default" @if(!Auth::user())onclick="window.location = '{{route('login')}}'" @endif>{{trans('fonds-page.appl-ass')}}</a>
                        <div class="content">
                            <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).toggleClass('active');$('.openContentMobile').slideToggle();">{{trans('fonds-page.read-fond')}} <i class="fas fa-chevron-down"></i></button>
                            <div class="textContent openContentMobile">
                                {!! $fond['about_'.app()->getLocale()] !!}
                            </div>
                            <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).toggleClass('active');$('.blueContent').slideToggle();">{{trans('fonds-page.read-mission')}} <i class="fas fa-chevron-down"></i></button>
                            <div class="blueContent">
                                <p class="name">{{trans('fonds-page.org-mission')}}</p>
                                <p class="textContent">
                                    {!! $fond['mission_'.app()->getLocale()] !!}
                                </p>
                            </div>

                            <div class="projectsBlock">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="name">{{trans('fonds-page.project-fond')}}</p>
                                        <a href="" class="readMore">{{trans('fonds-page.all-see')}} <span class="miniArrow">›</span></a>
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
                                                            <p>{{trans('fonds-page.help')}} <span class="tag blue">Спорт</span></p>
                                                            <p>{{trans('fonds-page.name-project')}} <span>{{$project->title}}</span></p>
                                                            <p>{{trans('fonds-page.who')}} <span>{{trans('fonds-page.paral')}}</span></p>
                                                            <p><b>{{trans('fonds-page.desc')}} </b>{!! mb_substr($project->about, 0, 150) !!}...</p>
                                                            <a href="" class="more">{{trans('fonds-page.hr')}} <span class="miniArrow">›</span></a>
                                                        </div>
                                                        <p class="date">{{trans('fonds-page.status')}} <span>{{trans('fonds-page.archev')}}</span></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bottomContent">
                            <h3>{{trans('fonds-page.org-map')}}</h3>
                            <div id="map" class="map"></div>
                            <a href="{{route('request_help')}}" class="btn-default blue">{{trans('fonds-page.appl-ass')}}</a>
                            <script>
                                ymaps.ready(init);

                                function init() {
                                    var myPlacemark,
                                        myMap = new ymaps.Map('map', {
                                            @if($fond->longitude && $fond->latitude)
                                            center: [{{$fond->longitude}}, {{$fond->latitude}}],
                                            zoom: 15,
                                            @else
                                            center: [48.045133, 67.492732],
                                            zoom: 5,
                                            @endif
                                            controls: ['searchControl']
                                        }, {
                                            searchControlProvider: 'yandex#search'
                                        });
                                    @if($fond->longitude && $fond->latitude)
                                        myPlacemark =  new ymaps.Placemark([{{$fond->longitude}}, {{$fond->latitude}}]);
                                    myMap.geoObjects.add(myPlacemark);
                                    @endif
                                }
                            </script>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="redContent">
                            <h2>{{trans('fonds-page.help-org')}}</h2>
                            <p>{{trans('fonds-page.donated')}} <span>100 000 000 тенге</span></p>
                            <p>{{trans('fonds-page.took-part')}} <span>4000 человек</span></p>
                            <p>{{trans('fonds-page.help-text')}}</p>
                            <form action="https://ecom.jysanbank.kz:8462/ecom/api" method="POST">
                                <div class="inputBlock">
                                    <input type="hidden" name="ORDER" value="{{$orderId}}">
                                    <span>{{trans('fonds-page.spec-amount')}}</span>
                                    <input type="text" name="AMOUNT" id="sum" placeholder="{{trans('fonds-page.donat-amount')}}">
                                    <input type="hidden" name="CURRENCY" value="KZT">
                                    <input type="hidden" name="MERCHANT" value="atamekenim.kz">
                                    <input type="hidden" name="TERMINAL" value="12200005">
                                    <input type="hidden" name="LANGUAGE" value="ru">
                                    <input type="hidden" name="CLIENT_ID" value="{{$orderId}}">
                                    <input type="hidden" name="DESC" value="test">
                                    <input type="hidden" name="DESC_ORDER" value="">
                                    <input type="hidden" name="EMAIL" value="">
                                    <input type="hidden" name="BACKREF" value="https://www.google.kz">
                                    <input type="hidden" name="Ucaf_Flag" value="">
                                    <input type="hidden" name="Ucaf_Authentication_Data" value="">
                                    <input type="hidden" name="crd_pan" value="">
                                    <input type="hidden" name="crd_exp" value="">
                                    <input type="hidden" name="crd_cvc" value="">
                                    <input type="hidden" name="P_SIGN" value="{{$vSign}}">
                                    <label for="sumInput1" onclick="$('#sum').val(100)">100</label>
                                    <label for="sumInput2" onclick="$('#sum').val(1000)">1000</label>
                                    <label for="sumInput3" onclick="$('#sum').val(10000)">10000</label>
                                </div>
{{--                                <div class="inputBlock d-none">--}}
{{--                                    <span>Указать сумму</span>--}}
{{--                                    <label for="dayInput1">Разовое пожертвование</label>--}}
{{--                                    <label for="dayInput2">каждый день</label>--}}
{{--                                    <label for="dayInput3">Ежемесячно</label>--}}
{{--                                    <input type="radio" id="dayInput1" name="day" value="Разовое пожертвование">--}}
{{--                                    <input type="radio" id="dayInput2" name="day" value="Каждый день">--}}
{{--                                    <input type="radio" id="dayInput3" name="day" value="Ежемесячно">--}}
{{--                                </div>--}}
                                <input type="hidden" name="DESC_ORDER" value="Помощь фонду {{$fond['title_'.app()->getLocale()] ?? $fond['title_ru']}}">
                                <button class="btn-default red" type="submit">
                                    <img src="/img/help.svg" alt=""> {{trans('fonds-page.supp-org')}}
                                </button>
                            </form>
                        </div>

                        <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).toggleClass('active');$('.mobileGrayContent').slideToggle();">Смотреть реквизиты <i class="fas fa-chevron-down"></i></button>
                        <?php $requisites = []; ?>
                        @if($fond->requisites)
                            <?php
                            $requisites = json_decode($fond->requisites, true);
                            ?>
                            @foreach($requisites as $requisite)
                        <div class="grayContent mobileGrayContent">
                            <h3>{{trans('fonds-page.rec')}}</h3>
                            <p><b>{{trans('fonds-page.ceo')}}</b> {{$requisite['leader']}} </p>
                            <p><b>{{trans('fonds-page.address')}}</b> {{$requisite['address']}} </p>
                            <p><b>{{trans('fonds-page.phone')}}</b> {{$requisite['phone']}} </p>
                            <p><b>{{trans('fonds-page.email')}}</b> {{$requisite['email']}}</p>
                        </div>
                            @endforeach
                            @endif
                    </div>



                    @if(count($fond->images)>0)
                    <div class="col-sm-4 bottomContent">
                        <div class="galleryBlock">
                            <h3>{{trans('fonds-page.photo-org')}}</h3>
                            <div class="row">
                                @foreach($fond->images as $i=> $image)
                                    @if($i == 3)
                                        @break
                                    @endif
                                        <div class="col-sm-3 col-6"><a href="{{$image->image}}" class="fondImg openGallery" data-lightbox="gallery"><img src="{{$image->image}}" alt=""></a></div>
                                @endforeach
                                @if(count($fond->images)>2)
                                <div class="col-sm-3 col-6"><a href="{{$fond->images[3]->image}}" class="fondImg openGallery" data-lightbox="gallery"><img src="{{$fond->images[3]->image}}" alt=""><span>+{{count($fond->images)-4}}</span></a></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($fond->helpsByStatus('process')->first())
        <div class="container-fluid default helperBlock d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>{{trans('fonds-page.in-work')}}</h4>
                        {{--<a href="" class="readMore">Смотреть все <span class="miniArrow">›</span></a>--}}
                    </div>
                    <div class="col-sm-6 rightBlock">
                        <p class="d-inline-block mr-3">{{trans('fonds-page.sort-ret')}}</p>
                        <div class="dropdown organizationDrop">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{trans('fonds-page.sort-ret')}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">{{trans('fonds-page.sort-ret')}}</a>
                                <a class="dropdown-item" href="#">{{trans('fonds-page.sort-ret')}}</a>
                                <a class="dropdown-item" href="#">{{trans('fonds-page.sort-ret')}}</a>
                            </div>
                        </div>
                    </div>
                    @foreach($fond->helps as $help)
                        @if($help->fond_status == 'process')
                            <div class="col-sm-3">
                                <div class="helpBlock">
                                    <div class="content">
                                        <p>{{trans('fonds-page.help')}} <span class="tag blue">{{$help->addHelpTypes[0]->name_ru}}</span></p>
                                        <p>{{trans('fonds-page.org')}} <img src="/img/logo.svg" alt=""></p>
                                        <p>{{trans('fonds-page.who')}} <span>{{$help->user->first_name}} {{$help->user->last_name}}</span></p>
                                        {{--<p>Сумма: <span>1,150,000 тг.</span></p>--}}
                                        <a href="{{route('help', [$help->id])}}" class="more">{{trans('fonds-page.hr')}} <span class="miniArrow">›</span></a>
                                    </div>
                                    <p class="date">{{$help->date_fond_finish}}</p>
                                    <img src="/img/support1.svg" alt="" class="bkg">
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
            @endif
            @if($fond->helpsByStatus('finished')->first())
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>{{trans('fonds-page.who-help-fond')}}</h4>
                    </div>
                    <div class="col-sm-6 rightBlock">
                        <p class="status">{{trans('fonds-page.all-reviews')}} <span>{{$fond->helps->count()}}</span></p>
                        <p class="status finishedCount">{{trans('fonds-page.well-done')}} <span>0</span></p>
                    </div>
                    <?php $i = 0; ?>
                    @foreach($fond->helps as $help)
                        @if($help->fond_status == 'finished')
                            <div class="col-sm-3">
                                <div class="helpBlock">
                                    <div class="content">
                                        <p>{{trans('fonds-page.help')}} <span class="tag blue">{{$help->addHelpTypes[0]->name_ru}}</span></p>
                                        <p>{{trans('fonds-page.org')}} <img src="/img/logo.svg" alt=""></p>
                                        <p>{{trans('fonds-page.who')}} <span>{{$help->user->first_name}} {{$help->user->last_name}}</span></p>
                                        {{--<p>Сумма: <span>1,150,000 тг.</span></p>--}}
                                        <a href="{{route('help', [$help->id])}}" class="more">{{trans('fonds-page.hr')}} <span class="miniArrow">›</span></a>
                                    </div>
                                    <p class="date">{{$help->date_fond_finish}}</p>
                                    <img src="/img/support1.svg" alt="" class="bkg">
                                </div>
                            </div>
                            <?php $i +=1; ?>
                        @endif
                    @endforeach
                    <script>
                        $('.finishedCount span').text({{$i}});
                    </script>
                </div>
            </div>
                @endif
        </div>

        <div class="container-fluid default organizationsBlock inOrganizationsBlock d-none">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>{{trans('fonds-page.th-trusted')}}</h4>
                        <a href="" class="readMore">{{trans('fonds-page.all-see')}} <span class="miniArrow">›</span></a>
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
        @if(count($fond->partners)>0)
        <div class="container-fluid default ourPartners d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>{{trans('fonds-page.partners-org')}}</h4>
                        {{--<a href="" class="readMore">Смотреть все <span class="miniArrow">›</span></a>--}}
                    </div>
                    <div class="col-sm-12 partners">
                        <div class="row">
                            @foreach($fond->partners as $partner)
                            <div class="col-sm-2">
                                <div class="block">
                                    <img src="{{$partner->image}}" alt="">
                                    <p>{{$partner->title}}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="container-fluid default otherOrganizations d-none">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>{{trans('fonds-page.similar-charities')}}</h4>
                    </div>
                    @foreach($relatedFonds as $relatedFond)
                    <div class="col-sm-3">
                        <div class="block">
                            <a href="{{route('innerFond', [$relatedFond->id])}}">
                                <img src="{{$relatedFond->logo ?? '/img/no-photo.png'}}" alt="">
                                <p>{{$relatedFond['title_'.app()->getLocale()] ?? $relatedFond['title_ru']}}</p>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
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

</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js' integrity='sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==' crossorigin='anonymous'></script>
";
?>

@extends('frontend.layout', ['script'=>$script])
