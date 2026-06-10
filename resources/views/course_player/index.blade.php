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
        #player_content > .course-video-area:not(.has-deck),
        #player_content > .sba-slide-frame-wrap {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 40px -24px rgba(15, 23, 42, 0.25);
        }
        /* Mobile player tweaks */
        @media (max-width: 991.98px) {
            .video-playlist-section { padding: 12px 0 80px !important; min-height: auto; background: #f8fafc; }
            .video-playlist-section .my-container { padding: 0 10px !important; max-width: 100% !important; }
            .video-playlist-section .row { margin: 0 !important; --bs-gutter-x: 0 !important; }
            #player_content { padding: 0 !important; }
            #player_side_bar { margin-top: 0; }
            /* Tab bar regains side padding so it doesn't touch the screen edge */
            .course-video-navtab { padding: 0; margin-top: 12px; }

            /* Apply 16:9 ratio ONLY to actual video/iframe wrappers, NOT to the
               carousel deck (which has its own tall layout in player_page). */
            .course-video-area:not(.has-deck),
            .course-video-area:not(.has-deck) > iframe,
            .course-video-area:not(.has-deck) > video {
                height: auto !important;
                min-height: 0 !important;
                aspect-ratio: 16 / 9;
                max-width: 100%;
            }
            /* Slide-deck wrapper resets — let the deck itself control height */
            .course-video-area.has-deck {
                aspect-ratio: auto !important;
                height: auto !important;
                min-height: 0 !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                overflow: visible !important;
                padding: 0 !important;
            }
            /* Sidebar inner scroll: use natural flow on mobile so page scroll isn't trapped */
            .sba-curr-body {
                max-height: none !important;
                overflow-y: visible !important;
            }
        }
        /* === Mobile floating "Lessons" toggle button === */
        .player-mobile-sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 18px;
            inset-inline-end: 18px;
            z-index: 1045;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff !important;
            border: none;
            border-radius: 100px;
            padding: 13px 22px;
            font-weight: 800;
            font-size: 0.92rem;
            box-shadow: 0 14px 30px rgba(99, 102, 241, 0.55);
            gap: 8px;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
        }
        .player-mobile-sidebar-toggle:hover { transform: translateY(-2px); }
        .player-mobile-sidebar-toggle .pmst-count {
            background: rgba(255,255,255,0.22);
            border-radius: 100px;
            padding: 2px 9px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        /* === Mobile sidebar drawer === */
        .player-sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(2px);
            z-index: 1050;
            opacity: 0;
            transition: opacity .3s ease;
        }
        .player-sidebar-backdrop.is-open {
            display: block;
            opacity: 1;
        }

        @media (max-width: 991.98px) {
            .player-mobile-sidebar-toggle { display: inline-flex; }

            #player_side_bar {
                position: fixed !important;
                top: 0;
                inset-inline-end: 0;
                width: min(360px, 92vw);
                height: 100vh;
                margin: 0 !important;
                z-index: 1051;
                background: #fff;
                box-shadow: -20px 0 50px rgba(15, 23, 42, 0.25);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                transform: translateX(100%);
                transition: transform .35s cubic-bezier(.16,1,.3,1);
                padding: 12px;
                max-width: 100% !important;
                flex: 0 0 auto !important;
            }
            html[dir="rtl"] #player_side_bar {
                inset-inline-end: auto;
                inset-inline-start: 0;
                box-shadow: 20px 0 50px rgba(15, 23, 42, 0.25);
                transform: translateX(-100%);
            }
            #player_side_bar.is-open {
                transform: translateX(0) !important;
            }
            /* Close button inside drawer */
            #player_side_bar::before {
                content: '';
                display: block;
                height: 4px;
                width: 48px;
                background: #cbd5e1;
                border-radius: 100px;
                margin: 6px auto 14px;
            }
        }

        /* Improve touch targets on the curriculum sidebar */
        @media (max-width: 991.98px) {
            .sba-curr { box-shadow: none !important; border: none !important; }
            .sba-curr-head { padding: 16px 14px 14px !important; border-radius: 14px 14px 0 0 !important; }
            .sba-curr-head h3 { font-size: 1rem !important; }
            .sba-section-toggle { padding: 14px 14px !important; }
            .sba-lesson { padding: 10px 14px !important; }
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

        <!-- Mobile drawer backdrop + toggle (lg and below only) -->
        <div class="player-sidebar-backdrop" id="playerSidebarBackdrop"></div>
        @php
            $__total_l   = lesson_count($course_details->id) ?: 0;
            $__sba_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
        @endphp
        <button type="button" class="player-mobile-sidebar-toggle" id="playerSidebarToggle"
                aria-label="{{ $__sba_arabic ? 'فتح قائمة الدروس' : 'Open lessons list' }}">
            <i class="fi-rr-menu-burger"></i>
            <span>{{ $__sba_arabic ? 'الدروس' : 'Lessons' }}</span>
            <span class="pmst-count">{{ $__total_l }}</span>
        </button>
    </section>

    <script>
    (function () {
        var btn = document.getElementById('playerSidebarToggle');
        var sb  = document.getElementById('player_side_bar');
        var bd  = document.getElementById('playerSidebarBackdrop');
        if (!btn || !sb || !bd) return;
        function open()  { sb.classList.add('is-open');  bd.classList.add('is-open');  document.body.style.overflow = 'hidden'; }
        function close() { sb.classList.remove('is-open'); bd.classList.remove('is-open'); document.body.style.overflow = ''; }
        btn.addEventListener('click', function (e) { e.preventDefault(); open(); });
        bd.addEventListener('click', close);
        // Close when a lesson link is tapped (so user lands on next lesson)
        sb.addEventListener('click', function (e) {
            var a = e.target.closest && e.target.closest('a[href]');
            if (a && a.getAttribute('href') && a.getAttribute('href') !== '#') {
                close();
            }
        });
        // Close on Escape
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
        // Close when resizing back to desktop
        window.addEventListener('resize', function () { if (window.innerWidth > 991) close(); });
    })();
    </script>
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
