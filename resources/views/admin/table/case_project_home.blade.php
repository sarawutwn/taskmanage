@foreach ($arrayData as $data)
    <tr>
        <th>
            {{$data['name']}}
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
            <div class="row">
                <div class="col-4">
                    <a href="" class="openCase" onclick="getCaseDetail({{$data['id']}})" data-toggle="modal" data-target="#add-type-modal">
                        <i class="fas fa-book-open"></i>
                    </a>
                </div>
                @if ($data->status == "opened")
                    <div class="col-4">
                        <a id="read-logtime" href="" onclick="toLogtime({{$data['id']}})" data-toggle="modal" data-target="#read-logtime"><i class="fas fa-history" style="color: red;"></i></a>
                    </div>
                @else
                    <div class="col-4">
                        <i class="fas fa-history" style="color: grey;"></i>
                    </div>
                @endif
                @if ($data->status == "opened")
                    <div class="col-3">
                        <a href="" onclick="toEndCase({{$data['id']}})" data-toggle="modal"><i class="fas fa-vote-yea" style="color: grey;"></i></a>
                    </div>
                @elseif ($data->status == "successfully")
                    <div class="col-3">
                        <i class="fas fa-vote-yea" style="color: green;"></i>
                    </div>
                @else
                    <div class="col-3">
                        <i class="fas fa-vote-yea" style="color: grey;"></i>
                    </div>
                @endif
            </div>
        </th>
    </tr>
@endforeach