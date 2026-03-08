@extends('layouts.landing')

@push('title', get_phrase('Home'))
@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
    $ar = [
        'New Era of Learning' => 'عصر جديد من التعلم',
        'Master Your' => 'أتقن',
        'Future' => 'مستقبلك',
        'with Creative Courseware' => 'مع حلول تعليمية إبداعية',
        'Empowering students with' => 'تمكين الطلاب من خلال',
        'flexible, high-quality' => 'تعلم مرن عالي الجودة',
        'online learning. Discover your potential with our immersive platforms.' => 'نؤمن بأن التعليم يجب أن يكون ممتعًا وتفاعليًا ومتاحًا للجميع. يتولى التدريب نخبة من الخبراء في مجالات البرمجة والتصميم والتسويق.',
        'Explore Courses' => 'استكشف الدورات',
        'Latest News' => 'اتصل بنا',
        'Trusted By' => 'موثوق من قبل',
        'Live Learners' => 'تطبيقات عملية',
        'Top Rated' => 'خبرة سويسرية',
        '#1 LMS Choice 2026' => 'دقة وجودة في التعليم الإلكتروني',
        'What Do You Want To Learn?' => 'ماذا تريد أن تتعلم؟',
        'Explore over 1200+ courses across various domains' => 'استكشف دوراتنا في البرمجة والتصميم والتسويق',
        'Best Instructors, Best Courses' => 'أفضل المدربين، أفضل الدورات',
        'Handpicked quality content for your career growth' => 'نوفر محتوى تعليمي محدث وفقًا لمتطلبات سوق العمل المحلي والدولي.',
        'Browse All' => 'تصفح الكل',
        'Professional' => 'احترافي',
        'General' => 'عام',
        'Latest from our Blog' => 'لماذا تختار منصتنا؟',
        'Stay updated with the latest trends in education and technology' => 'نلتزم بأعلى معايير الجودة والاحترافية، المستمدّة من الخبرات السويسرية في مجال التعليم الإلكتروني.',
        'Career Fast-Track' => 'خدمة ما بعد التخرج',
        'Turn Your Passion Into A' => 'انطلق نحو',
        'Global Career' => 'سوق العمل',
        'The world is waiting for your unique skills. Join 45,000+ students and start your journey today with industry-standard training.' => 'نساعدكم في الاستعداد للدخول إلى سوق العمل من خلال تجهيز سيرة ذاتية احترافية، والتحضير لمقابلات العمل وبناء ملفك الشخصي.',
        'Get Started For Free' => 'ابدأ الآن رحلتك',
        '+45k Students' => 'مجتمع داعم',
        'Live Success Rate' => 'معدل النجاح',
        'OFF' => 'خصم',
    ];
@endphp

@push('css')
<style>
    .vibrant-hero {
        padding: 180px 0 100px;
        background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.1), transparent),
                    radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.1), transparent) !important;
        background-color: var(--vibrant-light) !important;
    }
    
    .bento-hero-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-template-rows: repeat(2, 300px);
        gap: 24px;
    }

    .hero-main { grid-column: span 8; grid-row: span 2; background: #fff !important; }
    .hero-stat-1 { grid-column: span 4; grid-row: span 1; background: var(--vibrant-primary) !important; color: #fff !important; }
    .hero-stat-2 { grid-column: span 4; grid-row: span 1; background: var(--vibrant-accent) !important; color: #fff !important; }

    .category-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #fff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid rgba(0,0,0,0.05) !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .category-item:hover .category-circle {
        transform: rotate(15deg) scale(1.1);
        border-color: var(--vibrant-primary);
        box-shadow: 0 0 30px rgba(79, 70, 229, 0.2);
    }

    .vibrant-course-card {
        border-radius: 30px;
        padding: 10px;
        background: #fff;
        transition: all 0.4s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .vibrant-course-card:hover {
        transform: scale(1.03);
        box-shadow: 0 40px 80px rgba(0,0,0,0.07);
    }

    .vibrant-course-image {
        border-radius: 24px;
        height: 250px;
        object-fit: cover;
        width: 100%;
    }

    .vibrant-tag {
        background: rgba(79, 70, 229, 0.1);
        color: var(--vibrant-primary);
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    @media (max-width: 991px) {
        .bento-hero-grid {
            grid-template-columns: 1fr;
            grid-template-rows: auto;
        }
        .hero-main, .hero-stat-1, .hero-stat-2 { grid-column: span 1; }
    }
</style>
@endpush

@section('content')
<!-- Ultra Hero 4.0 -->
<section id="home" class="mesh-gradient-bg py-100 overflow-hidden" style="padding-top: 220px !important;">
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
                <div class="mt-5 pt-5" data-aos="fade-up" data-aos-delay="400">
                    <div class="glass-pill py-3 px-5 d-inline-flex flex-wrap align-items-center gap-5 shadow-sm border-0" style="background: rgba(255,255,255,0.4) !important;">
                        <span class="small fw-800 text-uppercase letter-spacing-2 opacity-50">{{ $is_arabic ? ($ar['Trusted By'] ?? get_phrase('Trusted By')) : get_phrase('Trusted By') }}</span>
                        <div class="vr opacity-10 d-none d-md-block" style="height: 30px;"></div>
                        <span class="fw-900 fs-5 text-dark opacity-60 hover-opacity-100 transition-all cursor-default" style="letter-spacing: -1px;">SwissLearningHub</span>
                        <span class="fw-700 fs-5 text-dark opacity-60 hover-opacity-100 transition-all cursor-default" style="font-family: 'Inter', sans-serif;">Taskbase</span>
                        <span class="fw-800 fs-5 text-dark opacity-60 hover-opacity-100 transition-all cursor-default" style="text-transform: uppercase;">Academia</span>
                        <span class="fw-600 fs-5 text-dark opacity-60 hover-opacity-100 transition-all cursor-default">Global Swiss Learning</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 position-relative">
                <div class="hero-visual-container position-relative">
                    <!-- Main Image with 3D Float -->
                    <div class="floating-3d-card relative z-2" data-aos="zoom-in" data-aos-duration="1200">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1200" class="w-100 rounded-5 shadow-2xl" style="height: 500px; object-fit: cover; border: 10px solid #fff;">
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
<section id="why_us" class="py-100 bg-light py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-800">{{ $is_arabic ? 'لماذا تختار منصتنا؟' : get_phrase('Why Choose Us') }}</h2>
            <p class="text-muted">{{ $is_arabic ? 'نلتزم بأعلى معايير الجودة والاحترافية، المستمدّة من الخبرات السويسرية في مجال التعليم الإلكتروني.' : get_phrase('Quality education managed from Switzerland') }}</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="bento-item h-100 p-4 shadow-sm border-0 d-flex flex-column" style="border-radius: 30px !important; background: #fff;">
                    <div class="category-circle mb-4 mx-auto" style="width: 80px; height: 80px; background: rgba(79, 70, 229, 0.1) !important;">
                        <i class="fi-rr-user-md text-vibrant-primary fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-center">{{ $is_arabic ? 'إدارة سويسرية ومدربون محترفون' : 'Swiss Management & Expert Instructors' }}</h4>
                    <p class="text-muted text-center flex-grow-1 mb-0">{{ $is_arabic ? 'فريق من المدربين ذوي خبرة عملية طويلة يقدمون الإرشاد والتوجيه خطوة بخطوة خلال جميع مراحل التعلم بإدارة سويسرية موثوقة.' : 'Expert instructors providing step-by-step guidance.' }}</p>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="bento-item h-100 p-4 shadow-sm border-0 d-flex flex-column" style="border-radius: 30px !important; background: #fff;">
                    <div class="category-circle mb-4 mx-auto" style="width: 80px; height: 80px; background: rgba(6, 182, 212, 0.1) !important;">
                        <i class="fi-rr-computer text-info fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-center">{{ $is_arabic ? 'تعلم مرن ومجتمع داعم' : 'Flexible Learning & Support' }}</h4>
                    <p class="text-muted text-center flex-grow-1 mb-0">{{ $is_arabic ? 'اختر ما يناسبك من التعليم عن بعد أو الحضور المباشر، وكن جزءاً من منتديات تفاعلية تجمع المتعلمين لتبادل الخبرات.' : 'Choose online or in-person learning and join a supportive community.' }}</p>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="bento-item h-100 p-4 shadow-sm border-0 d-flex flex-column" style="border-radius: 30px !important; background: #fff;">
                    <div class="category-circle mb-4 mx-auto" style="width: 80px; height: 80px; background: rgba(245, 158, 11, 0.1) !important;">
                        <i class="fi-rr-badge-check text-warning fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-center">{{ $is_arabic ? 'شهادات إتمام معتمدة' : 'Certified Completion' }}</h4>
                    <p class="text-muted text-center flex-grow-1 mb-0">{{ $is_arabic ? 'شهادات رقمية معترف بها تقدّم للمتدربين عند إكمال الدورات بنجاح، لتعزيز السيرة الذاتية والظهور المهني على الإنترنت.' : 'Recognized digital certificates to boost your resume and professional presence.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About & Vision Section -->
<section id="about" class="py-100 py-5">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-right">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1200" class="w-100 rounded-5 shadow-2xl" style="height: 500px; object-fit: cover;">
                    <div class="position-absolute bottom-0 start-0 bg-white p-4 m-4 rounded-4 shadow-lg animate-float" style="width: 250px;">
                        <h4 class="fw-900 text-vibrant-primary mb-1">الرؤية والرسالة</h4>
                        <p class="mb-0 text-muted small fw-medium">توفير تعليم عملي واحترافي باللغة العربية بمعايير دولية</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left">
                <span class="vibrant-tag mb-4 d-inline-block">{{ $is_arabic ? 'من نحن' : 'About Us' }}</span>
                <h2 class="display-5 fw-800 mb-4">{{ $is_arabic ? 'منصة تعليمية إلكترونية عربية تُدار من سويسرا' : 'Arab E-Learning Platform Managed from Switzerland' }}</h2>
                <p class="fs-5 text-muted mb-4 lh-lg">
                    {{ $is_arabic ? 'نحن منصة متخصصة في تقديم دورات تدريبية احترافية في البرمجة والتصميم والتسويق الرقمي، باستخدام مزيج من اللغة العربية والإنجليزية لضمان الفهم العميق والتطبيق العملي.' : 'We are a specialized platform offering professional training in programming, design, and digital marketing.' }}
                </p>
                <div class="d-flex align-items-start gap-4 mb-4 mt-5">
                    <div class="bg-vibrant-light p-3 rounded-circle text-vibrant-primary">
                        <i class="fi-rr-bullseye-pointer fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-2">{{ $is_arabic ? 'رسالتنا' : 'Our Mission' }}</h4>
                        <p class="text-muted">{{ $is_arabic ? 'توفير تعليم عملي واحترافي في مجالات البرمجة والتصميم والتسويق، ومساعدة الخريجين على تحقيق انتقال سلس إلى الحياة المهنية.' : 'Provide practical, professional education and assist graduates in their career transition.' }}</p>
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
        
        <div class="row g-4">
            @foreach (App\Models\Blog::where('status', 1)->take(3)->get() as $blog)
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                    <div class="bento-item h-100 p-3 shadow-sm border-0" style="border-radius: 30px !important;">
                        <img src="{{ get_image($blog->thumbnail) }}" class="w-100 mb-4" style="height: 200px; object-fit: cover; border-radius: 20px;">
                        <span class="vibrant-tag mb-3 d-inline-block">{{ $blog->category_id ? get_phrase(App\Models\Category::find($blog->category_id)->title) : ($is_arabic ? ($ar['General'] ?? get_phrase('General')) : get_phrase('General')) }}</span>
                        <h4 class="fw-bold mb-3">
                            <a href="{{ route('blog.details', $blog->slug) }}" class="text-dark text-decoration-none stretched-link">{{ Str::limit($blog->title, 50) }}</a>
                        </h4>
                        <p class="text-muted small mb-0">{{ Str::limit(strip_tags($blog->description), 100) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Final Call to Action -->
<section class="py-100 py-5">
    <div class="container py-5">
        <div class="bento-item p-0 position-relative overflow-hidden shadow-2xl border-0" data-aos="zoom-in-up" data-aos-duration="1000" style="min-height: 500px; border-radius: 50px !important; background: linear-gradient(135deg, var(--vibrant-darker), #1e1b4b) !important;">
            <!-- Animated Background Gradients -->
            <div class="position-absolute" style="top: -100px; left: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(79, 70, 229, 0.4), transparent); filter: blur(60px); opacity: 0.6;"></div>
            <div class="position-absolute" style="bottom: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(6, 182, 212, 0.3), transparent); filter: blur(60px); opacity: 0.4;"></div>
            
            <div class="row align-items-center g-0 h-100">
                <div class="col-lg-7 p-5 p-lg-10 text-white position-relative" data-aos="fade-right" data-aos-delay="200" style="z-index: 5;">
                    <span class="vibrant-tag mb-4 d-inline-block px-4 py-2 border-0" style="background: rgba(255,255,255,0.1); color: var(--vibrant-accent); font-weight: 800; border-radius: 50px;">🚀 {{ $is_arabic ? ($ar['Career Fast-Track'] ?? get_phrase('Career Fast-Track')) : get_phrase('Career Fast-Track') }}</span>
                    <h2 class="display-2 fw-800 mb-4 lh-1">
                        {{ $is_arabic ? ($ar['Turn Your Passion Into A'] ?? get_phrase('Turn Your Passion Into A')) : get_phrase('Turn Your Passion Into A') }} <span class="text-vibrant-gradient">{{ $is_arabic ? ($ar['Global Career'] ?? get_phrase('Global Career')) : get_phrase('Global Career') }}</span>
                    </h2>
                    <p class="fs-4 opacity-75 mb-5 pe-lg-5 fw-medium">{{ $is_arabic ? ($ar['The world is waiting for your unique skills. Join 45,000+ students and start your journey today with industry-standard training.'] ?? get_phrase('The world is waiting for your unique skills. Join 45,000+ students and start your journey today with industry-standard training.')) : get_phrase('The world is waiting for your unique skills. Join 45,000+ students and start your journey today with industry-standard training.') }}</p>
                    
                        <div class="d-flex flex-wrap gap-4 align-items-center">
                            <a href="{{ route('register.form') }}" class="btn-vibrant px-12 py-4 fs-5" style="border-radius: 100px !important;">{{ $is_arabic ? ($ar['Get Started For Free'] ?? get_phrase('Get Started For Free')) : get_phrase('Get Started For Free') }}</a>
                            <div class="d-flex -space-x-4">
                                <!-- Placeholder for student avatars -->
                                <div class="bg-white rounded-circle p-1 shadow-sm" style="width: 45px; height: 45px;"><img src="https://i.pravatar.cc/150?u=1" class="rounded-circle w-100 h-100"></div>
                                <div class="bg-white rounded-circle p-1 shadow-sm ms-n2" style="width: 45px; height: 45px;"><img src="https://i.pravatar.cc/150?u=2" class="rounded-circle w-100 h-100"></div>
                                <div class="bg-white rounded-circle p-1 shadow-sm ms-n2" style="width: 45px; height: 45px;"><img src="https://i.pravatar.cc/150?u=3" class="rounded-circle w-100 h-100"></div>
                                <span class="ms-3 fs-6 fw-bold text-white-50">{{ $is_arabic ? ($ar['+45k Students'] ?? get_phrase('+45k Students')) : get_phrase('+45k Students') }}</span>
                            </div>
                        </div>
                </div>
                <div class="col-lg-5 h-100 d-none d-lg-block position-relative overflow-hidden" data-aos="fade-left" data-aos-delay="400" style="min-height: 500px;">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200" class="position-absolute w-100 h-100 object-fit-cover" alt="CTA" style="opacity: 0.6; filter: contrast(1.2) brightness(0.8);">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, var(--vibrant-darker), transparent 70%);"></div>
                    
                    <!-- Floating Card Component -->
                    <div class="position-absolute p-4 backdrop-blur shadow-2xl animate-float" style="bottom: 40px; right: 40px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 24px; width: 250px;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-success rounded-circle" style="width: 10px; height: 10px;"></div>
                            <span class="fw-bold text-white small">{{ $is_arabic ? ($ar['Live Success Rate'] ?? get_phrase('Live Success Rate')) : get_phrase('Live Success Rate') }}</span>
                        </div>
                        <h3 class="text-white fw-bold mb-0">98.2%</h3>
                        <div class="progress mt-3 bg-white-10" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 98%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                                'q' => 'ما هي طرق التعلم المتاحة على المنصة؟',
                                'a' => 'يمكنك اختيار بين التعلم عن بعد عبر الإنترنت أو الحضور الشخصي في المركز التدريبي حسب ما يناسب وقتك ومكانك.'
                            ],
                            [
                                'q' => 'هل تُدرّس الدورات باللغة العربية فقط؟',
                                'a' => 'نعتمد أسلوب تدريس بمزيج من اللغة العربية والإنجليزية لتسهيل الفهم واستخدام المصطلحات التقنية الأكثر شيوعًا في سوق العمل.'
                            ],
                            [
                                'q' => 'هل أحصل على شهادة بعد انتهاء الدورة؟',
                                'a' => 'نعم، بعد إتمام متطلبات الدورة، تحصل على شهادة إتمام إلكترونية معتمدة يمكنك إضافتها إلى سيرتك الذاتية أو حسابك على LinkedIn.'
                            ],
                            [
                                'q' => 'هل هناك دعم بعد انتهاء الدورة؟',
                                'a' => 'بالتأكيد! نقدّم خدمة تجهيز المتخرج لسوق العمل، وتشمل: إعداد سيرة ذاتية احترافية، تدريب على مقابلات العمل، وتطوير الحسابات المهنية على LinkedIn وBehance وGitHub.'
                            ],
                            [
                                'q' => 'هل أحتاج إلى خبرة سابقة للتسجيل؟',
                                'a' => 'ليس بالضرورة. لدينا دورات مخصصة للمبتدئين وأخرى للمستويات المتقدمة، ويمكنك اختيار الدورة المناسبة لمستواك.'
                            ],
                            [
                                'q' => 'كيف أتواصل مع فريق الدعم؟',
                                'a' => 'يمكنك التواصل معنا عبر نموذج “اتصل بنا” على الموقع، أو مراسلتنا عبر البريد الإلكتروني: info@swissbridgeacademy.com'
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
