@extends('backend.fond_cabinet.layout')

@section('fond_content')
        <div class="container-fluid default myOrganizationContent">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="greyInfoBlock firstBig">
                            <div class="row">
                                <div class="col-sm-3">
                                    @if($fond->logo)
                                        <img src="{{$fond->logo}}" alt="" class="logotype">
                                    @else
                                        <img src="/img/no-photo.png" alt="" class="logotype">
                                    @endif
                                </div>
                                <div class="col-sm-9">
                                    <h1>Общественное объединение {{$fond->title_ru}}</h1>
                                    {{--<p class="descr">Поздравляем, в {{date('Y')}} году Вы реализовали {{$fond->helpsByDate(date('Y'))->count()}} заявок--}}
                                        {{--<span>на общую сумму 1 045 768 тенге</span>--}}
                                    {{--</p>--}}
                                    <p class="descr">{{trans('fond-cab.congra')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{route('fond_setting')}}" class="settings">{{trans('fond-cab.setting')}} <img src="/img/settings.svg" alt=""></a>
                    </div>
                    <div class="col-sm-8">
                        <div class="greyInfoBlock mini">
                            <?php $waitHelps = $fond->helpsByStatus('wait')->get();?>
                            <p class="countTag blue">{{trans('fond-cab.new-appl')}} <span>{{$waitHelps->count()}}</span></p>
                            {{--<a href="" class="btn-default">Поиск по всем заявкам</a>--}}
                                @if($waitHelps->count()>0)
                                @foreach($waitHelps as $help)
                                    <div class="applicationBlock">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                @foreach($help->addHelpTypes as $helps)<p class="tags default blue">{{$helps->name_ru}}</p>@endforeach
{{--                                                <p><span>{{}}</span>, 30 лет</p>--}}
                                                <p>{{$help->region->title_ru}} @if($help->city_id != null), {{ $help->city->title_ru }}@endif @if($help->district_id != null), {{ $help->city->title_ru }}@endif</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="name">{{trans('fond-cab.desc')}}</p>
                                                <p>{!! mb_substr($help->body, 0,100) !!}...</p>
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="name">{{trans('fond-cab.status-tjs')}}</p>
                                                <p class="tags default mini red">120 баллов</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="{{ route('fond_help_page',$help->id) }}" class="btn-default">{{trans('fond-cab.hr')}}</a>
                                                <form action="{{route('start_help', $help->id)}}" method="post">
                                                    @csrf
                                                    <button class="btn-default blue">{{trans('fond-cab.take-work')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @endif
                        </div>
                        <?php $processHelps = $fond->helpsByStatus('process')->get(); ?>
                        <div class="greyInfoBlock mini">
                            <p class="countTag red">{{trans('fond-cab.work-appl')}} <span>{{$processHelps->count()}}</span></p>
                            @if($processHelps->count()>0)
                                @foreach($processHelps as $process)
                                    <div class="applicationBlock">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                @foreach($help->addHelpTypes as $helps)<p class="tags default blue">{{$helps->name_ru}}</p>@endforeach
                                                {{--<p><span>Мужчина</span>, {{$process->user()->name}} лет</p>--}}
                                                    <p>{{$help->region->title_ru}} @if($help->city_id != null), {{ $help->city->title_ru }}@endif @if($help->district_id != null), {{ $help->city->title_ru }}@endif</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="name">{{trans('fond-cab.desc')}}</p>
                                                <p>{!! mb_substr($process->body, 0,100) !!}...</p>
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="name">{{trans('fond-cab.status-tjs')}}</p>
                                                <p class="tags default mini red">120 баллов</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="name center">{{trans('fond-cab.status')}}:</p>
                                                <p class="tags default mini grey mb-2">В работе с {{\Carbon\Carbon::parse($process->date_fond_start)->format('d.m.Y')}}</p>
                                                <form action="{{route('finish_help', $process->id)}}" method="post">
                                                    @csrf
                                                    <button class="btn-default blue">{{trans('fond-cab.well-done')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="" class="btn-default more">{{trans('fond-cab.see-all')}}</a>
                            @endif
                        </div>

                        <?php $finishedHelps = $fond->helpsByStatus('finished')->get(); ?>
                        <div class="greyInfoBlock mini">
                            <p class="countTag green">{{trans('fond-cab.done-appl')}} <span>{{$finishedHelps->count()}}</span></p>
                            @if($finishedHelps->count()>0)
                            @foreach($finishedHelps as $process)
                                <div class="applicationBlock">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            @foreach($help->addHelpTypes as $helps)<p class="tags default blue">{{$helps->name_ru}}</p>@endforeach
                                            <p><span>{{$process->user->gender=='male'?'Мужчина':'Женщина'}}</span>, {{\Carbon\Carbon::parse($process->user->born)->age }} лет </p>
                                            <p>{{$help->region->title_ru}} @if($help->city_id != null), {{ $help->city->title_ru }}@endif @if($help->district_id != null), {{ $help->city->title_ru }}@endif</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="name">{{trans('fond-cab.desc')}}</p>
                                            <p>{!! mb_substr($process->body, 0,100) !!}...</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="name">{{trans('fond-cab.status-tjs')}}</p>
                                            <p class="tags default mini red">120 баллов</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="name center">{{trans('fond-cab.status')}}</p>
                                            <p class="tags default mini green">{{trans('fond-cab.done')}} {{\Carbon\Carbon::parse($process->date_fond_finish)->format('d.m.Y')}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <a href="" class="btn-default more">{{trans('fond-cab.see-all')}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="greyContent">
                            <div class="miniStatusBlock">
                                {{--<p class="greyText">{{trans('fond-cab.all-rat')}} <span class="green">95%</span></p>--}}
                            </div>
                            {{--<p class="date">{{trans('fond-cab.see-history')}}</p>--}}
                            {{--<div class="dropdown">--}}
                                {{--<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                    {{--2010-2020--}}
                                {{--</button>--}}
                                {{--<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
                                    {{--<a class="dropdown-item" href="#">2010-2020</a>--}}
                                    {{--<a class="dropdown-item" href="#">2010-2020</a>--}}
                                    {{--<a class="dropdown-item" href="#">2010-2020</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="content">
                                {{--<p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>--}}
                                {{--<p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>--}}
                                {{--<p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>--}}
                                {{--<p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>--}}
                                {{--<p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>--}}
                                {{--<p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>--}}
                                {{--<p><span>1 место</span>по категории Социальная помощь по г. Нур-Султан</p>--}}
                                {{--<p><span>5 место</span>среди благотворительных организаций г. Нур-Султан</p>--}}
                                <a href="{{route('dev')}}">{{trans('fond-cab.all-see-org')}}</a>
                                <a href="{{route('dev')}}">{{trans('fond-cab.more-analytics')}}</a>
                                <a href="{{route('dev')}}">{{trans('fond-cab.how-to-up')}}</a>
                                <a href="{{route('dev')}}">{{trans('fond-cab.form-rat')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
