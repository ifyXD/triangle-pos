@extends('layouts.homepage')
@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="headline-1">
                    {{ ucfirst(request()->segment(1)) }}
                </h1>

            </div>
        </div>
    </section>
@endsection
