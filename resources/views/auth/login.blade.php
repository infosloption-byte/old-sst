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
    </head>

    <body class="theme-blue">
    	<!-- WRAPPER -->
    	<div id="wrapper">
    		<div class="vertical-align-wrap">
    			<div class="vertical-align-middle auth-main">
    				<div class="auth-box">
                        <div class="top">
                            <h4 style="color: white">SST | Admin</small></h4 >
                        </div>
    					<div class="card">
                            <div class="header">
                                <p class="lead">Login to your account</p>
                            </div>
                            <div class="body">
                                <form class="form-auth-small" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="signin-username" class="control-label sr-only">Username</label>
                                        <input type="username" name="username" class="form-control" id="signin-username" value="" placeholder="Username">
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="signin-password" class="control-label sr-only">Password</label>
                                        <input type="password" name="password" class="form-control" id="signin-password" value="" placeholder="Password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="fancy-checkbox element-left">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span>Remember me</span>
                                        </label>								
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                                    <div class="bottom">
                                        <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="page-forgot-password.html">Forgot password?</a></span>
                                        <span>Don't have an account? <a href="page-register.html">Register</a></span>
                                    </div>
                                </form>
                            </div>
                        </div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<!-- END WRAPPER -->
    </body>
</html>