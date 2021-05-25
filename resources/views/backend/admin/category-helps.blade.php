@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Заявки от получателей помощи : {{ $title }}</h1>
            @include('frontend.alerts')
        </div>
        <div class="col-12">
            @foreach($helps as $item)
                    <div class="card my-3">
                        <div class="card-header">
                            {{ $item->whoNeedHelp->name_ru }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Помощь {{ $item->id }}</h5>
                            <p class="card-text">{{ $item->body }}</p>
                            <a href="{{ route('admin_help_check', $item->id) }}" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
@endsection
