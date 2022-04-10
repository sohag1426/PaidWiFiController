<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title')</title>

    @include('laraview.layouts.vendorCss')
    @include('laraview.css.commonCss')
    @include('laraview.css.appCss')
    @yield('pageCss')

</head>

<body class="hold-transition layout-top-nav">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">

            <div class="container">

                <a href="#" class="navbar-brand">
                    <span class="brand-text font-weight-light">@yield('company')</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                @yield('topNavbar')

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    @if(Auth::user())
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

            </div>

        </nav>
        <!-- /navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            @yield('contentTitle')
                        </div>
                        <!-- /col -->
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container-fluid -->
            </div>
            <!-- /content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    @include('laraview.layouts.wait')
                    @yield('content')
                </div>
                <!-- /container-fluid -->
            </div>
            <!-- /content -->

        </div>
        <!-- /content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /control-sidebar -->

        <!-- Main Footer -->
        @include('laraview.layouts.footer')

    </div>
    <!--/wrapper -->

    @include('laraview.layouts.vendorJs')
    @include('laraview.js.commonJs')
    @include('laraview.js.appJs')
    @yield('pageJs')
    @stack('scripts')

</body>

</html>
