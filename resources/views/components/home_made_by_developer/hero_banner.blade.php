{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<section class="banner-wraper mt-0 mt-md-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 order-2 order-md-1">
                <div class="banner-content">
                    <h5 class="d-flex align-items-center mb-3"><img class="builder-editable me-2" builder-identity="1" src="{{asset('assets/page-builder/block-image/roket.svg')}}" alt="..." style="width: 24px; height: 24px;"> <span class="builder-editable fw-bold text-primary" builder-identity="2">{{ get_phrase('Welcome to Our Learning Platform')}}</span></h5>
                    <h1 class="display-4 fw-bolder mb-4" style="line-height: 1.2;">
                        <span class="builder-editable d-block mb-2" builder-identity="3">{{ get_phrase("Swiss Quality Standards")}}</span>
                        <span class="gradient color shadow-none builder-editable" builder-identity="4">{{ get_phrase('Interactive Modern Content')}}</span>
                    </h1>
                    <p class="builder-editable text-muted mb-4 fs-5" builder-identity="5">{{ get_phrase('Welcome Platform Description')}}</p>
                    <div class="banner-btn d-flex gap-3 mt-4">
                        <a href="{{ route('courses') }}" class="eBtn gradient builder-editable px-5 py-3 rounded-pill fw-bold shadow-sm" builder-identity="6">{{ get_phrase('Get Started') }}</a>
                        <a data-bs-toggle="modal" data-bs-target="#promoVideo" href="#" class="eBtn learn-btn px-4 py-3 rounded-pill d-flex align-items-center gap-2"><i class="fa-solid fa-play"></i>{{ get_phrase('Learn More') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-md-6 order-1 order-md-2 mb-5 mb-md-0">
                <div class="banner-image text-center">
                    <img class="img-fluid rounded-4 shadow-lg builder-editable" src="{{ asset(get_frontend_settings('banner_image')) }}" alt="banner-image" builder-identity="7" style="max-height: 500px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Vertically centered modal -->
<div class="modal fade-in-effect" id="promoVideo" tabindex="-1" aria-labelledby="promoVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body bg-dark">
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var xhr = new XMLHttpRequest();
        var url = "{{ route('view', ['path' => 'components.home_ajax_loaded_templates.promo_video']) }}";

        xhr.open("GET", url, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                $('#promoVideo .modal-body').html(xhr.responseText);
            }
        };

        xhr.send();
    })();

    function scrollToSmoothly(pos, time) {
        if (isNaN(pos)) {
            throw "Position must be a number";
        }
        if (pos < 0) {
            throw "Position can not be negative";
        }
        var currentPos = window.scrollY || window.screenTop;
        if (currentPos < pos) {
            var t = 10;
            for (let i = currentPos; i <= pos; i += 10) {
                t += 10;
                setTimeout(function() {
                    window.scrollTo(0, i);
                }, t / 2);
            }
        } else {
            time = time || 2;
            var i = currentPos;
            var x;
            x = setInterval(function() {
                window.scrollTo(0, i);
                i -= 10;
                if (i <= pos) {
                    clearInterval(x);
                }
            }, time);
        }
    }
</script>