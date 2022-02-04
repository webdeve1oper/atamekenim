@extends('frontend.layout')

@section('content')
    <div class="fatherBlock p-5">
        <div class="cotnainer-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 mb-sm-5">
                        <h1>Новости</h1>
                    </div>
                </div>
                @foreach($news as $new)
                    <div class="col-md-4">
                        <p class="date">{!! date('d.m'.'<b>'.'Y'.'</b>', strtotime($new['public_date'])) !!}</p>
                        <p class="name"><a href="{{route('new', $new['slug'])}}">{{$new['title_'.app()->getLocale()]??$new['title_ru']}}</a></p>
                        <div class="descr">{!! $new['body_'.app()->getLocale()]??$new['body_ru'] !!}</div>
                        <style>
                            .newsBlock .newsSlick .slick-slide .block .descr * {
                                margin: 0;
                                line-height: 1.6;
                            }
                        </style>
                    </div>
                @endforeach
                </div>
        </div>
    </div>
@endsection