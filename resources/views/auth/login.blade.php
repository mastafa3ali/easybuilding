@extends('website.layouts.master')

@section('content')
      <div class="section-padding" style="background-color: #cceedd">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h1 class="text-center">تسجيل الدخول على المنصة</h1>
                <div class="bordered rounded p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3 @error('phone') is-invalid @enderror">
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="{{ __('front.phone') }}" value="{{ old('phone') }}" required>
                            @error('phone')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 @error('password') is-invalid @enderror">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('front.password') }}" required>
                            @error('password')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                        </div>
                        <div class="form-group">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-gradient-green rounded">دخول</button>
                                @if (Route::has('password.request'))
                                    <a class="btn link-btn forgot-link" href="{{ route('password.request') }}">
                                        {{ __('front.reset_password') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
@endsection
