<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Customer Login</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/themes/adminlte3x/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/themes/adminlte3x/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/themes/adminlte3x/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/themes/adminlte3x/plugins/toastr/toastr.min.css">

</head>

<body class="hold-transition layout-top-nav">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">

                <a href="#" class="navbar-brand">
                    <i class="fas fa-wifi"></i>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Left navbar links -->
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a href="{{ config('consumer.about_link') }}" class="nav-link"> <i class="fas fa-home"></i> About</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link"><i class="fas fa-user-cog"></i> Admin Login</a>
                        </li>
                    </ul>

                </div>
                {{-- Left navbar links --}}

            </div>
        </nav>
        <!-- /navbar -->

        <!-- Content Wrapper-->
        <div class="content-wrapper">
            <!-- Content Header-->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">

                    </div>
                    <!--/row -->
                </div>
                <!--/container-fluid -->
            </div>
            <!-- /content-header -->

            <!-- Main content -->
            <div class="content">

                <!-- Modal Loading-->
                <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="overlay-wrapper">
                                    <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                                    <div class="text-bold pt-2">Loading...</div>
                                    <div class="text-bold pt-2">Please Wait</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/modal Loading-->

                <div class="container login-box">

                    <div class="card">

                        <!--card-body-->
                        <div class="card-body">

                            <!--Login Message-->
                            <p class="login-box-msg">Login to start your session</p>
                            <!--/Login Message-->

                            <!--Login form-->
                            <form name="login" action="{{ route('customer.web.login') }}" method="post"
                                onsubmit="return showModal()">

                                @csrf

                                @if (config('consumer.auth_customer_id'))

                                <!--customer_id-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                    <input name="customer_id" id="customer_id" type="text" class="form-control"
                                        placeholder="Customer ID" required>
                                </div>
                                <!--customer_id-->

                                @endif

                                <!--mobile-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-mobile"></i>
                                        </span>
                                    </div>
                                    <input name="mobile" id="mobile" type="text" class="form-control"
                                        placeholder="Mobile Number" required>
                                </div>
                                <!--mobile-->

                                <div class="row">
                                    <button type="submit" class="btn btn-block btn-dark btn-sm">SUBMIT</button>
                                </div>

                            </form>
                            <!--/Login form-->

                        </div>
                        <!--/card-body-->

                        @if (config('consumer.auth_customer_id'))

                        <div class="card-footer">

                            <!--Forgot CustomerId-->
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-link" href="{{ route('forgot-customer-id.create') }}">I forgot my
                                    Customer ID</a>
                            </div>
                            <!--/Forgot CustomerId-->

                        </div>

                        @endif

                    </div>
                    <!--/card-->

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
        <footer class="main-footer">
            <strong>powered by <a href="{{ config('app.url') }}">{{ config('consumer.app_subscriber') }}</a></strong>
        </footer>
        <!-- /Main Footer -->
    </div>
    <!--/wrapper -->

    <!-- jQuery -->
    <script src="/themes/adminlte3x/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/themes/adminlte3x/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/themes/adminlte3x/dist/js/adminlte.js"></script>
    <!-- SweetAlert2 -->
    <script src="/themes/adminlte3x/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="/themes/adminlte3x/plugins/toastr/toastr.min.js"></script>

    @if (session('success'))
    <script type="text/javascript">
        $(function() {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
            });

            Toast.fire({
                icon: 'success',
                title:  '{{ session('success') }}'
            })
        });

    </script>
    @endif

    @if (session('error'))
    <script type="text/javascript">
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 6000
            });

            Toast.fire({
                icon: 'error',
                title:  '{{ session('error') }}'
            })
        });

    </script>
    @endif


    <script>
        function showModal() {
          $('#ModalCenter').modal({
            backdrop: 'static',
            show: true
          });
          return true;
        }
    </script>

</body>

</html>
