@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('sections.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('admin.sections.update', $item->id) : route('admin.sections.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('sections.actions.edit') : __('sections.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('sections.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-12  @error('title') is-invalid @enderror">
                            <label class="form-label" for="title">{{ __('sections.default.name') }}</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder=""
                                   value="{{ $item->title ?? old('title') }}" required/>
                            @error('title')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-12">
                            <h5 class="column-title"><strong>{{ __('sections.description') }}</strong></h5>
                        </div>
                        <div class="mb-1 col-md-12 @error('description') is-invalid @enderror">
                            <label class="form-label" for="description">{{ __('sections.description') }}</label>
                            <textarea rows="5" name="description" id="description" class="form-control" placeholder="" >{{ $item->description ?? old('description') }}</textarea>
                            @error('description')
                            <span class="error">{{ $message }}</span>
                            @enderror
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
