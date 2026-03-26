@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp
<div class="col-lg-12 mb-4">
    <div class="vibrant-course-card p-3 shadow-sm border-0 bg-white radius-30 h-100">
        <a href="{{ route('course.details', $course->slug) }}" class="text-decoration-none">
            <div class="row g-0 h-100">
                <div class="col-lg-4 col-md-4 h-100">
                    <div class="position-relative overflow-hidden rounded-24 h-100">
                        <img src="{{ get_image($course->thumbnail) }}" class="w-100 h-100 object-fit-cover" style="min-height: 200px;" alt="{{ $course->title }}">
                         @if ($course->discount_flag == 1)
                            <span class="position-absolute top-15 end-15 badge bg-danger rounded-pill px-3 py-2 fw-bold" style="top: 15px; right: 15px; z-index: 10;">
                                {{ round((($course->price - $course->discounted_price) / $course->price) * 100) }}% {{ $is_arabic ? 'خصم' : get_phrase('OFF') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="card-body p-4 d-flex flex-column h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-vibrant-primary-soft text-vibrant-primary rounded-pill px-3 py-2 small fw-bold" style="background: rgba(79, 70, 229, 0.1);">{{ $is_arabic ? 'احترافي' : get_phrase('Professional') }}</span>
                            @auth
                                <div class="wishlist-btn">
                                    @if (isset($wishlist) && in_array($course->id, $wishlist))
                                        <span class="toggleWishItem inList cursor-pointer" id="item-{{ $course->id }}"><i class="fa-solid fa-heart text-danger"></i></span>
                                    @else
                                        <span class="toggleWishItem cursor-pointer" id="item-{{ $course->id }}"><i class="fa-regular fa-heart"></i></span>
                                    @endif
                                </div>
                            @endauth
                        </div>

                        <h3 class="fw-900 text-dark mb-3 lh-base ellipsis-line-2">{{ ucfirst($course->title) }}</h3>
                        
                        <p class="text-muted small mb-4 ellipsis-line-2">{{ strip_tags($course->description) }}</p>

                        <div class="mt-auto pt-3 border-top d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-4 text-muted small">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fi-rr-play-alt text-vibrant-primary"></i>
                                    <span>{{ lesson_count($course->id) }} {{ $is_arabic ? 'درس' : get_phrase('lessons') }}</span>
                                </div>
                                <div class="text-warning">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    <span class="text-muted ms-1 small">(5.0)</span>
                                </div>
                            </div>
                            <div class="price mt-2 mt-md-0">
                                @if ($course->is_paid == 0)
                                    <span class="fs-4 fw-900 text-success">{{ get_phrase('Free') }}</span>
                                @else
                                    <h4 class="fw-900 text-vibrant-gradient mb-0">
                                        {{ currency($course->discount_flag == 1 ? $course->discounted_price : $course->price) }}
                                    </h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
