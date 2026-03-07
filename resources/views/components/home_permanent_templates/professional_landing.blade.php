@extends('layouts.landing')

@push('title', get_phrase('Home'))

@push('css')
<style>
    .vibrant-hero {
        padding: 180px 0 100px;
        background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.1), transparent),
                    radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.1), transparent) !important;
        background-color: var(--vibrant-light) !important;
    }
    
    .bento-hero-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-template-rows: repeat(2, 300px);
        gap: 24px;
    }

    .hero-main { grid-column: span 8; grid-row: span 2; background: #fff !important; }
    .hero-stat-1 { grid-column: span 4; grid-row: span 1; background: var(--vibrant-primary) !important; color: #fff !important; }
    .hero-stat-2 { grid-column: span 4; grid-row: span 1; background: var(--vibrant-accent) !important; color: #fff !important; }

    .category-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #fff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid rgba(0,0,0,0.05) !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
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
<!-- Ultra Hero 4.0 -->
<section id="home" class="mesh-gradient-bg py-100 overflow-hidden" style="padding-top: 220px !important;">
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="glass-pill mb-4 animate__animated animate__fadeInDown">
                    <span>🚀</span> New Era of Learning
                </div>
                <h1 class="display-1 fw-900 mb-4 lh-1 animate__animated animate__fadeInLeft" style="letter-spacing: -2px;">
                    Master Your <span class="text-vibrant-gradient">Future</span> with Creative Courseware
                </h1>
                <p class="fs-4 text-muted mb-5 pe-lg-5 animate__animated animate__fadeInLeft animate__delay-1s">
                    Empowering students with <span class="text-dark fw-bold">flexible, high-quality</span> online learning. Discover your potential with our immersive platforms.
                </p>
                <div class="d-flex flex-wrap gap-4 align-items-center animate__animated animate__fadeInUp animate__delay-1s">
                    <a href="#courses" class="btn-vibrant px-12 py-4 fs-5" style="border-radius: 100px !important;">Explore Courses</a>
                    <a href="#blog" class="btn btn-outline-vibrant border-2 rounded-pill px-5 py-4 fw-bold">Latest News</a>
                </div>
                
                <!-- Logo Cloud / Social Proof -->
                <div class="mt-5 pt-5 opacity-50 d-flex gap-5 align-items-center flex-wrap animate__animated animate__fadeIn animate__delay-2s">
                    <span class="small fw-bold text-uppercase letter-spacing-2">Trusted By</span>
                    <i class="fa-brands fa-google fs-3"></i>
                    <i class="fa-brands fa-microsoft fs-3"></i>
                    <i class="fa-brands fa-amazon fs-3"></i>
                    <i class="fa-brands fa-apple fs-3"></i>
                </div>
            </div>
            
            <div class="col-lg-5 position-relative">
                <div class="hero-visual-container position-relative">
                    <!-- Main Image with 3D Float -->
                    <div class="floating-3d-card relative z-2">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1200" class="w-100 rounded-5 shadow-2xl" style="height: 500px; object-fit: cover; border: 10px solid #fff;">
                    </div>
                    
                    <!-- Floating Achievement Cards -->
                    <div class="position-absolute animate-float shadow-lg p-4 bg-white rounded-4 border-0" style="top: -40px; right: -20px; width: 220px; z-index: 5;">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="bg-success rounded-circle" style="width: 12px; height: 12px;"></div>
                            <span class="small fw-bold">Live Learners</span>
                        </div>
                        <h4 class="fw-900 mb-0">12,482+</h4>
                    </div>
                    
                    <div class="position-absolute animate-float shadow-lg p-4 bg-vibrant-primary text-white rounded-4 border-0" style="bottom: 40px; left: -40px; width: 200px; z-index: 5; animation-delay: 1.5s;">
                        <div class="fs-1 mb-2">🏆</div>
                        <h5 class="fw-bold mb-1">Top Rated</h5>
                        <p class="small mb-0 opacity-75">#1 LMS Choice 2026</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Creative Categories -->
<section id="categories" class="py-100 bg-vibrant-dark py-5">
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
<section id="courses" class="py-100 py-5">
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

<!-- Blog Section -->
<section id="blog" class="py-100 bg-light py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-800">{{ get_phrase('Latest from our Blog') }}</h2>
            <p class="text-muted">{{ get_phrase('Stay updated with the latest trends in education and technology') }}</p>
        </div>
        
        <div class="row g-4">
            @foreach (App\Models\Blog::where('status', 1)->take(3)->get() as $blog)
                <div class="col-lg-4">
                    <div class="bento-item h-100 p-3 shadow-sm border-0" style="border-radius: 30px !important;">
                        <img src="{{ get_image($blog->thumbnail) }}" class="w-100 mb-4" style="height: 200px; object-fit: cover; border-radius: 20px;">
                        <span class="vibrant-tag mb-3 d-inline-block">{{ $blog->category_id ? App\Models\Category::find($blog->category_id)->title : 'General' }}</span>
                        <h4 class="fw-bold mb-3">
                            <a href="{{ route('blog.details', $blog->slug) }}" class="text-dark text-decoration-none stretched-link">{{ Str::limit($blog->title, 50) }}</a>
                        </h4>
                        <p class="text-muted small mb-0">{{ Str::limit(strip_tags($blog->description), 100) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Final Call to Action -->
<section class="py-100 py-5">
    <div class="container py-5">
        <div class="bento-item p-0 position-relative overflow-hidden shadow-2xl border-0" style="min-height: 500px; border-radius: 50px !important; background: linear-gradient(135deg, var(--vibrant-darker), #1e1b4b) !important;">
            <!-- Animated Background Gradients -->
            <div class="position-absolute" style="top: -100px; left: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(79, 70, 229, 0.4), transparent); filter: blur(60px); opacity: 0.6;"></div>
            <div class="position-absolute" style="bottom: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(6, 182, 212, 0.3), transparent); filter: blur(60px); opacity: 0.4;"></div>
            
            <div class="row align-items-center g-0 h-100">
                <div class="col-lg-7 p-5 p-lg-10 text-white position-relative" style="z-index: 5;">
                    <span class="vibrant-tag mb-4 d-inline-block px-4 py-2 border-0" style="background: rgba(255,255,255,0.1); color: var(--vibrant-accent); font-weight: 800; border-radius: 50px;">🚀 {{ get_phrase('Career Fast-Track') }}</span>
                    <h2 class="display-2 fw-800 mb-4 lh-1">
                        Turn Your Passion Into A <span class="text-vibrant-gradient">Global Career</span>
                    </h2>
                    <p class="fs-4 opacity-75 mb-5 pe-lg-5 fw-medium">{{ get_phrase('The world is waiting for your unique skills. Join 45,000+ students and start your journey today with industry-standard training.') }}</p>
                    
                    <div class="d-flex flex-wrap gap-4 align-items-center">
                        <a href="{{ route('register.form') }}" class="btn-vibrant px-12 py-4 fs-5" style="border-radius: 100px !important;">{{ get_phrase('Get Started For Free') }}</a>
                        <div class="d-flex -space-x-4">
                            <!-- Placeholder for student avatars -->
                            <div class="bg-white rounded-circle p-1 shadow-sm" style="width: 45px; height: 45px;"><img src="https://i.pravatar.cc/150?u=1" class="rounded-circle w-100 h-100"></div>
                            <div class="bg-white rounded-circle p-1 shadow-sm ms-n2" style="width: 45px; height: 45px;"><img src="https://i.pravatar.cc/150?u=2" class="rounded-circle w-100 h-100"></div>
                            <div class="bg-white rounded-circle p-1 shadow-sm ms-n2" style="width: 45px; height: 45px;"><img src="https://i.pravatar.cc/150?u=3" class="rounded-circle w-100 h-100"></div>
                            <span class="ms-3 fs-6 fw-bold text-white-50">+45k Students</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 h-100 d-none d-lg-block position-relative overflow-hidden" style="min-height: 500px;">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200" class="position-absolute w-100 h-100 object-fit-cover" alt="CTA" style="opacity: 0.6; filter: contrast(1.2) brightness(0.8);">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, var(--vibrant-darker), transparent 70%);"></div>
                    
                    <!-- Floating Card Component -->
                    <div class="position-absolute p-4 backdrop-blur shadow-2xl animate-float" style="bottom: 40px; right: 40px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 24px; width: 250px;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-success rounded-circle" style="width: 10px; height: 10px;"></div>
                            <span class="fw-bold text-white small">Live Success Rate</span>
                        </div>
                        <h3 class="text-white fw-bold mb-0">98.2%</h3>
                        <div class="progress mt-3 bg-white-10" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 98%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .animate-float {
        animation: floatCTA 6s ease-in-out infinite;
    }
    @keyframes floatCTA {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    .ms-n2 { margin-left: -15px !important; transition: all 0.3s ease; }
    .ms-n2:hover { margin-left: -5px !important; }
    .bg-white-10 { background: rgba(255,255,255,0.1); }
</style>
@endsection

@push('js')
<script>
    $(window).on('scroll', function() {
        let scrollPos = $(window).scrollTop() + 150;
        $('section').each(function() {
            let currLink = $('.nav-link-vibrant[href="#' + $(this).attr('id') + '"]');
            if (currLink.length && $(this).offset().top <= scrollPos && $(this).offset().top + $(this).height() > scrollPos) {
                $('.nav-link-vibrant').removeClass('active');
                currLink.addClass('active');
            }
        });
    });
</script>
@endpush
