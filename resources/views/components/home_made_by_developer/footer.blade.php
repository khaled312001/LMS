@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp

<style>
    /* === Swiss Bridge footer === */
    .sba-footer {
        position: relative;
        margin-top: 80px;
        background: linear-gradient(165deg, #050918 0%, #0c1230 45%, #080d1f 100%);
        color: #b0bec5;
        overflow: hidden;
        isolation: isolate;
    }

    .sba-footer::before,
    .sba-footer::after {
        content: '';
        position: absolute;
        pointer-events: none;
        border-radius: 50%;
        filter: blur(40px);
        z-index: 0;
    }

    .sba-footer::before {
        width: 600px;
        height: 600px;
        top: -220px;
        inset-inline-start: -180px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, transparent 70%);
        animation: sba-float-1 22s ease-in-out infinite;
    }

    .sba-footer::after {
        width: 500px;
        height: 500px;
        bottom: -180px;
        inset-inline-end: -140px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.18) 0%, transparent 70%);
        animation: sba-float-2 26s ease-in-out infinite;
    }

    @keyframes sba-float-1 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(50px, 40px); }
    }

    @keyframes sba-float-2 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-40px, -30px); }
    }

    .sba-footer-top-bar {
        height: 3px;
        background: linear-gradient(90deg, transparent, #4f46e5 25%, #06b6d4 50%, #7e22ce 75%, transparent);
        background-size: 200% 100%;
        animation: sba-shimmer 8s linear infinite;
    }

    @keyframes sba-shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .sba-footer-inner {
        position: relative;
        z-index: 1;
        max-width: 1320px;
        margin: 0 auto;
        padding: 72px 24px 40px;
    }

    .sba-footer-grid {
        display: grid;
        grid-template-columns: 1.3fr 0.9fr 0.9fr 1.3fr;
        gap: 46px;
    }

    @media (max-width: 992px) {
        .sba-footer-grid { grid-template-columns: repeat(2, 1fr); gap: 40px; }
    }

    @media (max-width: 560px) {
        .sba-footer-grid { grid-template-columns: 1fr; gap: 36px; }
        .sba-footer-inner { padding: 56px 20px 32px; }
    }

    /* --- Column 1: Brand --- */
    .sba-brand-col .sba-logo {
        display: inline-block;
        margin-bottom: 20px;
        transition: transform 0.4s ease;
    }
    .sba-brand-col .sba-logo:hover { transform: translateY(-3px); }
    .sba-brand-col .sba-logo img { max-height: 54px; }

    .sba-brand-col .sba-about {
        color: #b0bec5;
        font-size: 0.93rem;
        line-height: 1.8;
        margin-bottom: 24px;
    }

    .sba-contact-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        color: #9db8d2;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all .28s ease;
    }

    .sba-contact-row:hover {
        color: #fff;
        padding-inline-start: 4px;
    }

    .sba-contact-ico {
        flex: 0 0 auto;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #818cf8;
        transition: all .28s ease;
    }

    .sba-contact-row:hover .sba-contact-ico {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-color: transparent;
        color: #fff;
        transform: rotate(-8deg) scale(1.08);
    }

    .sba-socials {
        margin-top: 24px;
        display: flex;
        gap: 12px;
    }

    .sba-social {
        position: relative;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.14);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #c9d6e3;
        font-size: 1.05rem;
        text-decoration: none;
        transition: all .35s cubic-bezier(.175,.885,.32,1.275);
        overflow: hidden;
    }

    .sba-social::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        opacity: 0;
        transition: opacity .3s ease;
    }

    .sba-social.fb::before { background: #1877f2; }
    .sba-social.ig::before { background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
    .sba-social.wa::before { background: linear-gradient(135deg, #25d366, #128c7e); }

    .sba-social:hover {
        transform: translateY(-5px) scale(1.08);
        color: #fff;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
        border-color: transparent;
    }

    .sba-social:hover::before { opacity: 1; }

    .sba-social > i { position: relative; z-index: 1; }

    /* --- Column 2/3: Link list --- */
    .sba-footer-col h6 {
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 0.72rem;
        font-weight: 800;
        margin-bottom: 26px;
        position: relative;
        padding-bottom: 14px;
    }

    .sba-footer-col h6::after {
        content: '';
        position: absolute;
        bottom: 0;
        inset-inline-start: 0;
        width: 36px;
        height: 2px;
        border-radius: 2px;
        background: linear-gradient(90deg, #4f46e5, #06b6d4);
    }

    .sba-footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sba-footer-links li { margin-bottom: 14px; }

    .sba-footer-links a {
        color: #9db8d2;
        text-decoration: none;
        font-size: 0.92rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: color .25s, gap .25s, transform .25s;
    }

    .sba-footer-links a .sba-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        flex-shrink: 0;
        opacity: 0.75;
        transition: all .25s ease;
    }

    .sba-footer-links a:hover {
        color: #fff;
        gap: 14px;
    }

    .sba-footer-links a:hover .sba-dot {
        opacity: 1;
        transform: scale(1.6);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
    }

    /* --- Column 4: Stats + Newsletter --- */
    .sba-stats-strip {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .sba-stat-box {
        flex: 1;
        padding: 14px 8px;
        text-align: center;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        transition: transform .3s ease, background .3s ease;
    }

    .sba-stat-box:hover {
        transform: translateY(-4px);
        background: rgba(255, 255, 255, 0.12);
    }

    .sba-stat-num {
        font-size: 1.2rem;
        font-weight: 900;
        line-height: 1.2;
    }

    .sba-stat-box.c1 .sba-stat-num { color: #818cf8; }
    .sba-stat-box.c2 .sba-stat-num { color: #34d399; }
    .sba-stat-box.c3 .sba-stat-num { color: #22d3ee; }

    .sba-stat-box .sba-stat-label {
        font-size: 0.68rem;
        color: #8fb3cc;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 4px;
    }

    .sba-newsletter-text {
        color: #9db8d2;
        font-size: 0.9rem;
        line-height: 1.7;
        margin-bottom: 18px;
    }

    .sba-newsletter-form {
        position: relative;
    }

    .sba-newsletter-form input {
        width: 100%;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 100px;
        color: #e8eef4;
        padding: 15px 22px;
        padding-inline-{{ $is_arabic ? 'start' : 'end' }}: 140px;
        font-size: 0.9rem;
        outline: none;
        transition: border-color .3s, box-shadow .3s;
    }

    .sba-newsletter-form input::placeholder { color: #7f93a6; }

    .sba-newsletter-form input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .sba-newsletter-form button {
        position: absolute;
        top: 6px;
        inset-inline-{{ $is_arabic ? 'start' : 'end' }}: 6px;
        background: linear-gradient(135deg, #4f46e5, #7e22ce);
        color: #fff;
        border: none;
        border-radius: 100px;
        padding: 10px 24px;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform .2s, box-shadow .25s;
    }

    .sba-newsletter-form button:hover {
        transform: scale(1.04);
        box-shadow: 0 8px 18px -6px rgba(79, 70, 229, 0.55);
    }

    /* --- Bottom bar --- */
    .sba-footer-bottom {
        position: relative;
        z-index: 1;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding: 20px 24px;
    }

    .sba-footer-bottom-inner {
        max-width: 1320px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        font-size: 0.82rem;
        color: #8aa4bc;
    }

    .sba-footer-bottom-inner .brand-name {
        color: #818cf8;
        font-weight: 700;
    }

    .sba-made-with {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .sba-made-with .sba-pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        animation: sba-pulse 1.8s ease-in-out infinite;
    }

    @keyframes sba-pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.6); }
        50%      { transform: scale(1.2); box-shadow: 0 0 0 6px rgba(99, 102, 241, 0); }
    }

    /* WhatsApp floating */
    .sba-wa {
        position: fixed;
        bottom: 32px;
        inset-inline-end: 32px;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #25d366, #128c7e);
        color: #fff;
        font-size: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        text-decoration: none;
        box-shadow: 0 10px 30px rgba(37, 211, 102, 0.45);
        transition: transform .3s cubic-bezier(.175,.885,.32,1.275);
    }

    .sba-wa:hover {
        transform: scale(1.12) rotate(-8deg);
        color: #fff;
    }

    .sba-wa::before,
    .sba-wa::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: rgba(37, 211, 102, 0.5);
        animation: sba-wa-ping 2s cubic-bezier(0, 0, .2, 1) infinite;
        z-index: -1;
    }

    .sba-wa::after {
        background: rgba(37, 211, 102, 0.3);
        animation-delay: 1s;
    }

    @keyframes sba-wa-ping {
        75%, 100% { transform: scale(2.1); opacity: 0; }
    }

    /* Reveal-on-scroll */
    .sba-reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity .8s ease, transform .8s ease;
    }

    .sba-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<footer class="sba-footer">
    <div class="sba-footer-top-bar"></div>

    <div class="sba-footer-inner">
        <div class="sba-footer-grid">
            {{-- Brand column --}}
            <div class="sba-brand-col sba-reveal">
                <a href="{{ route('home') }}" class="sba-logo">
                    <img src="{{ get_image(get_frontend_settings('light_logo')) }}" alt="Swiss Bridge Academy">
                </a>
                <p class="sba-about">
                    {{ $is_arabic
                        ? 'منصة تعليمية تُدار من سويسرا، تقدّم برامج عملية وحديثة في البرمجة، تطوير التطبيقات، الذكاء الاصطناعي، التسويق، التصميم، والمبيعات، عن بُعد أو حضوريًا من داخل المركز.'
                        : get_phrase('An educational platform managed from Switzerland, offering practical and modern programs in programming, app development, AI, marketing, design, and sales.') }}
                </p>

                <div>
                    <div class="sba-contact-row">
                        <span class="sba-contact-ico"><i class="fa-solid fa-location-dot"></i></span>
                        <span>Swiss Bridge Academy | Zürich, Switzerland</span>
                    </div>
                    <a href="https://wa.me/41779412126" target="_blank" class="sba-contact-row">
                        <span class="sba-contact-ico"><i class="fa-brands fa-whatsapp"></i></span>
                        <span>+41 77 941 21 26</span>
                    </a>
                    <a href="mailto:info@swissbridgeacademy.com" class="sba-contact-row">
                        <span class="sba-contact-ico"><i class="fa-solid fa-envelope"></i></span>
                        <span>info@swissbridgeacademy.com</span>
                    </a>
                </div>

                <div class="sba-socials">
                    <a href="https://www.facebook.com/61578503481427/" target="_blank" rel="noopener" aria-label="Facebook" class="sba-social fb">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/swiss_bridgeacademy/" target="_blank" rel="noopener" aria-label="Instagram" class="sba-social ig">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://wa.me/41779412126" target="_blank" rel="noopener" aria-label="WhatsApp" class="sba-social wa">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            {{-- Platform column --}}
            <div class="sba-footer-col sba-reveal">
                <h6>{{ $is_arabic ? 'المنصة' : get_phrase('Platform') }}</h6>
                <ul class="sba-footer-links">
                    <li><a href="{{ route('courses') }}"><span class="sba-dot"></span>{{ $is_arabic ? 'الدورات' : get_phrase('Courses') }}</a></li>
                    <li><a href="{{ route('blogs') }}"><span class="sba-dot"></span>{{ $is_arabic ? 'المدونة' : get_phrase('Blog') }}</a></li>
                    <li><a href="{{ route('login') }}"><span class="sba-dot"></span>{{ $is_arabic ? 'تسجيل الدخول' : get_phrase('Login') }}</a></li>
                    <li><a href="{{ route('register.form') }}"><span class="sba-dot"></span>{{ $is_arabic ? 'إنشاء حساب' : get_phrase('Sign Up') }}</a></li>
                </ul>
            </div>

            {{-- Resources column --}}
            <div class="sba-footer-col sba-reveal">
                <h6>{{ $is_arabic ? 'الموارد' : get_phrase('Resources') }}</h6>
                <ul class="sba-footer-links">
                    <li><a href="{{ route('about.us') }}"><span class="sba-dot"></span>{{ $is_arabic ? 'حول' : get_phrase('About') }}</a></li>
                    <li><a href="{{ route('contact.us') }}"><span class="sba-dot"></span>{{ $is_arabic ? 'اتصل بنا' : get_phrase('Contact') }}</a></li>
                    <li><a href="{{ route('privacy.policy') }}"><span class="sba-dot"></span>{{ $is_arabic ? 'الخصوصية' : get_phrase('Privacy') }}</a></li>
                    <li><a href="{{ route('terms.condition') }}"><span class="sba-dot"></span>{{ $is_arabic ? 'الشروط' : get_phrase('Terms') }}</a></li>
                </ul>
            </div>

            {{-- Newsletter column --}}
            <div class="sba-footer-col sba-reveal">
                <h6>{{ $is_arabic ? 'ابق متألقاً' : get_phrase('Stay Vibrant') }}</h6>

                <div class="sba-stats-strip">
                    <div class="sba-stat-box c1">
                        <div class="sba-stat-num">12K+</div>
                        <div class="sba-stat-label">{{ $is_arabic ? 'طلاب' : get_phrase('Students') }}</div>
                    </div>
                    <div class="sba-stat-box c2">
                        <div class="sba-stat-num">98%</div>
                        <div class="sba-stat-label">{{ $is_arabic ? 'نجاح' : get_phrase('Success') }}</div>
                    </div>
                    <div class="sba-stat-box c3">
                        <div class="sba-stat-num">120+</div>
                        <div class="sba-stat-label">{{ $is_arabic ? 'دورة' : get_phrase('Courses') }}</div>
                    </div>
                </div>

                <p class="sba-newsletter-text">
                    {{ $is_arabic
                        ? 'انضم إلى مجتمعنا للحصول على آخر التحديثات حول الدورات والأفكار الإبداعية.'
                        : get_phrase('Join our community to get the latest updates on new courses and creative insights.') }}
                </p>

                <form action="{{ route('newsletter.store') }}" method="post" class="sba-newsletter-form">
                    @csrf
                    <input type="email" name="email" required
                        placeholder="{{ $is_arabic ? 'عنوان البريد الإلكتروني' : get_phrase('Email Address') }}">
                    <button type="submit">
                        {{ $is_arabic ? 'انضم' : get_phrase('Join') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="sba-footer-bottom">
        <div class="sba-footer-bottom-inner">
            <p style="margin: 0;">
                © {{ date('Y') }}
                <span class="brand-name">{{ get_settings('system_name') }}</span>.
                {{ $is_arabic ? 'جميع الحقوق محفوظة.' : get_phrase('All Rights Reserved.') }}
            </p>
            <div class="sba-made-with">
                <span class="sba-pulse-dot"></span>
                {{ $is_arabic ? 'صُنع بـ ❤ لأجل التعلّم' : 'Made with ❤ for learning' }}
            </div>
        </div>
    </div>
</footer>

<a href="https://wa.me/41779412126" target="_blank" aria-label="WhatsApp" class="sba-wa">
    <i class="fa-brands fa-whatsapp"></i>
</a>

<script>
    (function () {
        // Reveal animations
        const io = ('IntersectionObserver' in window) ? new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 }) : null;

        document.querySelectorAll('.sba-reveal').forEach((el, i) => {
            el.style.transitionDelay = (i * 0.08) + 's';
            if (io) io.observe(el);
            else el.classList.add('is-visible');
        });
    })();
</script>
