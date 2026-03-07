@extends('layouts.landing')
@push('title', get_phrase('Knowledge Base'))
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
    .kb-section {
        background-color: #f8fafc;
        padding: 100px 0;
    }
    .g-title {
        font-weight: 900 !important;
        letter-spacing: -1px;
    }
    .kb-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 30px;
        padding: 40px;
        height: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
    .kb-card:hover {
        transform: translateY(-10px);
        background: #fff;
        box-shadow: 0 30px 60px rgba(0,0,0,0.05);
    }
    .kb-category-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--vibrant-primary), var(--vibrant-accent));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #fff;
        margin-bottom: 25px;
    }
    .kb-topic-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .kb-topic-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
    }
    .kb-topic-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .kb-topic-item a {
        color: #475569;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        width: 100%;
    }
    .kb-topic-item a:hover {
        color: var(--vibrant-primary);
        transform: translateX(5px);
    }
    .kb-topic-item i {
        font-size: 0.8rem;
        margin-right: 12px;
        color: var(--vibrant-primary);
        opacity: 0.5;
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
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Knowledge Base') }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-3 g-title mb-2">{{ get_phrase('Knowledge Base') }}</h1>
                    <p class="text-muted mb-0 fs-5">{{ get_phrase("Everything you need to know about our platform, courses, and more.") }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Knowledge Base Content Section -->
    <section class="kb-section">
        <div class="container">
            <div class="row g-4 overflow-hidden">
                @foreach($articles as $index => $article)
                    <div class="col-lg-6">
                        <div class="kb-card">
                            <div class="kb-category-icon">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <h3 class="g-title mb-4">{{ ucwords($article->title) }}</h3>
                            
                            @php
                                $topics = App\Models\Knowledge_base_topick::where('knowledge_base_id', $article->id)->orderBy('updated_at', 'desc')->get();
                            @endphp

                            <ul class="kb-topic-list">
                                @foreach($topics as $key => $topic)
                                    <li class="kb-topic-item">
                                        <a href="{{ route('knowledge.base.article', ['id' => $topic->id]) }}">
                                            <i class="fa-solid fa-file-lines"></i>
                                            {{ ucwords($topic->topic_name) }}
                                        </a>
                                    </li>
                                @endforeach
                                @if($topics->count() == 0)
                                    <li class="text-muted small italic">{{ get_phrase('No topics found in this category.') }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endforeach

                @if ($articles->count() == 0)
                    <div class="col-12 text-center py-5">
                        <div class="kb-card">
                            @include('frontend.default.empty')
                        </div>
                    </div>
                @endif
            </div>

            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')@endpush
