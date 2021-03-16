@extends('admin.layouts.master')
@section('content')

    <div class="col-lg-12 px-0">    
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">All Project</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created-time</th>
                                <th>Project-code</th>
                            </tr>
                        </thead>
                        <thead id="projectShow">
                            {{-- case Show aria --}}
                        </thead>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul id="paginationProject" class="pagination justify-content-end">
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var token = $.cookie('token');
            var username = $.cookie('username');
            var role = $.cookie('role');
            console.log(role);
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
            
            $.ajax({
                type: 'GET',
                url: '/api/project/paginateProjectAll',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data) {
                    var countPage = data.data.last_page;
                    var currentPage = data.data.current_page;
                    $('#projectShow').html(data.html);
                    // ทำ pagination ของ case
                    if(currentPage == 1){
                        $('#paginationProject').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                    }else {
                        var page = currentPage-1;
                         $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginate('+page+');">Previous</a></li>');
                    }
                    if(currentPage == countPage){
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginate('+1+');">'+1+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationProject').append('<li class="page-item active"><a class="page-link" onclick="return paginate('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                    }else{
                        var next = currentPage+1;
                        $('#paginationProject').append('<li class="page-item active"><a class="page-link" onclick="return paginate('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginate('+countPage+');">'+countPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginate('+next+');">Next</a></li>');
                    }
                }
            });
        });

        function paginate(page) {
            var token = $.cookie('token');
            $.ajax({
                type: 'GET',
                url: '/api/project/paginateProjectAll?page='+page,
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response){
                    var countPage = response.data.last_page;
                    var currentPage = response.data.current_page;
                    $('#projectShow').empty();
                    $('#paginationProject').empty();
                    $('#projectShow').html(response.html);
                    // ทำ pagination ของ case
                    if(currentPage == 1){
                        $('#paginationProject').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                    }else {
                        var page = currentPage-1;
                         $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginate('+page+');">Previous</a></li>');
                    }
                    if(currentPage == countPage){
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginate('+1+');">'+1+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationProject').append('<li class="page-item active"><a class="page-link" onclick="return paginate('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                    }else{
                        var next = currentPage+1;
                        $('#paginationProject').append('<li class="page-item active"><a class="page-link" onclick="return paginate('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginate('+countPage+');">'+countPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginate('+next+');">Next</a></li>');
                    }
                }
            });
        }
    </script>
@endsection