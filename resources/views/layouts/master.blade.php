<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>หน้าหลัก</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('themes/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('themes/css/sb-admin-2.min.css') }}" rel="stylesheet">
    {{-- <script src="{{ asset('themes/vendor/jquery/jquery.min.js') }}"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        {{-- @include('layouts.sidebar') --}}

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column vh-100">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.toolbar')

                <!-- Begin Page Content -->
                <div class="container px-3 py-3">

                    {{-- @include('layouts.pageheading') --}}

                    @yield('topbar')

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            {{-- @include('layouts.footer') --}}

        </div>
        <!-- End of Content Wrapper -->

    </div>
</body>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('themes/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('themes/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('themes/js/sb-admin-2.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Page level plugins -->
{{-- <script src="{{ asset('themes/vendor/chart.js/Chart.min.js') }}"></script> --}}

<!-- Page level custom scripts -->
{{-- <script src="{{ asset('themes/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('themes/js/demo/chart-pie-demo.js') }}"></script> --}}

</body>

</html>
