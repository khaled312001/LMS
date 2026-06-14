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
    /* Breadcrumb Clearance */
    .mesh-gradient-breadcrumb {
        padding: 180px 0 80px !important;
        background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.08), transparent),
                    radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.08), transparent) !important;
        background-color: #f8fafc !important;
        position: relative;
        overflow: hidden;
    }
    .login-section {
        background-color: #f8fafc;
        padding: 80px 0;
        min-height: 80vh;
        display: flex;
        align-items: center;
    }
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
                                            <input type="email" id="email" name="email" class="form-control" placeholder="{{ get_phrase('Enter your email') }}" required>
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

                                    @if(config('services.google.client_id'))
                                        <div class="d-flex align-items-center my-4">
                                            <div class="flex-grow-1" style="height:1px;background:rgba(0,0,0,0.08);"></div>
                                            <span class="px-3 small text-muted fw-bold">{{ $is_arabic ? 'أو' : get_phrase('OR') }}</span>
                                            <div class="flex-grow-1" style="height:1px;background:rgba(0,0,0,0.08);"></div>
                                        </div>

                                        <a href="{{ route('auth.google') }}" class="btn w-100 py-3 d-flex align-items-center justify-content-center gap-2 fw-bold"
                                           style="border:1px solid rgba(0,0,0,0.12); border-radius: 15px; background:#fff; color:#1f2937; transition:all .25s ease; text-decoration:none;"
                                           onmouseover="this.style.background='#f8fafc';this.style.boxShadow='0 6px 18px rgba(0,0,0,0.08)';"
                                           onmouseout="this.style.background='#fff';this.style.boxShadow='none';">
                                            <svg width="20" height="20" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                                <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                                                <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                                                <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303c-.792 2.237-2.231 4.166-4.087 5.571.001-.001.002-.001.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                                            </svg>
                                            <span>{{ $is_arabic ? 'المتابعة باستخدام جوجل' : get_phrase('Continue with Google') }}</span>
                                        </a>
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
