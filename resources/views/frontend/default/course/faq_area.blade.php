@php
    $faqs = [];
    if (!empty($course_details->faqs)) {
        $decoded = json_decode($course_details->faqs, true);
        $faqs = is_array($decoded) ? $decoded : [];
    }
@endphp
<div class="ps-box p-0 shadow-none">
    <h4 class="g-title mb-15">{{ get_phrase('FAQ') }}</h4>
    @if (!empty($faqs) && is_array($faqs) && count($faqs) > 0)
        <div class="faq p-0">
            <div class="accordion" id="accordionExample">
                @foreach ($faqs as $key => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse_{{ $key }}" aria-expanded="true"
                                aria-controls="collapse_{{ $key }}">{{ ucfirst($faq['title'] ?? '') }}
                            </button>
                        </h2>
                        <div id="collapse_{{ $key }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul class="faqs">
                                    <li>
                                        <a href="#"
                                            class="d-flex mb-4 justify-content-between align-items-center">
                                            <p class="d-flex">
                                                {{ ucfirst($faq['description'] ?? '') }}
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center">{{ get_phrase('FAQ area empty') }}</p>
    @endif
</div>