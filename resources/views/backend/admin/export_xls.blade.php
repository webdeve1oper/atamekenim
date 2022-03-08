@extends('backend.admin.layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Отчет</h1>
        </div>
        <div class="col-12">
            <form action="" method="post" class="row">
                @csrf
                <div class="col-sm-3">
                    <label for="">От</label>
                    <input type="date" name="date_from" value="{{date('Y-m-d')}}" class="form-control">
                </div>
                <div class="col-sm-3">
                    <label for="">До</label>
                    <input type="date" name="date_to" value="{{date('Y-m-d')}}"  class="form-control">
                </div>
                <div class="col-12 mb-sm-4"></div>
                <div class="col-sm-3 pt-3">
                    <ul class="list-unstyled pl-0 d-flex justify-content-around">
                        <li><div class="form-group">
                                <label for="first">Поступило</label>
                                <input id="first" name="type" type="radio" value="1"  checked>
                            </div></li>
                        <li><div class="form-group">
                                <label for="second">Отработано</label>
                                <input id="second" name="type" type="radio" value="2">
                            </div></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <input type="submit" value="Выгрузить" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
@endsection
