@foreach ($project as $data)
    <tr>
        <th><a href="/admin/project={{$data['id']}}&name={{$token['username']}}" style="color: blue;">{{$data['name']}}</a></th>
        @if ($data['description'] == null)
            <th>Not have description.</th>
        @else
            <th>{{$data['description']}}</th>
        @endif
        <th>{{$data['created_at']}}</th>
        <th>{{$data['project_code']}}</th>
    </tr>
@endforeach