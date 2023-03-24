<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>SiKato | Sistem Kasir Toko</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="css/light.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- DataTables -->
    <link href="plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Sweet Alert-->
    <link href="plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    {{-- select2 --}}
    <link href="plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <script src="plugins/jquery/jquery.min.js"></script>
    <style>
        .btn-ungu{
            background-color: #2B00D7;
            color: white;
        }
        .btn-ungu:hover{
            background-color: #2704b5;
            color: white;
        }
    </style>

</head>

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default"
    style="font-family: 'Poppins">
    <section class="vh-100">

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-7 d-flex justify-content-center align-items-center " >

                    <div class="m-sm-4">
                        
                        {{-- <img class="col-12" src="assets/logo/logo_loker.png" alt="logo"> --}}
                        <span class="fs-1 fw-bolder text-primary " ><span class="text-dark">Si</span> Kato</span><br>
                        <span class=" text-primary " >Sistem Kasir Toko</span>
                        <form action="javascript:onLogin(this)" method="post" id="form_login" name="form_login" autocomplete="off" class="mt-5">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control form-control-lg" type="email" name="user_email" placeholder="Enter your email" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
                                
                            </div>
                            
                            <button type="submit" class="btn btn-lg btn-primary col-12 mt-3">Log In</button>
                        </form>
                    </div>

                </div>
                <div class="col-sm-5 px-0 d-none d-sm-block">
                    <img src="assets/logo/smk.png"
                        alt="Login image" class="w-100 vh-100" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </section>
    @include('login::javascript')

    <script src="js/app.js"></script>

    <!-- Required datatable js -->
    <script src="plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/build/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/build/vfs_fonts.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    {{-- <script src="assets/js/pages/datatables.init.js"></script> --}}

    <!-- Sweet Alerts js -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    {{-- <script src="assets/js/pages/sweet-alerts.init.js"></script> --}}

    {{-- block ui --}}
    <script src="plugins/blockui-master/jquery.blockUI.js"></script>
    {{-- select2 --}}
    <script src="plugins/select2/select2.min.js"></script>

    <script src="assets/helpers/helper.js"></script>

</body>

</html>
