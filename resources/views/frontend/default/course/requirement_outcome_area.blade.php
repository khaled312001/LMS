@php
    $requirements = [];
    if (!empty($course_details->requirements)) {
        $decoded = json_decode($course_details->requirements);
        $requirements = is_array($decoded) ? $decoded : (is_object($decoded) ? (array)$decoded : []);
    }
    
    $outcomes = [];
    if (!empty($course_details->outcomes)) {
        $decoded = json_decode($course_details->outcomes);
        $outcomes = is_array($decoded) ? $decoded : (is_object($decoded) ? (array)$decoded : []);
    }
@endphp

<div class="ps-box p-0 shadow-none animate__animated animate__fadeIn">
    <div class="requirment d-block">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="requirment-left p-4 h-100 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <h4 class="fw-800 text-dark mb-4"><i class="fi-rr-list-check text-primary me-2"></i> {{ get_phrase('Requirements') }}</h4>
                    <ul class="list-unstyled m-0 d-flex flex-column gap-3">
                        @if (!empty($requirements) && is_array($requirements))
                            @foreach ($requirements as $requirement)
                                <li class="d-flex align-items-start gap-3">
                                    <div class="mt-1 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; background: #e0e7ff; border: 1px solid #c7d2fe;">
                                        <i class="fi-rr-check text-primary small"></i>
                                    </div>
                                    <p class="text-secondary mb-0">{{ $requirement }}</p>
                                </li>
                            @endforeach
                        @else
                            <li class="text-secondary opacity-50 italic small">
                                <i class="fi-rr-info me-2"></i> {{ get_phrase('No requirements listed for this course') }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="requirment-right p-4 h-100 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <h4 class="fw-800 text-dark mb-4"><i class="fi-rr-star-octogram text-primary me-2"></i> {{ get_phrase('What you will learn') }}</h4>
                    <ul class="list-unstyled m-0 d-flex flex-column gap-3">
                        @if (!empty($outcomes) && is_array($outcomes))
                            @foreach ($outcomes as $outcome)
                                <li class="d-flex align-items-start gap-3">
                                    <div class="mt-1 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; background: #fef3c7; border: 1px solid #fde68a;">
                                        <i class="fi-rr-bulb text-warning small"></i>
                                    </div>
                                    <p class="text-secondary mb-0">{{ $outcome }}</p>
                                </li>
                            @endforeach
                        @else
                            <li class="text-secondary opacity-50 italic small">
                                <i class="fi-rr-info me-2"></i> {{ get_phrase('No outcomes listed for this course') }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>