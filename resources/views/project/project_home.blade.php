@extends('layouts.master')

@section('content')

@include('modal.read_project')
@include('modal.read_logtime')


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
                                        <a href="" class="openCase" onclick="getCaseDetail({{$item->id}})" data-toggle="modal" data-target="#add-type-modal">
                                            <i class="fas fa-book-open"></i>
                                        </a>
                                    </div>
                                    @if ($item->status != "successfully")
                                    <div class="col-4">
                                        <a id="read-logtime" href="" onclick="toLogtime({{$item->id}})" data-toggle="modal" data-target="#read-logtime"><i class="fas fa-history" style="color: red;"></i></a>
                                    </div>
                                   @else
                                    <div class="col-4">
                                        <i class="fas fa-history" style="color: grey;"></i>
                                    </div>
                                   @endif
                                   @if ($item->status == "successfully")
                                    <div class="col-3">
                                        <i class="fas fa-vote-yea" style="color: green;"></i>
                                    </div>
                                    @else
                                    <div class="col-3">
                                        <a href="" onclick="toEndCase({{$item->id}})" data-toggle="modal"><i class="fas fa-vote-yea" style="color: grey;"></i></a>
                                   </div>
                                   @endif
                                   
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
            var tokenName = $.cookie('username');
            var param = document.URL.split('&')[1];
            var name = param.split('=')[1];
            if(tokenName != name){
                $.removeCookie('token');
                $.removeCookie('username');
                window.location = 'login';
            }
        });
        function getCaseDetail(data){
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

        //query ข้อมูลของ logtime เพื่อมาแปะข้อมูล และเช็คข้อมูลก่อนส่ง
        function toLogtime(data){
            var token = $.cookie('token');
            var formData = {
                id: data,
            };
            $.ajax({
                type: 'GET',
                url: 'api/project/member/case/logtime/getById',
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response) {
                    console.log(response);
                    $.cookie('caseData', data);
                    if(response.data != null){
                        if(response.data.total_working_time == null){
                            $("#detail").val(response.data.detail);
                        }
                    }else {
                        $("#detail").val(null);
                    }
                    
                }
            });
        }
        
        // ส่ง caseId ไปเพื่อกดนับเวลา start logtime
        function startLogTime(){
            var token = $.cookie('token');
            var caseData = $.cookie('caseData');
            var formData = {
                project_case_id: caseData,
                detail: $("#detail").val()
            };
            console.log(caseData);
            $.ajax({
                type: 'POST',
                url: 'api/project/member/case/logtime/timeStart',
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 201){
                        Swal.fire({
                            title: 'IS STARTING.',
                            text: 'Logtime of this case is starting.',
                            icon: 'info',
                            showConfirmButton: true,
                            focusConfirm: true,
                        });
                    }else if(response.status == 200){
                        Swal.fire({
                            title: 'IS START',
                            text: 'Logtime of this case is starting.',
                            icon: 'success',
                            showConfirmButton: true,
                            focusConfirm: true,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'REQUEST DETAIL!',
                        text: 'logtime is start when you have detail for working.',
                        icon: 'error',
                        showConfirmButton: true,
                        focusConfirm: true,
                    });
                }
            });
        }

        // ส่ง caseID ไป update logtime จาก start เป็น end
        function endLogTime(){
            var token = $.cookie('token');
            var caseData = $.cookie('caseData');
            var formData = {
                project_case_id: caseData,
                detail: $("#detail").val()
            };
            
            $.ajax({
                type: 'POST',
                url: 'api/project/member/case/logtime/timeEnd',
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                            title: 'SUCCESSFULLY',
                            text: 'Logtime of this case is ending.',
                            icon: 'success',
                            showConfirmButton: true,
                            focusConfirm: true,
                        });
                },
                error: function(){
                    Swal.fire({
                        title: "IS NOT STARTING!",
                        text: 'logtime is not starting.',
                        icon: 'error',
                        showConfirmButton: true,
                        focusConfirm: true,
                    });
                }
            });
        }

        // กดสิ้นสุด case 
        function toEndCase(data) {
            var token = $.cookie('token');
            var formData = {
                id: data,
            };

            Swal.fire({
                title: 'ARE YOU SURE FOR SUBMIT THIS CASE?',
                text: 'plese check your again and accept.',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                focusConfirm: true,
            }).then(function (confirm) {
                $.ajax({
                    type: 'POST',
                    url: 'api/project/member/case/update',
                    dataType: 'json',
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer '+token,
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            title: 'SUCCESSFULLY',
                            text: 'Case is ending.',
                            icon: 'success',
                            showConfirmButton: true,
                            focusConfirm: true,
                        });
                    }
                });
            });
        }
    </script>
@endsection

</body>
</html>

