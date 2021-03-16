@extends('admin.layouts.master')

@section('content')

@include('admin.modal.edit_project')
@include('admin.modal.add_case')
@include('admin.modal.add_member')
@include('admin.modal.read_case_edit_project')

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
                                <th style="color: black;">Member</th>
                                <th style="color: black;">Status</th>
                                <th style="color: black;">Option</th>
                            </tr>
                        </thead>
                        <thead id="caseShow">
                            {{-- case Show aria --}}
                        </thead>
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
        $(document).ready(function () {
            var token = $.cookie('token');
            var tokenName = $.cookie('username');
            var role = $.cookie('role');
            if(token == null){
                $.removeCookie('token');
                $.removeCookie('username');
                $.removeCookie('role');
                window.location = '/login';
            }else {
                if(role != 'ADMIN'){
                    $.removeCookie('token');
                    $.removeCookie('username');
                    $.removeCookie('role');
                    window.location = '/login';
                }
            }
            var param = document.URL.split('=')[1];
            formData = {
                projectId: param,
            };
            $.ajax({
                type: "POST",
                url: "/api/project/member/case/paginateCaseEdit",
                data: formData,
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
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

            $.ajax({
                type: "POST",
                url: "/api/project/member/paginateMemberEdit",
                data: formData,
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    var countPage = response.data.last_page;
                    var currentPage = response.data.current_page;
                    $('#memberShow').html(response.html);
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
                }
            });
        });

        // paginate member
        function paginateMember(page) {
            var token = $.cookie('token');
            var tokenName = $.cookie('username');
            var param = document.URL.split('=')[1];
            formData = {
                projectId: param,
            };
            $.ajax({
                type: 'POST',
                url: '/api/project/member/paginateMemberEdit?page='+page,
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response){
                    var countPage = response.data.last_page;
                    var currentPage = response.data.current_page;
                    $('#memberShow').empty();
                    $('#paginationMember').empty();
                    $('#memberShow').html(response.html);
                    // ทำ pagination ของ case
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
                }
            });
        }

        // paginate case
        function paginate(page) {
            var token = $.cookie('token');
            var tokenName = $.cookie('username');
            var param = document.URL.split('=')[1];
            formData = {
                projectId: param,
            };
            $.ajax({
                type: 'POST',
                url: '/api/project/member/case/paginateCaseEdit?page='+page,
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response){
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
                        Swal.fire({
                            title: 'Successfully',
                            text: 'Update project successfully.',
                            icon: 'success',
                            showConfirmButton: true,
                            focusConfirm: true,
                        }).then(function(confirm) {
                                location.reload();
                        });
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
                url: '/api/project/member/case/readCase',
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response) {
                    console.log(response.data);
                    $('.description').append('<h5 class="detail">'+response.data.detail+"</h5>");
                    $('.endCaseDate').append('<h5 class="endCase">'+response.data.end_case_time+"</h5>");
                }
            });
        }

        function deleteCase(data){
            var token = $.cookie('token');
            var formData = {
                id: data,
            };
            Swal.fire({
                title: 'ARE YOU SURE FOR DELETE THIS CASE?',
                text: 'plese check your again and accept.',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                focusConfirm: true,
            }).then(function (confirm) {
                if(confirm){
                    $.ajax({
                        type: 'POST',
                        url: '/api/project/member/case/delete',
                        dataType: 'json',
                        data: formData,
                        headers: {
                            'Authorization': 'Bearer '+token,
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'SUCCESSFULLY',
                                text: 'Case is deleted.',
                                icon: 'success',
                                showConfirmButton: true,
                                focusConfirm: true,
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        function deleteMember(data){
            var token = $.cookie('token');
            Swal.fire({
                title: 'ARE YOU SURE FOR DELETE THIS MEMBER?',
                text: 'plese check your again and accept.',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                focusConfirm: true,
            }).then(function (confirm) {
                if(confirm.value) {
                    var formData = {
                        projectId: data.project_id,
                        username: data.username,
                    };
                    console.log(formData);
                    $.ajax({
                        type: 'POST',
                        url: '/api/project/member/delete',
                        dataType: 'json',
                        data: formData,
                        headers: {
                            'Authorization': 'Bearer '+token,
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'SUCCESSFULLY',
                                text: 'Case is deleted.',
                                icon: 'success',
                                showConfirmButton: true,
                                focusConfirm: true,
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection