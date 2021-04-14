@extends('backend.fond_cabinet.layout')

@section('fond_content')
    <div class="container-fluid default myOrganizationContent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="accountMenu border-0 mb-5">
                        <ul>
                            <li><a href="{{route('fond_setting')}}" class="btn-default @if(Route::is('fond_setting')) blue @endif">БАЗОВАЯ ИНФОРМАЦИЯ</a></li>
                            <li><a href="{{route('fond_editActivity')}}" class="btn-default @if(Route::is('fond_editActivity')) blue @endif">БЛАГОТВОРИТЕЛЬНАЯ ДЕЯТЕЛЬНОСТЬ</a></li>
{{--                            <li><a href="{{route('projects')}}" class="btn-default @if(Route::is('projects') or Route::is('create_project')) blue @endif">ПРОЕКТЫ</a></li>--}}
                            <li><a href="{{route('partners')}}" class="btn-default @if(Route::is('partners')) blue @endif">ПАРТНЕРЫ</a></li>
                            <li><a href="{{route('gallery')}}" class="btn-default @if(Route::is('gallery')) blue @endif">ГАЛЕРЕЯ</a></li>
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
