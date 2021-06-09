@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid p-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>{{$new['title_'.app()->getLocale()]??$new['title_ru']}}</h1>
                        <div class="row mt-4">
                            <div class="col-12">
                                {!! $new['body_'.app()->getLocale()]??$new['body_ru'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
