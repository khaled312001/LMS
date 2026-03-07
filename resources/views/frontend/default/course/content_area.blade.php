<div class="ps-box p-0 shadow-none animate__animated animate__fadeIn">
    <h4 class="fw-800 text-white mb-4"><i class="fi-rr-book-open-cover text-vibrant-primary me-2"></i> {{ get_phrase('Course Curriculum') }}</h4>
    <div class="lesson-play-list p-0">
        @if (isset($sections) && $sections && $sections->count() > 0)
            <div class="accordion custom-vibrant-accordion" id="curriculumAccordion">
                @foreach ($sections as $key => $section)
                    <div class="accordion-item mb-3 border-0 bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button @if($key > 0) collapsed @endif px-4 py-3 rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#section_{{ $section->id }}" aria-expanded="@if($key == 0) true @else false @endif">
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
                                        <li class="rounded-3 transition-all hover-translate-x-5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                            <a href="{{ $course_details->is_paid ? 'javascript:: void(0);' : route('course.player', $course_details->slug) }}" class="d-flex justify-content-between align-items-center px-4 py-3 text-decoration-none">
                                                <div class="d-flex align-items-center gap-3">
                                                    <i class="fi-rr-play-alt text-vibrant-primary fs-5 mt-1"></i>
                                                    <span class="text-white opacity-80">{{ ucfirst($lesson->title) }}</span>
                                                </div>
                                                
                                                @if($lesson->duration != '00:00:00' && $lesson->duration != "")
                                                    <span class="badge rounded-pill px-3 py-2" style="background: rgba(79, 70, 229, 0.1); color: var(--vibrant-primary); border: 1px solid rgba(79, 70, 229, 0.2);">
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
            <div class="text-center py-5 opacity-50">
                <i class="fi-rr-book fs-1 d-block mb-3"></i>
                {{ get_phrase('Course curriculum Empty') }}
            </div>
        @endif
    </div>
</div>
