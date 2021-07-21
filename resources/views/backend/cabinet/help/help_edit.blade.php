@section('content')
    <div class="container-fluid default breadCrumbs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('cabinet') }}">Кабинет</a></li>
                        <li><a>Заявка id:{{ $help->id }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid default completeApplicationPage">
        <div class="container">
            @include('frontend.alerts')
            <div class="row">
                <div class="col-sm-5">
                    <p class="blueName">Редактирование заявки ID: <span>{{ getHelpId($help->id) }}</p>
                </div>
                <div class="col-sm-12 mb-4">
                </div>
                <div class="col-sm-12">
                    <form action="{{ route('update_help',$help->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($errors->has('title'))
                            <span class="error">{{ $errors->first('title') }}</span>
                        @endif
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group mb-4">
                                    <label for="who_need_help">{{trans('fonds.who-helps')}}</label>
                                    <select name="who_need_help" id="who_need_help" class="form-control">
                                        @foreach($scenarios as $value => $scenario)
                                            <option value="{{$scenario['id']}}">{{$scenario['name_'.app()->getLocale()] ?? $scenario['name_ru']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!--destination 1-->
                            <div class="col-sm-12 destinations1">
                                <div class="form-group mb-4 ">
                                    <label for="destinations1">{{trans('fonds.chois-stat-help')}}</label>
                                    <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.chois-stat-help2')}}" id="destinations1"></select>
                                </div>
                            </div>

                            <!--destination 2-->
                            <div class="col-sm-12 destinations2">
                                <div class="form-group mb-4">
                                    <label for="destinations2">{{trans('fonds.check-tjs-helps')}}</label>
                                    <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.check-tjs-helps')}}" id="destinations2"></select>
                                </div>
                            </div>

                            <!--destination 3-->
                            <div class="col-sm-12 destinations3">
                                <div class="form-group mb-4">
                                    <label for="destinations3">{{trans('fonds.check-origin-help')}}</label>
                                    <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.check-origin-help')}}" id="destinations3"></select>
                                </div>
                            </div>

                            <!--destination 4-->
                            <div class="col-sm-12 destinations4">
                                <div class="form-group mb-4">
                                    <label for="destinations4">{{trans('fonds.check-stat-health')}}</label>
                                    <select name="destinations[]" class="select2 w-100" multiple placeholder="{{trans('fonds.check-stat-health')}}" id="destinations4"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 regions">
                                <div class="form-group mb-4">
                                    <label for="regions">{{trans('fonds.indicate-place-help')}}</label>
                                    <select name="region_id" class="select2 w-100" placeholder="{{trans('fonds.type-help')}}" id="regions">
                                        @foreach($regions as $region)
                                            <option value="{{$region->region_id}}">{{$region->text}}</option>
                                        @endforeach
                                    </select>
                                    <small>{{trans('fonds.name-settlement')}}</small>
                                </div>
                            </div>

                            <div class="col-sm-4 districts" style="display: none">
                                <div class="form-group mb-4">
                                    <label for="">{{trans('fonds.disctrit')}}</label>
                                    <select name="district_id" class="select2 w-100" placeholder="Тип помощи" id="districts"></select>
                                </div>
                            </div>

                            <div class="col-sm-4 cities" style="display: none">
                                <div class="form-group mb-4">
                                    <label for="">{{trans('fonds.city')}}</label>
                                    <select name="city_id" class="select2 w-100" placeholder="Тип помощи" id="cities"></select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group mb-4 baseHelpTypes">
                            <label for="baseHelpTypes">{{trans('fonds.check-scope-help')}}</label>
                            <select name="baseHelpTypes[]" class="select2 w-100" placeholder="{{trans('fonds.scope-help')}}" id="baseHelpTypes">
                                @foreach($baseHelpTypes as $destionation)
                                    <option value="{{$destionation->id}}">{{$destionation->name_ru}}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">{{trans('fonds.scope-help')}}</small>
                        </div>

                        <div class="form-group mb-4 cashHelpTypes">
                            <label for="exampleInputEmail1">{{trans('fonds.check-type-help')}}</label>
                            <select name="cashHelpTypes[]" class="select2 w-100" multiple placeholder="{{trans('fonds.type-rendered-help')}}" id="cashHelpTypes">
                                @foreach($cashHelpTypes as $destination)
                                    <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4 cashHelpSizes">
                            <label for="exampleInputEmail1">{{trans('fonds.indicate-summ-help')}}</label>
                            <select name="cash_help_size_id" class="select2 w-100" placeholder="{{trans('fonds.type-rendered-help')}}" id="cashHelpSizes">
                                @foreach($cashHelpSizes as $destination)
                                    <option value="{{$destination['id']}}">{{$destination['name_'.app()->getLocale()] ?? $destination['name_ru']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1">{{trans('fonds.indicate-urgency-help')}}</label>
                            <select name="urgency_date" class="select2 w-100" placeholder="{{trans('fonds.indicate-urgency-help2')}}" id="helpUrgencyDate">
                                <option value="1">{{trans('fonds.flow-month-1')}}</option>
                                <option value="2">{{trans('fonds.flow-month-3')}}</option>
                                <option value="3">{{trans('fonds.flow-month-6')}}</option>
                                <option value="4">{{trans('fonds.flow-year')}}</option>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1">{{trans('fonds.attach-photo-video')}}</label>
                            <ul class="justify-content-start d-flex list-unstyled">
                                @foreach($help->images as $image)
                                    <li class="mr-4" style="position: relative;" id="file-{{$image->id}}">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{$image->image}}" class="img-fluid" style="max-width: 200px; height: 100px; object-fit: cover;" alt="">
                                                <button class="deletefile" type="button" style="top: 5px;" onclick="deleteImage({{$image->id}});"><i style="color: #0053a5;" class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                            <div class="input-group">
                                <input type="file" id="file" name="photo[]" class="form-control photo">
                                <div class="input-group-append" style="display: none;">
                                    <button class="btn btn-default p-2" type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <button class="btn btn-default p-2 mt-2" onclick="if($('.photo').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();} return false;">+ Добавить еще</button>
                        </div>

                        <div class="form-group mb-4">
                            <label for="">{{trans('fonds.video-share')}}</label>
                            <input type="text" name="video" class="form-control" placeholder="{{trans('fonds.share-video2')}}">
                        </div>

                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1">{{trans('fonds.attach-doc-help')}}</label>
                            <br>
                            <ul class="justify-content-start d-flex list-unstyled">
                                @foreach($help->docs as $doc)
                                    <li class="pr-4"><div class="card p-2 pr-4"><a href="{{$doc->path}}">{{$doc->original_name}}</a><button class="deletefile" type="button" onclick="deleteFile({{$doc->id}});"><i class="fas fa-times" style="color: #0053a5"></i></button></div></li>
                                @endforeach
                            </ul>
                            <div class="input-group">
                                <input type="file"  class="form-control docs" name="doc[]">
                                <div class="input-group-append" style="display: none;">
                                    <button class="btn btn-default p-2" type="button" onclick="$(this).parents('.input-group').remove();"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <button class="btn btn-default p-2 mt-2" onclick="if($('.docs').length <5){$($(this).prev().clone()).insertBefore(this).find('.input-group-append').show();} return false;">+ Добавить еще</button>
                        </div>

                        <textarea name="body" placeholder="{{trans('fonds.desc-help')}}" class="form-control mb-3" id="helpBody" cols="20" rows="10">{{$help->body}}</textarea>
                        {{--<input type="submit" class="btn btn-default m-auto d-table" value="{{trans('fonds.find')}}">--}}
                        <input type="submit" class="btn btn-default m-auto d-table" value="Обновить">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .deletefile{
            position: absolute;
            right: 2px;
            padding: 3px;
            padding-top: 0px;
            background: none;
            border: none;
            box-shadow: none;
        }
    </style>
    <script>
        function deleteImage(id){
            $.ajax({
                url: '{{route('delete_help_image')}}',
                method: 'GET',
                data: {'_token':'{{csrf_token()}}', 'id': id},
                success: function(){
                    $('#image-'+id).fadeOut('slow');
                    setTimeout(function(){
                        $('#image-'+id).remove();
                    }, 600);
                }
            })
        }
        function deleteFile(id){
            $.ajax({
                url: '{{route('delete_help_file')}}',
                method: 'GET',
                data: {'_token':'{{csrf_token()}}', 'id': id},
                success: function(){
                    $('#file-'+id).fadeOut('slow');
                    setTimeout(function(){
                        $('#file-'+id).remove();
                    }, 600);
                }
            })
        }
    </script>
    @include('backend.cabinet.help.script')
@endsection
@extends('frontend.layout')
