<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sinau Print - {{ request()->is('login') ? 'Login' : 'Register' }}</title>
    <link href="{{ asset('landingpage/img/favicon/fav_icon.jpg') }}" rel="icon">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            background: url('{{ asset('landingpage/img/login_register_bg.png') }}') no-repeat center center fixed;
            background-size: cover;
        }
        .login-left {
            color: white;
        }
        .login-left h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .login-left p {
            font-size: 1.2rem;
            font-weight: 300;
        }
        .overlay-bg {
            /* background: rgba(0, 0, 0, 0.6); */
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
