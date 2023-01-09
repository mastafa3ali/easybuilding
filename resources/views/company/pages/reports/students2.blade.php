@extends('teacher.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.students_report') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.students_report') }}</span>
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
            <div class="card-body">
                <div class="bordered p-3 rounded-7 bold">
                    <form action="{{ route('teacher.reports.download_student_report2') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="mb-3 col-md-9 @error('classroom_id') is-invalid @enderror">
                                        <label class="form-label" for="classroom_id">{{ __('admin.classroom') }}</label>
                                        <select name="classroom_id" id="classroom_id" class="form-control form-control-sm">
                                            <option value="">{{ __('admin.select') }}</option>
                                            @foreach($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-9 @error('type') is-invalid @enderror">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="f_section" name="filter_type" value="section">
                                                <label class="form-check-label" for="f_section">{{ __('admin.filter_by_sections') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="f_lesson" name="filter_type" value="lesson" checked>
                                                <label class="form-check-label" for="f_lesson">{{ __('admin.filter_by_lessons') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-9">
                                        <button type="button" class="btn btn-primary btn-sm w-100 btn-filter" style="margin-top: 28px">{{ __('admin.filter') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">{{ __('admin.select_lessons_or_sections') }}</label>
                                <hr>
                                <div id="lessons"></div>
                                <div class="text-left">
                                    <button class="btn btn-primary btn-sm" style="margin-top: 28px">{{ __('admin.export_report') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $(function() {
            $('.btn-filter').on('click', function (e) {
                var classroom_id = $('#classroom_id').val();
                var filter_type = $('input[name="filter_type"]:checked').val();

                var url = "{{ route('teacher.my_lessons') }}";

                if (filter_type == 'section') {
                    var url = "{{ route('teacher.my_sections') }}";
                }
                $.ajax({
                    type:'GET',
                    url:url,
                    data:{classroom_id:classroom_id,filter_type:filter_type},
                    success:function(data){
                        $('#lessons').html(data);
                    }
                });
            });
        })
    </script>
@endpush
