@extends('layouts.landing')
@push('title', get_phrase('Sign Up'))
@push('meta')@endpush
@push('css')
<style>
    .register-section {
        background-color: #f8fafc;
        padding: 80px 0;
        min-height: 80vh;
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
    .instructor-fields-container {
        background: rgba(79, 70, 229, 0.05);
        border-radius: 20px;
        padding: 25px;
        border: 1px dashed rgba(79, 70, 229, 0.2);
    }
    @php $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic'; @endphp
</style>
@endpush

@section('content')
    <!-- Breadcrumb Area -->
    <section class="mesh-gradient-breadcrumb">
        <div class="container text-center">
            <h1 class="display-4 fw-900 text-dark mb-3 animate__animated animate__fadeInDown">{{ get_phrase('Join Our Community') }}</h1>
            <nav aria-label="breadcrumb" class="animate__animated animate__fadeInUp">
                <ol class="breadcrumb justify-content-center m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none opacity-50">{{ get_phrase('Home') }}</a></li>
                    <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ get_phrase('Sign Up') }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="auth-card overflow-hidden">
                        <div class="row g-0 align-items-start">
                            <div class="col-lg-5 d-none d-lg-block pe-lg-5 border-end border-opacity-10 position-sticky top-0">
                                <div class="p-4 text-center">
                                    <img src="{{ asset('assets/frontend/default/image/signup.gif') }}" alt="Register" class="img-fluid rounded-4 animate__animated animate__zoomIn mb-4" style="max-height: 400px;">
                                    <h3 class="fw-900 text-dark">{{ $is_arabic ? 'مستقبل أفضل' : 'Better Future' }}</h3>
                                    <p class="text-muted">{{ get_phrase('See your growth and get consulting support!') }}</p>
                                    
                                    <div class="mt-5 text-start">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="rounded-circle bg-vibrant-primary-soft p-2 text-vibrant-primary" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fi-rr-check"></i>
                                            </div>
                                            <span class="fw-bold text-dark">{{ get_phrase('Access to 1000+ Courses') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="rounded-circle bg-vibrant-primary-soft p-2 text-vibrant-primary" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fi-rr-check"></i>
                                            </div>
                                            <span class="fw-bold text-dark">{{ get_phrase('Expert-led Content') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 ps-lg-5">
                                <form action="{{ route('register') }}" class="form-vibrant" id="register-form" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="name" class="form-label fw-bold text-dark small text-uppercase letter-spacing-1">{{ get_phrase('Full Name') }}</label>
                                        <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                                        @error('name') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-bold text-dark small text-uppercase letter-spacing-1">{{ get_phrase('Email Address') }}</label>
                                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                                        @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-bold text-dark small text-uppercase letter-spacing-1">{{ get_phrase('Create Password') }}</label>
                                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                        @error('password') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                    </div>

                                    @if (get_settings('allow_instructor'))
                                        <div class="form-check mb-4 p-0">
                                            <div class="d-flex align-items-center gap-2 custom-checkbox-container">
                                                <input id="instructor" type="checkbox" name="instructor" class="form-check-input ms-0">
                                                <label for="instructor" class="form-check-label fw-bold text-vibrant-primary cursor-pointer">{{ get_phrase('Apply to Become an instructor') }}</label>
                                            </div>
                                        </div>

                                        <div id="become-instructor-fields" class="d-none animate__animated animate__fadeIn mb-4">
                                            <div class="instructor-fields-container">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label fw-bold text-dark small text-uppercase">{{ get_phrase('Phone') }}</label>
                                                    <input class="form-control" id="phone" type="phone" name="phone" placeholder="{{ get_phrase('Enter your phone number') }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="document" class="form-label fw-bold text-dark small text-uppercase">{{ get_phrase('Qualification Document') }}</label>
                                                    <input class="form-control" id="document" type="file" name="document">
                                                    <small class="text-muted opacity-75">{{ get_phrase('PDF, JPG, PNG accepted') }}</small>
                                                </div>
                                                <div class="mb-0">
                                                    <label for="description" class="form-label fw-bold text-dark small text-uppercase">{{ get_phrase('Short Bio / Message') }}</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="{{ get_phrase('Tell us about your expertise...') }}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (get_frontend_settings('recaptcha_status'))
                                        <button class="btn-vibrant w-100 py-3 g-recaptcha" data-sitekey="{{ get_frontend_settings('recaptcha_sitekey') }}" data-callback='onLoginSubmit' data-action='submit'>
                                            {{ get_phrase('Create Free Account') }} <i class="fi-rr-arrow-right ms-2 align-middle"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn-vibrant w-100 py-3">
                                            {{ get_phrase('Create Free Account') }} <i class="fi-rr-arrow-right ms-2 align-middle"></i>
                                        </button>
                                    @endif

                                    <div class="mt-5 text-center">
                                        <p class="text-muted mb-0">{{ get_phrase('Already have an account?') }} 
                                            <a href="{{ route('login') }}" class="text-dark fw-900 text-decoration-none border-bottom border-dark">{{ get_phrase('Sign In') }}</a>
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
            document.getElementById("register-form").submit();
        }

        $(document).ready(function() {
            $('#instructor').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#become-instructor-fields').removeClass('d-none');
                    $('#phone').attr('required', true);
                } else {
                    $('#become-instructor-fields').addClass('d-none');
                    $('#phone').attr('required', false);
                }
            });
        });
    </script>
@endpush
