@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';
@endphp

<!-- Study Modes Section -->
<section class="py-100 py-5" style="background: linear-gradient(180deg, #ffffff 0%, #f0f4ff 100%);">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="vibrant-tag mb-3 d-inline-block">{{ $is_arabic ? 'نمط الدراسة' : 'Study Mode' }}</span>
            <h2 class="display-5 fw-800">{{ $is_arabic ? 'تعلّم بالطريقة التي تناسبك' : 'Learn in the Way That Suits You' }}</h2>
            <p class="text-muted col-md-8 mx-auto">{{ $is_arabic ? 'نحن نؤمن أن المرونة جزء مهم من نجاح التجربة التعليمية، لذلك نوفر للطلاب خيارين في الدراسة بحسب طبيعة البرنامج وما يناسب احتياجاتهم.' : 'We believe flexibility is a crucial part of a successful learning experience, which is why we offer students two study options based on the program\'s nature and their needs.' }}</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="h-100 p-5 shadow-sm bg-white" style="border-radius: 30px; border: 1px solid rgba(79, 70, 229, 0.1);">
                    <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(79,70,229,0.1), rgba(6,182,212,0.1));">
                        <i class="fi-rr-globe fs-1 text-vibrant-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-3">{{ $is_arabic ? 'الدراسة عن بُعد' : 'Online Learning' }}</h3>
                    <p class="text-muted fs-5 lh-lg">{{ $is_arabic ? 'خيار مناسب لمن يبحث عن المرونة وإمكانية التعلّم من أي مكان، مع متابعة منظمة وتجربة تعليمية واضحة.' : 'Perfect for those seeking flexibility to learn from anywhere with organized follow-ups and a clear educational experience.' }}</p>
                </div>
            </div>
            <div class="col-lg-5" data-aos="fade-left">
                <div class="h-100 p-5 shadow-lg text-white" style="border-radius: 30px; background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);">
                    <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: rgba(255,255,255,0.2);">
                        <i class="fi-rr-building fs-1 text-white"></i>
                    </div>
                    <h3 class="fw-bold mb-3">{{ $is_arabic ? 'الدراسة حضوريًا من داخل المركز' : 'On-site Learning' }}</h3>
                    <p class="text-white fs-5 lh-lg" style="opacity: 0.9;">{{ $is_arabic ? 'خيار مناسب لمن يفضّل التفاعل المباشر، وبيئة تعليمية حضورية تساعد على التركيز والمشاركة بشكل أكبر.' : 'Ideal for those who prefer direct interaction and an immersive on-site learning environment that helps with focus and participation.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What You Will Gain Section -->
<section class="py-100 py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=1200" class="w-100 rounded-5 shadow-lg" alt="Team meeting" style="border: 8px solid rgba(79, 70, 229, 0.05); height: 450px; object-fit: cover;">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="display-5 fw-800 mb-4">{{ $is_arabic ? 'ماذا ستكتسب من رحلتك معنا؟' : 'What will you gain from your journey with us?' }}</h2>
                <p class="fs-5 text-muted mb-4">{{ $is_arabic ? 'هدفنا أن تخرج من التجربة التعليمية بمهارات عملية وفهم أوضح وثقة أكبر في قدرتك على التقدّم.' : 'Our goal is for you to exit the educational experience with practical skills, a clearer understanding, and greater confidence in your ability to progress.' }}</p>
                
                @php
                    $gains = [
                        ['فهم عملي لمجالات رقمية حديثة', 'Practical understanding of modern digital fields'],
                        ['قدرة أفضل على استخدام الأدوات والتقنيات المعاصرة', 'Better ability to use contemporary tools and technologies'],
                        ['مهارات قابلة للتطبيق في الدراسة أو العمل أو المشاريع الشخصية', 'Applicable skills for study, work, or personal projects'],
                        ['تطور في الجاهزية المهنية والعملية', 'Improvement in professional and practical readiness'],
                        ['أساس قوي يمكن البناء عليه مستقبلًا', 'A strong foundation to build on in the future']
                    ];
                @endphp
                <ul class="list-unstyled fa-ul mt-4 ms-4">
                    @foreach($gains as $point)
                    <li class="mb-3 fs-5 text-dark fw-medium d-flex align-items-start gap-3">
                        <i class="fa-solid fa-check-circle text-success mt-1 fs-4"></i>
                        <span>{{ $is_arabic ? $point[0] : $point[1] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Target Audience -->
<section class="py-100 py-5" style="background: radial-gradient(circle at center, #1e1b4b 0%, #0f172a 100%);">
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-9" data-aos="zoom-in">
                <span class="badge px-4 py-2 fs-6 rounded-pill mb-4" style="background: rgba(79, 70, 229, 0.2); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.4);">
                    {{ $is_arabic ? 'لمن صُممت برامجنا؟' : 'Who are our programs designed for?' }}
                </span>
                <h3 class="fw-medium text-white lh-base mt-2" style="font-size: 1.8rem; line-height: 1.8 !important;">
                    {{ $is_arabic ? 'برامج Swiss Bridge Academy مناسبة للمبتدئين الذين يريدون دخول العالم الرقمي، وللطلاب الذين يبحثون عن مهارات عملية حقيقية، وللمهنيين الذين يريدون تطوير قدراتهم، ولمن يفكرون في تغيير مسارهم المهني، وكذلك للمستقلين ورواد الأعمال الذين يريدون توسيع مهاراتهم.' : 'Swiss Bridge Academy programs are suitable for beginners entering the digital world, students seeking actual practical skills, professionals wanting to enhance their capabilities, career-changers, and freelancers or entrepreneurs wishing to expand their skill sets.' }}
                </h3>
            </div>
        </div>
    </div>
</section>

<!-- How to Join -->
<section class="py-100 py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-800">{{ $is_arabic ? 'كيف تنضم إلى Swiss Bridge Academy؟' : 'How to join Swiss Bridge Academy?' }}</h2>
            <p class="text-muted">{{ $is_arabic ? 'صممنا عملية الانضمام بطريقة واضحة ومنظمة، حتى نساعد كل متقدم على البدء من المكان الصحيح وفي المسار الأنسب له.' : 'We designed an organized joining process to help every applicant start correctly from the right place and on the most suitable path.' }}</p>
        </div>
        
        <div class="row g-4 mt-4 position-relative">
            <!-- connecting line -->
            <div class="d-none d-lg-block position-absolute" style="top: 20%; left: 0; right: 0; border-top: 2px dashed rgba(79, 70, 229, 0.3); z-index: 1;"></div>
            
            @php
                $steps = [
                    ['1', 'تعبئة طلب الانضمام', 'تبدأ الرحلة من خلال تعبئة نموذج طلب الانضمام، حيث نأخذ فكرة أولية عن اهتمامك، خلفيتك، والبرنامج الذي ترغب في الالتحاق به.', 'Fill Application', 'The journey starts by filling out the application form, where we get an initial idea of your interests, background, and the program you wish to join.'],
                    ['2', 'اختبار تحديد المستوى', 'بعد مراجعة الطلب، يتم توجيهك إلى اختبار مستوى مناسب يساعدنا على فهم مستواك الحالي وتحديد نقطة البداية الأنسب لك.', 'Placement Test', 'After reviewing the application, you\'ll be directed to a placement test that helps us understand your current level and determine the most suitable starting point.'],
                    ['3', 'المقابلة', 'نجري مقابلة قصيرة للتعرف عليك بشكل أفضل، وفهم أهدافك، والتأكد من اختيار المسار المناسب لطموحك ومستواك.', 'Interview', 'We conduct a short interview to get to know you better, understand your goals, and ensure the chosen path fits your ambition and level.'],
                    ['4', 'تأكيد القبول وإتمام الدفع', 'بعد مراجعة الطلب والاختبار والمقابلة، يتم توضيح الخطوة التالية واستكمال إجراءات الدفع والتسجيل.', 'Acceptance & Payment', 'Following the application, test, and interview review, the next step is clarified and payment and registration procedures are completed.'],
                    ['5', 'التسجيل وبدء الرحلة', 'بمجرد تأكيد التسجيل، تبدأ رحلتك التعليمية معنا، سواء عن بُعد أو حضوريًا من داخل المركز.', 'Registration & Start', 'Once registration is confirmed, your educational journey with us begins, whether online or on-site at our center.']
                ];
            @endphp
            @foreach($steps as $index => $step)
            <div class="col-lg-2 col-md-4 col-sm-6 mx-auto position-relative" style="z-index: 2;" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="text-center">
                    <div class="d-inline-flex align-items-center justify-content-center text-white fw-bold shadow-lg" style="width: 50px; height: 50px; border-radius: 50%; background: var(--vibrant-primary); border: 4px solid #fff; font-size: 1.2rem;">
                        {{ $step[0] }}
                    </div>
                    <div class="mt-4 p-3 bg-light rounded-4 shadow-sm h-100 border border-1 border-white" style="transition: transform .3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform=''">
                        <h6 class="fw-bold text-dark">{{ $is_arabic ? $step[1] : $step[3] }}</h6>
                        <p class="small text-muted mb-0 lh-lg">{{ $is_arabic ? $step[2] : $step[4] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <p class="text-muted fst-italic mb-4">{{ $is_arabic ? 'هدفنا من هذه الخطوات هو مساعدتك على البدء بالشكل الصحيح، وليس تعقيد عملية التسجيل.' : 'Our goal with these steps is to help you start right, not to complicate the registration process.' }}</p>
            <a href="{{ route('register.form') }}" class="btn btn-vibrant rounded-pill px-5 py-3 fw-bold fs-5 shadow-lg">{{ $is_arabic ? 'ابدأ طلب الانضمام' : 'Start Application' }}</a>
        </div>
    </div>
</section>

<!-- Trust & Quality Section -->
<section class="py-100 py-5" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%);">
    <div class="container py-5">
        <div class="row align-items-center bg-white rounded-5 shadow-sm p-4 p-lg-5 border-0">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="display-6 fw-800 text-dark mb-4">{{ $is_arabic ? 'تجربة تعليمية تقوم على الجودة والوضوح' : 'An Educational Experience Based on Quality and Clarity' }}</h2>
                <p class="fs-5 text-muted lh-base mb-4">
                    {{ $is_arabic ? 'نحرص في Swiss Bridge Academy على تقديم تجربة تعليمية واضحة، منظمة، وعملية، تركّز على بناء المهارات الحقيقية وتقديم محتوى يساعد الطالب على الاستفادة الفعلية، وليس فقط المتابعة النظرية.' : 'At Swiss Bridge Academy, we are keen on providing a clear, organized, and practical learning experience that focuses on building real skills and offering content that helps the student actually benefit, rather than just theoretically follow along.' }}
                </p>
                @php
                    $qualities = [
                        ['إدارة من سويسرا', 'Swiss Management'],
                        ['محتوى حديث وموجه للواقع العملي', 'Modern, practically-oriented content'],
                        ['مدربون بخبرة عملية', 'Trainers with practical experience'],
                        ['تعلم عن بُعد أو حضوريًا من داخل المركز', 'Online or on-site learning'],
                        ['دعم بعد التخرج', 'Post-graduation support'],
                        ['شهادة إتمام', 'Certificate of completion']
                    ];
                @endphp
                <div class="row g-3">
                    @foreach($qualities as $quality)
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 text-dark fw-bold">
                            <i class="fa-solid fa-star text-warning"></i>
                            {{ $is_arabic ? $quality[0] : $quality[1] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 text-center" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=1200" class="img-fluid rounded-4 shadow-lg" alt="Quality Education">
            </div>
        </div>
    </div>
</section>
