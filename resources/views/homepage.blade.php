<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Login | {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body class="c-app flex-row align-items-center">
<div class="container">
{{--    <div class="row mb-3">--}}
{{--        <div class="col-12 d-flex justify-content-center">--}}
{{--            <img width="200" src="{{ asset('images/logo-dark.png') }}" alt="Logo">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-5">--}}
{{--            <div class="card p-4 border-0 shadow-sm">--}}
{{--                <div class="card-body">--}}
{{--                     <h1 class="text-center">This is fucking homepage well played bro</h1>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <p class="text-center mt-5 lead">--}}
{{--                Developed By--}}
{{--                <a href="https://www.facebook.com/JosephM.Tanquilan" class="font-weight-bold text-primary">Joseph</a>--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    </div>--}}





</div>

<!-- CoreUI -->
<script src="{{ mix('js/app.js') }}" defer></script>
{{--<script>--}}
{{--    let login = document.getElementById('login');--}}
{{--    let submit = document.getElementById('submit');--}}
{{--    let email = document.getElementById('email');--}}
{{--    let password = document.getElementById('password');--}}
{{--    let spinner = document.getElementById('spinner')--}}

{{--    login.addEventListener('submit', (e) => {--}}
{{--        submit.disabled = true;--}}
{{--        email.readonly = true;--}}
{{--        password.readonly = true;--}}

{{--        spinner.style.display = 'block';--}}

{{--        login.submit();--}}
{{--    });--}}

{{--    setTimeout(() => {--}}
{{--        submit.disabled = false;--}}
{{--        email.readonly = false;--}}
{{--        password.readonly = false;--}}

{{--        spinner.style.display = 'none';--}}
{{--    }, 3000);--}}
{{--</script>--}}

</body>
</html>
