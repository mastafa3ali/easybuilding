@extends('teacher.layouts.master')
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
                            <span>{{  __('orders.actions.edit') }}</span>
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
                            <label class="form-label">{{ __('books.name') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->order_details['sender_name'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.email') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->order_details['sender_email'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.book') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->order_details['order_content'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.teacher') }}</label>
                            <input disabled class="form-control" type="text"
                                   value="{{ $item->order_details['sub_sender_name'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.area') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->order_details['sender_area'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.phone') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->order_details['sender_phone'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.address') }}</label>
                            <input disabled class="form-control" type="text"
                                   value="{{ $item->order_details['sender_address'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.government') }}</label>
                            <select disabled id="sender_government" class="form-control">
                                <option value="">اختر</option>
                                @foreach (getGovernments() as $government=>$government_txt)
                                    <option
                                        value="{{ $government }}" @selected($item->order_details['sender_government']==$government)>
                                        {{ $government_txt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.sender_backup_phone') }}</label>
                            <input disabled class="form-control" type="text"
                                   value="{{ $item->order_details['sender_backup_phone'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.teacher') }}</label>
                            <input disabled class="form-control" type="text"
                                   value="{{ $item->order_details['sub_sender_name'] }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.created_at') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->created_at }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.reference_number') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->number }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.quantity') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->quantity }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.the_price') }}</label>
                            <input disabled class="form-control" type="text" value="{{ $item->price }}">
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label">{{ __('books.status') }}</label>
                            <input disabled class="form-control" type="text" value="{{ __('orders.statuses.' . $item->status) }}">
                        </div>
                        @if($item->payment_details)
                            <div class="mb-1 col-md-4">
                                <label class="form-label">{{ __('books.payment_details') }}</label>
                                <input disabled class="form-control" type="text" value="{{ $item->payment_details }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

