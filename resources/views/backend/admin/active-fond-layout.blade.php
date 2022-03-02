@extends('backend.admin.layout')

@section('content')
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-12 mt-2 mb-2">
            <h1 class="display-5">Данные фонда: {{ $item->title_ru }}</h1>
        </div>
        <div class="col-12">
            <hr>
            <h2 class="mt-4">Редактирование данных Фонда</h2>
            <form action="{{ route('active_fond_edit',$item->id) }}" method="post">
                @csrf
                <div class="form-check py-3 px-0 mb-4">
                    <label >E-mail</label>
                    <input class="form-control" name="email" placeholder="Email" value="{{ $item->email }}" required>
                </div>
                <div class="form-check py-3 px-0">
                    <label >Пароль</label>
                    <input class="form-control" name="password" placeholder="Пароль">
                </div>
                <button type="submit" class="btn btn-success mt-5 d-table">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
