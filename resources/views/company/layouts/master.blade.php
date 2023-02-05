<?php $assetsPath = asset('assets/admin') ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    @yield('title')
    <link rel="apple-touch-icon" href="{{ $assetsPath }}/images/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $assetsPath }}/images/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/extensions/toastr.min.css">
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
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/plugins/extensions/ext-component-toastr.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/forms/select/select2.min.css">

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css/custom.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/custom-rtl.css">
    <!-- END: Custom CSS-->
    @stack('styles')
    <!-- END: Custom CSS-->


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu  navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="">

<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center" data-nav="brand-center">

    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>

        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name fw-bolder">{{ auth()->user()->name }}</span>
                        <span class="user-status">{{ __('admin.company2') }}</span>
                    </div>
                    <span class="avatar"><img class="round" src="{{ $assetsPath }}/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{ route('company.profile.index') }}">
                        <i class="me-50" data-feather="user"></i> {{ __('admin.profile') }}
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="dropdown-item">
                        <i class="me-50" data-feather="power"></i> {{ __('admin.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('company.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
<ul class="main-search-list-defaultlist d-none">
    <li class="d-flex align-items-center"><a href="#">
            <h6 class="section-label mt-75 mb-0">Files</h6>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img src="{{ $assetsPath }}/images/icons/xls.png" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
                </div>
            </div><small class="search-data-size me-50 text-muted">&apos;17kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img src="{{ $assetsPath }}/images/icons/jpg.png" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
                </div>
            </div><small class="search-data-size me-50 text-muted">&apos;11kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img src="{{ $assetsPath }}/images/icons/pdf.png" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
                </div>
            </div><small class="search-data-size me-50 text-muted">&apos;150kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img src="{{ $assetsPath }}/images/icons/doc.png" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
                </div>
            </div><small class="search-data-size me-50 text-muted">&apos;256kb</small>
        </a></li>
    <li class="d-flex align-items-center"><a href="#">
            <h6 class="section-label mt-75 mb-0">Members</h6>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img src="{{ $assetsPath }}/images/portrait/small/avatar-s-8.jpg" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img src="{{ $assetsPath }}/images/portrait/small/avatar-s-1.jpg" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img src="{{ $assetsPath }}/images/portrait/small/avatar-s-14.jpg" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img src="{{ $assetsPath }}/images/portrait/small/avatar-s-6.jpg" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                </div>
            </div>
        </a></li>
</ul>
<ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion justify-content-between"><a class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start"><span class="me-75" data-feather="alert-circle"></span><span>No results found.</span></div>
        </a></li>
</ul>
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
@include('company.partials.sidebar')
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        @include('flash::message')
        @yield('content')
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-start d-block d-md-inline-block mt-25">
            <span class="d-none d-sm-inline-block">{{ config('app.name') }}</span>
        </span>
        <span class="float-md-end d-none d-md-block"><i data-feather="heart"></i></span>
    </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->


<div class="modal fade text-start" id="modalDelete" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteForm" method="post" action="#">
            <input type="hidden" name="_method" value="DELETE">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">{{ __('admin.dialogs.delete.title') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('admin.dialogs.delete.info') }}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger">{{ __('questions.dialogs.delete.confirm') }}</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">{{ __('questions.dialogs.delete.cancel') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- BEGIN: Vendor JS-->
<script src="{{ $assetsPath }}/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ $assetsPath }}/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="{{ $assetsPath }}/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="{{ $assetsPath }}/vendors/js/forms/select/select2.full.min.js"></script>


<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ $assetsPath }}/js/core/app-menu.js"></script>
<script src="{{ $assetsPath }}/js/core/app.js"></script>
<!-- END: Theme JS-->

<script>

    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
        $('.ajax_select2').select2({
            placeholder: "{{ __('admin.select') }}",
            ajax: {
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {results: data};
                },
                cache: true
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('click', '.delete_item', function (){
            var url= $(this).attr('data-url');
            $('#deleteForm').attr('action', url)
            $('#modalDelete').modal('show')
            return false;
        })


        $(document).on('change', '#subject_id', function(){
            var subject_id = $(this).val();
            $('#product_id').html('');
            $('#section_id').html('');
            $('#lesson_id').html('');
            $.ajax({
                type:'GET',
                url:"{{ route('company.products.select') }}",
                data:{subject_id:subject_id,pure_select:true},
                success:function(data){
                    $('#product_id').html(data);
                }
            });
        })

        $('#subject_id').on('select2:select', function (e) {
            $(".ajax_companys").val('').trigger('change')
        });

    })
</script>
@stack('scripts')
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

<script>
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    var firebaseConfig = {
        apiKey: "AIzaSyD4XGTrPle1LBlcnaEJA8j5lXtu1aUC-X4",
        authDomain: "easybuilding-d14f0.firebaseapp.com",
        projectId: "easybuilding-d14f0",
        storageBucket: "easybuilding-d14f0.appspot.com",
        messagingSenderId: "541745851840",
        appId: "1:541745851840:web:547c94f535958229d8ec25"
    };
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging.requestPermission().then(function () {
            return messaging.getToken()
        }).then(function(fcm_token) {

            $.ajax({
                type:'POST',
                url:"{{ route('company.fcmToken') }}",
                data:{
                _method:"PATCH",
                fcm_token,
                token:$('meta[name="csrf-token"]').attr('content')
                },
                success:function(data){
                    console.log(data)
                },
                error:function(response){
                    console.error(response)
                }
            });

        }).catch(function (err) {
            console.log(`Token Error :: ${err}`);
        });
    }

    initFirebaseMessagingRegistration();

    messaging.onMessage(function({data:{body,title}}){
        alert(title)
        new Notification(title, {body});
    });
</script>
</body>
<!-- END: Body-->

</html>
