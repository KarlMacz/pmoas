<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
@yield('meta')
    <title>{{ config('company.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">
    <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('js/custom/script.js') }}"></script>
@yield('resources')
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="" class="navbar-brand">
                        <img src="{{ asset('img/logo-success.png') }}" class="logo pull-left">
                        <span class="visible-xs-inline visible-sm-inline">{{ config('company.abbr') }}</span>
                        <span class="visible-md-inline visible-lg-inline">{{ config('company.name') }}</span>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>{{ Auth::user()->user_info->first_name . ' ' . Auth::user()->user_info->last_name }}</span> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('home.get.index') }}">Homepage</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ route('auth.get.logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="sidebar" style="margin-top: 0;">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li><a href="{{ route('clients.get.index') }}"><i class="fa fa-home fa-fw"></i> Home</a></li>
                    <li><a href="{{ route('clients.get.products') }}"><i class="fa fa-shopping-bag fa-fw"></i> Products Catalogue</a></li>
                    <li><a href="{{ route('cart.get.index') }}"><i class="fa fa-shopping-cart fa-fw"></i> Shopping Cart</a></li>
                    <li><a href="{{ route('clients.get.orders') }}"><i class="fa fa-cubes fa-fw"></i> Orders</a></li>
                    <li><a href="{{ route('clients.get.products_return') }}"><i class="fa fa-reply fa-fw"></i> Return Products</a></li>
                    <li><a href="{{ route('clients.get.contracts') }}"><i class="fa fa-list-alt fa-fw"></i> Contracts</a></li>
                    <li><a href="{{ route('clients.get.help') }}"><i class="fa fa-question fa-fw"></i> Help</a></li>
                </ul>
            </div>
        </div>
        <div id="page-wrapper">
        @yield('content')
        </div>
    </div>
@yield('modals')
    <div id="status-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">...</h4>
                </div>
                <div class="modal-body">...</div>
            </div>
        </div>
    </div>
    <div id="loading-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div style="margin-bottom: 10px;"><span class="fa fa-spinner fa-pulse fa-3x"></span></div>
                    <h4 class="no-margin">Please Wait...</h4>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
