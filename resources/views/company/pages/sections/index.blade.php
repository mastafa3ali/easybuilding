@extends('teacher.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('sections.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('sections.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
            <div class="mb-1 breadcrumb-right">
                @can('sections.create')
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('teacher.sections.create') }}">
                        <i data-feather="plus"></i>
                        <span class="active-sorting text-primary">{{ __('sections.actions.create') }}</span>
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
                        <th>{{ __('sections.default.name') }}</th>
                        <th>{{ __('sections.course') }}</th>
                        <th>{{ __('sections.price') }}</th>
                        <th>{{ __('sections.infinity_price') }}</th>
                        <th>{{ __('sections.students_count') }}</th>
                        <th>{{ __('sections.total') }}</th>
                        <th width="15%" class="text-center">{{ __('sections.options') }}</th>
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
                url: "{{ route('teacher.sections.list') }}",
                data: function (d) {
                    d.name   = $('#filterForm #name').val();
                    d.course_id    = $('#filterForm #course_id').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'name', name: 'name'},
                {data: 'course', name: 'course_id'},
                {data: 'price', name: 'price'},
                {data: 'infinity_price', name: 'infinity_price'},
                {data: 'students_sum', name: 'students_sum',orderable: false,searchable: false},
                {data: 'amount_sum', name: 'amount_sum',orderable: false,searchable: false},
                {data: 'actions',name: 'actions',orderable: false,searchable: false},
            ],
            columnDefs: [
                {
                    "targets": -1,
                    "render": function (data, type, row) {
                    var editUrl = '{{ route("teacher.sections.edit", ":id") }}';
                    editUrl = editUrl.replace(':id', row.id);

                    var deleteUrl = '{{ route("teacher.sections.destroy", ":id") }}';
                    deleteUrl = deleteUrl.replace(':id', row.id);

                    return `
                               <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical" class="font-medium-2"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="`+editUrl+`">
                                        <i data-feather="edit-2" class="font-medium-2"></i>
                                            <span>{{ __('sections.actions.edit') }}</span>
                                        </a>
                                        <a class="dropdown-item delete_item" data-url="`+deleteUrl+`" href="#">
                                            <i data-feather="trash" class="font-medium-2"></i>
                                             <span>{{ __('sections.actions.delete') }}</span>
                                        </a>
                                    </div>
                               </div>
                        `;
                    }
                }
            ],
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush
