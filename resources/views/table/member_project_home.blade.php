@foreach ($arrayData as $data)
    <tr>
        <td>{{$data['username']}}</td>
        <td>{{$data['role']}}</td>
        @if ($role == 'OWNER')
        <td class="text-center">
            <a id="a_delete" class="btn text-danger @if($data['role'] === 'OWNER') disabled @endif" onclick="return deleteMember({{$data}});"><i class="fas fa-trash"></i></a>
        </td>
        @else
        <td class="text-center">
            <a id="a_delete" class="btn text-danger disabled" onclick="return deleteMember({{$data}});"><i class="fas fa-trash"></i></a>
        </td>
        @endif
    </tr>
@endforeach