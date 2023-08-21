@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.dashboard') }}</title>
@endsection
@section('content')
    <section id="dashboard-ecommerce">
        <div class="row match-height">

            <!-- Statistics Card -->
            <div class="col-xl-12 col-md-12 col-12">
                <div class="card card-statistics">
                    <div class="card-header">
                    <h4 class="card-title" style="color: #345c76">{{ __('admin.statistics') }}</h4>
                  
                    </div>
                    <div class="card-body statistics-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-primary me-2">
                                        <div class="avatar-content">
                                            <i data-feather="credit-card" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $sall_products }}</h4>
                                    </div>

                                </div>
                                <div class="my-auto">
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.sall_products') }}</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-primary me-2">
                                        <div class="avatar-content">
                                            <i data-feather="credit-card" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $rent_products }}</h4>
                                    </div>

                                </div>
                                <div class="my-auto">
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.rent_products') }}</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-info me-2">
                                        <div class="avatar-content">
                                            <i data-feather="users" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $companies }}</h4>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.companies') }}</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-info me-2">
                                        <div class="avatar-content">
                                            <i data-feather="users" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $merchants }}</h4>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.merchants') }}</p>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-danger me-2">
                                        <div class="avatar-content">
                                            <i data-feather="credit-card" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $all_orders }}</h4>
                                    </div>

                                </div>
                                <div class="my-auto">
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.all_orders') }}</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-danger me-2">
                                        <div class="avatar-content">
                                            <i data-feather="credit-card" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $pendding_orders }}</h4>
                                    </div>

                                </div>
                                <div class="my-auto">
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.pendding_orders') }}</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-danger me-2">
                                        <div class="avatar-content">
                                            <i data-feather="credit-card" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $rejected_orders }}</h4>
                                    </div>

                                </div>
                                <div class="my-auto">
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.rejected_orders') }}</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-danger me-2">
                                        <div class="avatar-content">
                                            <i data-feather="credit-card" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $deliverd_orders }}</h4>
                                    </div>

                                </div>
                                <div class="my-auto">
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.deliverd_orders') }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
@stop

