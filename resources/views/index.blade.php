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
                        
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 px-0">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Project</h3>
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

                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
            var token = $.cookie('token');
            if(token == null){
                window.location = 'login';
            }
            // Ajax ยิงเพื่อขอข้อมูลของ Case และ map ข้อมูลไปแสดง
            $.ajax({
                type: 'GET',
                url: 'api/project/member/case/getCaseByToken',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data){
                    var array = data.data;
                    console.log();
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
                        $('#caseShow').append("<th>"+element.name+"</th>");
                        $('#caseShow').append("<th>"+element.detail+"</th>");
                        $('#caseShow').append('<th style="color: '+color+' ">'+element.status+"</th>");
                        $('#caseShow').append("<th>"+date+"</th>");
                        $('#caseShow').append("</tr>");
                    });
                },
            });
            // Ajax ยิงเพื่อขอข้อมูลของ Project และ map ข้อมูลไปแสดง
            $.ajax({
                type: 'GET',
                url: 'api/project/getByToken',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer '+token,
                },
                success: function(data){
                    var array = data.data;
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
                        $('#projectShow').append("<th>"+element.name+"</th>");
                        $('#projectShow').append("<th>"+description+"</th>");
                        $('#projectShow').append("<th>"+dateTime+"</th>");
                        $('#projectShow').append("<th>"+element.project_code+"</th>");
                        $('#projectShow').append("</tr>");
                    });
                }
            });
        });
    </script>
@endsection
</body>
</html>
