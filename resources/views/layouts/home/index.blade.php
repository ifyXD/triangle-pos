@extends('layouts.homepage')
@section('content')

        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="headline-1">
                        Streamline Your Business Operations Today!
                    </h1>
                    <h1 class="headline-2">
                        Discover the Power of Our POS
                    </h1>
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
                        <a href="{{ url('product') }}">
                            <figure>
                                <img class="img-thumbnail" src="{{ asset('images/homepage/product.png') }}"
                                     alt="Product Picture">
                                <figcaption>Product</figcaption>
                            </figure>
                        </a>

                        <a href="{{ url('stock') }}">
                            <figure>
                                <img class="img-thumbnail" src="{{ asset('images/homepage/product.png') }}"
                                     alt="Product Picture">
                                <figcaption>Stock Adjustments</figcaption>
                            </figure>
                        </a>
                        <a href="{{ url('purchase') }}">
                            <figure>
                                <img class="img-thumbnail" src="{{ asset('images/homepage/product.png') }}"
                                     alt="Product Picture">
                                <figcaption>Purchases</figcaption>
                            </figure>
                        </a>
                        <a href="{{ url('sale') }}">
                            <figure>
                                <img class="img-thumbnail" src="{{ asset('images/homepage/product.png') }}"
                                     alt="Product Picture">
                                <figcaption>Sale</figcaption>
                            </figure>
                        </a>
                        <a href="{{ url('expense') }}">
                            <figure>
                                <img class="img-thumbnail" src="{{ asset('images/homepage/product.png') }}"
                                     alt="Product Picture">
                                <figcaption>Expenses</figcaption>
                            </figure>
                        </a>
                        <a href="{{ url('parties') }}">
                            <figure>
                                <img class="img-thumbnail" src="{{ asset('images/homepage/product.png') }}"
                                     alt="Product Picture">
                                <figcaption>Parties</figcaption>
                            </figure>
                        </a>
                        <a href="{{ url('reports') }}">
                            <figure>
                                <img class="img-thumbnail" src="{{ asset('images/homepage/product.png') }}"
                                     alt="Product Picture">
                                <figcaption>Reports</figcaption>
                            </figure>
                        </a>
                        <a href="{{ url('user') }}">
                            <figure>
                                <img class="img-thumbnail" src="{{ asset('images/homepage/product.png') }}"
                                     alt="Product Picture">
                                <figcaption>User Management</figcaption>
                            </figure>
                        </a>
                    </div>


                </div>
            </div>
        </section>


        <section style="background: #F3F4F6;">
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
            <div class="container-near">
                <div class="near-footer">
                    <h1>Unleash your growth potential</h1>
                </div>

                <div class="near-button-container">
                    <div class="near-footer-button">
                        <a href="{{route('login')}}">Start now - It’s free</a>
                    </div>
                </div>
            </div>
        </section>

@endsection
