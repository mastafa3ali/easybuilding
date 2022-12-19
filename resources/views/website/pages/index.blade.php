@extends('website.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('assignments.plural') }}</title>
@endsection
@section('content')
     <!-- start of hero -->
        <section class="hero hero-style-1">
            <div class="hero-slider">
                @foreach ($sliders as $slider)
                <div class="slide">
                    <div class="container">
                        <img src="{{ $slider->photo }}" alt class="slider-bg">
                        <div class="row">
                            <div class="col col-md-8 col-md-offset-2 slide-caption">
                                <div class="slide-top">
                                    <span>{{ __('site.let_know_about_ghaith') }}</span>
                                </div>
                                <div class="slide-title">
                                    <h2>{{ $slider->title }}</h2>
                                </div>
                                <div class="btns">
                                    <a href="{{ route('about') }}" class="theme-btn">{{ __('site.more') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if (count($sliders)==0)
                    
                <div class="slide">
                    <div class="container">
                        <img src="{{ asset('site') }}/assets/images/slider/slide-2.jpg" alt class="slider-bg">
                        <div class="row">
                            <div class="col col-md-8 col-md-offset-2 slide-caption">
                                <div class="slide-top">
                                    <span>دعنا نعرف عن غيث</span>
                                </div>
                                <div class="slide-title">
                                    <h2>اقرأ! بسم ربك الذي خلق</h2>
                                </div>
                                <div class="btns">
                                    <a href="#" class="theme-btn">المزيد</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
            </div>
        </section>
        <!-- end of hero slider -->
        <!-- wpo-about-area start -->
        <div class="wpo-about-area-2 section-padding">
            <div class="container">
                <div class="wpo-about-wrap">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="wpo-about-img-3">
                                <img src="{{ asset('site') }}/assets/images/about.png" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="wpo-about-text">
                                <div class="wpo-section-title text-right">
                                    <span class="text-right">عن غيث</span>
                                    <h2 class="text-right">طلب العلم واجب على كل مسلم</h2>
                                </div>
                                <p>يهدف هذا المساق إلى مساعدة الطلاب على حفظ القرآن الكريم. الطلاب الذين يرغبون في حفظ جزء من القرآن أو كله.</p>
                                <div class="btns">
                                    <a href="about.html" class="theme-btn" tabindex="0">المزيد</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wpo-about-area end -->

        <!-- blog-area start -->
        <div class="blog-area section-padding">
            <div class="container">
                <div class="col-l2">
                    <div class="wpo-section-title">
                        <h2>فريق غيث</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($teams as $team)                        
                    <div class="col-lg-4 col-sm-6 col-12 custom-grid">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="{{ $team->photo }}" alt="">
                            </div>
                            <div class="blog-content">
                                <h3><div>{{ $team->title }}</div></h3>
                                <ul class="post-meta">
                                    
                                    <li><a href="#">{{ __('teams.types'.$team->type) }}</a></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- blog-area start -->
        <!-- footer-area start -->
        <div class="wpo-ne-footer">
            <!-- start wpo-news-letter-section -->
            <section class="wpo-news-letter-section">
                <div class="container">
                    <div class="wpo-news-letter-wrap">
                        <div class="row wpo-contact-form-map">
                            <div class="contact-form">
                                <h2>تواصل معانا</h2>
                                <form method="post" class="contact-validation-active" action="{{ route('contactus') }}" id="contact-form">
                                 @csrf
                              
                                    <div></div>
                                    <div></div>
                                    <div>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="الأسم">
                                    </div>
                                   
                                    <div class="clearfix">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="البريد الالكترونى">
                                    </div>
                                    <div>
                                        <input type="text" class="form-control" name="subject" id="subject"
                                            placeholder="الموضوع">
                                    </div>
                                    <div>
                                        <textarea class="form-control" name="note" id="note"
                                            placeholder="الرســالة"></textarea>
                                    </div>
                                    <div class="submit-area">
                                        <button type="submit" class="theme-btn submit-btn">إرسال رسالة</button>
                                        <div id="loader">
                                            <i class="ti-reload"></i>
                                        </div>
                                    </div>
                                       <div class="clearfix error-handling-messages">
                                        @if(Session::has('success'))                                        
                                        <div id="success" style="display: block">شكرًا لك سيم التواصل معك قريبا</div>
                                        @endif
                                            <div id="error"> حدث خطأ أثناء إرسال البريد الإلكتروني. الرجاء معاودة المحاولة في وقت لاحق.
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end container -->
            </section>

            <!-- start wpo-site-footer -->
                 @include('website.layouts.footer')

            <!-- end wpo-site-footer -->
        </div>
@stop


