@extends('backend.fond_cabinet.setting')

@section('setting_content')
    <div class="row">
        <div class="col-12 mb-3">
            <h1>ПРОЕКТЫ ВАШЕЙ ОРГАНИЗАЦИИ</h1>
            <a href="{{route('create_project')}}" class="btn btn-default float-right">+ Добавить проект</a>
        </div>
        @foreach(Auth::user()->projects as $project)
            <div class="col-sm-4">
                <div class="p-3" style="border: 1px solid #0053a5; border-radius: 3px;">
                    <p class="name">Название проекта: <b>{{$project->title}}</b></p>
                    <p>Сферы деятельности:  @foreach($project->baseHelpTypes as $i => $help){{$help['name_'.app()->getLocale()]}},@endforeach</p>
                    <p>Описание: {{strip_tags(substr($project->about, 0,100))}}</p>
                    <a href="{{ route('fond_project_update',$project->id) }}" class="btn btn-default p-2"><img src="/img/settings.svg" alt=""> Редактировать</a>
                    <a href="" class="btn btn-danger p-2"> Удалить</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
