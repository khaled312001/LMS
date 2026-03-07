@extends('layouts.landing')
@push('title', get_phrase('Article'))
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
    .article-section {
        background-color: #f8fafc;
        padding: 80px 0;
    }
    .article-main-container {
        background: #fff;
        border-radius: 40px;
        padding: 50px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.02);
    }
    .article-title {
        font-size: 2.75rem;
        font-weight: 900;
        letter-spacing: -1.5px;
        color: var(--vibrant-dark);
        margin-bottom: 30px;
    }
    .article-content {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #334155;
    }
    .kb-sidebar-container {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 30px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
    .sidebar-topic-list {
        list-style: none;
        padding: 0;
    }
    .sidebar-topic-item {
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .sidebar-topic-item:last-child {
        border-bottom: none;
    }
    .sidebar-topic-item a {
        text-decoration: none;
        font-weight: 600;
        color: #64748b;
        display: block;
        transition: all 0.2s ease;
    }
    .sidebar-topic-item a:hover, .sidebar-topic-item a.active {
        color: var(--vibrant-primary);
        transform: translateX(5px);
    }
</style>
@endpush
@section('content')
    <!-- Breadcrumb Area -->
    <section class="mesh-gradient-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('knowledge.base') }}">{{ get_phrase('Knowledge Base') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Article') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content Section -->
    <section class="article-section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="article-main-container">
                        <h1 class="article-title">{{ $article->topic_name }}</h1>
                        <div class="article-content">
                            {!! $article->description !!}
                        </div>
                        <div class="mt-5 pt-4 border-top">
                            <span class="fw-bold me-3 text-dark">{{ get_phrase('Share:') }}</span>
                            <div class="d-inline-flex gap-3">
                                @if (get_frontend_settings('twitter'))
                                    <a href="{{ get_frontend_settings('twitter') }}" class="text-vibrant-primary fs-5"><i class="fa-brands fa-twitter"></i></a>
                                @endif
                                @if (get_frontend_settings('linkedin'))
                                    <a href="{{ get_frontend_settings('linkedin') }}" class="text-vibrant-primary fs-5"><i class="fa-brands fa-linkedin"></i></a>
                                @endif
                                @if (get_frontend_settings('facebook'))
                                    <a href="{{ get_frontend_settings('facebook') }}" class="text-vibrant-primary fs-5"><i class="fa-brands fa-facebook"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="kb-sidebar-container">
                        <h4 class="fw-900 g-title mb-4 pb-2 border-bottom">{{ ucwords($title->title) }}</h4>
                        @php
                            $topics = App\Models\Knowledge_base_topick::where('knowledge_base_id', $title->id)->orderBy('updated_at', 'desc')->get();
                        @endphp
                        <ul class="sidebar-topic-list">
                            @foreach($topics as $topic)
                                <li class="sidebar-topic-item">
                                    <a href="{{ route('knowledge.base.article', ['id' => $topic->id]) }}" class="{{ $article->id == $topic->id ? 'active' : '' }}">
                                        {{ ucwords($topic->topic_name) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')@endpush