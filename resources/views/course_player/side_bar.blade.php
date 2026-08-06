@php
    $sections = App\Models\Section::where('course_id', $course_details->id)
        ->orderBy('sort')
        ->get();

    $completed_lesson = json_decode(
        App\Models\Watch_history::where('course_id', $course_details->id)
            ->where('student_id', auth()->id())
            ->value('completed_lesson'),
        true,
    ) ?? [];
    $active_section = App\Models\Lesson::where('id', $lesson_details->id ?? '')->value('section_id');

    $lesson_history = App\Models\Watch_history::where('course_id', $course_details->id)
        ->where('student_id', auth()->id())
        ->firstOrNew();
    $completed_lesson_arr = json_decode($lesson_history->completed_lesson, true);
    $completed_lesson_arr = is_array($completed_lesson_arr) ? $completed_lesson_arr : [];
    $complated_lesson = count($completed_lesson_arr);
    $course_progress_out_of_100 = progress_bar($course_details->id);

    $user_id = auth()->id();
    $is_course_instructor = is_course_instructor($course_details->id, $user_id);

    $is_locked = 0;
    $locked_lesson_ids = [];
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp

<style>
    .sba-curr {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #eef1f6;
        overflow: hidden;
        box-shadow: 0 20px 40px -24px rgba(15, 23, 42, 0.12);
    }

    .sba-curr-head {
        padding: 22px 22px 20px;
        background: linear-gradient(135deg, #eef2ff 0%, #f5f3ff 100%);
        border-bottom: 1px solid #e0e7ff;
    }

    .sba-curr-head h3 {
        font-size: 1.1rem;
        font-weight: 900;
        color: #0f172a;
        margin: 0 0 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sba-curr-head h3 i {
        color: #6366f1;
    }

    .sba-curr-progress {
        height: 8px;
        background: rgba(99, 102, 241, 0.12);
        border-radius: 100px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .sba-curr-progress > div {
        height: 100%;
        background: linear-gradient(90deg, #06b6d4, #6366f1, #ec4899);
        border-radius: 100px;
        transition: width 0.5s ease;
    }

    .sba-curr-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #475569;
    }

    .sba-curr-meta b {
        color: #0f172a;
    }

    .sba-curr-body {
        max-height: 75vh;
        overflow-y: auto;
        padding: 6px 0;
    }

    .sba-curr-body::-webkit-scrollbar {
        width: 6px;
    }

    .sba-curr-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .sba-section {
        border-bottom: 1px solid #f1f5f9;
    }

    .sba-section:last-child {
        border-bottom: none;
    }

    .sba-section-toggle {
        width: 100%;
        padding: 16px 22px;
        background: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        cursor: pointer;
        transition: background 0.25s ease;
        text-align: inherit;
        font: inherit;
    }

    .sba-section-toggle:hover {
        background: #f8fafc;
    }

    .sba-section-toggle .sba-sec-title {
        font-weight: 800;
        font-size: 0.95rem;
        color: #0f172a;
        flex: 1;
        min-width: 0;
    }

    .sba-section-toggle .sba-sec-count {
        font-size: 0.78rem;
        color: #64748b;
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 100px;
        font-weight: 700;
    }

    .sba-section-toggle .sba-chev {
        color: #94a3b8;
        transition: transform 0.3s ease;
    }

    .sba-section.is-open .sba-section-toggle .sba-chev {
        transform: rotate(180deg);
    }

    .sba-lesson-list {
        list-style: none;
        padding: 0 0 12px;
        margin: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
    }

    .sba-section.is-open .sba-lesson-list {
        max-height: 1500px;
    }

    .sba-lesson {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 22px 10px 22px;
        text-decoration: none;
        color: inherit;
        transition: background 0.2s ease;
        position: relative;
    }

    .sba-lesson:hover {
        background: #f8fafc;
    }

    .sba-lesson.is-active {
        background: linear-gradient(90deg, rgba(99, 102, 241, 0.08), transparent);
        box-shadow: inset 3px 0 0 #6366f1;
    }

    html[dir="rtl"] .sba-lesson.is-active {
        box-shadow: inset -3px 0 0 #6366f1;
    }

    .sba-lesson-status {
        flex: 0 0 auto;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        border: 1px solid #e2e8f0;
    }

    .sba-lesson-status.done {
        background: #dcfce7;
        color: #16a34a;
        border-color: #bbf7d0;
    }

    .sba-lesson-status.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 6px 14px -6px rgba(99, 102, 241, 0.6);
    }

    .sba-lesson-status.locked {
        background: #f1f5f9;
        color: #94a3b8;
    }

    .sba-lesson-body {
        flex: 1;
        min-width: 0;
    }

    .sba-lesson-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .sba-lesson.is-active .sba-lesson-title {
        color: #4f46e5;
        font-weight: 800;
    }

    .sba-lesson-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        font-size: 0.75rem;
        color: #64748b;
    }

    .sba-lesson-meta .sep {
        width: 3px;
        height: 3px;
        background: #cbd5e1;
        border-radius: 50%;
    }

    .sba-lesson-meta i {
        font-size: 0.8rem;
    }

    .sba-lesson.is-locked {
        opacity: 0.55;
        pointer-events: none;
    }
</style>

<div class="sba-curr">
    <div class="sba-curr-head">
        <h3>
            <i class="fi-rr-list-check"></i>
            {{ $is_arabic ? 'منهج الدورة' : get_phrase('Course curriculum') }}
        </h3>
        <div class="sba-curr-progress">
            <div style="width: {{ $course_progress_out_of_100 }}%"></div>
        </div>
        <div class="sba-curr-meta">
            <span>
                <b>{{ $complated_lesson }}</b> / {{ lesson_count($course_details->id) }}
                {{ $is_arabic ? 'درس' : get_phrase('Lessons') }}
            </span>
            <span><b>{{ $course_progress_out_of_100 }}%</b> {{ $is_arabic ? 'مكتمل' : get_phrase('Completed') }}</span>
        </div>
    </div>

    <div class="sba-curr-body">
        @foreach ($sections as $section)
            @php
                $lessons = App\Models\Lesson::where('section_id', $section->id)->orderBy('sort')->get();
                $section_is_open = $section->id == $active_section;
            @endphp
            <div class="sba-section {{ $section_is_open ? 'is-open' : '' }}" data-sba-section>
                <button type="button" class="sba-section-toggle">
                    <span class="sba-sec-title">{{ ucfirst($section->title) }}</span>
                    <span class="sba-sec-count">{{ $lessons->count() }}</span>
                    <svg class="sba-chev" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>

                <ul class="sba-lesson-list">
                    @foreach ($lessons as $lesson)
                        @php
                            $type = $lesson->lesson_type;
                            $is_current = isset($lesson_details->id) && $lesson->id == $lesson_details->id;
                            $is_done = in_array($lesson->id, $completed_lesson_arr);
                            $lesson_locked = $course_details->enable_drip_content && $is_locked;

                            if ($is_done) {
                                $status_class = 'done';
                                $status_svg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                            } elseif ($is_current) {
                                $status_class = 'active';
                                $status_svg = '<svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>';
                            } elseif ($lesson_locked) {
                                $status_class = 'locked';
                                $status_svg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>';
                            } else {
                                $status_class = '';
                                $icon_mark = 'file';
                                if (in_array($type, ['video-url', 'system-video', 'vimeo-url', 'google_drive'])) {
                                    $icon_mark = 'play';
                                } elseif ($type == 'image') {
                                    $icon_mark = 'image';
                                } elseif ($type == 'quiz') {
                                    $icon_mark = 'quiz';
                                }
                                if ($icon_mark == 'play') {
                                    $status_svg = '<svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>';
                                } elseif ($icon_mark == 'image') {
                                    $status_svg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>';
                                } elseif ($icon_mark == 'quiz') {
                                    $status_svg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
                                } else {
                                    $status_svg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>';
                                }
                            }

                            $type_label_ar = [
                                'text' => 'مستند',
                                'document_type' => 'ملف',
                                'iframe' => 'ملف',
                                'video-url' => 'فيديو',
                                'system-video' => 'فيديو',
                                'vimeo-url' => 'فيديو',
                                'google_drive' => 'فيديو',
                                'image' => 'صورة',
                                'quiz' => 'اختبار',
                            ];
                            $type_label_en = [
                                'text' => 'Document',
                                'document_type' => 'File',
                                'iframe' => 'File',
                                'video-url' => 'Video',
                                'system-video' => 'Video',
                                'vimeo-url' => 'Video',
                                'google_drive' => 'Video',
                                'image' => 'Image',
                                'quiz' => 'Quiz',
                            ];
                            $type_label = $is_arabic ? ($type_label_ar[$type] ?? 'مستند') : ($type_label_en[$type] ?? 'Lesson');

                            $lesson_dur = lesson_durations($lesson->id);
                        @endphp
                        <li>
                            <a href="{{ $lesson_locked ? 'javascript:void(0)' : route('course.player', ['slug' => $course_details->slug, 'id' => $lesson->id]) }}"
                                class="sba-lesson {{ $is_current ? 'is-active' : '' }} {{ $lesson_locked ? 'is-locked' : '' }}">
                                <span class="sba-lesson-status {{ $status_class }}">
                                    {!! $status_svg !!}
                                </span>
                                <div class="sba-lesson-body">
                                    <div class="sba-lesson-title">{{ $lesson->title }}</div>
                                    <div class="sba-lesson-meta">
                                        <span>{{ $type_label }}</span>
                                        @if ($lesson_dur && $lesson_dur != '00:00:00')
                                            <span class="sep"></span>
                                            <span><i class="fi-rr-clock"></i> {{ $lesson_dur }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </li>
                        @php
                            if ($is_locked) {
                                $locked_lesson_ids[] = $lesson->id;
                            }
                            if (
                                !in_array($lesson->id, $completed_lesson_arr) &&
                                !$is_locked &&
                                $course_details->enable_drip_content == 1 &&
                                auth()->user() &&
                                !$is_course_instructor
                            ) {
                                $is_locked = 1;
                            }
                        @endphp
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>

<script>
    (function () {
        document.querySelectorAll('[data-sba-section] .sba-section-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.closest('[data-sba-section]').classList.toggle('is-open');
            });
        });

        // Auto-scroll the active lesson into view
        const active = document.querySelector('.sba-lesson.is-active');
        if (active) {
            setTimeout(() => {
                active.scrollIntoView({ block: 'center', behavior: 'smooth' });
            }, 200);
        }
    })();
</script>
