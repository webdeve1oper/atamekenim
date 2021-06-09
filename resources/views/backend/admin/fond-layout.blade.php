@extends('backend.admin.layout')

@section('content')
    <div class="row">
        @include('frontend.alerts')
        <div class="col-sm-6 mt-2 mb-2">
            <h1>Благотворительная организация: ID{{ $fond->id }}</h1>
        </div>
        <div class="col-sm-6">
            @if($fond->status == 2)
                <ul class="controlButton">
                    <li>
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1">В реестр</button>
                    </li>
                    <li>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2">Отклонена</button>
                    </li>
                </ul>
            @else
                <div class="alert alert-info" role="alert">
                    Статус указанный админом - <strong>{{ $fond->status }}</strong>
                </div>
            @endif
        </div>
        <div class="col-12">
            <p><span>Статус:</span> {{ $fond->status }}</p>
            <p><span>Организационно-правовая форма:</span> {{ $fond->organLegalForm->name }}</p>
            <p><span>БИН:</span> {{ $fond->bin }}</p>
            <p><span>Название организации:</span> {{ $fond->title_ru }}</p>
            <p><span>Электронная почта:</span> {{ $fond->email }}</p>
            <hr>
            <p><span>Телефон:</span> {{ $fond->phone }}</p>
            <p><span>Должность сотрудника организации:</span> {{ $fond->work }}</p>
            <p><span>ФИО сотрудника организации:</span> {{ $fond->fio }}</p>

            <!-- Принять -->
            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Одобрить запрос {{ $fond->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('edit_fond_status') }}" method="post">
                                @csrf
                                <input type="text" name="fond_id" class="d-none" value="{{ $fond->id }}">
                                <div class="form-check my-3 border-bottom pb-3">
                                    <input class="form-check-input d-none" type="radio" name="status_name" id="flexRadioDefault1" value="finished" checked="checked">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Одобрить запрос
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Одобрить запрос</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Отклонить -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabe2" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Отклонить {{ $fond->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('edit_fond_status') }}" method="post">
                                @csrf
                                <input type="text" name="fond_id" class="d-none" value="{{ $fond->id }}">
                                <div class="form-check my-3 border-bottom pb-3">
                                    <input class="form-check-input d-none" type="radio" name="status_name" id="flexRadioDefault2" value="cancel" checked="checked">
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
                                <button type="submit" class="btn btn-primary mt-4 mx-auto d-table">Отклонить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .controlButton{
        display: table;
        margin: 0;
    }
    .controlButton li{
        display: inline-table;
        vertical-align: middle;
        margin: 0 16px 0 0;
    }
</style>
