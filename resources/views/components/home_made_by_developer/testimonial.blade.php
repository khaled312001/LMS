{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<section class="testimonials-wrapper section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="section-title">
                    <span class="title-head builder-editable text-primary fw-bold" builder-identity="3">{{ get_phrase('Testimonials') }}</span>
                    <h2 class="title builder-editable fw-bolder mt-2" builder-identity="4">{{ get_phrase('What our clients say about us') }}</h2>
                    <p class="description mt-3 builder-editable text-muted" builder-identity="5">{{ get_phrase('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.') }}</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="user-slider owl-carousel owl-theme">
                    <!-- Single User Opinion -->
                    <div class="p-4 mx-2 bg-white rounded-4 shadow-sm border-0 position-relative h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img class="builder-editable rounded-circle object-fit-cover me-3" style="width: 60px; height: 60px;" builder-identity="6" src="{{ asset('assets/page-builder/block-image/test-image.png') }}" alt="">
                            <div>
                                <h5 class="mb-0 fw-bold"><span class="builder-editable" builder-identity="8">{{ get_phrase('Linchon Philips') }}</span></h5>
                                <small class="text-muted"><span class="builder-editable" builder-identity="9">{{ get_phrase('CEO @ Yahoo') }}</span></small>
                            </div>
                        </div>
                        <ul class="d-flex align-items-center mb-3 text-warning">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star text-muted"></i></li>
                        </ul>
                        <p class="text-muted fst-italic mb-0 line-clamp-3">
                            "<span class="builder-editable" builder-identity="7">{{ get_phrase('Write your testimonial content here') }}</span>"
                        </p>
                    </div>

                    <!-- Single User Opinion 2 -->
                    <div class="p-4 mx-2 bg-white rounded-4 shadow-sm border-0 position-relative h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img class="builder-editable rounded-circle object-fit-cover me-3" style="width: 60px; height: 60px;" builder-identity="10" src="{{ asset('assets/page-builder/block-image/test-image.png') }}" alt="">
                            <div>
                                <h5 class="mb-0 fw-bold"><span class="builder-editable" builder-identity="12">{{ get_phrase('Linchon Philips') }}</span></h5>
                                <small class="text-muted"><span class="builder-editable" builder-identity="13">{{ get_phrase('CEO @ Yahoo') }}</span></small>
                            </div>
                        </div>
                        <ul class="d-flex align-items-center mb-3 text-warning">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>
                        <p class="text-muted fst-italic mb-0 line-clamp-3">
                            "<span class="builder-editable" builder-identity="11">{{ get_phrase('Write your testimonial content here') }}</span>"
                        </p>
                    </div>

                    <!-- Single User Opinion 3 -->
                    <div class="p-4 mx-2 bg-white rounded-4 shadow-sm border-0 position-relative h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img class="builder-editable rounded-circle object-fit-cover me-3" style="width: 60px; height: 60px;" builder-identity="14" src="{{ asset('assets/page-builder/block-image/test-image.png') }}" alt="">
                            <div>
                                <h5 class="mb-0 fw-bold"><span class="builder-editable" builder-identity="16">{{ get_phrase('Linchon Philips') }}</span></h5>
                                <small class="text-muted"><span class="builder-editable" builder-identity="17">{{ get_phrase('CEO @ Yahoo') }}</span></small>
                            </div>
                        </div>
                        <ul class="d-flex align-items-center mb-3 text-warning">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa-regular fa-star"></i></li>
                        </ul>
                        <p class="text-muted fst-italic mb-0 line-clamp-3">
                            "<span class="builder-editable" builder-identity="15">{{ get_phrase('Write your testimonial content here') }}</span>"
                        </p>
                    </div>
                    
                    <!-- Single User Opinion 4 -->
                    <div class="p-4 mx-2 bg-white rounded-4 shadow-sm border-0 position-relative h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img class="builder-editable rounded-circle object-fit-cover me-3" style="width: 60px; height: 60px;" builder-identity="18" src="{{ asset('assets/page-builder/block-image/test-image.png') }}" alt="">
                            <div>
                                <h5 class="mb-0 fw-bold"><span class="builder-editable" builder-identity="20">{{ get_phrase('Linchon Philips') }}</span></h5>
                                <small class="text-muted"><span class="builder-editable" builder-identity="21">{{ get_phrase('CEO @ Yahoo') }}</span></small>
                            </div>
                        </div>
                        <ul class="d-flex align-items-center mb-3 text-warning">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>
                        <p class="text-muted fst-italic mb-0 line-clamp-3">
                            "<span class="builder-editable" builder-identity="19">{{ get_phrase('Write your testimonial content here') }}</span>"
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('.testimonials-wrapper .user-slider').owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        margin: 20,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
</script>
