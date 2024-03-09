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
            <h1><a href="/">PUBMARK</a></h1>
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
                <a href="{{route('register')}}">Try if free</a>
            </div>
        </div>
    </nav>
</header>
<main>

@yield('content')

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
