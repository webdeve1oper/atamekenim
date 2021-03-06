<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Реестр Фондов</title>
    <meta name="description" content="">
    <link rel="shortcut icon" href="img/favicon.png" type="image/png">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="stylesheet" href="{{asset('/css/admin.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.3.1/jquery.maskedinput.min.js" integrity="sha512-D30F0yegJduD5FxOxI3qM1Z0YrbtXE3YLoyNDYvps4Qq63Y0l/ObPmjlsj27pgFx8mLdMQ24I3gGtdYZO741HQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('admin_home') }}"><img src="/img/logo.svg" alt="" style="max-height: 30px;" class="mx-4"></a>

    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a href="{{route('logout_admin')}}" class="nav-link">Выход</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar mt-3">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    @if(is_admin())
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('admins') }}">
                                Пользователи
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('active_fonds') }}">
                                Фонды в реестре
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_helps') }}">
                                Заявки от получателей помощи
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_fonds') }}">
                                Заявки от благотворительных организаций
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_news') }}">
                                Новости
                            </a>
                        </li>

                    @elseif(is_operator() or is_moderator())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_helps') }}">
                                Заявки от получателей помощи
                            </a>
                        </li>

                        @if(is_operator())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin_fonds') }}">
                                    Заявки от благотворительных организаций
                                </a>
                            </li>
                        @endif
                    @endif
                        @if(is_operator() or is_admin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_export') }}">
                                Отчет
                            </a>
                        </li>
                            @endif
                        @if(is_admin())
                            <li>
                                <a class="nav-link" href="{{ route('admin_helps_search') }}">
                                    поиск
                                </a>
                            </li>
                        @endif
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ms-sm-auto col-lg-10 pt-3 px-4">
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("#phone").mask("+7(999) 999-99-99");
    });
</script>
</body>
</html>
