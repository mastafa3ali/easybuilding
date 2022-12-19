<?php
$route = \Route::currentRouteName();
?>

<div class="horizontal-menu-wrapper">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-shadow menu-border container-xxl" role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="{{ route('teacher.home') }}">
                        <span class="brand-logo">
                         <img src="{{ $assetsPath }}/images/logo.png" style="max-width: 150px">
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <!-- Horizontal menu content-->
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <!-- include ../../../includes/mixins-->
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item {{ request()->routeIs('teacher.home') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" href="{{ route('teacher.home') }}">
                        <i data-feather="home"></i>
                        <span data-i18n="Dashboards">{{ __('admin.dashboard') }}</span>
                    </a>
                </li>
                <li class="dropdown nav-item {{ request()->routeIs('teacher.courses*') || request()->routeIs('teacher.sections*') || request()->routeIs('teacher.lessons*') ? 'active' : '' }}" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i data-feather="package"></i>
                        <span data-i18n="Apps">{{ __('admin.courses_tab') }}</span>
                    </a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.courses.index') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.courses') }}</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.sections.index') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.sections') }}</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.lessons.index') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.lessons') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('teacher.students*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" href="{{ route('teacher.students.index') }}">
                        <i data-feather="home"></i>
                        <span data-i18n="Dashboards">{{ __('admin.students') }}</span>
                    </a>
                </li>
                <li class="dropdown nav-item {{ request()->routeIs('teacher.posts*') || request()->routeIs('teacher.user_questions*') ? 'active' : '' }}" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i data-feather="package"></i>
                        <span data-i18n="Apps">{{ __('admin.questions_solutions') }}</span>
                    </a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.posts.index') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.posts') }}</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.user_questions.index') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.user_questions') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item {{ request()->routeIs('teacher.questions*') || request()->routeIs('teacher.quizzes*') || request()->routeIs('teacher.assignments*') ? 'active' : '' }}" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i data-feather="package"></i>
                        <span data-i18n="Apps">{{ __('admin.quizzes_questions') }}</span>
                    </a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.questions.index') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.questions') }}</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.quizzes.index') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.quizzes') }}</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.assignments.index') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.assignments') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
{{--                <li class="dropdown nav-item {{ request()->routeIs('teacher.payments*') ? 'active' : '' }}" data-menu="dropdown">--}}
{{--                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">--}}
{{--                        <i data-feather="package"></i>--}}
{{--                        <span data-i18n="Apps">{{ __('admin.payments') }}</span>--}}
{{--                    </a>--}}
{{--                    <ul class="dropdown-menu" data-bs-popper="none">--}}
{{--                        <li data-menu="">--}}
{{--                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.payments.index') }}" data-bs-toggle="" data-i18n="">--}}
{{--                                <i data-feather="mail"></i>--}}
{{--                                <span data-i18n="">{{ __('admin.payments') }}</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <li class="dropdown nav-item {{ request()->routeIs('teacher.reports*') ? 'active' : '' }}" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i data-feather="package"></i>
                        <span data-i18n="Apps">{{ __('admin.reports') }}</span>
                    </a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.reports.students2') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.students_report') }}</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.reports.lessons') }}" data-bs-toggle="" data-i18n="">
                                <i data-feather="mail"></i>
                                <span data-i18n="">{{ __('admin.lessons_report') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
