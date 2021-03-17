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
         <th>
            <div class="row">
                <div class="col-6">
                    <a id="openCase" class="btn text-primary" onclick="getCaseDetail({{$data['id']}})" data-toggle="modal" data-target="#read_case_modal">
                        <i class="fas fa-book-open"></i>
                    </a>
                </div>
                <div class="col-6">
                    <a id="deleteCase" class="btn text-danger" onclick="deleteCase({{$data['id']}})"><i class="fas fa-trash"></i></a>
                </div>
            </div>
        </th>
    </tr>
@endforeach