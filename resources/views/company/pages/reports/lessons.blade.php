@extends('teacher.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.lessons_report') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.lessons_report') }}</span>
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
                    <form action="{{ route('teacher.reports.download_lessons_report') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="mb-3 col-md-4 @error('classroom_id') is-invalid @enderror">
                                <label class="form-label" for="classroom_id">{{ __('admin.classroom') }}</label>
                                <select name="classroom_id" id="classroom_id" class="form-control form-control-sm">
                                    <option value="">{{ __('admin.select') }}</option>
                                    @foreach($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <button  class="btn btn-primary btn-sm w-100 btn-filter" style="margin-top: 28px">{{ __('admin.export_report') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
            </div>
        </div>
    </div>
@stop
