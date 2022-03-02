@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Фонды в реестре</h1>
            @include('frontend.alerts')
        </div>
        <div class="col-sm-12">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Название</th>
                    <th>БИН</th>
                    <th>Эл. почта</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($fonds as $fond)
                    <tr>
                        <td>{{ $fond->title_ru }}</td>
                        <td>{{ $fond->bin }}</td>
                        <td>{{ $fond->email }}</td>
                        <td><a class="d-inline-block" href="{{ route('active_fond_check',$fond->id) }}">Редактировать</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $fonds->links() }}
        </div>
    </div>
@endsection
