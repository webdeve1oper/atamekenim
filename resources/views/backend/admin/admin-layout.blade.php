@extends('backend.admin.layout')

@section('content')
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-12 mt-2 mb-2">
            <h1 class="display-5">Данные пользователя: {{ $admin->name }} ({{ $admin->role->name_ru }})</h1>
        </div>
        <div class="col-12">
            <hr>
            <h2 class="mt-4">Редактирование данных пользователя</h2>
            <form action="{{ route('admins_update',$admin->id) }}" method="post">
                @csrf
                <div class="form-check py-3 px-0">
                    <label >Имя пользователя</label>
                        <input class="form-control" name="name" placeholder="Имя" value="{{ $admin->name }}">
                </div>
                <div class="form-check py-3 px-0 mb-4">
                    <label >E-mail пользователя</label>
                        <input class="form-control" name="email" placeholder="Email" value="{{ $admin->email }}">
                </div>
                <div class="form-check py-3 px-0">
                    <label >Пароль</label>
                    <input class="form-control" name="password" placeholder="Пароль">
                </div>
                <span>На данный момент роль пользователя - </span><span class="badge bg-info mb-2">{{ $admin->role->name_ru }}</span>
                <div class="form-floating mt-2">
                    <select class="form-select" id="floatingSelect" aria-label="Роль пользователя" name="role_id">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name_ru }}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelect">Роль пользователя</label>
                </div>

                <button type="submit" class="btn btn-success mt-5 d-table">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
