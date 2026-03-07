@extends('layouts.landing')
@push('title', get_phrase('Blog'))
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
    .blog-listing-section {
        background-color: #f8fafc;
        padding: 80px 0;
    }
    .g-title {
        font-weight: 900 !important;
        letter-spacing: -1px;
    }
    .filter-card {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        border-radius: 24px !important;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important;
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
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Blog') }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-4 g-title mb-2">{{ get_phrase('Blogs') }}</h1>
                    <p class="text-muted mb-0">{{ get_phrase('Explore our latest articles, news, and creative insights.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content Section -->
    <div class="blog-listing-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row g-4">
                        @foreach ($blogs as $key => $blog)
                            <div class="col-lg-6 col-md-6 mb-4">
                                @include('frontend.default.blog.card')
                            </div>
                        @endforeach

                        @if ($blogs->count() == 0)
                            <div class="col-12 bg-white radius-24 py-5 shadow-sm text-center">
                                @include('frontend.default.empty')
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if(count($blogs) > 0)
                        <div class="entry-pagination mt-5 d-flex justify-content-center">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="filter-card">
                        @include('frontend.default.blog.filter')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')@endpush
