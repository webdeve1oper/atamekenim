@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid slide">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>{{trans('home.main-h1')}}</h1>
                        <p class="descr">{{trans('home.main-descr')}}</p>
                        <a href="{{route('request_help')}}" class="btn-default blue">{{trans('home.apply-for-assistance')}}</a>
                        <a href="{{route('registration_fond')}}" class="btn-default">{{trans('home.partic')}}</a>
                    </div>
                </div>
                <img src="/img/slide.svg" alt="" class="slideImg">
            </div>
        </div>
        <div class="container-fluid default organizationsBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>{{trans('home.main-h2')}}</h2>
                        <p class="descr">{{trans('home.filtrdescr')}}</p>
                    </div>
                    <div class="col-sm-12">
                        <form id="formSearch" action="{{route('fonds')}}">
                            @csrf
                            <input type="text" name="bin" placeholder="{{trans('home.searchbin')}}">
                            <select name="baseHelpTypes[]" id="select1">
                                <option value="all">{{trans('home.sector-activities')}}</option>
                                @foreach($baseHelpTypes as $help)
                                    <option  value="{{$help->id}}">
                                        {{$help['name_'.app()->getLocale()]}}
                                    </option>
                                @endforeach
                            </select>
                            <select name="destination[]" id="select2" style="max-width: 300px;">
                                <option value="all">{{trans('home.adresat')}}</option>
                                @foreach($destionations as $destination)
                                    <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                @endforeach
                            </select>
                            {{--<select name="city[]" id="select3">--}}
                                {{--<option value="all">Все города</option>--}}
                                {{--@foreach($cities as $id => $city)--}}
                                    {{--<option value="{{$id}}">{{$city}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                            <button>{{trans('home.found')}}</button>
                        </form>
                        <a href="{{route('dev')}}" class="btn-default openMap">{{trans('home.map-fonds')}}</a>
                    </div>

                    <div class="col-12" id="fond_lists">
                        @include('frontend.home_fond_list')
                    </div>
                    <div class="col-sm-12">
                        <a class="btn-default" href="{{route('fonds')}}">{{trans('home.all-org')}}<span class="miniArrow">›</span></a>
                        <button class="btn-default blue">{{trans('home.hepls-fonds')}}</button>
                        <a href="{{route('registration_fond')}}" class="btn-default blue">{{trans('home.reg-reestr')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default newMembers">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>{{trans('home.news-usr-reestr')}}</h2>
                        <a href="{{route('fonds')}}" class="readMore">{{trans('home.hr')}} <span class="miniArrow">›</span></a>
                    </div>
                    <div class="col-sm-6">
                        {{--<div class="dropdown">--}}
                            {{--<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                {{--По сектору деятельности--}}
                            {{--</button>--}}
                            {{--<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">--}}
                                {{--<a class="dropdown-item" href="#">За все время</a>--}}
                                {{--<a class="dropdown-item" href="#">За все время</a>--}}
                                {{--<a class="dropdown-item" href="#">За все время</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <div class="col-sm-6">
                        <div class="paginationBlock">
                            <ul class="pagination">
                                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
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
                                        <li><a href="{{route('innerFond', [$fond->id])}}" class="name">{{$fond['title_'.lang()]??$fond['title_ru']}}</a></li>
                                        <li>
                                            @foreach($fond->baseHelpTypes()->get() as $help){{$help['name_'.app()->getLocale()]}}, @endforeach
                                        </li>
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
                        <h3>{{trans('home.have-helps')}}</h3>
                        <form action="" id="helpForm">
                            <div class="inputBlock">
                                <label for="input1">{{trans('home.your-iin')}}</label>
                                <input type="text" id="input1" placeholder="{{trans('home.12-num')}}">
                            </div>
                            <div class="inputBlock">
                                <label for="citySelector">{{trans('home.your-regions')}}</label>
                                <select name="" id="citySelector">
                                    <option value="">{{trans('home.select-region')}}</option>
                                    @foreach($cities as $city)
                                        <option  value="{{$city->id}}">
                                            {{$city['title_'.app()->getLocale()]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="inputBlock">
                                <label for="input3">{{trans('home.your-number')}}</label>
                                <input type="text" id="input3" placeholder="8 (7**) *** *** **">
                            </div>
                            <div class="inputBlock topper">
                                <button>{{trans('home.apply')}}</button>
                            </div>
                            <div class="inputBlock topper">
                                <p class="regulations">{{trans('home.helps-offerts')}}</p>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <p class="bigName">{{trans('home.what-regis')}}</p>
                        <p class="descr">
                            {{trans('home.what-regis-text')}}
                        </p>
                        <a href="{{route('login')}}" class="btn-default blue"><img src="/img/lofin.svg" alt="">{{trans('auth.sign-in')}}</a>
                        <a href="{{route('registration_user')}}" class="btn-default transparent">{{trans('auth.sign-up')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default whyRegisterBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <h3>{{trans('home.what-regis-org')}}</h3>
                        <p class="descr">{{trans('home.what-regis-org-text')}}</p>
                        <a href="{{route('dev')}}" class="btn-default blue">{{trans('home.hr')}}</a>
                    </div>
                    <div class="col-sm-7">
                        <h3>{{trans('home.advant-regis')}}</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="problemBlock">
                                    <div class="imgBlock"><img src="/img/icon1.svg" alt=""></div>
                                    <div class="content">
                                        <p class="name">{{trans('home.confession')}}</p>
                                        <p class="descr">{{trans('home.confession-text')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="problemBlock">
                                    <div class="imgBlock"><img src="/img/icon2.svg" alt=""></div>
                                    <div class="content">
                                        <p class="name">{{trans('home.digital')}}</p>
                                        <p class="descr">{{trans('home.digital-text')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="problemBlock">
                                    <div class="imgBlock"><img src="/img/icon1.svg" alt=""></div>
                                    <div class="content">
                                        <p class="name">{{trans('home.convenience')}}</p>
                                        <p class="descr">{{trans('home.convenience-text')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="problemBlock">
                                    <div class="imgBlock"><img src="/img/icon2.svg" alt=""></div>
                                    <div class="content">
                                        <p class="name">{{trans('home.security')}}</p>
                                        <p class="descr">{{trans('home.security-text')}}</p>
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
                        <h4>{{trans('home.who-help')}}</h4>
                        <a href="{{route('dev')}}" class="readMore">{{trans('home.all-see')}}<span class="miniArrow">›</span></a>
                    </div>
                    <div class="col-sm-6 rightBlock">
                        <p class="status">{{trans('home.total-appl')}} <span>{{$helpsCount}}</span></p>
                        <p class="status">{{trans('home.well-done')}} <span>{{$helps->total()}}</span></p>
                    </div>
                    @foreach($helps as $help)
                        <div class="col-sm-3">
                            <div class="helpBlock">
                                <div class="content">
                                    <p>Помощь: <span class="tag blue">@foreach($help->addHelpTypes as $helps){{$helps->name_ru}}@endforeach</span></p>
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
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>{{trans('home.new-appl')}}</h4>
                        <a href="" class="readMore">{{trans('home.all-see')}}<span class="miniArrow">›</span></a>
                    </div>
                    <div class="col-sm-6 rightBlock">
                        <p class="status">{{trans('home.under-conside')}} <span>{{$newHelps->total()}}</span></p>
                    </div>
                    @foreach($newHelps as $help)
                    <div class="col-sm-3">
                        <div class="helpBlock newHelp">
                            <div class="content">
                                <p>Помощь: <span class="tag blue">@foreach($help->addHelpTypes as $helps){{$helps->name_ru}}@endforeach</span></p>
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

        <div class="container-fluid default faqBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>{{trans('home.faq2')}}</h4>
                        <button class="btn-default blue">{{trans('home.ask-question')}}</button>
                        <button class="btn-default">{{trans('home.coll-center')}}</button>
                    </div>
                    <div class="col-sm-12">
                        <div id="accordion" class="accordion">
                            <div class="card active">
                                <div class="card-header" id="headingOne">
                                    <p class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            {{trans('home.how-to-reestr')}}<i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        {{trans('home.how-to-reestr-text')}}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <p class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            {{trans('home.how-to-helps')}}<i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        {{trans('home.how-to-helps-text')}}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <p class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            {{trans('home.how-to-needy')}}<i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        {{trans('home.how-to-needy-text')}}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <p class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            {{trans('home.freq-ask-questions')}}<i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="card-body">
                                        {{trans('home.freq-ask-questions-text')}}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFive">
                                    <p class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            {{trans('home.faq-ask-questions1')}}<i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                    <div class="card-body">
                                        {{trans('home.faq-ask-questions1-text')}}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingSix">
                                    <p class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                            {{trans('home.faq-ask-questions2')}}<i class="fas fa-angle-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                    <div class="card-body">
                                        {{trans('home.faq-ask-questions2-text')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h4>{{trans('home.faq3')}}</h4>
                    </div>
                    <div class="col-sm-12">
                         <div id="accordion2" class="accordion">
                             <div class="card">
                                 <div class="card-header" id="headinOne">
                                     <p class="mb-0">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapeOne" aria-expanded="false" aria-controls="collapeOne" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                             {{trans('home.rfaq1')}}<i class="fas fa-angle-down"></i>
                                         </button>
                                     </p>
                                 </div>
                                 <div id="collapeOne" class="collapse" aria-labelledby="headinOne" data-parent="#accordion">
                                     <div class="card-body">
                                         {{trans('home.rfaq1-text')}}
                                     </div>
                                 </div>
                             </div>
                             <div class="card">
                                 <div class="card-header" id="headinTwo">
                                     <p class="mb-0">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapeTwo" aria-expanded="false" aria-controls="collapeTwo" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                             {{trans('home.rfaq2')}}<i class="fas fa-angle-down"></i>
                                         </button>
                                     </p>
                                 </div>
                                 <div id="collapeTwo" class="collapse" aria-labelledby="headinTwo" data-parent="#accordion">
                                     <div class="card-body">
                                         {{trans('home.rfaq2-text')}}
                                     </div>
                                 </div>
                             </div>
                             <div class="card">
                                 <div class="card-header" id="headinThree">
                                     <p class="mb-0">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapeThree" aria-expanded="false" aria-controls="collapeThree" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                             {{trans('home.rfaq3')}}<i class="fas fa-angle-down"></i>
                                         </button>
                                     </p>
                                 </div>
                                 <div id="collapeThree" class="collapse" aria-labelledby="headinThree" data-parent="#accordion">
                                     <div class="card-body">
                                         {{trans('home.rfaq3-text')}}
                                     </div>
                                 </div>
                             </div>
                             <div class="card">
                                 <div class="card-header" id="headinFour">
                                     <p class="mb-0">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapeFour" aria-expanded="false" aria-controls="collapeFour" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                             {{trans('home.rfaq4')}}<i class="fas fa-angle-down"></i>
                                         </button>
                                     </p>
                                 </div>
                                 <div id="collapeFour" class="collapse" aria-labelledby="headinFour" data-parent="#accordion">
                                     <div class="card-body">
                                         {{trans('home.rfaq4-text')}}
                                     </div>
                                 </div>
                             </div>
                             <div class="card">
                                 <div class="card-header" id="headinFive">
                                     <p class="mb-0">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapeFive" aria-expanded="false" aria-controls="collapeFive" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                             {{trans('home.rfaq5')}}<i class="fas fa-angle-down"></i>
                                         </button>
                                     </p>
                                 </div>
                                 <div id="collapeFive" class="collapse" aria-labelledby="headinFive" data-parent="#accordion">
                                     <div class="card-body">
                                         {{trans('home.rfaq5-text')}}
                                     </div>
                                 </div>
                             </div>
                             <div class="card">
                                 <div class="card-header" id="headinSix">
                                     <p class="mb-0">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapeSix" aria-expanded="false" aria-controls="collapeSix" onclick="$('.card').removeClass('active');$(this).parents('.card').addClass('active');">
                                             {{trans('home.rfaq6')}}<i class="fas fa-angle-down"></i>
                                         </button>
                                     </p>
                                 </div>
                                 <div id="collapeSix" class="collapse" aria-labelledby="headinSix" data-parent="#accordion">
                                     <div class="card-body">
                                         {{trans('home.rfaq6-text')}}
                                     </div>
                                 </div>
                             </div>
                             <button class="btn-default d-none">{{trans('home.see-more')}}<i class="fas fa-angle-down"></i></button>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default newsBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>{{trans('home.news')}}</h4>
                    </div>
                    <div class="col-sm-12">
                        <ul class="newsTabs">
                            <li><a href="" class="active">{{trans('home.last-news')}}</a></li>
{{--                            <li><a href="">{{trans('home.info-for-fond')}}</a></li>--}}
{{--                            <li><a href="">{{trans('home.info-for-benecif')}}</a></li>--}}
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
{{--                        <a href="{{route('news')}}" class="readMore">{{trans('home.read-all-news')}} <span class="miniArrow">›</span></a>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid default ourPartners">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>{{trans('home.our-partnres')}}</h4>
{{--                        <a href="{{route('dev')}}" class="readMore">{{trans('home.all-see')}}<span class="miniArrow">›</span></a>--}}
                    </div>
                    <div class="col-sm-12 partners">
                        <div class="row">
                            <div class="col">
                                <div class="block">
                                    <img src="/img/atameken.png" alt="">
                                    <p>{{trans('home.atameken')}}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="block">
                                    <img src="/img/goverment.png" alt="">
                                    <p>{{trans('home.m-edu')}}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="block">
                                    <img src="/img/goverment.png" alt="">
                                    <p>{{trans('home.m-tszn')}}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="block">
                                    <img src="/img/kaspi.png" alt="">
                                    <p>{{trans('home.kaspi')}}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="block">
                                    <img src="/img/kior.png" alt="">
                                    <p>{{trans('home.kior')}}</p>
                                </div>
                            </div>
                            {{--<div class="col-sm-2">--}}
                                {{--<div class="block">--}}
                                    {{--<img src="/img/goverment.png" alt="">--}}
                                    {{--<p>{{trans('home.m-tszn')}}</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
