@extends('layouts.admin')
@push('title', get_phrase('Student Progress'))
@push('meta')@endpush
@push('css')
    <style>
        .sp-progress { height: 8px; border-radius: 8px; background: #eef0f4; min-width: 120px; }
        .sp-progress .progress-bar { border-radius: 8px; }
        .sp-summary { display: flex; gap: 14px; flex-wrap: wrap; }
        .sp-summary .box { background: #f7f8fa; border-radius: 10px; padding: 12px 18px; min-width: 130px; }
        .sp-summary .box .num { font-size: 20px; font-weight: 700; }
        .sp-summary .box .lbl { font-size: 12px; color: #6b7280; }
    </style>
@endpush
@section('content')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                <h4 class="title fs-16px mb-0">
                    <a href="{{ route('admin.student.progress') }}" class="text-reset"><i class="fi-rr-arrow-left me-2"></i></a>
                    {{ $course->title }}
                </h4>
                <a href="{{ route('admin.course.edit', $course->id) }}" target="_blank"
                    class="btn ol-btn-outline-secondary d-flex align-items-center cg-8px">
                    <span class="fi-rr-edit"></span>
                    <span>{{ get_phrase('Edit course') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="ol-card mb-3">
        <div class="ol-card-body p-3">
            <div class="sp-summary">
                <div class="box">
                    <div class="num">{{ $students->total() }}</div>
                    <div class="lbl">{{ get_phrase('Enrolled students') }}</div>
                </div>
                <div class="box">
                    <div class="num">{{ $total_lessons }}</div>
                    <div class="lbl">{{ get_phrase('Total lessons') }}</div>
                </div>
                <div class="box">
                    <div class="num">{{ $course_total_label }}</div>
                    <div class="lbl">{{ get_phrase('Total content') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="ol-card">
        <div class="ol-card-body p-3">
            <div class="row mb-3">
                <div class="col-md-6 ms-auto">
                    <form action="{{ route('admin.student.progress.course', $course->id) }}" method="get" class="d-flex gap-2">
                        <input type="text" class="form-control ol-form-control" name="search" value="{{ $search }}"
                            placeholder="{{ get_phrase('Search student by name or email') }}">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Search') }}</button>
                    </form>
                </div>
            </div>

            @if (count($rows) > 0)
                <div class="table-responsive overflow-auto">
                    <table class="table eTable eTable-2">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ get_phrase('Student') }}</th>
                                <th scope="col">{{ get_phrase('Lessons completed') }}</th>
                                <th scope="col">{{ get_phrase('Progress') }}</th>
                                <th scope="col">{{ get_phrase('Watched time') }}</th>
                                <th scope="col">{{ get_phrase('Last activity') }}</th>
                                <th scope="col">{{ get_phrase('Status') }}</th>
                                <th scope="col">{{ get_phrase('Option') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $key => $row)
                                <tr>
                                    <th scope="row"><p class="row-number">{{ ($students->firstItem() ?? 1) + $key }}</p></th>
                                    <td>
                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                            <div class="dAdmin_profile_img">
                                                <img class="img-fluid rounded-circle image-45" width="45" height="45" src="{{ get_image($row['photo']) }}" />
                                            </div>
                                            <div class="ms-1">
                                                <h4 class="title fs-14px">{{ $row['name'] }}</h4>
                                                <p class="sub-title2 text-12px">{{ $row['email'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-bold">{{ $row['completed'] }} / {{ $row['total_lessons'] }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2 min-w-150px">
                                            <div class="progress sp-progress flex-grow-1">
                                                <div class="progress-bar {{ $row['progress'] >= 75 ? 'bg-success' : ($row['progress'] >= 40 ? 'bg-info' : 'bg-warning') }}"
                                                    role="progressbar" style="width: {{ $row['progress'] }}%"></div>
                                            </div>
                                            <span class="fs-12px fw-bold">{{ $row['progress'] }}%</span>
                                        </div>
                                    </td>
                                    <td><p>{{ $row['watched_label'] }}</p></td>
                                    <td>
                                        <p class="fs-13px">
                                            {{ $row['last_activity'] ? date('d M Y', strtotime($row['last_activity'])) : '—' }}
                                        </p>
                                    </td>
                                    <td>
                                        @if ($row['is_completed'])
                                            <span class="badge bg-success text-white">{{ get_phrase('Completed') }}</span>
                                        @elseif ($row['progress'] > 0)
                                            <span class="badge bg-info text-white">{{ get_phrase('In progress') }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white">{{ get_phrase('Not started') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.student.progress.student', ['course_id' => $course->id, 'student_id' => $row['user_id']]) }}"
                                            class="btn ol-btn-light ol-icon-btn" data-bs-toggle="tooltip" title="{{ get_phrase('Lesson details') }}">
                                            <i class="fi-rr-list"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15 mt-2">
                    <p class="admin-tInfo">
                        {{ get_phrase('Showing') . ' ' . count($rows) . ' ' . get_phrase('of') . ' ' . $students->total() . ' ' . get_phrase('data') }}
                    </p>
                    {{ $students->links() }}
                </div>
            @else
                @include('admin.no_data')
            @endif
        </div>
    </div>

@endsection
@push('js')@endpush
