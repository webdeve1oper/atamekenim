<?php
    $script = "<script src='/js/masked.input.js'></script>
        <script>
            $('#phone').mask('+7 (999) 99 99 99');
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
@extends('frontend.layout', ['script'=>$script])

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
                                        <a class="nav-link active" data-toggle="tab" href="#user">Зарегистрироваться как пользователь</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#fond">Зарегистрироваться как фонд</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content w-100">
                                    <div class="tab-pane container active w-100" id="user">
                                        <h1>Регистрация пользователя </h1>
                                        <form action="{{route('post_registration_user')}}" class="w-100" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <input name="first_name" type="text" value="{{old('first_name')}}" class="form-control mb-3" placeholder="Имя" />
                                                @if($errors->has('first_name'))
                                                    <span class="error">{{ $errors->first('first_name') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input name="last_name" type="text" value="{{old('last_name')}}" class="form-control mb-3" placeholder="Фамилия" />
                                                @if($errors->has('last_name'))
                                                    <span class="error">{{ $errors->first('last_name') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input id="iin" name="iin" type="text" value="{{old('iin')}}" class="form-control mb-3" placeholder="ИИН" />
                                                @if($errors->has('iin'))
                                                    <span class="error">{{ $errors->first('iin') }}</span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <input name="email" type="email" value="{{old('email')}}" class="form-control mb-3" placeholder="Почта" />
                                                @if($errors->has('email'))
                                                    <span class="error">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input name="password" type="password" class="form-control mb-3" placeholder="Пароль" />
                                                @if($errors->has('password'))
                                                    <span class="error">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control mb-3"  placeholder="Подвердите пароль" />
                                            </div>
                                            <button class="btn btn-primary" type="submit">Зарегистрироваться</button>
                                        </form>
                                        <hr>
                                        <a href="{{route('login')}}">У меня уже есть аккаунт</a>
                                    </div>
                                    <div class="tab-pane container w-100" id="fond">
                                        <h1>Регистрация Фонда</h1>
                                        <form action="{{route('post_registration_fond')}}" class="w-100" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <input id="bin" name="bin" type="text"  value="{{old('bin')}}" class="form-control mb-3" placeholder="БИН">
                                                @if($errors->has('bin'))
                                                    <span class="error">{{ $errors->first('bin') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input name="title" type="text"  value="{{old('title')}}" class="form-control mb-3" placeholder="Название организации">
                                                @if($errors->has('title'))
                                                    <span class="error">{{ $errors->first('title') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input name="email" type="text"  value="{{old('email')}}" class="form-control mb-3" placeholder="Почта">
                                                @if($errors->has('email'))
                                                    <span class="error">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input name="phone" type="text" id="phone" value="{{old('phone')}}" class="form-control mb-3" placeholder="Телефон" autocomplete="off">
                                                @if($errors->has('phone'))
                                                    <span class="error">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input name="password" type="password" class="form-control mb-3" placeholder="Пароль">
                                                @if($errors->has('password'))
                                                    <span class="error">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input name="password_confirmation" type="password" class="form-control mb-3" placeholder="Подвердите пароль">
                                                @if($errors->has('password_confirmation'))
                                                    <span class="error">{{ $errors->first('password_confirmation') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-11">
                                                        <p>с Договором оферты и Соглашением о конфиденциальности ознакомлен(-а)</p>
                                                    </div>
                                                    <div class="col-1">
                                                        <input type="checkbox" name="aggree" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Зарегистрироваться</button>
                                        </form>
                                        <hr>
                                        <a href="{{route('login')}}">У меня уже есть аккаунт</a>
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
