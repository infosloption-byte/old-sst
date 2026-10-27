<!doctype html>
<html lang="en">


<head>
<title>SST Admin - Southern Star Tattoo Studio</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/fontawesome/css/fontawesome.min.css')}}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{asset('assets/admin_panel/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/css/color_skins.css')}}">
</head>



<style type="text/css">
    
    .auth-main:after{
        content:'';
        position:absolute;
        right:0;
        top:0;
        width:100%;
        height:100%;
        z-index:-2;
        background:url("{{url('assets/admin_panel/images/auth_bg_.jpg')}}") no-repeat top left fixed
    }

</style>

<body class="theme-orange">
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle ">
                <div class=" text-center">
                    <div class="header">
                        <h3>
                            <span class="clearfix title">
                                <h1 style="font-size: 70px">403!</h1>
                                <span class="number left"></span> <span class="text">Forbiddon Error!</span>
                            </span>
                        </h3>
                    </div>
                    <div class="body">
                       <p>You don't have permission to access / or page your looking for is not found.</p>
            <div class="margin-top-30">
                <a href="javascript:history.go(-1)" class="btn btn-default"><i class="fa fa-arrow-left"></i> <span>Go Back</span></a>
                <a href="{{url('/')}}" class="btn btn-primary"><i class="fa fa-home"></i> <span>Home</span></a>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->
</body>

</html>

