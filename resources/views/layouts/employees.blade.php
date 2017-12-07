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
                    <li><a href="{{ route('employees.get.index') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                    <li>
                        <a href="#"><i class="fa fa-shopping-bag fa-fw"></i> Products Catalogue<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{{ route('employees.get.products') }}"><span class="fa fa-th-list fa-fw"></span> View All Products</a></li>
                            <li><a href="{{ route('employees.get.products_add') }}"><span class="fa fa-plus fa-fw"></span> Add Product</a></li>
                        </ul>
                    </li>
                    @if(Auth::user()->user_info->position === 'Administrator' || Auth::user()->user_info->position === 'Auditor')
                        <li>
                            <a href="#"><i class="fa fa-folder fa-fw"></i> Contract Management <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ route('employees.get.contracts') }}"><span class="fa fa-th-list fa-fw"></span> Enterprise Contract Control</a></li>
                                <li><a href="{{ route('employees.get.contracts_add') }}"><span class="fa fa-plus fa-fw"></span> Contract Creation</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->user_info->position === 'Administrator' || Auth::user()->user_info->position === 'Employee - Sales Department')
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Customer Data or Accounts <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ route('employees.get.clients_view') }}"><span class="fa fa-th-list fa-fw"></span> View All Clients</a></li>
                                <li><a href="{{ route('employees.get.company_clients_register') }}"><span class="fa fa-plus fa-fw"></span> Register Company Client</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->user_info->position === 'Administrator')
                        <li>
                            <a href="#"><i class="fa fa-suitcase fa-fw"></i> Employees <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ route('employees.get.employees_view') }}"><span class="fa fa-th-list fa-fw"></span> View All Employees</a></li>
                                <li><a href="{{ route('employees.get.employees_register') }}"><span class="fa fa-plus fa-fw"></span> Register Employee</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('maintenance.get.index') }}"><i class="fa fa-wrench fa-fw"></i> Maintenance</a></li>
                    @endif
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
