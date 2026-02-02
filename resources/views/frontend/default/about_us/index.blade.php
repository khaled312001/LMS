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
                        <div class="description-style">
                            <p class="mb-4">{{ get_phrase('About Us Full') }}</p>
                            <p class="mb-4">{{ get_phrase('Flexible Learning Full') }}</p>
                            <p class="mb-4">{{ get_phrase('Our Goal') }}</p>
                            <p class="mb-4">{{ get_phrase('Our Team Description') }}</p>
                            
                            <h4 class="g-title mb-3 mt-5">{{ get_phrase('Post-Graduation Service') }}</h4>
                            <p class="mb-3">{{ get_phrase('Career Support Services') }}</p>
                            <ul class="mb-4">
                                <li>{{ get_phrase('Professional CV Preparation') }}</li>
                                <li>{{ get_phrase('Interview Preparation') }}</li>
                                <li>{{ get_phrase('Profile Building') }}</li>
                            </ul>
                        </div>
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
                        <p class="description">{{ get_phrase('Mission Statement') }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-box p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-solid fa-eye text-primary fs-32px me-3"></i>
                            <h3 class="g-title mb-0">{{ get_phrase('Our Vision') }}</h3>
                        </div>
                        <p class="description">{{ get_phrase('Vision Statement') }}</p>
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
                            <i class="fa-solid fa-globe text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Trusted Swiss Management') }}</h4>
                        <p class="description">{{ get_phrase('Swiss Management Description') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-graduation-cap text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Professional Trainers') }}</h4>
                        <p class="description">{{ get_phrase('Professional Trainers Description') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-laptop-house text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Flexible Learning Options') }}</h4>
                        <p class="description">{{ get_phrase('Flexible Learning Description') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-users text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Supportive Community') }}</h4>
                        <p class="description">{{ get_phrase('Community Description') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-certificate text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Certified Completion') }}</h4>
                        <p class="description">{{ get_phrase('Certificates Description') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ps-box p-4 text-center h-100">
                        <div class="mb-3">
                            <i class="fa-solid fa-briefcase text-primary fs-48px"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ get_phrase('Post-Graduation Service') }}</h4>
                        <p class="description">{{ get_phrase('Post-Graduation Description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-80px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="ps-box p-5">
                        <h2 class="g-title mb-4">{{ get_phrase('Join Us Today') }}</h2>
                        <p class="description mb-4">{{ get_phrase('Start Your Journey') }}</p>
                        <p class="description mb-4">{{ get_phrase('Learn Programming From Zero') }}</p>
                        <a href="{{ route('courses') }}" class="btn btn-primary btn-lg mt-3">{{ get_phrase('Get Started') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Instructors Section -->
    @if (isset($instructors) && $instructors->count() > 0)
    <section class="py-80px bg-light">
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
    <section class="py-80px">
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
