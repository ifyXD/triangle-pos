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
                        <label for="text">First Name</label>
                        <input type="text" name="first_name" id="text" required placeholder="First Name"
                               class="@error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-label">
                        <label for="text">Last Name</label>
                        <input type="text" name="last_name" id="text" required placeholder="Last Name"
                               class="@error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
                        @error('last_name')
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
