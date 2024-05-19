{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<div class="container">
    <div class="card">
        <div class="card-body justify-center">
            <h4 class="card-title">Verify Your Email Address</h4>
            @if (session('resent'))
                <p class="alert alert-success" role="alert">A fresh verification link has been sent to your email address</p>
            @endif
            <p class="card-text">Before proceeding, please check your email for a verification link. If you did not receive the email</p>
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit">Resend Verification Email</button>
            </form>
        </div>
    </div>
</div>
<style>
    {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 2rem;
}

.card {
    width: 40rem;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    padding: 2rem;

}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 50px;
    font-weight: bold;
    margin-bottom: 15px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.card-text {
    font-size: 1.5rem;
    margin-bottom: 15px;
}

button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    justify-content: center;
}

button:hover {
    background-color: #0056b3;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
{{-- @endsection --}}
