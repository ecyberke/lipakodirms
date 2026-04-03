<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Lesa International Agencies RMS</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Silvestone Properties Management System" name="LIA" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />

    <!-- Page Specific css -->
    @stack('header_scripts')
</head>

<body>
    <div id="wrapper">
        <!-- Top Bar Start -->
        @include('includes.top_bar')
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
        @include('includes.side_menu')
        <!-- Left Sidebar End -->
        <div class="content-page">
            @yield('content')
        </div>
        <footer class="footer">
            © 2020 Lesa International Agencies <span class="d-none d-sm-inline-block"></span>.
        </footer>
        <!-- App's Basic Js  -->
        <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{ asset('assets/js/waves.min.js')}}"></script>        
        <script src="{{ asset('assets/js/app.js')}}"></script>
        <!-- Page specific js -->
        @stack('footer_scripts')


    </div>
</body>

</html>
