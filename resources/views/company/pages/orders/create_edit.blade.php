@extends('company.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('orders.plural') }}</title>
@endsection
@section('content')
    <form>
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{  __('orders.actions.show') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.code') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->code }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.status') }}</label>
                            <input disabled class="form-control" type="text" value="{{ __('orders.statuses.' . $item->status) }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.address') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->address }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.phone') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->phone }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.phone2') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->phone2 }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.delivery_phone') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->delivery_phone }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.area') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->area }}">
                        </div>
                        {{-- <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.details') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->details }}">
                        </div> --}}

                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.delivery_date') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->delivery_date }}">
                        </div>

                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.payment') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->payment }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.guarantee_amount') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->guarantee_amount }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.total') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->total }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.user') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->user_id }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.company') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->company_id }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.check_guarantee') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->check_guarantee }}">
                        </div>

                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.localtion') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->localtion }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.type') }}</label>
                            <input disabled class="form-control" type="text" value="{{ __('orders.types.' . $item->type) }}">
                        </div>

                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.created_at') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->created_at }}">
                        </div>


                    </div>
                       <div class="row">
                        <br>
                         <h4 class="text-center">{{ __('orders.details') }}</h4>

                         <table class="table">
                            <tr>
                             <th>{{ __('products.plural') }}</th>
                             <th>{{ __('products.qty') }}</th>
                             <th>{{ __('products.attributes.1') }}</th>
                             <th>{{ __('products.attributes.2') }}</th>
                             <th>{{ __('products.attributes.3') }}</th>
                            </tr>
                            @if ($item->type==1)
                            @foreach ($item->details as $product)
                            <tr>
                                <td>{{ $item->productDetails($product['id'])?->name }}</td>
                                <td colspan="3">{{ $product['qty'] }}</td>

                            </tr>
                            @endforeach

                            @else

                            @foreach ($item->details as $product)
                            <tr>
                                <td>{{ $item->productDetails($product['id'])?->name }}</td>
                                <td>---</td>
                                <td>{{ $product['attribute_1'] }}</td>
                                <td>{{ $product['attribute_2'] }}</td>
                                <td>{{ $product['attribute_3'] }}</td>

                            </tr>
                            @endforeach

                            @endif
                        </table>
                    </div>
                    <div class="row">

                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.attachment1') }}</label>
                            @if(pathinfo($item->attachmentpayment1, PATHINFO_EXTENSION)=='pdf')
                            <br>    
                                <a href="{{ $item->attachmentpayment1 }}" download>تحميل المرفق</a>
                                @else
                                <img src="{{ $item->attachmentpayment1 }}" class="img-fluid img-thumbnail">
                                <a href="{{ $item->attachmentpayment1 }}" download>تحميل المرفق</a>
                            @endif
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.attachment2') }}</label>
                            @if(pathinfo($item->attachmentpayment2, PATHINFO_EXTENSION)=='pdf')
                            <br>

                                <a href="{{ $item->attachmentpayment2 }}" download>تحميل المرفق</a>
                                @else
                                <img src="{{ $item->attachmentpayment2 }}" class="img-fluid img-thumbnail">
                                <a href="{{ $item->attachmentpayment2 }}" download>تحميل المرفق</a>
                            @endif
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.check_guarantee') }}</label>
                            @if(pathinfo($item->checkamount, PATHINFO_EXTENSION)=='pdf')
                            <br>
                                <a href="{{ $item->checkamount }}" download>تحميل المرفق</a>
                                @else
                                <img src="{{ $item->checkamount }}" class="img-fluid img-thumbnail">
                                <a href="{{ $item->checkamount }}" download>تحميل المرفق</a>
                            @endif
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.check_guarantee_amount') }}</label>
                            @if(pathinfo($item->checkguaranteeamount, PATHINFO_EXTENSION)=='pdf')
                            <br>  
                            <a href="{{ $item->checkguaranteeamount }}" download>تحميل المرفق</a>
                            @else
                            <img src="{{ $item->checkguaranteeamount }}" class="img-fluid img-thumbnail">
                            <a href="{{ $item->checkguaranteeamount }}" download>تحميل المرفق</a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

