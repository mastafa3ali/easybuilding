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
                         <div class="mb-1 col-md-4  @error('product_id') is-invalid @enderror">
                            <label class="form-label" for="product_id">{{ __('products.name') }}</label>
                            <select name="product_id" id="product_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('company.products.select') }}"
                                    data-ajax--cache="true" required>
                                @isset($item->product)
                                    <option value="{{ $item->product->id }}" selected>{{ $item->product->name }}</option>
                                @endisset
                            </select>
                            @error('product_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('rent_type') is-invalid @enderror">
                            <label class="form-label" for="rent_type">{{ __('products.rent_type') }}</label>
                            <select name="rent_type" id="rent_type" class="form-control  extra_field" required>
                                <option value="1" {{ isset($item)? $item->rent_type==1?'selected':'':'' }}>{{ __('products.rent_types.1') }}</option>
                                <option value="2" {{ isset($item)? $item->rent_type==2?'selected':'':'' }}>{{ __('products.rent_types.2') }}</option>
                                <option value="3" {{ isset($item)? $item->rent_type==3?'selected':'':'' }}>{{ __('products.rent_types.3') }}</option>
                                <option value="4" {{ isset($item)? $item->rent_type==4?'selected':'':'' }}>{{ __('products.rent_types.4') }}</option>
                                <option value="5" {{ isset($item)? $item->rent_type==5?'selected':'':'' }}>{{ __('products.rent_types.5') }}</option>

                            </select>
                            @error('rent_type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <input type="hidden" name="type" value="2" />
                        <div class="mb-1 col-md-2  @error('guarantee_amount') is-invalid @enderror" id="guarantee_amount_section">
                            <label class="form-label" for="guarantee_amount">{{ __('products.guarantee_amount') }}</label>
                            <input type="text" name="guarantee_amount" id="guarantee_amount" class="form-control" placeholder=""
                                   value="{{ $item->guarantee_amount ?? old('guarantee_amount') }}" required />
                            @error('guarantee_amount')
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

                        <div class="mb-1 col-md-4  @error('price') is-invalid @enderror">
                            <label class="form-label" for="price">{{ __('products.main_price') }}</label>
                            <input type="text" name="price" id="price" class="form-control" placeholder=""
                                   value="{{ $item->price ?? old('price') }}" step=".5" required/>
                            @error('price')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
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
                    <div class="row" id="other_price" >
                        <h2>{{ __('products.other_price') }}</h2>
                        <div class="mb-1 col-md-4  @error('price_2') is-invalid @enderror">
                            <label class="form-label" for="price_2">{{ __('products.price_2') }}</label>
                            <input type="text" name="price_2" id="price_2" class="form-control" placeholder=""
                            value="{{ $item->price_2 ?? old('price_2') }}" step=".5"/>
                            @error('price_2')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('price_3') is-invalid @enderror">
                            <label class="form-label" for="price_3">{{ __('products.price_3') }}</label>
                            <input type="text" name="price_3" id="price_3" class="form-control" placeholder=""
                            value="{{ $item->price_3 ?? old('price_3') }}" step=".5" />
                            @error('price_3')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('price_4') is-invalid @enderror">
                            <label class="form-label" for="price_4">{{ __('products.price_4') }}</label>
                            <input type="text" name="price_4" id="price_4" class="form-control" placeholder=""
                            value="{{ $item->price_4 ?? old('price_4') }}" step=".5" />
                            @error('price_4')
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
        checkPrice();
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

        $('body').on('change', '#product_id', function (){
            checkPrice();
        });

    });

    function checkPrice(){

        var product_id = $("#product_id").val();
            $('#other_price').hide();
            $.ajax({
                type:'GET',
                url:"{{ route('company.products.check') }}",
                data:{product_id:product_id},
                success:function(data){
                    console.log(data);
                    if(data==1){
                        $('#other_price').show();
                    }
                }
            });

    }

</script>
@endpush
