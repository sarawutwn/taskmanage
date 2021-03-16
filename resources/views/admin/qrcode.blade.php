@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <br>
            <div class="col-7">
                <div class="col-md-9" style="background-color: rgba(255, 255, 255, 0.315); border-style: solid; padding: 20px; border-color: rgb(199, 199, 199); border-radius: 22px;">
                    <div class="panel-heading">
                        <h1 class="red-fade" style="text-align: center; color: black;"> QR-CODE </h1>
                        <h5 class="red-fade" style="text-align: center; color: black;">FOR 'WORK-IN' AND 'WORK-OUT' CHECK</h5>
                    </div>
                    <hr>
                    <div class="text-align-center" style="text-align: center;">
                        <br>
                        {!! $qr !!}
                    </div>
                    <br>
                    <br>
                </div>
            </div>
            <div class="col-5">
                <div class="col-md-12 offset-ml-5" style="background-color: white; padding: 20px; border-style: solid; border-color: rgb(199, 199, 199); border-radius: 22px;">
                    <h3 class="red-fade" style="text-align: center; color: black;">ATTENDANCE TODAY LIST</h3>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Date of time</th>
                                </tr>
                            </thead>
                            <thead id="checkinShow">

                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
     $(document).ready(function() {
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
            url: 'api/getCheckInToday',
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer '+token,
            },
            success: function(data){
                var array = data.data;
                var description;
               var number = 1;

                array.forEach(element => {
                    var count = number++;
                    $('#checkinShow').append("<tr>");
                    $('#checkinShow').append("<th>"+count+"</th>");
                    $('#checkinShow').append("<th>"+element.date+"</th>");
                    $('#checkinShow').append("</tr>");
                });
                // array.forEach(element => {
                //     if(element.description == null){
                //         description = "Not have description.";
                //     }else{
                //         description = element.description;
                //     }
                //     var createdAt = element.created_at;
                //     var date = new Date(createdAt);
                //         var dateTime = date.getDay()+"/"+date.getMonth()+"/"+date.getFullYear()+"  "+date.getHours()+":"+date.getMinutes();
                //     $('#projectShow').append("<tr>");
                //     $('#projectShow').append('<th><a href="/project='+element.id+'&name='+username+'" style="color: blue;">'+element.name+"</a></th>");
                //     $('#projectShow').append("<th>"+description+"</th>");
                //     $('#projectShow').append("<th>"+dateTime+"</th>");
                //     $('#projectShow').append("<th>"+element.project_code+"</th>");
                //     $('#projectShow').append("</tr>");
                // });
            }
        });
     });
    function refreshPage(){
        window.location.reload();
    } 
</script>

@endsection