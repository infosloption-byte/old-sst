<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">   

        <title>SST - Southern Star Tattoo Studio - Hikkaduwa</title>

        <meta name="keywords" content="Cleaning Services" />
        <meta name="description" content="SST - Southern Star Tattoo Studio - Hikkaduwa">
        <meta name="author" content="sisfs.com.au">

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{asset('assets/front/img/favicon.png')}}" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{asset('assets/front/img/apple-touch-icon.png')}}">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

        <!-- Web Fonts  -->
        <link href="{{asset('assets/front/css/google-fonts.css')}}" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="{{asset('assets/front/vendor/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/animate/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/simple-line-icons/css/simple-line-icons.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/owl.carousel/assets/owl.theme.default.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/magnific-popup/magnific-popup.min.css')}}">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{asset('assets/front/css/theme.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/theme-elements.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/theme-blog.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/theme-shop.css')}}">

        <!-- Current Page CSS -->
        <link rel="stylesheet" href="{{asset('assets/front/vendor/rs-plugin/css/settings.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/rs-plugin/css/layers.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/rs-plugin/css/navigation.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/vendor/circle-flip-slideshow/css/component.css')}}">
        
        <link rel="stylesheet" href="{{asset('assets/front/css/skins/default.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/custom.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin_panel/dist/sweetalert/sweetalert.css')}}">

        

        <style type="text/css">
            
        </style>
        @yield('css')
    </head>
    <script type="text/javascript">
        function updateImageModel()
        {
            console.log('sadnf');
        }
    </script>
    <body class="loading-overlay-showing" data-plugin-page-transition data-loading-overlay data-plugin-options="{'hideDelay': 500}">
        <div class="loading-overlay">
            <div class="bounce-loader">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="body">
            @include('includes.front.header')
            @yield('content')
            @include('includes.front.footer')
        </div>

        <div class="modal fade" id="largeModalChangeProfilePic" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Change Profile Picture</h4>
                    </div>
                    <form action="" method="POST" role="form" id="update-profile-pic-form">
                        {{csrf_field()}}
                        <input type="hidden" name="profile_employee_id" id="profile_employee_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 text-center">
                                    <div class="avatar">
                                        <img ng-show="edit.image!=NULL" style="object-fit: cover;" src="{{url('storage')}}/@{{edit.image}}" class="rounded-circle avatar profile-pic" alt="">
                                    
                                        <img ng-show="edit.image==NULL" src="{{asset('assets/admin_panel/images/user-avatar.png')}}" class="rounded-circle avatar profile-pic" alt="">
                                    </div>
                                </div>
                                <div class="col-8 col-sm-8 col-md-8 col-lg-8 text-center">
                                    <label requird>Image Size : (200 x 200)px</label>
                                    <input type="file" id="profile_pic" name="profile_pic">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{asset('assets/front/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/jquery.appear/jquery.appear.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/jquery.cookie/jquery.cookie.min.js')}}"></script>
        
        <script src="{{asset('assets/front/vendor/popper/umd/popper.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/common/common.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/jquery.validation/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/jquery.gmap/jquery.gmap.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/jquery.lazyload/jquery.lazyload.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/isotope/jquery.isotope.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/vide/jquery.vide.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/vivus/vivus.min.js')}}"></script>
        
        <script src="{{asset('assets/front/js/theme.js')}}"></script>
        
        <script src="{{asset('assets/front/vendor/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
        <script src="{{asset('assets/front/vendor/circle-flip-slideshow/js/jquery.flipshow.min.js')}}"></script>
        <script src="{{asset('assets/front/js/views/view.home.js')}}"></script>

        <script src="{{asset('assets/front/js/theme.init.js')}}"></script>
        <script src="{{asset('assets/front/js/examples/examples.carousels.js')}}"></script>
        <script src="{{asset('assets/admin_panel/dist/sweetalert/sweetalert.min.js')}}"></script>

        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
        @yield('js')
    </body>
</html>