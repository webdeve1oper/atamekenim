@extends('backend.admin.layout')

@section('content')
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-12 mt-2 mb-2">
            <h1>Страница запроса: {{ $help->title }}</h1>
        </div>
        <div class="col-12">
            <span class="badge bg-success mb-5">{{ $help->who_need_help }}</span>
            <h5 class="border-bottom  d-table">Описание:</h5>
            <p class="mt-2 display-7">{{ $help->body }}</p>
            @if($help->admin_status == 'moderate')
                <button class="btn btn-primary mt-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    Действия
                </button>
            @else
                <div class="alert alert-info" role="alert">
                    Статус указанный админом - <strong>{{ $help->admin_status }}</strong>
                </div>
            @endif

            <!--Control Form-->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Действия</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="mb-5 display-7 border-bottom border-info d-table">
                        Задать статус для запроса: "{{ $help->title }}"
                    </div>
                    <div class="dropdown mt-3">
                        <form action="{{ route('edit_help_status') }}" method="post">
                            @csrf
                            <input type="text" name="help_id" class="d-none" value="{{ $help->id }}">
                            <div class="form-check my-3 border-bottom pb-3">
                                <input class="form-check-input" type="radio" name="status_name" id="flexRadioDefault1" value="finished">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Одобрить запрос
                                </label>
                            </div>
                            <div class="form-check my-3 border-bottom pb-3">
                                <input class="form-check-input" type="radio" name="status_name" id="flexRadioDefault2" value="edit">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Отправить на доработку (необходимо написать причину***)
                                </label>

                                <!--editor-->
                                <div class="form-floating mt-2">
                                    <textarea class="form-control" name="whyfordesc" placeholder="Причина отправки запроса на доработку?" id="floatingTextarea"></textarea>
                                    <label for="floatingTextarea">Причина?</label>
                                </div>
                            </div>

                            <div class="form-check my-3">
                                <input class="form-check-input" type="radio" name="status_name" id="flexRadioDefault3" value="cancel">
                                <label class="form-check-label" for="flexRadioDefault3">
                                    Отклонить запрос (необходимо выбрать причину***)
                                </label>

                                <!--select-->
                                <div class="form-floating mt-2">
                                    <select class="form-select" id="floatingSelect" aria-label="Причина отклонения запроса?" name="whycancel">
                                        <option disabled selected>Выбрать причину:</option>
                                        <option value="Нельзя">Нельзя</option>
                                        <option value="Потому что">Потому что</option>
                                        <option value="Документы">Документы</option>
                                    </select>
                                    <label for="floatingSelect">Причина отклонения запроса?</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
