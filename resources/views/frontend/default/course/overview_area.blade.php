<div class="ps-box p-0 shadow-none animate__animated animate__fadeIn">
    <h4 class="fw-900 text-white mb-4 display-6">{{ get_phrase('Course Overview') }}</h4>
    <div class="description text-white opacity-70 fs-5 lh-lg mb-4" id="ellipsis-4">
        @if (isset($course_details->description))
            {!! removeScripts($course_details->description) !!}
        @else
            <p class="text-center opacity-50">{{ get_phrase('No Course Description') }}</p>
        @endif
    </div>
    @if (isset($course_details->description))
        <a href="#" class="btn btn-link text-vibrant-accent fw-bold text-decoration-none p-0 d-flex align-items-center gap-2 transition-all hover-gap-3" id="more_description">
            {{ get_phrase('See more') }} <i class="fi-rr-arrow-small-right fs-4"></i>
        </a>
    @endif
</div>


</div>
@include('frontend.default.course.faq_area')