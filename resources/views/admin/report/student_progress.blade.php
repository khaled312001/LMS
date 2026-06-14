@extends('layouts.admin')
@push('title', get_phrase('Student Progress'))
@push('meta')@endpush
@push('css')
    <style>
        .sp-course-card { transition: box-shadow .2s ease, transform .2s ease; height: 100%; }
        .sp-course-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); transform: translateY(-2px); }
        .sp-thumb { width: 100%; height: 140px; object-fit: cover; border-radius: 10px; }
        .sp-progress { height: 8px; border-radius: 8px; background: #eef0f4; }
        .sp-progress .progress-bar { border-radius: 8px; }
        .sp-stat { text-align: center; }
        .sp-stat .num { font-size: 20px; font-weight: 700; line-height: 1; }
        .sp-stat .lbl { font-size: 12px; color: #6b7280; }
    </style>
@endpush
@section('content')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                <h4 class="title fs-16px mb-0">
                    <i class="fi-rr-chart-histogram me-2"></i>
                    {{ get_phrase('Student Progress') }}
                </h4>
                <form action="{{ route('admin.student.progress') }}" method="get" class="d-flex gap-2" style="max-width: 360px;">
                    <input type="text" class="form-control ol-form-control" name="search" value="{{ $search }}"
                        placeholder="{{ get_phrase('Search course') }}">
                    <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Search') }}</button>
                </form>
            </div>
        </div>
    </div>

    @if (count($courses) > 0)
        <div class="row g-3">
            @foreach ($courses as $course)
                @php $st = $stats[$course->id] ?? ['enrolled' => 0, 'total_lessons' => 0, 'avg_progress' => 0, 'active_learners' => 0]; @endphp
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="ol-card sp-course-card">
                        <div class="ol-card-body p-3">
                            <img class="sp-thumb mb-3" src="{{ get_image($course->thumbnail) }}" alt="">
                            <h4 class="title fs-15px mb-3" style="min-height: 42px; line-height: 1.4;">
                                {{ \Illuminate\Support\Str::limit($course->title, 60) }}
                            </h4>

                            <div class="d-flex justify-content-between mb-1">
                                <span class="fs-12px text-muted">{{ get_phrase('Average progress') }}</span>
                                <span class="fs-12px fw-bold">{{ $st['avg_progress'] }}%</span>
                            </div>
                            <div class="progress sp-progress mb-3">
                                <div class="progress-bar {{ $st['avg_progress'] >= 75 ? 'bg-success' : ($st['avg_progress'] >= 40 ? 'bg-info' : 'bg-warning') }}"
                                    role="progressbar" style="width: {{ $st['avg_progress'] }}%"></div>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-4 sp-stat">
                                    <div class="num">{{ $st['enrolled'] }}</div>
                                    <div class="lbl">{{ get_phrase('Students') }}</div>
                                </div>
                                <div class="col-4 sp-stat">
                                    <div class="num">{{ $st['active_learners'] }}</div>
                                    <div class="lbl">{{ get_phrase('Active') }}</div>
                                </div>
                                <div class="col-4 sp-stat">
                                    <div class="num">{{ $st['total_lessons'] }}</div>
                                    <div class="lbl">{{ get_phrase('Lessons') }}</div>
                                </div>
                            </div>

                            <a href="{{ route('admin.student.progress.course', $course->id) }}"
                                class="btn ol-btn-primary w-100 d-flex align-items-center justify-content-center cg-8px">
                                <span class="fi-rr-eye"></span>
                                <span>{{ get_phrase('View progress') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15 mt-3">
            <p class="admin-tInfo">
                {{ get_phrase('Showing') . ' ' . count($courses) . ' ' . get_phrase('of') . ' ' . $courses->total() . ' ' . get_phrase('data') }}
            </p>
            {{ $courses->links() }}
        </div>
    @else
        <div class="ol-card"><div class="ol-card-body p-3">@include('admin.no_data')</div></div>
    @endif

@endsection
@push('js')@endpush
