<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Public Market</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@100..800&family=Bakbak+One&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>


<header class="bg-200">
    <nav>
        <div class="logo">
            <h1><a href="{{route('login')}}">PUBMARK</a></h1>
        </div>

        <div class="menu">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>


        <div class="header-buttons">
            <div class="login">
                <a href="{{route('login')}}">Login</a>
            </div>
            <div class="start-free">
                <a href="{{url('trial')}}">Try if free</a>
            </div>
        </div>
    </nav>
</header>


<main>
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

        <div class="shape illustration_doodle" style="background-image: url('{{ asset('images/homepage/03.svg')}}');"></div>

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
</main>

<footer>
    <section>
        <div class="container">
            <div class="logo"><h1>RM</h1></div>
            <div class="footer-links"></div>


        </div>
    </section>

    <div class="copyright">
        <div class="copyright-container">
            <p>Website made with love</p>
        </div>
    </div>
</footer>


</body>
</html>
