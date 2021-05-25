@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Заявки от получателей помощи : {{ $title }}</h1>
            @include('frontend.alerts')
        </div>
        <div class="col-12">
            @foreach($fonds as $item)
                <div class="card my-3">
                    <div class="card-header">
                        ID Фонда: {{ $item->id }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title_ru }}</h5>
                        <p class="card-text">{{ $item->website }}</p>
                        @if($item->logo)
                            <img src="{{ $item->logo }}" alt="" class="mb-4 d-table" style="height: 100px;">
                        @endif
                        <a href="#" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
