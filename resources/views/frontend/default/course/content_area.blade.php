<div class="ps-box p-0 shadow-none animate__animated animate__fadeIn">
    <h4 class="fw-800 text-dark mb-4"><i class="fi-rr-book-open-cover text-primary me-2"></i> {{ get_phrase('Course Curriculum') }}</h4>
    <div class="lesson-play-list p-0">
        @if (isset($sections) && $sections && $sections->count() > 0)
            <div class="accordion custom-sba-accordion" id="curriculumAccordion">
                @foreach ($sections as $key => $section)
                    <div class="accordion-item mb-3 border-0 bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button @if($key > 0) collapsed @endif px-4 py-3 rounded-4 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#section_{{ $section->id }}" aria-expanded="@if($key == 0) true @else false @endif" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #1e293b;">
                                <span class="fw-bold">{{ ucfirst($section->title) }}</span>
                            </button>
                        </h2>
                        <div id="section_{{ $section->id }}" class="accordion-collapse collapse @if($key == 0) show @endif" data-bs-parent="#curriculumAccordion">
                            <div class="accordion-body px-0 pt-2">
                                <ul class="lesson-list course_list list-unstyled m-0 d-flex flex-column gap-2">
                                    @php
                                        $lessons = DB::table('lessons')
                                            ->where('section_id', $section->id)
                                            ->orderBy('sort')
                                            ->get();
                                    @endphp
                                    @foreach ($lessons as $lesson)
                                        <li class="rounded-3 transition-all hover-translate-x-5" style="background: #ffffff; border: 1px solid #e2e8f0;">
                                            <a href="{{ $course_details->is_paid ? 'javascript:: void(0);' : route('course.player', $course_details->slug) }}" class="d-flex justify-content-between align-items-start px-4 py-3 text-decoration-none gap-3">
                                                <div class="d-flex align-items-start gap-3" style="flex: 1; min-width: 0;">
                                                    <i class="fi-rr-play-alt text-primary fs-5 flex-shrink-0" style="margin-top: 2px;"></i>
                                                    <span class="text-secondary fw-bold" style="line-height: 1.5;">{{ ucfirst($lesson->title) }}</span>
                                                </div>

                                                @if($lesson->duration != '00:00:00' && $lesson->duration != "")
                                                    <span class="badge rounded-pill px-3 py-2 flex-shrink-0" style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">
                                                        <i class="fi-rr-clock me-1 small"></i> {{$lesson->duration}}
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @php $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic'; @endphp
            <div class="accordion custom-sba-accordion" id="placeholderAccordion">
                <!-- Section 1 -->
                <div class="accordion-item mb-3 border-0 bg-transparent">
                    <h2 class="accordion-header">
                        <button class="accordion-button px-4 py-3 rounded-4 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#placeholder_1" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #1e293b;">
                            <span class="fw-bold">{{ $is_arabic ? 'المقدمة والأساسيات' : 'Introduction & Fundamentals' }}</span>
                        </button>
                    </h2>
                    <div id="placeholder_1" class="accordion-collapse collapse show" data-bs-parent="#placeholderAccordion">
                        <div class="accordion-body px-0 pt-2">
                            <ul class="lesson-list list-unstyled m-0 d-flex flex-column gap-2">
                                <li class="rounded-3 px-4 py-3" style="background: #ffffff; border: 1px solid #e2e8f0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fi-rr-play-alt text-primary fs-5 mt-1"></i>
                                            <span class="text-secondary fw-bold">{{ $is_arabic ? 'مقدمة عن الدورة وما ستتعلمه' : 'Introduction to the course and what you will learn' }}</span>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2" style="background: #e0e7ff; color: #4338ca;">10:00</span>
                                    </div>
                                </li>
                                <li class="rounded-3 px-4 py-3" style="background: #ffffff; border: 1px solid #e2e8f0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fi-rr-settings text-primary fs-5 mt-1"></i>
                                            <span class="text-secondary fw-bold">{{ $is_arabic ? 'تجهيز الأدوات وبيئة العمل' : 'Setting up tools and workspace' }}</span>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2" style="background: #e0e7ff; color: #4338ca;">15:00</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Section 2 -->
                <div class="accordion-item mb-3 border-0 bg-transparent">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed px-4 py-3 rounded-4 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#placeholder_2" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #1e293b;">
                            <span class="fw-bold">{{ $is_arabic ? 'التطبيق العملي والمشاريع' : 'Practical Application & Projects' }}</span>
                        </button>
                    </h2>
                    <div id="placeholder_2" class="accordion-collapse collapse" data-bs-parent="#placeholderAccordion">
                        <div class="accordion-body px-0 pt-2">
                            <ul class="lesson-list list-unstyled m-0 d-flex flex-column gap-2">
                                <li class="rounded-3 px-4 py-3" style="background: #ffffff; border: 1px solid #e2e8f0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fi-rr-laptop text-primary fs-5 mt-1"></i>
                                            <span class="text-secondary fw-bold">{{ $is_arabic ? 'بدء المشروع الأول خطوة بخطوة' : 'Starting the first project step by step' }}</span>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2" style="background: #e0e7ff; color: #4338ca;">45:00</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
