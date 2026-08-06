@php
    $sba_is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
    $sba_progress_pct = progress_bar($course_details->id);
    $sba_completed_count = count(json_decode(
        App\Models\Watch_history::where('course_id', $course_details->id)
            ->where('student_id', auth()->id())
            ->value('completed_lesson') ?? '[]',
        true
    ) ?: []);
    $sba_total_lessons = lesson_count($course_details->id);
@endphp

<style>
    .playing-header-section {
        position: sticky;
        top: 0;
        z-index: 1030;
    }

    .sba-player-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #3b0764 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 12px 24px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .sba-player-header .sba-ph-brand {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }

    .sba-player-header .sba-ph-brand img {
        height: 42px;
    }

    .sba-player-header .sba-ph-title {
        flex: 1 1 auto;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
        text-align: center;
    }

    .sba-player-header .sba-ph-title .sba-title-text {
        font-size: 0.98rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sba-player-header .sba-ph-title .sba-progress-row {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
    }

    .sba-player-header .sba-progress-track {
        flex: 0 1 240px;
        height: 6px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 100px;
        overflow: hidden;
    }

    .sba-player-header .sba-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #06b6d4, #8b5cf6, #ec4899);
        border-radius: 100px;
        transition: width .5s ease;
    }

    .sba-player-header .sba-progress-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.85);
        min-width: 50px;
    }

    .sba-player-header .sba-ph-actions {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .sba-player-header .sba-ph-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 40px;
        padding: 0 18px;
        border-radius: 100px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        transition: all .25s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .sba-player-header .sba-ph-btn.ghost {
        background: rgba(255, 255, 255, 0.08);
        color: #e0e7ff;
        border-color: rgba(255, 255, 255, 0.15);
    }

    .sba-player-header .sba-ph-btn.ghost:hover {
        background: rgba(255, 255, 255, 0.14);
        color: #fff;
        transform: translateY(-1px);
    }

    .sba-player-header .sba-ph-btn.primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        box-shadow: 0 8px 18px -8px rgba(99, 102, 241, 0.6);
    }

    .sba-player-header .sba-ph-btn.primary:hover {
        transform: translateY(-1px);
        color: #fff;
    }

    .sba-player-header .sba-ph-btn.icon-only {
        width: 40px;
        padding: 0;
    }

    /* Round back button (mobile-first thumb-friendly) */
    .sba-player-header .sba-ph-back {
        flex: 0 0 auto;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #fff;
        text-decoration: none;
        transition: all .25s ease;
    }
    .sba-player-header .sba-ph-back:hover {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        transform: translateY(-1px);
        color: #fff;
    }

    @media (max-width: 992px) {
        .sba-player-header .sba-ph-title .sba-title-text {
            font-size: 0.88rem;
        }
        .sba-player-header .sba-progress-track {
            flex-basis: 140px;
        }
        .sba-player-header .sba-ph-btn.primary {
            display: none;
        }
    }

    @media (max-width: 640px) {
        .sba-player-header {
            padding: 10px 12px;
            gap: 8px;
        }
        .sba-player-header .sba-ph-brand img {
            height: 32px;
        }
        .sba-player-header .sba-ph-back {
            width: 36px;
            height: 36px;
        }
        .sba-player-header .sba-ph-title {
            text-align: start;
        }
        .sba-player-header .sba-ph-title .sba-title-text {
            font-size: 0.85rem;
            white-space: normal;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            line-height: 1.35;
        }
        .sba-player-header .sba-ph-title .sba-progress-row {
            display: none;
        }
        .sba-player-header .sba-ph-actions {
            gap: 6px;
        }
        /* Hide brand image on very small screens — back button + title is enough */
        .sba-player-header .sba-ph-brand {
            display: none;
        }
    }
</style>

<div class="sba-player-header">
    <a href="{{ url()->previous() && url()->previous() !== url()->current() ? url()->previous() : route('my.courses') }}"
       class="sba-ph-back" id="sbaPhBack"
       title="{{ $sba_is_arabic ? 'رجوع' : get_phrase('Back') }}"
       aria-label="{{ $sba_is_arabic ? 'رجوع' : get_phrase('Back') }}">
        @if ($sba_is_arabic)
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        @else
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        @endif
    </a>

    <a href="{{ route('home') }}" class="sba-ph-brand" title="{{ get_phrase('Home') }}">
        <img src="{{ asset(get_frontend_settings('light_logo')) }}" alt="Logo">
    </a>

    <div class="sba-ph-title">
        <p class="sba-title-text">{{ ucfirst(course_title($course_details)) }}</p>
        <div class="sba-progress-row">
            <span class="sba-progress-label"><span id="sbaProgCount">{{ $sba_completed_count }}</span> / <span id="sbaProgTotal">{{ $sba_total_lessons }}</span></span>
            <div class="sba-progress-track">
                <div class="sba-progress-fill" id="sbaProgFill" style="width: {{ $sba_progress_pct }}%"></div>
            </div>
            <span class="sba-progress-label"><span id="sbaProgPct">{{ round($sba_progress_pct) }}</span>%</span>
        </div>
    </div>

    <div class="sba-ph-actions">
        <button type="button" class="sba-ph-btn ghost icon-only" id="fullscreen" title="{{ get_phrase('Fullscreen') }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/></svg>
        </button>

        @if (auth()->check() && (is_course_instructor($course_details->id) || auth()->user()->role == 'admin'))
            <a href="{{ route(auth()->user()->role . '.course.edit', ['id' => $course_details->id, 'tab' => 'curriculum']) }}" class="sba-ph-btn primary">
                <i class="fi-rr-settings"></i>
                {{ get_phrase('Manage Course') }}
            </a>
        @else
            <a href="{{ route('my.courses') }}" class="sba-ph-btn primary">
                <i class="fi-rr-book-alt"></i>
                {{ $sba_is_arabic ? 'دوراتي' : get_phrase('My Courses') }}
            </a>
        @endif
    </div>
</div>

<script>
(function () {
    // Make the back button truly use browser history when available; fall back to my-courses.
    var btn = document.getElementById('sbaPhBack');
    if (!btn) return;
    btn.addEventListener('click', function (e) {
        // Only intercept on left click without modifier keys
        if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        if (window.history.length > 1 && document.referrer && document.referrer.indexOf(location.host) !== -1) {
            e.preventDefault();
            window.history.back();
        }
        // Otherwise let the link's href take over (fallback to my-courses)
    });
})();
</script>
