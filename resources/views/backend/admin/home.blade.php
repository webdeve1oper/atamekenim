@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Добро пожаловать {{ Auth::user()->name }}</h1>
            @include('frontend.alerts')
        </div>
        @if(is_admin())
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admins') }}">Пользователи</a>
                </div>
            </div>
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('active_fonds') }}">Фонды в реестре</a>
                </div>
            </div>
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admin_helps') }}">Заявки от получателей помощи</a>
                </div>
            </div>
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admin_fonds') }}">Заявки от благотворительных организаций</a>
                </div>
            </div>
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admin_news') }}">Новости</a>
                </div>
            </div>
        @elseif(is_operator() or is_moderator())
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admin_helps') }}">Заявки от получателей помощи</a>
                </div>
            </div>
        @if(is_operator())
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admin_fonds') }}">Заявки от благотворительных организаций</a>
                </div>
            </div>
            @endif
        @endif

    </div>
@endsection
