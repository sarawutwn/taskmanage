@foreach ($arrayData as $data)
    <tr>
        <th>
            {{$data['project_member_id']}}
        </th>
        <th>
            {{$data['name']}}
        </th>
        <th>
            {{$data['detail']}}
        </th>
        @if ($data['status'] == 'successfully')
        <th style="color: #1cc88a;">
            {{$data['status']}}
        </th>
        @elseif ($data['status'] == 'opened')
        <th style="color: #f6c23e;">
            {{$data['status']}}
        </th>
        @else 
         <th style="color: #4e73df;">
            {{$data['status']}}
        </th>
        @endif
        <th>
            {{$data['created_at']}}
        </th>
    </tr>
@endforeach