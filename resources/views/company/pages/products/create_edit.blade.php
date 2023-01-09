@extends('company.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('products.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('company.products.update', $item->id) : route('company.products.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('products.actions.edit') : __('products.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('products.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4  @error('name') is-invalid @enderror">
                            <label class="form-label" for="name">{{ __('products.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder=""
                                   value="{{ $item->name ?? old('name') }}" required/>
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('guarantee_amount') is-invalid @enderror">
                            <label class="form-label" for="guarantee_amount">{{ __('products.guarantee_amount') }}</label>
                            <input type="number" name="guarantee_amount" id="guarantee_amount" class="form-control" placeholder=""
                                   value="{{ $item->guarantee_amount ?? old('guarantee_amount') }}" />
                            @error('guarantee_amount')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-1 col-md-4  @error('price') is-invalid @enderror">
                            <label class="form-label" for="price">{{ __('products.price') }}</label>
                            <input type="number" name="price" id="price" class="form-control" placeholder=""
                                   value="{{ $item->price ?? old('price') }}" />
                            @error('price')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                       
                        <div class="mb-1 col-md-4  @error('category_id') is-invalid @enderror">
                            <label class="form-label" for="category_id">{{ __('products.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('company.categories.select') }}"
                                    data-ajax--cache="true">
                                @isset($item->category)
                                    <option value="{{ $item->category->id }}" selected>{{ $item->category->title }}</option>
                                @endisset
                            </select>
                            @error('category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('type') is-invalid @enderror">
                            <label class="form-label" for="type">{{ __('products.type') }}</label>
                            <select name="type" id="type" class="form-control  ">
                                    <option value="1" {{ isset($item)?($item->type==1?'selected':''):(old('type')==1?'selected':'') }} >{{ __('products.types.1') }}</option>
                                    <option value="2" {{ isset($item)?($item->type==2?'selected':''):(old('type')==2?'selected':'') }} >{{ __('products.types.2') }}</option>
                            </select>
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('properties') is-invalid @enderror">
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
                    </div>
                    <div class="row">
                         <div class="mb-1 col-md-12  @error('description') is-invalid @enderror">
                            <label class="form-label" for="description">{{ __('products.description') }}</label>
                            <textarea type="number" name="description" id="description" class="form-control" placeholder="">{{ $item->description ?? old('description') }}</textarea>
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
