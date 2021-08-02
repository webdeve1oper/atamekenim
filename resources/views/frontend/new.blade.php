@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid p-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>{{$new['title_'.app()->getLocale()]??$new['title_ru']}}</h1>
                        @if($new->image)
                            <img src="{{ $new->image }}" alt="" class="mainImg">
                        @endif
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="bodyText">
                                    {!! $new['body_'.app()->getLocale()]??$new['body_ru'] !!}
                                </div>
                                <p class="date">{!! date('d.m.Y', strtotime($new['public_date'])) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        h1 {
            display: table;
            margin: 0 0 30px;
            font-size: 32px;
        }
        img.mainImg {
            display: table;
            height: 400px;
            margin: 0 0 15px;
            max-width: 100%;
            object-fit: cover;
        }
        .bodyText {
            display: table;
            margin: 0;
            line-height: 1.8;
            font-size: 16px;
        }

        .bodyText * {
            display: table;
            margin: 0 0 10px;
            line-height: 1.8;
            font-size: 16px;
        }
        p.date {
            display: table;
            margin: 24px 0;
            font-size: 16px;
            font-weight: 600;
        }
    </style>
@endsection
