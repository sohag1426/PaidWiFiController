<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title')</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('laraview.layouts.vendorCss')
    @include('laraview.css.commonCss')
    @include('laraview.css.appCss')
    @yield('pageCss')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Site wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <form class="form-inline">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" id="global-customer-search" type="search"
                        placeholder="Search" aria-label="Search" onchange="globalSerachCustomer(this.value)">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @if (Auth::user())

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">
                        Account Balance : {{ Auth::user()->account_balance }} {{ config('consumer.currency') }}
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endif
            </ul>

        </nav>
        <!-- /navbar -->

        <!--Active Link-->
        @yield('activeLink')
        <!--/Active Link-->

        <!-- Main Sidebar Container -->
        @yield('sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            @yield('contentTitle')
                        </div>
                    </div>
                </div>
                <!-- /container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                @include('laraview.layouts.wait')
                @include('laraview.layouts.global_search_result_modal')
                @yield('content')
            </section>
            <!-- /content -->

        </div>
        <!-- /content-wrapper -->

        @include('laraview.layouts.footer')
        <!-- Control Sidebar -->

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /control-sidebar -->

    </div>
    <!-- /wrapper -->

    @include('laraview.layouts.vendorJs')
    @include('laraview.js.commonJs')
    @include('laraview.js.appJs')
    @yield('pageJs')
    @stack('scripts')

</body>

</html>
