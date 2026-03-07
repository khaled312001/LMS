@extends('layouts.landing')
@push('title', get_phrase('Course Details'))
@push('meta')@endpush
@push('css')
<style>
    .custom-vibrant-tabs .nav-link {
        color: rgba(15, 23, 42, 0.6);
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .custom-vibrant-tabs .nav-link.active {
        background: var(--vibrant-primary) !important;
        color: white !important;
        border-color: var(--vibrant-primary);
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
    }
    .custom-vibrant-tabs .nav-link:hover:not(.active) {
        background: rgba(255,255,255,0.1);
        color: white;
    }
    .breadcum-area .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.3) !important;
    }
    .ps-box.static-menu {
        background: transparent !important;
        border: none !important;
    }
    .tab-content {
        background: var(--vibrant-white);
        border-radius: 30px;
        padding: 40px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }
    .tab-content .g-title, 
    .tab-content h4, 
    .tab-content h3, 
    .tab-content h5, 
    .tab-content p, 
    .tab-content li, 
    .tab-content i,
    .tab-content a:not(.btn):not(.eBtn),
    .tab-content span:not(.badge) {
        color: var(--vibrant-dark) !important;
    }
    .s_stext {
        color: white !important;
        opacity: 0.8;
    }
    .s_stext:hover {
        color: var(--vibrant-accent) !important;
        opacity: 1;
    }
    .accordion-item {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 15px !important;
        margin-bottom: 10px;
        overflow: hidden;
    }
    .accordion-button {
        background: transparent !important;
        color: white !important;
        font-weight: 700 !important;
        box-shadow: none !important;
    }
    .accordion-button:not(.collapsed) {
        color: var(--vibrant-accent) !important;
    }
    .accordion-button::after {
        filter: brightness(0) invert(1);
    }
    .tab-content .fa-star, 
    .tab-content .fa-star-half-alt,
    .text-warning .fa-star {
        color: #f59e0b !important;
    }
    .lesson-list li a path {
        fill: white !important;
    }
    .lesson-list li a:hover {
        background: rgba(255,255,255,0.1) !important;
        border-radius: 10px;
    }
    .body-bg {
        background: var(--vibrant-light) !important;
    }

    /* Pricing Card Specifics */
    .sidebar-overlap {
        margin-top: -300px;
    }
    @media (max-width: 991px) {
        .sidebar-overlap {
            margin-top: 20px;
        }
    }
    .shadow-vibrant {
        box-shadow: 0 15px 40px rgba(79, 70, 229, 0.25);
    }

    .share-icon-vibrant {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white !important;
        transition: all 0.3s ease;
        text-decoration: none !important;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .share-icon-vibrant:hover {
        transform: translateY(-3px);
        background: var(--vibrant-primary);
        border-color: var(--vibrant-primary);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
    }
    .share-icon-vibrant.fb:hover { background: #1877f2; border-color: #1877f2; }
    .share-icon-vibrant.tw:hover { background: #1da1f2; border-color: #1da1f2; }
    .share-icon-vibrant.wa:hover { background: #25d366; border-color: #25d366; }
    .share-icon-vibrant.in:hover { background: #0a66c2; border-color: #0a66c2; }

    /* Vibrant Accordion */
    .custom-vibrant-accordion .accordion-button {
        background: rgba(255,255,255,0.03) !important;
        border: 1px solid rgba(255,255,255,0.05) !important;
        color: white !important;
        box-shadow: none !important;
        transition: all 0.3s ease;
    }
    .custom-vibrant-accordion .accordion-button:not(.collapsed) {
        background: rgba(79, 70, 229, 0.1) !important;
        border-color: rgba(79, 70, 229, 0.3) !important;
        color: var(--vibrant-accent) !important;
    }
    .custom-vibrant-accordion .accordion-button::after {
        filter: brightness(0) invert(1);
    }

    /* Review Styles */
    .vibrant-textarea {
        background: rgba(255,255,255,0.03) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        border-radius: 20px !important;
        color: white !important;
        padding: 20px !important;
        transition: all 0.3s ease;
    }
    .vibrant-textarea:focus {
        background: rgba(255,255,255,0.05) !important;
        border-color: var(--vibrant-primary) !important;
        box-shadow: 0 0 15px rgba(79, 70, 229, 0.2) !important;
    }
    .review-action {
        color: white !important;
        opacity: 0.4;
        text-decoration: none !important;
        transition: all 0.3s ease;
        font-weight: bold;
    }
    .review-action:hover, .review-action.active {
        opacity: 1;
        color: var(--vibrant-primary) !important;
    }
    .review-action i {
        font-size: 1.1rem;
    }

    /* Transitions & Hover Effects */
    .hover-translate-x-5:hover {
        transform: translateX(5px);
    }
    .hover-gap-3:hover {
        gap: 1rem !important;
    }
    .pointer {
        cursor: pointer;
    }
</style>
@endpush
@section('content')
    @php
        $course_creator = get_course_creator_id($course_details->id);
        $instructor_review = collect([]);
        if ($course_creator && isset($course_creator->id)) {
            $instructor_review = App\Models\Instructor_review::where('instructor_id', $course_creator->id)
                ->orderBy('id', 'DESC')
                ->get();
        }

        $review = App\Models\Review::where('course_id', $course_details->id)
            ->orderBy('id', 'DESC')
            ->get();

        $total = $review->count();
        $rating = array_sum(array_column($review->toArray(), 'rating'));

        $average_rating = 0;
        if ($total != 0) {
            $average_rating = $rating / $total;
        }

        $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
    @endphp
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area position-relative overflow-hidden py-5 pt-200" style="background: var(--vibrant-dark); min-height: 500px;">
        <!-- Mesh Gradient Background -->
        <div class="position-absolute w-100 h-100 top-0 start-0" style="background: radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.15) 0%, transparent 50%), radial-gradient(circle at 100% 100%, rgba(126, 34, 206, 0.15) 0%, transparent 50%); z-index: 0;"></div>
        
        <div class="container position-relative" style="z-index: 1;">
            <div class="row">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-50 text-decoration-none hover-opacity-100 transition-all">{{ $is_arabic ? 'الرئيسية' : get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">{{ $course_details->title }}</li>
                        </ol>
                    </nav>

                    <span class="vibrant-tag mb-4 d-inline-block">{{ $is_arabic ? 'دورة تدريبية' : get_phrase('Course Details') }}</span>
                    <h1 class="display-4 fw-900 text-white mb-4 lh-base">{{ $course_details->title }}</h1>
                    <p class="fs-5 text-white opacity-75 mb-5 pe-lg-5">
                        {{ ellipsis($course_details->short_description, 200) }}
                    </p>

                    <div class="d-flex flex-wrap gap-4 align-items-center text-white pb-4">
                        <div class="d-flex align-items-center gap-2">
                             <img class="rounded-circle border border-2 border-white-10" width="40" height="40" src="{{ get_image(course_by_instructor($course_details->id)->photo) }}" alt="instructor-image">
                             <span class="fw-bold opacity-75">{{ course_by_instructor($course_details->id)->name }}</span>
                        </div>
                        <div class="vr opacity-25 d-none d-md-block"></div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-warning small d-flex gap-1">
                                @if ($total > 0)
                                    @for ($i = 0; $i < round($average_rating); $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                    <span class="ms-1 fw-bold">{{ number_format($average_rating, 1) }}</span>
                                @else
                                    <i class="fa fa-star text-secondary opacity-50"></i>
                                    <span class="ms-1 fw-bold">0.0</span>
                                @endif
                            </div>
                            <span class="small opacity-50">({{ $total }} {{ $is_arabic ? 'تقييم' : get_phrase('Reviews') }})</span>
                        </div>
                        <div class="vr opacity-25 d-none d-md-block"></div>
                        <div class="d-flex align-items-center gap-2 small opacity-75">
                            <i class="fa-solid fa-globe"></i>
                            {{ ucfirst($is_arabic ? 'الإنجليزية' : $course_details->language) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="body-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 order-2 order-lg-1">

                     <div class="details-page-content">
                        <div class="ps-box static-menu mt-5 w-100">
                            <ul class="nav nav-pills custom-vibrant-tabs gap-2 mb-4" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active rounded-pill px-4 fw-bold" id="pills-overview-tab" data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab">{{ $is_arabic ? 'نظرة عامة' : get_phrase('Overview') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill px-4 fw-bold" id="pills-course-content-tab" data-bs-toggle="pill" data-bs-target="#pills-course-content" type="button" role="tab">{{ $is_arabic ? 'المنهج' : get_phrase('Curriculum') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill px-4 fw-bold" id="pills-details-tab" data-bs-toggle="pill" data-bs-target="#pills-details" type="button" role="tab">{{ $is_arabic ? 'التفاصيل' : get_phrase('Details') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill px-4 fw-bold" id="pills-instructor-tab" data-bs-toggle="pill" data-bs-target="#pills-instructor" type="button" role="tab">{{ $is_arabic ? 'المدرب' : get_phrase('Instructor') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill px-4 fw-bold" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab">{{ $is_arabic ? 'التقييمات' : get_phrase('Reviews') }}</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab" tabindex="0">
                                    @include('frontend.default.course.overview_area')
                                </div>
                                <div class="tab-pane fade" id="pills-course-content" role="tabpanel" aria-labelledby="pills-course-content-tab" tabindex="0">
                                    @include('frontend.default.course.content_area')
                                </div>
                                <div class="tab-pane fade" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab" tabindex="0">
                                    @include('frontend.default.course.requirement_outcome_area')
                                </div>
                                <div class="tab-pane fade" id="pills-instructor" role="tabpanel" aria-labelledby="pills-instructor-tab" tabindex="0">
                                    @include('frontend.default.course.instructor_area')
                                </div>
                                <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
                                    @include('frontend.default.course.review_area')
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-4 order-1 order-lg-2 mb-5">
                     <div class="pricing-card-wrapper position-sticky sidebar-overlap" style="z-index: 100; top: 120px;">
                        @include('frontend.default.course.pricing_card')
                     </div>
                </div>
            </div>
            <!------------------- Player Feature Area End  --------->
        </div>
    </section>

    <!------------------- Breadcum Area End  --------->


    <!-- Vertically centered modal -->
    <div class="modal fade-in-effect" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <link rel="stylesheet" href="{{ asset('assets/global/plyr/plyr.css') }}">
                    @php
                        $preview_video_type = str_contains($course_details->preview, 'youtu') ? 'youtube' : '';
                        $preview_video_type = str_contains($course_details->preview, 'vimeo') && $preview_video_type == '' ? 'vimeo' : $preview_video_type;
                        $preview_video_type = str_contains($course_details->preview, 'http') && $preview_video_type == '' ? 'html5' : $preview_video_type;
                    @endphp

                    @if ($preview_video_type == 'youtube')
                        <div class="plyr__video-embed" id="promoPlayer">
                            <iframe height="500" src="{{ $course_details->preview }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    @elseif ($preview_video_type == 'vimeo')
                        <div class="plyr__video-embed" id="promoPlayer">
                            <iframe height="500" id="promoPlayer" src="https://player.vimeo.com/video/{{ $course_details->preview }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    @elseif($preview_video_type == 'html5')
                        <video id="promoPlayer" playsinline controls>
                            <source src="{{ $course_details->preview }}" type="video/mp4">
                        </video>
                    @else
                        <video id="promoPlayer" playsinline controls>
                            <source src="{{ asset($course_details->preview) }}" type="video/mp4">
                        </video>
                    @endif

                    <script src="{{ asset('assets/global/plyr/plyr.js') }}"></script>
                    <script>
                        "use strict";
                        const promoPlayer = new Plyr('#promoPlayer');
                    </script>

                </div>
            </div>
        </div>
    </div>

    <script>
        "use strict";
        const myModalElement = document.getElementById('exampleModal')
        myModalElement.addEventListener('hidden.bs.modal', event => {
            promoPlayer.pause();
            $('#exampleModal').toggleClass('in');
        });
        myModalElement.addEventListener('shown.bs.modal', event => {
            promoPlayer.play();
            $('#exampleModal').toggleClass('in');
        });
    </script>

@endsection
@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('#more_description').on('click', function(e) {
                e.preventDefault();

                let ellipsis = $('.description').attr('id');
                $('.description').toggleClass(ellipsis);

                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).text('See less');
                } else {
                    $(this).html('See more <i class="fa-solid fa-angle-right me-2"></i>');
                }
            });
        });
    </script>
@endpush
