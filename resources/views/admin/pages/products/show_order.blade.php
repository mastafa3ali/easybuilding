@extends('admin.layouts.master')
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
                        @if($item->status== \App\Models\Order::STATUS_REJECTED)
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.reject_reason') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->reason }}">
                        </div>
                        @endif
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.address') }}</label>
                            @if($item->address)
                            <input disabled class="form-control" type="text" value="{{ $item->address }}">
                            @else
                            <a href="http://maps.google.com/?q={{ $item->lat }},{{ $item->long }}" class="btn btn-sm btn-outline-primary me-1 waves-effect form-control">الذهاب الى الموقع</a>
                            @endif
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.phone') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->phone }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.delivery_phone') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->delivery_phone }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.area') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->area }}">
                        </div>

                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.delivery_date') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->delivery_date }}">
                        </div>

                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.payment') }}</label>
                            <input disabled class="form-control" type="text" value="{{ __('orders.payments.'.$item->payment) }}">
                        </div>
                        @if($item->type==2)
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.guarantee_amount') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->guarantee_amount }}">
                        </div>
                       @endif
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.user') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->user?->name }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.company') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->company?->name }}">
                        </div>


                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.type') }}</label>
                            <input disabled class="form-control" type="text" value="{{ __('orders.types.' . $item->type) }}">
                        </div>

                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.created_at') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->created_at }}">
                        </div>
                          <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.progress_date') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->progress_date }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.on_way_date') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->on_way_date }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.deliverd_date') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->deliverd_date }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.reject_date') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->reject_date }}">
                        </div>
                    </div>
                    <div class="row">
                        <br>
                         <h4 class="text-center">{{ __('orders.details') }}</h4>

                         <table class="table">
                             @if ($item->type==1)
                            <tr>
                             <th>{{ __('products.plural') }}</th>
                             <th>{{ __('products.qty') }}</th>
                             <th>{{ __('products.price') }}</th>
                             <th>{{ __('orders.total') }}</th>
                            </tr>
                            @else
                            <tr>
                                <th>{{ __('products.plural') }}</th>
                                @if ($item->product?->sub_category_id==1)
                                <td>{{ __('orders.net_height') }}</td>
                                <td>{{ __('orders.slab_thickness') }}</td>
                                <td>{{ __('orders.space') }}</td>
                                @endif
                                @if ($item->product?->sub_category_id==2)
                                <td>{{ __('orders.total_length') }}</td>
                                <td>{{ __('orders.height') }}</td>
                                @endif
                                @if ($item->product?->sub_category_id==3)
                                <td>{{ __('orders.total_length') }}</td>
                                <td>{{ __('orders.height') }}</td>
                                <td>{{ __('orders.space') }}</td>
                                @endif
                                @if ($item->product?->sub_category_id==4)
                                <td>{{ __('orders.total_length') }}</td>
                                <td>{{ __('orders.height') }}</td>
                                @endif
                                <th>{{ __('products.mitrprice') }}</th>
                                <th>{{ __('orders.total') }}</th>
                            </tr>
                            @endif
                            @if ($item->type==1)
                            @foreach ($item->details as $product)
                            <tr>
                                <td> {{ $item->productDetails($product['id'])?->name }} </td>
                                <td> {{ $product['qty'] }} </td>
                                <td> {{ $product['price']??'' }} </td>
                                <td> {{ $product['qty']*$product['price'] }} </td>
                            </tr>
                            @endforeach
                            @else
                             @foreach ($item->details as $product)
                            <tr>
                                <td>{{ $item->productDetails($product['id'])?->name }}</td>

                                @if ($item->product?->sub_category_id==1)
                                    <td>{{ $product['attribute_1'] }}</td>
                                    <td>{{ $product['attribute_2'] }}</td>
                                    <td>{{ $product['attribute_3'] }}</td>
                                @endif
                                @if ($item->product?->sub_category_id==2)
                                    <td>{{ $product['attribute_1'] }}</td>
                                    <td>{{ $product['attribute_2'] }}</td>
                                @endif
                                @if ($item->product?->sub_category_id==3)
                                    <td>{{ $product['attribute_1'] }}</td>
                                    <td>{{ $product['attribute_2'] }}</td>
                                    <td>{{ $product['attribute_3'] }}</td>
                                @endif
                                @if ($item->product?->sub_category_id==4)
                                    <td>{{ $product['attribute_1'] }}</td>
                                    <td>{{ $product['attribute_2'] }}</td>
                                @endif

                                <td>{{ $product['price']??'' }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                    @if($item->type==2)
                    <div class="row">
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.attachment1') }}</label>
                            @if(pathinfo($item->attachmentpayment1, PATHINFO_EXTENSION)=='pdf')
                            <br>
                                <a href="{{ $item->attachmentpayment1 }}" download>
                                <img src="{{ asset('default.jpg') }}" class="img-fluid img-thumbnail">
                                </a>
                                @else
                                <a href="{{ $item->attachmentpayment1 }}" download>
                                <img src="{{ $item->attachmentpayment1 }}" class="img-fluid img-thumbnail">
                                </a>
                            @endif
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.attachment2') }}</label>
                            @if(pathinfo($item->attachmentpayment2, PATHINFO_EXTENSION)=='pdf')
                            <br>
                                <a href="{{ $item->attachmentpayment2 }}" download>
                                <img src="{{ asset('default.jpg') }}" class="img-fluid img-thumbnail">
                                </a>
                                @else
                                <a href="{{ $item->attachmentpayment2 }}" download>
                                <img src="{{ $item->attachmentpayment2 }}" class="img-fluid img-thumbnail">
                                </a>
                            @endif
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.check_guarantee') }}</label>
                            @if(pathinfo($item->checkamount, PATHINFO_EXTENSION)=='pdf')
                            <br>
                            <a href="{{ $item->checkamount }}" download>
                                <img src="{{ asset('default.jpg') }}" class="img-fluid img-thumbnail">
                            </a>
                            @else
                            <a href="{{ $item->checkamount }}" download>
                                <img src="{{ $item->checkamount }}" class="img-fluid img-thumbnail">
                            </a>
                            @endif
                        </div>
                        @if($item->payment!=1)
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.check_guarantee_amount') }}</label>
                            @if(pathinfo($item->checkguaranteeamount, PATHINFO_EXTENSION)=='pdf')
                            <br>
                            <a href="{{ $item->checkguaranteeamount }}" download>
                                <img src="{{ asset('default.jpg') }}" class="img-fluid img-thumbnail">
                            </a>
                            @else
                            <a href="{{ $item->checkguaranteeamount }}" download>
                                <img src="{{ $item->checkguaranteeamount }}" class="img-fluid img-thumbnail">
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endif
                    @if($item->type==1)
                    <div class="row">
                        @if($item->payment!=1)
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('orders.check_amount') }}</label>
                            @if(pathinfo($item->checkamount, PATHINFO_EXTENSION)=='pdf')
                            <br>
                                <a href="{{ $item->checkamount }}" download>
                                <img src="{{ asset('default.jpg') }}" class="img-fluid img-thumbnail">
                                </a>
                                @else
                                <a href="{{ $item->checkamount }}" download>
                                <img src="{{ $item->checkamount }}" class="img-fluid img-thumbnail">
                                </a>
                            @endif
                        </div>
                        @endif

                    </div>
                    @endif

                </div>
            </div>
        </div>
    </form>
@stop

