<table class="table table-bordered">
    @if(count($requisites) > 0)

        <thead>
        <tr>
            <td><b>БИН:</b></td>
            <td><b>БИК:</b></td>
            <td><b>ИИК:</b></td>
            <td><b>Название банка:</b></td>
            <td><b>Руководитель:</b></td>
            <td><b>Юридический адрес:</b></td>
            <td class="text-center" colspan="2"><b>Действие</b></td>
        </tr>
        </thead>
        @foreach($requisites as $i=> $requisite)
            <tr id="requisite_item_{{$requisite['id']}}">
                <td>@if($i == 0) {{Auth::user()->bin}} @else {{$requisite['bin']}} @endif</td>
                <td>{{$requisite['iik']}}</td>
                <td>{{$requisite['bik']}}</td>
                <td>{{$requisite['name']}}</td>
                <td>{{$requisite['leader']}}</td>
                <td>{{$requisite['yur_address']}}</td>
                <td class="text-center" style="border-right: 0;"><p class="btn btn-default" data-toggle="modal" data-target="#requisite{{$i}}">Редактировать</p></td>
                <td class="text-center" style="border-left: 0;"><p onclick="deleteRequisite({{$requisite['id']}})" class="btn btn-default" style="border-color: red; color: red!important;">Удалить</p></td>
            </tr>
        @endforeach
        <p class="btn btn-default p-2 float-right mt-2 mb-5 d-table" data-toggle="modal" data-target="#newRequiesite">
            + добавить еще один счет
        </p>
    @else
        <tr>
            <td rowspan="6">
                <p class="btn btn-default p-2 float-right mt-2 mb-5 d-table" data-toggle="modal" data-target="#newRequiesite">
                    &nbsp;+ добавить счет&nbsp;
                </p>
            </td>
        </tr>
    @endif
</table>
