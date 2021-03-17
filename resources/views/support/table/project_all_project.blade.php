@foreach ($arrayData as $data)
    <tr>
        <th><a href="/support/edit/project={{$data['id']}}" style="color: blue;">{{$data['name']}}</a></th>
        @if ($data['description'] == null)
            <th>Not have description.</th>
        @else
            <th>{{$data['description']}}</th>
        @endif
        <th>{{$data['created_at']}}</th>
        <th>{{$data['project_code']}}</th>
    </tr>
@endforeach