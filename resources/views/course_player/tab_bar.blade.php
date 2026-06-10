@php
    $course_progress_out_of_100 = progress_bar($course_details->id);
    if (isset($_GET['tab'])) {
        $tab = $_GET['tab'];
    } elseif (Session::has('forum_tab')) {
        $tab = Session::get('forum_tab');
    } else {
        $tab = 'summary';
    }
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp

<style>
    .sba-tabs {
        margin-top: 24px;
        background: #fff;
        border: 1px solid #eef1f6;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 28px -20px rgba(15, 23, 42, 0.12);
    }

    .sba-tabs-nav {
        display: flex;
        gap: 4px;
        padding: 10px;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        border-bottom: 1px solid #e0e7ff;
        overflow-x: auto;
    }

    .sba-tabs-nav::-webkit-scrollbar { display: none; }

    .sba-tabs-nav .nav-link {
        flex: 1 1 auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.92rem;
        color: #475569;
        background: transparent;
        border: none;
        transition: all 0.25s ease;
        white-space: nowrap;
        cursor: pointer;
    }

    .sba-tabs-nav .nav-link i {
        font-size: 1.1rem;
    }

    .sba-tabs-nav .nav-link:hover:not(.active) {
        background: rgba(99, 102, 241, 0.08);
        color: #4f46e5;
    }

    .sba-tabs-nav .nav-link.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff !important;
        box-shadow: 0 10px 20px -10px rgba(99, 102, 241, 0.55);
    }

    .sba-tabs-body {
        padding: 28px;
    }

    @media (max-width: 991.98px) {
        .sba-tabs { margin-top: 16px; border-radius: 14px; }
        .sba-tabs-nav {
            gap: 6px;
            padding: 8px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }
        .sba-tabs-nav .nav-link {
            flex: 0 0 auto;
            scroll-snap-align: start;
            padding: 10px 14px;
            font-size: 0.86rem;
            border-radius: 100px;
        }
    }
    @media (max-width: 640px) {
        .sba-tabs-body { padding: 14px; }
        .sba-tabs-nav .nav-link i { font-size: 1rem; }
        .sba-tabs-nav .nav-link span {
            font-size: 0.82rem;
        }
    }
    @media (max-width: 380px) {
        /* On the very smallest screens, show only icons for non-active tabs to save space */
        .sba-tabs-nav .nav-link:not(.active) span { display: none; }
        .sba-tabs-nav .nav-link { padding: 9px 12px; }
    }
</style>

<div class="sba-tabs">
    <ul class="sba-tabs-nav nav nav-pills" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link @if ($tab == 'summary') active @endif" id="pills-summary-tab" data-bs-toggle="pill" data-bs-target="#pills-summary" type="button" role="tab">
                <i class="fi-rr-blog-text"></i>
                <span>{{ $is_arabic ? 'الملخص' : get_phrase('Summary') }}</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link @if ($tab == 'live-class') active @endif" id="pills-live-class-tab" data-bs-toggle="pill" data-bs-target="#pills-live-class" type="button" role="tab">
                <i class="fi-rr-video-camera-alt"></i>
                <span>{{ $is_arabic ? 'الجلسات المباشرة' : get_phrase('Live class') }}</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link @if ($tab == 'certificate') active @endif" id="pills-certificate-tab" data-bs-toggle="pill" data-bs-target="#pills-certificate" type="button" role="tab">
                <i class="fi-rr-graduation-cap"></i>
                <span>{{ $is_arabic ? 'الشهادة' : get_phrase('Certificate') }}</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link @if ($tab == 'forum') active @endif" id="pills-forum-tab" data-bs-toggle="pill" data-bs-target="#pills-forum" type="button" role="tab">
                <i class="fi fi-rr-users-alt"></i>
                <span>{{ $is_arabic ? 'المنتدى' : get_phrase('Forum') }}</span>
            </button>
        </li>
    </ul>

    <div class="sba-tabs-body tab-content" id="pills-tabContent">
        @include('course_player.summary.index')
        @include('course_player.live_class.index')
        @include('course_player.certificate.index')
        @include('course_player.forum.index')
    </div>
</div>

@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.sba-tabs-nav button.nav-link').on('click', function(e) {
                e.preventDefault();
                let tab = $(this).data('bs-target');
                $.ajax({
                    type: "get",
                    url: "{{ route('forum.tab.active') }}",
                    data: { tab: tab }
                });
            });
        });
    </script>
@endpush
