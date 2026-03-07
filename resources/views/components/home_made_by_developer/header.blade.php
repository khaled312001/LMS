@php
    $parent_categories = DB::table('categories')->where('parent_id', 0)->latest('id')->get();
    $current_route = Route::currentRouteName();
@endphp

<header class="professional-header sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <a class="navbar-brand me-4" href="{{ route('home') }}">
                <img src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="Logo" style="max-height: 50px;">
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-3">
                    <li class="nav-item">
                        <a class="nav-link-professional {{ $current_route == 'home' ? 'active' : '' }}" href="{{ route('home') }}">{{ get_phrase('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-professional {{ $current_route == 'courses' ? 'active' : '' }}" href="{{ route('courses') }}">{{ get_phrase('Courses') }}</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-4">
                    <!-- Search Trigger -->
                    <form action="{{ route('courses') }}" method="get" class="d-none d-xl-flex">
                        <div class="input-group bg-light rounded-pill px-3">
                            <span class="input-group-text bg-transparent border-0"><i class="fi-rr-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none ps-0" placeholder="{{ get_phrase('Search...') }}" style="width: 150px;">
                        </div>
                    </form>
                    
                    <!-- Cart -->
                    <a href="{{ route('cart') }}" class="position-relative text-dark">
                        <i class="fi-rr-shopping-cart fs-5"></i>
                        @php $cart_count = auth()->check() ? App\Models\CartItem::where('user_id', auth()->id())->count() : 0; @endphp
                        @if($cart_count > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 10px; padding: 3px 6px; box-shadow: 0 0 0 2px #fff;">
                                {{ $cart_count }}
                            </span>
                        @endif
                    </a>

                    <!-- Wishlist -->
                    @auth
                    <a href="{{ route('wishlist') }}" class="position-relative text-dark d-none d-md-block">
                        <i class="fi-rr-heart fs-5"></i>
                        @php $wish_count = App\Models\Wishlist::where('user_id', auth()->id())->count(); @endphp
                        @if($wish_count > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px; padding: 3px 6px; box-shadow: 0 0 0 2px #fff;">
                                {{ $wish_count }}
                            </span>
                        @endif
                    </a>
                    @endauth

                    <!-- User Profile / Login -->
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-link p-0 dropdown-toggle shadow-none border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <img src="{{ get_image(auth()->user()->photo) }}" alt="User" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                                <div class="text-start d-none d-xxl-block">
                                    <p class="mb-0 text-dark fw-bold lh-1 small">{{ Str::limit(auth()->user()->name, 12) }}</p>
                                    <small class="text-muted text-capitalize" style="font-size: 10px;">{{ auth()->user()->role }}</small>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-2" style="border-radius: 16px; min-width: 240px; animation: fadeUp 0.3s ease;">
                                <li class="px-3 py-3 border-bottom mb-2 bg-light rounded-4">
                                    <h6 class="mb-0 fw-bold">{{ auth()->user()->name }}</h6>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                </li>
                                @if(in_array(auth()->user()->role, ['admin', 'instructor']))
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route(auth()->user()->role . '.dashboard') }}"><i class="fi-rr-apps me-2"></i>{{ get_phrase('Dashboard') }}</a></li>
                                @endif
                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('my.courses') }}"><i class="fi-rr-book-open-cover me-2"></i>{{ get_phrase('My Courses') }}</a></li>
                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('my.profile') }}"><i class="fi-rr-user me-2"></i>{{ get_phrase('Profile') }}</a></li>
                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('purchase.history') }}"><i class="fi-rr-receipt me-2"></i>{{ get_phrase('Purchase History') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item rounded-3 py-2 text-danger" href="{{ route('logout') }}"><i class="fi-rr-exit me-2"></i>{{ get_phrase('Logout') }}</a></li>
                            </ul>
                        </div>
                    @else
                        <div class="d-flex gap-2">
                             <a href="{{ route('login') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill fw-bold d-none d-sm-block">{{ get_phrase('Login') }}</a>
                             <a href="{{ route('register.form') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">{{ get_phrase('Join Now') }}</a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Mobile Nav -->
<div class="offcanvas offcanvas-start border-0 shadow" tabindex="-1" id="offcanvasNavbar" style="border-radius: 0 24px 24px 0;">
    <div class="offcanvas-header border-bottom p-4">
        <img src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="Logo" style="max-height: 45px;">
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-4">
        <ul class="navbar-nav gap-2">
             <li class="nav-item">
                <a class="nav-link fs-5 fw-500 rounded-3 p-3 {{ $current_route == 'home' ? 'bg-light text-primary' : '' }}" href="{{ route('home') }}"><i class="fi-rr-home me-2"></i>{{ get_phrase('Home') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-5 fw-500 rounded-3 p-3 {{ $current_route == 'courses' ? 'bg-light text-primary' : '' }}" href="{{ route('courses') }}"><i class="fi-rr-book-open-cover me-2"></i>{{ get_phrase('Courses') }}</a>
            </li>
            <hr class="my-4">
            @auth
                <li class="nav-item px-3 mb-4">
                    <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-4">
                         <img src="{{ get_image(auth()->user()->photo) }}" alt="User" class="rounded-circle border" style="width: 50px; height: 50px; object-fit: cover;">
                         <div>
                             <h6 class="mb-0 fw-bold">{{ auth()->user()->name }}</h6>
                             <small class="text-muted">{{ auth()->user()->email }}</small>
                         </div>
                    </div>
                </li>
            @endauth
            @guest
                <li class="nav-item"><a class="btn btn-primary w-100 py-3 rounded-4 mb-3 fw-bold" href="{{ route('login') }}">{{ get_phrase('Login') }}</a></li>
                <li class="nav-item"><a class="btn btn-outline-primary w-100 py-3 rounded-4 fw-bold" href="{{ route('register.form') }}">{{ get_phrase('Sign Up') }}</a></li>
            @else
                 <li class="nav-item"><a class="btn btn-danger w-100 py-3 rounded-4 fw-bold mt-4" href="{{ route('logout') }}"><i class="fi-rr-exit me-2"></i>{{ get_phrase('Logout') }}</a></li>
            @endguest
        </ul>
    </div>
</div>

@push('js')
<script>
    "use strict";
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.professional-header').addClass('sticky-active');
        } else {
            $('.professional-header').removeClass('sticky-active');
        }
    });
</script>
@endpush
