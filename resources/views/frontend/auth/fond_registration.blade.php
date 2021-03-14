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
                                <h1>Регистрация Фонда</h1>
                                <form action="{{route('post_registration_fond')}}" class="w-100" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <select name="org_type" class="form-control" id="">
                                            <option value="" disabled selected>Орг.-правовая форма</option>
                                            <option value="1">Общественное объединение</option>
                                        </select>
                                        @if($errors->has('org_type'))
                                            <span class="error">{{ $errors->first('org_type') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input id="bin" name="bin" type="text" value="{{old('bin')}}"
                                               class="form-control mb-3" placeholder="БИН">
                                        @if($errors->has('bin'))
                                            <span class="error">{{ $errors->first('bin') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input name="title" type="text" value="{{old('title')}}"
                                               class="form-control mb-3" placeholder="Название организации">
                                        @if($errors->has('title'))
                                            <span class="error">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input name="email" type="text" value="{{old('email')}}"
                                               class="form-control mb-3" placeholder="Почта">
                                        @if($errors->has('email'))
                                            <span class="error">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input name="phone" type="text" id="phone" value="{{old('phone')}}"
                                               class="form-control mb-3" placeholder="Телефон" autocomplete="off">
                                        @if($errors->has('phone'))
                                            <span class="error">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control mb-3"
                                               placeholder="Пароль">
                                        @if($errors->has('password'))
                                            <span class="error">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input name="password_confirmation" type="password" class="form-control mb-3"
                                               placeholder="Подвердите пароль">
                                        @if($errors->has('password_confirmation'))
                                            <span class="error">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-11">
                                                <p>с Договором оферты и Соглашением о конфиденциальности
                                                    ознакомлен(-а)</p>
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
            <img src="/img/slide.svg" alt="" class="slideImg">
        </div>
    </div>
@endsection