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
@extends('frontend.layout', ['script'=>$script])

@section('content')
    <div class="fatherBlock ">
        <div class="container-fluid slide pt-5 ">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-8 offset-sm-2">
                                <!-- Tab panes -->
                                        <h1>Регистрация пользователя </h1>
                                        <form id="phone_sms">
                                            <div class="form-group">
                                                <input type="text" class="phone_number form-control mb-3" name="phone" id="phone" placeholder="Введите Ваш номер телефона" value="{{old('phone')}}">
                                                <span class="error phone_error"></span>
                                            </div>
                                            <div class="form-group smsBlock"></div>
                                            <button class="btn btn-primary" type="submit">Продолжить</button>
                                        </form>
                                        <form action="{{route('post_registration_user')}}" id="mainForm" class="w-100" method="post">
                                            @csrf
                                            <div class="form-group d-none">
                                                <input name="first_name" type="text" value="{{old('first_name')}}test" class="form-control mb-3" placeholder="Имя" />
                                                @if($errors->has('first_name'))
                                                    <span class="error">{{ $errors->first('first_name') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group d-none">
                                                <input name="last_name" type="text" value="{{old('last_name')}}test" class="form-control mb-3" placeholder="Фамилия" />
                                                @if($errors->has('last_name'))
                                                    <span class="error">{{ $errors->first('last_name') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group d-none">
                                                <input id="iin" name="iin" type="text" value="{{old('iin')}}980111454545" class="form-control mb-3" placeholder="ИИН" />
                                                @if($errors->has('iin'))
                                                    <span class="error">{{ $errors->first('iin') }}</span>
                                                @endif
                                            </div>

                                            <div class="form-group d-none">
                                                <input name="email" type="email" value="{{old('email')}}test@test.ru" class="form-control mb-3" placeholder="Почта" />
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
                            </div>
                        </div>
                    </div>
                </div>
                <img src="/img/slide.svg" alt="" class="slideImg">
            </div>
        </div>

    <script>
        $(document).ready(function(){
            $('#phone_sms').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('post_sms_user') }}",
                    method: 'post',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function(response){
                        if(response.status == 1){
                            $('.smsBlock').show();
                            $('.smsBlock').html(`<input type="text" class="sms_code form-control mb-3" name="sms_code" placeholder="Код из SMS">`);
                            $('.phone_error').html(response.message);
                        }else if(response.status == 2){
                            $('.phone_error').html(response.message);
                            $('#mainForm').show();
                            $('#phone_sms').remove();
                        }else{
                            $('.phone_error').html(response.message);
                        }
                    }
                });
            });
        });
    </script>
@endsection
