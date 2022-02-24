@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Заявки от получателей помощи</h1>
            @include('frontend.alerts')
        </div>
        @if($helps9)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','moderate') }}">
                        <span>На модерации <b>Кол-во: {{ $helps9 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps10)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','finished') }}">
                        <span>В ожидании благотворителя <b>Кол-во: {{ $helps10 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps1)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','moderate') }}">
                        <span>На модерации <b>Кол-во: {{ $helps1 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps7)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','health') }}">
                        <span>На модерации / Здоровье <b>Кол-во: {{ $helps7 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps8)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','health-moderated') }}">
                        <span>Прошли модерацию / Здоровье <b>Кол-во: {{ $helps8 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps2)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','finished') }}">
                        <span>В ожидании благотворителя <b>Кол-во: {{ $helps2 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps3)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','fond_process') }}">
                        <span>В работе <b>Кол-во: {{ $helps3 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps4)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','cancel') }}">
                        <span>Отклонена <b>Кол-во: {{ $helps4 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps5)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','edit') }}">
                        <span>Требует правок <b>Кол-во: {{ $helps5 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
        @if($helps6)
            <div class="col-sm-3">
                <div class="categoryBlock">
                    <a href="{{ route('admin_helps_category','fond_finished') }}">
                        <span>Исполнена <b>Кол-во: {{ $helps6 }}</b></span>
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
<style>
    .categoryBlock {
        display: table;
        margin: 0 0 30px;
        width: 100%;
        text-align: center;
        border: 1px solid #b5f3ff;
        border-radius: 3px;
        box-shadow: 0 0 3px #b5f3ff;
        transition: .2s linear;
    }

    .categoryBlock a {
        display: table;
        width: 100%;
        padding: 40px 15px;
        text-decoration: none;
    }

    .categoryBlock a span {
        display: table;
        margin: 0 auto;
        font-weight: 600;
        position: relative;
    }


    .categoryBlock:hover {
        box-shadow: 0 5px 13px #b5f3ff;
    }

    .categoryBlock a span b {
        display: table;
        font-weight: 300;
        margin: 10px auto 0;
        font-size: 14px;
        border-top: 1px solid #eee;
        padding: 5px 0 0;
        width: 100%;
    }
</style>
