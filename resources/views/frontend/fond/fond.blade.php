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
                                <h1>{{$fond['title_'.lang()]??$fond['title_ru']}}</h1>
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
                                                    <p class="name">@if(Auth::check()){{$help->user->first_name}} @else {{gender($help->user->gender)}}  @endif, {{$help->region->title_ru ?? ''}}, {{$help->city->title_ru ?? ''}}</p>
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
                                {!! $fond['about_'.lang()]??$fond['about_ru'] !!}
                            </div>
                            <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).toggleClass('active');$('.blueContent').slideToggle();">{{trans('fonds-page.read-mission')}} <i class="fas fa-chevron-down"></i></button>
                            <div class="blueContent">
                                <p class="name">{{trans('fonds-page.org-mission')}}</p>
                                <p class="textContent">
                                    {!! $fond['mission_'.lang()]??$fond['mission_ru'] !!}
                                </p>
                            </div>
                            <?php $projects = $fond->projects; ?>
                            @if(count($projects)>0)
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
                                            @foreach($projects as $project)
                                                <div>
                                                    <div class="helpBlock">
                                                        <div class="content">
                                                            {{--<p>{{trans('fonds-page.help')}} <span class="tag blue">Спорт</span></p>--}}
                                                            <p>{{trans('fonds-page.name-project')}} <span>{{$project->title}}</span></p>
                                                            <p>{{trans('fonds-page.who')}} <span>{{trans('fonds-page.paral')}}</span></p>
                                                            <p><b>{{trans('fonds-page.desc')}} </b>{!! mb_substr($project->about, 0, 150) !!}...</p>
                                                            <a href="{{ route('innerProject', $project->id) }}" class="more">{{trans('fonds-page.hr')}} <span class="miniArrow">›</span></a>
                                                        </div>
                                                        <p class="date">{{trans('fonds-page.status')}} <span>{{trans('fonds-page.archev')}}</span></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="bottomContent">
                            <?php $offices = $fond->offices; ?>
                            @if(count($offices)>0)
                            <h3>{{trans('fonds-page.org-map')}}</h3>
                            <select name="" onchange="$('.maps').hide();$('.map'+$(this).val()).show();" class="form-control w-25 float-sm-right mr-sm-5" id="">
                                @foreach($offices as $key=> $office)
                                    <option value="{{$office->id}}">{{$office->address}} {{$office->central ? '(Центральный офис)':''}}</option>
                                @endforeach
                            </select>
                            @foreach($offices as $key=> $office)
                                <div class="map{{$office->id}} maps" style="{{$key!=0?'display:none':''}}">
                                    <div id="map{{$office->id}}" class="map" ></div>
                                </div>
                            @endforeach
                            <a href="{{route('request_help')}}" class="btn-default blue">{{trans('fonds-page.appl-ass')}}</a>
                            <script>
                                ymaps.ready(function() {
                                    @foreach($offices as $office)
                                    init('{{$office->id}}', '{{$office->longitude}}', '{{$office->latitude}}', '{{$office['address']}}');
                                    @endforeach
                                });
                                function init(id, longitude = null, latitude = null, title) {
                                    var mapId = 'map' + id;
                                    var myPlacemark,
                                        myMap = new ymaps.Map(mapId, {
                                            zoom: 15,
                                            center: [longitude == '' ? 51.16029659526363 : longitude, latitude == '' ? 71.41972787147488 : latitude],
                                            controls: ['searchControl']
                                        }, {
                                            searchControlProvider: 'yandex#search'
                                        });

                                    myPlacemark = createPlacemark([longitude == '' ? 51.16029659526363 : longitude, latitude == '' ? 71.41972787147488 : latitude], title);
                                    myMap.geoObjects.add(myPlacemark);
                                }
                                function createPlacemark(coords, title) {
                                    return new ymaps.Placemark(coords, {
                                        iconCaption: title
                                    }, {
                                        preset: 'islands#violetDotIconWithCaption',
                                        draggable: false
                                    });
                                }
                            </script>
                                @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="redContent">
                            <h2>{{trans('fonds-page.help-org')}}</h2>
                            <p>{{trans('fonds-page.donated')}} <span>{{$fond->donations ? array_sum(array_column($fond->donations->toArray(),'amount')) . ' тг': ''}}</span></p>
                            <p>{{trans('fonds-page.took-part')}} <span>{{$fond->donations ? count($fond->donations) . ' человек': ''}} </span></p>
                            <p>{{trans('fonds-page.help-text')}}</p>
                            <form>
                                <div class="inputBlock">
                                    <span>Указать сумму</span>
                                    <input type="text" name="AMOUNT" id="sum" placeholder="{{trans('fonds-page.donat-amount')}}">
                                    <label  for="sumInput1" onclick="$('#sum').val(100)">100 тг</label>
                                    <label  for="sumInput2" onclick="$('#sum').val(1000)">1000 тг</label>
                                    <label  for="sumInput3" onclick="$('#sum').val(10000)">10000 тг</label>
                                </div>
                                <div class="inputBlock">
                                    <span>Указать периодичность</span>
                                    <label class="label active" for="dayInput1">Разовое пожертвование</label>
                                    <label class="label" for="dayInput2">каждый день</label>
                                    <label class="label" for="dayInput3">Ежемесячно</label>
                                    <input type="radio" checked onchange="$(this).parents('.inputBlock').find('label').removeClass('active'); if($(this).prop('checked')==true){$('label[for=\'dayInput1\']').addClass('active')}" id="dayInput1" name="time" value="onetime">
                                    <input type="radio" onchange="$(this).parents('.inputBlock').find('label').removeClass('active'); if($(this).prop('checked')==true){$('label[for=\'dayInput2\']').addClass('active')}" id="dayInput2" name="time" value="daily">
                                    <input type="radio" onchange="$(this).parents('.inputBlock').find('label').removeClass('active'); if($(this).prop('checked')==true){$('label[for=\'dayInput3\']').addClass('active')}" id="dayInput3" name="time" value="monthly">
                                </div>
                            </form>
                            <button class="btn-default red" onclick="if($('#sum').val()==''){ $('#sum').css({'border-color':'red'});return false;}$('.modal input[name=\'amount\']').val($('#sum').val()); if($('#dayInput1').is(':checked')){$('#jusan').modal();}else{$('#cloudpayments').modal();}">
                                <img src="/img/help.svg" alt=""> {{trans('fonds-page.supp-org')}}
                            </button>
                        </div>
                        <button class="btn-default d-block d-sm-none mobileOpenContent" onclick="$(this).toggleClass('active');$('.mobileGrayContent').slideToggle();">Смотреть реквизиты <i class="fas fa-chevron-down"></i></button>
                        <?php $requisites = []; ?>
                        @if($fond->requisites)
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
                        <div class="galleryBlock ml-0">
                            <h3>{{trans('fonds-page.photo-org')}}</h3>
                            <div class="row m-0">
                                @foreach($fond->images()->orderBy('orders','asc')->get() as $i=> $image)
                                    @if($i == 3)
                                        @break
                                    @endif
                                        <div class="col-sm-3 col-6"><a href="{{$image->image}}" class="fondImg openGallery" data-lightbox="gallery"><img src="{{$image->image}}" alt=""></a></div>
                                @endforeach
                                @if(count($fond->images)>3)
                                <div class="col-sm-3 col-6"><a href="{{$fond->images[2]->image}}" class="fondImg openGallery" data-lightbox="gallery"><img src="{{$fond->images[2]->image}}" alt=""><span>+{{count($fond->images)-3}}</span></a></div>
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
                    <div class="col-sm-6 rightBlock d-none">
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
                                        <p>{{trans('fonds-page.who')}} <span>@if(Auth::check()){{$help->user->first_name}} {{$help->user->last_name}} @else {{gender($help->user->gender)}}  @endif</span></p>
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
                                        <p>{{trans('fonds-page.who')}} <span>@if(Auth::check()){{$help->user->first_name}} {{$help->user->last_name}} @else {{gender($help->user->gender)}}  @endif</span></p>
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
        <?php $payments = $fond->payments ?>
        @if(count($payments)>0)
            <div class="container-fluid default organizationsBlock inOrganizationsBlock">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>{{trans('fonds-page.th-trusted')}}</h4>
                            <a href="" class="readMore">{{trans('fonds-page.all-see')}} <span class="miniArrow">›</span></a>
                        </div>
    {{--                    <div class="col-sm-6">--}}
    {{--                        <div class="paginationBlock">--}}
    {{--                            <ul class="pagination">--}}
    {{--                                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>--}}
    {{--                                <li class="page-item"><a class="page-link" href="">2</a></li>--}}
    {{--                                <li class="page-item"><a class="page-link" href="">3</a></li>--}}
    {{--                                <li class="page-item"><a class="page-link" href="">4</a></li>--}}
    {{--                                <li class="page-item"><a class="page-link" href="">5</a></li>--}}
    {{--                                <li class="page-item">--}}
    {{--                                    <a class="page-link arrows" href="" rel="prev" aria-label="pagination.previous">‹</a>--}}
    {{--                                </li>--}}
    {{--                                <li class="page-item">--}}
    {{--                                    <a class="page-link arrows" href="" rel="next" aria-label="pagination.next">›</a>--}}
    {{--                                </li>--}}
    {{--                            </ul>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
                        <div class="col-sm-12">
                            <div class="organizationsList">
                                @foreach($payments as $payment)
                                <div class="item">
                                    <ul>
                                        <li><p class="name">Частное лицо</p></li>
                                        <li><p>{{$payment->amount}} тг</p></li>
                                        <li><p>{{date('H:i d-m-Y', strtotime($payment->created_at))}}</p></li>
                                        <li><p>Онлайн перевод</p></li>
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
                            <?php $partners = $fond->partners()->orderBy('orders','asc')->get();?>
                            @foreach($partners as $partner)
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
        @if(count($relatedFonds)>0)
            <div class="container-fluid default otherOrganizations d-none d-sm-block">
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
            @endif
    </div>
@include('frontend.fond.payments.cloudpayment')
@include('frontend.fond.payments.jusan')

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
