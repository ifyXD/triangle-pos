<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--<title>{{ ucfirst(request()->segment(1)) }} | {{ config('app.name') }}</title>--}}
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@100..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-... (hash value)" crossorigin="anonymous">
</head>
<body>


<header>
    <nav>
        <div class="logo">
            <h1><a href="/">PM</a></h1>
        </div>

        <div class="menu">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>


        <div class="header-buttons">
            <div class="login">
                <a href="{{route('login')}}">Login</a>
            </div>
            <div class="start-free">
                <a href="{{route('register')}}">Sign up</a>
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
            <p>Each app simplifies a process and empowers more people.
                Imagine the impact when everyone gets the right tool for the job, with perfect integration.</p>
            <div class="social-links">
                <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </section>

    <div class="copyright">
        <div class="copyright-container">
            <p>Copyright &copy; 2024 Joseph Tanquilan</p>
        </div>
    </div>
</footer>
</body>
</html>
