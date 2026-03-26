@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp
<div class="bento-item p-4 shadow-lg border-0 position-relative overflow-hidden" style="border-radius: 40px !important; backdrop-filter: blur(30px); background: rgba(15, 23, 42, 0.6) !important; border: 1px solid rgba(255,255,255,0.08) !important;">
    <div class="position-absolute w-100 h-100 top-0 start-0" style="background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.15), transparent); z-index: 0;"></div>
    
    <div class="position-relative" style="z-index: 1;">
        <div class="hero-details mb-4">
            <div class="position-relative overflow-hidden sba-shadow-premium" style="border-radius: 30px;">
                <img class="w-100" src="{{ get_image($course_details->banner) }}" alt="{{ $course_details->title }}" style="transition: transform 0.5s ease; height: 220px; object-fit: cover;">
            </div>
        </div>

        @if ($course_details->is_best)
            <div class="badge w-100 py-3 mb-4 rounded-pill" style="background: linear-gradient(90deg, #f59e0b, #fbbf24); color: #000; font-weight: 900; letter-spacing: 1px; box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);">
                <i class="fa-solid fa-crown me-2"></i> {{ $is_arabic ? 'أفضل كورس' : get_phrase('Top course') }}
            </div>
        @endif

        <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
            @if (isset($course_details->is_paid) && $course_details->is_paid == 0)
                <h1 class="fw-900 text-white mb-0 display-5">{{ $is_arabic ? 'مجاني' : get_phrase('Free') }}</h1>
            @elseif (isset($course_details->discount_flag) && $course_details->discount_flag == 1)
                <h1 class="fw-900 text-white mb-0 display-5 letter-spacing-tight">{{ currency($course_details->discounted_price, 2) }}</h1>
                <div class="d-flex flex-column">
                    <del class="text-white opacity-40 small">{{ currency($course_details->price, 2) }}</del>
                    <span class="badge bg-danger rounded-pill px-2 py-1 small fw-bold" style="font-size: 0.7rem;">{{ round((($course_details->price - $course_details->discounted_price) / $course_details->price) * 100) }}% {{ $is_arabic ? 'خصم' : 'OFF' }}</span>
                </div>
            @else
                <h1 class="fw-900 text-white mb-0 display-5 letter-spacing-tight">{{ currency($course_details->price, 2) }}</h1>
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

        @php
            $current_price = $course_details->is_paid ? ($course_details->discount_flag ? $course_details->discounted_price : $course_details->price) : 0;
            $wa_msg = ($is_arabic ? 'مرحباً، أريد طلب هذه الدورة:' : 'Hello, I want to order this course:') . "\n";
            $wa_msg .= ($is_arabic ? '*الدورة:* ' : '*Course:* ') . $course_details->title . "\n";
            $wa_msg .= ($is_arabic ? '*السعر:* ' : '*Price:* ') . currency($current_price, 2) . "\n";
            $wa_msg .= ($is_arabic ? '*الرابط:* ' : '*Link:* ') . route('course.details', $course_details->slug);
            $whatsapp_url = "https://wa.me/41779412126?text=" . urlencode($wa_msg);
        @endphp

        <div class="d-grid gap-3 mb-4">
            @if (isset(auth()->user()->id) && $is_enrolled)
                <a href="{{ route('my.courses') }}" class="btn-sba-primary py-3 rounded-pill fw-bold text-center">
                    {{ $is_arabic ? 'ابدأ التعلم' : get_phrase('Start Now') }}
                </a>
            @else
                <a href="{{ $whatsapp_url }}" target="_blank" class="btn-sba-primary py-3 rounded-pill fw-bold text-center" style="background: linear-gradient(135deg, #25d366, #128c7e) !important; border:none; box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);">
                    <i class="fab fa-whatsapp me-2"></i> {{ $is_arabic ? 'طلب الدورة الآن' : 'Order Course Now' }}
                </a>
                
                @if (isset(auth()->user()->id))
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
        </div>

        <ul class="list-unstyled mb-0">
            <li class="d-flex justify-content-between align-items-center py-3 border-bottom border-white-10">
                <span class="text-white opacity-60 small d-flex align-items-center gap-2"><i class="fi-rr-unlock text-sba-accent"></i> {{ $is_arabic ? 'الوصول' : get_phrase('Access') }}</span>
                <span class="text-white fw-800">{{ $is_arabic ? 'مدى الحياة' : get_phrase('Lifetime') }}</span>
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 border-bottom border-white-10">
                <span class="text-white opacity-60 small d-flex align-items-center gap-2"><i class="fi-rr-clock text-sba-accent"></i> {{ $is_arabic ? 'المدة' : get_phrase('Duration') }}</span>
                @php
                    $duration = total_durations($course_details->id);
                    if ($duration == '00h 00m' || (int) substr($duration, 0, 2) < 24) {
                        $duration = '24h 00m';
                    }
                @endphp
                <span class="text-white fw-800">{{ $duration }}</span>
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 border-bottom border-white-10">
                <span class="text-white opacity-60 small d-flex align-items-center gap-2"><i class="fi-rr-chart-pyramid text-sba-accent"></i> {{ $is_arabic ? 'المستوى' : get_phrase('Level') }}</span>
                <span class="text-white fw-800">{{ $is_arabic ? 'مبتدئ' : 'Beginner' }}</span>
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 border-bottom border-white-10">
                <span class="text-white opacity-60 small d-flex align-items-center gap-2"><i class="fi-rr-diploma text-sba-accent"></i> {{ $is_arabic ? 'شهادة' : get_phrase('Certificate') }}</span>
                <span class="text-white fw-800">{{ $is_arabic ? 'نعم' : 'Yes' }}</span>
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
        <div class="w-100 px-2 pb-2 text-center mt-4 pt-3 border-top border-white-10">
            <p class="text-white opacity-40 small mb-3 text-uppercase letter-spacing-1 fw-bold">{{ get_phrase('Share this course') }}</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $share_url }}&ref={{ $ref }}" target="_blank" class="share-icon-sba fb" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Facebook') }}">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ $share_url }}&text={{ $course_details['title'] }}&ref={{ $ref }}" target="_blank" class="share-icon-sba tw" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Twitter') }}">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://api.whatsapp.com/send?text={{ $share_url }}&ref={{ $ref }}" target="_blank" class="share-icon-sba wa" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Whatsapp') }}">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?url={{ $share_url }}&title={{ $course_details['title'] }}&summary={{ $course_details['short_description'] }}&ref={{ $ref }}" target="_blank" class="share-icon-sba in" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Linkedin') }}">
                    <i class="fab fa-linkedin-in"></i>
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
