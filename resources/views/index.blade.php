@extends('layouts.master')

@section('topbar')
    @include('layouts.topbar')
@endsection

@section('content')
<div class="col-lg-12 px-0">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Cases</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <thead id="caseShow">
                        {{-- case Show aria --}}
                    </thead>
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

<div class="col-lg-12 px-0">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Projects</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Create Date</th>
                            <th>Code</th>
                        </tr>
                    </thead>
                    {{-- Project data form --}}
                    <thead id="projectShow">
                        {{-- project Show aria --}}
                    </thead>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul id="paginationProject" class="pagination justify-content-end">
                    {{-- paginate project aria --}}
                </ul>
            </nav>
        </div>
        
        {{-- <div class="text-align-center">
            <br>
            {!! $qr !!}
        </div> --}}
        
    </div>
</div>

    <script>
        // pagination เรียกตาม page
        function paginate(page) {
            var token = $.cookie('token');
            $.ajax({
                type: 'GET',
                url: 'api/project/member/case/paginateCaseByTokenWithViewMake?page='+page,
                dataType: 'json',
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

        function paginateProject(page) {
            var token = $.cookie('token');
            $.ajax({
                type: 'GET',
                url: 'api/project/paginateByTokenWithViewMake?page='+page,
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data){
                    $('#projectShow').empty();
                    $('#paginationProject').empty();
                    var countPage = data.data[0].project.last_page;
                    var currentPage = data.data[0].project.current_page;
                    $('#projectShow').html(data.html);
                    // ทำ pagination ของ Project
                    if(currentPage == 1){
                        $('#paginationProject').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                    }else {
                        var page = currentPage-1;
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginateProject('+page+');">Previous</a></li>');
                    }
                    if(currentPage == countPage){
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginateProject('+1+');">'+1+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationProject').append('<li class="page-item active"><a class="page-link" onclick="return paginateProject('+countPage+');">'+countPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                    }else{
                        var next = currentPage+1;
                        $('#paginationProject').append('<li class="page-item  active"><a class="page-link" onclick="return paginateProject('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginateProject('+countPage+');">'+countPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginateProject('+next+');">Next</a></li>');
                    }
                }
            });
        }

        $(document).ready(function() {
            var token = $.cookie('token');
            var username = $.cookie('username');
            var role = $.cookie('role');
            if(token == null){
                $.removeCookie('token');
                $.removeCookie('username');
                $.removeCookie('role');
                window.location = '/login';
            }else {
                if(role != 'USER'){
                    $.removeCookie('token');
                    $.removeCookie('username');
                    $.removeCookie('role');
                    window.location = '/login';
                }
            }

            $.ajax({
                type: 'GET',
                url: 'api/project/member/case/paginateCaseByTokenWithViewMake',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data) {
                    var countPage = data.data.last_page;
                    var currentPage = data.data.current_page;
                    $('#caseShow').html(data.html);
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
            // Ajax ยิงเพื่อขอข้อมูลของ Project และ map ข้อมูลไปแสดง
            $.ajax({
                type: 'GET',
                url: 'api/project/paginateByTokenWithViewMake',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data) {
                    var countPage = data.data[0].project.last_page;
                    var currentPage = data.data[0].project.current_page;
                    $('#projectShow').html(data.html);
                    // ทำ pagination ของ Project
                    if(countPage == 1){
                        $('#paginationProject').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                        $('#paginationProject').append('<li class="page-item active"><a class="page-link">1</a></li>');
                        $('#paginationProject').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                    }else {
                        if(currentPage == 1){
                            $('#paginationProject').append('<li class="page-item disabled"><a class="page-link">Previous</a></li>');
                        }else {
                            var page = currentPage-1;
                            $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginateProject('+page+');">Previous</a></li>');
                        }
                        $('#paginationProject').append('<li class="page-item  active"><a class="page-link" onclick="return paginateProject('+currentPage+');">'+currentPage+'</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link">...</a></li>');
                        $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginateProject('+countPage+');">'+countPage+'</a></li>');
                        if(currentPage == countPage){
                            $('#paginationProject').append('<li class="page-item disabled"><a class="page-link" href="">Next</a></li>');
                        }else{
                            var next = currentPage+1;
                            $('#paginationProject').append('<li class="page-item"><a class="page-link" onclick="return paginateProject('+next+');">Next</a></li>');
                        }
                    }
                }
            });
        });
    </script>
@endsection
</body>
</html>
