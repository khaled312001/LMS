<!DOCTYPE html>
@php
    $active_lan = session('language') ?? get_settings('language');
    $active_lan_id = DB::table('languages')->where('name', 'like', $active_lan)->value('id');
    $language_direction = DB::table('languages')->where('id', $active_lan_id)->value('direction') ?? 'ltr';
    $html_lang = ($active_lan == 'arabic' || $active_lan == 'Arabic') ? 'ar' : 'en';
@endphp
<html lang="{{ $html_lang }}" dir="{{ $language_direction }}">

<head>
    @include('layouts.seo')
    @stack('meta')
    
    @if($language_direction == 'rtl')
    <style>
        html, body {
            direction: rtl;
            text-align: right;
            overflow-x: hidden !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        * {
            max-width: 100%;
            box-sizing: border-box;
        }
        .container, .row, [class*="col-"] {
            direction: rtl;
            max-width: 100%;
            overflow-x: hidden;
        }
        img, video, iframe {
            max-width: 100% !important;
            height: auto !important;
        }
        .text-start {
            text-align: right !important;
        }
        .text-end {
            text-align: left !important;
        }
        .ms-auto {
            margin-right: auto !important;
            margin-left: 0 !important;
        }
        .me-auto {
            margin-left: auto !important;
            margin-right: 0 !important;
        }
        .ps-0 {
            padding-right: 0 !important;
        }
        .pe-0 {
            padding-left: 0 !important;
        }
        .ms-0 {
            margin-right: 0 !important;
        }
        .me-0 {
            margin-left: 0 !important;
        }
        @media (max-width: 768px) {
            body, html {
                overflow-x: hidden !important;
                position: relative;
                width: 100%;
            }
            .container-fluid, .container {
                padding-left: 15px;
                padding-right: 15px;
                max-width: 100%;
                overflow-x: hidden;
            }
            .row {
                margin-left: 0;
                margin-right: 0;
                max-width: 100%;
            }
            [class*="col-"] {
                padding-left: 15px;
                padding-right: 15px;
                max-width: 100%;
            }
            section, div {
                max-width: 100%;
                overflow-x: hidden;
            }
        }
    </style>
    @else
    <style>
        html, body {
            overflow-x: hidden !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        * {
            max-width: 100%;
            box-sizing: border-box;
        }
        img, video, iframe {
            max-width: 100% !important;
            height: auto !important;
        }
        @media (max-width: 768px) {
            body, html {
                overflow-x: hidden !important;
                position: relative;
                width: 100%;
            }
            .container-fluid, .container {
                padding-left: 15px;
                padding-right: 15px;
                max-width: 100%;
                overflow-x: hidden;
            }
            .row {
                margin-left: 0;
                margin-right: 0;
                max-width: 100%;
            }
            [class*="col-"] {
                padding-left: 15px;
                padding-right: 15px;
                max-width: 100%;
            }
            section, div {
                max-width: 100%;
                overflow-x: hidden;
            }
        }
    </style>
    @endif

    <!-- fav icon -->
    <link rel="shortcut icon" href="{{ asset(get_frontend_settings('favicon')) }}" />

    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/owl.theme.default.min.css') }}">

    <!-- Jquery Ui Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/jquery-ui.css') }}">

    <!-- Nice Select Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/nice-select.css') }}">

    <!-- Fontawasome Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/all.min.css') }}">

    {{-- New Css Link --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/slick/slick-theme.css') }}">

    <!-- Flat Pickr -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/flatpickr/flatpickr.min.css') }}">

    <!-- FlatIcons Css -->
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/custome-front/custom-fronts.css') }}">

    <!-- Player Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/plyr.css') }}">

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/bootstrap.min.css') }}">

    <!-- Main Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/responsive.css') }}">

    <!-- Yaireo Tagify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/tagify-master/dist/tagify.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/custom_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/new_responsive.css') }}">

    <!-- Jquery Js -->
    <script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>
    @stack('css')

</head>

<body>
    @php $current_route_name = Route::currentRouteName(); @endphp
    @php
        if (session('home')) {
            $home_page = App\Models\Builder_page::where('id', session('home'))->firstOrNew();
        } else {
            $home_page = App\Models\Builder_page::where('status', 1)->firstOrNew();
        }
    @endphp

    @if ($home_page->is_permanent == 1)
        @include('components.home_made_by_developer.top_bar')
        @include('components.home_made_by_developer.header')
        <section>
            @yield('content')
        </section>
        @include('components.home_made_by_developer.footer')
    @else
        @if ($current_route_name == 'home' || $current_route_name == 'admin.page.preview')
            <section>
                @yield('content')
            </section>
        @else
            @php $builder_files = $home_page->html ? json_decode($home_page->html, true) : []; @endphp
            @if (in_array('top_bar', $builder_files))
                @include('components.home_made_by_builder.top_bar')
            @endif

            @if (in_array('header', $builder_files))
                @include('components.home_made_by_builder.header')
            @endif

            <section>
                @yield('content')
            </section>

            @if (in_array('footer', $builder_files))
                @include('components.home_made_by_builder.footer')
            @endif
        @endif
    @endif

    <!-- Bootstrap Js -->
    <script src="{{ asset('assets/frontend/default/js/bootstrap.bundle.min.js') }}"></script>


    <!-- nice select js -->
    <script src="{{ asset('assets/frontend/default/js/jquery.nice-select.min.js') }}"></script>

    {{-- New Js Link  --}}
    <script src="{{ asset('assets/frontend/default/vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/default/vendors/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/default/vendors/counterup/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/frontend/default/vendors/slick/slick.min.js') }}"></script>

    <script src="{{ asset('assets/frontend/default/vendors/flatpickr/flatpickr.min.js') }}"></script>

    <!-- owl carousel js -->
    <script src="{{ asset('assets/frontend/default/js/owl.carousel.min.js') }}"></script>


    <!-- Player Js -->
    <script src="{{ asset('assets/frontend/default/js/plyr.js') }}"></script>


    <!-- Yaireo Tagify -->
    <script src="{{ asset('assets/global/tagify-master/dist/tagify.min.js') }}"></script>


    <!-- Jquery Ui Js -->
    <script src="{{ asset('assets/frontend/default/js/jquery-ui.min.js') }}"></script>


    <!-- price range Js -->
    <script src="{{ asset('assets/frontend/default/js/price_range_script.js') }}"></script>


    <!-- Main Js -->
    <script src="{{ asset('assets/frontend/default/js/script.js') }}?v=1.1"></script>

    @if(get_frontend_settings('cookie_status'))
        @include('frontend.default.cookie')
    @endif

    <!-- End Footer -->
    @include('frontend.default.modal')
    <!-- toster file -->
    @include('frontend.default.toaster')
    <!-- custom scripts -->
    @include('frontend.default.scripts')
    @stack('js')
</body>

</html>
