<!doctype html>
<html lang="en">
    <head>
        <title>SST Admin - Southern Star Tattoo Studio</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{asset('assets/front/img/favicon.png')}}" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{asset('assets/front/img/apple-touch-icon.png')}}">
        <!-- VENDOR CSS -->
        <link rel="stylesheet" href="{{asset('assets/admin_panel/dist/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin_panel/dist/fontawesome/css/all.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin_panel/dist/chartist/css/chartist.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin_panel/dist/chartist-plugin-tooltip/chartist-plugin-tooltip.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin_panel/dist/toastr/toastr.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin_panel/dist/sweetalert/sweetalert.css')}}">

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="{{asset('assets/admin_panel/css/main.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin_panel/css/loading.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin_panel/css/color_skins.css')}}">

        <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/ng-multiselect/dualmultiselect.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">

        <style type="text/css">
            @media (max-width: 768px){
                .breadcrumb{
                    float: left!important;
                }
            }

            .pagination>li>a, .pagination>li>span {
                -moz-border-radius-topleft: 2px;
                -webkit-border-top-left-radius: 2px;
                border-top-left-radius: 2px;
                -moz-border-radius-bottomleft: 2px;
                -webkit-border-bottom-left-radius: 2px;
                border-bottom-left-radius: 2px;
            }

            .page-link:not(:disabled):not(.disabled) {
                cursor: pointer;
            }

            .pagination>li>a, .pagination>li>span {
                color: #000;
            }

            .pagination li > span{

                position: relative;
                display: block;
                padding: .5rem .75rem;
                line-height: 1.25;
                background-color: #fff;
                border: 1px solid #dee2e6;

                margin-left: 0;
                border-top-left-radius: .25rem;
                border-bottom-left-radius: .25rem;
            }

            .pagination li > a{

                position: relative;
                display: block;
                padding: .5rem .75rem;
                line-height: 1.25;
                background-color: #fff;
                border: 1px solid #dee2e6;

                margin-left: 0;
                border-top-left-radius: .25rem;
                border-bottom-left-radius: .25rem;
            }
        </style>

@yield('css')


</head>
<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper"  id="loader">
    <div class="loader">
        <div class="m-t-30"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
        <p>Please wait...</p>        
    </div>
</div>
<!-- Overlay For Sidebars -->

<div id="wrapper">

    <!-- NAVIGATION BAT -->
    @include('includes.navbar')
    <!-- NAVIGATION BAT -->

    <!-- SIDEBAR -->
    @include('includes.sidebar')
    <!-- //SIDEBAR -->
    

    <div id="main-content">
        <div class="container-fluid">
            @yield('content')            
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="{{asset('assets/admin_panel/bundles/libscripts.bundle.js')}}"></script>
<script src="{{asset('assets/admin_panel/bundles/vendorscripts.bundle.js')}}"></script>

<script src="{{asset('assets/admin_panel/dist/toastr/toastr.js')}}"></script>
<script src="{{asset('assets/admin_panel/dist/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/admin_panel/bundles/chartist.bundle.js')}}"></script>
<script src="{{asset('assets/admin_panel/bundles/knob.bundle.js')}}"></script>
<script src="{{asset('assets/admin_panel/bundles/mainscripts.bundle.js')}}"></script>

<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>

<script src="{{asset('assets/admin_panel/dist/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/dialog.js')}}"></script>
<script src="{{asset('assets/admin_panel/dist/bootsrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/admin_panel/dist/bootsrap-fileinput/themes/explorer-fa/theme.js')}}"></script>

<script src="{{asset('assets/dist/moment/moment.js')}}"></script>
<script src="{{asset('assets/dist/angular-moment/angular-moment.min.js')}}"></script>

<script src="{{asset('/assets/dist/ng-multiselect/dualmultiselect.js')}}"></script>
<script src="{{asset('assets/dist/ng-image/angular.img-fallback.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular-bootstrap/ui-bootstrap-0.14.3.min.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular-bootstrap/ui-bootstrap-tpls-0.14.3.min.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular/angular-sanitize.min.js')}}"></script>
<script src="{{asset('assets/dist/ng-pagination/dist/paging.js')}}"></script>

<script type="text/javascript">
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("[rel=tooltip]").tooltip({html:true});

    // toastr.options.closeButton = true;
    // toastr.options.positionClass = 'toast-bottom-right';    
    // toastr['success']('Hello, welcome to Lucid, a unique admin Template.');


</script>

@yield('js')

</body>

</html>
