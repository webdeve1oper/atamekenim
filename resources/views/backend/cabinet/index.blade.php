@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default accountMenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{trans('cabinet-appl.appl-personal-page')}}</h1>
                        <ul class="myAccountMenu">
                            <li><a href="{{route('history')}}">{{trans('cabinet-appl.hist-mess')}}</a></li>
                            <li><a href="{{route('reviews')}}">{{trans('cabinet-appl.my-rev')}}</a></li>
                            <li><a href="">{{trans('cabinet-appl.message')}}</a></li>
                            <li><a href="">{{trans('cabinet-appl.my-photo')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row"><div class="col-12">@include('frontend.alerts')</div></div>
        </div>
        <div class="container-fluid default myOrganizationContent myAccountPage">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="greyInfoBlock accountInfo">
                            <div class="row">
                                <div class="col-sm-2 col-4">
                                    @if(Auth::user()->avatar)
                                        <img src="{{Auth::user()->avatar}}" alt="" class="avatar">
                                    @else
                                        <img src="/img/no-photo.png" alt="" class="avatar">
                                    @endif
                                </div>
                                <div class="col-sm-10 col-8">
                                    <p class="name">{{trans('cabinet-appl.welcome')}}, {{Auth::user()->first_name}} {{Auth::user()->patron}}!</p>
                                    {{--<p class="descr">В {{date('Y')}} г. Вам оказали помощь на сумму в 1 254 000 тенге</p>--}}
                                </div>
                            </div>
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag blue">{{trans('cabinet-appl.moder')}} <span>{{$moderateHelps->count()}}</span></p>
                            @foreach($moderateHelps as $help)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.help')}}</p>
                                            @foreach($help->addHelpTypes as $helps)<p class="tags default mini blue">{{$helps->name_ru}}</p>@endforeach
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.data-filing')}}</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">{{trans('cabinet-appl.desc-appl')}}</p>
                                            <p>{{mb_substr($help->body, 0, 50)}}...</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            <p>50 000 - 100 000 тг</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">{{trans('cabinet-appl.who')}}</p>
                                                <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            <a href="{{ route('cabinet_help_page',$help->id) }}" class="btn btn-success mt-4">{{trans('cabinet-appl.more-appl')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag green">{{trans('cabinet-appl.executed')}} <span>{{$finishedHelps->count()}}</span></p>
                            <p class="countTag red reviews d-none">{{trans('cabinet-appl.no-appl')}} <span></span></p>
                            <script>
                                var reviewCount = 0;
                            </script>
                            @foreach($finishedHelps as $key=> $help)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.help')}}</p>
                                            @foreach($help->addHelpTypes as $helps)<p class="tags default mini blue">{{$helps->name_ru}}</p>@endforeach
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.data-filing')}}</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">{{trans('cabinet-appl.desc-appl')}}</p>
                                            <p>{{mb_substr($help->body, 0, 50)}}...</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            <p>50 000 - 100 000 тг</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">Кому:</p>
                                            <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            @if(!$help->reviews)
                                            <button data-target="#review" data-toggle="modal" onclick="$('#help_id').val({{$help->id}})" class="btn-default blue">{{trans('cabinet-appl.leave-rev')}}</button>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                @if(!$help->reviews)
                                    <script>
                                        reviewCount +=1;
                                        $('.reviews').removeClass('d-none').find('span').text(reviewCount);
                                    </script>
                                @endif
                            @endforeach
                            <a href="" class="btn-default more">{{trans('cabinet-appl.all-see-more')}}</a>
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag blue">{{trans('cabinet-appl.wait-the-benef')}} <span>{{$waitHelps->count()}}</span></p>
                                @foreach($waitHelps as $help)
                                    <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.help')}}</p>
                                            @foreach($help->addHelpTypes as $helps)<p class="tags default mini blue">{{$helps->name_ru}}</p>@endforeach
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.data-filing')}}</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">{{trans('cabinet-appl.desc-appl')}}</p>
                                            <p>{{mb_substr($help->body, 0, 50)}}...</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            <p>50 000 - 100 000 тг</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">{{trans('cabinet-appl.who')}}</p>
                                            <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            <a href="{{ route('cabinet_help_page',$help->id) }}" class="btn btn-success mt-4">{{trans('cabinet-appl.more-appl')}}</a>
                                        </div>
                                    </div>
                                    </div>
                                @endforeach
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag red">{{trans('cabinet-appl.appl-work')}} <span>{{$processHelps->count()}}</span></p>
                            @foreach($processHelps as $help)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.help')}}</p>
                                            <p class="tags default mini blue">{{trans('cabinet-appl.edu')}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.data-filing')}}</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">{{trans('cabinet-appl.desc-appl')}}</p>
                                            <p>{{$help->body}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            <p>50 000 - 100 000 тг</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">{{trans('cabinet-appl.who')}}</p>
                                            <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            <a href="{{ route('cabinet_help_page',$help->id) }}" class="btn btn-success mt-4">{{trans('cabinet-appl.more-appl')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <a href="" class="btn-default more">{{trans('cabinet-appl.all-see-appl-work')}}</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="greyContent accountGreyContent">
                            <p class="big">{{trans('cabinet-appl.pers-info')}}</p>
                            <a href="{{route('editUser', [Auth::user()->id])}}" class="settings">{{trans('cabinet-appl.edit')}} <img src="/img/settings.svg" alt=""></a>
                            <p>
                                <span>{{trans('cabinet-appl.place-birth')}}</span>
{{--                                <span>{{Auth::user()}}</span>--}}
                            </p>
                            <p>
                                <span>{{trans('cabinet-appl.place-res')}}</span>
                                <span>Алматинская область, Талгарский район, г. Талгар</span>
                            </p>
                            <p>
                                <span>{{trans('cabinet-appl.edu')}}</span>
                                <span>{{Auth::user()->education ?? '-'}}</span>
                            </p>
                            <p>
                                <span>{{trans('cabinet-appl.place-work')}}</span>
                                <span>{{Auth::user()->job ?? '-'}}</span>
                            </p>
                            <p>
                                <span>{{trans('cabinet-appl.amount-chil')}}</span>
                                <span>{{Auth::user()->children_count == 0? '-':Auth::user()->children_count}}</span>
                            </p>
                            <p>
                                <span>{{trans('cabinet-appl.contact')}}</span>
                                <span>{{preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', Auth::user()->phone)}}</span>
                            </p>
                            <p>
                                <span>{{trans('cabinet-appl.about')}}</span>
                                <span class="fullText">
                                   {{Auth::user()->about}}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="review" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" style="position:absolute; right: 30px;">&times;</button>
                        <h5 class="modal-title text-center d-table m-auto">{{trans('cabinet-appl.review')}}</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('review_to_fond')}}" method="post">
                            @csrf
                            <input type="hidden" name="help_id" id="help_id" value="">
                            <input type="text" name="title" class="form-control mb-3" placeholder="{{trans('cabinet-appl.heading')}}">
                            <textarea name="body" class="form-control mb-3" id="" cols="30" placeholder="{{trans('cabinet-appl.text')}}" rows="10"></textarea>
                            <input type="submit" class="btn btn-default" value="{{trans('cabinet-appl.leave-rev')}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
