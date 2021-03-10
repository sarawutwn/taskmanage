@extends('layouts.master')

@section('content')

@include('modal.read_project')
@include('modal.read_logtime')
@include('modal.edit_project')
@include('modal.add_case')
@include('modal.add_member')

<div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h3 class="m-0 font-weight-bold text-primary">{{ $project->name }}</h3>
                </div>
                <div class="card-body">
                    @if ($project->description == null)
                        <h4> Not have description. </h4>
                    @else
                        <h4> {{ $project->description }} </h4>
                    @endif
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-auto">
                            <a id="btn_edit_project" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#edit_project_modal"
                                data-project="{{$project}}">Edit</a>
                        </div>
                    </div>
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
                     <button id="btn_add_case" type="submit" class="btn btn-success" data-toggle="modal"
                        data-target="#add_case_modal" data-id="{{ $project->id }}">Add case</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="color: black;">Name</th>
                            <th style="color: black;">Status</th>
                            <th style="color: black;">Option</th>
                        </tr>
                    </thead>
                    <thead id="caseShow">
                        {{-- case Show aria --}}
                    </thead>
                    {{-- @foreach ($case as $item)
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
                    @endforeach --}}

                    <tbody>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul id="paginationCase" class="pagination justify-content-end">
                    {{-- paginate project aria --}}
                </ul>
            </nav>
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
                    <button id="btn_add_member" type="submit" class="btn btn-success" data-toggle="modal"
                        data-target="#add_member_modal" data-id="{{ $project->id }}">Add member</button>
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
                    <thead id="memberShow">
                        {{-- member Show aria --}}
                    </thead>
                    {{-- @foreach ($member as $item)
                        <tr>
                            <td>{{$item->username}}</td>
                            <td>{{$item->role}}</td>
                            <td class="text-center">
                                <a id="a_delete" class="btn text-danger @if($item->role === 'OWNER') disabled @endif" onclick="return deleteMember({{$item}});"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach --}}
                    <tbody>

                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul id="paginationMember" class="pagination justify-content-end">
                    {{-- paginate Member aria --}}
                </ul>
            </nav>
        </div>
    </div>
</div>
</div>



    <script>
        $(document).ready(function() {
            var token = $.cookie('token');
            var tokenName = $.cookie('username');
            var param = document.URL.split('&')[1];
            var paramProject = document.URL.split('&')[0];
            var project = paramProject.split('=')[1];
            var name = param.split('=')[1];
            if(tokenName != name){
                $.removeCookie('token');
                $.removeCookie('username');
                window.location = 'login';
            }
            var formData = {
                projectId: project,
            };

            // get เคสทั้งหมดของโปรเจคที่อยู่หน้านี้
            $.ajax({
                type: "POST",
                url: "/api/project/member/case/paginateCaseWhereProjectIdByTokenWithViewMake",
                data: formData,
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    var array = response.data.data;
                    var countPage = response.data.last_page;
                    var currentPage = response.data.current_page;
                    $('#caseShow').html(response.html);
                    // ทำ pagination ของ case
                    if(countPage == 1){
                        $('#paginationCase').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                        $('#paginationCase').append('<li class="page-item active"><a class="page-link">1</a></li>');
                        $('#paginationCase').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                    }else {
                        if(currentPage == 1){
                            $('#paginationCase').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                        }else {
                            var page = currentPage-1;
                            $('#paginationCase').append('<li class="page-item"><a class="page-link" onclick="return paginate('+page+');">Previous</a></li>');
                        }
                        $('#paginationCase').append('<li class="page-item  active"><a class="page-link" onclick="return paginate('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationCase').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationCase').append('<li class="page-item"><a class="page-link" onclick="return paginate('+countPage+');">'+countPage+'</a></li>');
                        if(currentPage == countPage){
                            $('#paginationCase').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                        }else{
                            var next = currentPage+1;
                            $('#paginationCase').append('<li class="page-item"><a class="page-link" onclick="return paginate('+next+');">Next</a></li>');
                        }
                    }
                }
            });

            // get สมาชิกทั้งหมดของโปรเจคนี้
            $.ajax({
                type: "POST",
                url: "/api/project/member/paginateMemberWhereProjectIdByToken",
                data: formData,
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(res){
                    var array = res.data.data;
                    var countPage = res.data.last_page;
                    var currentPage = res.data.current_page;
                    console.log(res);
                    $('#memberShow').html(res.html);
                    // ทำ pagination ของ case
                    if(countPage == 1){
                        $('#paginationMember').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                        $('#paginationMember').append('<li class="page-item active"><a class="page-link">1</a></li>');
                        $('#paginationMember').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                    }else {
                        if(currentPage == 1){
                            $('#paginationMember').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                        }else {
                            var page = currentPage-1;
                            $('#paginationMember').append('<li class="page-item"><a class="page-link" onclick="return paginateMember('+page+');">Previous</a></li>');
                        }
                        $('#paginationMember').append('<li class="page-item  active"><a class="page-link" onclick="return paginateMember('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationMember').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationMember').append('<li class="page-item"><a class="page-link" onclick="return paginateMember('+countPage+');">'+countPage+'</a></li>');
                        if(currentPage == countPage){
                            $('#paginationMember').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                        }else{
                            var next = currentPage+1;
                            $('#paginationMember').append('<li class="page-item"><a class="page-link" onclick="return paginateMember('+next+');">Next</a></li>');
                        }
                    }
                },
            });
        });

        function paginateMember(page){
            var token = $.cookie('token');
            var paramProject = document.URL.split('&')[0];
            var project = paramProject.split('=')[1];
            var formData = {
                projectId: project,
            };
            $.ajax({
                type: "POST",
                url: "/api/project/member/paginateMemberWhereProjectIdByToken?page="+page,
                data: formData,
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(res){
                    var array = res.data.data;
                    var countPage = res.data.last_page;
                    var currentPage = res.data.current_page;
                    $('#memberShow').empty();
                    $('#paginationMember').empty();
                    $('#memberShow').html(res.html);
                    // ทำ pagination ของ Member
                    if(currentPage == 1){
                        $('#paginationMember').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                    }else {
                        var page = currentPage-1;
                         $('#paginationMember').append('<li class="page-item"><a class="page-link" onclick="return paginateMember('+page+');">Previous</a></li>');
                    }
                    if(currentPage == countPage){
                        $('#paginationMember').append('<li class="page-item"><a class="page-link" onclick="return paginateMember('+1+');">'+1+'</a></li>');
                        $('#paginationMember').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationMember').append('<li class="page-item active"><a class="page-link" onclick="return paginateMember('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationMember').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                    }else{
                        var next = currentPage+1;
                        $('#paginationMember').append('<li class="page-item active"><a class="page-link" onclick="return paginateMember('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationMember').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationMember').append('<li class="page-item"><a class="page-link" onclick="return paginateMember('+countPage+');">'+countPage+'</a></li>');
                        $('#paginationMember').append('<li class="page-item"><a class="page-link" onclick="return paginateMember('+next+');">Next</a></li>');
                    }
                },
            });
        }

        // paginate case 
        function paginate(page) {
            var token = $.cookie('token');
            var paramProject = document.URL.split('&')[0];
            var project = paramProject.split('=')[1];
            var formData = {
                projectId: project,
            };
            $.ajax({
                type: 'POST',
                url: 'api/project/member/case/paginateCaseWhereProjectIdByTokenWithViewMake?page='+page,
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response){
                    var array = response.data.data;
                    var countPage = response.data.last_page;
                    var currentPage = response.data.current_page;
                    $('#caseShow').empty();
                    $('#paginationCase').empty();
                    $('#caseShow').html(response.html);
                    // ทำ pagination ของ case
                    if(currentPage == 1){
                        $('#paginationCase').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                    }else {
                        var page = currentPage-1;
                         $('#paginationCase').append('<li class="page-item"><a class="page-link" onclick="return paginate('+page+');">Previous</a></li>');
                    }
                    if(currentPage == countPage){
                        $('#paginationCase').append('<li class="page-item"><a class="page-link" onclick="return paginate('+1+');">'+1+'</a></li>');
                        $('#paginationCase').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationCase').append('<li class="page-item active"><a class="page-link" onclick="return paginate('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationCase').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                    }else{
                        var next = currentPage+1;
                        $('#paginationCase').append('<li class="page-item active"><a class="page-link" onclick="return paginate('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationCase').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationCase').append('<li class="page-item"><a class="page-link" onclick="return paginate('+countPage+');">'+countPage+'</a></li>');
                        $('#paginationCase').append('<li class="page-item"><a class="page-link" onclick="return paginate('+next+');">Next</a></li>');
                    }
                }
            });
        }
        
        //delete
        
        function deleteMember(data) {
            var token = $.cookie('token');
            // var projectId = $('.projectId'+data).val();
            // var username = $('.username'+data).val();
            
            Swal.fire({
                title: 'ARE YOU SURE DELETE MEMBER?',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
            }).then(function(confirm) {
                if (confirm.value) {
                    var formData = {
                        projectId: data.project_id,
                        username: data.username,
                    };
                    console.log(formData);
                    $.ajax({
                        type: "POST",
                        url: "/api/project/member/delete",
                        data: formData,
                        dataType: "json",
                        headers: {
                            'Authorization': 'Bearer ' + token,
                        },
                        success: function(response) {
                            Swal.fire({
                            title: 'SUCCESSFULLY',
                                text: 'Member is deleted in project.',
                                icon: 'success',
                                showConfirmButton: true,
                                focusConfirm: true,
                            }).then(function(confirm) {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        // เรียกปุ่ม edit project
        $('#btn_edit_project').click(function (e) {
            e.preventDefault();
            // console.log($('#btn_edit_project').data('project'))
            const project = $('#btn_edit_project').data('project');
            $('#modal-input-project-name').val(project.name);
            $('#modal-input-project-description').val(project.description);
            $('#edit_project_modal').modal('show');
        });

        // ยิงเพื่อส่งข้อมูลไป edit
        $('#edit_project').click(function(e) {
            e.preventDefault();
            const token = $.cookie('token');
            const project = $('#btn_edit_project').data('project');
            const name = $('#modal-input-project-name').val();
            const des = $('#modal-input-project-description').val();
            const formData = {
                id: project.id,
                name: name,
                description: des
            }
            Swal.fire({
                title: 'Please check the information!!',
                text: 'Make sure the information is correct before recording',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                focusConfirm: true,
                // cancelButtonColor: '#f5365c'
            }).then(function(confirm) {
                if (!confirm.value) {
                    return
                }
                $.ajax({
                    type: "POST",
                    url: "/api/project/edit",
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    dataType: "json",
                    success: function(data) {
                        $.cookie('token', data.data.token);
                        $.cookie('name', data.data.name);
                        $.cookie('description', data.data.description);
                        window.location = 'index'
                        console.log(data)
                    }
                });
            });
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
                if(confirm.value){
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
                        location.reload();
                    }
                });
                }else{
                    
                }
                
            });
        }
    </script>
@endsection

</body>
</html>

