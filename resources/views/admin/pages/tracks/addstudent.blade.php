@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('track.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data" 
          action="{{  route('admin.tracks.storeTrackStudents',$item->id) }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ $item->name }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('track.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?php $studentsTrack=$item->studentsTrack()->pluck('student_id')->toArray(); ?>
                        @foreach ($students as $student)
                            
                        <div class="mb-1 col-md-6  @error('student_id') is-invalid @enderror">
                            <label class="form-label" for="student_id">{{ $student->name }}</label>
                        </div>       
                        <div class="mb-1 col-md-2  @error('student_id') is-invalid @enderror">
                            <input type="checkbox" name="student_id[]"  class="form-check-input form-control" placeholder=""
                            value="{{ $student->id }}" {{ in_array($student->id,$studentsTrack)?'checked':'' }} style="height:37px;width:35px" />
                            @error('student_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <hr>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
