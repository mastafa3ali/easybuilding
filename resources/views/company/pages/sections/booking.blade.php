@extends('teacher.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | الوحده / الباب</title>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="bordered p-3 rounded-7 bold">
                <div class="row">
                    <div class="col-md-6">
                        <span>{{ __('sections.section_name') }}</span> : <span>{{ $section->name }}</span><br>
                    </div>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm text-fade table-hover nowrap w-100" id="DataTables_Table_0" role="grid">
                    <thead>
                    <tr role="row">
                        <th style="width: 31px;"></th>
                        <th>{{ __('sections.student_name') }}</th>
                        <th>{{ __('sections.student_phone') }}</th>
                        <th>{{ __('sections.start_date') }}</th>
                        <th>{{ __('sections.end_date') }}</th>
                        <th style="width: 50px;">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;?>
                    @foreach($items as $key => $item)
                        <tr>
                            <td class="sorting_1">
                                {{ $i++ }}
                            </td>
                            <td>{{ $item->user->name ?? '' }}</td>
                            <td>{{ $item->user->phone ?? '' }}</td>
                            <td>{{ $item->start_date }}</td>
                            <td>{{ $item->end_date }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
