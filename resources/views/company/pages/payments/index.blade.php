@extends('company.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('payments.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ route('company.payments.store') }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{  __('admin.payments') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('products.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                     <div class="demo-inline-spacing">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="payment[]" value=1 type="checkbox" {{ isset($item)? in_array(1,$item->payments)?'checked':'' :'' }} />
                            <label class="form-check-label" for="inlineCheckbox1">{{ __('orders.payments.1') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="payment[]" value=2 type="checkbox" {{ isset($item)? in_array(2,$item->payments)?'checked':'':''  }} />
                            <label class="form-check-label" for="inlineCheckbox2">{{ __('orders.payments.2') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="payment[]" value=3 type="checkbox" {{ isset($item)? in_array(3,$item->payments)?'checked':'':''  }} />
                            <label class="form-check-label" for="inlineCheckbox3">{{ __('orders.payments.3') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
