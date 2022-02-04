@extends('frontend.layout')

@section('content')
    <div class="fatherBlock">
        <div class="container-fluid default accountMenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{trans('cabinet-appl.appl-personal-page')}}</h1>
                        <ul class="myAccountMenu">
                            {{--<li><a href="{{route('history')}}">{{trans('cabinet-appl.hist-mess')}}</a></li>--}}
                            {{--<li><a href="{{route('reviews')}}">{{trans('cabinet-appl.my-rev')}}</a></li>--}}
                            {{--<li><a href="">{{trans('cabinet-appl.message')}}</a></li>--}}
                            {{--<li><a href="">{{trans('cabinet-appl.my-photo')}}</a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row"><div class="col-12">@include('frontend.alerts')</div></div>
        </div>
        <div class="container-fluid default myOrganizationContent myAccountPage">
            <div class="container">
                <div class="row">
                    <form action="{{ route('updateUser')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-8">
                            <div class="greyInfoBlock accountInfo">
                                <div class="row">
                                    <div class="col-sm-4 col-4">
                                        @if(Auth::user()->avatar)
                                            <img src="{{Auth::user()->avatar}}" alt="" class="avatar">
                                        @else
                                            <img src="/img/no-photo.png" alt="" class="avatar">
                                        @endif
                                        <br>
                                        <span style="display: table; margin: 0 0 10px;width: 100%;">Загрузить аватар</span>
                                        <input type="file" name="avatar" accept="image/png, image/jpeg">
                                        <span id="errorAvatar" class="d-none" style="color: red;">Максимальный размер аватар может быть не более 1МБ!!</span>
                                        <span id="errorAvatar2" class="d-none" style="color: red;">Загружать только в форматах: 'jpg', 'jpeg', 'png'!!</span>
                                    </div>
                                    <div class="col-sm-8 col-8">
                                        <p class="name">{{Auth::user()->first_name}} {{Auth::user()->patron}}</p>
                                        {{--<p class="descr">В {{date('Y')}} г. Вам оказали помощь на сумму в 1 254 000 тенге</p>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="greyContent accountGreyContent " style="width: 100%;margin-left: 0;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="big">{{trans('cabinet-appl.pers-info')}}</p>
                                        <p>
                                            <span>E-mail</span>
                                            <span>
                                                <input type="email" name="email" value="{{ $user->email }}">
                                            </span>
                                        </p>
                                        <p>
                                            <span>{{trans('cabinet-appl.about')}}</span>
                                            <span class="fullText">
                                                <textarea name="about" style="width: 100%;height: 150px;">
                                                    @if($user->about){{$user->about}}@endif
                                                </textarea>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <button class="btn-default" style="margin: 15px auto 0; display: table;">Сохранить</button>

                            </div>
                        </div>
                    </form>
            </div>
        </div>
        </div>

    </div>
    <style>
        .myAccountPage .accountInfo img.avatar {
            max-width: 150px;
            height: 150px;
        }

        .container-fluid.default.myOrganizationContent.myAccountPage form {
            width: 100%;
        }
        .container-fluid.default.myOrganizationContent.myAccountPage form input,.container-fluid.default.myOrganizationContent.myAccountPage form textarea {
            padding: 10px 15px;
            border: 1px solid #eee;
            border-radius: 3px;
            width: 100%;
        }
    </style>
    <script>
        $('input[name="avatar"]').change(function() {
            var size = this.files[0].size;
            var name = this.files[0].name;
            $('#errorAvatar').addClass("d-none");
            $('#errorAvatar2').addClass("d-none");
            if(1000000 < size){
                $('#errorAvatar').removeClass("d-none");
                $('input[name="avatar"]').val('');
            }
            var fileExtension = ['jpg', 'jpeg', 'png']; // допустимые типы файлов
            if ($.inArray(name.split('.').pop().toLowerCase(), fileExtension) == -1) {
                $('#errorAvatar2').removeClass("d-none");
                $('input[name="avatar"]').val('');
            }
        });
    </script>
@endsection
