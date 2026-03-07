@php
    $faqs = [];
    if (!empty($course_details->faqs)) {
        $decoded = json_decode($course_details->faqs, true);
        $faqs = is_array($decoded) ? $decoded : [];
    }
@endphp
<div class="ps-box p-0 shadow-none mt-5 pt-5 border-top border-white-10 animate__animated animate__fadeIn">
    <h4 class="fw-800 text-white mb-4"><i class="fi-rr-interrogation text-vibrant-primary me-2"></i> {{ get_phrase('Frequently Asked Questions') }}</h4>
    @if (!empty($faqs) && is_array($faqs) && count($faqs) > 0)
        <div class="faq p-0">
            <div class="accordion custom-vibrant-accordion" id="faqAccordion">
                @foreach ($faqs as $key => $faq)
                    <div class="accordion-item mb-3 border-0 bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed px-4 py-3 rounded-4" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq_{{ $key }}" aria-expanded="false">
                                <span class="fw-bold">{{ ucfirst($faq['title'] ?? '') }}</span>
                            </button>
                        </h2>
                        <div id="faq_{{ $key }}" class="accordion-collapse collapse"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body px-4 py-4 mt-2 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <p class="text-white opacity-75 mb-0 lh-lg">
                                    {{ ucfirst($faq['description'] ?? '') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-5 opacity-50">
            <i class="fi-rr-box-open fs-1 d-block mb-3"></i>
            {{ get_phrase('No FAQs available yet') }}
        </div>
    @endif
</div>