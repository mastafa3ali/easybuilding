<?php
$route = \Route::currentRouteName();
?>

    <div class="horizontal-menu-wrapper">
        <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-shadow menu-border container-xxl" role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">

                    <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i></a></li>
                </ul>
            </div>
            <div class="shadow-bottom"></div>
            <!-- Horizontal menu content-->
            <div class="navbar-container main-menu-content" data-menu="menu-container">
                <!-- include ../../../includes/mixins-->
                <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class="nav-item {{ request()->routeIs('company.home') ? 'active' : '' }}">
                        <a class="nav-link d-flex align-items-center" href="{{ route('company.home') }}">
                            <i data-feather="home"></i>
                            <span data-i18n="Dashboards">{{ __('admin.dashboard') }}</span>
                        </a>
                    </li>
                    <li class="dropdown nav-item {{ request()->routeIs('company.products*')  ? 'active' : '' }}" >
                        <a class=" nav-link d-flex align-items-center" href="{{ route('company.products.index') }}" >
                            <i data-feather="package"></i>
                            <span data-i18n="Apps">{{ __('admin.productsrent') }}</span>
                        </a>
                    </li>
                    <li class="dropdown nav-item {{ request()->routeIs('company.product_ssale*')  ? 'active' : '' }}" >
                        <a class=" nav-link d-flex align-items-center" href="{{ route('company.product_ssale.index') }}" >
                            <i data-feather="package"></i>
                            <span data-i18n="Apps">{{ __('admin.productssale') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('company.orders') ? 'active' : '' }}">
                        <a class="nav-link d-flex align-items-center" href="{{ route('company.orders') }}">
                            <i data-feather="book"></i>
                            <span data-i18n="List">{{ __('admin.orders') }}</span>
                        </a>
                    </li>
                      {{-- <li class="dropdown nav-item {{ request()->routeIs('company.reports*') ? 'active' : '' }}" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i data-feather="package"></i>
                        <span data-i18n="Apps">{{ __('admin.reports') }}</span>
                    </a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">#</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
