@extends('layouts.homepage')
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-1">{{ ucfirst(request()->segment(1)) }}</h1>
            <div class="cta-container">
                <div class="start-now">
                    <a href="{{route('register')}}">Start now - It’s free</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-200">
    <div class="shape illustration_doodle"
         style="background-image: url('{{ asset('images/homepage/03.svg')}}');"></div>

    <div class="container">
        <div class="feature-content">
            <div class="content">
                {{-- <h1 class="display-1"> {{ ucfirst(request()->segment(1)) }}</h1> --}}
            </div>
        </div>
    </div>
</section>

<section class="bg-200">
    <div class="card-container mb-5">
        <div class="card-image-container">
            <img src="https://scontent.fcgm1-1.fna.fbcdn.net/v/t39.30808-6/438299046_2610478715794572_459715752760786860_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeFUdVPVYLsCL8X-gOYZxOHhX56uc_kYhCZfnq5z-RiEJu_TxigAo2edy9lzUenVkyXArwSMkdQeohYRVWuA20ze&_nc_ohc=rQ1-1IrAIvwQ7kNvgGJ1ZIp&_nc_ht=scontent.fcgm1-1.fna&oh=00_AYChndBVTD3ZX6yXNufQ4DQBd8iO-7Iz8FTYmHQfFEOZgw&oe=6649B46C" alt="Market Icon" class="card-image">
        </div>
        <div class="feature-text-content">
            <p><strong>Just Contact</strong><br>
                Joseph M. Tanquilan.<br>
                09264569593.</p>
            <div class="social-links">
                <a href="https://www.facebook.com/JosephM.Tanquilan" target="_blank"><i class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com/uncertainty0112/" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://github.com/ifyXD" target="_blank"><i class="bi bi-github"></i></a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="near-footer">
            <h1>Unleash your growth potential</h1>
            <div class="near-button-container">
                <div class="near-footer-button">
                    <a href="{{route('login')}}">Start now - It’s free</a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
   .card-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    text-align: left;
    margin: 0 auto;
    max-width: 800px;
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    padding: 20px;
    transition: box-shadow 0.3s ease, transform 0.3s ease; /* Add transition for smooth effect */
}

.card-container:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Darker shadow on hover */
    transform: scale(1.05); /* Slightly scale up the card */
}

.card-image-container {
    flex: 1;
}

.card-image {
    width: 100%;
    height: auto;
    max-width: 300px;
    border-radius: 8px;
}

.feature-text-content {
    flex: 2;
    padding: 20px;
}

.social-links {
    margin-top: 10px;
}

.social-links a {
    margin: 0 10px;
    font-size: 1.5rem;
    color: #495057;
    text-decoration: none;
    transition: color 0.3s ease; /* Add transition for smooth color change */
}

.social-links a:hover {
    color: #007bff;
}

</style>
@endsection
