@extends('frontend.layout')

@section('content')
    <div class="container-fluid fatherBlock">
        <div class="container">
            <div class="row">
                <h1>Форма подачи заявки на помощь</h1>
                <form action="" method="post">
                    @csrf
                    <input type="text" name="title">
                </form>
            </div>
        </div>
    </div>
@endsection