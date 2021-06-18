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
                        <textarea name="descr" id="descrPartner" placeholder="Краткое описание"></textarea>
                        <input type="submit" class="btn btn-default mt-3" value="Загрузить">
                    </form>
                </div>
                <div class="col-sm-9">
                    <ul id="sortable" class="ui-sortable list-unstyled">
                        @foreach($gallery as $partner)
                            <li class="ui-state-default mb-4"><img class="img-fluid" src="{{$partner->image}}" alt=""><br><br>
                                <p><label>Название:</label><br>{{$partner->title}} </p>
                                <hr>
                                <p>
                                    <label>Краткое описание:</label><br>{{ $partner->descr }}</p>
                                <hr>
                                <label>Сортировка</label>
                                <form action="{{route('update_gallery')}}" method="post">
                                    @csrf
                                    <input type="text" name="gallery_id" value="{{ $partner->id }}" class="d-none">
                                    <select name="orders" class="updatePartner form-control">
                                        @foreach($gallery as $k => $item)
                                            <option value="{{ $k+1 }}" @if($partner->orders == $k+1) selected="selected" @endif>{{ $k+1 }}</option>
                                        @endforeach
                                    </select>
                                </form>
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
            object-fit: contain;
        }
        #sortable li{
            margin: 3px 3px 3px 0;
            padding: 1px;
            float: left;
            border: 0;
            background: none;
            position: relative;
        }
        #descrPartner{
            display: table;
            margin: 10px 0;
            width: 100%;
            height: 80px;
            border: 1px solid #eee;
            border-radius: 3px;
            padding: 10px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.updatePartner').change(function(){
                $(this).parents('form').submit();
            });
        });
    </script>
@endsection
