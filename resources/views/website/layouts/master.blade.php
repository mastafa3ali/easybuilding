<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author">
    <title>غيث</title>
    <link href="{{ asset('site') }}/assets/css/themify-icons.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/flaticon.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/animate.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/owl.carousel.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/owl.theme.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/slick.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/slick-theme.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/swiper.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/owl.transitions.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/jquery.fancybox.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/odometer-theme-default.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/nice-select.css" rel="stylesheet">
    <link href="{{ asset('site') }}/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
            </div>
        </div>
        <!-- end preloader -->
        <header id="header" class="wpo-site-header wpo-header-style-2">
            <div class="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col col-md-6 col-sm-7 col-12">
                            <div class="contact-intro">
                                <ul>
                                    <li><i class="fi ti-location-pin"></i>{{ general_setting('general_company_address') }}</li>
                                    <li><i class="fi flaticon-envelope"></i> {{ general_setting('general_email') }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col col-md-6 col-sm-5 col-12">
                            <div class="contact-info">
                                <ul>
                                    <li><a href="{{ general_setting('general_facebook_url') }}" target="__blanck"><i class="ti-facebook"></i></a></li>
                                    <li><a href="{{ general_setting('general_twitter') }}" target="__blanck"><i class="ti-twitter-alt"></i></a></li>
                                    <li><a href="{{ general_setting('general_instagram') }}" target="__blanck"><i class="ti-instagram"></i></a></li>
                                    <li><a href="{{ general_setting('general_google_url') }}" target="__blanck"><i class="ti-google"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end topbar -->
            <div class="site-header header-style-1">
                <nav class="navigation navbar navbar-default original">
                    <div class="container" style="display: flex;">
                        <div class="navbar-header">
                            <button type="button" class="open-btn">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('site') }}/assets/images/logo.png" alt="logo"></a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse navigation-holder">
                            <button class="close-navbar"><i class="ti-close"></i></button>
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="{{ route('home') }}">{{ __('site.home') }}</a>
                                </li>
                                <li><a href="{{ route('about') }}">{{ __('site.about_ghaith') }}</a></li>
                                <li><a href="{{ route('newghaith') }}">{{ __('site.new_ghaith') }}</a></li>
                                @can('site.studentsAchievement')
                                <li><a href="{{ route('studentsAchievement') }}">{{ __('site.request_page') }}</a></li>
                                @endcan
                                @can('site.achievementPanel')
                                <li><a href="{{ route('achievementPanel') }}">{{ __('site.dashboard_ends') }}</a></li>
                                @endcan
                            </ul>
                        </div><!-- end of nav-collapse -->

                    </div><!-- end of container -->
                </nav>
            </div>
        </header>
   @yield('content')
    </div>
    <!-- end of page-wrapper -->
    <!-- All JavaScript files
    ================================================== -->
    <script src="{{ asset('site') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('site') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('site') }}/assets/js/circle-progress.min.js"></script>
    <!-- Plugins for this template -->
    <script src="{{ asset('site') }}/assets/js/jquery-plugin-collection.js"></script>
    <!-- Custom script for this template -->
    <script>
        const contacntUrl="{{ route('contactus') }}";
    </script>
    <script src="{{ asset('site') }}/assets/js/script.js"></script>
    @stack('scripts')


</body>

</html>