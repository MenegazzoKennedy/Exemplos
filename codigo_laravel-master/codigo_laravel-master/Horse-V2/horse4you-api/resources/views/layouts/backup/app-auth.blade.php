<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Horse4U') }}</title>

    <link rel="icon" type="image/png')}}" sizes="16x16" href="{{ asset('img/favicon_web.png')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('bower_components/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('bower_components/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon_web.png') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        
        .login-page, .register-page {
            background-color: #343A40;
            background-image: url('../img/bg_horse-login-copia.jpg');
            background-position: bottom center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .login-logo a, .register-logo a {
            color: #000000;
        }
        .login-logo b, .register-logo b {
            font-weight: 800;
        }

    </style>
</head>
<body class="login-page">
    @yield('content')
    

    <!-- jQuery -->
    <script src="{{ asset('bower_components/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @hasSection('javascript')
        @yield('javascript')
    @endif
</body>
</html>
