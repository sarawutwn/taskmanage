@extends('support.layouts.master')

@section('content')
@extends('support.modal.read_case_edit_project')
@extends('support.modal.add_case')
@extends('support.modal.edit_project')
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

    <div class="col-lg-12 px-0">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col">
                        <h3 class="m-0 font-weight-bold text-primary">Cases</h3>
                    </div>
                    <div class="col-auto">
                            <button id="btn_add_case" type="submit" class="btn btn-success" data-toggle="modal" data-target="#add_case_modal" data-id="{{ $project->id }}">Add case</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created-time</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <thead id="caseShow">
                            {{-- case Show aria --}}
                        </thead>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul id="paginationCase" class="pagination justify-content-end">
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#datetimepicker1').datepicker("setDate", new Date());
            var token = $.cookie('token');
            var username = $.cookie('username');
            var role = $.cookie('role');
            if(token == null){
                $.removeCookie('token');
                $.removeCookie('username');
                $.removeCookie('role');
                window.location = '/login';
            }else {
                if(role != 'SUPPORT'){
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
                type: 'POST',
                url: '/api/project/member/case/paginateCaseEdit',
                dataType: 'json',
                data: formData,
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data) {
                    console.log(data);
                    var countPage = data.data.last_page;
                    var currentPage = data.data.current_page;
                    $('#caseShow').html(data.html);
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
        });

        function paginate(page) {
            var token = $.cookie('token');
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






        //function add case ทั้งหมด
        $('#add_case').click(function(e) {
        e.preventDefault();
        const token = $.cookie('token');
        const projectId = $('#btn_add_case').data('id');
        const username = $('#modal-input-case-member-project-id').val();
        const name = $('#modal-input-case-name').val();
        const detial = $('#modal-input-case-detial').val();
        const endcase = $('#modal-input-case-end').val();
        const formData = {
            project_id: projectId,
            project_member_id: username,
            name: name,
            detail: detial,
            end_case_time: endcase
        }
        console.log(endcase);
        $.ajax({
            type: "POST",
            url: "/api/project/member/case/add",
            data: formData,
            headers:{
                'Authorization': 'Bearer ' + token,
            },
            success: function (response) {
                Swal.fire({
                    title: 'Add case successfully.',
                    icon: 'success',
                    showConfirmButton: true,
                    focusConfirm: true,
                    }).then(function(confirm) {
                        if (confirm) {
                            window.location.reload();
                        }
                });
            },
            error: function () {
                Swal.fire({
                    title: 'Add case fail!',
                    text: 'Plese try again.',
                    icon: 'error',
                    showConfirmButton: true,
                    closeOnConfirm: false,
                    focusConfirm: true,
                }).then(function(confirm) {
                        if (confirm) {
                            window.location.reload();
                        }
                });
            }
        });
        $('#add_case_modal').modal('hide');
    });
    $('#modal-input-case-member-project-id').keyup(function(e) {
        const token = $.cookie('token');
        const searchText = $(this).val();
        if (searchText == '') {
            return
        }
        $.ajax({
            type: "GET",
            url: "/api/project/member/get/add" + searchText,
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            success: function(response) {
                let array = [];
                response.data.forEach(item => {
                    array.push(item.username)
                });
                autocomplete(document.getElementById(
                    "modal-input-case-member-project-id"), array);
            }
        });
    });
    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }
    // autocomplete(document.getElementById("myInput"), countries);
    </script>
@endsection
