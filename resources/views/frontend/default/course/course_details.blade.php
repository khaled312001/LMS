@extends('layouts.landing')
@push('title', get_phrase('Course Details'))
@push('meta')@endpush
@push('css')
<style>
    .custom-vibrant-tabs .nav-link {
        color: rgba(15, 23, 42, 0.6);
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .custom-vibrant-tabs .nav-link.active {
        background: var(--vibrant-primary) !important;
        color: white !important;
        border-color: var(--vibrant-primary);
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
    }
    .custom-vibrant-tabs .nav-link:hover:not(.active) {
        background: rgba(79, 70, 229, 0.05);
        color: var(--vibrant-primary) !important;
        border-color: rgba(79, 70, 229, 0.2);
    }
    .breadcum-area .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.3) !important;
    }
    .ps-box.static-menu {
        background: transparent !important;
        border: none !important;
    }
    .tab-content {
        background: var(--vibrant-white);
        border-radius: 30px;
        padding: 40px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }
    .tab-content .g-title, 
    .tab-content h4, 
    .tab-content h3, 
    .tab-content h5, 
    .tab-content p, 
    .tab-content li, 
    .tab-content i,
    .tab-content a:not(.btn):not(.eBtn),
    .tab-content span:not(.badge) {
        color: var(--vibrant-dark) !important;
    }
    .s_stext {
        color: white !important;
        opacity: 0.8;
    }
    .s_stext:hover {
        color: var(--vibrant-accent) !important;
        opacity: 1;
    }
    .accordion-item {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 15px !important;
        margin-bottom: 10px;
        overflow: hidden;
    }
    .accordion-button {
        background: transparent !important;
        color: white !important;
        font-weight: 700 !important;
        box-shadow: none !important;
    }
    .accordion-button:not(.collapsed) {
        color: var(--vibrant-accent) !important;
    }
    .accordion-button::after {
        filter: brightness(0) invert(1);
    }
    .tab-content .fa-star, 
    .tab-content .fa-star-half-alt,
    .text-warning .fa-star {
        color: #f59e0b !important;
    }
    .lesson-list li a path {
        fill: white !important;
    }
    .lesson-list li a:hover {
        background: rgba(255,255,255,0.1) !important;
        border-radius: 10px;
    }
    /* Completely New Swiss Bridge Academy Course Details Layout */
    .sba-bg-light {
        background: #f8fafc !important;
    }

    /* ===== Modern Animated Hero =====
       Note: padding-top is generous so the fixed glass header never overlaps
       the breadcrumb / tag in either language. */
    .sba-course-header {
        background: linear-gradient(135deg, #0b1228 0%, #1a1340 50%, #2a1257 100%);
        padding: 170px 0 90px;
        position: relative;
        overflow: hidden;
        isolation: isolate;
    }
    @media (max-width: 991.98px) {
        .sba-course-header { padding: 130px 0 70px; }
    }
    @media (max-width: 575.98px) {
        .sba-course-header { padding: 110px 0 60px; }
    }
    .sba-course-header h1 {
        font-size: 1.55rem;
        line-height: 1.4;
        margin-bottom: 0.75rem !important;
        background: linear-gradient(120deg, #ffffff 0%, #c7d2fe 60%, #f0abfc 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: sbaTitleIn 0.9s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
    .sba-course-header .lead-desc {
        font-size: 0.95rem;
        line-height: 1.75;
        color: rgba(226, 232, 240, 0.85);
        animation: sbaFadeUp 0.9s 0.15s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
    .sba-course-header .breadcrumb {
        font-size: 0.85rem;
        margin-top: 0.25rem;
        margin-bottom: 1.5rem !important;
        animation: sbaFadeUp 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
    .sba-course-header .breadcrumb-item a {
        color: rgba(199, 210, 254, 0.7) !important;
        transition: color 0.25s;
    }
    .sba-course-header .breadcrumb-item a:hover {
        color: #fff !important;
    }
    .sba-course-header .breadcrumb-item.active {
        color: rgba(255,255,255,0.95) !important;
    }
    .sba-course-header .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(199, 210, 254, 0.4) !important;
    }
    .sba-hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 16px 7px 7px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(167, 139, 250, 0.35);
        border-radius: 100px;
        color: #e0e7ff;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        margin-bottom: 1.25rem;
        backdrop-filter: blur(10px);
        animation: sbaFadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
    .sba-hero-tag .sba-tag-icon {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.75rem;
        box-shadow: 0 4px 12px rgba(168, 85, 247, 0.45);
    }
    .sba-hero-tag .sba-tag-icon i {
        animation: sbaSpark 2.4s ease-in-out infinite;
    }

    /* Meta chips */
    .sba-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        animation: sbaFadeUp 0.9s 0.3s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
    .sba-chip {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 9px 16px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 100px;
        color: #e2e8f0;
        font-size: 0.85rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    .sba-chip:hover {
        background: rgba(255,255,255,0.08);
        border-color: rgba(168, 85, 247, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(168, 85, 247, 0.18);
    }
    .sba-chip i {
        font-size: 0.95rem;
    }
    .sba-chip-rating { background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.3); }
    .sba-chip-rating i { color: #fbbf24; }
    .sba-chip-lang i { color: #38bdf8; }
    .sba-chip-level i { color: #a78bfa; }
    .sba-chip-duration i { color: #34d399; }
    .sba-chip-cert i { color: #f472b6; }

    /* Decorative animated blobs */
    .sba-hero-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.55;
        z-index: 0;
        pointer-events: none;
    }
    .sba-blob-1 {
        width: 380px; height: 380px;
        background: radial-gradient(circle, #6366f1, transparent 70%);
        top: -120px; left: -100px;
        animation: sbaFloat 14s ease-in-out infinite;
    }
    .sba-blob-2 {
        width: 460px; height: 460px;
        background: radial-gradient(circle, #a855f7, transparent 70%);
        bottom: -180px; right: -120px;
        animation: sbaFloat 18s ease-in-out infinite reverse;
    }
    .sba-blob-3 {
        width: 240px; height: 240px;
        background: radial-gradient(circle, #ec4899, transparent 70%);
        top: 30%; right: 25%;
        opacity: 0.35;
        animation: sbaFloat 12s ease-in-out infinite 2s;
    }

    /* Floating decorative icons — sit on the side opposite to the text content
       (RTL: text is on the right, icons on the left; LTR: vice-versa).
       Logical properties (inset-inline-end) handle direction automatically. */
    .sba-hero-deco {
        position: absolute;
        inset-inline-end: 0;
        top: 0;
        bottom: 0;
        width: 42%;
        z-index: 1;
        pointer-events: none;
        display: none;
    }
    @media (min-width: 992px) {
        .sba-hero-deco { display: block; }
    }
    .sba-deco-icon {
        position: absolute;
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 12px 35px rgba(0,0,0,0.25);
    }
    .sba-deco-1 {
        top: 12%;
        inset-inline-end: 18%;
        background: linear-gradient(135deg, #6366f1, #4338ca);
        animation: sbaFloatY 6s ease-in-out infinite;
    }
    .sba-deco-2 {
        top: 55%;
        inset-inline-end: 8%;
        background: linear-gradient(135deg, #a855f7, #7e22ce);
        animation: sbaFloatY 7s ease-in-out infinite 0.8s;
        width: 56px; height: 56px;
        font-size: 1.25rem;
    }
    .sba-deco-3 {
        top: 30%;
        inset-inline-end: 42%;
        background: linear-gradient(135deg, #ec4899, #be185d);
        animation: sbaFloatY 8s ease-in-out infinite 1.5s;
        width: 50px; height: 50px;
        font-size: 1.1rem;
    }
    .sba-deco-4 {
        top: 72%;
        inset-inline-end: 35%;
        background: linear-gradient(135deg, #06b6d4, #0e7490);
        animation: sbaFloatY 9s ease-in-out infinite 0.4s;
        width: 58px; height: 58px;
        font-size: 1.3rem;
    }
    .sba-deco-5 {
        top: 18%;
        inset-inline-end: 50%;
        background: linear-gradient(135deg, #f59e0b, #b45309);
        animation: sbaFloatY 7.5s ease-in-out infinite 1.2s;
        width: 46px; height: 46px;
        font-size: 1rem;
    }

    /* Soft grid pattern overlay */
    .sba-hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
        background-size: 60px 60px;
        mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        z-index: 0;
        pointer-events: none;
    }

    @keyframes sbaTitleIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes sbaFadeUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes sbaFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(40px, -30px) scale(1.08); }
        66% { transform: translate(-30px, 40px) scale(0.95); }
    }
    @keyframes sbaFloatY {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-18px) rotate(6deg); }
    }
    @keyframes sbaSpark {
        0%, 100% { transform: scale(1) rotate(0); opacity: 1; }
        50% { transform: scale(1.2) rotate(15deg); opacity: 0.85; }
    }

    @media (min-width: 768px) {
        .sba-course-header {
            padding: 130px 0 80px;
        }
        .sba-course-header h1 {
            font-size: 2rem;
        }
    }
    @media (min-width: 1200px) {
        .sba-course-header {
            padding: 150px 0 95px;
        }
        .sba-course-header h1 {
            font-size: 2.4rem;
        }
        .sba-course-header .lead-desc {
            font-size: 1.02rem;
        }
    }

    .sba-course-content-wrapper {
        margin-top: -50px;
        position: relative;
        z-index: 20;
        padding-bottom: 60px;
    }

    .sba-main-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
    }
    @media (min-width: 992px) {
        .sba-main-card {
            padding: 36px;
        }
    }

    .sba-pricing-sticky {
        position: sticky;
        top: 100px;
        z-index: 50;
    }

    .sba-shadow-premium {
        box-shadow: 0 20px 50px rgba(79, 70, 229, 0.2);
    }

    .share-icon-vibrant {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white !important;
        transition: all 0.3s ease;
        text-decoration: none !important;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .share-icon-vibrant:hover {
        transform: translateY(-3px);
        background: var(--vibrant-primary);
        border-color: var(--vibrant-primary);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
    }
    .share-icon-vibrant.fb:hover { background: #1877f2; border-color: #1877f2; }
    .share-icon-vibrant.tw:hover { background: #1da1f2; border-color: #1da1f2; }
    .share-icon-vibrant.wa:hover { background: #25d366; border-color: #25d366; }
    .share-icon-vibrant.in:hover { background: #0a66c2; border-color: #0a66c2; }

    /* Vibrant Accordion */
    .custom-vibrant-accordion .accordion-button {
        background: rgba(255,255,255,0.03) !important;
        border: 1px solid rgba(255,255,255,0.05) !important;
        color: white !important;
        box-shadow: none !important;
        transition: all 0.3s ease;
    }
    .custom-vibrant-accordion .accordion-button:not(.collapsed) {
        background: rgba(79, 70, 229, 0.1) !important;
        border-color: rgba(79, 70, 229, 0.3) !important;
        color: var(--vibrant-accent) !important;
    }
    .custom-vibrant-accordion .accordion-button::after {
        filter: brightness(0) invert(1);
    }

    /* Review Styles */
    .vibrant-textarea {
        background: rgba(255,255,255,0.03) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        border-radius: 20px !important;
        color: white !important;
        padding: 20px !important;
        transition: all 0.3s ease;
    }
    .vibrant-textarea:focus {
        background: rgba(255,255,255,0.05) !important;
        border-color: var(--vibrant-primary) !important;
        box-shadow: 0 0 15px rgba(79, 70, 229, 0.2) !important;
    }
    .review-action {
        color: white !important;
        opacity: 0.4;
        text-decoration: none !important;
        transition: all 0.3s ease;
        font-weight: bold;
    }
    .review-action:hover, .review-action.active {
        opacity: 1;
        color: var(--vibrant-primary) !important;
    }
    .review-action i {
        font-size: 1.1rem;
    }

    /* Transitions & Hover Effects */
    .hover-translate-x-5:hover {
        transform: translateX(5px);
    }
    .hover-gap-3:hover {
        gap: 1rem !important;
    }
    .pointer {
        cursor: pointer;
    }
</style>
@endpush
@section('content')
    @php
        $course_creator = get_course_creator_id($course_details->id);
        $instructor_review = collect([]);
        if ($course_creator && isset($course_creator->id)) {
            $instructor_review = App\Models\Instructor_review::where('instructor_id', $course_creator->id)
                ->orderBy('id', 'DESC')
                ->get();
        }

        $review = App\Models\Review::where('course_id', $course_details->id)
            ->orderBy('id', 'DESC')
            ->get();

        $total = $review->count();
        $rating = array_sum(array_column($review->toArray(), 'rating'));

        $average_rating = 0;
        if ($total != 0) {
            $average_rating = $rating / $total;
        }

        $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
    @endphp
    <!------------------- SBA Course Header ------------------->
    @php
        $hero_duration = isset($course_details->id) ? total_durations($course_details->id) : '';
        $hero_level = $course_details->level ?? '';
        $hero_level_label = '';
        if ($hero_level) {
            $level_map_ar = ['beginner' => 'مبتدئ', 'intermediate' => 'متوسط', 'advanced' => 'متقدم', 'everyone' => 'الجميع'];
            $level_map_en = ['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced', 'everyone' => 'All Levels'];
            $hero_level_label = $is_arabic ? ($level_map_ar[$hero_level] ?? ucfirst($hero_level)) : ($level_map_en[$hero_level] ?? ucfirst($hero_level));
        }
    @endphp
    <section class="sba-course-header">
        <!-- Animated background -->
        <div class="sba-hero-grid"></div>
        <div class="sba-hero-blob sba-blob-1"></div>
        <div class="sba-hero-blob sba-blob-2"></div>
        <div class="sba-hero-blob sba-blob-3"></div>

        <!-- Floating decorative icons (desktop only) -->
        <div class="sba-hero-deco" aria-hidden="true">
            <div class="sba-deco-icon sba-deco-1"><i class="fa-solid fa-code"></i></div>
            <div class="sba-deco-icon sba-deco-2"><i class="fa-solid fa-rocket"></i></div>
            <div class="sba-deco-icon sba-deco-3"><i class="fa-solid fa-graduation-cap"></i></div>
            <div class="sba-deco-icon sba-deco-4"><i class="fa-solid fa-laptop-code"></i></div>
            <div class="sba-deco-icon sba-deco-5"><i class="fa-solid fa-lightbulb"></i></div>
        </div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 col-xl-7">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-house me-1" style="font-size:0.75rem;"></i>{{ $is_arabic ? 'الرئيسية' : get_phrase('Home') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active fw-bold" aria-current="page">{{ ellipsis($course_details->title, 50) }}</li>
                        </ol>
                    </nav>

                    <span class="sba-hero-tag">
                        <span class="sba-tag-icon"><i class="fa-solid fa-bolt"></i></span>
                        {{ $is_arabic ? 'دورة احترافية' : get_phrase('Premium Course') }}
                    </span>

                    <h1 class="fw-900">{{ $course_details->title }}</h1>

                    <p class="lead-desc mb-4 pe-lg-4">
                        {{ ellipsis($course_details->short_description, 160) }}
                    </p>

                    <div class="sba-meta-row">
                        <div class="sba-chip sba-chip-rating">
                            <i class="fa-solid fa-star"></i>
                            <span class="fw-bold">{{ number_format($average_rating ?: 5, 1) }}</span>
                            @if ($total > 0)
                                <span class="opacity-75">({{ $total }})</span>
                            @endif
                        </div>

                        @if ($hero_duration)
                            <div class="sba-chip sba-chip-duration">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $hero_duration }}</span>
                            </div>
                        @endif

                        @if ($hero_level_label)
                            <div class="sba-chip sba-chip-level">
                                <i class="fa-solid fa-signal"></i>
                                <span>{{ $hero_level_label }}</span>
                            </div>
                        @endif

                        <div class="sba-chip sba-chip-lang">
                            <i class="fa-solid fa-globe"></i>
                            <span>{{ $is_arabic ? 'عربي / إنجليزي' : 'Arabic & English' }}</span>
                        </div>

                        <div class="sba-chip sba-chip-cert">
                            <i class="fa-solid fa-certificate"></i>
                            <span>{{ $is_arabic ? 'شهادة معتمدة' : 'Certificate' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------------- SBA Course Content Area ------------------->
    <section class="sba-bg-light">
        <div class="container sba-course-content-wrapper">
            <div class="row flex-column-reverse flex-lg-row g-4 align-items-start">
                
                <!-- Main Content Column -->
                <div class="col-lg-8">
                    <div class="sba-main-card">
                        
                        <!-- Tabs -->
                        <ul class="nav nav-pills custom-vibrant-tabs gap-2 mb-5" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-pill px-4 fw-bold" id="pills-overview-tab" data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab">{{ $is_arabic ? 'نظرة عامة' : get_phrase('Overview') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4 fw-bold" id="pills-course-content-tab" data-bs-toggle="pill" data-bs-target="#pills-course-content" type="button" role="tab">{{ $is_arabic ? 'المنهج' : get_phrase('Curriculum') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4 fw-bold" id="pills-details-tab" data-bs-toggle="pill" data-bs-target="#pills-details" type="button" role="tab">{{ $is_arabic ? 'التفاصيل' : get_phrase('Details') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4 fw-bold" id="pills-faq-tab" data-bs-toggle="pill" data-bs-target="#pills-faq" type="button" role="tab">{{ $is_arabic ? 'الأسئلة الشائعة' : get_phrase('FAQ') }}</button>
                            </li>
                        </ul>

                        <div class="tab-content border-0 p-0 shadow-none bg-transparent" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab" tabindex="0">
                                @include('frontend.default.course.overview_area')
                            </div>
                            <div class="tab-pane fade" id="pills-course-content" role="tabpanel" aria-labelledby="pills-course-content-tab" tabindex="0">
                                @include('frontend.default.course.content_area')
                            </div>
                            <div class="tab-pane fade" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab" tabindex="0">
                                @include('frontend.default.course.requirement_outcome_area')
                            </div>
                            <div class="tab-pane fade" id="pills-faq" role="tabpanel" aria-labelledby="pills-faq-tab" tabindex="0">
                                <div class="p-4" style="background:#f8fafc; border-radius:20px;">
                                    @include('frontend.default.course.faq_area')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sticky Sidebar Column -->
                <div class="col-lg-4">
                     <div class="sba-pricing-sticky">
                        @include('frontend.default.course.pricing_card')
                     </div>
                </div>

            </div>
        </div>
    </section>

    <!------------------- Course Area End  --------->



@endsection
@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('#more_description').on('click', function(e) {
                e.preventDefault();

                let ellipsis = $('.description').attr('id');
                $('.description').toggleClass(ellipsis);

                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).text('See less');
                } else {
                    $(this).html('See more <i class="fa-solid fa-angle-right me-2"></i>');
                }
            });
        });
    </script>
@endpush
