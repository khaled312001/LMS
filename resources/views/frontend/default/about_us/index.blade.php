@extends('layouts.default')
@push('title', get_phrase('About Us'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <!-- Start Breadcrumb -->
    <section class="breadcum-area page-content-pb-100 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum mt-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb d-flex flex-nowrap">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('About Us') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('About Us') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Breadcrumb -->

    <!-- Statistics Section -->
    <section class="py-80px">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="ps-box text-center p-4">
                        <h2 class="g-title mb-2 text-primary">{{ number_format($total_students) }}+</h2>
                        <p class="description">{{ get_phrase('Happy Students') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="ps-box text-center p-4">
                        <h2 class="g-title mb-2 text-primary">{{ number_format($total_instructors) }}+</h2>
                        <p class="description">{{ get_phrase('Expert Instructors') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="ps-box text-center p-4">
                        <h2 class="g-title mb-2 text-primary">{{ number_format($total_courses) }}+</h2>
                        <p class="description">{{ get_phrase('Online Courses') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="ps-box text-center p-4">
                        <h2 class="g-title mb-2 text-primary">{{ number_format($total_enrollments) }}+</h2>
                        <p class="description">{{ get_phrase('Total Enrollments') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="py-80px bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ps-box p-4">
                        <h2 class="g-title mb-4">{{ get_phrase('Welcome to Our Learning Platform') }}</h2>
                        @if (!empty($about_content))
                            <div class="description-style">
                                {!! htmlspecialchars_decode(removeScripts($about_content)) !!}
                            </div>
                        @else
                            <div class="description-style">
                                <p class="mb-4">{{ get_phrase('We are a leading online learning platform dedicated to providing high-quality education to students worldwide. Our mission is to make education accessible, affordable, and engaging for everyone.') }}</p>
                                
                                <p class="mb-4">{{ get_phrase('With a diverse range of courses taught by expert instructors, we offer comprehensive learning experiences that help students achieve their educational and professional goals. Whether you are looking to advance your career, learn a new skill, or pursue a passion, we have something for everyone.') }}</p>
                                
                                <p class="mb-4">{{ get_phrase('Our platform features:') }}</p>
                                <ul class="mb-4">
                                    <li>{{ get_phrase('High-quality video lessons and interactive content') }}</li>
                                    <li>{{ get_phrase('Expert instructors with real-world experience') }}</li>
                                    <li>{{ get_phrase('Flexible learning schedules that fit your lifestyle') }}</li>
                                    <li>{{ get_phrase('Certificates of completion for your achievements') }}</li>
                                    <li>{{ get_phrase('Lifetime access to course materials') }}</li>
                                    <li>{{ get_phrase('Community support and peer interaction') }}</li>
                                </ul>
                                
                                <p>{{ get_phrase('Join thousands of satisfied students who have transformed their lives through our comprehensive online courses. Start your learning journey today!') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-80px">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="ps-box p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-solid fa-bullseye text-primary fs-32px me-3"></i>
                            <h3 class="g-title mb-0">{{ get_phrase('Our Mission') }}</h3>
                        </div>
                        <p class="description">{{ get_phrase('Our mission is to democratize education by providing high-quality, accessible, and affordable online learning opportunities to students worldwide. We strive to empower individuals to achieve their personal and professional goals through comprehensive, engaging, and practical educational content.') }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-box p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-solid fa-eye text-primary fs-32px me-3"></i>
                            <h3 class="g-title mb-0">{{ get_phrase('Our Vision') }}</h3>
                        </div>
                        <p class="description">{{ get_phrase('We envision a world where quality education is accessible to everyone, regardless of geographical location or financial constraints. Our vision is to become the most trusted and comprehensive online learning platform, recognized for excellence in education delivery and student success.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-80px bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="g-title">{{ get_phrase('Why Choose Us') }}</h2>
                    <p class="description">{{ get_phrase('Discover what makes us the best choice for your learning journey') }}</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-graduation-cap text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Expert Instructors') }}</h4>
                        <p class="description">{{ get_phrase('Learn from industry experts and experienced professionals who bring real-world knowledge to every lesson.') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-certificate text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Certified Courses') }}</h4>
                        <p class="description">{{ get_phrase('Earn recognized certificates upon course completion that can boost your resume and career prospects.') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-clock text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Flexible Learning') }}</h4>
                        <p class="description">{{ get_phrase('Study at your own pace, anytime, anywhere. Our flexible schedule fits your busy lifestyle.') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-video text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('High-Quality Content') }}</h4>
                        <p class="description">{{ get_phrase('Access professionally produced video lessons, interactive quizzes, and comprehensive study materials.') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-users text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Community Support') }}</h4>
                        <p class="description">{{ get_phrase('Join a vibrant community of learners, interact with peers, and get support from instructors.') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-infinity text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Lifetime Access') }}</h4>
                        <p class="description">{{ get_phrase('Get lifetime access to course materials, so you can revisit and review content whenever you need.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Instructors Section -->
    @if (isset($instructors) && $instructors->count() > 0)
    <section class="py-80px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="g-title">{{ get_phrase('Meet Our Expert Instructors') }}</h2>
                    <p class="description">{{ get_phrase('Learn from the best in the industry') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($instructors as $instructor)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="ps-box text-center p-4 h-100">
                            <div class="mb-3">
                                <img src="{{ get_image($instructor->photo) }}" alt="{{ $instructor->name }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <h5 class="g-title mb-2">{{ $instructor->name }}</h5>
                            @if (!empty($instructor->about))
                                <p class="description ellipsis-line-3">{{ Str::limit($instructor->about, 100) }}</p>
                            @endif
                            <a href="{{ route('instructor.details', ['name' => slugify($instructor->name), 'id' => $instructor->id]) }}" class="btn btn-sm btn-primary mt-3">
                                {{ get_phrase('View Profile') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Course Statistics Section -->
    <section class="py-80px bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="g-title">{{ get_phrase('Our Course Offerings') }}</h2>
                    <p class="description">{{ get_phrase('Explore our diverse range of courses') }}</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center">
                        <h3 class="g-title text-primary mb-3">{{ number_format($total_courses) }}+</h3>
                        <p class="description mb-3">{{ get_phrase('Total Courses') }}</p>
                        <p class="description">{{ get_phrase('Comprehensive courses covering various topics and skill levels') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center">
                        <h3 class="g-title text-primary mb-3">{{ number_format($free_courses) }}+</h3>
                        <p class="description mb-3">{{ get_phrase('Free Courses') }}</p>
                        <p class="description">{{ get_phrase('Access quality education without any cost') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center">
                        <h3 class="g-title text-primary mb-3">{{ number_format($premium_courses) }}+</h3>
                        <p class="description mb-3">{{ get_phrase('Premium Courses') }}</p>
                        <p class="description">{{ get_phrase('Advanced courses with in-depth content and expert guidance') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')@endpush
