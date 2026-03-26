@php
    $parent_categories = DB::table('categories')->where('parent_id', 0)->latest('id')->get();
    $current_route = Route::currentRouteName();
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp

<header class="vibrant-header d-flex align-items-center justify-content-between">
    <div class="logo-area">
        <a href="{{ route('home') }}">
            <img src="{{ get_image(get_frontend_settings('light_logo')) }}" class="light-logo" alt="{{ $is_arabic ? 'اللوجو' : get_phrase('Logo') }}" style="max-height: 65px;">
            <img src="{{ get_image(get_frontend_settings('dark_logo')) }}" class="dark-logo d-none" alt="{{ $is_arabic ? 'اللوجو' : get_phrase('Logo') }}" style="max-height: 65px;">
        </a>
    </div>

    <nav class="d-none d-lg-block">
        <ul class="d-flex align-items-center gap-2 m-0 p-0 list-unstyled">
            <li><a href="{{ route('home') }}#home" class="nav-link-vibrant active">{{ get_phrase('Home') }}</a></li>
            <li><a href="{{ route('home') }}#courses" class="nav-link-vibrant">{{ get_phrase('Courses') }}</a></li>
            <li><a href="{{ route('home') }}#categories" class="nav-link-vibrant">{{ get_phrase('Categories') }}</a></li>
            <li><a href="{{ route('home') }}#blog" class="nav-link-vibrant">{{ get_phrase('Blog') }}</a></li>
        </ul>
    </nav>

    <div class="action-area d-flex align-items-center gap-3">
        <!-- Language Switcher - Desktop only -->
        <div class="dropdown d-none d-lg-block">
            <button class="btn btn-light rounded-pill px-3 py-2 border-0 shadow-sm dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-globe me-1"></i> {{ get_phrase(ucfirst(session('language') ?? get_settings('language'))) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-3 animate-fade-up" style="border-radius: 20px;">
                @foreach (DB::table('languages')->get() as $language)
                    <li>
                        <a class="dropdown-item rounded-3 {{ (session('language') ?? get_settings('language')) == $language->name ? 'active bg-vibrant-primary text-white' : '' }}"
                           href="{{ route('select.lng', ['language' => $language->name]) }}">
                            {{ ucfirst($language->name) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        @auth
            <!-- User avatar - Desktop only -->
            <div class="dropdown d-none d-lg-block">
                <button class="btn p-0 border-0 dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ get_phrase('User Menu') }}">
                    <img src="{{ get_image(auth()->user()->photo) }}" alt="User" class="rounded-circle" style="width: 40px; height: 40px; border: 2px solid var(--vibrant-primary);">
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-3 animate-fade-up" style="border-radius: 20px; min-width: 220px;">
                    <li class="px-3 py-2 border-bottom mb-2">
                        <p class="mb-0 fw-bold">{{ auth()->user()->name }}</p>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </li>
                    <li><a class="dropdown-item rounded-3" href="{{ route('my.courses') }}"><i class="fi-rr-book-open-cover me-2"></i>{{ get_phrase('My Courses') }}</a></li>
                    <li><a class="dropdown-item rounded-3" href="{{ route('my.profile') }}"><i class="fi-rr-user me-2"></i>{{ get_phrase('Profile') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item rounded-3 text-danger" href="{{ route('logout') }}"><i class="fi-rr-exit me-2"></i>{{ get_phrase('Logout') }}</a></li>
                </ul>
            </div>
        @else
            <!-- Auth buttons - Desktop only -->
            <a href="{{ route('login') }}" class="nav-link-vibrant d-none d-lg-block">{{ get_phrase('Login') }}</a>
            <a href="{{ route('register.form') }}" class="btn-vibrant d-none d-lg-inline-block">{{ $is_arabic ? 'انضم الآن' : get_phrase('Join Free') }}</a>
        @endauth

        <!-- Mobile Hamburger -->
        <button class="btn mobile-menu-btn d-lg-none shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#vibrantMobileNav" aria-controls="vibrantMobileNav" aria-label="{{ $is_arabic ? 'القائمة' : get_phrase('Toggle Menu') }}">
            <i class="fa-solid fa-bars-staggered fs-5"></i>
        </button>
    </div>
</header>

<!-- Vibrant Mobile Nav -->
<div class="offcanvas offcanvas-end border-0 shadow-lg" tabindex="-1" id="vibrantMobileNav" style="border-radius: 28px 0 0 28px; width: 320px;">
    <!-- Offcanvas Header -->
    <div class="offcanvas-header p-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); min-height: 80px;">
        <img src="{{ get_image(get_frontend_settings('light_logo')) }}" alt="{{ $is_arabic ? 'اللوجو' : get_phrase('Logo') }}" style="max-height: 50px; filter: brightness(0) invert(1);">
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close" style="opacity: 0.85; transition: all 0.3s ease; background-color: rgba(255,255,255,0.15); border-radius: 50%; padding: 10px; filter: invert(1);"></button>
    </div>

    <!-- Offcanvas Body -->
    <div class="offcanvas-body p-4 bg-white d-flex flex-column justify-content-between">
        
        <!-- Navigation Links -->
        <div class="mobile-nav-links mt-3">
            <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                <li>
                    <a href="{{ route('home') }}" class="nav-offcanvas-link d-flex align-items-center gap-3 p-3 rounded-4 text-dark text-decoration-none fw-bold" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(79, 70, 229, 0.1);">
                            <i class="fi-rr-home text-primary fs-5"></i>
                        </div>
                        <span class="fs-5">{{ $is_arabic ? 'الرئيسية' : get_phrase('Home') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('courses') }}" class="nav-offcanvas-link d-flex align-items-center gap-3 p-3 rounded-4 text-dark text-decoration-none fw-bold" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(6, 182, 212, 0.1);">
                            <i class="fi-rr-book-alt text-info fs-5"></i>
                        </div>
                        <span class="fs-5">{{ $is_arabic ? 'الدورات' : get_phrase('Courses') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#categories" class="nav-offcanvas-link d-flex align-items-center gap-3 p-3 rounded-4 text-dark text-decoration-none fw-bold" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(245, 158, 11, 0.1);">
                            <i class="fi-rr-apps text-warning fs-5"></i>
                        </div>
                        <span class="fs-5">{{ $is_arabic ? 'الفئات' : get_phrase('Categories') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('blogs') }}" class="nav-offcanvas-link d-flex align-items-center gap-3 p-3 rounded-4 text-dark text-decoration-none fw-bold" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                            <i class="fi-rr-edit text-success fs-5"></i>
                        </div>
                        <span class="fs-5">{{ $is_arabic ? 'المدونة' : get_phrase('Blog') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('register.form') }}" class="nav-offcanvas-link d-flex align-items-center gap-3 p-3 rounded-4 text-decoration-none fw-bold" style="background: linear-gradient(135deg,rgba(79,70,229,0.1),rgba(124,58,237,0.08)); border: 1px solid rgba(79,70,229,0.2); color: var(--vibrant-primary);">
                        <div class="icon-box rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--vibrant-primary);">
                            <i class="fi-rr-user-add text-white fs-5"></i>
                        </div>
                        <span class="fs-5">{{ $is_arabic ? 'تقديم طلب الطالب' : 'Student Application' }}</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Bottom Section -->
        <div class="mobile-nav-bottom mt-5 border-top border-light pt-4">
            <!-- Language Selection -->
            <div class="mb-4">
                <p class="text-secondary small fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="fi-rr-globe"></i> {{ get_phrase('Choose Language') }}
                </p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach (DB::table('languages')->get() as $language)
                        <a href="{{ route('select.lng', ['language' => $language->name]) }}" 
                           class="btn btn-sm rounded-pill px-4 py-2 fw-bold transition-all shadow-sm {{ (session('language') ?? get_settings('language')) == $language->name ? 'btn-primary border-0 text-white' : 'btn-light border text-dark hover-bg-light' }}">
                            {{ ucfirst($language->name) }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Auth Buttons -->
            <div class="d-flex flex-column gap-3 mt-4">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 py-3 rounded-pill fw-bold transition-all fs-6">
                        <i class="fi-rr-sign-in-alt me-2"></i> {{ $is_arabic ? 'تسجيل الدخول' : get_phrase('Login') }}
                    </a>
                    <a href="{{ route('register.form') }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold transition-all shadow-sm fs-6" style="background: var(--vibrant-primary); border: none;">
                        <i class="fi-rr-user-add me-2"></i> {{ $is_arabic ? 'انضم الآن مجاناً' : get_phrase('Get Started Free') }}
                    </a>
                @else
                    <div class="user-info-box p-3 rounded-4 mb-3 d-flex align-items-center gap-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                         <img src="{{ get_image(auth()->user()->photo) }}" alt="User" class="rounded-circle shadow-sm" style="width: 45px; height: 45px; border: 2px solid #fff;">
                         <div>
                             <h6 class="mb-0 fw-bold text-dark">{{ auth()->user()->name }}</h6>
                             <small class="text-secondary">{{ get_phrase('Welcome back!') }}</small>
                         </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('my.courses') }}" class="btn btn-light w-50 py-2 rounded-pill fw-bold border text-dark text-nowrap small"><i class="fi-rr-book-open-cover me-1"></i> {{ get_phrase('Courses') }}</a>
                        <a href="{{ route('my.profile') }}" class="btn btn-light w-50 py-2 rounded-pill fw-bold border text-dark text-nowrap small"><i class="fi-rr-settings me-1"></i> {{ get_phrase('Profile') }}</a>
                    </div>
                    <a href="{{ route('logout') }}" class="btn btn-light w-100 py-3 mt-2 rounded-pill fw-bold text-danger transition-all border">
                        <i class="fi-rr-exit me-2"></i> {{ get_phrase('Logout') }}
                    </a>
                @endguest
            </div>
            
            <!-- Mobile Footer Info -->
            <div class="text-center mt-5 pt-3">
                <p class="text-muted small mb-0 fw-medium">© {{ date('Y') }} {{ get_frontend_settings('website_title') }}</p>
                <div class="d-flex justify-content-center gap-3 mt-2">
                    <a href="#" class="text-muted text-decoration-none transition-all hover-text-primary" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="text-muted text-decoration-none transition-all hover-text-primary" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="text-muted text-decoration-none transition-all hover-text-primary" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="text-muted text-decoration-none transition-all hover-text-primary" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== Mobile Offcanvas Sidebar ===== */
    #vibrantMobileNav {
        background: #fff !important;
    }
    #vibrantMobileNav .offcanvas-header {
        background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;
        border-bottom: none !important;
    }
    #vibrantMobileNav .offcanvas-header img {
        filter: brightness(0) invert(1) !important;
    }
    #vibrantMobileNav .btn-close {
        filter: invert(1) !important;
        opacity: 0.8 !important;
        background-color: rgba(255,255,255,0.15) !important;
        border-radius: 50% !important;
        transition: all 0.3s ease !important;
    }
    #vibrantMobileNav .btn-close:hover {
        background-color: rgba(255,255,255,0.3) !important;
        transform: rotate(90deg);
        opacity: 1 !important;
    }
    #vibrantMobileNav .hover-bg-light:hover {
        background-color: #f1f5ff !important;
        border-color: rgba(79,70,229,0.3) !important;
    }
    #vibrantMobileNav .hover-text-primary:hover {
        color: var(--vibrant-primary) !important;
        transform: translateY(-2px);
    }
    #vibrantMobileNav .mobile-nav-links a {
        transition: all 0.25s ease !important;
    }
    #vibrantMobileNav .mobile-nav-links a:hover,
    #vibrantMobileNav .mobile-nav-links a.active-link {
        background: linear-gradient(135deg, rgba(79,70,229,0.08), rgba(124,58,237,0.05)) !important;
        border-color: rgba(79,70,229,0.2) !important;
        color: var(--vibrant-primary) !important;
    }
    #vibrantMobileNav .mobile-nav-links a:hover .icon-box {
        background: var(--vibrant-primary) !important;
        transform: rotate(-5deg) scale(1.1);
        transition: all 0.25s ease;
    }
    #vibrantMobileNav .mobile-nav-links a:hover .icon-box i {
        color: white !important;
    }
    /* Hide join button on mobile - btn-vibrant overrides Bootstrap d-none */
    @media (max-width: 991px) {
        .vibrant-header .btn-vibrant,
        .vibrant-header .btn-outline-vibrant {
            display: none !important;
        }
        .vibrant-header {
            left: 0 !important;
            transform: none !important;
            width: 100% !important;
        }
    }
    .shadow-hover:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>

@push('js')
<script>
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.vibrant-header').addClass('scrolled');
        } else {
            $('.vibrant-header').removeClass('scrolled');
        }
    });

    // Fix offcanvas nav links - close offcanvas then navigate
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nav-offcanvas-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var href = this.getAttribute('href');
                var offcanvasEl = document.getElementById('vibrantMobileNav');
                var offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (offcanvasInstance) {
                    offcanvasEl.addEventListener('hidden.bs.offcanvas', function handler() {
                        offcanvasEl.removeEventListener('hidden.bs.offcanvas', handler);
                        window.location.href = href;
                    });
                    offcanvasInstance.hide();
                } else {
                    window.location.href = href;
                }
            });
        });
    });
</script>
@endpush
