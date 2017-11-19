<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
@yield('meta')
    <title>{{ config('company.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">
    <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom/script.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@yield('resources')
</head>
<body data-spy="scroll" data-offset="59" data-target="#navbar-menu">
@yield('content')
@yield('modals')
</body>
</html>
