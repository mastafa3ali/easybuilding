@extends('website.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('assignments.plural') }}</title>
@endsection
@section('content')
     <!-- start of hero -->
        <section class="hero hero-style-1">
            <div class="hero-slider">
                
                <div class="slide">
                    <div class="container">
                        <img src="{{ asset('site') }}/assets/images/slider/slide-1.jpg" alt class="slider-bg">
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
                <div class="slide">
                    <div class="container">
                        <img src="{{ asset('site') }}/assets/images/slider/slide-3.jpg" alt class="slider-bg">
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
                    <div class="col-lg-4 col-sm-6 col-12 custom-grid">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="{{ asset('site') }}/assets/images/about.png" alt="">
                            </div>
                            <div class="blog-content">
                                <h3><div>اسم المتميزين .................</div></h3>
                                <ul class="post-meta">
                                    
                                    <li><a href="#">معلمة</a></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12 custom-grid">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="{{ asset('site') }}/assets/images/about.png" alt="">
                            </div>
                            <div class="blog-content">
                                <h3><div>اسم المتميزين .................</div></h3>
                                <ul class="post-meta">
                                    
                                    <li><a href="#">طالبة</a></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12 custom-grid">
                        <div class="blog-item b-0">
                            <div class="blog-img">
                                <img src="{{ asset('site') }}/assets/images/about.png" alt="">
                            </div>
                            <div class="blog-content">
                                <h3><div>اسم المتميزين .................</div></h3>
                                <ul class="post-meta"> 
                                    <li><a href="#">مشرفة</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                                <form method="post" class="contact-validation-active" id="contact-form">
                                    <div>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="الأسم الأول">
                                    </div>
                                    <div>
                                        <input type="text" class="form-control" name="name2" id="name2"
                                            placeholder="الأسم الثانى">
                                    </div>
                                    <div class="clearfix">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Email">
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
                                        <div id="success">شكرًا لك</div>
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
            <div class="wpo-ne-footer-2">
                <!-- start wpo-site-footer -->
                <footer class="wpo-site-footer">
                    <div class="wpo-upper-footer">
                        <div class="container">
                            <div class="row" style="display: flex;">
                                <div class="col col-lg-6 col-md-6 col-sm-6" style="display: flex; justify-content: center">
                                    <div class="widget about-widget">
                                        <div class="logo widget-title">
                                            <img src="{{ asset('site') }}/assets/images/logo.png" alt="blog">
                                        </div>
                                        <ul>
                                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                                            <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                                            <li><a href="#"><i class="ti-google"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col col-lg-3 col-md-3 col-sm-6">
                                    <div class="widget link-widget">
                                        <div class="widget-title">
                                            <h3>روابط مفيدة</h3>
                                        </div>
                                        <ul>
                                            <li><a href="about.html">عن غيث</a></li>
                                            <li><a href="new.html">جديد غيث</a></li>
                                            <li><a href="students_achievement.html">لوحة إنجاز الطالبات</a></li>
                                            <li><a href="achievement_panel.html">لوحة إنجاز الخاتمات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col col-lg-3 col-md-3 col-sm-6">
                                    <div class="widget market-widget wpo-service-link-widget">
                                        <div class="widget-title">
                                            <h3>اتصل </h3>
                                        </div>
                                        <div class="contact-ft">
                                            <ul>
                                                <li><i class="fi ti-location-pin"></i>العنوان </li>
                                                <li><i class="fi flaticon-call"></i> 000123456789</li>
                                                <li><i class="fi flaticon-envelope"></i>info@gmail.com</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end container -->
                    </div>
                    <div class="wpo-lower-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col col-xs-12">
                                    <p class="copyright">&copy; 2022 غيث. كل الحقوق محفوظة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end wpo-site-footer -->
            </div>
            <!-- end wpo-site-footer -->
        </div>
@stop


