@extends('layouts.landing')
@push('title', get_phrase('Log In'))
@push('meta')@endpush
@push('css')
<style>
    .login-section {
        background-color: #f8fafc;
        padding: 80px 0;
        min-height: 60vh;
        display: flex;
        align-items: center;
    }
    .auth-card {
        background: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        border-radius: 40px !important;
        padding: 50px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05) !important;
    }
    .form-vibrant .form-control {
        background: rgba(255, 255, 255, 0.5) !important;
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        border-radius: 15px !important;
        padding: 15px 20px !important;
        transition: all 0.3s ease;
    }
    .form-vibrant .form-control:focus {
        background: #fff !important;
        border-color: var(--vibrant-primary) !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
    }
    @php $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic'; @endphp
</style>
@endpush

@section('content')
    <!-- Breadcrumb Area -->
    <section class="mesh-gradient-breadcrumb">
        <div class="container text-center">
            <h1 class="display-4 fw-900 text-dark mb-3 animate__animated animate__fadeInDown">{{ get_phrase('Welcome Back') }}</h1>
            <nav aria-label="breadcrumb" class="animate__animated animate__fadeInUp">
                <ol class="breadcrumb justify-content-center m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none opacity-50">{{ get_phrase('Home') }}</a></li>
                    <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ get_phrase('Login') }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="auth-card overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6 d-none d-lg-block pe-lg-5 border-end border-opacity-10">
                                <div class="p-4 text-center">
                                    <img src="{{ asset('assets/frontend/default/image/login.gif') }}" alt="Login" class="img-fluid rounded-4 animate__animated animate__zoomIn" style="max-height: 400px;">
                                    <h3 class="fw-900 mt-4 text-dark">{{ $is_arabic ? 'تطوير مستمر' : 'Continuous Growth' }}</h3>
                                    <p class="text-muted">{{ get_phrase('See your growth and get consulting support!') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 ps-lg-5">
                                <form action="{{ route('login') }}" class="form-vibrant mt-2" id="login-form" method="POST">
                                    @csrf
                                    <div class="text-center d-lg-none mb-4">
                                         <h4 class="fw-900 text-dark mb-2">{{ get_phrase('Login') }}</h4>
                                         <p class="text-muted small">{{ get_phrase('See your growth and get consulting support!') }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-bold text-dark small text-uppercase letter-spacing-1">{{ get_phrase('Email Address') }}</label>
                                        <div class="position-relative">
                                            <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com" required>
                                            <i class="fi-rr-envelope position-absolute top-50 translate-middle-y opacity-30 {{ $is_arabic ? 'start-0 ms-3' : 'end-0 me-3' }}"></i>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="password" class="form-label fw-bold text-dark small text-uppercase letter-spacing-1 m-0">{{ get_phrase('Password') }}</label>
                                            <a href="{{route('password.request')}}" class="small text-vibrant-primary fw-bold text-decoration-none">{{ get_phrase('Forgot?') }}</a>
                                        </div>
                                        <div class="position-relative">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                                            <i class="fi-rr-lock position-absolute top-50 translate-middle-y opacity-30 {{ $is_arabic ? 'start-0 ms-3' : 'end-0 me-3' }}"></i>
                                        </div>
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                        <label class="form-check-label small fw-bold text-muted" for="flexCheckChecked">{{ get_phrase('Stay logged in for 30 days') }}</label>
                                    </div>

                                    @if(get_frontend_settings('recaptcha_status'))
                                        <button class="btn-vibrant w-100 py-3 g-recaptcha" data-sitekey="{{ get_frontend_settings('recaptcha_sitekey') }}" data-callback='onLoginSubmit' data-action='submit'>
                                            {{ get_phrase('Login Now') }} <i class="fi-rr-arrow-right ms-2 align-middle"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn-vibrant w-100 py-3">
                                            {{ get_phrase('Login Now') }} <i class="fi-rr-arrow-right ms-2 align-middle"></i>
                                        </button>
                                    @endif

                                    <div class="mt-5 text-center">
                                        <p class="text-muted mb-0">{{ get_phrase("Don't have an account?") }} 
                                            <a href="{{ route('register.form') }}" class="text-dark fw-900 text-decoration-none border-bottom border-dark">{{ get_phrase('Create Account') }}</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        "use strict";
        function onLoginSubmit(token) {
            document.getElementById("login-form").submit();
        }
    </script>
@endpush
