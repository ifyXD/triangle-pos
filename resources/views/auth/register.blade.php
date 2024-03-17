{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">--}}

{{--    <title>Register | {{ config('app.name') }}</title>--}}

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
{{--            <div class="card mx-4">--}}
{{--                <div class="card-body p-4">--}}
{{--                    <form method="post" action="{{ url('/register') }}">--}}
{{--                        @csrf--}}
{{--                        <h1>Register</h1>--}}
{{--                        <p class="text-muted">Create your account</p>--}}
{{--                        <div class="input-group mb-3">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span class="input-group-text">--}}
{{--                                    <i class="bi bi-person"></i>--}}
{{--                              </span>--}}
{{--                            </div>--}}
{{--                            <input type="text" class="form-control @error('name') is-invalid @enderror"--}}
{{--                                   name="name" value="{{ old('name') }}"--}}
{{--                                   placeholder="Full Name">--}}
{{--                            @error('name')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="input-group mb-3">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span class="input-group-text">--}}
{{--                                    <i class="bi bi-envelope"></i>--}}
{{--                                </span>--}}
{{--                            </div>--}}
{{--                            <input type="email" class="form-control @error('email') is-invalid @enderror"--}}
{{--                                   name="email" value="{{ old('email') }}" placeholder="Email">--}}
{{--                            @error('email')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="input-group mb-3">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span class="input-group-text">--}}
{{--                                    <i class="bi bi-lock"></i>--}}
{{--                              </span>--}}
{{--                            </div>--}}
{{--                            <input type="password" class="form-control @error('password') is-invalid @enderror"--}}
{{--                                   name="password" placeholder="Password">--}}
{{--                            @error('password')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="input-group mb-4">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span class="input-group-text">--}}
{{--                                  <i class="bi bi-lock"></i>--}}
{{--                              </span>--}}
{{--                            </div>--}}
{{--                            <input type="password" name="password_confirmation" class="form-control"--}}
{{--                                   placeholder="Confirm password">--}}
{{--                        </div>--}}
{{--                        <button type="submit" class="btn btn-primary btn-block btn-flat mb-3">Register</button>--}}
{{--                        <a href="{{ route('login') }}" class="text-center">I already have a membership.</a>--}}
{{--                    </form>--}}
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
                    <p>Create your account</p>
                </div>
                <form class="login-form" action="{{ url('/register') }}" method="post">
                    @csrf
                    <div class="form-label">
                        <label for="text">Name</label>
                        <input type="text" name="name" id="text" required placeholder="Full Name"
                               class="@error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-label">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required placeholder="Email"
                               class="@error('email') is-invalid @enderror" value="{{ old('email') }}">
                    </div>
                    <div class="form-label">
                        <label for="pwd">Password</label>
                        <input type="password" name="password" id="pwd" required placeholder="Password"
                               class="@error('password') is-invalid @enderror">
                    </div>
                    <div class="form-label">
                        <label for="pwd">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="pwd" required placeholder="Confirm Password">
                    </div>
                    <div class="cta-container">
                        <button type="submit">SIGN UP</button>
                        <div class="login-link register-link">
                            <span class="have-account">
                                <a href="{{ route('login') }}">I already have an account</a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="{{ mix('js/app.js') }}" defer></script>
@endsection
