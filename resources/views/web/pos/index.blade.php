@extends('layouts.homepage')
@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="display-1">Point of Sale!</h1>
                <h1 class="display-3">Discover the Power of Our POS</h1>
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
             style="background-image: url('{{ asset('images/homepage/01.svg')}}');"></div>

        <div class="container">
            <div class="feature-content feature-content-destroyer">
                <div class="content content-change">
                    <img class="image-pachuychuy"
                         src="{{ asset('images/landingpage/tae.png') }}"
                         alt="pos-image">
                </div>
            </div>
        </div>
    </section>

    <section class="bg-200">
        <div class="container">
            <div class="feature-text-content">
                <div style="text-align: justify;">
                    <p><strong>Imagine a vast collection of business apps at your disposal.</strong><br>
                      
                    <p>
                        <br>
                        In the context of the public market in Valencia, implementing a point of sale (POS) system would revolutionize operations. It would streamline transactions, making them faster and more accurate. Inventory management would become more efficient, reducing the risk of overstocking or stockouts. Sales data could be analyzed to understand customer preferences and trends, enabling vendors to make informed decisions about their offerings. The system could also facilitate loyalty programs and personalized customer experiences, enhancing customer satisfaction and retention. Overall, implementing a POS system in the public market in Valencia would modernize operations, improve efficiency, and ultimately drive business growth..<br>
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
