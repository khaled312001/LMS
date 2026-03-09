<footer class="neon-footer">
    <div class="neon-footer-top-border"></div>
    @php $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic'; @endphp
    <div class="container pb-5">
        <div class="row g-5">
            {{-- Brand --}}
            <div class="col-lg-4">
                <div class="footer-brand mb-4">
                    <a href="{{ route('home') }}">
                        <img src="{{ get_image(get_frontend_settings('light_logo')) }}" class="mb-4" alt="{{ $is_arabic ? 'اللوجو' : get_phrase('Logo') }}" style="max-height: 48px;">
                    </a>
                    <p class="mb-4">{{ $is_arabic ? 'تمكين الجيل القادم من المبدعين والقادة من خلال تعليم عالمي المستوى وتجارب تعليمية حديثة.' : get_phrase('Empowering the next generation of creators and leaders through world-class education and modern learning experiences.') }}</p>
                </div>
                <div class="d-flex gap-3">
                    <a href="{{ get_frontend_settings('facebook') }}" class="footer-social-icon" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ get_frontend_settings('twitter') }}" class="footer-social-icon" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="{{ get_frontend_settings('linkedin') }}" class="footer-social-icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            {{-- Platform --}}
            <div class="col-lg-2 col-6">
                <h5 class="footer-title">{{ $is_arabic ? 'المنصة' : get_phrase('Platform') }}</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('courses') }}" class="neon-link">{{ $is_arabic ? 'الدورات' : get_phrase('Courses') }}</a></li>
                    <li><a href="{{ route('blogs') }}" class="neon-link">{{ $is_arabic ? 'المدونة' : get_phrase('Blog') }}</a></li>
                    <li><a href="{{ route('knowledge.base.topicks') }}" class="neon-link">{{ $is_arabic ? 'قاعدة المعرفة' : get_phrase('Knowledge Base') }}</a></li>
                    <li><a href="{{ route('faq') }}" class="neon-link">{{ $is_arabic ? 'الأسئلة الشائعة' : get_phrase('FAQ') }}</a></li>
                </ul>
            </div>

            {{-- Resources --}}
            <div class="col-lg-2 col-6">
                <h5 class="footer-title">{{ $is_arabic ? 'الموارد' : get_phrase('Resources') }}</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('about.us') }}" class="neon-link">{{ $is_arabic ? 'حول' : get_phrase('About') }}</a></li>
                    <li><a href="{{ route('contact.us') }}" class="neon-link">{{ $is_arabic ? 'اتصل بنا' : get_phrase('Contact') }}</a></li>
                    <li><a href="{{ route('privacy.policy') }}" class="neon-link">{{ $is_arabic ? 'الخصوصية' : get_phrase('Privacy') }}</a></li>
                    <li><a href="{{ route('terms.condition') }}" class="neon-link">{{ $is_arabic ? 'الشروط' : get_phrase('Terms') }}</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div class="col-lg-4">
                <h5 class="footer-title">{{ $is_arabic ? 'ابق متألقاً' : get_phrase('Stay Vibrant') }}</h5>
                <p class="small mb-4" style="color:#64748b; line-height:1.75;">{{ $is_arabic ? 'انضم إلى مجتمعنا للحصول على آخر التحديثات حول الدورات والأفكار الإبداعية.' : get_phrase('Join our community to get the latest updates on new courses and creative insights.') }}</p>
                <form action="{{ route('newsletter.store') }}" method="post" class="position-relative">
                    @csrf
                    <input type="email" name="email" class="form-control rounded-pill px-4 py-3 shadow-none no-focus-glow" placeholder="{{ $is_arabic ? 'عنوان البريد الإلكتروني' : get_phrase('Email Address') }}" aria-label="{{ $is_arabic ? 'عنوان البريد الإلكتروني' : get_phrase('Email Address') }}" required style="border-width: 1px; padding-right: 120px !important;">
                    <button class="btn btn-vibrant position-absolute end-0 top-0 h-100 px-4 rounded-pill fw-600" type="submit" style="font-size:0.88rem;">{{ $is_arabic ? 'انضم' : get_phrase('Join') }}</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <div class="neon-footer-divider mx-4"></div>

    {{-- Bottom bar --}}
    <div class="container neon-footer-bottom">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <p class="mb-0" style="color:#334155;">© {{ date('Y') }} {{ get_settings('system_name') }}. {{ get_phrase('All Rights Reserved.') }}</p>
            <p class="mb-0" style="color:#1e293b; font-size:0.8rem;">{{ $is_arabic ? 'صُنع بـ ❤ لأجل التعلّم' : 'Made with ❤ for learning' }}</p>
        </div>
    </div>
</footer>

<!-- WhatsApp V2: Pulse & Wave -->
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', get_settings('phone')) }}" class="whatsapp-v2 shadow-lg" target="_blank" aria-label="Chat with us on WhatsApp">
    <div class="whatsapp-wave"></div>
    <div class="whatsapp-wave delay-1"></div>
    <i class="fa-brands fa-whatsapp"></i>
</a>

<style>
    .whatsapp-v2 {
        position: fixed;
        bottom: 40px;
        right: 40px;
        width: 70px;
        height: 70px;
        background: #25d366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 32px;
        z-index: 1000;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .whatsapp-v2:hover {
        transform: scale(1.1) rotate(10deg);
        color: #fff;
    }

    .whatsapp-wave {
        position: absolute;
        width: 100%;
        height: 100%;
        background: #25d366;
        border-radius: 50%;
        opacity: 0.5;
        z-index: -1;
        animation: whatsapp-ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    .whatsapp-wave.delay-1 { animation-delay: 1s; }

    @keyframes whatsapp-ping {
        75%, 100% {
            transform: scale(2.2);
            opacity: 0;
        }
    }

    .no-focus-glow:focus {
        border-color: var(--vibrant-primary) !important;
        background: rgba(255,255,255,0.07) !important;
    }

    /* RTL adjustments */
    [dir="rtl"] .neon-footer .footer-title::after {
        left: auto;
        right: 0;
    }
    [dir="rtl"] .neon-link::before {
        display: none;
    }
    [dir="rtl"] .neon-link:hover {
        padding-left: 0 !important;
        padding-right: 4px !important;
    }
</style>
