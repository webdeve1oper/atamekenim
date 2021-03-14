@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default accountMenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul>
                            {{--<li><a href="">Избранные заявки</a></li>--}}
                            {{--<li><a href="">История заявок</a></li>--}}
                            {{--<li><a href="">Мои поступления</a></li>--}}
                            {{--<li><a href="">Сообщения</a></li>--}}
                            {{--<li><a href="">Мои отзывы</a></li>--}}
                            <li><a href="{{route('fond_cabinet')}}">Мой кабинет</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @include('frontend.alerts')
        @yield('fond_content')
    </div>
@endsection