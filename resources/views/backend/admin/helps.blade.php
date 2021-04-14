@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Запросы на помощь</h1>
            @include('frontend.alerts')
        </div>
        <div class="col-12">
            <h5 class="mb-2 border-bottom  d-table">Новые заявки:</h5>
            @foreach($helps as $item)
                @if($item->admin_status == 'moderate')
                    <div class="card my-3">
                        <div class="card-header">
                            {{ $item->whoNeedHelp->name_ru }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ $item->body }}</p>
                            <a href="{{ route('admin_help_check', $item->id) }}" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-12">
            <hr>
            <h5 class="mb-2 border-bottom  d-table">Подтвержденные:</h5>
            @foreach($helps as $item)
                @if($item->admin_status == 'finished')
                    <div class="card my-3">
                        <div class="card-header">
                            {{ $item->whoNeedHelp->name_ru }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ $item->body }}</p>
                            <a href="{{ route('admin_help_check', $item->id) }}" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-12">
            <hr>
            <h5 class="mb-2 border-bottom  d-table">Заявки отправленные на доработку:</h5>
            @foreach($helps as $item)
                @if($item->admin_status == 'edit')
                    <div class="card my-3">
                        <div class="card-header">
                            {{ $item->whoNeedHelp->name_ru }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ $item->body }}</p>
                            <a href="{{ route('admin_help_check', $item->id) }}" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-12">
            <hr>
            <h5 class="mb-2 border-bottom  d-table">Отмененные заявки:</h5>
            @foreach($helps as $item)
                @if($item->admin_status == 'cancel')
                    <div class="card my-3">
                        <div class="card-header">
                            {{ $item->whoNeedHelp->name_ru }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ $item->body }}</p>
                            <a href="{{ route('admin_help_check', $item->id) }}" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
