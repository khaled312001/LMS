@extends('layouts.landing')

{{-- Title tagline only; layouts/seo.blade.php appends the site name and emits all meta/OG tags --}}
@push('title'){{ strtolower(session('language') ?? get_settings('language')) == 'arabic' ? 'منصة تعليمية متخصصة' : 'Professional Learning Platform' }}@endpush

@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
    $ar = [
        'New Era of Learning' => 'بوابتك إلى المهارات الرقمية',
        'Master Your' => 'بوابتك إلى',
        'Future' => 'المهارات الرقمية',
        'with Creative Courseware' => 'التي يصنع بها المستقبل',
        'Empowering students with' => 'في Swiss Bridge Academy نوفّر تجربة تعليمية حديثة وعملية تساعدك على اكتساب مهارات حقيقية في البرمجة، تطوير التطبيقات، الذكاء الاصطناعي، التسويق، التصميم، والمبيعات.',
        'flexible, high-quality' => '',
        'online learning. Discover your potential with our immersive platforms.' => 'نقدّم مسارات تعليمية واضحة تركّز على التطبيق العملي، مع إمكانية التعلّم عن بُعد أو حضوريًا من داخل المركز.',
        'Explore Courses' => 'استكشف البرامج',
        'Latest News' => 'قدّم طلب الانضمام',
        'Trusted By' => 'تعلم عملي. مسارات حديثة. خطوات واضحة نحو مستقبل مهني أقوى.',
        'Live Learners' => 'تطبيقات عملية',
        'Top Rated' => 'خبرة سويسرية',
        '#1 LMS Choice 2026' => 'دقة وجودة في التعليم الإلكتروني',
        'What Do You Want To Learn?' => 'مساراتنا التعليمية',
        'Explore over 1200+ courses across various domains' => 'اختر المجال الذي يناسب أهدافك، وابدأ رحلة تعليمية عملية تساعدك على بناء مهارات حديثة ومطلوبة.',
        'Best Instructors, Best Courses' => 'أفضل المدربين، أفضل الدورات',
        'Handpicked quality content for your career growth' => 'نوفر محتوى تعليمي محدث وفقًا لمتطلبات سوق العمل المحلي والدولي.',
        'Browse All' => 'عرض جميع البرامج',
        'Professional' => 'احترافي',
        'General' => 'عام',
        'Latest from our Blog' => 'لماذا يختارنا الطلاب؟',
        'Stay updated with the latest trends in education and technology' => 'نلتزم بأعلى معايير الجودة والاحترافية، المستمدّة من الخبرات السويسرية في مجال التعليم الإلكتروني.',
        'Career Fast-Track' => 'دعم بعد التخرج',
        'Turn Your Passion Into A' => 'دعم بعد التخرج نحو',
        'Global Career' => 'الخطوة التالية',
        'The world is waiting for your unique skills. Join 45,000+ students and start your journey today with industry-standard training.' => 'بعد إتمام البرنامج بنجاح، نحرص على مساعدة الطالب في الاستعداد بشكل أفضل للمرحلة التالية، من خلال خدمات دعم مهني تساعده على تقديم نفسه بصورة أكثر احترافية.',
        'Get Started For Free' => 'ابدأ طلب الانضمام',
        '+45k Students' => 'مجتمع داعم',
        'Live Success Rate' => 'معدل النجاح',
        'OFF' => 'خصم',
    ];
@endphp

@push('css')
<style>
    /* ===== DESIGN TOKENS ===== */
    :root {
        --lp-primary: #4f46e5;
        --lp-primary-dark: #3730a3;
        --lp-accent: #06b6d4;
        --lp-gold: #f59e0b;
        --lp-success: #10b981;
        --lp-bg: #f8faff;
        --lp-dark: #0f172a;
        --lp-card-radius: 28px;
    }

    /* ===== HERO ===== */
    .vibrant-hero {
        padding: 180px 0 100px;
        background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.12), transparent),
                    radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.1), transparent) !important;
        background-color: var(--lp-bg) !important;
    }

    /* ===== GLASS PILL ===== */
    .glass-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 22px;
        background: rgba(79, 70, 229, 0.08);
        border: 1.5px solid rgba(79, 70, 229, 0.18);
        border-radius: 100px;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--lp-primary);
        letter-spacing: 0.3px;
    }

    /* ===== CATEGORY CIRCLE ===== */
    .category-circle {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15) !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid rgba(255,255,255,0.2) !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .category-item:hover .category-circle {
        transform: rotate(10deg) scale(1.12);
        background: rgba(255,255,255,0.25) !important;
        box-shadow: 0 12px 40px rgba(79, 70, 229, 0.25);
    }

    /* Category section - dark gradient bg */
    #categories {
        background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 60%, #0c1a3a 100%) !important;
    }

    /* ===== COURSE CARDS ===== */
    .vibrant-course-card {
        border-radius: var(--lp-card-radius);
        padding: 8px;
        background: #fff;
        transition: all 0.35s ease;
        border: 1px solid rgba(79, 70, 229, 0.07);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        position: relative;
    }

    .vibrant-course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 60px rgba(79, 70, 229, 0.12);
        border-color: rgba(79, 70, 229, 0.15);
    }

    .vibrant-course-image {
        border-radius: 20px;
        height: 220px;
        object-fit: cover;
        width: 100%;
    }

    .vibrant-tag {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(6, 182, 212, 0.08));
        color: var(--lp-primary);
        padding: 5px 14px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid rgba(79, 70, 229, 0.15);
    }

    /* ===== WHY CHOOSE US ===== */
    #why_us {
        background: linear-gradient(180deg, #f0f4ff 0%, #f8faff 100%) !important;
    }

    #why_us .bento-item {
        border: 1px solid rgba(79, 70, 229, 0.08) !important;
        transition: all 0.3s ease;
    }
    #why_us .bento-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(79, 70, 229, 0.1) !important;
        border-color: rgba(79, 70, 229, 0.2) !important;
    }

    /* ===== FILTER BUTTONS ===== */
    .filter-btn {
        transition: all 0.25s ease !important;
        font-weight: 600 !important;
    }
    .filter-btn.active {
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3) !important;
        transform: translateY(-2px);
    }

    /* ===== ACCORDION ===== */
    .custom-accordion .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.06), rgba(6, 182, 212, 0.04)) !important;
        color: var(--lp-primary) !important;
        box-shadow: none !important;
    }
    .custom-accordion .accordion-button:focus {
        box-shadow: none !important;
    }
    .custom-accordion .accordion-item {
        border: 1px solid rgba(79, 70, 229, 0.08) !important;
        transition: all 0.3s ease;
    }
    .custom-accordion .accordion-item:hover {
        border-color: rgba(79, 70, 229, 0.2) !important;
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.08) !important;
    }

    /* ===== FAQ SECTION ===== */
    #faq {
        background: linear-gradient(180deg, #f0f4ff 0%, #f8faff 100%) !important;
    }

    /* ===== HERO STATS FLOATING CARDS ===== */
    .floating-stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
    }

    /* ===== COURSE SECTION ===== */
    #courses {
        background: linear-gradient(180deg, #ffffff 0%, #f8faff 100%);
    }

    /* ===== ABOUT SECTION ===== */
    #about {
        background: #fff;
    }

    /* ===== BLOG SECTION ===== */
    #blog .bento-item {
        transition: all 0.3s ease;
        border: 1px solid rgba(79, 70, 229, 0.06) !important;
    }
    #blog .bento-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(79, 70, 229, 0.1) !important;
    }

    /* ===== SWIPER PAGINATION ===== */
    .swiper-pagination-bullet-active {
        background: var(--lp-primary) !important;
        width: 24px !important;
        border-radius: 4px !important;
    }
    .swiper-pagination-bullet {
        background: rgba(79, 70, 229, 0.3) !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .bento-hero-grid {
            grid-template-columns: 1fr;
            grid-template-rows: auto;
        }
        .hero-main, .hero-stat-1, .hero-stat-2 { grid-column: span 1; }

        .vibrant-course-image { height: 190px; }

        #home h1.display-1 {
            font-size: 2.6rem !important;
            letter-spacing: -1px !important;
        }
        .floating-3d-card img {
            height: 320px !important;
        }
    }
</style>
@endpush

@section('content')
<!-- Ultra Hero 4.0 -->
<style>
    #home {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding-top: 130px !important;
        padding-bottom: 60px !important;
        position: relative;
        background: #070b1e !important;
        overflow: hidden;
    }
    #home::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(900px 600px at 15% 10%, rgba(99, 102, 241, 0.35), transparent 60%),
            radial-gradient(700px 500px at 90% 85%, rgba(236, 72, 153, 0.25), transparent 60%),
            radial-gradient(700px 600px at 70% 15%, rgba(6, 182, 212, 0.20), transparent 60%),
            linear-gradient(160deg, #070b1e 0%, #0f172a 55%, #1e1b4b 100%);
        z-index: 0;
        pointer-events: none;
    }
    #home::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 28px 28px;
        opacity: 0.5;
        z-index: 0;
        pointer-events: none;
    }
    /* Orb animations */
    .sba-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 1;
        pointer-events: none;
        opacity: 0.55;
    }
    .sba-orb.o1 { width: 380px; height: 380px; background: #6366f1; top: 12%; left: 8%; animation: sba-orb-1 18s ease-in-out infinite; }
    .sba-orb.o2 { width: 320px; height: 320px; background: #ec4899; bottom: 10%; right: 8%; animation: sba-orb-2 22s ease-in-out infinite; }
    .sba-orb.o3 { width: 280px; height: 280px; background: #06b6d4; top: 50%; left: 50%; transform: translate(-50%, -50%); animation: sba-orb-3 25s ease-in-out infinite; }
    @keyframes sba-orb-1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(60px,40px)} }
    @keyframes sba-orb-2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-50px,-30px)} }
    @keyframes sba-orb-3 { 0%,100%{transform:translate(-50%,-50%) scale(1)} 50%{transform:translate(-50%,-50%) scale(1.15)} }

    /* Bright hero typography on dark bg */
    #home h1 { color: #fff !important; }
    #home h1 .text-vibrant-gradient {
        background: linear-gradient(135deg,#fbbf24 0%,#ec4899 50%,#06b6d4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    #home p.fs-4 {
        color: #cbd5e1 !important;
    }
    #home p.fs-4 .text-dark {
        color: #fff !important;
        font-weight: 800;
    }
    #home .glass-pill {
        background: rgba(255,255,255,0.08) !important;
        border: 1px solid rgba(255,255,255,0.18) !important;
        color: #e0e7ff !important;
        backdrop-filter: blur(12px);
    }
    /* Trusted-by chips */
    #home .mt-5.pt-2 p.small {
        color: rgba(255,255,255,0.55) !important;
    }
    #home .mt-5.pt-2 span[style*="background:rgba(255,255,255"] {
        background: rgba(255,255,255,0.08) !important;
        border-color: rgba(255,255,255,0.15) !important;
        color: #e2e8f0 !important;
    }

    /* Stats cards on dark hero */
    #home #sba-stats-row > [class*="col-"] > div {
        background: rgba(255,255,255,0.06) !important;
        border-color: rgba(255,255,255,0.12) !important;
        box-shadow: 0 10px 30px -15px rgba(0,0,0,0.5) !important;
        backdrop-filter: blur(10px);
    }
    #home #sba-stats-row > [class*="col-"] > div > div[style*="color:#64748b"] {
        color: rgba(255,255,255,0.7) !important;
    }

    /* Floating stat cards around hero image */
    #home .hero-visual-container .position-absolute {
        background: #fff !important;
    }
    #home .hero-visual-container img {
        border-color: rgba(255,255,255,0.08) !important;
        box-shadow: 0 30px 80px rgba(0,0,0,0.6) !important;
    }

    /* Outline buttons readable on dark */
    #home .btn-outline-vibrant {
        color: #fff !important;
        border-color: rgba(255,255,255,0.35) !important;
    }
    #home .btn-outline-vibrant:hover {
        background: rgba(255,255,255,0.1) !important;
        border-color: rgba(255,255,255,0.6) !important;
    }

    @media (max-width: 992px) {
        #home { min-height: auto; padding-top: 120px !important; padding-bottom: 40px !important; }
    }

    /* Keep columns truly side-by-side and prevent overlap */
    #home .container > .row {
        position: relative;
        z-index: 3;
    }
    #home .col-lg-7 {
        position: relative;
        z-index: 4;
    }
    #home .col-lg-5 {
        position: relative;
        z-index: 2;
    }
    /* Don't let absolutely-positioned floating cards leak into the text column */
    #home .hero-visual-container {
        max-width: 100%;
        overflow: visible;
    }
    #home .hero-visual-container .position-absolute {
        z-index: 6;
    }
    /* Tighten the hero image so it sits inside its column */
    #home .hero-visual-container img {
        max-width: 100%;
        width: 100%;
        height: 440px !important;
    }
    /* Typography tune-down so 2-column layout fits on standard screens */
    #home h1.display-1 {
        font-size: clamp(2.2rem, 4.2vw, 3.6rem) !important;
        line-height: 1.15 !important;
    }
    #home p.fs-4 {
        font-size: 1.05rem !important;
        line-height: 1.75;
    }
    /* Floating cards shrink a bit so they don't reach the text */
    #home .hero-visual-container > div.position-absolute {
        width: 180px !important;
    }
    /* On tablet, stack the columns so nothing overlaps */
    @media (max-width: 991.98px) {
        #home .col-lg-7,
        #home .col-lg-5 {
            text-align: center;
        }
        #home .hero-visual-container {
            margin-top: 40px;
        }
        #home .hero-visual-container > div.position-absolute {
            display: none !important;
        }
        #home h1.display-1 {
            font-size: 2.2rem !important;
        }
    }
</style>
<section id="home" class="overflow-hidden">
    <span class="sba-orb o1"></span>
    <span class="sba-orb o2"></span>
    <span class="sba-orb o3"></span>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="glass-pill mb-4" data-aos="fade-down" data-aos-duration="1000">
                    <span>🚀</span> {{ $is_arabic ? ($ar['New Era of Learning'] ?? get_phrase('New Era of Learning')) : get_phrase('New Era of Learning') }}
                </div>
                <h1 class="display-1 fw-900 mb-4 lh-1" data-aos="fade-up" data-aos-delay="100" style="letter-spacing: -2px;">
                    {{ $is_arabic ? ($ar['Master Your'] ?? get_phrase('Master Your')) : get_phrase('Master Your') }} <span class="text-vibrant-gradient">{{ $is_arabic ? ($ar['Future'] ?? get_phrase('Future')) : get_phrase('Future') }}</span> {{ $is_arabic ? ($ar['with Creative Courseware'] ?? get_phrase('with Creative Courseware')) : get_phrase('with Creative Courseware') }}
                </h1>
                <p class="fs-4 text-muted mb-5 pe-lg-5" data-aos="fade-up" data-aos-delay="200">
                    {{ $is_arabic ? ($ar['Empowering students with'] ?? get_phrase('Empowering students with')) : get_phrase('Empowering students with') }} <span class="text-dark fw-bold">{{ $is_arabic ? ($ar['flexible, high-quality'] ?? get_phrase('flexible, high-quality')) : get_phrase('flexible, high-quality') }}</span> {{ $is_arabic ? ($ar['online learning. Discover your potential with our immersive platforms.'] ?? get_phrase('online learning. Discover your potential with our immersive platforms.')) : get_phrase('online learning. Discover your potential with our immersive platforms.') }}
                </p>
                <div class="d-flex flex-wrap gap-3 align-items-center" data-aos="fade-up" data-aos-delay="300">
                    <a href="#courses" class="btn-vibrant px-5 py-3 fs-5" style="border-radius: 100px !important;">{{ $is_arabic ? 'استكشف البرامج' : get_phrase('Explore Courses') }}</a>
                    <button type="button" class="btn btn-outline-vibrant border-2 rounded-pill px-5 py-3 fw-bold" onclick="document.getElementById('joinRequestModal') && new bootstrap.Modal(document.getElementById('joinRequestModal')).show()">
                        <i class="fa-solid fa-graduation-cap me-2"></i>{{ $is_arabic ? 'انضم كطالب' : 'Join as Student' }}
                    </button>
                    <button type="button" class="btn btn-outline-vibrant border-2 rounded-pill px-5 py-3 fw-bold" onclick="document.getElementById('instructor_join') && document.getElementById('instructor_join').scrollIntoView({behavior:'smooth'})">
                        <i class="fa-solid fa-chalkboard-user me-2"></i>{{ $is_arabic ? 'انضم كمدرب' : 'Join as Instructor' }}
                    </button>
                </div>
                <!-- Logo Cloud / Social Proof -->
                <div class="mt-5 pt-2" data-aos="fade-up" data-aos-delay="400">
                    <p class="small fw-700 text-uppercase mb-3" style="letter-spacing: 3px; color: #94a3b8;">{{ $is_arabic ? ($ar['Trusted By'] ?? get_phrase('Trusted By')) : get_phrase('Trusted By') }}</p>
                    <div style="display:flex; flex-wrap:wrap; align-items:center; gap:10px; {{ $is_arabic ? 'justify-content:flex-start;direction:rtl;' : '' }}">
                        @foreach([
                            [$is_arabic ? 'تعلم عملي وتطبيقي' : 'Practical Learning', '#4f46e5'],
                            [$is_arabic ? 'عن بُعد أو حضوريًا' : 'Remote or On-site', '#06b6d4'],
                            [$is_arabic ? 'مسارات حديثة' : 'Modern Tracks', '#f59e0b'],
                            [$is_arabic ? 'دعم مهني بعد التخرج' : 'Career Support', '#10b981'],
                        ] as [$brand, $dot])
                        <span style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.85);backdrop-filter:blur(8px);border:1px solid rgba(0,0,0,0.07);border-radius:100px;padding:8px 18px 8px 14px;font-size:0.82rem;font-weight:700;color:#1e293b;box-shadow:0 2px 10px rgba(0,0,0,0.06);transition:all .25s;">
                            <span style="width:8px;height:8px;border-radius:50%;background:{{ $dot }};display:inline-block;flex-shrink:0;"></span>
                            {{ $brand }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 position-relative">
                <div class="sba-hero-image-wrap" data-aos="zoom-in" data-aos-duration="1000">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1200"
                         alt="Students learning"
                         class="sba-hero-image">
                    <div class="sba-hero-image-overlay"></div>

                    {{-- Inline chips inside the image, not floating outside --}}
                    <div class="sba-hero-chip sba-hero-chip-tl">
                        <span class="sba-hero-dot"></span>
                        <div>
                            <div class="sba-hero-chip-label">{{ $is_arabic ? ($ar['Live Learners'] ?? 'Live Learners') : get_phrase('Live Learners') }}</div>
                            <div class="sba-hero-chip-value">12,482+</div>
                        </div>
                    </div>

                    <div class="sba-hero-chip sba-hero-chip-br">
                        <div class="sba-hero-chip-ico"><i class="fa-solid fa-trophy"></i></div>
                        <div>
                            <div class="sba-hero-chip-title">{{ $is_arabic ? 'الأعلى تقييمًا' : 'Top Rated' }}</div>
                            <div class="sba-hero-chip-sub">#1 LMS 2026</div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .sba-hero-image-wrap {
                    position: relative;
                    width: 100%;
                    aspect-ratio: 4 / 5;
                    max-height: 560px;
                    border-radius: 28px;
                    overflow: hidden;
                    box-shadow: 0 35px 70px -20px rgba(0, 0, 0, 0.55);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                }
                .sba-hero-image {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    display: block;
                }
                .sba-hero-image-overlay {
                    position: absolute;
                    inset: 0;
                    background: linear-gradient(180deg, transparent 45%, rgba(7, 11, 30, 0.7) 100%);
                    pointer-events: none;
                }
                .sba-hero-chip {
                    position: absolute;
                    background: rgba(255, 255, 255, 0.96);
                    backdrop-filter: blur(14px);
                    border: 1px solid rgba(255, 255, 255, 0.6);
                    border-radius: 16px;
                    padding: 12px 16px;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
                    z-index: 2;
                }
                .sba-hero-chip-tl {
                    top: 18px;
                    inset-inline-start: 18px;
                }
                .sba-hero-chip-br {
                    bottom: 18px;
                    inset-inline-end: 18px;
                }
                .sba-hero-dot {
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    background: #10b981;
                    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
                    flex-shrink: 0;
                }
                .sba-hero-chip-label {
                    font-size: 0.72rem;
                    font-weight: 700;
                    color: #475569;
                    letter-spacing: 0.3px;
                }
                .sba-hero-chip-value {
                    font-size: 1.1rem;
                    font-weight: 900;
                    background: linear-gradient(135deg, #4f46e5, #7e22ce);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    line-height: 1.2;
                }
                .sba-hero-chip-ico {
                    width: 36px;
                    height: 36px;
                    border-radius: 10px;
                    background: linear-gradient(135deg, #f59e0b, #f97316);
                    color: #fff;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                    box-shadow: 0 6px 14px rgba(245, 158, 11, 0.35);
                }
                .sba-hero-chip-title {
                    font-size: 0.9rem;
                    font-weight: 900;
                    color: #0f172a;
                    line-height: 1.2;
                }
                .sba-hero-chip-sub {
                    font-size: 0.72rem;
                    color: #64748b;
                }
                @media (max-width: 991.98px) {
                    .sba-hero-image-wrap {
                        max-width: 520px;
                        margin: 30px auto 0;
                        aspect-ratio: 16/11;
                    }
                }
            </style>
        </div>
    </div>

    </div>
</section>

<!-- Stats Section - separate section right under the hero -->
<section id="sba-stats-section" style="background: linear-gradient(180deg, #070b1e 0%, #0f172a 100%); padding: 60px 0 70px; position: relative; overflow: hidden;">
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);background-size:28px 28px;opacity:0.6;pointer-events:none;"></div>
    <div class="container position-relative" style="z-index:2;">
        @php
            $brand_grad = 'linear-gradient(135deg,#4f46e5 0%,#7e22ce 50%,#06b6d4 100%)';
            $brand_shadow = 'rgba(79,70,229,0.28)';
            $stats = [
                ['icon'=>'fa-solid fa-users',        'target'=>12000, 'prefix'=>'+', 'suffix'=>'K',  'divide'=>1000, 'decimals'=>0, 'label'=> $is_arabic?'طالب نشط':'Active Students'],
                ['icon'=>'fa-solid fa-book-open',    'target'=>120,   'prefix'=>'+', 'suffix'=>'',   'divide'=>1,    'decimals'=>0, 'label'=> $is_arabic?'دورة تدريبية':'Courses'],
                ['icon'=>'fa-solid fa-circle-check', 'target'=>98,    'prefix'=>'',  'suffix'=>'%',  'divide'=>1,    'decimals'=>0, 'label'=> $is_arabic?'معدل النجاح':'Success Rate'],
                ['icon'=>'fa-solid fa-star',         'target'=>4.9,   'prefix'=>'',  'suffix'=>'',   'divide'=>1,    'decimals'=>1, 'label'=> $is_arabic?'تقييم المنصة':'Rating'],
            ];
        @endphp
        <div class="row g-4 justify-content-center" id="sba-stats-row">
        @foreach($stats as $i => $s)
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ 80 + $i * 70 }}">
            <div style="background:rgba(255,255,255,0.04);border-radius:22px;padding:32px 18px 26px;text-align:center;border:1px solid rgba(255,255,255,0.1);box-shadow:0 20px 50px -20px rgba(0,0,0,0.5);position:relative;overflow:hidden;backdrop-filter:blur(12px);transition:transform .3s,box-shadow .3s,border-color .3s;" onmouseover="this.style.transform='translateY(-8px)';this.style.boxShadow='0 30px 60px {{ $brand_shadow }}';this.style.borderColor='rgba(255,255,255,0.2)'" onmouseout="this.style.transform='';this.style.boxShadow='0 20px 50px -20px rgba(0,0,0,0.5)';this.style.borderColor='rgba(255,255,255,0.1)'">
                <div style="position:absolute;top:-30px;left:50%;transform:translateX(-50%);width:140px;height:140px;border-radius:50%;background:radial-gradient(circle,rgba(99,102,241,0.25) 0%,transparent 70%);pointer-events:none;"></div>
                <div style="position:relative;width:62px;height:62px;border-radius:16px;background:{{ $brand_grad }};display:inline-flex;align-items:center;justify-content:center;margin-bottom:18px;box-shadow:0 10px 24px {{ $brand_shadow }};">
                    <i class="{{ $s['icon'] }}" style="color:#fff;font-size:1.45rem;"></i>
                </div>
                <div class="sba-counter" data-target="{{ $s['target'] }}" data-prefix="{{ $s['prefix'] }}" data-suffix="{{ $s['suffix'] }}" data-divide="{{ $s['divide'] }}" data-decimals="{{ $s['decimals'] }}"
                     style="font-size:2.25rem;font-weight:900;line-height:1;margin-bottom:10px;letter-spacing:-1px;background:linear-gradient(135deg,#fff 0%,#a5b4fc 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    {{ $s['prefix'] }}0{{ $s['suffix'] }}
                </div>
                <div style="font-size:0.8rem;font-weight:700;color:rgba(255,255,255,0.7);text-transform:uppercase;letter-spacing:1.5px;">{{ $s['label'] }}</div>
                <div style="position:absolute;bottom:0;left:0;right:0;height:4px;background:{{ $brand_grad }};"></div>
            </div>
        </div>
        @endforeach
        </div>
        <script>
            (function () {
                function animateCounter(el) {
                    if (el.dataset.sbaAnimated === '1') return;
                    el.dataset.sbaAnimated = '1';
                    var target   = parseFloat(el.dataset.target)   || 0;
                    var prefix   = el.dataset.prefix || '';
                    var suffix   = el.dataset.suffix || '';
                    var divide   = parseFloat(el.dataset.divide)   || 1;
                    var decimals = parseInt(el.dataset.decimals, 10) || 0;
                    var duration = 1800;
                    var start    = performance.now();
                    function frame(t) {
                        var p = Math.min((t - start) / duration, 1);
                        var eased = 1 - Math.pow(1 - p, 3);
                        var current = target * eased;
                        var displayed = (current / divide).toFixed(decimals);
                        el.textContent = prefix + displayed + suffix;
                        if (p < 1) requestAnimationFrame(frame);
                        else el.textContent = prefix + (target / divide).toFixed(decimals) + suffix;
                    }
                    requestAnimationFrame(frame);
                }
                function init() {
                    var counters = document.querySelectorAll('.sba-counter');
                    if (!counters.length) return;
                    if (typeof IntersectionObserver === 'undefined') {
                        counters.forEach(animateCounter);
                        return;
                    }
                    var obs = new IntersectionObserver(function (entries) {
                        entries.forEach(function (e) {
                            if (e.isIntersecting) {
                                animateCounter(e.target);
                                obs.unobserve(e.target);
                            }
                        });
                    }, { threshold: 0.3 });
                    counters.forEach(function (c) { obs.observe(c); });
                }
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', init);
                } else {
                    init();
                }
            })();
        </script>
    </div>
</section>

<!-- Creative Categories -->
<section id="categories" class="py-100 bg-vibrant-dark py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-800 text-white mb-3">{{ $is_arabic ? ($ar['What Do You Want To Learn?'] ?? get_phrase('What Do You Want To Learn?')) : get_phrase('What Do You Want To Learn?') }}</h2>
            <p class="text-white opacity-50">{{ $is_arabic ? ($ar['Explore over 1200+ courses across various domains'] ?? get_phrase('Explore over 1200+ courses across various domains')) : get_phrase('Explore over 1200+ courses across various domains') }}</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            @php
                $icons = [
                    'Node.js' => 'fa-brands fa-node-js',
                    'Vue.js' => 'fa-brands fa-vuejs',
                    'React' => 'fa-brands fa-react',
                    'JavaScript' => 'fa-brands fa-js',
                    'HTML/CSS' => 'fa-solid fa-code',
                    'Web Development' => 'fa-solid fa-laptop-code',
                    'Mobile Development' => 'fa-solid fa-mobile-screen-button',
                    'Design' => 'fa-solid fa-palette',
                    'Marketing' => 'fa-solid fa-bullhorn',
                    'Data Science' => 'fa-solid fa-chart-bar',
                    'Photography' => 'fa-solid fa-camera',
                    'Business' => 'fa-solid fa-briefcase',
                    'Health' => 'fa-solid fa-heart-pulse',
                    'Music' => 'fa-solid fa-music'
                ];
            @endphp
            @php
                $__home_categories = \Illuminate\Support\Facades\Cache::remember('home:parent_categories_with_counts', 600, function () {
                    $cats = App\Models\Category::where('parent_id', 0)->get();
                    $result = [];
                    foreach ($cats as $c) {
                        $cnt = count_category_courses($c->id);
                        if ($cnt > 0) {
                            $result[] = (object) [
                                'id'    => $c->id,
                                'title' => $c->title,
                                'icon'  => $c->icon,
                                'count' => $cnt,
                            ];
                        }
                        if (count($result) >= 8) break;
                    }
                    return $result;
                });
            @endphp
            @foreach ($__home_categories as $category)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="category-item text-center">
                        <a href="javascript:void(0)" class="text-decoration-none d-block p-4 rounded-5 transition-all h-100 bento-item border-0" style="background: rgba(255,255,255,0.03) !important; backdrop-filter: blur(10px); cursor: default;">
                            <div class="category-circle mb-4 mx-auto shadow-lg" style="background: linear-gradient(135deg, #fff, #f8f9fa) !important;">
                                <i class="{{ $icons[$category->title] ?? ($category->icon ?: 'fa-solid fa-graduation-cap') }} text-vibrant-gradient fs-1"></i>
                            </div>
                            <h5 class="text-white fw-900 mb-2">{{ get_phrase($category->title) }}</h5>
                            <span class="badge rounded-pill bg-vibrant-primary px-3 py-2">{{ $category->count }} {{ get_phrase('Courses') }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Vibrant Featured Courses -->
<section id="courses" class="py-100 py-5">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <h2 class="display-5 fw-800">{{ $is_arabic ? ($ar['Best Instructors, Best Courses'] ?? get_phrase('Best Instructors, Best Courses')) : get_phrase('Best Instructors, Best Courses') }}</h2>
                <p class="text-muted">{{ $is_arabic ? ($ar['Handpicked quality content for your career growth'] ?? get_phrase('Handpicked quality content for your career growth')) : get_phrase('Handpicked quality content for your career growth') }}</p>
            </div>
            <a href="{{ route('courses') }}" class="btn btn-outline-vibrant border-2 rounded-pill px-4 fw-bold mb-2">{{ $is_arabic ? ($ar['Browse All'] ?? get_phrase('Browse All')) : get_phrase('Browse All') }}</a>
        </div>
        
        @php
            $current_lang = strtolower(session('language') ?? get_settings('language'));
            [$featured_categories, $all_courses, $__home_category_lookup] = \Illuminate\Support\Facades\Cache::remember(
                'home:featured_courses:v2:' . $current_lang,
                600,
                function () use ($current_lang) {
                    // Show ALL active courses (not language-filtered). Translation happens
                    // per-card via localize_course() so paired courses display in the user's language.
                    $categories = DB::table('categories')->get();
                    $categoryMap = $categories->keyBy('id');
                    $parents = $categories->where('parent_id', 0);
                    $courseCountsByCat = DB::table('courses')
                        ->where('status', 'active')
                        ->selectRaw('category_id, count(*) as cnt')
                        ->groupBy('category_id')
                        ->pluck('cnt', 'category_id');
                    $featured = $parents->filter(function ($p) use ($categoryMap, $courseCountsByCat) {
                        $ids = $categoryMap->where('parent_id', $p->id)->pluck('id')->push($p->id);
                        return $ids->sum(fn($id) => (int) ($courseCountsByCat[$id] ?? 0)) > 0;
                    })->take(5)->values();
                    $courses = DB::table('courses')
                        ->where('status', 'active')
                        ->orderBy('id', 'desc')
                        ->take(24)
                        ->get();
                    return [$featured, $courses, $categoryMap];
                }
            );
            // Localize titles/descriptions to active site language and dedupe paired courses
            $all_courses = localize_courses($all_courses);
        @endphp



        <!-- Course Swiper -->
        <div class="position-relative" data-aos="fade-up" data-aos-delay="200">
        <button class="course-prev-btn" style="position:absolute;top:50%;left:-20px;transform:translateY(-50%);z-index:10;width:48px;height:48px;border-radius:50%;background:#fff;border:none;box-shadow:0 4px 20px rgba(0,0,0,0.15);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--vibrant-primary);font-size:1.2rem;transition:all 0.3s;"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="course-next-btn" style="position:absolute;top:50%;right:-20px;transform:translateY(-50%);z-index:10;width:48px;height:48px;border-radius:50%;background:#fff;border:none;box-shadow:0 4px 20px rgba(0,0,0,0.15);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--vibrant-primary);font-size:1.2rem;transition:all 0.3s;"><i class="fa-solid fa-chevron-right"></i></button>
        <div class="swiper course-swiper pb-5 px-3">
            <div class="swiper-wrapper">
                @foreach ($all_courses as $row)
                    @php
                        $cat_id = $row->category_id;
                        $parent_cat = $__home_category_lookup[$cat_id] ?? null;
                        $parent_id = $parent_cat ? $parent_cat->parent_id : 0;
                    @endphp
                    <div class="swiper-slide course-slide cat-{{ $cat_id }} @if($parent_id > 0) cat-{{ $parent_id }} @endif" style="height: auto;">
                        <div class="vibrant-course-card p-3 h-100 d-flex flex-column" style="margin: 10px;">
                            <div class="position-relative mb-4">
                                <img src="{{ get_image($row->thumbnail) }}" class="vibrant-course-image" alt="{{ $row->title }}">
                                @if($row->discount_flag == 1)
                                    <span class="position-absolute badge bg-danger rounded-pill px-3 py-2 fw-bold shadow-sm" style="top: 15px; left: 15px; z-index: 2;">{{ round((($row->price - $row->discounted_price) / $row->price) * 100) }}% {{ $is_arabic ? ($ar['OFF'] ?? get_phrase('OFF')) : get_phrase('OFF') }}</span>
                                @endif
                            </div>
                            <div class="px-2 flex-grow-1 d-flex flex-column">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="vibrant-tag">{{ get_phrase(($__home_category_lookup[$row->category_id]->title ?? null) ?: 'Professional') }}</span>
                                    <div class="text-warning small fw-bold">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                        <span class="text-muted ms-1">(5.0)</span>
                                    </div>
                                </div>
                                <h4 class="fw-bold mb-4 flex-grow-1">
                                    <a href="{{ route('course.details', $row->slug) }}" class="text-dark text-decoration-none stretched-link">{{ Str::limit($row->title, 50) }}</a>
                                </h4>
                                <div class="d-flex justify-content-end align-items-center border-top pt-4 mt-auto">
                                    <div class="price position-relative" style="z-index: 2;">
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
            <!-- Pagination inside container (to center dots) -->
            <div class="swiper-pagination mt-4 position-relative" style="bottom: 0;"></div>
        </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section id="why_us" class="py-100 py-5" style="background: linear-gradient(160deg, #eef2ff 0%, #f0f9ff 100%);">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="vibrant-tag mb-3 d-inline-block">{{ $is_arabic ? 'مميزاتنا' : 'Why Us' }}</span>
            <h2 class="display-5 fw-800 mt-2">{{ $is_arabic ? 'لماذا يختارنا الطلاب؟' : get_phrase('Why Choose Us') }}</h2>
        </div>

        @php
            $features = [
                ['icon'=>'fi-rr-laptop','title_ar'=>'تعليم عملي يركّز على التطبيق','title_en'=>'Practical Hands-on Learning','desc_ar'=>'نحن نؤمن أن القيمة الحقيقية تأتي من القدرة على استخدام المعرفة، لذلك نركّز على التعلم العملي وليس الاكتفاء بالشرح النظري.','desc_en'=>'We focus on practical learning, not just theoretical explanations.','grad'=>'linear-gradient(135deg,rgba(79,70,229,0.15),rgba(79,70,229,0.05))','color'=>'text-vibrant-primary','bg'=>'#fff','text'=>''],
                ['icon'=>'fi-rr-rocket','title_ar'=>'محتوى حديث يواكب السوق','title_en'=>'Up-to-date Market Content','desc_ar'=>'نصمم برامجنا بما ينسجم مع التغيرات السريعة في العالم الرقمي، حتى يتعلم الطالب مهارات مرتبطة بالواقع الحالي.','desc_en'=>'Programs designed to match the fast-changing digital world.','grad'=>'rgba(255,255,255,0.2)','color'=>'text-white','bg'=>'linear-gradient(135deg, #4f46e5, #7c3aed)','text'=>'color:rgba(255,255,255,0.8);'],
                ['icon'=>'fi-rr-user-md','title_ar'=>'مدربون بخبرة عملية','title_en'=>'Experienced Instructors','desc_ar'=>'يقود العملية التعليمية مدربون لديهم خبرة عملية ومعرفة حقيقية بالمجالات التي يدرّسونها، بما يضمن تجربة أكثر واقعية وفائدة.','desc_en'=>'Instructors with real-world experience lead the learning process.','grad'=>'linear-gradient(135deg,rgba(6,182,212,0.15),rgba(6,182,212,0.05))','color'=>'text-vibrant-accent','bg'=>'#fff','text'=>''],
                ['icon'=>'fi-rr-computer','title_ar'=>'تعلم مرن وواضح','title_en'=>'Flexible & Clear Learning','desc_ar'=>'نوفّر للطالب تجربة تعليمية مرنة ومنظمة، سواء اختار الدراسة عن بُعد أو حضوريًا من داخل المركز.','desc_en'=>'Flexible learning experience, remote or on-site.','grad'=>'linear-gradient(135deg,rgba(16,185,129,0.15),rgba(16,185,129,0.05))','color'=>'text-success','bg'=>'#fff','text'=>''],
                ['icon'=>'fi-rr-comments','title_ar'=>'مزيج لغوي يدعم الفهم وسوق العمل','title_en'=>'Bilingual Approach','desc_ar'=>'نعتمد أسلوبًا يجمع بين العربية والإنجليزية بطريقة تساعد الطالب على الفهم، وفي الوقت نفسه تعرّفه على المصطلحات المستخدمة فعليًا في المجال.','desc_en'=>'Arabic-English mix for deep understanding and industry readiness.','grad'=>'linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.05))','color'=>'text-warning','bg'=>'#fff','text'=>''],
                ['icon'=>'fi-rr-badge-check','title_ar'=>'دعم يمتد لما بعد الدراسة','title_en'=>'Post-graduation Support','desc_ar'=>'لا يتوقف دورنا عند انتهاء الدورة، بل نساعد الطالب أيضًا في الاستعداد للخطوة التالية مهنيًا.','desc_en'=>'Our role extends beyond course completion to career readiness.','grad'=>'linear-gradient(135deg,rgba(126,34,206,0.15),rgba(126,34,206,0.05))','color'=>'text-purple','bg'=>'#fff','text'=>''],
            ];
        @endphp

        <div class="row g-4">
            @foreach($features as $i => $f)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 + $i * 100 }}">
                <div class="h-100 p-5 shadow-sm border-0 d-flex flex-column" style="border-radius: 30px !important; background: {{ $f['bg'] }}; {{ $f['bg'] != '#fff' ? 'color:#fff;' : 'border: 1px solid rgba(79, 70, 229, 0.08);' }}">
                    <div class="mb-4 mx-auto d-flex align-items-center justify-content-center rounded-4" style="width: 70px; height: 70px; background: {{ $f['grad'] }};">
                        <i class="{{ $f['icon'] }} {{ $f['color'] }} fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-center {{ $f['bg'] != '#fff' ? 'text-white' : '' }}">{{ $is_arabic ? $f['title_ar'] : $f['title_en'] }}</h4>
                    <p class="text-center flex-grow-1 mb-0 lh-lg {{ $f['bg'] == '#fff' ? 'text-muted' : '' }}" style="{{ $f['text'] }}">{{ $is_arabic ? $f['desc_ar'] : $f['desc_en'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- About & Vision Section -->
<section id="about" class="py-100 py-5">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-right">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1200" class="w-100 rounded-5 shadow-2xl" style="height: 500px; object-fit: cover;" alt="Team discussing project in a collaborative environment">
                    <div class="position-absolute bottom-0 start-0 bg-white p-4 m-4 rounded-4 shadow-lg animate-float" style="width: 250px;">
                        <h4 class="fw-900 text-vibrant-primary mb-1">{{ $is_arabic ? 'تعليم عملي يربطك بالعالم الرقمي' : 'Practical Digital Education' }}</h4>
                        <p class="mb-0 text-muted small fw-medium">{{ $is_arabic ? 'تعليم رقمي احترافي للناطقين بالعربية بأسلوب حديث ومنظم' : 'Professional digital education for Arabic speakers' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left">
                <span class="vibrant-tag mb-4 d-inline-block">{{ $is_arabic ? 'من نحن' : 'About Us' }}</span>
                <h2 class="display-5 fw-800 mb-4">{{ $is_arabic ? 'تعليم عملي يربطك بالعالم الرقمي الحديث' : 'Practical Education Connecting You to the Modern Digital World' }}</h2>
                <p class="fs-5 text-muted mb-4 lh-lg">
                    {{ $is_arabic ? 'Swiss Bridge Academy هي منصة تعليمية تُدار من سويسرا، وتركّز على تقديم تعليم رقمي احترافي للناطقين باللغة العربية، بأسلوب حديث، منظم، وعملي. هدفنا ليس فقط تقديم محتوى تعليمي، بل بناء تجربة تعلم تساعد الطالب على اكتساب مهارات واضحة وقابلة للتطبيق في الواقع المهني.' : 'Swiss Bridge Academy is an educational platform managed from Switzerland, focused on providing professional digital education for Arabic speakers in a modern, organized, and practical approach.' }}
                </p>
                <p class="text-muted mb-4 lh-lg">
                    {{ $is_arabic ? 'نقدّم برامجنا بمزيج مدروس من اللغة العربية والإنجليزية، حتى يتمكن المتعلّم من الفهم العميق للمفاهيم، وفي الوقت نفسه التعرّف على المصطلحات والأدوات المستخدمة فعليًا في بيئة العمل الحديثة.' : 'We deliver our programs in a balanced mix of Arabic and English, enabling learners to deeply understand concepts while getting familiar with terminology used in the modern workplace.' }}
                </p>
                <div class="d-flex align-items-start gap-4 mb-4 mt-5">
                    <div class="bg-vibrant-light p-3 rounded-circle text-vibrant-primary">
                        <i class="fi-rr-bullseye-pointer fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-2">{{ $is_arabic ? 'رسالتنا' : 'Our Mission' }}</h4>
                        <p class="text-muted">{{ $is_arabic ? 'توفير تعليم عملي واحترافي في مجالات البرمجة والتصميم والتسويق والمبيعات، ومساعدة الخريجين على تحقيق انتقال سلس إلى الحياة المهنية.' : 'Provide practical, professional education and assist graduates in their career transition.' }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-4">
                    <div class="bg-vibrant-light p-3 rounded-circle text-vibrant-accent">
                        <i class="fi-rr-eye fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-2">{{ $is_arabic ? 'رؤيتنا' : 'Our Vision' }}</h4>
                        <p class="text-muted mb-0">{{ $is_arabic ? 'أن نكون الخيار الأول للمتعلّمين العرب الذين يبحثون عن جودة التعليم الأوروبي بلغتهم الأم، مع توفير مسارات واضحة نحو الوظائف.' : 'To be the first choice for Arab learners seeking European quality education in their native language.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog / Why Us Section -->
<section id="blog" class="py-100 py-5" style="background: linear-gradient(180deg, #f8faff 0%, #ffffff 100%);">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="vibrant-tag mb-3 d-inline-block">{{ $is_arabic ? 'لماذا تختار منصتنا؟' : get_phrase('Latest from our Blog') }}</span>
            <h2 class="display-5 fw-800 mt-2">{{ $is_arabic ? ($ar['Latest from our Blog'] ?? get_phrase('Latest from our Blog')) : get_phrase('Latest from our Blog') }}</h2>
            <p class="text-muted">{{ $is_arabic ? ($ar['Stay updated with the latest trends in education and technology'] ?? get_phrase('Stay updated with the latest trends in education and technology')) : get_phrase('Stay updated with the latest trends in education and technology') }}</p>
        </div>
        <div class="row g-4">
            @php
                $__home_lang = strtolower(session('language') ?? get_settings('language'));
                $__home_blogs = \Illuminate\Support\Facades\Cache::remember(
                    'home:latest_blogs:' . $__home_lang,
                    600,
                    function () use ($__home_lang) {
                        $q = App\Models\Blog::where('status', 1);
                        if (in_array($__home_lang, ['english', 'arabic'])) {
                            $q->where('language', $__home_lang);
                        }
                        return $q->orderBy('is_popular', 'desc')->orderBy('id', 'desc')->take(3)->get();
                    }
                );
            @endphp
            @foreach ($__home_blogs as $blog)
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                    <div class="bento-item h-100 p-3 shadow-sm border-0" style="border-radius: 30px !important; background: #fff;">
                        <img src="{{ get_image($blog->thumbnail) }}" class="w-100 mb-4" style="height: 210px; object-fit: cover; border-radius: 22px;" alt="{{ $blog->title }}">
                        <div class="px-2 pb-2">
                            <span class="vibrant-tag mb-3 d-inline-block">{{ $blog->category_id && isset($__home_category_lookup[$blog->category_id]) ? get_phrase($__home_category_lookup[$blog->category_id]->title) : ($is_arabic ? ($ar['General'] ?? get_phrase('General')) : get_phrase('General')) }}</span>
                            <h4 class="fw-bold mb-3">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="text-dark text-decoration-none stretched-link">{{ Str::limit($blog->title, 50) }}</a>
                            </h4>
                            <p class="text-muted small mb-0 lh-lg">{{ Str::limit(strip_tags($blog->description), 110) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Final Call to Action & Post-grad Support -->
<section class="py-100 py-5">
    <div class="container py-5">
        <div class="bento-item p-0 position-relative overflow-hidden shadow-2xl border-0" data-aos="zoom-in-up" data-aos-duration="1000" style="min-height: 500px; border-radius: 50px !important; background: linear-gradient(135deg, var(--vibrant-darker), #1e1b4b) !important;">
            <!-- Animated Background Gradients -->
            <div class="position-absolute" style="top: -100px; left: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(79, 70, 229, 0.4), transparent); filter: blur(60px); opacity: 0.6;"></div>
            <div class="position-absolute" style="bottom: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(6, 182, 212, 0.3), transparent); filter: blur(60px); opacity: 0.4;"></div>
            
            <div class="row align-items-center g-0 h-100">
                <div class="col-lg-7 p-5 p-lg-10 text-white position-relative" data-aos="fade-right" data-aos-delay="200" style="z-index: 5;">
                    <span class="vibrant-tag mb-4 d-inline-block px-4 py-2 border-0" style="background: rgba(255,255,255,0.1); color: var(--vibrant-accent); font-weight: 800; border-radius: 50px;">🚀 {{ $is_arabic ? 'دعم بعد التخرج نحو الخطوة التالية' : get_phrase('Career Fast-Track') }}</span>
                    <h2 class="display-4 fw-800 mb-4 lh-1">
                        {{ $is_arabic ? 'ابدأ اليوم بخطوة تفتح لك أبوابًا جديدة' : 'Start Today, Open New Doors' }}
                    </h2>
                    <p class="fs-5 opacity-80 mb-4 pe-lg-5 fw-medium">{{ $is_arabic ? 'بعد إتمام البرنامج بنجاح، نحرص على مساعدة الطالب في الاستعداد بشكل أفضل للمرحلة التالية، من خلال خدمات دعم مهني تساعده على تقديم نفسه بصورة أكثر احترافية.' : 'After completing the program successfully, we help you prepare for the next step professionally.' }}</p>
                    
                    <ul class="list-unstyled mb-5 opacity-90 fs-6 lh-lg" style="{{ $is_arabic ? 'padding-right: 0;' : 'padding-left: 0;' }}">
                        <li class="d-flex align-items-start gap-3 mb-3"><i class="fa-solid fa-check text-vibrant-accent mt-1 flex-shrink-0"></i><span>{{ $is_arabic ? 'المساعدة في إعداد سيرة ذاتية احترافية' : 'CV Preparation' }}</span></li>
                        <li class="d-flex align-items-start gap-3 mb-3"><i class="fa-solid fa-check text-vibrant-accent mt-1 flex-shrink-0"></i><span>{{ $is_arabic ? 'الدعم في التحضير لمقابلات العمل' : 'Interview Preparation' }}</span></li>
                        <li class="d-flex align-items-start gap-3 mb-3"><i class="fa-solid fa-check text-vibrant-accent mt-1 flex-shrink-0"></i><span>{{ $is_arabic ? 'تحسين الحضور المهني على منصات مثل LinkedIn وBehance' : 'Professional Presence' }}</span></li>
                    </ul>
                    
                        <div class="d-flex flex-wrap gap-4 align-items-center">
                            <a href="{{ route('courses') }}" class="btn-vibrant px-5 py-3 fs-6" style="border-radius: 100px !important;">{{ $is_arabic ? 'استكشف البرامج' : 'Explore Courses' }}</a>
                            <a href="{{ route('register.form') }}" class="btn btn-outline-light border-2 px-5 py-3 fs-6 fw-bold" style="border-radius: 100px !important;">{{ $is_arabic ? 'قدّم طلب الانضمام' : 'Apply Now' }}</a>
                        </div>
                </div>
                <div class="col-lg-5 h-100 d-none d-lg-block position-relative overflow-hidden" data-aos="fade-left" data-aos-delay="400" style="min-height: 500px;">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200" class="position-absolute w-100 h-100 object-fit-cover" alt="CTA" style="opacity: 0.6; filter: contrast(1.2) brightness(0.8);">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, var(--vibrant-darker), transparent 70%);"></div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('components.home_permanent_templates.swiss_bridge_extra_sections')

<!-- Student Join Request Modal -->
<div class="modal fade" id="joinRequestModal" tabindex="-1" aria-labelledby="joinRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 460px;">
        <div class="modal-content border-0 shadow-2xl overflow-hidden" style="border-radius: 20px !important; background: #fff;">
            <div class="modal-header border-0 px-4 pt-3 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-800 mb-0">{{ $is_arabic ? 'تقديم طلب انضمام' : 'Submit Application' }}</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width:32px;height:32px;"><i class="fa-solid fa-xmark small"></i></button>
            </div>
            <div class="modal-body px-4 pt-2 pb-4">
                <p class="text-muted small mb-3">{{ $is_arabic ? 'سيتواصل معك فريقنا لتحديد موعد اختبار المستوى.' : 'Our team will contact you to schedule a placement test.' }}</p>

                <form action="{{ route('contact.store') }}" method="POST" id="joinRequestForm">
                    @csrf
                    <input type="hidden" name="subject" value="New Student Admission Application">

                    <div class="row g-3">
                        <div class="col-6">
                            <input type="text" class="form-control rounded-3 bg-light border-0" name="name" placeholder="{{ $is_arabic ? 'الاسم الكامل *' : 'Full Name *' }}" required style="height:48px;">
                        </div>
                        <div class="col-6">
                            <input type="email" class="form-control rounded-3 bg-light border-0" name="email" placeholder="{{ $is_arabic ? 'البريد الإلكتروني *' : 'Email *' }}" required style="height:48px;">
                        </div>
                        <div class="col-6">
                            <input type="tel" class="form-control rounded-3 bg-light border-0" name="phone" placeholder="{{ $is_arabic ? 'رقم الواتساب *' : 'WhatsApp *' }}" required style="height:48px;">
                        </div>
                        <div class="col-6">
                            <select class="form-select rounded-3 bg-light border-0" name="course_interest" style="height:48px;">
                                <option value="">{{ $is_arabic ? 'التخصص' : 'Program' }}</option>
                                @php $cats = DB::table('categories')->where('parent_id', 0)->get(); @endphp
                                @foreach($cats as $cat)
                                    <option value="{{ $cat->title }}">{{ $is_arabic ? get_phrase($cat->title) : $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control rounded-3 bg-light border-0" name="message" placeholder="{{ $is_arabic ? 'لماذا تريد الانضمام إلينا؟ *' : 'Why join us? *' }}" style="height:90px;" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-vibrant w-100 rounded-pill py-2 fw-bold">{{ $is_arabic ? 'إرسال طلب الانضمام' : 'Submit Application' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts to handle modal trigger -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Open modal for register links
    const applyLinks = document.querySelectorAll('a[href*="register"]');
    applyLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            new bootstrap.Modal(document.getElementById('joinRequestModal')).show();
        });
    });
    // Auto-open modal if redirected from another page with #join hash
    if (window.location.hash === '#join') {
        setTimeout(function() {
            new bootstrap.Modal(document.getElementById('joinRequestModal')).show();
            history.replaceState(null, '', window.location.pathname);
        }, 400);
    }
});
</script>

<!-- FAQ Section -->
<section id="faq" class="py-100 bg-light py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-800">{{ $is_arabic ? 'الأسئلة الشائعة (FAQ)' : 'Frequently Asked Questions' }}</h2>
            <p class="text-muted">{{ $is_arabic ? 'كل ما تحتاج معرفته عن منصتنا وطرق التعلم' : 'Everything you need to know about our platform' }}</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                <div class="accordion custom-accordion" id="faqAccordion">
                    @php
                        $faqs = [
                            [
                                'q_ar' => 'ما هي طرق التعلم المتاحة؟',
                                'a_ar' => 'يمكنك اختيار بين التعلم عن بُعد أو الحضور الشخصي في المركز، بحسب البرنامج المتاح وما يناسب احتياجاتك.',
                                'q_en' => 'What are the available learning methods?',
                                'a_en' => 'You can choose between remote online learning or attending in-person at our center, depending on the available programs and your needs.'
                            ],
                            [
                                'q_ar' => 'هل يتم التدريس باللغة العربية فقط؟',
                                'a_ar' => 'نعتمد أسلوب تدريس يجمع بين العربية والإنجليزية لتسهيل الفهم، وفي الوقت نفسه مساعدة الطالب على التعرف على المصطلحات المستخدمة في المجال.',
                                'q_en' => 'Is the teaching only in Arabic?',
                                'a_en' => 'We adopt a teaching style that blends Arabic and English to facilitate understanding while helping students learn industry-standard terminology.'
                            ],
                            [
                                'q_ar' => 'هل أحتاج إلى خبرة سابقة للتسجيل؟',
                                'a_ar' => 'ليس بالضرورة. لدينا برامج مناسبة لمستويات مختلفة، ويتم تحديد البداية المناسبة من خلال اختبار المستوى والمقابلة.',
                                'q_en' => 'Do I need prior experience to register?',
                                'a_en' => 'Not necessarily. We have programs suitable for different levels, and the right starting point is determined through a placement test and interview.'
                            ],
                            [
                                'q_ar' => 'ماذا يحدث بعد التخرج؟',
                                'a_ar' => 'نوفّر دعمًا يساعد الطالب على الاستعداد بشكل أفضل للمرحلة التالية، مثل المساعدة في السيرة الذاتية، مقابلات العمل، والحضور المهني الرقمي.',
                                'q_en' => 'What happens after graduation?',
                                'a_en' => 'We provide support to better prepare students for their next steps, including help with their resumes, job interviews, and digital professional presence.'
                            ],
                            [
                                'q_ar' => 'كيف تتم عملية الانضمام؟',
                                'a_ar' => 'تتم من خلال طلب انضمام، اختبار مستوى، مقابلة، ثم الدفع والتسجيل.',
                                'q_en' => 'How does the joining process work?',
                                'a_en' => 'It starts with an application form, followed by a placement test, an interview, and finally payment and registration.'
                            ],
                            [
                                'q_ar' => 'هل أحصل على شهادة بعد انتهاء الدورة؟',
                                'a_ar' => 'يمكن منح الطالب شهادة إتمام بعد استكمال متطلبات البرنامج بنجاح.',
                                'q_en' => 'Do I get a certificate after completing the course?',
                                'a_en' => 'Yes, students are awarded a certificate of completion upon successfully finishing the program requirements.'
                            ]
                        ];
                    @endphp

                    @foreach($faqs as $index => $faq)
                        <div class="accordion-item mb-3 border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold p-4 bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index }}">
                                    {{ $is_arabic ? $faq['q_ar'] : $faq['q_en'] }}
                                </button>
                            </h2>
                            <div id="faq-{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body p-4 pt-0 text-muted lh-lg">
                                    {{ $is_arabic ? $faq['a_ar'] : $faq['a_en'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instructor Join Section -->
<section id="instructor_join" class="py-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); position: relative; overflow: hidden;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-white-10" style="background: radial-gradient(circle at 10% 20%, rgba(79, 70, 229, 0.05) 0%, transparent 50%); z-index: 1;"></div>
    
    <div class="container position-relative py-5" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="vibrant-tag mb-4 d-inline-block">{{ $is_arabic ? 'انضم كمدرب' : 'Join as Instructor' }}</span>
                <h2 class="display-4 fw-900 mb-4" style="color: #0f172a; letter-spacing: -1.5px;">
                    {{ $is_arabic ? 'شارك خبرتك وابْنِ' : 'Share Your Expertise &' }} <span class="text-vibrant-gradient">{{ $is_arabic ? 'مستقبلهم' : 'Build Their Future' }}</span>
                </h2>
                <p class="fs-5 text-muted mb-5 lh-lg">
                    {{ $is_arabic ? 'تبحث Swiss Bridge Academy دائماً عن النخبة من المدربين لنقل رسالتنا المبنية على التعليم العملي الجاد. إذا كنت تمتلك الخبرة والشغف، أرسل سيرتك الذاتية وانضم إلينا.' : 'Swiss Bridge Academy is always looking for top trainers to carry our mission of practical and serious education. If you have the expertise and passion, send your CV and join us.' }}
                </p>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-vibrant-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-chalkboard-user fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $is_arabic ? 'بيئة احترافية' : 'Professional Environment' }}</h5>
                        <p class="text-muted small mb-0">{{ $is_arabic ? 'إدارة سويسرية وحلول تقنية متكاملة.' : 'Swiss management and integrated tech solutions.' }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-vibrant-accent text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $is_arabic ? 'مجتمع طلابي شغوف' : 'Passionate Student Community' }}</h5>
                        <p class="text-muted small mb-0">{{ $is_arabic ? 'تفاعل مع طلاب يبحثون عن مهارات حقيقية.' : 'Interact with students looking for real skills.' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="card border-0 shadow-xl rounded-5 overflow-hidden" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px);">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('instructor.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" dir="{{ $is_arabic ? 'rtl' : 'ltr' }}">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="fw-bold mb-0">{{ $is_arabic ? 'نموذج تقديم المدربين' : 'Instructor Application Form' }}</h3>
                                <a href="#" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;" class="btn btn-sm btn-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;" aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
                            </div>

                            @if(Session::has('success'))
                                <div class="alert alert-success rounded-4 fw-bold py-3"><i class="fa-solid fa-check-circle me-2"></i>{{ Session::get('success') }}</div>
                            @endif
                            @if(Session::has('error'))
                                <div class="alert alert-danger rounded-4 fw-bold py-3"><i class="fa-solid fa-circle-exclamation me-2"></i>{{ Session::get('error') }}</div>
                            @endif

                            @php $inp = 'form-control rounded-4 bg-light border-0 px-4'; $inp_style = 'height:58px;text-align:'.($is_arabic?'right':'left').';'; @endphp
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="{{ $inp }}" name="name" placeholder="{{ $is_arabic ? 'الاسم الثلاثي *' : 'Full Name *' }}" required style="{{ $inp_style }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="{{ $inp }}" name="email" placeholder="{{ $is_arabic ? 'البريد الإلكتروني *' : 'Email *' }}" required style="{{ $inp_style }}">
                                </div>
                                <div class="col-md-12">
                                    <input type="tel" class="{{ $inp }}" name="phone" placeholder="{{ $is_arabic ? 'رقم الواتساب *' : 'WhatsApp *' }}" required style="{{ $inp_style }}">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control rounded-4 bg-light border-0 px-4 py-3" name="message" placeholder="{{ $is_arabic ? 'رسالة تعريفية / مجالاتك *' : 'Cover Letter / Your Domains *' }}" style="height:110px;text-align:{{ $is_arabic?'right':'left' }};" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="fw-bold mb-2 d-block text-dark" style="text-align:{{ $is_arabic?'right':'left' }};">{{ $is_arabic ? 'السيرة الذاتية (CV)' : 'Resume / CV' }} <span class="text-danger">*</span></label>
                                    <input class="form-control bg-light border-0 rounded-4" type="file" name="cv" accept=".pdf,.doc,.docx" required style="padding:14px 18px;">
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-vibrant w-100 rounded-pill py-3 fw-bold fs-5 shadow-lg d-flex align-items-center justify-content-center gap-2">
                                        {{ $is_arabic ? 'إرسال الطلب' : 'Submit Application' }} <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
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
    .floating-stat-mini { padding: 14px 18px !important; }
    @media (max-width: 768px) {
        .floating-stat-mini { display: none !important; }
        .hero-visual-container .position-absolute.animate-float { display: none !important; }
    }
</style>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Initialize Swiper for Courses
        var courseSwiper = new Swiper(".course-swiper", {
            slidesPerView: 1,
            spaceBetween: 10,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".course-next-btn",
                prevEl: ".course-prev-btn",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 30 },
            }
        });

        // Course Filtering Logic
        const filterBtns = document.querySelectorAll('.filter-btn');
        const slides = document.querySelectorAll('.course-slide');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Manage Active Classes
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'btn-vibrant');
                    b.classList.add('btn-outline-vibrant');
                });
                btn.classList.add('active', 'btn-vibrant');
                btn.classList.remove('btn-outline-vibrant');
                
                // Get Filter Target
                const filterValue = btn.getAttribute('data-filter');
                
                // Keep track of any match
                let matchCount = 0;
                
                // Show/Hide slides
                slides.forEach(slide => {
                    if (filterValue === 'all' || slide.classList.contains(filterValue)) {
                        slide.style.display = 'block';
                        matchCount++;
                    } else {
                        slide.style.display = 'none';
                    }
                });
                
                // Update swiper internally so it re-calculates pagination and loop
                courseSwiper.update();
                courseSwiper.slideTo(0);
            });
        });
    });
</script>
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
