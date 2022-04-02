@extends('backend.admin.layout')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <form action="{{ route('admin_helps_search') }}" method="get">
        @csrf
        <div class="col-12">
            <h5>Поиск</h5>
            <div class="row">
                <hr>
                <div class="col-2">
                    <p>Поиск по id заявки</p>
                    <input type="text" name="help_id" value="{{app('request')->input('help_id')}}" class="form-control" placeholder="id заявки">
                </div>
                <div class="col-3">
                    <p>Фамилия</p>
                    <select class="form-control" id="last_name" value="{{app('request')->input('last_name')}}"
                            name="user_id"></select>
                </div>
                <div class="col-3">
                    <p>Поиск по слову в тексте</p>
                    <input type="text" name="body" value="{{app('request')->input('body')}}" placeholder="Поиск по слову в тексте" class="form-control">
                </div>
                <div class="col-2">
                    <p>Номер телефона</p>
                    <input type="text" name="phone" value="{{app('request')->input('phone')}}" id="phone" placeholder="Поиск по номеру телефона" class="form-control">
                </div>
                <div class="col-2">
                    <p>&nbsp;</p>
                    <input type="submit" value="Поиск" class="form-control btn-primary">
                </div>
            </div>
        </div>
    </form>
    @if($helps)
       <div class="col-12">
           <div class="row">
               @foreach($helps as $item)
                   <div class="col-6">
                       <div class="card my-3" >
                           <div class="card-header" @if($item->admin_status == 'finished' and $item->fond_status == 'wait' and $item->status_kh == 'possible') style="    background-color: #ff5630; color: white;" @endif>
                               {{ $item->whoNeedHelp->name_ru }}
                           </div>
                           <div class="card-body">
                               <h5 class="card-title">Помощь {{ getHelpId($item->id) }}</h5>
                               <p class="card-text">{{ $item->body }}</p>
                               <a href="{{ route('admin_help_check', $item->id) }}" class="btn btn-primary">Подробнее</a>
                           </div>
                       </div>
                   </div>
               @endforeach
               <div class="col-sm-12">
                   {{ $helps->appends(request()->input())->links() }}
               </div>
           </div>
       </div>
    @endif
    <script>

        $('#last_name').select2({
            allowClear: true, minimumInputLength: 3,
            language: {
                inputTooShort: function (args) {

                    return "Введите минимум 3 символа.";
                },
                noResults: function () {
                    return "Не найдено.";
                },
                searching: function () {
                    return "Поиск...";
                },
            },
            ajax: {
                url: " {{route('get_users')}}",
                dataType: 'json',
                type: "GET",
                quietMillis: 100,
                data: function (term) {
                    return {
                        name: term.term,
                        _token: '{{csrf_token()}}'
                    };
                },
                processResults: function (response) {
                    var datas = [];
                    for (let [key, value] of Object.entries(response)) {
                        datas.push({id: value.id, text: value.text + ' '+ value.text2});
                    }
                    return {
                        results: datas
                    };
                }
            }

        });
    </script>
@endsection
