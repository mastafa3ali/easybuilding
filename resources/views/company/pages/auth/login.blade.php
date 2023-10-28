<?php $assetsPath = asset('assets/admin') ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>{{ config('app.name') }}</title>
    <link rel="apple-touch-icon" href="{{ $assetsPath }}/images/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $assetsPath }}/images/favicon.png">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/vendors-rtl.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/pages/page-auth.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css/custom.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/custom-rtl.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v2">
                <div class="auth-inner row m-0">
                    <!-- Brand logo-->
                    <a class="brand-logo" href="#">
                        <img src="{{ $assetsPath }}/images/logo.png" height="40">
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{ $assetsPath }}/images/logo.png" alt="Login V2" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Login-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1">{{ __('admin.welcome') }}</h2>
                            <form class="auth-login-form mt-2" method="POST" action="{{ route('company.postLogin') }}">
                                @csrf
                                <div class="mb-1 @error('phone') is-invalid @enderror">
                                    <label class="form-label" for="login-phone">{{ __('admin.phone') }}</label>
                                    <input class="form-control" id="login-phone" type="number" name="phone" placeholder="" aria-describedby="login-phone" autofocus="" tabindex="1" value="{{ old('phone') }}" />
                                    @error('phone')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-1 @error('password') is-invalid @enderror">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="login-password">{{ __('admin.password') }}</label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}">
                                                <small>{{ __('admin.forgot_password') }}</small>
                                            </a>
                                            @endif
                                        </div>
                                    <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                                        <input class="form-control form-control-merge" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" />
                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        @error('password')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
                                        <label class="form-check-label" for="remember-me"> {{ __('admin.remember_me') }}</label>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100" tabindex="4">{{ __('admin.login') }}</button>
                                <br>
                                <br>
                                <a href="{{ route('register') }}">
                                    <small>{{ __('admin.register') }}</small>
                                </a>
                            </form>
                        </div>
                    </div>
                    <!-- /Login-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->


<!-- BEGIN: Vendor JS-->
<script src="{{ $assetsPath }}/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ $assetsPath }}/vendors/js/ui/jquery.sticky.js"></script>
<script src="{{ $assetsPath }}/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ $assetsPath }}/js/core/app-menu.js"></script>
<script src="{{ $assetsPath }}/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ $assetsPath }}/js/scripts/pages/page-auth-login.js"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
</body>
<!-- END: Body-->

</html>
