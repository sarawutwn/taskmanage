<!DOCTYPE html>
<html lang="en">
<html><head>
    <meta charset="UTF-8">
    <title>Generate QR Code</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <!-- bootstrap -->
 <style>
    body, html {
        height: 100%;
        width: 100%;
        background-image: url("https://images.unsplash.com/photo-1579546929662-711aa81148cf?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1650&q=80");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .red-fade {
        text-align: center; 
        font-family: Arial;
        font-weight: 100; 
        background: -webkit-linear-gradient(#c72c5a, #513594);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .text-align-center{
        text-align: center;
    }
    #btn{
        text-align: center;
    }
    .btn-danger{
        background: -webkit-linear-gradient(#c72c5a, #913594);
        width: 300px;
        border-radius: 8px;
    }
</style>
<body> 
    <div class="container" id="panel">
        <br><br><br>
        <div class="row">
            <div class="col-md-6 offset-md-3" style="background-color: white; padding: 20px; box-shadow: 10px 10px 5px #888; border-radius: 22px;">
                <div class="panel-heading">
                    <h1 class="red-fade">SOFTSIONS Co.,Ltd</h1>
                    <h4 class="red-fade">สแกน QR-Code สำหรับเข้างานและออกงาน</h4>
                </div>
                <hr>
                <div class="text-align-center">
                    <br>
                    {!! $qr !!}
                </div>
                <br>
                <div class="text-align-center">
                    <button class="btn btn-danger" onClick="refreshPage()">Refresh Button</button>
                </div>
                <br>
            </div>
        </div>
    </div>
</body>

<script>
    function refreshPage(){
        window.location.reload();
    } 
</script>
</html>