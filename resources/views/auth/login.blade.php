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
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src=" {{ asset('assets/images/signin-image.jpg') }}" alt="sing up image"></figure>
                        <a href="{{ url('/register') }}" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>

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
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>

                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#" id="alert"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#" id="alert1"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#" id="alert2"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    {{-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // enter keyd
            $(document).bind('keypress', function(e) {
                if(e.keyCode==13){
                    $('#signIn').trigger('click');
                }
            });

            var token = $.cookie('token');
            if(token != null){
                window.location = 'index';
            }
            $('#signin').click(function(){
                var formData = {
                    username: $('#username').val(),
                    password: $('#password').val(),
                }
                $.ajax({
                    type: 'POST',
                    url: 'api/login',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        $.cookie('token', data.data.token);
                        $.cookie('username', data.data.username);
                        window.location = "index";
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Registration fail!',
                            text: 'Plese sign-up again.',
                            icon: 'error',
                            showConfirmButton: true,
                            closeOnConfirm: false,
                            focusConfirm: true,
                            });
                    },
                });
            });
            $('#alert').click(function() {
                Swal.fire({
                            title: 'Coming soon....',
                            text: 'CFunction "Sign-in with facebook" is not ready.',
                            icon: 'warning',
                            showConfirmButton: true,
                            closeOnConfirm: false,
                            focusConfirm: true,
                            });
            });
            $('#alert1').click(function() {
                Swal.fire({
                            title: 'Coming soon....',
                            text: 'Function "Sign-in with twitter" is not ready.',
                            icon: 'warning',
                            showConfirmButton: true,
                            closeOnConfirm: false,
                            focusConfirm: true,
                            });
            });
            $('#alert2').click(function() {
                Swal.fire({
                            title: 'Coming soon....',
                            text: 'Function "Sign-in with google" is not ready.',
                            icon: 'warning',
                            showConfirmButton: true,
                            closeOnConfirm: false,
                            focusConfirm: true,
                            });
            });
        });
    </script>
</body>
</html>
