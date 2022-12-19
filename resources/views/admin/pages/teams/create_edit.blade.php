@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('subjects.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('admin.teams.update', $item->id) : route('admin.teams.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('subjects.actions.edit') : __('subjects.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('subjects.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4  @error('title') is-invalid @enderror">
                            <label class="form-label" for="title">{{ __('teams.default.name') }}</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder=""
                                   value="{{ $item->title ?? old('title') }}" required/>
                            @error('title')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('type') is-invalid @enderror">
                            <label class="form-label">{{ __('teams.type') }}</label>
                            <select class="form-control input" name="type">
                                <option value="">{{ __('teams.select') }}</option>
                                    <option value="1" {{ isset($item)?($item->type==1 ? 'selected' : ''):'' }}>{{ __('teams.types.1') }}</option>
                                    <option value="2" {{ isset($item)?($item->type==2 ? 'selected' : ''):'' }}>{{ __('teams.types.2') }}</option>
                                    <option value="3" {{ isset($item)?($item->type==3 ? 'selected' : ''):'' }}>{{ __('teams.types.3') }}</option>
                            </select>
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4 @error('image') is-invalid @enderror">
                            <label class="form-label" for="image">{{ __('teams.file') }}</label>
                            <input type="file" class="form-control input" name="image" id="image">
                            @error('image')
                            <span class="error">{{ $message }}</span>
                            @enderror
                            <div>
                                <br>
                                @if(isset($item) && !empty($item->image))
                                    <img src="{{ $item->photo }}"
                                         class="img-fluid img-thumbnail">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
