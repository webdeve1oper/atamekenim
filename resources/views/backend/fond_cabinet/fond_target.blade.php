@extends('backend.fond_cabinet.setting')

@section('setting_content')
    <div class="col-sm-12 pb-5">
        <h1>ИНФОРМАЦИЯ О БЛАГОТВОРИТЕЛЬНОЙ ДЕЯТЕЛЬНОСТИ ВАШЕЙ ОРГАНИЗАЦИИ</h1>
        <p>
            Внесите информацию о том, кому, в каком регионе и как Ваша организация оказывает благотворительную помощь
        </p>
    </div>
    <form action="{{route('fond_editActivity')}}" method="post" enctype="multipart/form-data">
        <div class="row">
            @csrf
            <div class="col-12">
                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse2">Выберите основную сферу благотворительной деятельности Вашей организации (выберите один или несколько вариантов)* <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <?php $baseHelpTypess = array_column(Auth::user()->baseHelpTypes->toArray(), 'name_ru');?>
                                    @foreach($baseHelpTypes as $destination)
                                        <div class="col-sm-6">
                                            <div class="checkbox">
                                                <label>
                                                    <input @if(in_array($destination['name_ru'], $baseHelpTypess)) checked
                                                           @endif type="checkbox" id="base_help_types{{$destination['id']}}" name="base_help_types[]"
                                                           value="{{$destination['id']}}"> <b>{{$destination['name_ru']}}</b> @if($destination['description_ru'])<p>(<?php echo mb_strtolower($destination['description_ru']) ?> )@endif</p>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse3">Выберите дополнительную сферу благотворительной деятельности Вашей организации (выберите один и несколько вариантов) * <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <?php $addHelpTypess = array_column(Auth::user()->addHelpTypes->toArray(), 'name_ru');?>
                                    @foreach($baseHelpTypes as $destination)
                                        <div class="col-sm-6">
                                            <div class="checkbox">
                                                <label>
                                                    <input @if(in_array($destination['name_ru'], $addHelpTypess)) checked
                                                           @endif type="checkbox" id="add_help_types{{$destination['id']}}" name="add_help_types[]" value="{{$destination['id']}}"> <b>{{$destination['name_ru']}}</b> @if($destination['description_ru'])
                                                        <p>(<?php echo mb_strtolower($destination['description_ru']) ?> )@endif</p>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse4">Отметьте бенефициаров (получателей помощи), исходя из благотворительной деятельности Вашей организации (выберите один или несколько вариантов)*<i
                                    class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <?php $addHelpTypess = array_column(Auth::user()->scenarios->toArray(), 'name_ru');?>
                                    @foreach($scenarios as $destination)
                                        <div class="col-sm-6 @if($destination['id'] == 3)d-none @endif">
                                            <div class="checkbox">
                                                <label>
                                                    <input @if($destination['id'] == 1) onchange="$('#scenario_id3').prop('checked', $(this).prop('checked'))" @endif  @if(in_array($destination['name_ru'], $addHelpTypess)) checked
                                                           @endif type="checkbox" id="scenario_id{{$destination['id']}}" name="scenario_id[]" value="{{$destination['id']}}">
                                                    <b>@switch($destination['id'])
                                                            @case(2)
                                                                отдельные лица (адресная помощь)
                                                            @break
                                                            @case(1)
                                                                семьи
                                                            @break
                                                            @case(4)
                                                                сообщества (например, жителям жилого комплекса, жителям населенного пункта, людям, объединенным по определенным интересам и т.д.)
                                                            @break
                                                            @case(5)
                                                                организации (государственной или частной компании, например, детскому дому, больнице)
                                                            @case(6)
                                                                животные
                                                            @break
                                                        @endswitch
                                                    </b>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse15">Выберите вид оказываемой помощи Вашей организацией (выберите один или несколько вариантов) <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse15" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $cashHelpTypess = [];
                                        if (Auth::user()->cashHelpTypes) {
                                            $cashHelpTypess = array_column(Auth::user()->cashHelpTypes->toArray(), 'name_ru');
                                        }
                                        ?>
                                        @php $i = 0 @endphp
                                        @foreach($cashHelpTypes as $destination)
                                            <div class="checkbox">
                                                <input type="checkbox" @if(in_array($destination['name_ru'], $cashHelpTypess)) checked
                                                       @endif name="cashHelpTypes[]" value="{{$destination['id']}}" id="cashHelpTypes{{$destination['id']}}">
                                                <label for="cashHelpTypes{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse16">Выберите размер оказываемой помощи (выберите один или несколько вариантов)*<i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse16" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $cashHelpSizess = [];
                                        if (Auth::user()->cashHelpSizes) {
                                            $cashHelpSizess = array_column(Auth::user()->cashHelpSizes->toArray(), 'name_ru');
                                        }
                                        ?>
                                        @php $i = 0 @endphp
                                        @foreach($cashHelpSizes as $destination)
                                            @if($i != $destination->paren_id )
                                                @php $i = $destination->paren_id @endphp
                                            @endif
                                            <div class="checkbox">
                                                <input type="checkbox" @if(in_array($destination['name_ru'], $cashHelpSizess)) checked
                                                       @endif name="cashHelpSizes[]" value="{{$destination['id']}}" id="cashHelpSizes{{$destination['id']}}">
                                                <label for="cashHelpSizes{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="panel panel-default">
                        <div class="card-header">
                            <a data-toggle="collapse" class="collapsed" href="#collapse13">Адресаты <i class="fas fa-angle-up"></i></a>
                        </div>
                        <div id="collapse13" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $destinationss = [];
                                        if (Auth::user()->destinations) {
                                            $destinationss = array_column(Auth::user()->destinations->toArray(), 'name_ru');
                                        }
                                        ?>
                                        @php $i = 0 @endphp
                                        <p class="p-3"><b>{{config('destination_fond')[$i]}}</b></p>
                                        <div class="row">
                                            @foreach($destinations as $destination)
                                                <div class="col-12">
                                                    @if($i != $destination->parent_id )
                                                        @php $i = $destination->parent_id @endphp
                                                        <p class="p-3"><b>{{config('destination_fond')[$i]}}</b></p>
                                                    @endif
                                                    <div class="checkbox">
                                                        <input type="checkbox" @if(in_array($destination['name_ru'], $destinationss)) checked
                                                               @endif name="destinations[]" value="{{$destination['id']}}" id="destinations{{$destination['id']}}">
                                                        <label for="destinations{{$destination['id']}}"> {{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="submit" class="btn btn-default" value="Сохранить">
            </div>
        </div>
    </form>
    <style>
        .fa-angle-up {
            float: right;
        }

        .collapsed .fa-angle-up::before {
            content: "\f107";
        }

        .card a{
            color: rgb(0 83 165);
            font-weight: 600;
        }
    </style>
@endsection
