@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Добро пожаловать {{ Auth::user()->name }}</h1>
            @include('frontend.alerts')
        </div>
        @if(Auth::user()->role_id == 1)
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admins') }}">Пользователи</a>
                </div>
            </div>
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admin_helps') }}">Запросы на помощь</a>
                </div>
            </div>
        @elseif(Auth::user()->role_id == 2)
            <div class="col-sm">
                <div class="col border-info border p-5 text-center">
                    <a href="{{ route('admin_helps') }}">Запросы на помощь</a>
                </div>
            </div>
        @endif

    </div>
@endsection
