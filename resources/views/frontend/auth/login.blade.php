<?php
$script = "<script src='/js/masked.input.js'></script>
        <script>
            $('#phone').mask('+7 (999) 999 99 99');
            $.fn.setCursorPosition = function(pos) {
            if ($(this).get(0).setSelectionRange) {
              $(this).get(0).setSelectionRange(pos, pos);
            } else if ($(this).get(0).createTextRange) {
              var range = $(this).get(0).createTextRange();
              range.collapse(true);
              range.moveEnd('character', pos);
              range.moveStart('character', pos);
              range.select();
            }
          };
          $('#phone').click(function(){
            $(this).setCursorPosition(4);
          });
        </script>";
?>
@extends('frontend.layout')

@section('content')
    <div class="fatherBlock ">
        <div class="container-fluid slide pt-5 ">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="cool-sm-8 offset-sm-2">
                                {{--<ul class="nav nav-tabs">--}}
                                    {{--<li class="nav-item">--}}
                                        {{--<a class="nav-link active" data-toggle="tab" href="#user">Войти как пользователь</a>--}}
                                    {{--</li>--}}
                                    {{--<li class="nav-item">--}}
                                        {{--<a class="nav-link" data-toggle="tab" href="#fond">Войти как фонд</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                                <!-- Tab panes -->
                                <div class="tab-content w-100">
                                    <div class="tab-pane container active w-100" id="user">
                                        @include('frontend.alerts')
                                        {{--<h1>Авторизация пользователя </h1>--}}
                                        <h1>{{ trans('auth.auth') }}</h1>
                                        <p>{{ trans('auth.auth_desc') }}</p>
                                        {{--<form action="{{route('post_login_user')}}" class="w-100" method="post">--}}
                                            {{--@csrf--}}
                                            {{--@if($errors->has('email'))--}}
                                                {{--<span class="error">{{ $errors->first('email') }}</span>--}}
                                            {{--@endif--}}
                                            {{--<input name="email" type="text" value="{{old('email')}}" class="form-control mb-3" placeholder="ИИН или почта">--}}
                                            {{--@if($errors->has('password'))--}}
                                                {{--<span class="error">{{ $errors->first('password') }}</span>--}}
                                            {{--@endif--}}
                                            {{--<input name="password" type="password" class="form-control mb-3" placeholder="Пароль">--}}

                                            {{--<button class="btn btn-primary" type="submit">Продолжить</button>--}}
                                        {{--</form>--}}
                                        <hr>
                                        <a class="login btn-default blue" href="{{route('registration_user')}}">{{ trans('auth.login_or_register') }}</a>
                                        {{--<a class="login btn-default blue" href="{{route('registration_user')}}">Регистрация</a>--}}
                                        <a class="login btn-default blue" class="ml-3" href="{{route('login-fond')}}">Войти как фонд</a>
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
