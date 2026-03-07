<footer class="professional-footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="footer-brand mb-4">
                    <a href="{{ route('home') }}">
                        <img src="{{ get_image(get_frontend_settings('light_logo')) }}" alt="Logo" style="max-height: 60px;" class="mb-4">
                    </a>
                    <p class="mb-4 lh-lg" style="max-width: 320px;">{{ get_phrase('Experience excellence in learning with our world-class academy. We provide expert-led courses designed to help you master new skills and achieve your goals.') }}</p>
                    <div class="social-links d-flex gap-3">
                         <a href="{{ get_frontend_settings('facebook') }}" class="btn btn-outline-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; transition: all 0.3s ease;"><i class="fa-brands fa-facebook-f"></i></a>
                         <a href="{{ get_frontend_settings('twitter') }}" class="btn btn-outline-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; transition: all 0.3s ease;"><i class="fa-brands fa-twitter"></i></a>
                         <a href="{{ get_frontend_settings('linkedin') }}" class="btn btn-outline-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; transition: all 0.3s ease;"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-title">{{ get_phrase('Learning') }}</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('courses') }}" class="footer-link">{{ get_phrase('All Courses') }}</a></li>
                    <li><a href="{{ route('blogs') }}" class="footer-link">{{ get_phrase('Reading Blog') }}</a></li>
                    <li><a href="{{ route('knowledge.base.topicks') }}" class="footer-link">{{ get_phrase('Knowledge Base') }}</a></li>
                    <li><a href="{{ route('faq') }}" class="footer-link">{{ get_phrase('FAQ') }}</a></li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-title">{{ get_phrase('Company') }}</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about.us') }}" class="footer-link">{{ get_phrase('About Us') }}</a></li>
                    <li><a href="{{ route('contact.us') }}" class="footer-link">{{ get_phrase('Contact with Us') }}</a></li>
                    <li><a href="{{ route('privacy.policy') }}" class="footer-link">{{ get_phrase('Privacy Policy') }}</a></li>
                    <li><a href="{{ route('terms.condition') }}" class="footer-link">{{ get_phrase('Terms And Use') }}</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4">
                <h5 class="footer-title">{{ get_phrase('Newsletter') }}</h5>
                <p class="small mb-4 opacity-75">{{ get_phrase('Subscribe to our newsletter and stay updated with the latest courses and features.') }}</p>
                <form action="{{ route('newsletter.store') }}" method="post" id="professional-newsletter">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" class="form-control bg-dark border-secondary text-white rounded-start-pill px-4 shadow-none" placeholder="{{ get_phrase('Enter your email') }}" required style="height: 54px;">
                        <button class="btn btn-primary rounded-end-pill px-4 fw-bold shadow-none" type="submit">{{ get_phrase('Subscribe') }}</button>
                    </div>
                </form>
                <div class="contact-details mt-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle p-2 me-3"><i class="fa-solid fa-phone text-white tiny"></i></div>
                        <div>
                             <small class="d-block opacity-50">{{ get_phrase('Call Us') }}</small>
                             <span class="fw-bold text-white">{{ get_settings('phone') }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-2 me-3"><i class="fa-solid fa-envelope text-white tiny"></i></div>
                        <div>
                             <small class="d-block opacity-50">{{ get_phrase('Email Address') }}</small>
                             <span class="fw-bold text-white">{{ get_settings('system_email') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="my-5 border-secondary opacity-10">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="small mb-0 opacity-50">© {{ date('Y') }} {{ get_settings('system_name') }}. {{ get_phrase('All Rights Reserved.') }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="small mb-0 opacity-50">{{ get_phrase('Designed with Excellence') }}</p>
            </div>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', get_settings('phone')) }}" class="whatsapp-float pulse shadow-lg" target="_blank" data-bs-toggle="tooltip" title="{{ get_phrase('Chat with us') }}">
    <i class="fa-brands fa-whatsapp"></i>
</a>