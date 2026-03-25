@extends('layouts.landing')
@push('title', get_phrase('Contact us'))
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
    .contact-section {
        background-color: #f8fafc;
        padding: 100px 0;
    }
    .contact-card-vibrant {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 40px;
        padding: 50px 40px;
        transition: all 0.3s ease;
        text-align: center;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
    .contact-card-vibrant:hover {
        transform: translateY(-10px);
        background: #fff;
        box-shadow: 0 30px 60px rgba(0,0,0,0.05);
    }
    .contact-icon-box {
        width: 90px;
        height: 90px;
        border-radius: 32px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(6, 182, 212, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--vibrant-primary);
        margin: 0 auto 30px;
    }
    .form-container-vibrant {
        background: #fff;
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.02);
    }
    .map-container-vibrant {
        border-radius: 40px;
        overflow: hidden;
        height: 100%;
        min-height: 450px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.02);
    }
    .g-title {
        font-weight: 900 !important;
        letter-spacing: -1px;
    }
    .form-control-vibrant {
        border-radius: 20px;
        padding: 15px 25px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        transition: all 0.3s ease;
    }
    .form-control-vibrant:focus {
        border-color: var(--vibrant-primary);
        background: #fff;
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.05);
    }
</style>
@endpush
@section('content')
    @php $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic'; @endphp
    
    @if($is_arabic)
    <style>
        .contact-card-vibrant, .form-container-vibrant { text-align: right !important; direction: rtl !important; }
        .form-label { margin-right: 15px !important; margin-left: 0 !important; display: block; }
        .breadcrumb-item + .breadcrumb-item::before { padding-left: 0.5rem !important; }
        .ms-2 { margin-right: 0.5rem !important; margin-left: 0 !important; }
        .display-3, .display-5 { line-height: 1.4; }
    </style>
    @endif

    <!-- Breadcrumb Area -->
    <section class="mesh-gradient-breadcrumb">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 {{ $is_arabic ? 'text-end' : '' }}">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb {{ $is_arabic ? 'justify-content-end' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ $is_arabic ? 'الرئيسية' : get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $is_arabic ? 'اتصل بنا' : get_phrase('Contact us') }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-3 g-title mb-2">{{ $is_arabic ? 'تواصل معنا' : get_phrase('Get in Touch') }}</h1>
                    <p class="text-muted mb-0 fs-5">{{ $is_arabic ? 'نحن هنا دائماً لمساعدتك. تواصل معنا في أي وقت.' : get_phrase("We're always here to help you. Reach out anytime.") }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="eNtery-item">
        <div class="container">
            <div class="row justify-content-center mt-n5 position-relative z-index-2">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="contact-card-vibrant">
                        <div class="contact-icon-box">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ $is_arabic ? 'عنواننا' : get_phrase('Our Address') }}</h4>
                        <p class="text-muted mb-4">{{ $is_arabic ? 'تفضل بزيارة مكتبنا الرئيسي وتعرف على وجهتنا في سويسرا.' : get_phrase('Visit our main office and experience our culture.') }}</p>
                        <a href="https://maps.google.com/?q=Bahnhofstrasse 37, 8001 Zürich" target="_blank" class="text-vibrant-primary fw-bold text-decoration-none fs-5">Bahnhofstrasse 37, 8001 Zürich</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="contact-card-vibrant">
                        <div class="contact-icon-box">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ $is_arabic ? 'معلومات التواصل' : get_phrase('Contact Info') }}</h4>
                        <p class="text-muted mb-4">{{ $is_arabic ? 'تحدث معنا مباشرة أو اتصل بنا في أي وقت.' : get_phrase('Open a chat or give us a call at any time.') }}</p>
                        <a href="tel:+41779412126" class="text-vibrant-primary fw-bold text-decoration-none fs-5" dir="ltr">+41779412126</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="contact-card-vibrant">
                        <div class="contact-icon-box">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <h4 class="g-title mb-3">{{ $is_arabic ? 'البريد الإلكتروني' : get_phrase('Contact Email') }}</h4>
                        <p class="text-muted mb-4">{{ $is_arabic ? 'أرسل رسالتك مباشرة إلى فريق الدعم الخاص بنا.' : get_phrase('Send your message directly to our support team.') }}</p>
                        <a href="mailto:info@swissbridgeacademy.com" class="text-vibrant-primary fw-bold text-decoration-none fs-5">info@swissbridgeacademy.com</a>
                    </div>
                </div>
            </div>
            <div class="row pt-100 align-items-stretch">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="map-container-vibrant h-100">
                        <iframe class="border-0 w-100 h-100" src="https://maps.google.com/maps?q=Bahnhofstrasse 37, 8001 Zürich&hl={{ $is_arabic ? 'ar' : 'en' }}&z=16&amp;output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="form-container-vibrant">
                        <h2 class="display-5 g-title mb-4">{{ $is_arabic ? 'إرسال رسالة' : get_phrase('Send Message') }}</h2>
                        <p class="text-muted mb-5 fs-5">{{ $is_arabic ? 'لديك استفسار معين؟ املأ النموذج أدناه وسنقوم بالرد عليك في غضون 24 ساعة.' : get_phrase('Have a specific inquiry? Fill out the form below and we will get back to you within 24 hours.') }}</p>
                        
                        <form action="{{ route('contact.store') }}" method="post" class="mt-4" id="global-form">@csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label fw-bold text-dark mb-2">{{ $is_arabic ? 'الاسم' : get_phrase('Name') }}</label>
                                        <input type="text" name="name" class="form-control form-control-vibrant @error('name') border-danger @enderror" placeholder="{{ $is_arabic ? 'اسمك بالكامل' : get_phrase('Your Name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="email" class="form-label fw-bold text-dark mb-2">{{ $is_arabic ? 'البريد الإلكتروني' : get_phrase('Email') }}</label>
                                        <input type="email" name="email" class="form-control form-control-vibrant @error('email') border-danger @enderror" placeholder="{{ $is_arabic ? 'بريدك الإلكتروني' : get_phrase('Your Email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="phone" class="form-label fw-bold text-dark mb-2">{{ $is_arabic ? 'رقم الهاتف' : get_phrase('Phone') }}</label>
                                        <input type="tel" name="phone" class="form-control form-control-vibrant @error('phone') border-danger @enderror" placeholder="{{ $is_arabic ? 'رقم هاتفك' : get_phrase('Your phone') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="address" class="form-label fw-bold text-dark mb-2">{{ $is_arabic ? 'العنوان' : get_phrase('Address') }}</label>
                                        <input type="text" name="address" class="form-control form-control-vibrant @error('address') border-danger @enderror" placeholder="{{ $is_arabic ? 'عنوانك' : get_phrase('Your address') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-group">
                                    <label for="message" class="form-label fw-bold text-dark mb-2">{{ $is_arabic ? 'الرسالة' : get_phrase('Message') }}</label>
                                    <textarea name="message" cols="30" rows="6" class="form-control form-control-vibrant @error('message') border-danger @enderror" placeholder="{{ $is_arabic ? 'اكتب رسالتك هنا...' : get_phrase('Your message here ...') }}"></textarea>
                                </div>
                            </div>

                            @if(get_frontend_settings('recaptcha_status'))
                                <button class="btn btn-vibrant w-100 py-3 rounded-pill fw-bold g-recaptcha" data-sitekey="{{ get_frontend_settings('recaptcha_sitekey') }}" data-callback='onContactSubmit' data-action='submit'>
                                    {{ $is_arabic ? 'إرسال الرسالة' : get_phrase('Send Message') }} <i class="fa-solid fa-paper-plane {{ $is_arabic ? 'me-2' : 'ms-2' }}"></i>
                                </button>
                            @else
                                <button type="submit" class="btn btn-vibrant w-100 py-3 rounded-pill fw-bold">
                                    {{ $is_arabic ? 'إرسال الرسالة' : get_phrase('Send Message') }} <i class="fa-solid fa-paper-plane {{ $is_arabic ? 'me-2' : 'ms-2' }}"></i>
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        "use strict";

        function onContactSubmit(token) {
            document.getElementById("global-form").submit();
        }
        
    </script>
@endpush
