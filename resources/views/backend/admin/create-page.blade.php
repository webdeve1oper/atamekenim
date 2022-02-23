@extends('backend.admin.layout')

@section('content')
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-12 mt-2 mb-2">
            <h1 class="display-5">Создание нового специалиста</h1>
        </div>
        <div class="col-12">
            <hr>
            <form action="{{ route('admin_create') }}" method="POST">
                @csrf
                <div class="form-check py-3 px-0">
                    <label >Имя</label>
                    <input class="form-control" name="name" placeholder="Имя">
                </div>
                <div class="form-check py-3 px-0">
                    <label >Пароль</label>
                    <input class="form-control" name="password" placeholder="Пароль">
                </div>
                <div class="form-check py-3 px-0 mb-4">
                    <label >E-mail</label>
                    <input class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-floating mt-2">
                    <select class="form-select" id="floatingSelect" aria-label="Роль пользователя" name="role_id">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name_ru }}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelect">Роль специалиста</label>
                </div>

                <button type="submit" class="btn btn-success mt-5 d-table">Создать</button>
            </form>
        </div>
    </div>
@endsection
