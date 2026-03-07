@php
    $review = App\Models\Review::where('course_id', $course->id)
        ->orderBy('id', 'DESC')
        ->get();

    $total = $review->count();
    $rating = array_sum(array_column($review->toArray(), 'rating'));

    $average_rating = 0;
    if ($total != 0) {
        $average_rating = $rating / $total;
    }

    $wishlist = App\Models\Wishlist::where('user_id', auth()->user()->id ?? '')->pluck('course_id')->toArray();
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp

<div class="col-lg-4 col-md-6 mb-4">
    <div class="vibrant-course-card h-100 p-3 shadow-sm transition-all border-0 bg-white radius-30 position-relative">
        <a href="{{ route('course.details', $course->slug) }}" class="text-decoration-none d-block">
            <div class="position-relative mb-4 overflow-hidden rounded-24">
                <img src="{{ get_image($course->thumbnail) }}" class="w-100 object-fit-cover" style="height: 220px;" alt="{{ $course->title }}">
                
                @if ($course->discount_flag == 1)
                     <span class="position-absolute top-15 end-15 badge bg-danger rounded-pill px-3 py-2 fw-bold" style="top: 15px; right: 15px;">
                        {{ round((($course->price - $course->discounted_price) / $course->price) * 100) }}% {{ $is_arabic ? 'خصم' : get_phrase('OFF') }}
                    </span>
                @endif

                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                    <div class="d-flex justify-content-between align-items-center text-white">
                        <span class="badge bg-vibrant-primary rounded-pill px-3 py-2 small fw-bold">{{ $is_arabic ? 'احترافي' : get_phrase('Professional') }}</span>
                         @auth
                            <div class="wishlist-btn">
                                @if (in_array($course->id, $wishlist))
                                    <span class="toggleWishItem inList cursor-pointer" id="item-{{ $course->id }}"><i class="fa-solid fa-heart text-danger"></i></span>
                                @else
                                    <span class="toggleWishItem cursor-pointer" id="item-{{ $course->id }}"><i class="fa-regular fa-heart"></i></span>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="card-body p-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ get_image($course->instructor_image) }}" class="rounded-circle border border-2 border-light shadow-sm" style="width: 32px; height: 32px; object-fit: cover;">
                        <span class="small fw-bold text-muted">{{ $course->instructor_name }}</span>
                    </div>
                    <div class="text-warning small fw-bold">
                        <i class="fa fa-star me-1"></i>{{ number_format($average_rating, 1) }}
                    </div>
                </div>

                <h4 class="fw-900 text-dark mb-3 lh-base ellipsis-line-2" style="height: 3rem;">{{ ucfirst($course->title) }}</h4>

                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <i class="fi-rr-play-alt text-vibrant-primary"></i>
                        <span>{{ lesson_count($course->id) }} {{ $is_arabic ? 'درس' : get_phrase('lessons') }}</span>
                    </div>
                    <div class="price">
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
        </a>
    </div>
</div>
