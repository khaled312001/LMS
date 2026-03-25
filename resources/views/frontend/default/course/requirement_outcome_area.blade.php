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

    $technologies = [];
    if (!empty($course_details->technologies)) {
        $decoded = json_decode($course_details->technologies);
        $technologies = is_array($decoded) ? $decoded : (is_object($decoded) ? (array)$decoded : []);
    }
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp

<div class="ps-box p-0 shadow-none animate__animated animate__fadeIn">
    <div class="requirment d-block">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="requirment-left p-4 h-100 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <h5 class="fw-800 text-dark mb-4"><i class="fi-rr-list-check text-primary me-2"></i> {{ $is_arabic ? 'المتطلبات' : get_phrase('Requirements') }}</h5>
                    <ul class="list-unstyled m-0 d-flex flex-column gap-3">
                        @if (!empty($requirements) && is_array($requirements))
                            @foreach ($requirements as $requirement)
                                <li class="d-flex align-items-start gap-3">
                                    <div class="mt-1 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; background: #e0e7ff; border: 1px solid #c7d2fe;">
                                        <i class="fi-rr-check text-primary small" style="font-size: 0.7rem;"></i>
                                    </div>
                                    <p class="text-secondary mb-0 small">{{ $requirement }}</p>
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
            <div class="col-md-4">
                <div class="requirment-middle p-4 h-100 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <h5 class="fw-800 text-dark mb-4"><i class="fi-rr-settings text-info me-2"></i> {{ $is_arabic ? 'التقنيات والأدوات' : get_phrase('Technologies & Tools') }}</h5>
                    <ul class="list-unstyled m-0 d-flex flex-column gap-3">
                        @if (!empty($technologies) && is_array($technologies))
                            @foreach ($technologies as $tech)
                                <li class="d-flex align-items-start gap-3">
                                    <div class="mt-1 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; background: #e0f2fe; border: 1px solid #bae6fd;">
                                        <i class="fi-rr-check text-info small" style="font-size: 0.7rem;"></i>
                                    </div>
                                    <p class="text-secondary mb-0 small">{{ $tech }}</p>
                                </li>
                            @endforeach
                        @else
                            <li class="text-secondary opacity-50 italic small">
                                <i class="fi-rr-info me-2"></i> {{ get_phrase('No technologies listed') }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="requirment-right p-4 h-100 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <h5 class="fw-800 text-dark mb-4"><i class="fi-rr-star-octogram text-warning me-2"></i> {{ $is_arabic ? 'ماذا ستتعلم؟' : get_phrase('What you will learn') }}</h5>
                    <ul class="list-unstyled m-0 d-flex flex-column gap-3">
                        @if (!empty($outcomes) && is_array($outcomes))
                            @foreach ($outcomes as $outcome)
                                <li class="d-flex align-items-start gap-3">
                                    <div class="mt-1 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; background: #fef3c7; border: 1px solid #fde68a;">
                                        <i class="fi-rr-bulb text-warning small" style="font-size: 0.7rem;"></i>
                                    </div>
                                    <p class="text-secondary mb-0 small">{{ $outcome }}</p>
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