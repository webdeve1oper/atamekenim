@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default accountMenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            {{--<li><a href="">{{trans('fond-cab.star-appl')}}</a></li>--}}
                            {{--<li><a href="">{{trans('fond-cab.history-appl')}}</a></li>--}}
                            {{--<li><a href="">{{trans('fond-cab.my-rec')}}</a></li>--}}
                            {{--<li><a href="">{{trans('fond-cab.mess')}}</a></li>--}}
                            {{--<li><a href="">{{trans('fond-cab.my-rev')}}</a></li>--}}
                            <li><a href="{{route('fond_cabinet')}}">{{trans('fond-cab.my-cab')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 pt-3">
                    @include('frontend.alerts')
                </div>
            </div>
        </div>
        @yield('fond_content')
    </div>
@endsection
