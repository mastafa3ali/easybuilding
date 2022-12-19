@extends('website.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('assignments.plural') }}</title>
@endsection
@section('content')
  <!-- .wpo-breadcumb-area start -->
        <div class="wpo-breadcumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="wpo-breadcumb-wrap">
                            <h2>{{ __('site.about_ghaith') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .wpo-breadcumb-area end -->
        <!-- wpo-about-area start -->
        <div class="wpo-about-area-3 section-padding">
            <div class="container">
                <div class="wpo-about-wrap">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="wpo-about-img-3">
                            <?php $aboutImage = $items->where('key', 'about_image')->first()->value ?? old('settings.image'); ?>
                                @if( !empty($aboutImage))
                                <img src="{{  asset('storage/settings/' .$aboutImage) }}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 colsm-12">
                            <div class="wpo-about-text">
                                <div class="wpo-section-title">
                                    <span class="text-right">عن غيث</span>
                                    <h2 class="text-right">{{ $items->where('key', 'about_title')->first()->value??'' }}</h2>
                                </div>
                                <p>
                                    {!! $items->where('key', 'about_content')->first()->value??'' !!}
                                </p>
                                <div class="btns">
                                    <ul>
                                        <li class="video-holder">
                                            <a href="{{ $items->where('key', 'about_video_url')->first()->value??'' }}" class="video-btn" data-type="iframe" tabindex="0"></a>
                                        </li>
                                        <li class="video-text">
                                            <a href="{{ $items->where('key', 'about_video_url')->first()->value??'' }}" class="video-btn" data-type="iframe" tabindex="0">
                                               شاهدنا
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wpo-about-area end -->
        <!-- courses-area start -->
       <div class="courses-area">
           <div class="container">
               <div class="row">
                @foreach ($sections as $section)
                <div class="col-md-4 col-sm-6 custom-grid col-12">
                    <div class="courses-item">
                        <div class="course-icon">
                            <span><img src="/assets/images/icon1.png" alt=""></span>
                        </div>
                        <div class="course-text">
                            <h2>{{ $section->title }}</h2>
                            <p>{{ $section->description }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
               </div>
           </div>
       </div>
       <!-- courses-area start -->
       <div class="service-area-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="wpo-section-title">
                            <h2>ماذا نقدم</h2>
                        </div>
                    </div>
                </div>
                <div class="service-wrap">
                    <div class="row">
                        @foreach ($categories as $category)
                        <div class="col-lg-4 col-md-4 col-sm-6 custom-grid col-12">
                            <div class="service-single-item">
                                <div class="service-single-img">
                                    <img src="{{ $category->photo }}" alt="">
                                </div>
                                <div class="service-text">
                                    <h2><a href="#">{{ $category->title }}</a></h2>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="wpo-ne-footer">
            <!-- start wpo-site-footer -->
        @include('website.layouts.footer')
            <!-- end wpo-site-footer -->
        </div>
@stop


