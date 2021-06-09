@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Заявки от благотворительных организаций</h1>
            @include('frontend.alerts')
        </div>
        <div class="col-sm-3">
            <div class="categoryBlock">
                <a>
                    <span>Всего заявок <b>Кол-во: {{ count($fonds1) }}</b></span>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="categoryBlock">
                <a href="{{ route('admin_fonds_category', 1) }}">
                    <span>В реестре <b>Кол-во: {{ count($fonds2) }}</b></span>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="categoryBlock">
                <a href="{{ route('admin_fonds_category', 2) }}">
                    <span>На модерации <b>Кол-во: {{ count($fonds4) }}</b></span>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="categoryBlock">
                <a href="{{ route('admin_fonds_category', 0) }}">
                    <span>Отклонена <b>Кол-во: {{ count($fonds3) }}</b></span>
                </a>
            </div>
        </div>
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
