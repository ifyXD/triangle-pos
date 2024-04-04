{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">--}}

{{--    <title>Send Reset Password Link | {{ config('app.name') }}</title>--}}

{{--    <!-- Favicon -->--}}
{{--    <link rel="icon" href="{{ asset('images/favicon.png') }}">--}}
{{--    <!-- CoreUI CSS -->--}}
{{--    <link rel="stylesheet" href="{{ mix('css/app.css') }}" crossorigin="anonymous">--}}
{{--    <!-- Bootstrap Icons -->--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">--}}
{{--</head>--}}
{{--<body class="c-app flex-row align-items-center">--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-6">--}}
{{--            <div class="card-group">--}}
{{--                <div class="card p-4">--}}
{{--                    <div class="card-body">--}}
{{--                        @if (session('status'))--}}
{{--                            <div class="alert alert-success">--}}
{{--                                {{ session('status') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <form method="post" action="{{ url('/password/email') }}">--}}
{{--                            @csrf--}}
{{--                            <h1>Reset Your Password</h1>--}}
{{--                            <p class="text-muted">Enter Email to reset password</p>--}}
{{--                            <div class="input-group mb-3">--}}
{{--                                <div class="input-group-prepend">--}}
{{--                                    <span class="input-group-text">--}}
{{--                                        <i class="bi bi-envelope"></i>--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                                <input type="email"--}}
{{--                                       class="form-control @error('email') is-invalid @enderror" name="email"--}}
{{--                                       value="{{ old('email') }}" placeholder="Email">--}}
{{--                                @error('email')--}}
{{--                                <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <div class="col-12">--}}
{{--                                    <button class="btn btn-block btn-primary" type="submit">--}}
{{--                                        <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<!-- CoreUI -->--}}
{{--<script src="{{ mix('js/app.js') }}" defer></script>--}}

{{--</body>--}}
{{--</html>--}}

@extends('layouts.homepage-no-footer')
@section('content')
    <section class="login login-section">
        <div class="container">
            <div class="card">
                <div class="form-header">
                    <h1>PUB MARKET</h1>
                    <p>Recover your account</p>
                </div>
                <form class="login-form" action="{{ url('/password/email') }}" method="post">
                    @csrf
                    <div class="form-label">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required placeholder="Email"
                               class="@error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="cta-container">
                        <button type="submit">RESET PASSWORD</button>
{{--                        <div class="login-link register-link">--}}
{{--                            <span class="have-account">--}}
{{--                                <a href="{{ route('login') }}">I already have an account</a>--}}
{{--                            </span>--}}
{{--                        </div>--}}
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="{{ mix('js/app.js') }}" defer></script>
@endsection
