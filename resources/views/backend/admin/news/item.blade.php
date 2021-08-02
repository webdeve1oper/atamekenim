@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Редактирование новости: {{ $item->title_ru }}</h1>
            @include('frontend.alerts')
        </div>
        <form action="{{ route('admin_news_update',$item->id) }}" method="POST" enctype='multipart/form-data'>
            @csrf
            <div class="col-sm-12">
                <div class="inputBlock">
                    @if($item->image)<img src="{{ $item->image }}" alt="">@endif
                    <label for="">Изображение</label>
                    <input type="file" name="image">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="inputBlock">
                    <label for="">Название(рус)</label>
                    <input type="text" name="title_ru" value="@if($item->title_ru){{ $item->title_ru }}@endif">
                </div>
                <div class="inputBlock">
                    <label for="">Название(каз)</label>
                    <input type="text" name="title_kz" value="@if($item->title_kz){{ $item->title_kz }}@endif">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="inputBlock">
                    <label for="">Описание(рус)</label>
                    <textarea name="body_ru" class="mytextarea">@if($item->body_ru){{ $item->body_ru }}@endif</textarea>
                </div>
                <div class="inputBlock">
                    <label for="">Описание(каз)</label>
                    <textarea name="body_kz" class="mytextarea">@if($item->body_kz){{ $item->body_kz }}@endif</textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="inputBlock">
                <label for="">Дата публикации</label>
                <input type="date" name="public_date" value="@if($item->public_date){{ $item->public_date }}@endif">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="inputBlock">
                    <button class="btn btn-primary">Сохранить</button>
                </div>
            </div>

        </form>
    </div>
    <script>
        tinymce.init({
            selector: '.mytextarea',
            height: '500'
        });
    </script>
    <style>
        h1 {
            display: table;
            font-size: 24px;
            margin: 40px 0 30px;
        }

        form {
            display: table;
            margin: 0 0 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 13px #eee;
        }

        form .inputBlock {
            margin: 15px 0;
            display: table;
            padding: 24px;
            background: #fff;
            width: 100%;
        }

        form .inputBlock img {
            display: table;
            width: 400px;
            height: auto;
        }

        form .inputBlock label {
            display: table;
            margin: 0 0 10px;
        }

        form .inputBlock input {
            display: table;
            min-width: 50%;
            max-width: 100%;
            border: 1px solid #eee;
            padding: 10px 15px;
        }
    </style>
@endsection
