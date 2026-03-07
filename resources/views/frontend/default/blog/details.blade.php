@extends('layouts.landing')
@push('title', get_phrase('Blog Details'))
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
    .blog-details-section {
        background-color: #f8fafc;
        padding: 80px 0;
    }
    .article-container {
        background: #fff;
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.02);
    }
    .article-header {
        margin-bottom: 40px;
        text-align: center;
    }
    .article-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        margin-bottom: 30px;
        color: #64748b;
        font-weight: 600;
    }
    .article-meta i {
        color: var(--vibrant-primary);
        margin-right: 8px;
    }
    .article-title {
        font-size: 3.5rem;
        font-weight: 900;
        letter-spacing: -2px;
        line-height: 1.1;
        color: #0f172a;
        margin-bottom: 30px;
    }
    .article-thumbnail {
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 50px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.1);
    }
    .article-content {
        font-size: 1.25rem;
        line-height: 1.8;
        color: #334155;
    }
    .article-content p {
        margin-bottom: 30px;
    }
    .article-content img {
        max-width: 100%;
        border-radius: 20px;
        margin: 40px 0;
    }
    .tag-cloud {
        padding-top: 40px;
        border-top: 1px solid #f1f5f9;
        margin-top: 50px;
    }
    .sidebar-widget {
        background: #fff;
        border-radius: 30px;
        padding: 30px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
    .like-button {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 1.5rem;
    }
    .like-button.active {
        background: var(--vibrant-primary);
        color: #fff;
        border-color: var(--vibrant-primary);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
    }
    @media (max-width: 991px) {
        .article-container { padding: 30px; }
        .article-title { font-size: 2.5rem; }
    }
</style>
@endpush

@section('content')
    @php
        $total_comments = count_comments_by_blog_id($blog_details->id);
        $total_likes = count_likes_by_blog_id($blog_details->id);
    @endphp

    <!-- Breadcrumb Area -->
    <section class="mesh-gradient-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blogs') }}">{{ get_phrase('Blogs') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Blog Details') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Details Section -->
    <section class="blog-details-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <article class="article-container">
                        <header class="article-header">
                            <div class="article-meta">
                                <span><i class="fa-solid fa-folder"></i> {{ get_blog_category_name($blog_details->category_id) }}</span>
                                <span><i class="fa-solid fa-calendar-alt"></i> {{ date('d M, Y', strtotime($blog_details->created_at)) }}</span>
                                <span><i class="fa-solid fa-heart"></i> <span id="total-blog-likes">{{ $total_likes }}</span> {{ get_phrase('Likes') }}</span>
                            </div>
                            <h1 class="article-title">{{ $blog_details->title }}</h1>
                        </header>

                        <div class="article-thumbnail">
                            <img src="{{ get_image($blog_details->banner) }}" class="w-100 h-100 object-fit-cover" alt="{{ $blog_details->title }}">
                        </div>

                        <div class="article-content">
                            {!! removeScripts($blog_details->description) !!}
                        </div>

                        <div class="tag-cloud d-flex flex-wrap gap-2 align-items-center">
                            <span class="fw-bold me-2 text-dark">{{ get_phrase('Tags:') }}</span>
                            @php
                                $tags = $blog_details->keywords ? json_decode($blog_details->keywords, true) : [];
                                if (is_array($tags) && count($tags) > 0) {
                                    $tags = array_column($tags, 'value');
                                } else { $tags = []; }
                            @endphp
                            @foreach ($tags as $tag)
                                <a href="{{ route('blogs', ['tag' => $tag]) }}" class="badge rounded-pill bg-light text-dark text-decoration-none px-3 py-2 transition-all hover-bg-primary">
                                    {{ ucfirst($tag) }}
                                </a>
                            @endforeach
                        </div>

                        @auth
                            <div class="d-flex justify-content-center mt-5">
                                @php
                                    $is_liked = App\Models\BlogLike::where('blog_id', $blog_details->id)
                                        ->where('user_id', auth()->user()->id)
                                        ->first();
                                @endphp
                                <div class="like-button @if ($is_liked) active @endif" id="blog-like-toggle">
                                    <i class="fa-solid fa-heart"></i>
                                </div>
                            </div>
                        @endauth
                    </article>

                    <!-- Related Articles -->
                    @if(isset($related_blogs) && $related_blogs->count() > 0)
                        <div class="mt-100">
                            <div class="text-center mb-5">
                                <h2 class="display-5 fw-900 letter-spacing-tight">{{ get_phrase('Related Articles') }}</h2>
                                <p class="text-muted">{{ get_phrase('Deepen your knowledge with these similar topics.') }}</p>
                            </div>
                            <div class="row g-4">
                                @foreach ($related_blogs as $r_blog)
                                    <div class="col-lg-4 col-md-6">
                                        @php $blog = $r_blog; @endphp
                                        @include('frontend.default.blog.card')
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#blog-like-toggle').on('click', function() {
                $.ajax({
                    type: "get",
                    url: "{{ route('blog.like') }}",
                    data: { blog_id: "{{ $blog_details->id }}" },
                    success: function(response) {
                        let likes = parseInt($('#total-blog-likes').text());
                        if (response.like) {
                            $('#blog-like-toggle').addClass('active');
                            $('#total-blog-likes').text(likes + 1);
                        } else {
                            $('#blog-like-toggle').removeClass('active');
                            $('#total-blog-likes').text(likes - 1);
                        }
                    }
                });
            });
        });
    </script>
@endpush
