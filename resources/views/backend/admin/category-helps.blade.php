@extends('backend.admin.layout')

@section('content')
    <div class="row">
        <div class="col-6">
            <form action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="id" placeholder="Поиск по id">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">поиск</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-12 mt-2 mb-4">
            <h1>Заявки от получателей помощи : {{ $title }}</h1>
            @include('frontend.alerts')
        </div>
            @foreach($helps as $item)
                <div class="col-6">
                    <div class="card my-3">
                        <div class="card-header">
                            {{ $item->whoNeedHelp->name_ru }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Помощь {{ getHelpId($item->id) }}</h5>
                            <p class="card-text">{{ $item->body }}</p>
                            <a href="{{ route('admin_help_check', $item->id) }}" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
            @endforeach
        <div class="col-sm-12">
            {{ $helps->links() }}
        </div>
        </div>
@endsection
