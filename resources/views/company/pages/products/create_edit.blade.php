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
                                    data-ajax--cache="true">
                                @isset($item->product)
                                    <option value="{{ $item->product->id }}" selected>{{ $item->product->name }}</option>
                                @endisset
                            </select>
                            @error('product_id')
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
                        <div class="mb-1 col-md-4  @error('guarantee_amount') is-invalid @enderror" id="guarantee_amount_section" style="{{ $display }}">
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
