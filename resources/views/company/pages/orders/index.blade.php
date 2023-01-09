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
                    {{-- <a href="{{ route('company.orders.download') }}" class="btn btn-sm btn-outline-primary bg-white me-1 waves-effect border-0">{{ __('products.download') }}</a> --}}
            
                        {{-- @include('company.pages.orders.filter') --}}
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
    
                <div class="card mt-2">
                            <div class="card-body p-0">
                                {{-- <table class="datatables-ajax table table-responsive">
                                    <thead>
                                    <tr>
                                        
                                        <th>{{ __('books.sender_name') }}</th>
                                        <th>{{ __('books.sender_phone') }}</th>
                                        <th>{{ __('books.sender_area') }}</th>
                                        <th>{{ __('books.status') }}</th>
                                        <th>{{ __('books.sender_address') }}</th>
                                        <th>{{ __('books.order_num') }}</th>
                                        <th>{{ __('books.book_name') }}</th>
                                        <th>{{ __('books.student_phone') }}</th>
                                        <th>{{ __('books.sender_email') }}</th>
                                        <th>{{ __('books.action') }}</th>
                                    </tr>
                                    </thead>
                                </table> --}}
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
                
                {data: 'sender_name', name: 'sender_name',orderable: false,searchable: false},
                {data: 'sender_phone', name: 'sender_phone',orderable: false,searchable: false},
                {data: 'sender_area', name: 'sender_area',orderable: false,searchable: false},
                {data: 'status', name: 'status'},
                {data: 'sender_address', name: 'sender_address',orderable: false,searchable: false},
                {data: 'number', name: 'number'},
                {data: 'book_name', name: 'book_name',orderable: false,searchable: false},
                {data: 'student_phone', name: 'student_phone',orderable: false,searchable: false},
                {data: 'sender_email', name: 'sender_email',orderable: false,searchable: false},
                {data: 'actions',name: 'actions',orderable: false,searchable: false},

            ],  columnDefs: [
                @canany('orders.show','orders.delete','orders.changeToConfirmed','orders.changeToCanceled')
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
                @endcanany

            ]
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
        $('body').on('click', '.update_status', function() {
            var url = $(this).attr('data-url');
            var id = $(this).attr('data-order_id');
            $('#updateStatusForm').attr('action', url)
            $('#order_id').val(id)
            $('#modalUpdateStatus').modal('show')
            return false;
        })
    </script>
@endpush
