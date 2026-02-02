<section class="category-wrapper section-padding">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <h1 class="title mb-4 builder-editable" builder-identity="1">{{ get_phrase('Frequently Asked Questions?') }}</h1>
                <p class="info builder-editable" builder-identity="2">{{ get_phrase("FAQ provides quick answers to common inquiries, helping users resolve doubts efficiently.") }}</p>
            </div>
        </div>
        <div class="row mb-110 mt-5">
            @php
                // $faqs = json_decode(get_frontend_settings('website_faqs'), true);
                // $faqs = count($faqs) > 0 ? $faqs : [['question' => '', 'answer' => '']];
                $faqs = [
                    ['question' => get_phrase('FAQ Learning Methods Question'), 'answer' => get_phrase('FAQ Learning Methods Answer')],
                    ['question' => get_phrase('FAQ Language Question'), 'answer' => get_phrase('FAQ Language Answer')],
                    ['question' => get_phrase('FAQ Certificate Question'), 'answer' => get_phrase('FAQ Certificate Answer')],
                    ['question' => get_phrase('FAQ Support Question'), 'answer' => get_phrase('FAQ Support Answer')],
                    ['question' => get_phrase('FAQ Experience Question'), 'answer' => get_phrase('FAQ Experience Answer')],
                    ['question' => get_phrase('FAQ Payment Question'), 'answer' => get_phrase('FAQ Payment Answer')],
                    ['question' => get_phrase('FAQ Refund Question'), 'answer' => get_phrase('FAQ Refund Answer')],
                    ['question' => get_phrase('FAQ Contact Question'), 'answer' => get_phrase('FAQ Contact Answer')],
                ];
            @endphp
            <div class="col-md-12">
                <div class="accordion qnaaccordion-two" id="accordionExampleLeft">
                    @foreach ($faqs as $key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeft{{ $key }}" aria-expanded="true" aria-controls="collapseLeft{{ $key }}">
                                    {{ $faq['question'] }}
                                </button>
                            </h2>
                            <div id="collapseLeft{{ $key }}" class="accordion-collapse collapse px-0 {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExampleLeft">
                                <div class="accordion-body">
                                    <p class="answer">{{ $faq['answer'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>