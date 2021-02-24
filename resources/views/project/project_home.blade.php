@extends('layouts.master')

@section('content')

@include('modal.read_project')


<div class="row">
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-center">
            <h3 class="m-0 font-weight-bold text-primary">{{$project->name}}</h3>
        </div>
        <div class="card-body">
            @if ($project->description == null)
                <h4> Not have description. </h4>
                @else
                <h4> {{$project->description}} </h4>
            @endif
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h3 class="m-0 font-weight-bold text-primary">Case</h3>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Add case</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="color: black;">Name</th>
                            <th style="color: black;">Description</th>
                            <th style="color: black;">Option</th>
                        </tr>
                    </thead>
                    @foreach ($case as $item)
                        <tr>
                            <th>{{$item->name}}</th>
                            @if($item->status == "new")
                                <th style="color: #4e73df;">{{$item->status}}</th>
                                @elseif($item->status == "successfully")
                                <th style="color: #1cc88a;">{{$item->status}}</th>
                                @else
                                <th style="color: #f6c23e;">{{$item->status}}</th>
                            @endif
                            <th>
                                <div class="row">
                                    <div class="col-4">
                                        <a href="" class="openCase" onclick="importId({{$item->id}})" data-toggle="modal" data-target="#add-type-modal">
                                            <i class="fas fa-book-open"></i>
                                        </a>
                                    </div>
                                   <div class="col-1">
                                        <a id="edit-material" href="" data-toggle="modal"><i class="fas fa-vote-yea" style="color: green;"></i></a>
                                   </div>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h3 class="m-0 font-weight-bold text-primary">Member</h3>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Add member</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="color: black;">Name</th>
                            <th style="color: black;">Role</th>
                            <th class="text-center" style="color: black;">Delete</th>
                        </tr>
                    </thead>
                    @foreach ($member as $item)
                        <tr>
                            <td>{{$item->username}}</td>
                            <td>{{$item->role}}</td>
                            <td class="text-center">
                                <a id="a_delete" href="" class="btn text-danger @if($item->role === 'OWNER') disabled @endif"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>



    <script>
        $(document).ready(function() {
            var token = $.cookie('token');

        });
        function importId(data){
            var token = $.cookie('token');
            var formData = {
                id: data,
            };
            $.ajax({
                type: 'POST',
                url: 'api/project/member/case/open',
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response) {
                    console.log(response);
                    $('.description').append('<h5 class="detail">'+response.data.detail+"</h5>");
                    $('.endCaseDate').append('<h5 class="endCase">'+response.data.end_case_time+"</h5>");
                }
            });
        }
    </script>
@endsection

</body>
</html>

