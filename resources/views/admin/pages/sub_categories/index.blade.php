@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('sub_categories.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('sub_categories.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
            <div class="mb-1 breadcrumb-right">

            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-datatable">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('sub_categories.default.name') }}</th>
                        <th>{{ __('sub_categories.category') }}</th>
                        <th>{{ __('categories.sort') }}</th>
                        <th>{{ __('sub_categories.image') }}</th>
                            <th width="15%" class="text-center">{{ __('sub_categories.options') }}</th>
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
                url: "{{ route('admin.sub_categories.list') }}",
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
                {data: 'category', name: 'category'},
                {data: 'sort', name: 'sort'},
                {data: 'photo', name: 'photo'},
                {data: 'actions',name: 'actions',orderable: false,searchable: false},
            ],
            columnDefs: [

                {
                    "targets": -1,
                    "render": function (data, type, row) {
                         var editUrl = '{{ route("admin.sub_categories.edit", ":id") }}';
                         editUrl = editUrl.replace(':id', row.id);
                           return `  <a class="dropdown-item" href="`+editUrl+`">
                            <i data-feather="edit-2" class="font-medium-2"></i>
                                <span>{{ __('sub_categories.actions.edit') }}</span>
                            </a>`;
                        //  var editUrl = '{{ route("admin.sub_categories.edit", ":id") }}';
                        //  editUrl = editUrl.replace(':id', row.id);

                        //  var deleteUrl = '{{ route("admin.sub_categories.destroy", ":id") }}';
                        //  deleteUrl = deleteUrl.replace(':id', row.id);

                        //  return `
                        //         <div class="dropdown">
                        //              <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                        //                      <i data-feather="more-vertical" class="font-medium-2"></i>
                        //              </button>
                        //              <div class="dropdown-menu">
                        //                  @can('sub_categories.edit')
                        //                  <a class="dropdown-item" href="`+editUrl+`">
                        //                  <i data-feather="edit-2" class="font-medium-2"></i>
                        //                      <span>{{ __('sub_categories.actions.edit') }}</span>
                        //                  </a>
                        //                  @endcan
                        //                  @can('sub_categories.delete')
                        //                  <a class="dropdown-item delete_item" data-url="`+deleteUrl+`" href="#">
                        //                      <i data-feather="trash" class="font-medium-2"></i>
                        //                       <span>{{ __('sub_categories.actions.delete') }}</span>
                        //                  </a>
                        //                  @endcan
                        //              </div>
                        //          </div>
                        //     `;
                    }
                }
            ],
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush
