<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>{{ ucfirst(request()->segment(1)) }} | {{ config('app.name') }}</title> --}}
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@100..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    {{-- <style>
        nav,
        .nav-height {
            position: relative;
        }

        .open {
            position: absolute !important;
            right: 15px;
        }

        .nav-height {
            height: 100px;
        }

        @media (max-width: 768px) {
            .header-buttons {
              position: absolute;
            }
        }

        #nav-magic2 {
            position: relative;
        }
    </style> --}}


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-... (hash value)" crossorigin="anonymous">
</head>

<body>


    <header>
        <nav>
            <div class="logo">
                <h1><a href="/">PM</a></h1>
            </div>

            <div class="menu" id="nav-magic1">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div id="nav-magic">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="header-buttons" id="nav-magic2">
                <div class="login">
                    <a href="{{ route('login') }}">Login</a>
                </div>
                <div class="start-free">
                    <a href="{{ route('register') }}">Sign up</a>
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
                <div class="logo">
                    <h1>PM</h1>
                </div>
                <p>Each app simplifies a process and empowers more people.
                    Imagine the impact when everyone gets the right tool for the job, with perfect integration.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/JosephM.Tanquilan"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/uncertainty0112/"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/josephtanquilan"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </section>

        <div class="copyright">
            <div class="copyright-container">
                <p>Copyright &copy; 2024 Joseph Tanquilan</p>
            </div>
        </div>
    </footer>


    <script>
        $(document).ready(function() {
            $('#nav-magic, #nav-magic1, #nav-magic2').click(function() {
                $(this).toggleClass('open');
                console.log("Clicked:", this.id);
                $('.menu').toggleClass('other-class');

            });

        });
    </script>
</body>

</html>
