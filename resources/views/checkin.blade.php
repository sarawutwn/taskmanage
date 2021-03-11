<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIGN-IN</title>
    <link rel="stylesheet" href="{{ asset('assets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body style="background-color: rgb(116,185,255);">
        <div class="row">
            <br><br>
        </div>
        
            <div class="container">
                <div class="signin-content">
                    <div class="signin-form">
                        <h2 class="form-title">Check-In</h2>
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Username or Email"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" onclick="submit()" id="signin" class="form-submit" value="SUBMIT"/>
                            </div>
                    </div>
                    <div class="signup-image">
                        <figure><img width="250" height="250" src="{{ asset('assets/images/chat.png') }}"></figure>
                    </div>
                </div>
            </div>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    
    <script>
        function submit(){
            var formData = {
                username: $("#username").val(),
                password: $("#password").val(),
                code: document.URL.split('=')[1]
            };
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: 'api/submitCheck',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                            title: 'SUCCESSFULLY',
                            text: 'Your already to working.',
                            icon: 'success',
                            showConfirmButton: true,
                            focusConfirm: true,
                        });
                },
                error: function(res){
                    var errorMessage;
                    var data = res.responseJSON.errors;
                    console.log(res.responseJSON);
                    if(res.responseJSON.status == 400){
                        if(res.responseJSON.message == 'Validator Error'){
                            if(data['username'] != null){
                                errorMessage = data['username'];
                            }else if(data['password'] != null){
                                errorMessage = data['password'];
                            }else {
                                errorMessage = "Someting went wrong.";
                            }
                        }else {
                            errorMessage = res.responseJSON.errors;
                        }
                    }else {
                        errorMessage = "QRcode is not support for you id.";
                    }
                    

                    Swal.fire({
                        title: "FAIL!",
                        text: errorMessage,
                        icon: 'error',
                        showConfirmButton: true,
                        focusConfirm: true,
                    });
                }
            });
        }
    </script>
</body>
</html>
