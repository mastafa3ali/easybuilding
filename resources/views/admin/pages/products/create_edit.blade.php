@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('products.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('admin.products.update', $item->id) : route('admin.products.store') }}">
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
                         <div class="mb-1 col-md-4  @error('category_id') is-invalid @enderror">
                            <label class="form-label" for="category_id">{{ __('products.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('admin.categories.select') }}"
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
                            <select name="type" id="type" class="form-control  select_type">
                                    <option value="1" {{ isset($item)?($item->type==1?'selected':''):(old('type')==1?'selected':'') }} >{{ __('products.types.1') }}</option>
                                    <option value="2" {{ isset($item)?($item->type==2?'selected':''):(old('type')==2?'selected':'') }} >{{ __('products.types.2') }}</option>
                            </select>
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                         <div class="mb-1 col-md-4  @error('sub_category_id') is-invalid @enderror" id="sub_category_id_section" style="{{ $display }}">
                            <label class="form-label" for="sub_category_id">{{ __('products.sub_category') }}</label>
                            <select name="sub_category_id" id="sub_category_id" class="form-control ">
                                @isset($item->subcategory)
                                    <option value="{{ $item->subcategory->id }}" selected>{{ $item->subcategory->name }}</option>
                                @endisset
                            </select>
                            @error('sub_category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4 @error('image') is-invalid @enderror">
                            <label class="form-label" for="image">{{ __('sliders.file') }}</label>
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
                    </div>
                    <div class="row">

                        <div class="mb-1 col-md-12  @error('description') is-invalid @enderror">
                            <label class="form-label" for="description">{{ __('products.description') }}</label>
                            <textarea name="description" id="description" class="form-control" placeholder="">{{ $item->description ?? old('description') }}</textarea>
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
                $("#sub_category_id_section").hide(500);
            }
            if(type==2){
                $("#sub_category_id_section").show(500);
            }
            return false;
        });

         $(document).on('change', '#category_id', function(){
            var category_id = $(this).val();
            $('#sub_category_id').html('');
            console.log(category_id);
            $.ajax({
                type:'GET',
                url:"{{ route('admin.sub_categories.select') }}",
                data:{category_id:category_id,pure_select:true},
                success:function(data){
                    $('#sub_category_id').html(data);
                }
            });
        })
    })
</script>
@endpush
