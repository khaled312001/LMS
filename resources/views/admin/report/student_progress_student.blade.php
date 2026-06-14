@extends('layouts.admin')
@push('title', get_phrase('Student Progress'))
@push('meta')@endpush
@push('css')
    <style>
        .sp-progress { height: 7px; border-radius: 8px; background: #eef0f4; min-width: 90px; }
        .sp-progress .progress-bar { border-radius: 8px; }
        .sp-summary { display: flex; gap: 14px; flex-wrap: wrap; }
        .sp-summary .box { background: #f7f8fa; border-radius: 10px; padding: 12px 18px; min-width: 130px; }
        .sp-summary .box .num { font-size: 20px; font-weight: 700; }
        .sp-summary .box .lbl { font-size: 12px; color: #6b7280; }
        .sp-section-title { background: #f3f4f6; padding: 10px 14px; border-radius: 8px; font-weight: 700; font-size: 14px; }
    </style>
@endpush
@section('content')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <a href="{{ route('admin.student.progress.course', $course->id) }}" class="text-reset"><i class="fi-rr-arrow-left"></i></a>
                <img class="img-fluid rounded-circle image-45" width="45" height="45" src="{{ get_image($student->photo) }}" />
                <div>
                    <h4 class="title fs-16px mb-0">{{ $student->name }}</h4>
                    <p class="sub-title2 text-12px mb-0">{{ $student->email }}</p>
                </div>
                <span class="ms-md-auto badge bg-light text-dark fs-13px">{{ $course->title }}</span>
            </div>
        </div>
    </div>

    <div class="ol-card mb-3">
        <div class="ol-card-body p-3">
            <div class="sp-summary">
                <div class="box">
                    <div class="num">{{ $completed_count }} / {{ $total_lessons }}</div>
                    <div class="lbl">{{ get_phrase('Lessons completed') }}</div>
                </div>
                <div class="box">
                    <div class="num">{{ $progress }}%</div>
                    <div class="lbl">{{ get_phrase('Overall progress') }}</div>
                </div>
                <div class="box">
                    <div class="num">{{ $watched_label }}</div>
                    <div class="lbl">{{ get_phrase('Total watched time') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="ol-card">
        <div class="ol-card-body p-3">
            @php $hasLessons = false; @endphp
            @foreach ($section_data as $section)
                @if (count($section['lessons']) > 0)
                    @php $hasLessons = true; @endphp
                    <div class="sp-section-title mb-2 mt-3">{{ $section['title'] }}</div>
                    <div class="table-responsive overflow-auto mb-2">
                        <table class="table eTable eTable-2">
                            <thead>
                                <tr>
                                    <th scope="col">{{ get_phrase('Lesson') }}</th>
                                    <th scope="col">{{ get_phrase('Duration') }}</th>
                                    <th scope="col">{{ get_phrase('Watched') }}</th>
                                    <th scope="col">{{ get_phrase('Watched %') }}</th>
                                    <th scope="col">{{ get_phrase('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($section['lessons'] as $lesson)
                                    <tr>
                                        <td><div class="min-w-200px">{{ $lesson['title'] }}</div></td>
                                        <td><p>{{ $lesson['duration_label'] }}</p></td>
                                        <td><p>{{ $lesson['watched_label'] }}</p></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 min-w-120px">
                                                <div class="progress sp-progress flex-grow-1">
                                                    <div class="progress-bar {{ $lesson['watched_pct'] >= 75 ? 'bg-success' : ($lesson['watched_pct'] >= 40 ? 'bg-info' : 'bg-warning') }}"
                                                        role="progressbar" style="width: {{ $lesson['watched_pct'] }}%"></div>
                                                </div>
                                                <span class="fs-12px">{{ $lesson['watched_pct'] }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($lesson['is_completed'])
                                                <span class="badge bg-success text-white"><i class="fi-rr-check me-1"></i>{{ get_phrase('Completed') }}</span>
                                            @elseif ($lesson['watched_pct'] > 0)
                                                <span class="badge bg-info text-white">{{ get_phrase('Watching') }}</span>
                                            @else
                                                <span class="badge bg-secondary text-white">{{ get_phrase('Not started') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach

            @unless ($hasLessons)
                @include('admin.no_data')
            @endunless
        </div>
    </div>

@endsection
@push('js')@endpush
