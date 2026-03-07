@php
    $parent_categories = DB::table('categories')->where('parent_id', 0)->latest('id')->get();
    $current_route = Route::currentRouteName();
@endphp

<header class="vibrant-header d-flex align-items-center justify-content-between">
    <div class="logo-area">
        <a href="{{ route('home') }}">
            <img src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="Logo" style="max-height: 40px;">
        </a>
    </div>

    <nav class="d-none d-lg-block">
        <ul class="d-flex align-items-center gap-2 m-0 p-0 list-unstyled">
            <li><a href="{{ route('home') }}" class="nav-link-vibrant {{ $current_route == 'home' ? 'active' : '' }}">{{ get_phrase('Home') }}</a></li>
            <li><a href="{{ route('courses') }}" class="nav-link-vibrant {{ $current_route == 'courses' ? 'active' : '' }}">{{ get_phrase('Courses') }}</a></li>
            <li><a href="{{ route('blogs') }}" class="nav-link-vibrant {{ $current_route == 'blogs' ? 'active' : '' }}">{{ get_phrase('Blog') }}</a></li>
        </ul>
    </nav>

    <div class="action-area d-flex align-items-center gap-3">
        @auth
            <div class="dropdown">
                <button class="btn p-0 border-0 dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown">
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
            <a href="{{ route('login') }}" class="text-dark fw-bold text-decoration-none d-none d-sm-block">{{ get_phrase('Login') }}</a>
            <a href="{{ route('register.form') }}" class="btn-vibrant">{{ get_phrase('Join Free') }}</a>
        @endauth
        
        <button class="btn btn-light rounded-circle p-2 d-lg-none shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#vibrantMobileNav">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
    </div>
</header>

<!-- Vibrant Mobile Nav -->
<div class="offcanvas offcanvas-end border-0 shadow-lg" tabindex="-1" id="vibrantMobileNav" style="border-radius: 30px 0 0 30px;">
    <div class="offcanvas-header p-4">
        <img src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="Logo" style="max-height: 40px;">
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-4 bg-vibrant-dark text-white">
        <ul class="list-unstyled d-flex flex-column gap-3">
            <li><a href="{{ route('home') }}" class="fs-4 text-white text-decoration-none fw-bold">{{ get_phrase('Home') }}</a></li>
            <li><a href="{{ route('courses') }}" class="fs-4 text-white text-decoration-none fw-bold">{{ get_phrase('Courses') }}</a></li>
            <li><a href="{{ route('blogs') }}" class="fs-4 text-white text-decoration-none fw-bold">{{ get_phrase('Blog') }}</a></li>
        </ul>
        <hr class="my-5 opacity-25">
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-light w-100 py-3 rounded-4 mb-3 fw-bold">{{ get_phrase('Login') }}</a>
            <a href="{{ route('register.form') }}" class="btn btn-primary w-100 py-3 rounded-4 fw-bold" style="background: var(--vibrant-primary); border: none;">{{ get_phrase('Get Started') }}</a>
        @else
            <a href="{{ route('logout') }}" class="btn btn-danger w-100 py-3 rounded-4 fw-bold">{{ get_phrase('Logout') }}</a>
        @endguest
    </div>
</div>

@push('js')
<script>
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.vibrant-header').addClass('scrolled');
        } else {
            $('.vibrant-header').removeClass('scrolled');
        }
    });
</script>
@endpush
