@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('readingcycles.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('readingcycles.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
            <div class="mb-1 breadcrumb-right">
                @can('readingcycles.create')
                    <div class="dropdown">
                        <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('admin.readingcycles.create') }}">
                            <i data-feather="plus"></i>
                            <span class="active-sorting text-primary">{{ __('readingcycles.actions.create') }}</span>
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-datatable">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('readingcycles.default.name') }}</th>
                        <th>{{ __('readingcycles.track') }}</th>
                        <th>{{ __('readingcycles.supervisor') }}</th>
                        <th>{{ __('readingcycles.active') }}</th>
                        <th>{{ __('readingcycles.created_by') }}</th>
                        @canany('readingcycles.edit','readingcycles.delete')
                            <th width="15%" class="text-center">{{ __('readingcycles.options') }}</th>
                        @endcanany
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
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
            lengthMenu: [[10, 50, 100,500, -1], [10, 50, 100,500, "All"]],
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            ajax: {
                url: "{{ route('admin.readingcycles.list') }}",
                data: function (d) {
                    d.name   = $('#filterForm #name').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'name', name: 'name'},
                {data: 'track', name: 'track',orderable: false,searchable: false},
                {data: 'supervisor', name: 'supervisor',orderable: false,searchable: false},
                {data: 'active', name: 'active',orderable: false,searchable: false},
                {data: 'created_by', name: 'created_by',orderable: false,searchable: false},
                    @canany('readingcycles.edit','readingcycles.delete')
                {data: 'actions',name: 'actions',orderable: false,searchable: false},
                @endcanany
            ],
            columnDefs: [
              
                @canany('readingcycles.edit','readingcycles.delete')
                {
                    "targets": -1,
                    "render": function (data, type, row) {
                        var addStudentUrl = '{{ route("admin.readingcycles.addStudent", ":id") }}';
                        addStudentUrl = addStudentUrl.replace(':id', row.id);

                        var editUrl = '{{ route("admin.readingcycles.edit", ":id") }}';
                        editUrl = editUrl.replace(':id', row.id);

                        var deleteUrl = '{{ route("admin.readingcycles.destroy", ":id") }}';
                        deleteUrl = deleteUrl.replace(':id', row.id);

                        return `
                               <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical" class="font-medium-2"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('readingcycles.addStudent')
                        <a class="dropdown-item" href="`+addStudentUrl+`">
                                        <i data-feather="send" class="font-medium-2"></i>
                                            <span>{{ __('readingcycles.actions.addStudent') }}</span>
                                        </a>
                                        @endcan
                                        @can('readingcycles.edit')
                        <a class="dropdown-item" href="`+editUrl+`">
                                        <i data-feather="edit-2" class="font-medium-2"></i>
                                            <span>{{ __('readingcycles.actions.edit') }}</span>
                                        </a>
                                        @endcan
                        @can('readingcycles.delete')
                        <a class="dropdown-item delete_item" data-url="`+deleteUrl+`" href="#">
                                            <i data-feather="trash" class="font-medium-2"></i>
                                             <span>{{ __('readingcycles.actions.delete') }}</span>
                                        </a>
                                        @endcan
                        </div>
                   </div>
                    `;
                    }
                }
                @endcanany
            ],
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush
