@extends('layouts.landing')
@push('title', get_phrase('Frequently asked questions'))
@push('meta')@endpush
@push('css')
<style>
    .mesh-gradient-breadcrumb {
        background: radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 100% 100%, rgba(6, 182, 212, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
        padding: 180px 0 80px !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .breadcrumb-item a {
        color: var(--vibrant-primary) !important;
        font-weight: 600;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: var(--vibrant-dark) !important;
        font-weight: 700;
    }
    .faq-section {
        background-color: #f8fafc;
        padding: 100px 0;
    }
    .g-title {
        font-weight: 900 !important;
        letter-spacing: -1px;
    }
    .faq-accordion .accordion-item {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .faq-accordion .accordion-item:hover {
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
    .faq-accordion .accordion-button {
        padding: 25px 30px;
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--vibrant-dark);
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }
    .faq-accordion .accordion-button:not(.collapsed) {
        color: var(--vibrant-primary);
        background: rgba(79, 70, 229, 0.03) !important;
    }
    .faq-accordion .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234F46E5'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }
    .faq-accordion .accordion-body {
        padding: 0 30px 30px;
        font-size: 1.1rem;
        line-height: 1.7;
        color: #64748b;
    }
</style>
@endpush
@section('content')
    <!-- Breadcrumb Area -->
    <section class="mesh-gradient-breadcrumb">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('FAQ') }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-3 g-title mb-2">{{ get_phrase('Frequently Asked Questions') }}</h1>
                    <p class="text-muted mb-0 fs-5">{{ get_phrase("Find quick answers to common inquiries and resolve your doubts efficiently.") }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Content Section -->
    <section class="faq-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @php
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

                    <div class="accordion faq-accordion" id="faqAccordion">
                        @foreach ($faqs as $key => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $key }}" aria-expanded="{{ $key == 0 ? 'true' : 'false' }}">
                                        {{ $faq['question'] }}
                                    </button>
                                </h2>
                                <div id="faq{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ $faq['answer'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')@endpush
