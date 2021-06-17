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
