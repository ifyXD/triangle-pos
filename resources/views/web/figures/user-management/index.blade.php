@extends('layouts.homepage')
@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="display-1">Empower Your Team</h1>
                <h1 class="display-3">Navigate User Management with Our Feature!</h1>
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
                    <h1 class="display-1"> {{ ucfirst(request()->segment(1)) }}</h1>
                </div>


            </div>
        </div>
    </section>

    <section class="bg-200">
        <div class="container">
            <div class="feature-text-content">
                <p><strong>Imagine a vast collection of business apps at your disposal.</strong><br>
                    Got something to improve? There is an app for that.<br>
                    No complexity, no cost, just a one-click install.</p>
                <p>Each app simplifies a process and empowers more people.<br>
                    Imagine the impact when everyone gets the right tool for the job, with perfect integration.</p>
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
@endsection
