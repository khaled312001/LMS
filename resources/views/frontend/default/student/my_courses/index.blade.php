@extends('layouts.default')
@push('title', get_phrase('My courses'))
@push('meta')@endpush
@push('css')
    <style>
        :root {
            --sba-primary: #6366f1;
            --sba-primary-2: #8b5cf6;
            --sba-accent: #06b6d4;
            --sba-success: #10b981;
            --sba-warning: #f59e0b;
            --sba-danger: #ef4444;
            --sba-dark: #0f172a;
            --sba-dark-2: #1e1b4b;
            --sba-muted: #64748b;
            --sba-border: #e2e8f0;
            --sba-bg: #f8fafc;
            --sba-surface: #ffffff;
        }

        /* Page wrapper - gives the whole page breathing room under the fixed header */
        .sba-mycourses-page {
            background: var(--sba-bg);
            padding-top: 140px;
            padding-bottom: 80px;
        }

        .sba-mycourses-page .profile-banner-area {
            display: none !important;
        }

        .sba-mycourses-page .container {
            max-width: 1240px;
        }

        .sba-mycourses-page .row {
            align-items: flex-start;
        }

        .sba-mycourses-page > .container > .row > .col-lg-3,
        .sba-mycourses-page > .container > .row > .col-lg-9 {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* ---------- Hero banner ---------- */
        .sba-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 45%, #4c1d95 100%);
            border-radius: 24px;
            padding: 36px 36px 32px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 45px -22px rgba(15, 23, 42, 0.45);
            margin-bottom: 32px;
        }

        .sba-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 90% -10%, rgba(236, 72, 153, 0.35), transparent 50%),
                radial-gradient(circle at 0% 110%, rgba(6, 182, 212, 0.3), transparent 45%);
            pointer-events: none;
        }

        .sba-hero > * {
            position: relative;
            z-index: 1;
        }

        .sba-hero-title {
            font-weight: 900;
            font-size: 1.9rem;
            margin: 0 0 8px;
            line-height: 1.35;
            color: #fff;
        }

        .sba-hero-sub {
            color: rgba(255, 255, 255, 0.78);
            font-size: 1rem;
            margin: 0;
            line-height: 1.7;
        }

        .sba-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-top: 26px;
        }

        .sba-stat {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 16px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: background .25s ease, transform .25s ease;
        }

        .sba-stat:hover {
            background: rgba(255, 255, 255, 0.14);
            transform: translateY(-2px);
        }

        .sba-stat-ico {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex: 0 0 auto;
        }

        .sba-stat-body {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            min-width: 0;
        }

        .sba-stat-num {
            font-weight: 900;
            font-size: 1.5rem;
            color: #fff;
        }

        .sba-stat-lbl {
            color: rgba(255, 255, 255, 0.78);
            font-size: 0.88rem;
            font-weight: 600;
            margin-top: 2px;
        }

        /* ---------- Section heading ---------- */
        .sba-section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sba-section-head h3 {
            font-weight: 900;
            font-size: 1.4rem;
            color: var(--sba-dark);
            margin: 0;
        }

        .sba-section-head a {
            color: var(--sba-primary);
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap .25s ease;
        }

        .sba-section-head a:hover {
            gap: 10px;
        }

        /* ---------- Course cards ---------- */
        .sba-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        @media (max-width: 1200px) {
            .sba-cards { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 720px) {
            .sba-cards { grid-template-columns: 1fr; }
            .sba-stats { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 420px) {
            .sba-stats { grid-template-columns: 1fr; }
        }

        .sba-card {
            background: #fff;
            border: 1px solid var(--sba-border);
            border-radius: 20px;
            overflow: hidden;
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
            display: flex;
            flex-direction: column;
        }

        .sba-card:hover {
            transform: translateY(-4px);
            border-color: transparent;
            box-shadow: 0 25px 50px -20px rgba(15, 23, 42, 0.2);
        }

        .sba-card-media {
            position: relative;
            aspect-ratio: 16/9;
            overflow: hidden;
            background: #eef2ff;
        }

        .sba-card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .sba-card:hover .sba-card-media img {
            transform: scale(1.05);
        }

        .sba-chip {
            position: absolute;
            top: 12px;
            inset-inline-start: 12px;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 800;
            border-radius: 100px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 6px 16px -6px rgba(0,0,0,.25);
        }

        .sba-chip.is-lifetime { background: linear-gradient(135deg, #10b981, #059669); }
        .sba-chip.is-expired  { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .sba-chip.is-limited  { background: linear-gradient(135deg, #f59e0b, #d97706); }

        .sba-card-body {
            padding: 20px 22px 22px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            flex: 1;
        }

        .sba-author {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sba-author img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 4px 10px -4px rgba(0,0,0,.15);
        }

        .sba-author span {
            color: #475569;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .sba-card-title {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--sba-dark);
            line-height: 1.45;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 3em;
        }

        .sba-card-title a {
            color: inherit;
            text-decoration: none;
        }

        .sba-card-title a:hover {
            color: var(--sba-primary);
        }

        .sba-progress-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .sba-progress-row .lbl {
            color: var(--sba-muted);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .sba-progress-row .val {
            color: var(--sba-dark);
            font-weight: 900;
            font-size: 1rem;
        }

        .sba-progress {
            height: 8px;
            background: #f1f5f9;
            border-radius: 100px;
            overflow: hidden;
        }

        .sba-progress-bar {
            height: 100%;
            border-radius: 100px;
            background: linear-gradient(90deg, var(--sba-accent), var(--sba-primary), #ec4899);
            transition: width .5s ease;
        }

        .sba-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px dashed var(--sba-border);
            font-size: 0.85rem;
        }

        .sba-meta .lbl { color: var(--sba-muted); font-weight: 600; }
        .sba-meta .val { color: var(--sba-dark); font-weight: 700; }
        .sba-meta .val.is-bad { color: var(--sba-danger); }

        .sba-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px 18px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.95rem;
            text-decoration: none;
            border: none;
            color: #fff !important;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .sba-cta.primary  { background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 12px 24px -10px rgba(99,102,241,.55); }
        .sba-cta.success  { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 12px 24px -10px rgba(16,185,129,.55); }
        .sba-cta.renew    { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 12px 24px -10px rgba(245,158,11,.55); }

        .sba-cta:hover {
            transform: translateY(-2px);
        }

        /* ---------- Empty state ---------- */
        .sba-empty {
            background: #fff;
            border: 2px dashed var(--sba-border);
            border-radius: 22px;
            padding: 48px 24px;
            text-align: center;
            grid-column: 1 / -1;
        }

        .sba-empty-ico {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            color: var(--sba-primary);
            font-size: 1.8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .sba-empty h4 { font-weight: 800; color: var(--sba-dark); margin-bottom: 6px; }
        .sba-empty p  { color: var(--sba-muted); margin-bottom: 18px; }
        .sba-empty .sba-cta {
            width: auto;
            padding: 12px 28px;
        }

        /* ---------- Pagination ---------- */
        .sba-pager {
            margin-top: 36px;
            display: flex;
            justify-content: center;
        }

        .sba-pager .pagination {
            gap: 6px;
        }

        .sba-pager .page-link {
            border-radius: 10px !important;
            border: 1px solid var(--sba-border) !important;
            color: var(--sba-dark) !important;
        }

        .sba-pager .active .page-link {
            background: var(--sba-primary) !important;
            border-color: var(--sba-primary) !important;
            color: #fff !important;
        }
    </style>
@endpush
@section('content')
    <section class="sba-mycourses-page">
        <div class="container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')

                <div class="col-lg-9">
                    @php
                        $student_id = auth()->user()->id;
                        $all_enrollments = \App\Models\Enrollment::where('user_id', $student_id)->get();
                        $total_courses = $all_enrollments->count();

                        $completed = 0;
                        $in_progress = 0;
                        $not_started = 0;
                        foreach ($all_enrollments as $e) {
                            $p = progress_bar($e->course_id);
                            if ($p >= 100) {
                                $completed++;
                            } elseif ($p > 0) {
                                $in_progress++;
                            } else {
                                $not_started++;
                            }
                        }

                        $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
                    @endphp

                    {{-- Hero banner --}}
                    <div class="sba-hero">
                        <h2 class="sba-hero-title">
                            {{ $is_arabic ? 'مرحبًا بك، ' . auth()->user()->name . ' 👋' : 'Welcome back, ' . auth()->user()->name . ' 👋' }}
                        </h2>
                        <p class="sba-hero-sub">
                            {{ $is_arabic ? 'تابع تعلّمك من حيث توقّفت. كل خطوة اليوم تبني غدًا أفضل.' : get_phrase('Pick up where you left off. Every step today builds a better tomorrow.') }}
                        </p>

                        <div class="sba-stats">
                            <div class="sba-stat">
                                <div class="sba-stat-ico" style="background: rgba(99,102,241,0.25); color: #c7d2fe;">
                                    <i class="fi-rr-book-alt"></i>
                                </div>
                                <div class="sba-stat-body">
                                    <span class="sba-stat-num">{{ $total_courses }}</span>
                                    <span class="sba-stat-lbl">{{ $is_arabic ? 'إجمالي الدورات' : get_phrase('Total') }}</span>
                                </div>
                            </div>
                            <div class="sba-stat">
                                <div class="sba-stat-ico" style="background: rgba(6,182,212,0.25); color: #67e8f9;">
                                    <i class="fi-rr-play-circle"></i>
                                </div>
                                <div class="sba-stat-body">
                                    <span class="sba-stat-num">{{ $in_progress }}</span>
                                    <span class="sba-stat-lbl">{{ $is_arabic ? 'قيد التعلم' : get_phrase('In Progress') }}</span>
                                </div>
                            </div>
                            <div class="sba-stat">
                                <div class="sba-stat-ico" style="background: rgba(16,185,129,0.25); color: #6ee7b7;">
                                    <i class="fi-rr-check-circle"></i>
                                </div>
                                <div class="sba-stat-body">
                                    <span class="sba-stat-num">{{ $completed }}</span>
                                    <span class="sba-stat-lbl">{{ $is_arabic ? 'مكتمل' : get_phrase('Completed') }}</span>
                                </div>
                            </div>
                            <div class="sba-stat">
                                <div class="sba-stat-ico" style="background: rgba(245,158,11,0.25); color: #fcd34d;">
                                    <i class="fi-rr-bookmark"></i>
                                </div>
                                <div class="sba-stat-body">
                                    <span class="sba-stat-num">{{ $not_started }}</span>
                                    <span class="sba-stat-lbl">{{ $is_arabic ? 'لم تبدأ بعد' : get_phrase('Not Started') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section heading --}}
                    <div class="sba-section-head">
                        <h3>{{ $is_arabic ? 'دوراتي' : get_phrase('My Courses') }}</h3>
                        <a href="{{ route('courses') }}">
                            {{ $is_arabic ? 'تصفح المزيد' : get_phrase('Browse more') }}
                            <i class="fi-rr-angle-{{ $is_arabic ? 'left' : 'right' }}-small"></i>
                        </a>
                    </div>

                    {{-- Courses grid --}}
                    <div class="sba-cards">
                        @forelse ($my_courses as $course)
                            @php
                                $course_progress = progress_bar($course->course_id);

                                $watch_history = App\Models\Watch_history::where('course_id', $course->course_id)
                                    ->where('student_id', auth()->user()->id)
                                    ->first();

                                $lesson = App\Models\Lesson::where('course_id', $course->course_id)
                                    ->orderBy('sort', 'asc')
                                    ->first();

                                if (!$watch_history && !$lesson) {
                                    $url = route('course.player', ['slug' => $course->slug]);
                                } else {
                                    $lesson_id = $watch_history->watching_lesson_id ?? ($lesson->id ?? null);
                                    $url = route('course.player', ['slug' => $course->slug, 'id' => $lesson_id]);
                                }

                                $is_expired = $course->expiry_date > 0 && $course->expiry_date < time();
                                $is_lifetime = $course->expiry_date == 0;
                            @endphp

                            <div class="sba-card">
                                <div class="sba-card-media">
                                    <img src="{{ get_image($course->thumbnail) }}" alt="{{ $course->title }}">
                                    @if ($is_expired)
                                        <span class="sba-chip is-expired"><i class="fi-rr-cross-circle"></i>{{ $is_arabic ? 'منتهي' : get_phrase('Expired') }}</span>
                                    @elseif ($is_lifetime)
                                        <span class="sba-chip is-lifetime"><i class="fi-rr-infinity"></i>{{ $is_arabic ? 'مدى الحياة' : get_phrase('Lifetime') }}</span>
                                    @else
                                        <span class="sba-chip is-limited"><i class="fi-rr-clock"></i>{{ $is_arabic ? 'محدود' : get_phrase('Limited') }}</span>
                                    @endif
                                </div>

                                <div class="sba-card-body">
                                    <div class="sba-author">
                                        <img src="{{ get_image($course->user_photo) }}" alt="{{ $course->user_name }}">
                                        <span>{{ $course->user_name }}</span>
                                    </div>

                                    <h4 class="sba-card-title">
                                        <a href="{{ route('course.details', $course->slug) }}">{{ ucfirst($course->title) }}</a>
                                    </h4>

                                    <div>
                                        <div class="sba-progress-row">
                                            <span class="lbl">{{ $is_arabic ? 'التقدم' : get_phrase('Progress') }}</span>
                                            <span class="val">{{ $course_progress }}%</span>
                                        </div>
                                        <div class="sba-progress mt-2">
                                            <div class="sba-progress-bar" style="width: {{ $course_progress }}%"></div>
                                        </div>
                                    </div>

                                    <div class="sba-meta">
                                        @if ($is_expired)
                                            <span class="lbl">{{ $is_arabic ? 'انتهى في' : get_phrase('Expired on') }}</span>
                                            <span class="val is-bad">{{ date('d M Y', $course->expiry_date) }}</span>
                                        @elseif ($is_lifetime)
                                            <span class="lbl">{{ $is_arabic ? 'الوصول' : get_phrase('Access') }}</span>
                                            <span class="val">{{ $is_arabic ? 'مدى الحياة' : get_phrase('Lifetime') }}</span>
                                        @else
                                            <span class="lbl">{{ $is_arabic ? 'ينتهي في' : get_phrase('Expires on') }}</span>
                                            <span class="val">{{ date('d M Y', $course->expiry_date) }}</span>
                                        @endif
                                    </div>

                                    @if ($is_expired)
                                        <a href="{{ route('purchase.course', ['course_id' => $course->course_id]) }}" class="sba-cta renew">
                                            <i class="fi-rr-refresh"></i>{{ $is_arabic ? 'تجديد' : get_phrase('Renew') }}
                                        </a>
                                    @elseif ($course_progress >= 100)
                                        <a href="{{ $url }}" class="sba-cta success">
                                            <i class="fi-rr-rotate-right"></i>{{ $is_arabic ? 'شاهد مرة أخرى' : get_phrase('Watch again') }}
                                        </a>
                                    @elseif ($course_progress > 0)
                                        <a href="{{ $url }}" class="sba-cta primary">
                                            <i class="fi-rr-play"></i>{{ $is_arabic ? 'متابعة التعلم' : get_phrase('Continue') }}
                                        </a>
                                    @else
                                        <a href="{{ $url }}" class="sba-cta primary">
                                            <i class="fi-rr-rocket-lunch"></i>{{ $is_arabic ? 'ابدأ الآن' : get_phrase('Start Now') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="sba-empty">
                                <div class="sba-empty-ico"><i class="fi-rr-book-alt"></i></div>
                                <h4>{{ $is_arabic ? 'لم تسجّل في أي دورة بعد' : get_phrase('You haven\'t enrolled in any course yet') }}</h4>
                                <p>{{ $is_arabic ? 'استكشف مكتبتنا وابدأ رحلتك اليوم' : get_phrase('Explore our library and start your journey today') }}</p>
                                <a href="{{ route('courses') }}" class="sba-cta primary">
                                    <i class="fi-rr-search"></i>{{ $is_arabic ? 'تصفح الدورات' : get_phrase('Browse Courses') }}
                                </a>
                            </div>
                        @endforelse
                    </div>

                    @if (count($my_courses) > 0)
                        <div class="sba-pager">
                            {{ $my_courses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')@endpush
