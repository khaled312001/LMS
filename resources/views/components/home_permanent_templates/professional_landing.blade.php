@extends('layouts.landing')

@push('title', get_phrase('Home'))
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
<section id="home" class="mesh-gradient-bg py-100 overflow-hidden" style="padding-top: 210px !important; background: linear-gradient(160deg, #f8faff 0%, #eef2ff 50%, #f0f9ff 100%) !important;">
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
                <div class="d-flex flex-wrap gap-4 align-items-center" data-aos="fade-up" data-aos-delay="300">
                    <a href="#courses" class="btn-vibrant px-12 py-4 fs-5" style="border-radius: 100px !important;">{{ $is_arabic ? ($ar['Explore Courses'] ?? get_phrase('Explore Courses')) : get_phrase('Explore Courses') }}</a>
                    <a href="{{ route('contact.us') }}" class="btn btn-outline-vibrant border-2 rounded-pill px-5 py-4 fw-bold">{{ $is_arabic ? 'تواصل معنا' : get_phrase('Contact Us') }}</a>
                </div>
                <!-- Logo Cloud / Social Proof -->
                <div class="mt-5 pt-2" data-aos="fade-up" data-aos-delay="400">
                    <p class="small fw-700 text-uppercase mb-3" style="letter-spacing: 3px; color: #94a3b8;">{{ $is_arabic ? ($ar['Trusted By'] ?? get_phrase('Trusted By')) : get_phrase('Trusted By') }}</p>
                    <div style="display:flex; flex-wrap:wrap; align-items:center; gap:10px;">
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
                <div class="hero-visual-container position-relative">
                    <!-- Main Image with 3D Float -->
                    <div class="floating-3d-card relative z-2" data-aos="zoom-in" data-aos-duration="1200">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1200" class="w-100 rounded-5 shadow-2xl" style="height: 500px; object-fit: cover; border: 10px solid #fff;" alt="Student learning on laptop with creative courseware">
                    </div>
                    
                    <!-- Floating Achievement Cards -->
                    <div class="position-absolute animate-float shadow-lg p-4 bg-white rounded-4 border-0" data-aos="fade-left" data-aos-delay="600" style="top: -40px; right: -20px; width: 220px; z-index: 5;">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="bg-success rounded-circle" style="width: 12px; height: 12px;"></div>
                            <span class="small fw-bold">{{ $is_arabic ? ($ar['Live Learners'] ?? get_phrase('Live Learners')) : get_phrase('Live Learners') }}</span>
                        </div>
                        <h4 class="fw-900 mb-0">12,482+</h4>
                    </div>
                    
                    <div class="position-absolute animate-float shadow-lg p-4 bg-vibrant-primary text-white rounded-4 border-0" data-aos="fade-right" data-aos-delay="800" style="bottom: 40px; left: -40px; width: 200px; z-index: 5; animation-delay: 1.5s;">
                        <div class="fs-1 mb-2">🏆</div>
                        <h5 class="fw-bold mb-1">{{ $is_arabic ? ($ar['Top Rated'] ?? get_phrase('Top Rated')) : get_phrase('Top Rated') }}</h5>
                        <p class="small mb-0 opacity-75">{{ $is_arabic ? ($ar['#1 LMS Choice 2026'] ?? get_phrase('#1 LMS Choice 2026')) : get_phrase('#1 LMS Choice 2026') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="container position-relative" style="z-index:10; margin-top:70px;">
        @php
            $stats = [
                ['icon'=>'fi-rr-users',         'value'=>'+12K', 'label'=> $is_arabic?'طالب نشط':'Active Students',  'color'=>'#4f46e5','grad'=>'linear-gradient(135deg,#4f46e5,#7e22ce)','shadow'=>'rgba(79,70,229,0.25)'],
                ['icon'=>'fi-rr-book-open-cover','value'=>'+120', 'label'=> $is_arabic?'دورة تدريبية':'Courses',      'color'=>'#06b6d4','grad'=>'linear-gradient(135deg,#06b6d4,#0ea5e9)','shadow'=>'rgba(6,182,212,0.25)'],
                ['icon'=>'fi-rr-badge-check',   'value'=>'98%',  'label'=> $is_arabic?'معدل النجاح':'Success Rate',  'color'=>'#10b981','grad'=>'linear-gradient(135deg,#10b981,#059669)','shadow'=>'rgba(16,185,129,0.25)'],
                ['icon'=>'fi-rr-star',          'value'=>'4.9★', 'label'=> $is_arabic?'تقييم المنصة':'Rating',       'color'=>'#f59e0b','grad'=>'linear-gradient(135deg,#f59e0b,#f97316)','shadow'=>'rgba(245,158,11,0.25)'],
            ];
        @endphp
        <div class="row g-4 justify-content-center">
        @foreach($stats as $i => $s)
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ 80 + $i * 70 }}">
            <div style="background:#fff;border-radius:20px;padding:28px 16px 24px;text-align:center;border:1px solid rgba(0,0,0,0.06);box-shadow:0 4px 24px rgba(0,0,0,0.07);position:relative;overflow:hidden;transition:transform .3s,box-shadow .3s;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 20px 48px {{ $s['shadow'] }}'" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 24px rgba(0,0,0,0.07)'">
                {{-- icon --}}
                <div style="width:54px;height:54px;border-radius:14px;background:{{ $s['grad'] }};display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;box-shadow:0 8px 20px {{ $s['shadow'] }};">
                    <i class="{{ $s['icon'] }}" style="color:#fff;font-size:1.35rem;"></i>
                </div>
                {{-- value --}}
                <div style="font-size:2rem;font-weight:900;color:{{ $s['color'] }};line-height:1;margin-bottom:8px;letter-spacing:-1px;">{{ $s['value'] }}</div>
                {{-- label --}}
                <div style="font-size:0.78rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1.5px;">{{ $s['label'] }}</div>
                {{-- bottom glow strip --}}
                <div style="position:absolute;bottom:0;left:0;right:0;height:3px;background:{{ $s['grad'] }};border-radius:0 0 20px 20px;"></div>
            </div>
        </div>
        @endforeach
        </div>
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
            @foreach (App\Models\Category::where('parent_id', 0)->get()->filter(fn($c) => count_category_courses($c->id) > 0)->take(8) as $category)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="category-item text-center">
                        <a href="{{ route('courses', $category->slug) }}" class="text-decoration-none d-block p-4 rounded-5 transition-all h-100 bento-item border-0" style="background: rgba(255,255,255,0.03) !important; backdrop-filter: blur(10px);">
                            <div class="category-circle mb-4 mx-auto shadow-lg" style="background: linear-gradient(135deg, #fff, #f8f9fa) !important;">
                                <i class="{{ $icons[$category->title] ?? ($category->icon ?: 'fa-solid fa-graduation-cap') }} text-vibrant-gradient fs-1"></i>
                            </div>
                            <h5 class="text-white fw-900 mb-2">{{ get_phrase($category->title) }}</h5>
                            <span class="badge rounded-pill bg-vibrant-primary px-3 py-2">{{ count_category_courses($category->id) }} {{ get_phrase('Courses') }}</span>
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
            $featured_categories = DB::table('categories')->where('parent_id', 0)->get()->filter(fn($c) => count_category_courses($c->id) > 0)->take(5);
            $all_courses = DB::table('courses')->where('status', 'active')->orderBy('id', 'desc')->take(12)->get();
        @endphp

        <!-- Filters -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-5" data-aos="fade-up">
            <button class="btn btn-vibrant rounded-pill px-4 py-2 filter-btn active" data-filter="all">{{ $is_arabic ? 'الكل' : get_phrase('All') }}</button>
            @foreach ($featured_categories as $cat)
                <button class="btn btn-outline-vibrant border-2 rounded-pill px-4 fw-bold mb-2 filter-btn" data-filter="cat-{{ $cat->id }}">{{ get_phrase($cat->title) }}</button>
            @endforeach
        </div>

        <!-- Course Swiper -->
        <div class="swiper course-swiper pb-5 px-3" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                @foreach ($all_courses as $row)
                    <div class="swiper-slide course-slide cat-{{ $row->category_id }}" style="height: auto;">
                        <div class="vibrant-course-card p-3 h-100 d-flex flex-column" style="margin: 10px;">
                            <div class="position-relative mb-4">
                                <img src="{{ get_image($row->thumbnail) }}" class="vibrant-course-image" alt="{{ $row->title }}">
                                @if($row->discount_flag == 1)
                                    <span class="position-absolute badge bg-danger rounded-pill px-3 py-2 fw-bold shadow-sm" style="top: 15px; left: 15px; z-index: 2;">{{ round((($row->price - $row->discounted_price) / $row->price) * 100) }}% {{ $is_arabic ? ($ar['OFF'] ?? get_phrase('OFF')) : get_phrase('OFF') }}</span>
                                @endif
                            </div>
                            <div class="px-2 flex-grow-1 d-flex flex-column">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="vibrant-tag">{{ get_phrase(App\Models\Category::find($row->category_id)->title ?? 'Professional') }}</span>
                                    <div class="text-warning small fw-bold">
                                        <i class="fa-solid fa-star me-1"></i>4.9
                                    </div>
                                </div>
                                <h4 class="fw-bold mb-4 flex-grow-1">
                                    <a href="{{ route('course.details', $row->slug) }}" class="text-dark text-decoration-none stretched-link">{{ Str::limit($row->title, 50) }}</a>
                                </h4>
                                <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-auto">
                                    <div class="d-flex align-items-center gap-2 position-relative" style="z-index: 2;">
                                        <img src="{{ course_instructor_image($row->id) }}" class="rounded-circle shadow-sm border border-white" style="width: 38px; height: 38px; object-fit: cover;">
                                        <span class="small fw-bold text-dark">{{ course_by_instructor($row->id)->name }}</span>
                                    </div>
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
            @foreach (App\Models\Blog::where('status', 1)->take(3)->get() as $blog)
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                    <div class="bento-item h-100 p-3 shadow-sm border-0" style="border-radius: 30px !important; background: #fff;">
                        <img src="{{ get_image($blog->thumbnail) }}" class="w-100 mb-4" style="height: 210px; object-fit: cover; border-radius: 22px;" alt="{{ $blog->title }}">
                        <div class="px-2 pb-2">
                            <span class="vibrant-tag mb-3 d-inline-block">{{ $blog->category_id ? get_phrase(App\Models\Category::find($blog->category_id)->title) : ($is_arabic ? ($ar['General'] ?? get_phrase('General')) : get_phrase('General')) }}</span>
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
                    
                    <ul class="list-unstyled fa-ul mb-5 opacity-90 fs-6 lh-lg ms-4">
                        <li><span class="fa-li"><i class="fa-solid fa-check text-vibrant-accent"></i></span>{{ $is_arabic ? 'المساعدة في إعداد سيرة ذاتية احترافية' : 'CV Preparation' }}</li>
                        <li><span class="fa-li"><i class="fa-solid fa-check text-vibrant-accent"></i></span>{{ $is_arabic ? 'الدعم في التحضير لمقابلات العمل' : 'Interview Preparation' }}</li>
                        <li><span class="fa-li"><i class="fa-solid fa-check text-vibrant-accent"></i></span>{{ $is_arabic ? 'تحسين الحضور المهني على منصات مثل LinkedIn وBehance' : 'Professional Presence' }}</li>
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
                                'q' => 'ما هي طرق التعلم المتاحة؟',
                                'a' => 'يمكنك اختيار بين التعلم عن بُعد أو الحضور الشخصي في المركز، بحسب البرنامج المتاح وما يناسب احتياجاتك.'
                            ],
                            [
                                'q' => 'هل يتم التدريس باللغة العربية فقط؟',
                                'a' => 'نعتمد أسلوب تدريس يجمع بين العربية والإنجليزية لتسهيل الفهم، وفي الوقت نفسه مساعدة الطالب على التعرف على المصطلحات المستخدمة في المجال.'
                            ],
                            [
                                'q' => 'هل أحتاج إلى خبرة سابقة للتسجيل؟',
                                'a' => 'ليس بالضرورة. لدينا برامج مناسبة لمستويات مختلفة، ويتم تحديد البداية المناسبة من خلال اختبار المستوى والمقابلة.'
                            ],
                            [
                                'q' => 'ماذا يحدث بعد التخرج؟',
                                'a' => 'نوفّر دعمًا يساعد الطالب على الاستعداد بشكل أفضل للمرحلة التالية، مثل المساعدة في السيرة الذاتية، مقابلات العمل، والحضور المهني الرقمي.'
                            ],
                            [
                                'q' => 'كيف تتم عملية الانضمام؟',
                                'a' => 'تتم من خلال طلب انضمام، اختبار مستوى، مقابلة، ثم الدفع والتسجيل.'
                            ],
                            [
                                'q' => 'هل أحصل على شهادة بعد انتهاء الدورة؟',
                                'a' => 'يمكن منح الطالب شهادة إتمام بعد استكمال متطلبات البرنامج بنجاح.'
                            ]
                        ];
                    @endphp

                    @foreach($faqs as $index => $faq)
                        <div class="accordion-item mb-3 border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold p-4 bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index }}">
                                    {{ $faq['q'] }}
                                </button>
                            </h2>
                            <div id="faq-{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body p-4 pt-0 text-muted lh-lg">
                                    {{ $faq['a'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    $(document).ready(function() {
        // Initialize Swiper for Courses
        var courseSwiper = new Swiper(".course-swiper", {
            slidesPerView: 1,
            spaceBetween: 10,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
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
