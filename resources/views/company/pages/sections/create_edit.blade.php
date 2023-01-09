@extends('teacher.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('sections.plural') }}</title>
@endsection
@section('content')
      <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('teacher.sections.update', $item->id) : route('teacher.sections.store') }}">
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
                        <div class="mb-1 col-md-4 @error('course_id') is-invalid @enderror">
                            <label class="form-label" for="course_id">{{ __('sections.subject') }}</label>
                            <select name="course_id" id="course_id" class="form-control ajax_select2"
                                    data-ajax--url="{{ route('teacher.courses.select') }}"
                                    data-ajax--cache="true">
                                @isset($item->course)
                                    <option value="{{ $item->course->id }}">{{ $item->course->name }}</option>
                                @endisset
                            </select>
                            @error('course_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('name') is-invalid @enderror">
                            <label class="form-label" for="name">{{ __('sections.default.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder=""
                                   value="{{ $item->name ?? old('name') }}" required/>
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('price') is-invalid @enderror">
                            <label class="form-label">{{ __('sections.price') }}</label>
                            <input class="form-control" name="price" type="number" value="{{ $item->price ?? old('price') }}">
                            @error('price')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('infinity_price') is-invalid @enderror">
                            <label class="form-label">{{ __('sections.infinity_price') }}</label>
                            <input class="form-control" name="infinity_price" type="number" value="{{ $item->infinity_price ?? old('infinity_price') }}">
                            @error('infinity_price')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('discount') is-invalid @enderror">
                            <label class="form-label">{{ __('admin.discount') }}</label>
                            <input class="form-control" name="discount" type="number" value="{{ $item->discount ?? old('discount') }}">
                            @error('discount')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('price2') is-invalid @enderror">
                            <label class="form-label">{{ __('sections.price2') }}</label>
                            <input class="form-control" name="price2" type="number" value="{{ $item->price2 ?? old('price2') }}">
                            @error('price2')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('rank') is-invalid @enderror">
                            <label class="form-label">الترتيب</label>
                            <input class="form-control" name="rank" type="number" value="{{ $item->rank ?? old('rank') }}">
                            @error('rank')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('published') is-invalid @enderror">
                            <label class="form-label">{{ __('courses.publish') }}</label>
                                <?php $published = $item->published ?? old('published'); ?>
                            <select class="form-control form-select" name="published" id="published">
                                <option value="0" {{ $published != 1 ? 'selected': '' }}>{{ __('courses.draft') }}</option>
                                <option value="1" {{ $published == 1 ? 'selected': '' }}>{{ __('courses.publish') }}</option>
                            </select>
                            @error('published')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12"></div>
                        <div class="mb-1 col-md-12 @error('description') is-invalid @enderror">
                            <label class="form-label" for="description">{{ __('sections.description') }}</label>
                            <textarea rows="6" name="description" id="description" class="form-control" placeholder=""
                            >{{ $item->description ?? old('description') }}</textarea>
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
