@extends('company.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('products.orders') }}</title>
@endsection
@section('content')
         <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('products.orders') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card mt-2">
            <div class="card-body p-0">
                <table class="datatables-ajax table table-responsive">
                    <thead>
                    <tr>
                        <th>{{ __('orders.code') }}</th>
                        <th>{{ __('orders.type') }}</th>
                        <th>{{ __('orders.status') }}</th>
                        <th>{{ __('orders.address') }}</th>
                        <th>{{ __('orders.phone') }}</th>
                        <th>{{ __('orders.delivery_phone') }}</th>
                        <th>{{ __('orders.total') }}</th>
                        <th>{{ __('orders.user') }}</th>
                        <th>{{ __('orders.action') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('company.pages.orders.modal')
@stop
@push('scripts')
    <script>
        var dt_ajax_table = $('.datatables-ajax');
        var dt_ajax = dt_ajax_table.dataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            info: false,
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            drawCallback: function( settings ) {
                feather.replace();
            },
            ajax: {
                url: "{{ route('company.orders.list') }}",
                data: function (d) {
                    d.book_name   = $('#filterForm #book_name').val();
                    d.student_phone = $('#filterForm #student_phone').val();
                    d.number = $('#filterForm #number').val();
                    d.date = $('#filterForm #date').val();
                }
            },
              drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                {data: 'code', name: 'code'},
                {data: 'type', name: 'type'},
                {data: 'status', name: 'status'},
                {data: 'address', name: 'address'},
                {data: 'phone', name: 'phone'},
                {data: 'delivery_phone', name: 'delivery_phone'},
                {data: 'total', name: 'total'},
                {data: 'user', name: 'user'},
                {data: 'actions',name: 'actions',orderable: false,searchable: false}
            ],  columnDefs: [
                {
                    "targets": -1,
                    "render": function (data, type, row) {
                    var deleteUrl = '{{ route("company.orders.destroy", ":id") }}';
                    deleteUrl = deleteUrl.replace(':id', row.id);
                    return `
                    <div class="dropdown">
                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                                    <i data-feather="more-vertical" class="font-medium-2"></i>
                            </button>
                            <div class="dropdown-menu">
                                `+row.change_status+`
                                `+row.editUrl+`

                            </div>
                        </div> `;
                    }
                }
            ]
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
        $('body').on('click', '.update_status', function() {
            var url = $(this).attr('data-url');
            var id = $(this).attr('data-order_id');
            var status = $(this).attr('data-status');
            if(status==1){
                console.log(status)
                $('#reason').show();
            }else{
                $('#reason').hide();
            }
            $('#updateStatusForm').attr('action', url)
            $('#order_id').val(id)
            $('#modalUpdateStatus').modal('show')
            return false;
        })
    </script>
@endpush
