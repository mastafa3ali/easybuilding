@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('sub_categories.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('admin.sub_categories.update', $item->id) : route('admin.sub_categories.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('sub_categories.actions.edit') : __('sub_categories.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('sub_categories.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4  @error('name_en') is-invalid @enderror">
                            <label class="form-label" for="name_en">{{ __('admin.title_en') }}</label>
                            <input type="text" name="name_en" id="name_en" class="form-control" placeholder=""
                                   value="{{ $item->name_en ?? old('name_en') }}" required/>
                            @error('name_en')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('name_ar') is-invalid @enderror">
                            <label class="form-label" for="name_ar">{{ __('admin.title_ar') }}</label>
                            <input type="text" name="name_ar" id="name_ar" class="form-control" placeholder=""
                                   value="{{ $item->name_ar ?? old('name_ar') }}" required/>
                            @error('name_ar')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @if(!isset($item))
                        <div class="mb-1 col-md-4  @error('category_id') is-invalid @enderror">
                            <label class="form-label" for="category_id">{{ __('products.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('admin.categories.select') }}"
                                    data-ajax--cache="true" required>
                                @isset($item->category)
                                    <option value="{{ $item->category?->id }}" selected>{{ $item->category?->title }}</option>
                                @endisset
                            </select>
                            @error('category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="mb-1 col-md-6  @error('sort') is-invalid @enderror">
                            <label class="form-label" for="sort">{{ __('categories.sort') }}</label>
                            <input type="number" name="sort" id="sort" class="form-control" placeholder=""
                                   value="{{ $item->sort ?? old('sort') }}" required/>
                            @error('sort')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         @if(!isset($item))

                        <div class="mb-1 col-md-4  @error('properties') is-invalid @enderror" >
                            <label class="form-label" for="properties">{{ __('products.property') }}</label>
                            <select name="properties" id="properties" class="form-control  ">
                                    <option value="1" {{ isset($item)?($item->properties==1?'selected':''):(old('properties')==1?'selected':'') }} >{{ __('products.properties.1') }}</option>
                                    <option value="2" {{ isset($item)?($item->properties==2?'selected':''):(old('properties')==2?'selected':'') }} >{{ __('products.properties.2') }}</option>
                                    <option value="3" {{ isset($item)?($item->properties==3?'selected':''):(old('properties')==3?'selected':'') }} >{{ __('products.properties.3') }}</option>
                            </select>
                            @error('properties')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="mb-1 col-md-4 @error('image') is-invalid @enderror">
                            <label class="form-label" for="image">{{ __('sub_categories.file') }}</label>
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
