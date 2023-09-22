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
                        <div class="mb-1 col-md-2  @error('price') is-invalid @enderror">
                            <label class="form-label" for="price">{{ __('products.price') }}</label>
                            <input type="string" name="price" id="price" class="form-control" placeholder=""
                                   value="{{ $item->price ?? old('price') }}" step=".5" />
                            @error('price')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-2  @error('available') is-invalid @enderror">
                            <br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="available"
                                        value="1" id="available"
                                    @checked($item->available ?? false )/>
                                <label class="form-check-label" for="available">{{ __('categories.available') }}</label>
                            </div>
                            @error('available')
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

                        <div class="mb-1 col-md-6  @error('description_en') is-invalid @enderror">
                            <label class="form-label" for="description_en">{{ __('admin.description_en') }}</label>
                            <textarea name="description_en" id="description_en" class="form-control" placeholder="">{{ $item->description_en ?? old('description_en') }}</textarea>
                            @error('description_en')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-6  @error('description_ar') is-invalid @enderror">
                            <label class="form-label" for="description_ar">{{ __('admin.description_ar') }}</label>
                            <textarea name="description_ar" id="description_ar" class="form-control" placeholder="">{{ $item->description_ar ?? old('description_ar') }}</textarea>
                            @error('description_ar')
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
