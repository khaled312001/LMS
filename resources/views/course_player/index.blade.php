<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $course_title = isset($course_details) && $course_details->title ? $course_details->title : get_phrase('Course Playing Page');
        $page_title = $course_title . ' | ' . config('app.name');
        $meta_description = isset($course_details) && $course_details->short_description ? strip_tags($course_details->short_description) : get_phrase('Learn from the best courses on our platform');
    @endphp
    <title>{{ $page_title }}</title>
    <!-- all the meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{{ $meta_description }}" />
    <meta name="author" content="{{ config('app.name') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ $page_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
    @if(isset($course_details) && $course_details->thumbnail)
    <meta property="og:image" content="{{ get_image($course_details->thumbnail) }}" />
    @endif
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:title" content="{{ $page_title }}" />
    <meta property="twitter:description" content="{{ $meta_description }}" />
    @if(isset($course_details) && $course_details->thumbnail)
    <meta property="twitter:image" content="{{ get_image($course_details->thumbnail) }}" />
    @endif
    <!-- all the css files -->
    <link rel="shortcut icon" href="{{ asset(get_frontend_settings('favicon')) }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/course_player/vendors/fontawesome/fontawesome.css') }}" />
    <!-- Player CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plyr/plyr.css') }}" />
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/course_player/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/course_player/css/custom.css') }}" />
    <!-- FlatIcons Css -->
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />

    <!-- Summernote Css -->
    <link rel="stylesheet" href="{{ asset('assets/global/summernote/summernote.min.css') }}">

    <!-- Yaireo Tagify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/tagify-master/dist/tagify.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Start Course Playing Header -->
    <header class="playing-header-section">
        @include('course_player.header')
    </header>
    <!-- End Course Playing Header -->

    <!-- Start Course Playing Video and Playlist Area -->
    <style>
        .video-playlist-section {
            background: #f8fafc;
            padding: 24px 0 40px;
            min-height: calc(100vh - 65px);
        }
        .video-playlist-section .my-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 18px;
        }
        #player_content > .course-video-area,
        #player_content > .sba-slide-frame-wrap {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 40px -24px rgba(15, 23, 42, 0.25);
        }
        /* Mobile player tweaks */
        @media (max-width: 991.98px) {
            .video-playlist-section { padding: 12px 0 24px; min-height: auto; }
            .video-playlist-section .my-container { padding: 0 10px; }
            #player_side_bar { margin-top: 20px; }
            #player_content > .course-video-area,
            #player_content > .sba-slide-frame-wrap {
                border-radius: 12px;
            }
            /* Force 16:9 aspect for video / iframe wrappers */
            .sba-slide-frame-wrap,
            .course-video-area,
            .course-video-area > iframe,
            .course-video-area > video,
            .sba-slide-frame-wrap > iframe {
                height: auto !important;
                min-height: 0 !important;
                aspect-ratio: 16 / 9;
                max-width: 100%;
            }
            iframe[height] {
                height: auto !important;
                aspect-ratio: 16 / 9;
            }
            /* Sidebar inner scroll: use natural flow on mobile so page scroll isn't trapped */
            .sba-curr-body {
                max-height: none !important;
                overflow-y: visible !important;
            }
        }
        /* Mobile floating "Lessons" toggle button */
        .player-mobile-sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 18px;
            inset-inline-end: 18px;
            z-index: 1040;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border: none;
            border-radius: 100px;
            padding: 12px 20px;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 10px 28px rgba(99, 102, 241, 0.45);
            gap: 8px;
            align-items: center;
        }
        @media (max-width: 991.98px) {
            .player-mobile-sidebar-toggle { display: inline-flex; }
        }
    </style>
    <section class="video-playlist-section">
        <div class="my-container">
            <div class="row g-4">
                <div class="col-lg-8" id="player_content">
                    @if(in_array($lesson_details->id, get_locked_lesson_ids($course_details->id, auth()->user()->id)) && $course_details->enable_drip_content)
                        @php
                           $drip_content_settings =  json_decode($course_details->drip_content_settings);
                        @endphp
                        <div class="py-5 my-5 text-center">
                            {!! remove_js(htmlspecialchars_decode($drip_content_settings->locked_lesson_message ?? "")) !!}
                        </div>
                    @else
                        @include('course_player.player_page')
                    @endif
                    <!-- Tab -->
                    <div class="course-video-navtab">
                        @include('course_player.tab_bar')
                    </div>
                </div>
                <div class="col-lg-4" id="player_side_bar">
                    @include('course_player.side_bar')
                </div>
            </div>
        </div>
    </section>
    <!-- End Course Playing Video and Playlist Area -->

    <!-- Main Jquery -->
    <script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap bundle with popper -->
    <script src="{{ asset('assets/frontend/default/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Summernote Css -->
    <script src="{{ asset('assets/global/summernote/summernote.min.js') }}"></script>

    <!-- Fontawesome JS -->
    <script src="{{ asset('assets/global/course_player/vendors/fontawesome/fontawesome.all.min.js') }}"></script>

    <!-- Player JS -->
    <script src="{{ asset('assets/global/plyr/plyr.js') }}"></script>

    <!-- Yaireo Tagify -->
    <script src="{{ asset('assets/global/tagify-master/dist/tagify.min.js') }}"></script>

    <!-- Jquery form -->
    <script type="text/javascript" src="{{ asset('assets/global/jquery-form/jquery.form.min.js') }}"></script>

    <!-- toster file -->
    @include('frontend.default.toaster')

    <!-- Custom Script -->
    <script src="{{ asset('assets/global/course_player/js/script.js') }}"></script>

    @include('admin.common_scripts')
    @include('course_player.init')
    @stack('js')
</body>

</html>
