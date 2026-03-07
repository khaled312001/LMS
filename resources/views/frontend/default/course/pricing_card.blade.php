@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp
<div class="bento-item p-4 shadow-lg border-0 bg-white-5 position-relative overflow-hidden" style="border-radius: 30px !important; backdrop-filter: blur(20px);">
    <div class="position-absolute w-100 h-100 top-0 start-0" style="background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, transparent 100%); z-index: 0;"></div>
    
    <div class="position-relative" style="z-index: 1;">
        <div class="hero-details mb-4">
            <div class="position-relative overflow-hidden" style="border-radius: 20px;">
                <img class="w-100" src="{{ get_image($course_details->banner) }}" alt="{{ $course_details->title }}" style="transition: transform 0.5s ease;">
                <div class="position-absolute w-100 h-100 top-0 start-0 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.3);">
                    <div class="play-circle cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal" style="width: 60px; height: 60px; background: white; border-radius: 50%; d-flex; align-items: center; justify-content: center; box-shadow: 0 0 20px rgba(255,255,255,0.5);">
                        <i class="fa-solid fa-play text-dark fs-4 ms-1"></i>
                    </div>
                </div>
            </div>
        </div>

        @if ($course_details->is_best)
            <div class="vibrant-tag mb-3 w-100 text-center" style="background: var(--vibrant-accent); color: var(--vibrant-dark); font-weight: 800;">
                <i class="fa-solid fa-crown me-2"></i> {{ $is_arabic ? 'أفضل كورس' : get_phrase('Top course') }}
            </div>
        @endif

        <div class="d-flex align-items-end gap-2 mb-4">
            @if (isset($course_details->is_paid) && $course_details->is_paid == 0)
                <h2 class="fw-900 text-white mb-0">{{ $is_arabic ? 'مجاني' : get_phrase('Free') }}</h2>
            @elseif (isset($course_details->discount_flag) && $course_details->discount_flag == 1)
                <h2 class="fw-900 text-white mb-0">{{ currency($course_details->discounted_price, 2) }}</h2>
                <del class="text-white opacity-50">{{ currency($course_details->price, 2) }}</del>
                <span class="badge bg-danger rounded-pill px-2 py-1 small">{{ round((($course_details->price - $course_details->discounted_price) / $course_details->price) * 100) }}% {{ $is_arabic ? 'خصم' : 'OFF' }}</span>
            @else
                <h2 class="fw-900 text-white mb-0">{{ currency($course_details->price, 2) }}</h2>
            @endif
        </div>

        @php
            if (isset(auth()->user()->id)) {
                $is_enrolled = DB::table('enrollments')
                    ->where('user_id', auth()->user()->id)
                    ->where('course_id', $course_details->id)
                    ->where(function ($query) {
                        $query->where('expiry_date', '>', now()->timestamp)
                            ->orWhereNull('expiry_date');
                    })
                    ->exists();

                $in_cart = DB::table('cart_items')
                    ->where('user_id', auth()->user()->id)
                    ->where('course_id', $course_details->id)
                    ->exists();

                $in_wishlist = DB::table('wishlists')
                    ->where('user_id', auth()->user()->id)
                    ->where('course_id', $course_details->id)
                    ->exists();

                $pending_course_for_payment = DB::table('offline_payments')
                    ->where('user_id', auth()->user()->id)
                    ->where('status', 0)
                    ->first();

                $pending_course = $pending_course_for_payment ? json_decode($pending_course_for_payment->items, true) : [];
            }
        @endphp

        <div class="d-grid gap-3 mb-4">
            @if (isset(auth()->user()->id))
                @if (in_array($course_details->id, $pending_course))
                    <button disabled class="btn btn-secondary py-3 rounded-pill fw-bold opacity-75">
                        {{ $is_arabic ? 'قيد المراجعة' : get_phrase('In progress') }}
                    </button>
                @else
                    @if ($is_enrolled)
                        <a href="{{ route('my.courses') }}" class="btn-vibrant py-3 rounded-pill fw-bold text-center">
                            {{ $is_arabic ? 'ابدأ التعلم' : get_phrase('Start Now') }}
                        </a>
                    @else
                        <a href="{{ route('purchase.course', $course_details->id) }}" class="btn-vibrant py-3 rounded-pill fw-bold text-center">
                            {{ $is_arabic ? 'اشتر الآن' : get_phrase($course_details->is_paid ? 'Buy Now' : 'Enroll Now') }}
                        </a>

                        @if (isset($course_details->is_paid) && $course_details->is_paid == 1)
                            @if ($in_cart)
                                <a href="{{ route('cart.delete', ['id' => $course_details->id]) }}" class="btn btn-outline-danger py-3 rounded-pill fw-bold">
                                    {{ $is_arabic ? 'حذف من العربة' : get_phrase('Remove from cart') }}
                                </a>
                            @else
                                <a href="{{ route('cart.store', $course_details->id) }}" class="btn btn-outline-vibrant py-3 rounded-pill fw-bold">
                                    {{ $is_arabic ? 'أضف إلى العربة' : get_phrase('Add to cart') }}
                                </a>
                            @endif
                        @endif

                        @if ($in_wishlist)
                            <button class="btn btn-link text-white opacity-50 text-decoration-none fw-bold toggleWishItem" onclick="wishlistToggleButton('{{ $course_details->id }}', this)">
                                <i class="fa-solid fa-heart me-2 text-danger"></i> {{ $is_arabic ? 'حذف من المفضلة' : get_phrase('Remove from wishlist') }}
                            </button>
                        @else
                            <button class="btn btn-link text-white opacity-50 text-decoration-none fw-bold toggleWishItem" onclick="wishlistToggleButton('{{ $course_details->id }}', this)">
                                <i class="fa-regular fa-heart me-2"></i> {{ $is_arabic ? 'أضف للمفضلة' : get_phrase('Add to wishlist') }}
                            </button>
                        @endif
                    @endif
                @endif
            @else
                <a href="{{ route('purchase.course', $course_details->id) }}" class="btn-vibrant py-3 rounded-pill fw-bold text-center">
                    {{ $is_arabic ? 'اشتر الآن' : get_phrase($course_details->is_paid ? 'Buy Now' : 'Enroll Now') }}
                </a>
            @endif
        </div>

        <ul class="list-unstyled mb-0">
            <li class="d-flex justify-content-between align-items-center py-3 border-bottom border-white-10">
                <span class="text-white opacity-50 small"><i class="fa-solid fa-users me-2"></i> {{ $is_arabic ? 'الطلاب' : get_phrase('Students') }}</span>
                <span class="text-white fw-bold">{{ total_enroll($course_details->id) }}</span>
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 border-bottom border-white-10">
                <span class="text-white opacity-50 small"><i class="fa-solid fa-clock me-2"></i> {{ $is_arabic ? 'المدة' : get_phrase('Duration') }}</span>
                <span class="text-white fw-bold">{{ total_durations($course_details->id) }}</span>
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 border-bottom border-white-10">
                <span class="text-white opacity-50 small"><i class="fa-solid fa-layer-group me-2"></i> {{ $is_arabic ? 'المستوى' : get_phrase('Level') }}</span>
                <span class="text-white fw-bold">{{ $is_arabic ? 'متقدم' : $course_details->level }}</span>
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 border-bottom border-white-10">
                <span class="text-white opacity-50 small"><i class="fa-solid fa-certificate me-2"></i> {{ $is_arabic ? 'شهادة' : get_phrase('Certificate') }}</span>
                <span class="text-white fw-bold">{{ $is_arabic ? 'نعم' : 'Yes' }}</span>
            </li>
        </ul>

        @php
            if (isset($user_data['unique_identifier'])):
                $ref = $user_data['unique_identifier'];
            else:
                $ref = '';
            endif;
            $share_url = route('course.details', $course_details->slug);
        @endphp
        <div class="w-100 px-4 pb-2 text-center mt-3">
            <span>{{ get_phrase('Share') }} :</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $share_url }}&ref={{ $ref }}" target="_blank" class="p-2 mx-2 color-facebook" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Facebook') }}" data-bs-placement="top">
                <i class="fab fa-facebook text-20"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ $share_url }}&text={{ $course_details['title'] }}&ref={{ $ref }}" target="_blank" class="p-2 mx-2 color-twitter" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Twitter') }}" data-bs-placement="top">
                <i class="fab fa-twitter text-20"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ $share_url }}&ref={{ $ref }}" target="_blank" class="p-2 mx-2 color-whatsapp" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Whatsapp') }}" data-bs-placement="top">
                <i class="fab fa-whatsapp text-20"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?url={{ $share_url }}&title={{ $course_details['title'] }}&summary={{ $course_details['short_description'] }}&ref={{ $ref }}" target="_blank" class="p-2 mx-2 color-linkedin" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Linkedin') }}" data-bs-placement="top">
                <i class="fab fa-linkedin text-20"></i>
            </a>
        </div>
    </div>
</div>

<script>
    'use strict';

    function wishlistToggleButton(course_id, elem) {
        $.ajax({
            type: "get",
            url: "{{ route('toggleWishItem') }}" + '/' + course_id,
            success: function(response) {
                if (response) {
                    if (response.toggleStatus == 'added') {
                        $(elem).removeClass('learn-btn');
                        $(elem).addClass('gradient');
                        $(elem).html('{{ get_phrase('Remove from wishlist') }}');
                    } else if (response.toggleStatus == 'removed') {
                        $(elem).removeClass('gradient');
                        $(elem).addClass('learn-btn');
                        $(elem).html('{{ get_phrase('Add to wishlist') }}');
                    }
                }
            }
        });
    }
</script>

@include('frontend.default.scripts')
