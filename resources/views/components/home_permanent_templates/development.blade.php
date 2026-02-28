@extends('layouts.default')
@push('title', get_phrase('Home'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/clinton/font.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/poppins/stylesheet.css') }}">
    <style>
        body {
            background-color: #FAFEFF;
        }

        .info {
            font-family: 'Poppins' !important;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #7E8088;
        }
        

        h1,
        h1 .highlight {
            font-family: 'clinton-bold' !important;
        }

        .font-italic {
            font-family: 'clinton-bold-italic' !important;
        }

        h2,
        h3,
        h4,
        h5,
        h6,
        .hero-rated-profile-area .info {
            font-family: 'clinton-bold' !important;
        }

        body,
        p,
        span,
        button,
        a {
            font-family: 'Poppins' !important;
            font-weight: normal;
        }

        .btn-danger-1,
        .btn-whitelight {
            font-family: 'Poppins' !important;
            font-weight: normal;
        }

        .subtitle-1,
        .subtitle-2,
        .subtitle-3,
        .subtitle-4,
        .subtitle-5{
            font-family: 'Poppins' !important;
            font-weight: 500;
        }
        .accordion-button{
            font-weight: 500 !important;
        }

        .learning-coding-card, .dev-course-card, .dev-student-testimonial, .dev-news-card{
            border: none;
            border-radius: 12px;
            background: #FFF;
            box-shadow: 0px 14px 32px 0px rgba(147, 148, 158, 0.20);
        }
        .dev-course-card:hover, .dev-news-card:hover{
            box-shadow: 0px 14px 32px 0px rgba(249, 92, 22, 0.17);
        }
        .text-dev-warning{
            color: #030303 !important;
            transition: color 0.3s;
        }
        .dev-news-link:hover .text-dev-warning{
            color: #F95C16 !important;
            transition: color 0.3s;
        }
        .accordion, .accordion-button, .accordion-body, .accordion-header, .accordion-item{
            background-color: #fafeff;
        }
        
        /* Enhanced Background Animation for Hero Section - Gradient Animation */
        .development-hero-section1 {
            position: relative;
            overflow: hidden;
            background: linear-gradient(
                135deg,
                #FAFEFF 0%,
                #FFF5F0 15%,
                #FFE8D9 30%,
                #FFD4B8 45%,
                #FFE8D9 60%,
                #FFF5F0 75%,
                #FAFEFF 90%,
                #FFF5F0 100%
            );
            background-size: 300% 300%;
            animation: gradientFlow 12s ease-in-out infinite;
            border-top: 1px solid rgba(249, 92, 22, 0.15);
        }
        
        .development-hero-section1::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                45deg,
                rgba(249, 92, 22, 0.1) 0%,
                transparent 25%,
                rgba(249, 92, 22, 0.08) 50%,
                transparent 75%,
                rgba(249, 92, 22, 0.1) 100%
            );
            background-size: 200% 200%;
            animation: gradientWave 10s ease-in-out infinite;
            pointer-events: none;
            opacity: 0.8;
        }
        
        .development-hero-section1::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 30% 40%, rgba(249, 92, 22, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 70% 60%, rgba(249, 92, 22, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 50% 20%, rgba(249, 92, 22, 0.08) 0%, transparent 35%);
            animation: gradientPulse 8s ease-in-out infinite;
            pointer-events: none;
        }
        
        .development-hero-section1 .container {
            position: relative;
            z-index: 1;
        }
        
        @keyframes gradientFlow {
            0% {
                background-position: 0% 50%;
            }
            25% {
                background-position: 100% 50%;
            }
            50% {
                background-position: 100% 100%;
            }
            75% {
                background-position: 0% 100%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        @keyframes gradientWave {
            0%, 100% {
                background-position: 0% 0%;
                opacity: 0.6;
            }
            25% {
                background-position: 100% 0%;
                opacity: 0.8;
            }
            50% {
                background-position: 100% 100%;
                opacity: 1;
            }
            75% {
                background-position: 0% 100%;
                opacity: 0.8;
            }
        }
        
        @keyframes gradientPulse {
            0%, 100% {
                transform: scale(1) rotate(0deg);
                opacity: 0.7;
            }
            33% {
                transform: scale(1.1) rotate(120deg);
                opacity: 0.9;
            }
            66% {
                transform: scale(1.05) rotate(240deg);
                opacity: 0.8;
            }
        }
        
        /* Scroll Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }
        
        .animate-fade-in {
            opacity: 0;
            transition: opacity 1s ease-out;
        }
        
        .animate-fade-in.animated {
            opacity: 1;
        }
        
        .animate-slide-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .animate-slide-left.animated {
            opacity: 1;
            transform: translateX(0);
        }
        
        .animate-slide-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .animate-slide-right.animated {
            opacity: 1;
            transform: translateX(0);
        }
        
        .animate-scale {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .animate-scale.animated {
            opacity: 1;
            transform: scale(1);
        }
        
        /* Stagger animation for cards */
        .animate-stagger > * {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        
        .animate-stagger.animated > *:nth-child(1) {
            transition-delay: 0.1s;
        }
        
        .animate-stagger.animated > *:nth-child(2) {
            transition-delay: 0.2s;
        }
        
        .animate-stagger.animated > *:nth-child(3) {
            transition-delay: 0.3s;
        }
        
        .animate-stagger.animated > *:nth-child(4) {
            transition-delay: 0.4s;
        }
        
        .animate-stagger.animated > * {
            opacity: 1;
            transform: translateY(0);
        }
        
    </style>
@endpush
@section('content')

    <!-- Banner Area Start -->
    @php
        $bannerData = json_decode(get_frontend_settings('banner_image'));
        $banneractive = get_frontend_settings('home_page');
        if ($bannerData !== null && is_object($bannerData) && property_exists($bannerData, $banneractive)) {
            $banner = asset(json_decode(get_frontend_settings('banner_image'))->$banneractive);
        } else {
            $defaultBanner = asset('assets/frontend/default/image/development-banner1.webp');
        }
        $total_students = DB::table('users')->where('role', 'student')->get();
    @endphp
    <section class="dev-banner-section" style="background-image: url({{ isset($banner) ? $banner : $defaultBanner }});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="development-banner-area">
                        @php
                            $banner_title = get_phrase(get_frontend_settings('banner_title'));
                            $arr = explode(' ', $banner_title);
                            $phrase_two = end($arr);
                            $phrase_one = str_replace($phrase_two, '', $banner_title);
                        @endphp
                        <h1 class="title">{{ $phrase_one }}<span class=" font-italic highlight">{{ $phrase_two }}</span></h1>
                        <a href="javascript:void(0);" class="video-play-btn" type="button" data-bs-toggle="modal" data-bs-target="#promoVideo">
                            <span class="icon">
                                <img src="{{ asset('assets/frontend/default/image/play-black-large.svg') }}" alt="">
                            </span>
                            <span>{{ get_phrase('Watch Video') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Area End -->

    <!-- Hero Area Start -->
    <section class="development-hero-section1 mb-80" style="margin-top: 2px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="development-hero-area1 d-flex align-items-center justify-content-between">
                        <div class="hero-rated-profile-area">
                            <ul class="profiles d-flex align-items-center">

                                @php
                                    $students = DB::table('users')->where('role', 'student')->take(2)->latest('id')->get();
                                @endphp
                                @foreach ($students as $student)
                                    <li>
                                        <img data-bs-toggle="tooltip" title="{{ $student->name }}" src="{{ get_image($student->photo) }}" alt="">
                                    </li>
                                @endforeach
                                <li>
                                    <img src="{{ asset('assets/frontend/default/image/arrow-rotate-white-16.svg') }}" alt="">
                                </li>
                            </ul>
                            <p class="info">{{ count($total_students) }}+ {{ get_phrase('User already register and signing up for using it') }}</p>
                        </div>
                        <p class="hero-info">{{ get_phrase(get_frontend_settings('banner_sub_title')) }}</p>
                        <a href="{{ route('courses') }}" class="btn-black1">{{ get_phrase('Get Courses') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Area End -->

    <!-- Software Development Area Start -->


    @if ($stordetails = json_decode(get_homepage_settings('development')))
        @php
            function highlightLastWord($text)
            {
                $words = explode(' ', $text);
                if (count($words) > 1) {
                    $lastWord = array_pop($words);
                    return implode(' ', $words) . ' <span class="highlight">' . $lastWord . '</span>';
                }
                return '<span class="highlight">' . $text . '</span>';
            }
        @endphp
        <section class="animate-on-scroll">
            <div class="container">
                <div class="row row-20 mb-80 align-items-center">
                    <div class="col-lg-6">
                        <div class="software-development-banner animate-slide-left">
                            @if (isset($stordetails->image))
                                <img src="{{ asset('uploads/home_page_image/development/' . $stordetails->image) }}" alt="">
                            @else
                                <img src="{{ asset('assets/frontend/default/image/soft-dev-banner.webp') }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="software-development-details animate-slide-right">
                            <h2 class="title">{!! removeScripts(highlightLastWord(get_phrase($stordetails->title))) !!}</h2>
                            <p class="info mb-20">{!! get_phrase(strip_tags($stordetails->description)) !!}</p>
                            <a href="{{ route('about.us') }}" class="btn-black-arrow1">
                                <span>{{ get_phrase('Learn More') }}</span>
                                <i class="fi-rr-angle-small-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Software Development Area End -->

    <!-- Learning Coding Area Start -->
    <section class="animate-on-scroll">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="dev-section-title animate-fade-in">
                        <h1 class="title mb-20">{{ get_phrase('Start Learning') }} <span class="highlight">{{ get_phrase('Coding') }}</span> {{ get_phrase('Languages') }}</h1>
                        <p class="info">{{ get_phrase("The industry's standard dummy text ever since the  unknown printer took a galley of type and scrambled") }}</p>
                    </div>
                </div>
            </div>
            <div class="row row-20 mb-100 justify-content-center animate-stagger">
                <!-- Card -->
                <div class="col-lg-4 col-md-6">
                    <div class="learning-coding-card pt-3">
                        <div class="banner mb-5">
                            <img src="{{ asset('assets/frontend/default/image/learnig-coding-banner1.webp') }}" alt="">
                        </div>
                        <h4 class="title">{{ get_phrase('Online Courses') }}</h4>
                        <p class="info">{{ get_phrase("The industry's standard dummy text ever since the  unknown printer took a galley of type and scrambled") }}</p>
                    </div>
                </div>
                <!-- Card -->
                <div class="col-lg-4 col-md-6">
                    <div class="learning-coding-card pt-3">
                        <div class="banner mb-5">
                            <img src="{{ asset('assets/frontend/default/image/learnig-coding-banner2.webp') }}" alt="">
                        </div>
                        <h4 class="title">{{ get_phrase('Top Instructors') }}</h4>
                        <p class="info">{{ get_phrase("The industry's standard dummy text ever since the  unknown printer took a galley of type and scrambled") }}</p>
                    </div>
                </div>
                <!-- Card -->
                <div class="col-lg-4 col-md-6">
                    <div class="learning-coding-card pt-3">
                        <div class="banner mb-5">
                            <img src="{{ asset('assets/frontend/default/image/learnig-coding-banner3.webp') }}" alt="">
                        </div>
                        <h4 class="title">{{ get_phrase('Online Certificates') }}</h4>
                        <p class="info">{{ get_phrase("The industry's standard dummy text ever since the  unknown printer took a galley of type and scrambled") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Learning Coding Area End -->

    <!-- Pick A Course Area Start -->
    <section class="animate-on-scroll">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="dev-section-title animate-fade-in">
                        <h1 class="title mb-20">{{ get_phrase('Pick A Course To') }} <span class="highlight">{{ get_phrase('Get Started') }}</span></h1>
                        <p class="info">{{ get_phrase("The industry's standard dummy text ever since the  unknown printer took a galley of type and scrambled") }}</p>
                    </div>
                </div>
            </div>
            <div class="row row-20 mb-110 animate-stagger">
                @php
                    $featured_courses = DB::table('courses')->where('status', 'active')->latest('id')->get();
                @endphp
                @foreach ($featured_courses->take(4) as $key => $row)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <a href="{{ route('course.details', $row->slug) }}" class="dev-course-card-link">
                            <div class="dev-course-card">
                                <div class="banner">
                                    <img src="{{ get_image($row->thumbnail) }}" alt="banner">
                                </div>
                                @php
                                    $ratings = DB::table('reviews')
                                        ->where('course_id', $row->id)
                                        ->pluck('rating')
                                        ->toArray();
                                    $average_rating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
                                    $full_stars = floor($average_rating);
                                    $has_half_star = $average_rating - $full_stars >= 0.5;
                                    $review_count = count($ratings);
                                @endphp
                                <div class="dev-course-card-body">
                                    <h5 class="title ellipsis-line-2">{{ ucfirst($row->title) }}</h5>
                                    <div class="reviews d-flex align-items-center">
                                        @if ($review_count > 0)
                                            <div class="ratings d-flex align-items-center">
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < $full_stars)
                                                        <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="Full Star">
                                                    @elseif ($i == $full_stars && $has_half_star)
                                                        <img src="{{ asset('assets/frontend/default/image/star-yellow-half-14.svg') }}" alt="Half Star">
                                                    @else
                                                        <img src="{{ asset('assets/frontend/default/image/star.svg') }}" alt="Empty Star">
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="total fw-500">{{ $review_count }} {{ get_phrase('Reviews') }}</p>
                                        @endif
                                    </div>

                                    @if (isset($row->is_paid) && $row->is_paid == 0)
                                        <p class="price">{{ get_phrase('Free') }}</p>
                                    @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                        <p class="price">
                                            {{ currency($row->discounted_price, 2) }}
                                            <del class="fs-14px text-secondary">{{currency($row->price)}}</del>
                                        </p>
                                    @else
                                        <p class="price">{{ currency($row->price, 2) }}</p>
                                    @endif

                                    <div class="leason-student d-flex align-items-center">
                                        <div class="leasons-students d-flex align-items-center">
                                            <i class="fi-rr-book-open-cover"></i>
                                            <p class="total fw-500">{{ lesson_count($row->id) }}{{ get_phrase('lessons') }}</p>
                                        </div>
                                        <div class="leasons-students d-flex align-items-center">
                                            <i class="fi-rr-users"></i>
                                            <p class="total fw-500">{{ course_enrollments($row->id) }} {{ get_phrase('Students') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                @if (count($featured_courses) > 4)
                    <!-- Button  -->
                    <div class="col-xl-12">
                        <div class="dev-course-btn-area d-flex justify-content-center">
                            <a href="{{ route('courses') }}" class="btn-black-arrow1">
                                <span>{{ get_phrase('View More') }}</span>
                                <i class="fi-rr-angle-small-right"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Pick A Course Area End -->

    <!-- Programming Ebook Area Start -->
  
    <!-- Programming Ebook Area End -->

    <!-- Ask Question Area Start -->
    <section class="animate-on-scroll">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="dev-section-title animate-fade-in">
                        <h1 class="title">{{ get_phrase('Frequently Asked') }} <span class="highlight">{{ get_phrase('Questions') }}</span></h1>
                    </div>
                </div>
            </div>
            <!-- QNA Accordion -->
            <div class="row mb-100 animate-scale">
                <div class="col-md-12">
                    <div class="accordion qna-three-accordion" id="accordionExample4">
                        @php
                            $faqs = count(json_decode(get_frontend_settings('website_faqs'), true)) > 0 ? json_decode(get_frontend_settings('website_faqs'), true) : [['question' => '', 'answer' => '']];
                        @endphp
                        @foreach ($faqs as $key => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $key }}">
                                    <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#qnaOne{{ $key }}" aria-expanded="true" aria-controls="qnaOne">
                                        {{ get_phrase($faq['question']) }}
                                    </button>
                                </h2>
                                <div id="qnaOne{{ $key }}" class="accordion-collapse collapse px-0  {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExample4" aria-labelledby="{{ $key }}">
                                    <div class="accordion-body">
                                        <p class="answer">{{ get_phrase($faq['answer']) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Ask Question Area End -->

    <!-- Student Testimonials Area Start -->
    <section class="animate-on-scroll">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="dev-section-title animate-fade-in">
                        <h1 class="title mb-20">{{ get_phrase('What Our') }} <span class="highlight">{{ get_phrase('Students') }}</span> {{ get_phrase('Have To Say') }}</h1>
                        <p class="info">{{ get_phrase("The industry's standard dummy text ever since the  unknown printer took a galley of type and scrambled") }}</p>
                    </div>
                </div>
            </div>
            <!-- Testimonials -->
            <div class="row mb-100 animate-scale">
                <div class="col-md-12">
                    @php
                        $reviews = DB::table('user_reviews')->get();
                    @endphp
                    @if(count($reviews) > 0)
                        <div class="swiper dev-student-swiper" id="testimonials-swiper">
                            <div class="swiper-wrapper">
                                @foreach ($reviews as $review)
                                    @php
                                        $userDetails = App\Models\User::where('id', $review->user_id)->first();
                                        if (!$userDetails) {
                                            continue;
                                        }
                                    @endphp
                                    <div class="swiper-slide">
                                        <div class="dev-student-testimonial">
                                            <div class="ratings d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                                    @else
                                                        <img src="{{ asset('assets/frontend/default/image/star.svg') }}" alt="">
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="feedback"><span class="bold">{{ $review->review }}</span></p>
                                            <div class="profile-wrap d-flex align-items-center">
                                                <div class="profile">
                                                    <img src="{{ get_image_by_id($userDetails->id) }}" alt="{{ $userDetails->name }}">
                                                </div>
                                                <div class="name-role">
                                                    <h5 class="name">{{ $userDetails->name }}</h5>
                                                    <p class="role">{{ get_phrase('Student') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Swiper navigation if desired -->
                            @if(count($reviews) > 1)
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">{{ get_phrase('No reviews available yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @if(count($reviews) > 0)
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var testimonialsContainer = document.getElementById('testimonials-swiper');
                    if (!testimonialsContainer) {
                        return;
                    }
                    
                    // Destroy existing swiper if it exists
                    if (window.testimonialsSwiperInstance) {
                        window.testimonialsSwiperInstance.destroy(true, true);
                    }
                    
                    var reviewsCount = parseInt('{{ count($reviews) }}');
                    var testimonialsSwiper = new Swiper('#testimonials-swiper', {
                        loop: reviewsCount > 1,
                        autoplay: reviewsCount > 1 ? {
                            delay: 3500,
                            disableOnInteraction: false,
                        } : false,
                        slidesPerView: 1,
                        spaceBetween: 16,
                        centeredSlides: true,
                        breakpoints: {
                            0: {
                                slidesPerView: 1,
                                spaceBetween: 16,
                                centeredSlides: true,
                            },
                            576: {
                                slidesPerView: 1,
                                spaceBetween: 20,
                                centeredSlides: true,
                            },
                            768: {
                                slidesPerView: 2,
                                spaceBetween: 24,
                                centeredSlides: false,
                            },
                            992: {
                                slidesPerView: 2,
                                spaceBetween: 24,
                                centeredSlides: false,
                            }
                        },
                        pagination: reviewsCount > 1 ? {
                            el: '.swiper-pagination',
                            clickable: true,
                            dynamicBullets: true,
                        } : false,
                        navigation: reviewsCount > 1 ? {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        } : false,
                    });
                    
                    window.testimonialsSwiperInstance = testimonialsSwiper;
                });
            </script>
            @endif
        </div>
    </section>
    <!-- Student Testimonials Area End -->

    <!-- News Blog Area Start -->
    @if (get_frontend_settings('blog_visibility_on_the_home_page'))
        <section class="animate-on-scroll">
            <div class="container">
                <!-- Section Title -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="dev-section-title animate-fade-in">
                            <h1 class="title mb-20">{{ get_phrase('Get News with') }} <span class="highlight">{{ get_phrase('Academy') }}</span></h1>
                            <p class="info">{{ get_phrase("The industry's standard dummy text ever since the  unknown printer took a galley of type and scrambled") }}</p>
                        </div>
                    </div>
                </div>
                <div class="row row-20 mb-100 animate-stagger">
                    @foreach ($blogs as $key => $blog)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <a href="{{ route('blog.details', $blog->slug) }}" class="dev-news-link">
                                <div class="dev-news-card">
                                    <div class="banner">
                                        <img src="{{ get_image($blog->thumbnail) }}" alt="">
                                    </div>
                                    <div class="dev-news-card-body">
                                        <h5 class="ellipsis-line-2 title mb-12">{{ ucfirst($blog->title) }}</h5>
                                        <div class="date-comments flex-wrap mb-3 d-flex align-items-center">
                                            <div class="date-wrap d-flex align-items-center">
                                                <img src="{{ asset('assets/frontend/default/image/calendar-black-16.svg') }}" alt="">
                                                <p class="value">{{ $blog->created_at->format('d M, Y') }}</p>
                                            </div>
                                        </div>
                                        <p class="info ellipsis-line-2">{{ ellipsis(strip_tags($blog->description), 160) }}</p>

                                        <p class="text-dark mt-3 text-dev-warning">{{get_phrase('Read More')}} <i class="fi-br-angle-small-right"></i></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- News Blog Area End -->


    <!-- Vertically centered modal -->
    <div class="modal fade-in-effect" id="promoVideo" tabindex="-1" aria-labelledby="promoVideoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <link rel="stylesheet" href="{{ asset('assets/global/plyr/plyr.css') }}">

                    @if (get_frontend_settings('promo_video_provider') == 'youtube')
                        <div class="plyr__video-embed" id="promoPlayer">
                            <iframe height="500" src="{{ get_frontend_settings('promo_video_link') }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    @elseif (get_frontend_settings('promo_video_provider') == 'vimeo')
                        <div class="plyr__video-embed" id="promoPlayer">
                            <iframe height="500" id="promoPlayer" src="https://player.vimeo.com/video/{{ get_frontend_settings('promo_video_link') }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    @else
                        <video id="promoPlayer" playsinline controls>
                            <source src="{{ get_frontend_settings('promo_video_link') }}" type="video/mp4">
                        </video>
                    @endif

                    <script src="{{ asset('assets/global/plyr/plyr.js') }}"></script>
                    <script>
                        "use strict";
                        var promoPlayer = new Plyr('#promoPlayer');
                    </script>

                </div>
            </div>
        </div>
    </div>

    <script>
        "use strict";
        const myModalEl = document.getElementById('promoVideo')
        myModalEl.addEventListener('hidden.bs.modal', event => {
            promoPlayer.pause();
            $('#promoVideo').toggleClass('in');
        });
        myModalEl.addEventListener('shown.bs.modal', event => {
            promoPlayer.play();
            $('#promoVideo').toggleClass('in');
        });
    </script>

    <!-- Scroll Animation Script -->
    <script>
        "use strict";
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        // Stop observing once animated
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all elements with animation classes
            const animatedElements = document.querySelectorAll(
                '.animate-on-scroll, .animate-fade-in, .animate-slide-left, .animate-slide-right, .animate-scale, .animate-stagger'
            );

            animatedElements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>


@endsection
