<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIGN-UP</title>
    <link rel="stylesheet" href="{{ asset('assets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body id="app">
    <div class="row">
        <br><br>
    </div>
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>

                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Username"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="password" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-pin-account"></i></label>
                                <input type="text" name="firstname" id="firstname" placeholder="First Name"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-account-o"></i></label>
                                <input type="text" name="lastname" id="lastname" placeholder="Last Name"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>

                    </div>
                    <div class="signup-image">
                        <figure><img src="{{ asset('assets/images/signup-image.jpg') }}" alt="sing up image"></figure>
                        <a href="{{ url('/login') }}" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function(){
            $('#signup').click(function(){
                var username = $('#username').val();
                var password= $('#password').val();
                var email = $('#email').val();
                var firstname = $('#firstname').val();
                var lastname = $('#lastname').val();
                Swal.fire({
                    title: 'Are you sure to register?',
                    text: 'Re-check your data before accept.',
                    icon: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true,
                    focusConfirm: true,
                    cancelButtonColor: '#f5365c'
                }).then(function (confirm) {
                    var formData = {
                        username: username,
                        password: password,
                        email: email,
                        firstname: firstname,
                        lastname: lastname
                    }
                    $.ajax({
                        type: 'POST',
                        url: 'api/register',
                        data: formData,
                        dataType: 'json',
                        success: function (data) {
                            if(data.status == 200){
                                Swal.fire({
                                title: 'Congratulations',
                                text: 'Back to sign-in for use application.',
                                icon: 'success',
                                showConfirmButton: true,
                                focusConfirm: true,
                                }).then(function(confirm) {
                                    if (confirm) {
                                    location.reload();
                                    }
                                });
                            }
                        },
                        error: function (error) {
                            Swal.fire({
                                title: 'Registration fail!',
                                text: 'Plese sign-up again.',
                                icon: 'error',
                                showConfirmButton: true,
                                focusConfirm: true,
                                }).then(function(confirm) {
                                    if (confirm) {
                                    location.reload();
                                    }
                                });
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
