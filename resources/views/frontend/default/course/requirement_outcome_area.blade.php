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

<div class="ps-box p-0 shadow-none">
    <div class="requirment d-block">
        <div class="row row-gap-4">
            <div class="col-sm-6">
                <div class="requirment-left ">
                    <h4 class="g-title mb-20">{{ get_phrase('Requirment') }}</h4>
                    <ul>
                        @if (!empty($requirements) && is_array($requirements))
                            @foreach ($requirements as $requirement)
                                <li class="d-flex">
                                    <i class="fa-solid fa-check"></i>
                                    <p class="description">{{ $requirement }}</p>
                                </li>
                            @endforeach
                        @else
                            <li class="d-flex">
                                <p class="description">{{ get_phrase('No requirements listed') }}</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="requirment-right">
                    <h4 class="g-title mb-20">{{ get_phrase('Outcomes') }}</h4>
                    <ul>
                        @if (!empty($outcomes) && is_array($outcomes))
                            @foreach ($outcomes as $outcome)
                                <li class="d-flex">
                                    <i class="fa-solid fa-check"></i>
                                    <p class="description">{{ $outcome }}</p>
                                </li>
                            @endforeach
                        @else
                            <li class="d-flex">
                                <p class="description">{{ get_phrase('No outcomes listed') }}</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>