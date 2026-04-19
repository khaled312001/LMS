@php $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic'; @endphp

<footer style="background:linear-gradient(170deg,#050918 0%,#0c1230 45%,#080d1f 100%);position:relative;overflow:hidden;margin-top:60px;">

    {{-- Decorative blobs --}}
    <div style="position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(79,70,229,0.15) 0%,transparent 70%);top:-200px;left:-150px;pointer-events:none;"></div>
    <div style="position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(6,182,212,0.12) 0%,transparent 70%);bottom:-150px;right:-100px;pointer-events:none;"></div>

    {{-- Top gradient bar --}}
    <div style="height:3px;background:linear-gradient(90deg,transparent,#4f46e5 25%,#06b6d4 50%,#7e22ce 75%,transparent);"></div>

    <div class="container" style="padding-top:80px;padding-bottom:60px;position:relative;z-index:1;">
        <div class="row g-5">

            {{-- Col 1: Brand --}}
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="d-inline-block mb-4">
                    <img src="{{ get_image(get_frontend_settings('light_logo')) }}" alt="Logo" style="max-height:50px;">
                </a>
                <p style="color:#b0bec5;font-size:0.93rem;line-height:1.85;margin-bottom:20px;">
                    {{ $is_arabic
                        ? 'منصة تعليمية تُدار من سويسرا، تقدّم برامج عملية وحديثة في البرمجة، تطوير التطبيقات، الذكاء الاصطناعي، التسويق، التصميم، والمبيعات، عن بُعد أو حضوريًا من داخل المركز.'
                        : get_phrase('An educational platform managed from Switzerland, offering practical and modern programs in programming, app development, AI, marketing, design, and sales.') }}
                </p>
                <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px;">
                    <i class="fa-solid fa-location-dot" style="color:#818cf8;margin-top:3px;"></i>
                    <span style="color:#9db8d2;font-size:0.88rem;">Swiss Bridge Academy | Zürich, Switzerland</span>
                </div>
                <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px;">
                    <i class="fa-brands fa-whatsapp" style="color:#25d366;margin-top:3px;"></i>
                    <a href="https://wa.me/41779412126" target="_blank" style="color:#9db8d2;font-size:0.88rem;text-decoration:none;transition:color .25s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#9db8d2'">+41 77 941 21 26</a>
                </div>
                <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:20px;">
                    <i class="fa-solid fa-envelope" style="color:#818cf8;margin-top:3px;"></i>
                    <a href="mailto:info@swissbridgeacademy.com" style="color:#9db8d2;font-size:0.88rem;text-decoration:none;transition:color .25s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#9db8d2'">info@swissbridgeacademy.com</a>
                </div>

                {{-- Social icons: Facebook + Instagram only --}}
                <div style="display:flex;gap:10px;">
                    @foreach([
                        ['fa-facebook-f',  'https://www.facebook.com/61578503481427/',       '#1877f2'],
                        ['fa-instagram',   'https://www.instagram.com/swiss_bridgeacademy/', 'linear-gradient(135deg,#f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)'],
                    ] as [$icon, $href, $hc])
                    <a href="{{ $href }}" target="_blank" rel="noopener" aria-label="{{ $icon }}"
                       style="width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);display:inline-flex;align-items:center;justify-content:center;color:#c9d6e3;font-size:0.95rem;text-decoration:none;transition:all .3s;"
                       onmouseover="this.style.background='{{ $hc }}';this.style.borderColor='transparent';this.style.color='#fff';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 20px rgba(0,0,0,0.35)';"
                       onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='#c9d6e3';this.style.transform='';this.style.boxShadow='';">
                        <i class="fa-brands {{ $icon }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Col 2: Platform --}}
            <div class="col-lg-2 col-6">
                <h6 style="color:#ffffff;text-transform:uppercase;letter-spacing:3px;font-size:0.72rem;font-weight:800;margin-bottom:24px;position:relative;padding-bottom:12px;">
                    {{ $is_arabic ? 'المنصة' : get_phrase('Platform') }}
                    <span style="position:absolute;bottom:0;{{ $is_arabic ? 'right' : 'left' }}:0;width:28px;height:2px;background:linear-gradient(90deg,#4f46e5,#06b6d4);border-radius:2px;"></span>
                </h6>
                <ul style="list-style:none;padding:0;margin:0;">
                    @foreach([
                        [route('courses'), $is_arabic ? 'الدورات' : get_phrase('Courses')],
                        [route('blogs'),   $is_arabic ? 'المدونة' : get_phrase('Blog')],
                    ] as [$url, $label])
                    <li style="margin-bottom:14px;">
                        <a href="{{ $url }}"
                           style="color:#9db8d2;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:7px;transition:color .25s,gap .25s;"
                           onmouseover="this.style.color='#ffffff';this.style.gap='11px';"
                           onmouseout="this.style.color='#9db8d2';this.style.gap='7px';">
                            <span style="width:5px;height:5px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#06b6d4);display:inline-block;flex-shrink:0;opacity:.8;"></span>
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 3: Resources --}}
            <div class="col-lg-2 col-6">
                <h6 style="color:#ffffff;text-transform:uppercase;letter-spacing:3px;font-size:0.72rem;font-weight:800;margin-bottom:24px;position:relative;padding-bottom:12px;">
                    {{ $is_arabic ? 'الموارد' : get_phrase('Resources') }}
                    <span style="position:absolute;bottom:0;{{ $is_arabic ? 'right' : 'left' }}:0;width:28px;height:2px;background:linear-gradient(90deg,#7e22ce,#06b6d4);border-radius:2px;"></span>
                </h6>
                <ul style="list-style:none;padding:0;margin:0;">
                    @foreach([
                        [route('about.us'),       $is_arabic ? 'حول'       : get_phrase('About')],
                        [route('contact.us'),     $is_arabic ? 'اتصل بنا'  : get_phrase('Contact')],
                        [route('privacy.policy'), $is_arabic ? 'الخصوصية' : get_phrase('Privacy')],
                        [route('terms.condition'),$is_arabic ? 'الشروط'    : get_phrase('Terms')],
                    ] as [$url, $label])
                    <li style="margin-bottom:14px;">
                        <a href="{{ $url }}"
                           style="color:#9db8d2;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:7px;transition:color .25s,gap .25s;"
                           onmouseover="this.style.color='#ffffff';this.style.gap='11px';"
                           onmouseout="this.style.color='#9db8d2';this.style.gap='7px';">
                            <span style="width:5px;height:5px;border-radius:50%;background:linear-gradient(135deg,#7e22ce,#06b6d4);display:inline-block;flex-shrink:0;opacity:.8;"></span>
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 4: Newsletter --}}
            <div class="col-lg-4">
                <h6 style="color:#ffffff;text-transform:uppercase;letter-spacing:3px;font-size:0.72rem;font-weight:800;margin-bottom:24px;position:relative;padding-bottom:12px;">
                    {{ $is_arabic ? 'ابق متألقاً' : get_phrase('Stay Vibrant') }}
                    <span style="position:absolute;bottom:0;{{ $is_arabic ? 'right' : 'left' }}:0;width:28px;height:2px;background:linear-gradient(90deg,#06b6d4,#4f46e5);border-radius:2px;"></span>
                </h6>

                {{-- Mini stats strip --}}
                <div style="display:flex;gap:12px;margin-bottom:22px;">
                    @foreach([['12K+','طلاب','Students','#818cf8'],['98%','نجاح','Success','#34d399'],['120+','دورة','Courses','#22d3ee']] as [$v,$ar_l,$en_l,$c])
                    <div style="text-align:center;flex:1;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:12px 6px;">
                        <div style="font-size:1.1rem;font-weight:900;color:{{ $c }};line-height:1.2;">{{ $v }}</div>
                        <div style="font-size:0.68rem;color:#8fb3cc;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-top:3px;">{{ $is_arabic ? $ar_l : $en_l }}</div>
                    </div>
                    @endforeach
                </div>

                <p style="color:#9db8d2;font-size:0.88rem;line-height:1.8;margin-bottom:18px;">
                    {{ $is_arabic
                        ? 'انضم إلى مجتمعنا للحصول على آخر التحديثات حول الدورات والأفكار الإبداعية.'
                        : get_phrase('Join our community to get the latest updates on new courses and creative insights.') }}
                </p>

                <form action="{{ route('newsletter.store') }}" method="post" style="position:relative;">
                    @csrf
                    <input type="email" name="email" required
                           placeholder="{{ $is_arabic ? 'عنوان البريد الإلكتروني' : get_phrase('Email Address') }}"
                           style="width:100%;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.18);border-radius:100px;color:#e8eef4;padding:14px {{ $is_arabic ? '22px' : '130px' }} 14px {{ $is_arabic ? '130px' : '22px' }};font-size:0.88rem;outline:none;transition:border-color .3s,box-shadow .3s;box-sizing:border-box;"
                           onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.2)';"
                           onblur="this.style.borderColor='rgba(255,255,255,0.18)';this.style.boxShadow='';">
                    <button type="submit"
                            style="position:absolute;top:6px;{{ $is_arabic ? 'left' : 'right' }}:6px;background:linear-gradient(135deg,#4f46e5,#7e22ce);color:#fff;border:none;border-radius:100px;padding:9px 22px;font-size:0.85rem;font-weight:700;cursor:pointer;transition:opacity .25s,transform .2s;"
                            onmouseover="this.style.opacity='.88';this.style.transform='scale(1.03)';"
                            onmouseout="this.style.opacity='1';this.style.transform='';">
                        {{ $is_arabic ? 'انضم' : get_phrase('Join') }}
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- Divider --}}
    <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.12),transparent);margin:0 24px;position:relative;z-index:1;"></div>

    {{-- Bottom bar --}}
    <div class="container" style="padding:22px 12px;position:relative;z-index:1;">
        <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:12px;">
            <p style="margin:0;font-size:0.83rem;color:#8aa4bc;">
                © {{ date('Y') }} <span style="color:#818cf8;font-weight:700;">{{ get_settings('system_name') }}</span>. {{ get_phrase('All Rights Reserved.') }}
            </p>
            <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;color:#7a9ab2;">
                <span style="width:6px;height:6px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#06b6d4);display:inline-block;"></span>
                {{ $is_arabic ? 'صُنع بـ ❤ لأجل التعلّم' : 'Made with ❤ for learning' }}
            </div>
        </div>
    </div>

</footer>

{{-- WhatsApp Floating Button --}}
<a href="https://wa.me/41779412126"
   target="_blank" aria-label="WhatsApp"
   style="position:fixed;bottom:36px;right:36px;width:62px;height:62px;background:linear-gradient(135deg,#25d366,#128c7e);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:28px;z-index:10000;text-decoration:none;box-shadow:0 8px 28px rgba(37,211,102,0.45);transition:transform .3s cubic-bezier(.175,.885,.32,1.275);"
   onmouseover="this.style.transform='scale(1.12) rotate(8deg)';"
   onmouseout="this.style.transform='';">
    <div style="position:absolute;width:100%;height:100%;border-radius:50%;background:rgba(37,211,102,0.5);animation:waPing 2s cubic-bezier(0,0,.2,1) infinite;z-index:-1;"></div>
    <div style="position:absolute;width:100%;height:100%;border-radius:50%;background:rgba(37,211,102,0.35);animation:waPing 2s cubic-bezier(0,0,.2,1) infinite 1s;z-index:-1;"></div>
    <i class="fa-brands fa-whatsapp"></i>
</a>

<style>
@keyframes waPing { 75%,100%{ transform:scale(2.1); opacity:0; } }
</style>
