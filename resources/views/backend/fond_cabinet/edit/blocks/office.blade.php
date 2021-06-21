<tr id="office_item_{{$office['id']}}">
    <td>{{$office['leader']}}</td>
    <td>{{$office['address']}}</td>
    <td>{{$office['phone']}}</td>
    <td>{{$office['email']}}</td>
    <td>{{$office['time']}}</td>
    <td class="text-center" style="border-right: 0;"><p class="btn btn-default" data-toggle="modal" data-target="#office{{$i}}">Редактировать</p></td>
    <td class="text-center" style="border-left: 0;"><p onclick="deleteOffice({{$office['id']}})" class="btn btn-default" style="border-color: red; color: red!important;">Удалить</p></td>
</tr>
