<?php
    $route = \Route::currentRouteName();
    $assetsPath = asset('assets/admin');
?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    <h2 class="brand-text">{{ config('app.name') }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.home') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">{{ __('admin.dashboard') }}</span>
                </a>
            </li>

            @can('sliders.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.sliders.index') }} ">
                    <i data-feather="image"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.sliders') }}</span>
                </a>
            </li>
            @endcan
            @can('categories.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.categories.index') }} ">
                    <i data-feather="database"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.categories') }}</span>
                </a>
            </li>
            @endcan
            @can('sub_categories.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.sub_categories.index') }} ">
                    <i data-feather="box"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.sub_categories') }}</span>
                </a>
            </li>
            @endcan
            @can('orders.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.orders.index') }} ">
                    <i data-feather="box"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.orders') }}</span>
                </a>
            </li>
            @endcan
            @can('products.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.products.index') }} ">
                    <i data-feather="briefcase"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.products') }}</span>
                </a>
            </li>
            @endcan
            
            @can('rates.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.rates.index') }} ">
                    <i data-feather="briefcase"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.rates') }}</span>
                </a>
            </li>
            @endcan

            @can('products.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.products.orders') }} ">
                    <i data-feather="book"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.orders') }}</span>
                </a>
            </li>
            @endcan
            @can('reports.saleOrders')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.reports.saleOrders') }} ">
                    <i data-feather="book"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.sale_orders') }}</span>
                </a>
            </li>
            @endcan
            @can('reports.rentOrders')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.reports.rentOrders') }} ">
                    <i data-feather="book"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.rent_orders') }}</span>
                </a>
            </li>
            @endcan
            @can('contacts.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.contacts.index') }} ">
                    <i data-feather="phone"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.contacts') }}</span>
                </a>
            </li>
            @endcan
            @can('settings.general')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.settings.index') }} ">
                    <i data-feather="settings"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.company_details') }}</span>
                </a>
            </li>
            @endcan
            @can('settings.about')
                <li>
                    <a class="d-flex align-items-center" href="{{ route('admin.settings.about') }} ">
                        <i data-feather="info"></i>
                        <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.about') }}</span>
                    </a>
                </li>
            @endcan
            @can('notifications.view')
                <li>
                    <a class="d-flex align-items-center" href="{{ route('admin.notifications.index') }} ">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.notifications') }}</span>
                    </a>
                </li>
            @endcan
            @can('settings.privacy')
                <li>
                    <a class="d-flex align-items-center" href="{{ route('admin.settings.privacy') }} ">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.privacy') }}</span>
                    </a>
                </li>
            @endcan
            @can('settings.terms')
                <li>
                    <a class="d-flex align-items-center" href="{{ route('admin.settings.terms') }} ">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.terms') }}</span>
                    </a>
                </li>
            @endcan
            @can('users.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.users.index') }} ">
                    <i data-feather="users"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.users') }}</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div>

