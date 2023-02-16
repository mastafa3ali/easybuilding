@extends('company.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('products.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('company.product_ssale.update', $item->id) : route('company.product_ssale.store') }}">
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
                                   value="{{ $item->name ?? old('name') }}" />
                            @error('name')
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
                        <input type="hidden" name="type" value="1" />
                       <div class="mb-1 col-md-4 @error('image') is-invalid @enderror">
                            <label class="form-label" for="image">{{ __('products.main_image') }}</label>
                            <input type="file" class="form-control input" name="image" id="image">
                            @error('image')
                            <span class="error">{{ $message }}</span>
                            @enderror
                            <div>
                                <br>
                                @if(isset($item) && !empty($item->photo))
                                    <img src="{{ $item->photo }}" class="img-fluid img-thumbnail">
                                @endif
                            </div>
                        </div>
                        <div class="mb-1 col-md-4 @error('images') is-invalid @enderror">
                            <label class="form-label" for="images">{{ __('products.images') }}</label>
                            <input type="file" class="form-control input" name="images[]" id="images" multiple>
                            @error('images')
                            <span class="error">{{ $message }}</span>
                            @enderror
                            <div>
                                <br>
                                @if(isset($item) && !empty($item->photos))
                                @foreach ($item->photos as $photo)
                                <img src="{{ $photo }}" class="img-fluid img-thumbnail" width="100px">
                                @endforeach
                                @endif
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
@push('scripts')
    <script>
    $(window).on('load', function() {

        $('body').on('change', '.select_type', function (){
            var type= $(this).val();
            if(type==1){
                $("#guarantee_amount_section").hide(500);
            }
            if(type==2){
                $("#guarantee_amount_section").show(500);
            }
            return false;
        });
    })
</script>
@endpush
