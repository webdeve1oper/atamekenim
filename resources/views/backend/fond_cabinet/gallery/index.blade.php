@extends('backend.fond_cabinet.setting')

@section('setting_content')
    <div class="container-fluid default myOrganizationContent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Фото</h1>
                </div>
                <div class="col-sm-3 mt-3">
                    <form action="{{route('gallery')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" placeholder="Название" class="form-control" name="title">
                        <input type="file" class="form-control mt-3" name="image">
                        <input type="hidden" name="orders" value="{{$gallery->count()}}">
                        <input type="submit" class="btn btn-default mt-3" value="Загрузить">
                    </form>
                </div>
                <div class="col-sm-9">
                    <ul id="sortable" class="ui-sortable list-unstyled">
                        @foreach($gallery as $partner)
                            <li class="ui-state-default"><img class="img-fluid" src="{{$partner->image}}" alt=""><p>{{$partner->title}} </p>
                                <form action="{{route('delete_gallery')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$partner->id}}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="border-0 p-0 position-absolute" style="right: 0; top: 0;"><i class="far fa-window-close"></i></button>
                                </form></li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        #sortable img{
            width: 180px;
            height: 140px;
        }
        #sortable li{
            margin: 3px 3px 3px 0;
            padding: 1px;
            float: left;
            border: 0;
            background: none;
            position: relative;
        }
    </style>
@endsection
