<!doctype html>
<html lang="en">


<!-- Mirrored from thememakker.com/templates/lucid/hr/html/light/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Jan 2019 14:00:24 GMT -->
<head>
<title>Simpli5 | Admin</title>
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

    img{
            margin-left: auto!important;
    display: block!important;
    margin-right: auto !important;
    }

</style>
</head>

<body class="theme-blue">
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="row justify-content-center">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="card">
                            <div class="header text-center">
                                <p class="lead">Download Now From PlayStore (<a href="https://play.google.com/store/apps/details?id=com.warpath.simplifive.warpath&hl=en">GO</a>)</p>
                            </div>
                            <div class="body ">
                                <div id="qrcode-plastore"></div>
                            </div>
                        </div>               
                    </div>

                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="card">
                            <div class="header text-center">
                                <p class="lead">Download From Link (
                                <a href="{{url('/releases/1.0.6.apk')}}">Download</a>)</p>
                            </div>
                            <div class="body">
                                <div id="qrcode-link"></div>
                            </div>
                        </div>               
                    </div>            
                </div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

<script src="{{asset('assets/dist/qr-js/qrcode.min.js')}}"></script>
<script type="text/javascript">
    

    new QRCode(document.getElementById("qrcode-plastore"), "https://play.google.com/store/apps/details?id=com.warpath.simplifive.warpath&hl=en");
    new QRCode(document.getElementById("qrcode-link"), "{{url('/releases/1.0.6.apk')}}");

</script>

<!-- Mirrored from thememakker.com/templates/lucid/hr/html/light/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Jan 2019 14:00:24 GMT -->
</html>
