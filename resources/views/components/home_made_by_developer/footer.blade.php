<footer class="neon-footer">
    @php $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic'; @endphp
    <div class="container pb-5">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="footer-brand mb-5">
                    <a href="{{ route('home') }}">
                        <img src="{{ get_image(get_frontend_settings('light_logo')) }}" class="mb-4" alt="{{ $is_arabic ? 'اللوجو' : get_phrase('Logo') }}" style="max-height: 45px;">
                    </a>
                    <p class="opacity-50 mb-4">{{ $is_arabic ? 'تمكين الجيل القادم من المبدعين والقادة من خلال تعليم عالمي المستوى وتجارب تعليمية حديثة.' : get_phrase('Empowering the next generation of creators and leaders through world-class education and modern learning experiences.') }}</p>
                </div>
                <div class="d-flex gap-4">
                    <a href="{{ get_frontend_settings('facebook') }}" class="text-white opacity-50 hover-opacity-100 fs-5"><i class="fa-brands fa-facebook"></i></a>
                    <a href="{{ get_frontend_settings('twitter') }}" class="text-white opacity-50 hover-opacity-100 fs-5"><i class="fa-brands fa-twitter"></i></a>
                    <a href="{{ get_frontend_settings('linkedin') }}" class="text-white opacity-50 hover-opacity-100 fs-5"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-6">
                <h5 class="footer-title">{{ $is_arabic ? 'المنصة' : get_phrase('Platform') }}</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('courses') }}" class="neon-link">{{ get_phrase('Courses') }}</a></li>
                    <li><a href="{{ route('blogs') }}" class="neon-link">{{ get_phrase('Blog') }}</a></li>
                    <li><a href="{{ route('knowledge.base.topicks') }}" class="neon-link">{{ get_phrase('Knowledge Base') }}</a></li>
                    <li><a href="{{ route('faq') }}" class="neon-link">{{ get_phrase('FAQ') }}</a></li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-6">
                <h5 class="footer-title">{{ $is_arabic ? 'الموارد' : get_phrase('Resources') }}</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about.us') }}" class="neon-link">{{ $is_arabic ? 'حول' : get_phrase('About') }}</a></li>
                    <li><a href="{{ route('contact.us') }}" class="neon-link">{{ $is_arabic ? 'اتصل بنا' : get_phrase('Contact') }}</a></li>
                    <li><a href="{{ route('privacy.policy') }}" class="neon-link">{{ $is_arabic ? 'الخصوصية' : get_phrase('Privacy') }}</a></li>
                    <li><a href="{{ route('terms.condition') }}" class="neon-link">{{ get_phrase('Terms') }}</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4">
                <h5 class="footer-title">{{ $is_arabic ? 'ابق متألقاً' : get_phrase('Stay Vibrant') }}</h5>
                <p class="small opacity-50 mb-4">{{ get_phrase('Join our community to get the latest updates on new courses and creative insights.') }}</p>
                <form action="{{ route('newsletter.store') }}" method="post" class="position-relative">
                    @csrf
                    <input type="email" name="email" class="form-control bg-transparent border-secondary text-white rounded-pill px-4 py-3 shadow-none no-focus-glow" placeholder="{{ $is_arabic ? 'عنوان البريد الإلكتروني' : get_phrase('Email Address') }}" required style="border-width: 2px;">
                    <div class="version-marker" style="position: absolute; bottom: 10px; right: 10px; opacity: 0.2; font-size: 0.7rem;">{{ get_phrase('v2.7-Stable') }}</div>
                    <button class="btn btn-vibrant position-absolute end-0 top-0 h-100 px-4 rounded-pill" type="submit">{{ $is_arabic ? 'انضم' : get_phrase('Join') }}</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container pt-5 border-top border-secondary opacity-25">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
            <p class="small mb-0 opacity-50">© {{ date('Y') }} {{ get_settings('system_name') }}. {{ get_phrase('All Rights Reserved.') }}</p>
            <div class="d-flex gap-4 small opacity-50">
                <span class="text-white">{{ get_phrase('Status: Operational') }}</span>
                <span class="text-white">{{ get_phrase('v2.7-Stable') }}</span>
            </div>
        </div>
    </div>
</footer>

<!-- WhatsApp V2: Pulse & Wave -->
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', get_settings('phone')) }}" class="whatsapp-v2 shadow-lg" target="_blank">
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
        background: rgba(255,255,255,0.05) !important;
    }
</style>