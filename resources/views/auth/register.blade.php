<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register | {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body class="c-app flex-row align-items-center">
    <div class="container">
        <form>
            <div class="row justify-content-center">
                @include('auth.permission-register')
                <div class="col-12 col-md-12 col-lg-6 registrationForm d-none">
                    <div class="card mx-4 ">
                        <div class="card-body p-4 ">
                            <h1>PM | Get Started</h1>
                            <p class="text-muted">Instant Access</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="name" id="nameinput"
                                    value="{{ old('name') }}" placeholder="Full Name">

                                <div class="invalid-feedback name-error"></div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                </div>
                                <input type="email" id="emailinput" class="form-control " name="email"
                                    value="{{ old('email') }}" placeholder="Email">
                                <div class="invalid-feedback email-error"></div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="bi bi-shop"></i>
                                    </span>
                                </div>
                                <input type="text" id="storenameinput"
                                    class="form-control" name="storename"
                                    value="{{ old('storename') }}" placeholder="Store Name">
                                
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                </div>
                                <input type="password" id="passwordinput"
                                    class="form-control" name="password"
                                    placeholder="Password">
                                    <div class="invalid-feedback password-error"> </div>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" placeholder="Confirm password">
                            </div>


                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <button type="button"
                                        class="backtoPermission btn btn-block btn-flat mb-3 btn-outline-success text-dark"><i
                                            class="fa fa-chevron-left mr8"></i> Change Permissions</button>
                                </div>
                                <div class="col-12 col-md-6">
                                    <button type="button" class="btn btn-primary btn-block btn-flat mb-3"
                                        id="registerBtn">Register</button>
                                </div>
                            </div>
                            <a href="{{ route('login') }}" class="text-center">I already have a membership.</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.permissionBtn').click(function() {

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('.permissionForm').addClass('d-none');
                $('.registrationForm').removeClass('d-none');

                
            });
            $('.backtoPermission').click(function() {
                $('.permissionForm').removeClass('d-none');
                $('.registrationForm').addClass('d-none');
            });


            $('#registerBtn').click(function() {
                // Get input values
                var name = $('#nameinput').val();
                var email = $('#emailinput').val();
                var password = $('#passwordinput').val();
                var password_confirmation = $('#password_confirmation').val();
                var storename = $('#storenameinput').val();

                // Check if password and password_confirmation password match
                if (password !== password_confirmation) {
                    alert("Passwords do not match!");
                    return; // Prevent further execution
                }

                // Fetch the CSRF token from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                // Perform AJAX POST request with CSRF token included in headers
                $.ajax({
                    method: 'post',
                    url: '/register',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'name': name,
                        'email': email,
                        'password': password,
                        'password_confirmation': password_confirmation,
                        // 'storename': storename,
                    },
                    success: function(data) {

                        console.log(data);
                    },
                    error: function(xhr) {

                        console.log(xhr.responseJSON.message);
                        var errors = xhr.responseJSON.errors;
                        // Display errors next to corresponding input fields
                        $.each(errors, function(key, value) {
                            $('#' + key + 'input').addClass('is-invalid');
                            $('.' + key + '-error').text(value[0]);
                        });
                    }



                });

            });

        });
    </script>

    <!-- CoreUI -->
    <script src="{{ mix('js/app.js') }}" defer></script>

</body>

</html>
