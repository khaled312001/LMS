@extends('layouts.landing')
@push('title', get_phrase('About Us'))
@push('meta')@endpush
@push('css')
<style>
    .mesh-gradient-breadcrumb {
        background: radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 100% 100%, rgba(6, 182, 212, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
        padding: 180px 0 80px !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .breadcrumb-item a {
        color: var(--vibrant-primary) !important;
        font-weight: 600;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: var(--vibrant-dark) !important;
        font-weight: 700;
    }
    .about-section {
        padding: 100px 0;
        background: #f8fafc;
    }
    .stat-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 30px;
        padding: 40px;
        transition: all 0.3s ease;
        text-align: center;
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-10px);
        background: #fff;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    }
    .stat-number {
        font-size: 3rem;
        font-weight: 900;
        background: linear-gradient(45deg, var(--vibrant-primary), var(--vibrant-accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 10px;
    }
    .g-title {
        font-weight: 900 !important;
        letter-spacing: -1px;
    }
    .content-card {
        background: #fff;
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 10px 50px rgba(0,0,0,0.03);
    }
    .icon-box-vibrant {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(6, 182, 212, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--vibrant-primary);
        margin-bottom: 30px;
    }
</style>
@endpush
@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    
    <!-- Breadcrumb Area -->
    <section class="mesh-gradient-breadcrumb">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('About Us') }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-3 g-title mb-0">{{ get_phrase('Our Journey & Vision') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-100" style="background: #fff; margin-top: -50px; position: relative; z-index: 2; border-radius: 60px 60px 0 0;">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($total_students) }}+</div>
                        <p class="fw-bold text-muted mb-0">{{ get_phrase('Happy Students') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($total_instructors) }}+</div>
                        <p class="fw-bold text-muted mb-0">{{ get_phrase('Expert Instructors') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($total_courses) }}+</div>
                        <p class="fw-bold text-muted mb-0">{{ get_phrase('Online Courses') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($total_enrollments) }}+</div>
                        <p class="fw-bold text-muted mb-0">{{ get_phrase('Total Enrollments') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="position-relative pe-lg-5">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200" class="img-fluid rounded-5 shadow-lg" alt="About Us">
                        <div class="position-absolute bg-vibrant-primary text-white p-4 rounded-4 shadow-xl d-none d-md-block" style="bottom: -30px; right: 20px; max-width: 250px;">
                            <h4 class="fw-bold mb-2">10+ {{ get_phrase('Years') }}</h4>
                            <p class="small mb-0 opacity-75">{{ get_phrase('Of excellence in Swiss managed education.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="vibrant-tag mb-4">{{ get_phrase('Who We Are') }}</span>
                    <h2 class="display-5 g-title mb-4">{{ get_phrase('Welcome to Our Learning Platform') }}</h2>
                    <div class="fs-5 text-muted lh-lg mb-5">
                        <p>{{ get_phrase('About Us Full') }}</p>
                        <p>{{ get_phrase('Flexible Learning Full') }}</p>
                    </div>
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-vibrant-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ get_phrase('Expert Mentorship') }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-vibrant-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ get_phrase('Lifetime Access') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-100" style="background: #fff;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="stat-card text-start p-5" style="background: #f8fafc;">
                        <div class="icon-box-vibrant">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <h3 class="display-6 g-title mb-4">{{ get_phrase('Our Mission') }}</h3>
                        <p class="fs-5 text-muted">{{ get_phrase('Mission Statement') }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stat-card text-start p-5" style="background: #f8fafc;">
                        <div class="icon-box-vibrant">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h3 class="display-6 g-title mb-4">{{ get_phrase('Our Vision') }}</h3>
                        <p class="fs-5 text-muted">{{ get_phrase('Vision Statement') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-100 bg-vibrant-dark text-white" style="border-radius: 60px 60px 0 0;">
        <div class="container py-5">
            <div class="text-center mb-5 pb-4">
                <span class="vibrant-tag mb-4 shadow-sm" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">{{ get_phrase('Excellence') }}</span>
                <h2 class="display-4 g-title mb-3">{{ get_phrase('Why Choose Us') }}</h2>
                <p class="text-white opacity-50">{{ get_phrase('Discover what makes us the best choice for your learning journey') }}</p>
            </div>
            
            <div class="row g-5">
                @php
                    $features = [
                        ['icon' => 'fa-globe', 'title' => 'Trusted Swiss Management', 'desc' => 'Swiss Management Description'],
                        ['icon' => 'fa-graduation-cap', 'title' => 'Professional Trainers', 'desc' => 'Professional Trainers Description'],
                        ['icon' => 'fa-laptop-house', 'title' => 'Flexible Learning Options', 'desc' => 'Flexible Learning Description'],
                        ['icon' => 'fa-users', 'title' => 'Supportive Community', 'desc' => 'Community Description'],
                        ['icon' => 'fa-certificate', 'title' => 'Certified Completion', 'desc' => 'Certificates Description'],
                        ['icon' => 'fa-briefcase', 'title' => 'Post-Graduation Service', 'desc' => 'Post-Graduation Description']
                    ];
                @endphp
                
                @foreach($features as $f)
                    <div class="col-lg-4 col-md-6">
                        <div class="p-4 rounded-5 h-100 transition-all hover-translate-y" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <div class="fs-1 text-vibrant-gradient mb-4">
                                <i class="fa-solid {{ $f['icon'] }}"></i>
                            </div>
                            <h4 class="fw-bold mb-3">{{ get_phrase($f['title']) }}</h4>
                            <p class="opacity-75 lh-lg">{{ get_phrase($f['desc']) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5 p-lg-100 rounded-5 text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--vibrant-primary), var(--vibrant-accent));">
                        <div class="position-absolute w-100 h-100 top-0 start-0 opacity-10" style="background: radial-gradient(circle at 100% 100%, white 0%, transparent 60%);"></div>
                        <div class="position-relative z-1 text-white">
                            <h2 class="display-3 g-title mb-4">{{ get_phrase('Join Us Today') }}</h2>
                            <p class="fs-4 opacity-75 mb-5 mx-auto" style="max-width: 700px;">{{ get_phrase('Start Your Journey') }} - {{ get_phrase('Learn Programming From Zero') }}</p>
                            <a href="{{ route('courses') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold shadow-xl border-0 transition-all hover-scale">
                                {{ get_phrase('Get Started') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')@endpush
