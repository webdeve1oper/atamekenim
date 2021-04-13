@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Админы</h1>
            @include('frontend.alerts')
        </div>
        <div class="col-sm-12">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Email</th>
                    <th>Имя</th>
                    <th>Роль</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->role->name_ru }}</td>
                            <td><a class="d-inline-block" href="{{ route('admins_edit',$admin->id) }}">Редактировать</a>@if($admin->id != Auth::user()->id)<form class="d-inline-block" action="{{ route('admins_delete',$admin->id) }}" method="post">@csrf <button class="btn btn-danger mx-3 py-1">Удалить</button></form>@endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
