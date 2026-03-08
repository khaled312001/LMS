@php
    $instructor = course_by_instructor($course_details->id);
@endphp

<div class="ps-box p-0 shadow-none eInstructor animate__animated animate__fadeIn">
    <h4 class="fw-800 text-dark mb-4"><i class="fi-rr-chalkboard-user text-primary me-2"></i> {{ get_phrase('About the Instructor') }}</h4>
    
    <div class="instructor-card p-4 rounded-4 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
        <div class="d-flex flex-wrap align-items-center gap-4">
            <div class="position-relative">
                <img src="{{ get_image($instructor->photo) }}" class="rounded-circle shadow-sm" alt="{{ $instructor->name }}" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #4f46e5;">
                <div class="position-absolute bottom-0 end-0 bg-success border border-white border-3 rounded-circle" style="width: 20px; height: 20px;" title="Online"></div>
            </div>
            <div class="flex-grow-1">
                <h3 class="fw-900 text-dark mb-1">{{ ucfirst($instructor->name) }}</h3>
                <p class="text-primary fw-bold mb-2">
                    @php
                        $skills = json_decode($instructor->skills, true);
                        if(is_array($skills) && count($skills) > 0){
                            $skills = array_column($skills, 'value');
                        }
                    @endphp
                    {{ $skills ? implode(' • ', $skills) : '' }}
                </p>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex text-warning">
                        @php $rating = instructor_rating($instructor->id); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa{{ $i <= $rating ? '-solid' : '-regular' }} fa-star fs-6"></i>
                        @endfor
                    </div>
                    <span class="text-secondary small">({{ $rating }} {{ get_phrase('Rating') }})</span>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-4 pt-4 border-top border-light">
            <div class="col-4 text-center">
                <div class="p-3 rounded-3" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <i class="fi-rr-users text-primary fs-4 d-block mb-1"></i>
                    <span class="d-block fw-900 text-dark">{{ count_student_by_instructor($course_details->user_id) }}</span>
                    <span class="text-secondary small">{{ get_phrase('Students') }}</span>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="p-3 rounded-3" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <i class="fi-rr-document text-primary fs-4 d-block mb-1"></i>
                    <span class="d-block fw-900 text-dark">{{ count_course_by_instructor($instructor->id) }}</span>
                    <span class="text-secondary small">{{ get_phrase('Courses') }}</span>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="p-3 rounded-3" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <i class="fi-rr-comment-heart text-primary fs-4 d-block mb-1"></i>
                    <span class="d-block fw-900 text-dark">{{ instructor_reviews($instructor->id) }}</span>
                    <span class="text-secondary small">{{ get_phrase('Reviews') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <p class="text-secondary lh-lg mb-4">
                {{ ucfirst($instructor->about) }}
            </p>
            <a href="{{ route('instructor.details', ['name' => slugify($instructor->name), 'id' => $instructor->id]) }}"
                class="btn-sba-primary w-100 py-3 rounded-pill fw-bold text-center d-inline-block">
                {{ get_phrase('View Full Profile') }}
            </a>
        </div>
    </div>
</div>