@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';

    if (isset(auth()->user()->id)) {
        $is_enrolled = DB::table('enrollments')
            ->where('user_id', auth()->user()->id)
            ->where('course_id', $course_details->id)
            ->where(function ($query) {
                $query->where('expiry_date', '>', now()->timestamp)
                    ->orWhereNull('expiry_date');
            })
            ->exists();

        $in_wishlist = DB::table('wishlists')
            ->where('user_id', auth()->user()->id)
            ->where('course_id', $course_details->id)
            ->exists();
    }

    $current_price = $course_details->is_paid ? ($course_details->discount_flag ? $course_details->discounted_price : $course_details->price) : 0;
    $wa_msg = ($is_arabic ? 'مرحباً، أريد طلب هذه الدورة:' : 'Hello, I want to order this course:') . "\n";
    $wa_msg .= ($is_arabic ? '*الدورة:* ' : '*Course:* ') . $course_details->title . "\n";
    $wa_msg .= ($is_arabic ? '*السعر:* ' : '*Price:* ') . currency($current_price, 2) . "\n";
    $wa_msg .= ($is_arabic ? '*الرابط:* ' : '*Link:* ') . route('course.details', $course_details->slug);
    $whatsapp_url = 'https://wa.me/41779412126?text=' . urlencode($wa_msg);

    $duration = total_durations($course_details->id);
    if ($duration == '00h 00m' || (int) substr($duration, 0, 2) < 24) {
        $duration = '24h 00m';
    }

    $share_url = route('course.details', $course_details->slug);
@endphp

<style>
    .sba-pricing-card {
        position: relative;
        border-radius: 28px;
        padding: 0;
        overflow: hidden;
        background: linear-gradient(155deg, #1e1b4b 0%, #312e81 55%, #4c1d95 100%);
        box-shadow: 0 35px 70px -25px rgba(15, 23, 42, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .sba-pricing-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 85% -10%, rgba(236, 72, 153, 0.35), transparent 50%),
            radial-gradient(circle at 0% 100%, rgba(14, 165, 233, 0.3), transparent 45%);
        pointer-events: none;
        z-index: 0;
    }

    .sba-pricing-card > * {
        position: relative;
        z-index: 1;
    }

    .sba-pricing-media {
        position: relative;
        margin: 16px 16px 0;
        border-radius: 22px;
        overflow: hidden;
        aspect-ratio: 16 / 10;
        background: #0f172a;
    }

    .sba-pricing-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .sba-pricing-card:hover .sba-pricing-media img {
        transform: scale(1.05);
    }

    .sba-pricing-badge-top {
        position: absolute;
        top: 14px;
        inset-inline-start: 14px;
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #111827;
        font-weight: 900;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 6px 12px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 8px 18px -6px rgba(245, 158, 11, 0.55);
    }

    .sba-pricing-discount-chip {
        position: absolute;
        top: 14px;
        inset-inline-end: 14px;
        background: linear-gradient(135deg, #ef4444, #f97316);
        color: #fff;
        font-weight: 800;
        font-size: 0.78rem;
        padding: 6px 12px;
        border-radius: 999px;
        box-shadow: 0 8px 18px -6px rgba(239, 68, 68, 0.55);
    }

    .sba-pricing-body {
        padding: 24px 24px 26px;
    }

    .sba-pricing-price-row {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 12px;
        margin-bottom: 22px;
    }

    .sba-pricing-price-row .sba-price {
        font-weight: 900;
        color: #fff;
        font-size: 2.5rem;
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .sba-pricing-price-row .sba-price-old {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: line-through;
        font-size: 1rem;
        font-weight: 600;
    }

    .sba-pricing-price-row .sba-save {
        background: rgba(34, 197, 94, 0.15);
        color: #86efac;
        border: 1px solid rgba(34, 197, 94, 0.35);
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.78rem;
        padding: 5px 12px;
    }

    .sba-primary-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
        color: #fff;
        border: none;
        border-radius: 16px;
        padding: 16px 20px;
        font-weight: 800;
        font-size: 1rem;
        text-decoration: none;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 15px 30px -12px rgba(37, 211, 102, 0.6);
    }

    .sba-primary-cta:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 20px 38px -10px rgba(37, 211, 102, 0.7);
    }

    .sba-primary-cta.sba-primary-enrolled {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.6);
    }

    .sba-wishlist-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        margin-top: 12px;
        padding: 12px 18px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.85);
        font-weight: 700;
        font-size: 0.92rem;
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .sba-wishlist-btn:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    .sba-features-grid {
        margin-top: 24px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .sba-feature-chip {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        transition: all 0.3s ease;
    }

    .sba-feature-chip:hover {
        background: rgba(255, 255, 255, 0.09);
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .sba-feature-chip .sba-feature-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        color: #fbbf24;
        font-size: 1rem;
        margin-bottom: 4px;
    }

    .sba-feature-chip .sba-feature-label {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .sba-feature-chip .sba-feature-value {
        color: #fff;
        font-weight: 800;
        font-size: 0.95rem;
    }

    .sba-pricing-support {
        margin-top: 22px;
        padding: 16px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sba-pricing-support .sba-support-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(14, 165, 233, 0.18);
        color: #38bdf8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex: 0 0 auto;
    }

    .sba-pricing-support .sba-support-text {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.85rem;
        line-height: 1.4;
    }

    .sba-pricing-support .sba-support-text a {
        color: #fbbf24;
        font-weight: 700;
        text-decoration: none;
    }

    .sba-share-row {
        margin-top: 22px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        text-align: center;
    }

    .sba-share-row > p {
        color: rgba(255, 255, 255, 0.45);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .sba-share-row .sba-share-icons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .sba-share-row .sba-share-icons a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.07);
        color: rgba(255, 255, 255, 0.75);
        transition: all 0.25s ease;
        text-decoration: none;
    }

    .sba-share-row .sba-share-icons a:hover {
        transform: translateY(-3px);
        color: #fff;
    }

    .sba-share-row .sba-share-icons .fb:hover { background: #1877f2; }
    .sba-share-row .sba-share-icons .tw:hover { background: #1da1f2; }
    .sba-share-row .sba-share-icons .wa:hover { background: #25d366; }
    .sba-share-row .sba-share-icons .in:hover { background: #0a66c2; }
</style>

<div class="sba-pricing-card">
    <div class="sba-pricing-media">
        <img src="{{ get_image($course_details->banner) }}" alt="{{ $course_details->title }}">
        @if ($course_details->is_best)
            <span class="sba-pricing-badge-top">
                <i class="fa-solid fa-crown"></i> {{ $is_arabic ? 'أفضل كورس' : get_phrase('Top course') }}
            </span>
        @endif
        @if (isset($course_details->discount_flag) && $course_details->discount_flag == 1 && $course_details->is_paid)
            <span class="sba-pricing-discount-chip">
                {{ round((($course_details->price - $course_details->discounted_price) / $course_details->price) * 100) }}% {{ $is_arabic ? 'خصم' : 'OFF' }}
            </span>
        @endif
    </div>

    <div class="sba-pricing-body">
        <div class="sba-pricing-price-row">
            @if (isset($course_details->is_paid) && $course_details->is_paid == 0)
                <span class="sba-price">{{ $is_arabic ? 'مجاني' : get_phrase('Free') }}</span>
            @elseif (isset($course_details->discount_flag) && $course_details->discount_flag == 1)
                <span class="sba-price">{{ currency($course_details->discounted_price, 2) }}</span>
                <div class="d-flex flex-column align-items-start gap-1">
                    <span class="sba-price-old">{{ currency($course_details->price, 2) }}</span>
                    <span class="sba-save">
                        <i class="fa-solid fa-tag me-1"></i>
                        {{ $is_arabic ? 'وفّر' : get_phrase('Save') }}
                        {{ currency($course_details->price - $course_details->discounted_price, 2) }}
                    </span>
                </div>
            @else
                <span class="sba-price">{{ currency($course_details->price, 2) }}</span>
            @endif
        </div>

        @if (isset(auth()->user()->id) && $is_enrolled)
            <a href="{{ route('my.courses') }}" class="sba-primary-cta sba-primary-enrolled">
                <i class="fa-solid fa-play"></i>
                {{ $is_arabic ? 'ابدأ التعلم' : get_phrase('Start Now') }}
            </a>
        @else
            @if (is_public_course($course_details->id))
                {{-- Open course: straight into the player, no sign-in needed --}}
                <a href="{{ route('course.player', $course_details->slug) }}" class="sba-primary-cta">
                    <i class="fa-solid fa-play fs-5"></i>
                    {{ $is_arabic ? 'ابدأ الكورس الآن' : 'Start the Course Now' }}
                </a>
                <div class="text-center mt-2" style="font-size: 13px; color: #6b7280;">
                    <i class="fa-solid fa-unlock me-1"></i>
                    {{ $is_arabic ? 'مجاني بالكامل — بدون تسجيل دخول' : 'Completely free — no sign-in required' }}
                </div>
            @elseif (!$course_details->is_paid)
                {{-- Free course: one-click enroll (Google sign-in for guests, instant enrollment) --}}
                <a href="{{ route('enroll.free', $course_details->id) }}" class="sba-primary-cta">
                    <i class="fa-solid fa-graduation-cap fs-5"></i>
                    {{ $is_arabic ? 'سجّل الآن مجانًا' : 'Enroll Now for Free' }}
                </a>
                @guest
                    <div class="text-center mt-2" style="font-size: 13px; color: #6b7280;">
                        <i class="fab fa-google me-1"></i>
                        {{ $is_arabic ? 'تسجيل سريع بحساب جوجل — بدون أي بيانات إضافية' : 'Quick sign-up with Google — no extra details needed' }}
                    </div>
                @endguest
            @else
                <a href="{{ $whatsapp_url }}" target="_blank" rel="noopener" class="sba-primary-cta">
                    <i class="fab fa-whatsapp fs-5"></i>
                    {{ $is_arabic ? 'طلب الدورة الآن' : 'Order Course Now' }}
                </a>
            @endif

            @if (isset(auth()->user()->id))
                @if ($in_wishlist)
                    <button type="button" class="sba-wishlist-btn toggleWishItem"
                        onclick="wishlistToggleButton('{{ $course_details->id }}', this)">
                        <i class="fa-solid fa-heart text-danger"></i>
                        {{ $is_arabic ? 'حذف من المفضلة' : get_phrase('Remove from wishlist') }}
                    </button>
                @else
                    <button type="button" class="sba-wishlist-btn toggleWishItem"
                        onclick="wishlistToggleButton('{{ $course_details->id }}', this)">
                        <i class="fa-regular fa-heart"></i>
                        {{ $is_arabic ? 'أضف للمفضلة' : get_phrase('Add to wishlist') }}
                    </button>
                @endif
            @endif
        @endif

        <div class="sba-features-grid">
            <div class="sba-feature-chip">
                <span class="sba-feature-icon"><i class="fi-rr-unlock"></i></span>
                <span class="sba-feature-label">{{ $is_arabic ? 'الوصول' : get_phrase('Access') }}</span>
                <span class="sba-feature-value">{{ $is_arabic ? 'مدى الحياة' : get_phrase('Lifetime') }}</span>
            </div>
            <div class="sba-feature-chip">
                <span class="sba-feature-icon"><i class="fi-rr-clock"></i></span>
                <span class="sba-feature-label">{{ $is_arabic ? 'المدة' : get_phrase('Duration') }}</span>
                <span class="sba-feature-value">{{ $duration }}</span>
            </div>
            <div class="sba-feature-chip">
                <span class="sba-feature-icon"><i class="fi-rr-chart-pyramid"></i></span>
                <span class="sba-feature-label">{{ $is_arabic ? 'المستوى' : get_phrase('Level') }}</span>
                <span class="sba-feature-value">{{ $is_arabic ? 'مبتدئ' : get_phrase('Beginner') }}</span>
            </div>
            <div class="sba-feature-chip">
                <span class="sba-feature-icon"><i class="fi-rr-diploma"></i></span>
                <span class="sba-feature-label">{{ $is_arabic ? 'شهادة' : get_phrase('Certificate') }}</span>
                <span class="sba-feature-value">{{ $is_arabic ? 'نعم' : get_phrase('Yes') }}</span>
            </div>
        </div>

        <div class="sba-pricing-support">
            <div class="sba-support-icon"><i class="fi-rr-headset"></i></div>
            <div class="sba-support-text">
                {{ $is_arabic ? 'تحتاج مساعدة؟ تواصل مع الدعم الفني:' : get_phrase('Need help? Contact support:') }}<br>
                <a href="mailto:info@swissbridgeacademy.com">info@swissbridgeacademy.com</a>
            </div>
        </div>

        <div class="sba-share-row">
            <p>{{ get_phrase('Share this course') }}</p>
            <div class="sba-share-icons">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $share_url }}" target="_blank" rel="noopener" class="fb" title="{{ get_phrase('Share on Facebook') }}">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ $share_url }}&text={{ $course_details['title'] }}" target="_blank" rel="noopener" class="tw" title="{{ get_phrase('Share on Twitter') }}">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://api.whatsapp.com/send?text={{ $share_url }}" target="_blank" rel="noopener" class="wa" title="{{ get_phrase('Share on Whatsapp') }}">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?url={{ $share_url }}&title={{ $course_details['title'] }}" target="_blank" rel="noopener" class="in" title="{{ get_phrase('Share on Linkedin') }}">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
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
                    if (response.toggleStatus === 'added') {
                        $(elem).html(
                            '<i class="fa-solid fa-heart text-danger"></i> {{ $is_arabic ? 'حذف من المفضلة' : get_phrase('Remove from wishlist') }}'
                        );
                    } else if (response.toggleStatus === 'removed') {
                        $(elem).html(
                            '<i class="fa-regular fa-heart"></i> {{ $is_arabic ? 'أضف للمفضلة' : get_phrase('Add to wishlist') }}'
                        );
                    }
                }
            }
        });
    }
</script>

@include('frontend.default.scripts')

@if (is_public_course($course_details->id))
    {{-- Mobile sticky CTA: the course is open, so keep "start now" one tap away --}}
    <div class="sba-mobile-cta">
        <a href="{{ route('course.player', $course_details->slug) }}">
            <i class="fa-solid fa-play"></i>
            <span>{{ $is_arabic ? 'ابدأ الكورس الآن' : 'Start the Course Now' }}</span>
        </a>
        <small>{{ $is_arabic ? 'مجاني — بدون تسجيل دخول' : 'Free — no sign-in' }}</small>
    </div>

    <style>
        .sba-mobile-cta { display: none; }

        @media (max-width: 991.98px) {
            .sba-mobile-cta {
                display: block;
                position: fixed;
                inset-inline: 0;
                bottom: 0;
                z-index: 1040;
                padding: 10px 14px calc(10px + env(safe-area-inset-bottom));
                background: rgba(255, 255, 255, .97);
                backdrop-filter: blur(8px);
                border-top: 1px solid #e9ecef;
                box-shadow: 0 -6px 20px rgba(0, 0, 0, .10);
                text-align: center;
            }

            .sba-mobile-cta a {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
                min-height: 54px;
                padding: 14px 18px;
                border-radius: 12px;
                background: linear-gradient(135deg, #16a34a, #22c55e);
                color: #fff;
                font-size: 17px;
                font-weight: 700;
                text-decoration: none;
                box-shadow: 0 4px 14px rgba(22, 163, 74, .35);
            }

            .sba-mobile-cta a:active { transform: translateY(1px); }

            .sba-mobile-cta small {
                display: block;
                margin-top: 6px;
                font-size: 12px;
                color: #6b7280;
            }

            /* keep the sticky bar from covering the end of the page */
            body { padding-bottom: 104px; }
        }
    </style>
@endif
