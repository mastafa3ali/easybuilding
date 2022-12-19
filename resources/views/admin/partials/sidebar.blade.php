<?php
    $route = \Route::currentRouteName();
    $assetsPath = asset('assets/admin');
?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    <img src="{{ $assetsPath }}/images/icon.png">
                    <h2 class="brand-text">{{ config('app.name') }}</h2>
                </a></li>
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
     
            @canany('newghaith.view')
            <li class=" nav-item {{ request()->routeIs('admin.newghaith') ? 'open' : '' }}">
                <a class="d-flex align-items-center {{ request()->routeIs('admin.newghaith') ? 'active' : '' }}" href="{{ route('admin.newghaith.index') }}">
                    <i data-feather="user-check"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">{{ __('admin.newghaith') }}</span>
                </a>
            </li>
            @endcanany
            @can('sliders.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.sliders.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.sliders') }}</span>
                </a>
            </li>
            @endcan
            @can('categories.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.categories.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.categories') }}</span>
                </a>
            </li>
            @endcan
            @can('sections.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.sections.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.sections') }}</span>
                </a>
            </li>
            @endcan
            @can('tracks.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.tracks.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.tracks') }}</span>
                </a>
            </li>
            @endcan
            @can('readingcycles.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.readingcycles.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.readingcycles') }}</span>
                </a>
            </li>
            @endcan
            @can('teams.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.teams.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.teams') }}</span>
                </a>
            </li>
            @endcan
            @can('contacts.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.contacts.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.contacts') }}</span>
                </a>
            </li>
            @endcan
            @can('settings.general')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.settings.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.company_details') }}</span>
                </a>
            </li>
            @endcan
                @can('settings.about')
                    <li>
                        <a class="d-flex align-items-center" href="{{ route('admin.settings.about') }} ">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.about') }}</span>
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
            @can('roles.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.roles.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.roles') }}</span>
                </a>
            </li>
            @endcan
            @can('users.view')
            <li>
                <a class="d-flex align-items-center" href="{{ route('admin.users.index') }} ">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate" data-i18n="List">{{ __('admin.users') }}</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div>

