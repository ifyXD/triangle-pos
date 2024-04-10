@php
    $colorPalette = auth()->user()->themecustom->color_palette ?? 'darkblue';
    $paletteArray = explode(',', $colorPalette);
    $firstValue = trim($paletteArray[2] ?? null);
    $secondValue = trim($paletteArray[1] ?? null);
    $thirdValue = trim($paletteArray[0] ?? null);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta content="Fahim Anzam Dip" name="author">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/merged-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu-styling.css') }}">
    @include('includes.main-css')


    <style>
        .btn-secondary {
            background-color: {{ $secondValue }} !important;
        }
        .c-main {
            background-color: {{ $secondValue }} !important;
        }

        .btn-primary {
            background-color: {{ $thirdValue }} !important;
        }

        .c-sidebar.c-sidebar-minimized .c-sidebar-nav-item,
        .bg-primary {
            background-color: {{ $firstValue }} !important;
        }

        .page-item.active .page-link {
            background-color: {{ $firstValue }} !important;
            border-color: {{ $firstValue }} !important;

        }


        .c-sidebar.c-sidebar-minimized .c-sidebar-nav>.c-sidebar-nav-dropdown:hover,
        .c-sidebar.c-sidebar-minimized .c-sidebar-nav-item:hover>.c-sidebar-nav-dropdown-toggle,
        .c-sidebar.c-sidebar-minimized .c-sidebar-nav-item:hover>.c-sidebar-nav-link,
        .c-sidebar .c-sidebar-nav-dropdown-toggle:hover,
        .c-sidebar .c-sidebar-nav-link:hover {
            background: {{ $thirdValue }};
            color: #fff
        }

        .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle,
        .c-sidebar .c-sidebar-nav-link.c-active {
            background: {{ $thirdValue }};
            color: #fff
        }

        a {
            color: {{ $firstValue }};
            text-decoration: none !important;
        }

        a:hover {
            color: {{ $thirdValue }};
        }



    </style>
</head>

<body class="c-app">
    @include('layouts.sidebar')

    <div class="c-wrapper">
        <header class="c-header c-header-light c-header-fixed">
            @include('layouts.header')
            <div class="c-subheader justify-content-between px-3">
                @yield('breadcrumb')
            </div>
        </header>

        <div class="c-body">
            <main class="c-main">
                @yield('content')
            </main>
        </div>

        @include('layouts.footer')
    </div>

    @include('includes.main-js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>

</html>
