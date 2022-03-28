@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default accountMenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{trans('cabinet-appl.appl-personal-page')}}</h1>
                        <ul class="myAccountMenu">
                            {{--<li><a href="#{{route('history')}}">{{trans('cabinet-appl.hist-mess')}}</a></li>--}}
                            {{--<li><a href="#{{route('reviews')}}">{{trans('cabinet-appl.my-rev')}}</a></li>--}}
                            {{--<li><a href="">{{trans('cabinet-appl.message')}}</a></li>--}}
                            {{--<li><a href="">{{trans('cabinet-appl.my-photo')}}</a></li>--}}
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
                                    <br>
                                    <a href="{{route('request_help')}}" class="btn-default blue">{{trans('home.apply-for-assistance')}}</a>
                                    {{--<p class="descr">В {{date('Y')}} г. Вам оказали помощь на сумму в 1 254 000 тенге</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="greyContent accountGreyContent">
                            <p class="big">{{trans('cabinet-appl.pers-info')}}</p>
                            <a href="{{route('editUser')}}" class="settings">{{trans('cabinet-appl.edit')}} <img src="/img/settings.svg" alt=""></a>
                            {{--<p>--}}
                            {{--<span>{{trans('cabinet-appl.place-birth')}}</span>--}}
                            {{--                                <span>{{Auth::user()}}</span>--}}
                            {{--</p>--}}
                            {{--<p>--}}
                            {{--<span>{{trans('cabinet-appl.place-res')}}</span>--}}
                            {{--<span>{{Auth::user()->born_location_country->title_ru ?? ''}}, {{Auth::user()->born_location_region->title_ru ?? ''}}, {{Auth::user()->born_location_city->title_ru ?? ''}}</span>--}}
                            {{--</p>--}}
                            {{--<p>--}}
                            {{--<span>{{trans('cabinet-appl.edu')}}</span>--}}
                            {{--<span>{{Auth::user()->education ?? '-'}}</span>--}}
                            {{--</p>--}}
                            {{--<p>--}}
                            {{--<span>{{trans('cabinet-appl.place-work')}}</span>--}}
                            {{--<span>{{Auth::user()->job ?? '-'}}</span>--}}
                            {{--</p>--}}
                            {{--<p>--}}
                            {{--<span>{{trans('cabinet-appl.amount-chil')}}</span>--}}
                            {{--<span>{{Auth::user()->children_count == 0? '-':Auth::user()->children_count}}</span>--}}
                            {{--</p>--}}
                            {{--<p>--}}
                            {{--<span>{{trans('cabinet-appl.contact')}}</span>--}}
                            {{--<span>{{preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', Auth::user()->phone)}}</span>--}}
                            {{--</p>--}}
                            <p>
                                <span>{{trans('cabinet-appl.about')}}</span>
                                <span class="fullText">
                                    {{ Str::limit(Auth::user()->about, 180) }}
                                </span>
                                <style>

                                    .myAccountPage .accountGreyContent p span.fullText {word-break: break-all;}
                                </style>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="greyInfoBlock mini">
                            <p class="countTag blue">{{trans('cabinet-appl.moder')}} <span>{{$moderateHelps->count()}}</span></p>
                            <p class="floatRight">
                                {{ trans('home.cabinet-moderate-notif') }}
                            </p>
                            @foreach($moderateHelps as $help)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p><b>Заявка ID:</b>{{ getHelpId($help->id) }}</p>
                                            <p class="name">{{trans('cabinet-appl.help')}}</p>
                                            @foreach($help->addHelpTypes as $helps)<p class="tags default mini blue">{{$helps->name_ru}}</p>@endforeach
                                        </div>
                                        <div class="col-sm-1">
                                            <p class="name">{{trans('cabinet-appl.data-filing')}}</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.desc-appl')}}</p>
                                            <p>{{mb_substr($help->body, 0, 50)}}...</p>
                                        </div>
                                        <div class="col-sm-1 d-none">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            @if(isset($help->cashHelpSize->name_ru))
                                                <p>{{ $help->cashHelpSize->name_ru }}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.who')}}</p>
                                                <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            <a href="{{ route('cabinet_help_page',$help->id) }}" class="btn btn-success mt-4">{{trans('cabinet-appl.more-appl')}}</a>
                                        </div>
                                        <div class="col-sm-4">
                                            @if(!$help->phone)
                                                <div class="alert alert-danger mt-4">
                                                    {{ trans('home.input-phone') }}
                                                </div>
                                            @endif
                                            @if($help->admin_status == 'edit')
{{--                                                    <div class="alert alert-info mt-4">--}}
{{--                                                        {{ trans('home.cabinet-edit-moderate-notif') }}--}}
{{--                                                    </div>--}}
                                                <?php $last_comment = $help->lastComment->last() ?>
                                                @if($last_comment)
                                                    @if($last_comment->cause_value)
                                                        <div class="alert alert-info mt-4">
                                                            {{ trans('home.new_alert_'.$last_comment->cause_value) }}
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif

                                            @if($help->status_kh == \App\Help::STATUS_KH_NOT_APPROVED)
                                                @if($help->id > 31205)
                                                    <div class="alert alert-danger mt-4">
                                                        {{ trans('home.help_registered') }}
                                                    </div>
                                                @endif
                                            @endif
                                            @if($help->status_kh == \App\Help::STATUS_KH_POSSIBLY)
                                                <div class="alert alert-success mt-4">
                                                    {{ trans('home.kh_possibly_message_for_user') }}
                                                </div>
                                            @endif
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
                                            <p><b>Заявка ID:</b>{{ getHelpId($help->id) }}</p>
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
                                        <div class="col-sm-1 d-none">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            @if(isset($help->cashHelpSize->name_ru))
                                                <p>{{ $help->cashHelpSize->name_ru }}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">Кому:</p>
                                            <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            @if(!$help->reviews)
                                                <button data-target="#review" data-toggle="modal" onclick="$('#help_id').val({{$help->id}})" class="btn-default blue mt-3">{{trans('cabinet-appl.leave-rev')}}</button>
                                            @else
                                                <button data-target="#review{{$help->reviews->id}}" data-toggle="modal" class="btn-default blue mt-3">Читать отзыв</button>
                                                <div id="review{{$help->reviews->id}}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" style="position:absolute; right: 30px;">&times;</button>
                                                                <h5 class="modal-title text-center d-table m-auto">{{trans('cabinet-appl.review')}}</h5>
                                                            </div>
                                                            <div class="modal-body">
{{--                                                               <h6> {{$help->reviews->title}}</h6>--}}
                                                               <p> {{$help->reviews->body}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <a href="{{ route('cabinet_help_page',$help->id) }}" class="btn btn-success mt-3">{{trans('cabinet-appl.more-appl')}}</a>
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
                            {{--<a href="" class="btn-default more">{{trans('cabinet-appl.all-see-more')}}</a>--}}
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag blue">{{trans('cabinet-appl.wait-the-benef')}} <span>{{$waitHelps->count()}}</span></p>
{{--                            <p class="floatRight">--}}
{{--                                Уважаемый {{Auth::user()->first_name}} {{Auth::user()->patron}}! Портал уведомляет Вас о том, что по заявке найдено Х (количество) фондов, которые могут дать Вам ответ.--}}
{{--                            </p>--}}
                                @foreach($waitHelps as $help)
                                    <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p><b>Заявка ID:</b>{{ getHelpId($help->id) }}</p>
                                            <p class="name">{{trans('cabinet-appl.help')}}</p>
                                            @foreach($help->addHelpTypes as $helps)<p class="tags default mini blue">{{$helps->name_ru}}</p>@endforeach
                                        </div>
                                        <div class="col-sm-1">
                                            <p class="name">{{trans('cabinet-appl.data-filing')}}</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.desc-appl')}}</p>
                                            <p>{{mb_substr($help->body, 0, 50)}}...</p>
                                        </div>
                                        <div class="col-sm-1 d-none">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            @if(isset($help->cashHelpSize->name_ru))
                                                <p>{{ $help->cashHelpSize->name_ru }}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.who')}}</p>
                                            @if(isset($help->whoNeedHelp->name_ru))
                                            <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            @endif
                                            <a href="{{ route('cabinet_help_page',$help->id) }}" class="btn btn-success mt-4">{{trans('cabinet-appl.more-appl')}}</a>
                                        </div>
                                        <div class="col-sm-4">
                                            @if(!$help->phone)
                                                <div class="alert alert-danger mt-4">
                                                    {{ trans('home.input-phone') }}
                                                </div>
                                            @endif
                                            @if($help->status_kh == \App\Help::STATUS_KH_NOT_APPROVED)
                                                @if($help->id > 31205)
                                                    <div class="alert alert-danger mt-4">
                                                        {{ trans('home.without-kh') }}
                                                    </div>
                                                @endif
                                            @endif
                                            @if($help->status_kh == \App\Help::STATUS_KH_POSSIBLY)
                                                <div class="alert alert-success mt-4">
                                                    {{ trans('home.kh_possibly_message_for_user') }}
                                                </div>
                                            @endif
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
                                            <p><b>Заявка ID:</b>{{ getHelpId($help->id) }}</p>
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
                                        <div class="col-sm-2 d-none">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            @if(isset($help->cashHelpSize->name_ru))
                                                <p>{{ $help->cashHelpSize->name_ru }}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name">{{trans('cabinet-appl.who')}}</p>
                                            @if(isset($help->whoNeedHelp->name_ru))
                                                <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            @endif
                                            <a href="{{ route('cabinet_help_page',$help->id) }}" class="btn btn-success mt-4">{{trans('cabinet-appl.more-appl')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!--<a href="" class="btn-default more">{{trans('cabinet-appl.all-see-appl-work')}}</a>-->
                        </div>
                        <div class="greyInfoBlock mini">
                            <p class="countTag red">Отклоненные <span>{{$cancledHelps->count()}}</span></p>
                            @foreach($cancledHelps as $help)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p><b>Заявка ID:</b>{{ getHelpId($help->id) }}</p>
                                            <p class="name">{{trans('cabinet-appl.help')}}</p>
                                            @foreach($help->addHelpTypes as $helps)<p class="tags default mini blue">{{$helps->name_ru}}</p>@endforeach
                                        </div>
                                        <div class="col-sm-1">
                                            <p class="name">{{trans('cabinet-appl.data-filing')}}</p>
                                            <p>{{date('d.m.Y', strtotime($help->created_at))}}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.desc-appl')}}</p>
                                            <p>{{mb_substr($help->body, 0, 50)}}...</p>
                                        </div>
                                        <div class="col-sm-1 d-none">
                                            <p class="name">{{trans('cabinet-appl.summ')}}</p>
                                            @if(isset($help->cashHelpSize->name_ru))
                                                <p>{{ $help->cashHelpSize->name_ru }}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('cabinet-appl.who')}}</p>
                                            @if(isset($help->whoNeedHelp->name_ru))
                                                <p>{{$help->whoNeedHelp->name_ru}}</p>
                                            @endif
                                            <a href="{{ route('cabinet_help_page',$help->id) }}" class="btn btn-success mt-4">{{trans('cabinet-appl.more-appl')}}</a>
                                        </div>
                                        <div class="col-sm-4">
                                                <?php $last_comment = $help->lastComment->last() ?>
                                                @if($last_comment)
                                                    @if($last_comment->cause_value)
                                                        <div class="alert alert-danger mt-4">
                                                            {{ trans('home.new_alert_'.$last_comment->cause_value) }}
                                                        </div>
                                                    @else
                                                        <div class="alert alert-danger mt-4">
                                                            {{ trans('home.cabinet-cancel-notif') }}
                                                        </div>
                                                    @endif
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!--<a href="" class="btn-default more">{{trans('cabinet-appl.all-see-appl-work')}}</a>-->
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
    <style>
        p.floatRight {
            display: inline-table;
            max-width: 60%;
            vertical-align: middle;
            margin: 0;
            text-decoration: underline;
        }
    </style>
@endsection
