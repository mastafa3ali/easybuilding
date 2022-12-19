<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/front') }}/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="{{ asset('assets/front') }}/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/front') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link href="{{ asset('assets/front') }}/css/style.css?v={{ date('His') }}" rel="stylesheet">
    <link href="{{ asset('assets/front') }}/css/rtl.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/apexcharts/apexcharts.css">
    <link rel="icon" type="image/png" href="{{ asset('assets/front') }}/images/favicon.png" />
    @stack('styles')
    <title>{{ config('app.name') }}</title>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-R79SKJ9L03"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-R79SKJ9L03');
    </script>
</head>
<body>
<div class="container">
    <div class="text-center mt-3">
        <a class="navbar-brand" href="{{ route('login') }}">
            <img class="img-fluid" src="{{ asset('assets/front') }}/images/logo.png">
        </a>
    </div>
    @include('flash::message')

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row my-3">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="bordered rounded p-4">
                    <div class="row">
                        <div class="mb-3 col-md-6 @error('name') is-invalid @enderror">
                            <label class="form-label fw-bold">{{ __('students.name') }}</label>
                            <input class="form-control font-16" name="name" type="text" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="mb-3 col-md-6 @error('national_id') is-invalid @enderror">
                            <label class="form-label fw-bold">{{ __('students.national_id') }}</label>
                            <input class="form-control font-16" name="national_id" type="text" value="{{ old('national_id') }}">
                            @error('national_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="mb-3 col-md-6 @error('phone') is-invalid @enderror">
                            <label class="form-label fw-bold">{{ __('students.phone') }}</label>
                            <input class="form-control font-16" name="phone" type="text" value="{{ old('phone') }}">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6 @error('parent_phone') is-invalid @enderror">
                            <label class="form-label fw-bold">{{ __('students.parent_phone') }}</label>
                            <input class="form-control font-16" name="parent_phone" type="text" value="{{ old('parent_phone') }}">
                            @error('parent_phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6 @error('email') is-invalid @enderror">
                            <label class="form-label fw-bold">{{ __('students.email') }}</label>
                            <input class="form-control font-16 input" name="email"  placeholder="" type="email" value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6 @error('gender') is-invalid @enderror">
                            <label class="form-label fw-bold">{{ __('students.gender') }}</label>
                            <?php $gender= old('gender'); ?>
                            <select class="form-control font-16 input" name="gender">
                                <option value="m" {{ $gender == 'm' ? 'selected' : '' }}>{{ __('students.male') }}</option>
                                <option value="f" {{ $gender == 'f' ? 'selected' : '' }}>{{ __('students.female') }}</option>
                            </select>
                            @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6 @error('password') is-invalid @enderror">
                            <label class="form-label fw-bold">{{ __('users.password') }}</label>
                            <input class="form-control font-16 input" name="password"  placeholder="" type="password">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6 @error('password_confirmation') is-invalid @enderror">
                            <label class="form-label fw-bold">تأكيد كلمة المرور</label>
                            <input class="form-control font-16 input" name="password_confirmation"  placeholder="" type="password">
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6 @error('classroom_id') is-invalid @enderror">
                            <label class="form-label" for="classroom_id">{{ __('students.classroom') }}</label>
                            <?php $classroomId= old('classroom_id'); ?>
                            <select name="classroom_id" id="classroom_id" class="form-control font-16">
                                <option value="">اختر</option>
                                @foreach(\App\Models\ClassRoom::all() as $classroom)
                                    <option value="{{ $classroom->id }}" @selected($classroomId == $classroom->id)>{{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            @error('classroom_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6 @error('state_id') is-invalid @enderror">
                            <label class="form-label" for="state_id">{{ __('students.state') }}</label>
                            <?php $stateId= old('state_id'); ?>
                            <select name="state_id" id="state_id" class="form-control font-16">
                                <option value="">اختر</option>
                                @foreach(\App\Models\City::all() as $city)
                                    <option value="{{ $city->id }}" @selected($stateId == $city->id)>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="mb-3 col-md-12 @error('address') is-invalid @enderror">
                            <label class="form-label fw-bold">{{ __('users.address') }}</label>
                            <textarea class="form-control font-16 input" name="address">{{ old('address') }}</textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-gradient-green rounded">تسجيل</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </form>
</div>
<script src="{{ asset('assets/admin') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets/front') }}/js/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="{{ asset('assets/front') }}/js//bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="{{ asset('assets/admin') }}/plugins/apexcharts/apexcharts.js"></script>
@stack('scripts')
</body>
</html>
