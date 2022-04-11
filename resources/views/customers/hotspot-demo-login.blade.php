<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Internet Login</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/themes/adminlte3x/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/themes/adminlte3x/dist/css/adminlte.min.css">

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

                <!-- Modal Instruction-->
                <div class="modal fade" id="ModalInstruction" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="overlay-wrapper">
                                    <p>Please Open the Link in a Browser <i class="fab fa-chrome"></i></p>
                                    <!--input-group -->
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="LinkLogin" value="$(link-login-only)"
                                            class="form-control">
                                        <span class="input-group-append">
                                            <button onclick="copyToClipboard()" type="button"
                                                class="btn btn-info btn-flat">
                                                <span id="LinkLoginCopy">Copy to clipboard</span>
                                            </button>
                                        </span>
                                    </div>
                                    <!--/input-group -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/modal Instruction-->


                <div class="container login-box">
                    <div class="card">

                        <!--Logo
                        <img class="card-img-top profile-user-img img-fluid img-circle"
                            src="" alt="...">
                        Logo-->

                        <!--card-body-->
                        <div class="card-body">

                            <!--Login Message-->
                            <p class="login-box-msg">Login to start your session</p>
                            <!--/Login Message-->

                            <!--Login form-->
                            <form name="login" action="{{ route('hotspot.login') }}" method="post"
                                onsubmit="return showModal()">

                                <!--mobile-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-mobile"
                                                aria-hidden="true"></i></span>
                                    </div>
                                    <input name="mobile" id="mobile" type="text" class="form-control"
                                        placeholder="Mobile Number" required>
                                </div>
                                <!--mobile-->

                                <input type="hidden" name="system_identity" value="3:172.30.30.1" />
                                <input type="hidden" name="login_ip" value="172.30.30.253" />
                                <input type="hidden" name="login_mac_address" value="D0:4A:3E:46:6D:A5" />
                                <input type="hidden" name="link_login_only" value="http://172.30.30.1/login" />
                                <input type="hidden" name="link_logout" value="http://172.30.30.1/logout" />

                                <div class="row">
                                    <button type="submit" class="btn btn-block btn-dark btn-sm">SUBMIT</button>
                                </div>

                            </form>
                            <!--/Login form-->

                        </div>
                        <!--/card-body-->

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

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="/themes/adminlte3x/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/themes/adminlte3x/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/themes/adminlte3x/dist/js/adminlte.js"></script>
    <script>
        $(document).ready(function () {
            let userAgentString = navigator.userAgent;
            if (userAgentString.indexOf('wv') > -1) {
                $('#ModalInstruction').modal({
                    backdrop: 'static',
                    show: true
                });
            }
        });

        function showModal() {
          $('#ModalCenter').modal({
            backdrop: 'static',
            show: true
          });
          return true;
        }

        function copyToClipboard() {
          var copyText = document.getElementById("LinkLogin");
          copyText.select();
          copyText.setSelectionRange(0, 99999);
          document.execCommand("copy");

          var tooltip = document.getElementById("LinkLoginCopy");
          tooltip.innerHTML = "Copied";
        }

    </script>
</body>

</html>
