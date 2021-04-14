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
                    <div class="col-sm-6" >
                        <div class="row">
                            <div class="cool-sm-8 offset-sm-2">
                                <form action="{{route('post_registration_fond')}}" class="w-100" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <select name="organ_id" class="form-control" id="">
                                            <option value="" disabled selected>Орг.-правовая форма</option>
                                            @foreach($organ_legal as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('organ_id'))
                                            <span class="error">{{ $errors->first('organ_id') }}</span>
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
                                        <input name="title_ru" type="text" value="{{old('title_ru')}}"
                                               class="form-control mb-3" placeholder="Название организации">
                                        @if($errors->has('title_ru'))
                                            <span class="error">{{ $errors->first('title_ru') }}</span>
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
                                        <input name="work" type="text" id="work" value="{{old('work')}}"
                                               class="form-control mb-3" placeholder="Должность сотрудника организации:" autocomplete="off">
                                        @if($errors->has('work'))
                                            <span class="error">{{ $errors->first('work') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input name="fio" type="text" id="fio" value="{{old('fio')}}"
                                               class="form-control mb-3" placeholder="ФИО сотрудника организации:" autocomplete="off">
                                        @if($errors->has('fio'))
                                            <span class="error">{{ $errors->first('fio') }}</span>
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
                    <div class="col-sm-6" style="z-index: 9999">
                        <h1>Регистрация благотворительной организации</h1>
                        <p>Регистрация благотворительной организации означает создание страницы организации с одновременным созданием личного рабочего кабинета, где имеется возможность ввести детальную информацию о благотворительной деятельности организации, доступную в сети интернет. Как только Вы зарегистрируете свою организацию в Реестре, она будет отображаться в списке благотворительных организаций Казахстана. Через свой личный рабочий кабинет Вы сможете получать заявки на получение помощи, соответствующие Вашему региону, сфере оказываемой помощи и категориям благополучателей, и брать их в работу.</p>
                        <p>Благодаря регистрации в Реестре благотворительных организаций, Вы получите:</p>
                        <p><strong>Признание</strong></p>
                        <p>Все пользователи узнают о Вашей организации и ее деятельности, Вы сможете участвовать в рейтингах и конкурсах</p>
                        <p><strong>Удобство</strong></p>
                        <p>Вы получаете только заявки, соответствующие Вашему региону, сфере оказываемой помощи и категориям благополучателей</p>
                        <p><strong>Цифровизация</strong></p>
                        <p>Вы получаете все данные о заявителе за счет связи с государственными информационными базами данных</p>
                        <p><strong>Безопасность</strong></p>
                        <p>Вы можете быть уверены, что с каждой взятой Вами заявкой работаете только Вы (исключение иждивенчества)</p>
                    </div>
                </div>
            </div>
            <img src="/img/slide.svg" style="    left: 74%;" alt="" class="slideImg">
        </div>
    </div>
@endsection
