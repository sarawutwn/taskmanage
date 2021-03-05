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
                            <th>Create</th>
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
                url: 'api/project/member/case/paginateCaseByToken?page='+page,
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(response){
                    var array = response.data.data;
                    var countPage = response.data.last_page;
                    var currentPage = response.data.current_page;
                    $('#caseShow').empty();
                    $('#paginationCase').empty();
                    array.forEach(element => {
                        var color;

                        // ทำสีให้ status
                        if(element.status == "successfully"){
                            color = "#1cc88a;";
                        }else if(element.status == "new"){
                            color = "#4e73df;";
                        }else {
                            color = "#f6c23e;";
                        }

                        // จัดการ format วันที่
                        var updateAt = element.updated_at;
                        var date = new Date(updateAt);
                        var date = date.getDay()+"/"+date.getMonth()+"/"+date.getFullYear()+"  "+date.getHours()+":"+date.getMinutes();

                        // จัดวาง element
                        $('#caseShow').append("<tr>");
                        $('#caseShow').append('<th>'+element.name+"</th>");
                        $('#caseShow').append('<th>'+element.detail+'</th>');
                        $('#caseShow').append('<th style="color: '+color+' ">'+element.status+'</th>');
                        $('#caseShow').append('<th>'+date+'</th>');
                        $('#caseShow').append("</tr>");
                    });
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
                url: 'api/project/paginateByToken?page='+page,
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data){
                    $('#projectShow').empty();
                    $('#paginationProject').empty();
                    var array = data.data.data;
                    var countPage = data.data.last_page;
                    var currentPage = data.data.current_page;
                    var description;
                    array.forEach(element => {
                        if(element.description == null){
                            description = "Not have description.";
                        }else{
                            description = element.description;
                        }
                        var createdAt = element.created_at;
                        var date = new Date(createdAt);
                        var dateTime = date.getDay()+"/"+date.getMonth()+"/"+date.getFullYear()+"  "+date.getHours()+":"+date.getMinutes();
                        $('#projectShow').append("<tr>");
                        $('#projectShow').append('<th><a href="/project='+element.id+'&name='+username+'" style="color: blue;">'+element.name+"</a></th>");
                        $('#projectShow').append("<th>"+description+"</th>");
                        $('#projectShow').append("<th>"+dateTime+"</th>");
                        $('#projectShow').append("<th>"+element.project_code+"</th>");
                        $('#projectShow').append("</tr>");
                    });

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
            if(token == null){
                window.location = 'login';
            }
            // Ajax ยิงเพื่อขอข้อมูลของ Case และ map ข้อมูลไปแสดง
            $.ajax({
                type: 'GET',
                url: 'api/project/member/case/paginateCaseByToken',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data){
                    var array = data.data.data;
                    var countPage = data.data.last_page;
                    var currentPage = data.data.current_page;
                    console.log(array);
                    // console.log(array);
                    array.forEach(element => {
                        var color;

                        // ทำสีให้ status
                        if(element.status == "successfully"){
                            color = "#1cc88a;";
                        }else if(element.status == "new"){
                            color = "#4e73df;";
                        }else {
                            color = "#f6c23e;";
                        }

                        // จัดการ format วันที่
                        var updateAt = element.updated_at;
                        var date = new Date(updateAt);
                        var date = date.getDay()+"/"+date.getMonth()+"/"+date.getFullYear()+"  "+date.getHours()+":"+date.getMinutes();

                        // จัดวาง element
                        $('#caseShow').append("<tr>");
                        $('#caseShow').append('<th>'+element.name+"</th>");
                        $('#caseShow').append('<th>'+element.detail+'</th>');
                        $('#caseShow').append('<th style="color: '+color+' ">'+element.status+'</th>');
                        $('#caseShow').append('<th>'+date+'</th>');
                        $('#caseShow').append("</tr>");
                    });

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
                },
            });

            // Ajax ยิงเพื่อขอข้อมูลของ Project และ map ข้อมูลไปแสดง
            $.ajax({
                type: 'GET',
                url: 'api/project/paginateByToken',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data){
                    var array = data.data.data;
                    var countPage = data.data.last_page;
                    var currentPage = data.data.current_page;
                    var description;
                    array.forEach(element => {
                        if(element.description == null){
                            description = "Not have description.";
                        }else{
                            description = element.description;
                        }
                        var createdAt = element.created_at;
                        var date = new Date(createdAt);
                        var dateTime = date.getDay()+"/"+date.getMonth()+"/"+date.getFullYear()+"  "+date.getHours()+":"+date.getMinutes();
                        $('#projectShow').append("<tr>");
                        $('#projectShow').append('<th><a href="/project='+element.id+'&name='+username+'" style="color: blue;">'+element.name+"</a></th>");
                        $('#projectShow').append("<th>"+description+"</th>");
                        $('#projectShow').append("<th>"+dateTime+"</th>");
                        $('#projectShow').append("<th>"+element.project_code+"</th>");
                        $('#projectShow').append("</tr>");
                    });

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
