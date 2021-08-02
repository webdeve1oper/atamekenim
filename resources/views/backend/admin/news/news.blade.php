@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <div class="row">
                <div class="col-sm-6"><h1>Новости</h1></div>
                <div class="col-sm-6"><a href="{{ route('admin_news_create') }}" class="btn-success btn mt-4">Добавить</a></div>
            </div>
            @include('frontend.alerts')
        </div>
        @foreach($news as $item)
            <div class="col-6">
                <div class="newBlock">
                    <div class="card-header">
                        <img src="{{ $item->image }}" alt="">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($item->title_ru, 60) }}</h5>
                        <div class="card-text">{!! Str::limit($item->body_ru, 200) !!}</div>
                        <a href="{{ route('admin_news_edit', $item->id) }}" class="btn btn-primary">Подробнее</a>
                        <form action="{{ route('admin_news_delete', $item->id) }}" method="post" style="float: right;">
                            @csrf
                            <button class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <style>
        .newBlock {
            display: table;
            width: 100%;
            border: 1px solid #eee;
            border-radius: 4px;
            margin: 0 0 15px;
            transition: .2s linear;
        }

        .newBlock .card-header {
            display: inline-block;
            width: 40%;
            max-width: 40%;
            padding: 0;
            border-radius: 0;
            margin: 0;
            background: transparent;
            vertical-align: top;
            height: 228px;
        }

        .newBlock .card-header img {
            display: table;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .newBlock .card-body {
            display: inline-block;
            width: 59%;
            vertical-align: top;
            padding: 20px 30px;
        }

        .newBlock .card-body h5 {
            display: table;
            font-size: 18px;
            font-weight: 700;
        }

        .newBlock .card-body .card-text {
            font-size: 14px;
        }

        .newBlock .card-body .btn {
            padding: 5px 15px;
            font-size: 14px;
        }

        .newBlock:hover {
            box-shadow: 0 0 13px #eee;
        }
        .newBlock .card-body .card-text * {
            margin: 0;
            line-height: 1.6;
            font-size: 14px;
        }

        .newBlock .card-body .card-text {
            margin: 10px 0 20px;
        }

        .newBlock .card-header {
            height: 235px;
        }
    </style>
@endsection
