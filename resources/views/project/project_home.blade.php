@extends('layouts.master')

@section('content')
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
                            <a id="btn_edit_project" type="submit" class="btn btn-primary" data-toggle="modal"
<<<<<<< Updated upstream
                                data-project="{{$project}}">Edit</a>
=======
                                data-target="#edit_project_modal" data-project="{{ $project }}">Edit</a>
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                            <button type="submit" class="btn btn-success">Add case</button>
=======
                            <button id="btn_add_case" type="submit" class="btn btn-success" data-toggle="modal"
                                data-target="#add_case_modal" data-id="{{ $project->id }}">Add case</button>
>>>>>>> Stashed changes
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
<<<<<<< Updated upstream
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Option</th>
=======
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Option</th>
>>>>>>> Stashed changes
                                </tr>
                            </thead>
                            @foreach ($case as $item)
                                <tr>
                                    <th>{{ $item->name }}</th>
                                    @if ($item->status == 'new')
                                        <th style="color: #4e73df;">{{ $item->status }}</th>
                                    @elseif($item->status == "successfully")
                                        <th style="color: #1cc88a;">{{ $item->status }}</th>
                                    @else
                                        <th style="color: #f6c23e;">{{ $item->status }}</th>
                                    @endif
                                    <th>
                                        <div class="row">
                                            <div class="col-4">
<<<<<<< Updated upstream
                                                <a href="" class="openCase" onclick="importId({{ $item->id }})"
=======
                                                <a href="" class="openCase" onclick="getCaseDetail({{ $item->id }})"
>>>>>>> Stashed changes
                                                    data-toggle="modal" data-target="#add-type-modal">
                                                    <i class="fas fa-book-open"></i>
                                                </a>
                                            </div>
<<<<<<< Updated upstream
                                            <div class="col-1">
                                                <a id="edit-material" href="" data-toggle="modal"><i class="fas fa-vote-yea"
                                                        style="color: green;"></i></a>
                                            </div>
=======
                                            @if ($item->status != 'successfully')
                                                <div class="col-4">
                                                    <a id="read-logtime" href="" onclick="toLogtime({{ $item->id }})"
                                                        data-toggle="modal" data-target="#read-logtime"><i
                                                            class="fas fa-history" style="color: red;"></i></a>
                                                </div>
                                            @else
                                                <div class="col-4">
                                                    <i class="fas fa-history" style="color: grey;"></i>
                                                </div>
                                            @endif
                                            @if ($item->status == 'successfully')
                                                <div class="col-3">
                                                    <i class="fas fa-vote-yea" style="color: green;"></i>
                                                </div>
                                            @else
                                                <div class="col-3">
                                                    <a href="" onclick="toEndCase({{ $item->id }})"
                                                        data-toggle="modal"><i class="fas fa-vote-yea"
                                                            style="color: grey;"></i></a>
                                                </div>
                                            @endif


>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                            <a id="btn_add_member" type="submit" class="btn btn-success" data-toggle="modal"
                            data-target="#project_member_id">Add Member</a>
=======
                            <button id="btn_add_member" type="submit" class="btn btn-success" data-toggle="modal"
                                data-target="#add_member_modal" data-id="{{ $project->id }}">Add member</button>
>>>>>>> Stashed changes
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
<<<<<<< Updated upstream
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            @foreach ($member as $item)
                                <tr>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td class="text-center">
                                        <a id="a_delete" href="" class="btn text-danger @if ($item->role === 'OWNER') disabled @endif"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            <tbody>

=======
                        <table class="table table-bordered" id="member_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="color: black;">Name</th>
                                    <th style="color: black;">Role</th>
                                    <th class="text-center" style="color: black;">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($member as $item)
                                    <tr>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->role }}</td>
                                        <td class="text-center">
                                            <a id="a_delete" class="btn text-danger
                                                        @if ($item->role === 'OWNER') disabled @endif"
                                                data-member="{{ $item->username }}" data-project="{{ $project->id }}">
                                                <i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
>>>>>>> Stashed changes
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< Updated upstream

    @include('modal.read_project')
    @include('modal.edit_project')
=======
>>>>>>> Stashed changes

    @include('modal.read_project')
    @include('modal.read_logtime')
    @include('modal.edit_project')
    @include('modal.add_member')
    @include('modal.add_case')

<<<<<<< Updated upstream

    <script>
        $('#btn_add_member').click(function (e) {
        e.preventDefault();
        console.log('555555')

    });
        $(document).ready(function() {
            var token = $.cookie('token');

        });

        function importId(data) {
=======
    <script>
        //delete
        $(document).ready(function() {
            $('#member_table tr').click(function() {
                const token = $.cookie('token');
                var id = $(this).find("a").attr("id");
                let projectId = $(this).find("a").data("project");
                let username = $(this).find("a").data("member");

                if (id == "a_delete") {
                    Swal.fire({
                        title: 'ARE YOU SURE DELETE MEMBER?',
                        icon: 'warning',
                        showConfirmButton: true,
                        showCancelButton: true,
                    }).then(function(confirm) {
                        if (confirm.value) {

                        }
                    });
                }

                $.ajax({
                    type: "POST",
                    url: "/api/project/member/delete",
                    data: "data",
                    dataType: "dataType",
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    success: function(response) {
                        console.log(response)
                    }
                });
            });
        });

        // เรียกปุ่ม edit project
        $('#btn_edit_project').click(function(e) {
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

        $(document).ready(function() {
            var token = $.cookie('token');
            var tokenName = $.cookie('username');
            var param = document.URL.split('&')[1];
            var name = param.split('=')[1];
            if (tokenName != name) {
                $.removeCookie('token');
                $.removeCookie('username');
                window.location = 'login';
            }
        });

        function getCaseDetail(data) {
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
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    console.log(response);
                    $('.description').append('<h5 class="detail">' + response.data.detail + "</h5>");
                    $('.endCaseDate').append('<h5 class="endCase">' + response.data.end_case_time + "</h5>");
                }
            });
        }

        //query ข้อมูลของ logtime เพื่อมาแปะข้อมูล และเช็คข้อมูลก่อนส่ง
        function toLogtime(data) {
>>>>>>> Stashed changes
            var token = $.cookie('token');
            var formData = {
                id: data,
            };
            $.ajax({
<<<<<<< Updated upstream
                type: 'POST',
                url: 'api/project/member/case/open',
=======
                type: 'GET',
                url: 'api/project/member/case/logtime/getById',
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    console.log(response);
                    $.cookie('caseData', data);
                    if (response.data != null) {
                        if (response.data.total_working_time == null) {
                            $("#detail").val(response.data.detail);
                        }
                    } else {
                        $("#detail").val(null);
                    }

                }
            });
        }

        // ส่ง caseId ไปเพื่อกดนับเวลา start logtime
        function startLogTime() {
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
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 201) {
                        Swal.fire({
                            title: 'IS STARTING.',
                            text: 'Logtime of this case is starting.',
                            icon: 'info',
                            showConfirmButton: true,
                            focusConfirm: true,
                        });
                    } else if (response.status == 200) {
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
        function endLogTime() {
            var token = $.cookie('token');
            var caseData = $.cookie('caseData');
            var formData = {
                project_case_id: caseData,
                detail: $("#detail").val()
            };

            $.ajax({
                type: 'POST',
                url: 'api/project/member/case/logtime/timeEnd',
>>>>>>> Stashed changes
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    console.log(response);
<<<<<<< Updated upstream
                    $('.description').append('<h5 class="detail">' + response.data.detail + "</h5>");
                    $('.endCaseDate').append('<h5 class="endCase">' + response.data.end_case_time + "</h5>");
=======
                    Swal.fire({
                        title: 'SUCCESSFULLY',
                        text: 'Logtime of this case is ending.',
                        icon: 'success',
                        showConfirmButton: true,
                        focusConfirm: true,
                    });
                },
                error: function() {
                    Swal.fire({
                        title: "IS NOT STARTING!",
                        text: 'logtime is not starting.',
                        icon: 'error',
                        showConfirmButton: true,
                        focusConfirm: true,
                    });
>>>>>>> Stashed changes
                }
            });
        }

<<<<<<< Updated upstream
=======
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
            }).then(function(confirm) {
                $.ajax({
                    type: 'POST',
                    url: 'api/project/member/case/update',
                    dataType: 'json',
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer ' + token,
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

>>>>>>> Stashed changes
    </script>
@endsection

</body>

</html>
