@extends('frontend.layout')

@section('content')
    <div class="fatherBlock ">
        <div class="container-fluid slide pt-5 ">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="cool-sm-8 offset-sm-2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#user">Войти как пользователь</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#fond">Войти как фонд</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content w-100">
                                    <div class="tab-pane container active w-100" id="user">
                                        @include('frontend.alerts')
                                        <h1>Авторизация пользователя </h1>
                                        <form action="{{route('post_login_user')}}" class="w-100" method="post">
                                            @csrf
                                            @if($errors->has('email'))
                                                <span class="error">{{ $errors->first('email') }}</span>
                                            @endif
                                            <input name="email" type="text" value="{{old('email')}}" class="form-control mb-3" placeholder="ИИН или почта">
                                            <input name="password" type="password" class="form-control mb-3" placeholder="Пароль">
                                            <button class="btn btn-primary" type="submit">Войти</button>
                                        </form>
                                        <hr>
                                        <a href="{{route('registration_user')}}">Регистрация</a>
                                    </div>
                                    <div class="tab-pane container fade w-100" id="fond">
                                        <h1>Авторизация Фонда</h1>
                                        <form action="{{route('post_login_fond')}}" class="w-100" method="post">
                                            @csrf
                                            @if($errors->has('email'))
                                                <span class="error">{{$errors->first('email')}}</span>
                                            @endif
                                            <input name="email" type="text"  value="{{old('email')}}" class="form-control mb-3" placeholder="БИН или почта">
                                            <input name="password" type="password" class="form-control mb-3" placeholder="Пароль">
                                            <button class="btn btn-primary" type="submit">Войти</button>
                                        </form>
                                        <hr>
                                        <a href="{{route('registration_fond')}}">Регистрация</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="/img/slide.svg" alt="" class="slideImg">
            </div>
        </div>



    </div>
@endsection
