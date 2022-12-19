@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('tracks.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('admin.tracks.update', $item->id) : route('admin.tracks.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('tracks.actions.edit') : __('tracks.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('tracks.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-7  @error('name') is-invalid @enderror">
                            <label class="form-label" for="name">{{ __('tracks.default.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder=""
                                   value="{{ $item->name ?? old('name') }}" required/>
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-1"></div>
                        <div class="mb-1 col-md-3  @error('active') is-invalid @enderror">
                            <label class="form-label" for="active">{{ __('tracks.active') }}</label>
                            <input type="checkbox" name="active" id="active" class="form-check-input form-control" placeholder=""
                                   value="1" @checked(old('active', $item->active ?? 1)) style="height:40px;width:35px" />
                            @error('active')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
