@extends('layouts.landing')

@push('title', get_phrase('Home'))

@push('css')
<style>
    .vibrant-hero {
        padding: 180px 0 100px;
        background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.05), transparent),
                    radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.05), transparent);
    }
    
    .bento-hero-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-template-rows: repeat(2, 300px);
        gap: 20px;
    }

    .hero-main { grid-column: span 8; grid-row: span 2; }
    .hero-stat-1 { grid-column: span 4; grid-row: span 1; background: var(--vibrant-primary); color: #fff; }
    .hero-stat-2 { grid-column: span 4; grid-row: span 1; background: var(--vibrant-accent); color: #fff; }

    .category-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid transparent;
    }

    .category-item:hover .category-circle {
        transform: rotate(15deg) scale(1.1);
        border-color: var(--vibrant-primary);
        box-shadow: 0 0 30px rgba(79, 70, 229, 0.2);
    }

    .vibrant-course-card {
        border-radius: 30px;
        padding: 10px;
        background: #fff;
        transition: all 0.4s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .vibrant-course-card:hover {
        transform: scale(1.03);
        box-shadow: 0 40px 80px rgba(0,0,0,0.07);
    }

    .vibrant-course-image {
        border-radius: 24px;
        height: 250px;
        object-fit: cover;
        width: 100%;
    }

    .vibrant-tag {
        background: rgba(79, 70, 229, 0.1);
        color: var(--vibrant-primary);
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    @media (max-width: 991px) {
        .bento-hero-grid {
            grid-template-columns: 1fr;
            grid-template-rows: auto;
        }
        .hero-main, .hero-stat-1, .hero-stat-2 { grid-column: span 1; }
    }
</style>
@endpush

@section('content')
<!-- Bento Hero -->
<section class="vibrant-hero">
    <div class="container">
        <div class="bento-hero-grid">
            <div class="bento-item hero-main d-flex flex-column justify-content-center p-5">
                <span class="vibrant-tag mb-4 w-fit-content px-3 py-2 text-primary" style="background: rgba(79, 70, 229, 0.08); border-radius: 50px;">🌟 {{ get_phrase('New Era of LMS') }}</span>
                <h1 class="display-3 fw-800 mb-4 lh-1">
                    {!! str_replace(['Learning', 'Education'], ['<span class="text-vibrant-gradient">Learning</span>', '<span class="text-vibrant-gradient">Education</span>'], get_frontend_settings('banner_title')) !!}
                </h1>
                <p class="fs-5 text-muted mb-5 pe-lg-5">{{ get_frontend_settings('banner_sub_title') }}</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('courses') }}" class="btn-vibrant">{{ get_phrase('Start Learning') }}</a>
                    <a href="{{ route('about.us') }}" class="btn btn-light rounded-pill px-4 fw-bold">{{ get_phrase('Our Story') }}</a>
                </div>
            </div>
            
            <div class="bento-item hero-stat-1 d-flex flex-column justify-content-end p-5">
                <h2 class="display-4 fw-800 mb-2">45k+</h2>
                <p class="mb-0 fw-bold fs-5 opacity-75">{{ get_phrase('Students Enrolled') }}</p>
            </div>
            
            <div class="bento-item hero-stat-2 d-flex flex-column justify-content-end p-5">
                <h2 class="display-4 fw-800 mb-2">100%</h2>
                <p class="mb-0 fw-bold fs-5 opacity-75">{{ get_phrase('Success Stories') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Creative Categories -->
<section class="py-100 bg-vibrant-dark py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-800 text-white mb-3">{{ get_phrase('What Do You Want To Learn?') }}</h2>
            <p class="text-white opacity-50">{{ get_phrase('Explore over 1200+ courses across various domains') }}</p>
        </div>
        
        <div class="d-flex flex-wrap justify-content-center gap-5">
            @foreach (App\Models\Category::take(6)->get() as $category)
                <div class="category-item text-center">
                    <a href="{{ route('courses', $category->slug) }}" class="text-decoration-none">
                        <div class="category-circle mb-3 mx-auto shadow-lg">
                            <i class="{{ $category->icon ?? 'fa-solid fa-graduation-cap' }} text-vibrant-gradient"></i>
                        </div>
                        <p class="text-white fw-bold mb-0">{{ $category->title }}</p>
                        <small class="text-white opacity-50">{{ count_category_courses($category->id) }} {{ get_phrase('Courses') }}</small>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Vibrant Featured Courses -->
<section class="py-100 py-5">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="display-5 fw-800">{{ get_phrase('Best Instructors, Best Courses') }}</h2>
                <p class="text-muted">{{ get_phrase('Handpicked quality content for your career growth') }}</p>
            </div>
            <a href="{{ route('courses') }}" class="btn btn-outline-vibrant border-2 rounded-pill px-4 fw-bold mb-2">{{ get_phrase('Browse All') }}</a>
        </div>
        
        <div class="row g-4">
            @php
                $top_courses = DB::table('courses')->where('status', 'active')->orderBy('id', 'desc')->take(3)->get();
            @endphp
            @foreach ($top_courses as $row)
                <div class="col-lg-4">
                    <div class="vibrant-course-card p-3">
                        <div class="position-relative mb-4">
                            <img src="{{ get_image($row->thumbnail) }}" class="vibrant-course-image" alt="{{ $row->title }}">
                            @if($row->discount_flag == 1)
                                <span class="position-absolute top-3 end-3 badge bg-danger rounded-pill px-3 py-2 fw-bold" style="top: 15px; right: 15px;">{{ round((($row->price - $row->discounted_price) / $row->price) * 100) }}% OFF</span>
                            @endif
                        </div>
                        <div class="px-2">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="vibrant-tag">Professional</span>
                                <div class="text-warning small fw-bold">
                                    <i class="fa-solid fa-star me-1"></i>4.9
                                </div>
                            </div>
                            <h4 class="fw-bold mb-4">
                                <a href="{{ route('course.details', $row->slug) }}" class="text-dark text-decoration-none">{{ Str::limit($row->title, 40) }}</a>
                            </h4>
                            <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-3">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ course_instructor_image($row->id) }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                    <span class="small fw-bold">{{ course_by_instructor($row->id)->name }}</span>
                                </div>
                                <div class="price">
                                    @if ($row->is_paid == 0)
                                        <span class="fs-4 fw-bold text-success">{{ get_phrase('Free') }}</span>
                                    @else
                                        <span class="fs-4 fw-bold text-vibrant-gradient">{{ currency($row->discount_flag == 1 ? $row->discounted_price : $row->price) }}</span>
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

<!-- Final Call to Action -->
<section class="py-100 py-5">
    <div class="container py-5">
        <div class="bento-item p-0 position-relative bg-vibrant-dark overflow-hidden" style="min-height: 450px;">
            <div class="row align-items-center g-0 h-100">
                <div class="col-lg-7 p-5 p-lg-10 text-white position-relative" style="z-index: 2;">
                    <h2 class="display-3 fw-800 mb-4">{{ get_phrase('Turn Your Passion Into A Career') }}</h2>
                    <p class="fs-5 opacity-75 mb-5 pe-lg-5">{{ get_phrase('The world is waiting for your skills. Start your journey today with our industry-led training programs.') }}</p>
                    <a href="{{ route('register.form') }}" class="btn-vibrant px-10 py-4 fs-5">{{ get_phrase('Get Started For Free') }}</a>
                </div>
                <div class="col-lg-5 h-100 d-none d-lg-block position-relative">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1200" class="position-absolute w-100 h-100 object-fit-cover opacity-50" alt="CTA">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, var(--vibrant-dark), transparent);"></div>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="position-absolute rounded-circle" style="width: 400px; height: 400px; background: var(--vibrant-primary); opacity: 0.1; bottom: -200px; right: -100px;"></div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    "use strict";
    // Any specific JS for the new vibrant design can go here
</script>
@endpush
