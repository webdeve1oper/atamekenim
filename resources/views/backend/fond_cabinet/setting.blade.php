@extends('backend.fond_cabinet.layout')

@section('fond_content')
    <div class="container-fluid default myOrganizationContent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="accountMenu border-0 mb-5">
                        <ul>
                            <li><a href="{{route('fond_setting')}}" class="btn-default @if(Route::is('fond_setting')) blue @endif">Основные настройки</a></li>
                            <li><a href="{{route('projects')}}" class="btn-default @if(Route::is('projects') or Route::is('create_project')) blue @endif">Проекты</a></li>
                            <li><a href="{{route('partners')}}" class="btn-default @if(Route::is('partners')) blue @endif">Партнеры</a></li>
                            <li><a href="{{route('gallery')}}" class="btn-default @if(Route::is('gallery')) blue @endif">Галерея</a></li>
                        </ul>
                    </div>
                    <div class="greyInfoBlock firstBig">
                        @yield('setting_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection