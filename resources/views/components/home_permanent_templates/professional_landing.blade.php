@extends('layouts.default')

@push('title', get_phrase('Home'))

@push('css')
<style>
    /* Section Spacing */
    .section-spacing {
        padding: 100px 0;
    }
    
    /* Hero Title Variation */
    .hero-title span {
        color: var(--academy-primary);
        background: linear-gradient(120deg, var(--academy-primary), var(--academy-secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Category Cards */
    .category-card-professional {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #f1f5f9;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .category-card-professional:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        border-color: var(--academy-primary);
    }

    .category-icon-wrapper {
        width: 80px;
        height: 80px;
        background: #f8fafc;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 32px;
        color: var(--academy-primary);
        transition: all 0.3s ease;
    }

    .category-card-professional:hover .category-icon-wrapper {
        background: var(--academy-primary);
        color: #fff;
    }

    /* Course Cards */
    .course-card-professional {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        height: 100%;
    }

    .course-card-professional:hover {
        box-shadow: 0 30px 60px rgba(0,0,0,0.08);
        transform: scale(1.02);
    }

    .course-image-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .course-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .course-card-professional:hover .course-image-wrapper img {
        transform: scale(1.1);
    }

    .course-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(4px);
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        color: var(--academy-dark);
        z-index: 1;
    }

    .course-content {
        padding: 25px;
    }

    .instructor-thumb {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    /* Stats Section */
    .stats-section {
        background: var(--academy-dark);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .stat-item h2 {
        font-size: 48px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 5px;
    }

    .stat-item p {
        color: #94a3b8;
        font-weight: 500;
    }

    /* Testimonials */
    .testimonial-card {
        padding: 40px;
        background: #fff;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        position: relative;
    }

    .testimonial-card i.quote-icon {
        position: absolute;
        top: 30px;
        right: 30px;
        font-size: 40px;
        opacity: 0.1;
        color: var(--academy-primary);
    }

    /* Animations helpers */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-professional">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 animate-fade-up">
                <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-4 fw-bold">🚀 {{ get_phrase('Next Generation Learning') }}</span>
                <h1 class="hero-title">
                    {!! str_replace(['Learning', 'Education', 'Skills'], ['<span>Learning</span>', '<span>Education</span>', '<span>Skills</span>'], get_frontend_settings('banner_title')) !!}
                </h1>
                <p class="hero-subtitle">{{ get_frontend_settings('banner_sub_title') }}</p>
                <div class="d-flex gap-3 mt-5">
                    <a href="{{ route('courses') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg">{{ get_phrase('Explore Courses') }}</a>
                    <a href="{{ route('about.us') }}" class="btn btn-outline-dark px-5 py-3 rounded-pill fw-bold">{{ get_phrase('About Us') }}</a>
                </div>
                
                <div class="mt-5 d-flex align-items-center gap-4">
                    <div class="d-flex">
                        <img src="https://i.pravatar.cc/150?u=a" class="rounded-circle border border-2 border-white" style="width: 40px; margin-right: -15px;">
                        <img src="https://i.pravatar.cc/150?u=b" class="rounded-circle border border-2 border-white" style="width: 40px; margin-right: -15px;">
                        <img src="https://i.pravatar.cc/150?u=c" class="rounded-circle border border-2 border-white" style="width: 40px;">
                    </div>
                    <div>
                        <p class="mb-0 fw-bold text-dark">12k+ {{ get_phrase('Students') }}</p>
                        <small class="text-muted">{{ get_phrase('Join our growing community') }}</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 d-none d-lg-block">
                <div class="position-relative animate-fade-up" style="animation-delay: 0.2s;">
                    <div class="hero-image-main rounded-4 shadow-lg overflow-hidden position-relative" style="z-index: 2;">
                        <img src="{{ asset('uploads/system/home-banner.jpg') }}" alt="Hero" class="w-100" onerror="this.src='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200'">
                    </div>
                    <!-- Decorative elements -->
                    <div class="position-absolute bg-white p-3 rounded-4 shadow-lg d-flex align-items-center gap-3 animate-fade-up" style="bottom: 30px; left: -30px; z-index: 3; animation-delay: 0.5s;">
                        <div class="bg-success rounded-circle p-2"><i class="fa-solid fa-check text-white"></i></div>
                        <div>
                            <p class="mb-0 fw-bold small">100% {{ get_phrase('Job Secure') }}</p>
                            <small class="text-muted" style="font-size: 10px;">{{ get_phrase('Verified Courses') }}</small>
                        </div>
                    </div>
                    <div class="position-absolute bg-white p-3 rounded-4 shadow-lg animate-fade-up" style="top: 40px; right: -20px; z-index: 3; animation-delay: 0.7s;">
                         <p class="mb-1 fw-bold small"><i class="fa-solid fa-star text-warning me-2"></i>4.9/5</p>
                         <small class="text-muted" style="font-size: 10px;">{{ get_phrase('Trustpilot Reviews') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section-spacing">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <h6 class="text-primary fw-bold text-uppercase mb-2">{{ get_phrase('Top Categories') }}</h6>
            <h2 class="fw-bold fs-1">{{ get_phrase('Browse by Interest') }}</h2>
        </div>
        
        <div class="row g-4">
            @foreach (App\Models\Category::take(8)->get() as $category)
                <div class="col-xl-3 col-lg-4 col-md-6 reveal">
                    <a href="{{ route('courses', $category->slug) }}">
                        <div class="category-card-professional">
                            <div class="category-icon-wrapper">
                                <i class="{{ $category->icon ?? 'fa-solid fa-graduation-cap' }}"></i>
                            </div>
                            <h5 class="fw-bold mb-2">{{ $category->title }}</h5>
                            <p class="small text-muted mb-0">{{ count_category_courses($category->id) }} {{ get_phrase('Courses') }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <h2 class="counter">45k</h2>
                    <p>{{ get_phrase('Active Students') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <h2 class="counter">890+</h2>
                    <p>{{ get_phrase('Expert Instructors') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <h2 class="counter">1.2k</h2>
                    <p>{{ get_phrase('Total Courses') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <h2 class="counter">100%</h2>
                    <p>{{ get_phrase('Satisfaction rate') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses -->
<section class="section-spacing bg-light">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-end mb-5 reveal">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2">{{ get_phrase('Popular Courses') }}</h6>
                <h2 class="fw-bold fs-1">{{ get_phrase('Level Up Your Skills') }}</h2>
            </div>
            <a href="{{ route('courses') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill fw-bold mb-2">{{ get_phrase('View All Courses') }}</a>
        </div>
        
        <div class="row g-4">
            @php
                $featured_courses = DB::table('courses')->where('status', 'active')->latest('id')->take(6)->get();
            @endphp
            @foreach ($featured_courses as $row)
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="course-card-professional">
                        <div class="course-image-wrapper">
                            @if($row->discount_flag == 1)
                                <div class="course-badge">{{ round((($row->price - $row->discounted_price) / $row->price) * 100) }}% {{ get_phrase('OFF') }}</div>
                            @endif
                            <a href="{{ route('course.details', $row->slug) }}">
                                <img src="{{ get_image($row->thumbnail) }}" alt="{{ $row->title }}">
                            </a>
                        </div>
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill small">{{ App\Models\Category::find($row->category_id)->title ?? 'Course' }}</span>
                                <div class="d-flex align-items-center text-warning small">
                                    @php
                                        $ratings = DB::table('reviews')->where('course_id', $row->id)->pluck('rating')->toArray();
                                        $avg_rating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 5;
                                    @endphp
                                    <i class="fa-solid fa-star me-1"></i>
                                    <span class="fw-bold text-dark">{{ number_format($avg_rating, 1) }}</span>
                                </div>
                            </div>
                            <h5 class="fw-bold text-dark mb-3">
                                <a href="{{ route('course.details', $row->slug) }}">{{ Str::limit($row->title, 45) }}</a>
                            </h5>
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <i class="fi-rr-book-open-cover text-primary small"></i>
                                <small class="text-muted">{{ lesson_count($row->id) }} {{ get_phrase('Lessons') }}</small>
                                <span class="mx-1 text-muted">•</span>
                                <i class="fi-rr-clock text-primary small"></i>
                                <small class="text-muted">{{ $row->duration ?? 'Self-paced' }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{ course_instructor_image($row->id) }}" class="instructor-thumb" alt="Instructor">
                                    <small class="fw-bold text-dark">{{ course_by_instructor($row->id)->name }}</small>
                                </div>
                                <div class="price-info">
                                    @if ($row->is_paid == 0)
                                        <span class="fs-4 fw-bold text-success">{{ get_phrase('Free') }}</span>
                                    @else
                                        <span class="fs-4 fw-bold text-primary">{{ currency($row->discount_flag == 1 ? $row->discounted_price : $row->price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- About Us (Value Proposition) -->
<section class="section-spacing">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1200" alt="About" class="w-100 rounded-4 shadow-lg">
                    <div class="position-absolute top-50 start-50 translate-middle bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-lg hover-scale" style="width: 80px; height: 80px; cursor: pointer;">
                        <i class="fa-solid fa-play text-white fs-4 ms-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal">
                <h6 class="text-primary fw-bold text-uppercase mb-2">{{ get_phrase('Why Choose Us') }}</h6>
                <h2 class="fw-bold fs-1 mb-4">{{ get_phrase('Empowering Your Quality Of Life Through Education') }}</h2>
                <p class="text-muted mb-5 lh-lg">{{ get_phrase('We provide top-notch online education that flexible, accessible, and high-quality. Our mission is to democratize education and make it available for everyone, everywhere.') }}</p>
                
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 mb-4">
                            <div class="bg-soft-primary p-3 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fa-solid fa-award text-primary"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ get_phrase('Certified Courses') }}</h6>
                                <p class="small text-muted mb-0">{{ get_phrase('Earn recognized certificates') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 mb-4">
                            <div class="bg-soft-success p-3 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fa-solid fa-users text-success"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ get_phrase('Expert Tutors') }}</h6>
                                <p class="small text-muted mb-0">{{ get_phrase('Learn from industry pros') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('register.form') }}" class="btn btn-dark px-5 py-3 rounded-pill fw-bold mt-3">{{ get_phrase('Get Started Now') }}</a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="section-spacing bg-soft-primary overflow-hidden">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <h6 class="text-primary fw-bold text-uppercase mb-2">{{ get_phrase('Testimonials') }}</h6>
            <h2 class="fw-bold fs-1">{{ get_phrase('What Our Students Say') }}</h2>
        </div>
        
        <div class="swiper lms-testimonial-2 reveal">
            <div class="swiper-wrapper py-4">
                @foreach (DB::table('user_reviews')->take(6)->get() as $review)
                    @php $userDetails = DB::table('users')->where('id', $review->user_id)->first(); @endphp
                    @if($userDetails)
                    <div class="swiper-slide">
                        <div class="testimonial-card shadow-sm h-100">
                            <i class="fa-solid fa-quote-right quote-icon"></i>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <img src="{{ get_image($userDetails->photo) }}" class="rounded-circle shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $userDetails->name }}</h6>
                                    <div class="text-warning small">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-muted opacity-25' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted italic mb-0">"{!! Str::limit($review->review, 150) !!}"</p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            <div class="swiper-pagination mt-5 position-relative"></div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section-spacing">
    <div class="container">
        <div class="bg-primary rounded-5 p-5 p-lg-5 text-center position-relative overflow-hidden reveal">
            <!-- Background shapes -->
            <div class="position-absolute opacity-10 rounded-circle bg-white" style="width: 300px; height: 300px; top: -150px; right: -150px;"></div>
            <div class="position-absolute opacity-10 rounded-circle bg-white" style="width: 200px; height: 200px; bottom: -100px; left: -100px;"></div>
            
            <div class="position-relative z- index-2 py-4">
                <h2 class="text-white fw-bold fs-1 mb-3">{{ get_phrase('Start Your Journey To Success Today') }}</h2>
                <p class="text-white opacity-75 mb-5 fs-5 max-w-700px mx-auto">{{ get_phrase('Join thousands of students and start learning from the best instructors in the world. Your future starts here.') }}</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('register.form') }}" class="btn btn-light text-primary px-5 py-3 rounded-pill fw-bold shadow-lg">{{ get_phrase('Join For Free') }}</a>
                    <a href="{{ route('contact.us') }}" class="btn btn-outline-light px-5 py-3 rounded-pill fw-bold">{{ get_phrase('Contact Us') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    "use strict";
    
    // Reveal animation logic
    function reveal() {
        var reveals = document.querySelectorAll(".reveal");
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 150;
            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add("active");
            }
        }
    }
    window.addEventListener("scroll", reveal);
    
    // Counter animation
    $(document).ready(function() {
        $('.counter').each(function() {
            var $this = $(this),
                countTo = $this.text();
            $({ countNum: 0 }).animate({
                countNum: parseFloat(countTo)
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum) + (countTo.includes('k') ? 'k' : (countTo.includes('+') ? '+' : (countTo.includes('%') ? '%' : ''))));
                },
                complete: function() {
                    $this.text(countTo);
                }
            });
        });
        
        // Initial call
        reveal();
        
        // Initialize Swiper for Testimonials
        if(typeof Swiper !== 'undefined') {
            new Swiper('.lms-testimonial-2', {
                slidesPerView: 1,
                spaceBetween: 30,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
                autoplay: {
                    delay: 5000,
                },
            });
        }
    });
</script>
@endpush
