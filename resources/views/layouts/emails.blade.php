<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ config('company.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <style>
        html,
        body {
            padding: 0;
            margin: 0;
        }

        body {
            background-color: #eee;
            color: #222;
            font-family: 'Segoe UI';
            font-size: 15px;
        }

        .container {
            padding: 100px 10%;
        }

        .card {
            background-color: white;
            box-shadow: 0 2px 2px rgba(34, 34, 34, 0.5);
            display: block;
            margin-bottom: 10px;
            width: 100%;
        }

        .card > .card-header {
            font-size: 2em;
            padding: 15px;
        }

        .card > .card-content {
            padding: 15px;
        }

        .card > .card-header + .card-content {
            padding-top: 0;
        }

        .card.card-primary {
            background-color: #2c3e50;
            color: white;
        }

        .card.card-success {
            background-color: #18bc9c;
            color: white;
        }

        .card.card-warning {
            background-color: #f39c12;
            color: white;
        }

        .card.card-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn {
            border: none;
            display: inline-block;
            padding: 10px 15px;
            min-width: 100px;
        }

        a.btn {
            text-decoration: none;
        }

        .btn-primary {
            color: #ffffff;
            background-color: #2c3e50;
            border-color: #2c3e50;
        }

        .btn-primary:focus,
        .btn-primary:hover {
            background-color: #1a242f;
            border-color: #161f29;
            color: #ffffff;
        }

        .btn-primary:active:hover {
            color: #ffffff;
            background-color: #0d1318;
            border-color: #000000;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
@yield('content')
</body>
</html>
