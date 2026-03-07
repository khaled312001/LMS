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
    
    <style>
        html, body {
            overflow-x: hidden !important;
            max-width: 100% !important;
            width: 100% !important;
            margin: 0;
            padding: 0;
        }
        * {
            box-sizing: border-box;
        }
    </style>

    <!-- fav icon -->
    <link rel="shortcut icon" href="{{ asset(get_frontend_settings('favicon')) }}" />

    <!-- Fontawasome Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/all.min.css') }}">
    
    <!-- FlatIcons Css -->
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/bootstrap.min.css') }}">

    <!-- New UI Assets -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/swiper/swiper-bundle.min.css') }}">
    
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/custom_style.css') }}">

    <!-- Jquery Js -->
    <script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>
    @stack('css')
</head>

<body>
    @include('components.home_made_by_developer.header')
    
    <main>
        @yield('content')
    </main>

    @include('components.home_made_by_developer.footer')

    <!-- Bootstrap Js -->
    <script src="{{ asset('assets/frontend/default/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Swiper Js -->
    <script src="{{ asset('assets/frontend/default/vendors/swiper/swiper-bundle.min.js') }}"></script>

    @include('frontend.default.modal')
    @include('frontend.default.toaster')
    @include('frontend.default.scripts')
    @stack('js')
</body>
</html>
