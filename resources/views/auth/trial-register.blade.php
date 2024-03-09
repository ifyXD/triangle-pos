<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Public Market</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@100..800&family=Bakbak+One&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet">
</head>

<body>


    <header class="bg-200">
        <nav>
            <div class="logo">
                <h1><a href="{{ route('login') }}">PUBMARK</a></h1>
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
                    <a href="{{ route('login') }}">Login</a>
                </div>
                <div class="start-free">
                    <a href="{{ url('trial') }}">Try if free</a>
                </div>
            </div>
        </nav>
    </header>


    <main>
        <section class="hero-section " style="background-color: #714b67">
            <div class="container">
                <div class="hero-content">
                    <h6 class="headline-1 text-light ">
                        Choose your apps
                    </h6>
                    <p class="headline-2 text-light ">
                        Free instant access, no credit card required.
                    </p>
                </div>
            </div>
        </section>

        <section>
            <div class="  mt-5">
                <div class="feature-text-content">

                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Default checkbox
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Default checkbox
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Default checkbox
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Default checkbox
                                </label>
                            </div>
                        </div>
                         

                    </div>





                </div>

            </div>
        </section>
    </main>

    <footer>
        <section>
            <div class="container">
                <div class="logo">
                    <h1>RM</h1>
                </div>
                <div class="footer-links"></div>


            </div>
        </section>

        <div class="copyright">
            <div class="copyright-container">
                <p>Website made with love</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
