<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NHCF896');</script>
        <!-- End Google Tag Manager -->

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-TLDNC2L9Y2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-TLDNC2L9Y2');
        </script>
        <!-- End Google Tag  -->
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <meta name="author" content="ycusriya - csriyarathne@gmail.com">    
        <meta name="title" content="Tattoo Services,Professional Tattoo Services,Piercing Services">
        <meta name="description" content="Tattoo Services,Professional Tattoo Services,Piercing Services">
        <meta name="keywords" content="Tattoo Services,Professional Tattoo Services,Piercing Services" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index, follow">
                
        <!-- SITE TITLE -->
        <title>Book Appointment - Southern Star Tattoo</title>
                            
        <!-- FAVICON AND TOUCH ICONS -->
        <link rel="shortcut icon" href="{{asset('assets/front/images/favicon.ico')}}" type="image/x-icon">
        <link rel="icon" href="{{asset('assets/front/images/favicon.ico')}}" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/front/images/apple-touch-icon-152x152.png')}}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/front/images/apple-touch-icon-120x120.png')}}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/front/images/apple-touch-icon-76x76.png')}}">
        <link rel="apple-touch-icon" href="{{asset('assets/front/images/apple-touch-icon.png')}}">
        <link rel="icon" href="{{asset('assets/front/images/apple-touch-icon.png')}}" type="image/x-icon">

        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&amp;display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css2?family=Vollkorn:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">

        <!-- BOOTSTRAP CSS -->
        <link href="{{asset('assets/front/css/bootstrap.min.css')}}" rel="stylesheet">
                
        <!-- FONT ICONS -->
        <link href="{{asset('assets/front/css/flaticon.css')}}" rel="stylesheet">

        <!-- PLUGINS STYLESHEET -->
        <link href="{{asset('assets/front/css/menu.css')}}" rel="stylesheet"> 
        <link id="effect" href="{{asset('assets/front/css/dropdown-effects/fade-down.css')}}" media="all" rel="stylesheet">
        <link href="{{asset('assets/front/css/magnific-popup.css')}}" rel="stylesheet">   
        <link href="{{asset('assets/front/css/owl.carousel.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/front/css/owl.theme.default.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/front/css/datetimepicker.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/front/css/lunar.css')}}" rel="stylesheet">

        <!-- ON SCROLL ANIMATION -->
        <link href="{{asset('assets/front/css/animate.css')}}" rel="stylesheet">

        <!-- TEMPLATE CSS -->
        <link href="{{asset('assets/front/css/style.css')}}" rel="stylesheet"> 
        
        <!-- RESPONSIVE CSS -->
        <link href="{{asset('assets/front/css/responsive.css')}}" rel="stylesheet">
        @yield('css')
    </head>
    <body class="theme--dark">
        <!-- PRELOADER SPINNER
        ============================================= -->   
        <div id="loading" class="loading-black">
            <div id="loading-center"><span class="loader"></span></div>
        </div>

        <!-- PAGE CONTENT
        ============================================= -->   
        <div id="page" class="page">
            @include('includes.front.header')

            <!-- INNER PAGE TITLE
            ============================================= -->   
            <section id="booking-page" class="inner-page-hero division">
                <div class="container"> 
                    <div class="row">   
                        <div class="col">
                            <div class="page-hero-txt color--white">
                                <h2>Book an Appointment</h2>    
                                <p>Please fill out the appointment form below to make appointment</p>
                            </div>  
                        </div>
                    </div>
                </div>     <!-- End container --> 
            </section>  <!-- END INNER PAGE HERO -->

            <!-- BOOKING-1
            ============================================= -->
            <div id="booking-1" class="pt-8 pb-7 booking-section division">
                <div class="container">


                    <!-- BOOKING FORM -->
                    <div class="row justify-content-center">    
                        <div class="col-lg-10 col-xl-9" style="background: #000;padding: 3%;">
                            <form name="bookinkform" class="row booking-form">

                                <!-- Form Input -->
                                <div class="col-lg-6">
                                    <input type="text" name="firstname" class="form-control firstname" placeholder="First Name*" required>
                                </div>

                                <!-- Form Input -->
                                <div class="col-lg-6">
                                    <input type="text" name="lastname" class="form-control lastname" placeholder="Last Name*" required>
                                </div>
                                  
                                <!-- Form Input -->        
                                <div class="col-lg-6">
                                    <input type="email" name="email" class="form-control email" placeholder="Email Address*" required> 
                                </div>

                                <!-- Form Input -->   
                                <div class="col-lg-6">
                                    <input type="tel" name="phone" class="form-control phone" placeholder="Phone Number*" required> 
                                </div>

                                <!-- Form Select -->
                                <div class="col-lg-6">
                                    <select name="service" class="form-select service" aria-label="Appointment Type">
                                        <option selected>Select Type</option>
                                        <option>Tattoo Appointment</option>
                                        <option>Tattoo Consultation</option>
                                        <option>Piercing Appointment</option>
                                        <option>Piercing Consultation</option>
                                    </select>
                                </div>

                                <!-- Form Input -->
                                <div class="col-md-6">
                                    <input id="datetimepicker" type="text" name="date" class="form-control date" placeholder="Appointment Date*" required>
                                </div>
                                                            
                                <!-- Form Button -->
                                <div class="col-md-12 text-center">  
                                    <button type="submit" class="btn btn--tra-black hover--black submit">Book Appointment</button> 
                                </div>
                                                                              
                                <!-- Form Message -->
                                <div class="col-md-12 booking-form-msg">
                                    <div class="sending-msg"><span class="loading"></span></div>
                                </div>  
                                                                                        
                            </form>
                        </div>  
                    </div>    <!-- END BOOKING FORM -->


                </div>     <!-- End container -->
            </div>  <!-- END BOOKING-1 -->

            <!-- CONTACTS-1
            ============================================= -->
            <div id="contacts-1" class="contacts-section division">             
                <div class="container">


                    <!-- GOOGLE MAP --> 
                    <div class="row">
                        <div class="col">
                            <div class="google-map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448.23244838446715!2d80.10124259901787!3d6.131463666194388!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae177c69a253c77%3A0x114da2db435b0131!2sSouthern%20Star%20Tattoo%20-%20Hikkaduwa!5e0!3m2!1sen!2slk!4v1732258544507!5m2!1sen!2slk" width="1300" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>  <!-- END GOOGLE MAP --> 


                </div>     <!-- End container -->   
            </div>  <!-- END CONTACTS-1 -->

            <!-- GALLERY-3
            ============================================= -->
            @include('includes.front.gallery')

            @include('includes.front.footer-mod')
        </div>  <!-- END PAGE CONTENT -->

        @yield('js')

        <!-- EXTERNAL SCRIPTS
        ============================================= -->   
        <script src="{{asset('assets/front/js/jquery-3.7.0.min.js')}}"></script>
        <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script> 
        <script src="{{asset('assets/front/js/modernizr.custom.js')}}"></script>
        <script src="{{asset('assets/front/js/jquery.easing.js')}}"></script>
        <script src="{{asset('assets/front/js/menu.js')}}"></script>
        <script src="{{asset('assets/front/js/datetimepicker.js')}}"></script>    
        <script src="{{asset('assets/front/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('assets/front/js/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{asset('assets/front/js/request-form.js')}}"></script>  
        <script src="{{asset('assets/front/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/front/js/jquery.ajaxchimp.min.js')}}"></script>  
        <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/front/js/lunar.js')}}"></script>
        <script src="{{asset('assets/front/js/wow.js')}}"></script>
                
        <!-- Custom Script -->      
        <script src="{{asset('assets/front/js/custom.js')}}"></script>

        <script>
            $(document).on({
                "contextmenu": function (e) {
                    console.log("ctx menu button:", e.which); 

                    // Stop the context menu
                    e.preventDefault();
                },
                "mousedown": function(e) { 
                    console.log("normal mouse down:", e.which); 
                },
                "mouseup": function(e) { 
                    console.log("normal mouse up:", e.which); 
                }
            });
        </script>

    </body>
</html>