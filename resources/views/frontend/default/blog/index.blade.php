@extends('layouts.landing')
@push('title', get_phrase('Blog'))
@push('meta')@endpush
@push('css')
<style>
    .blog-hero {
        background: radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 100% 100%, rgba(6, 182, 212, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
        padding: 180px 0 80px !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .blog-listing-section { background: #f8fafc; padding: 80px 0; }
    .blog-card { background:#fff; border-radius:28px; border:none; box-shadow:0 4px 24px rgba(0,0,0,0.05); transition:transform 0.3s,box-shadow 0.3s; overflow:hidden; }
    .blog-card:hover { transform:translateY(-6px); box-shadow:0 16px 40px rgba(79,70,229,0.12); }
    .blog-card img { height:210px; object-fit:cover; width:100%; transition:transform 0.4s; }
    .blog-card:hover img { transform:scale(1.04); }
    .blog-sidebar-card { background:rgba(255,255,255,0.9); backdrop-filter:blur(16px); border-radius:24px; border:1px solid rgba(255,255,255,0.6); box-shadow:0 8px 30px rgba(0,0,0,0.04); padding:28px; }
    .breadcrumb-item a { color:var(--vibrant-primary)!important; font-weight:600; text-decoration:none; }
    .breadcrumb-item.active { color:var(--vibrant-dark)!important; font-weight:700; }
    .entry-pagination .page-link { border:none!important; border-radius:12px!important; padding:10px 18px; font-weight:700; color:var(--vibrant-dark); background:#fff; box-shadow:0 4px 10px rgba(0,0,0,0.04); }
    .entry-pagination .page-item.active .page-link { background:var(--vibrant-primary)!important; color:#fff!important; }
</style>
@endpush
@section('content')
@php $is_arabic_page = strtolower(session('language') ?? get_settings('language')) == 'arabic'; @endphp

<section class="blog-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ $is_arabic_page ? 'الرئيسية' : get_phrase('Home') }}</a></li>
                <li class="breadcrumb-item active">{{ $is_arabic_page ? 'المدونة' : get_phrase('Blog') }}</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-900 mb-2" style="letter-spacing:-1px;">{{ $is_arabic_page ? 'المدونة' : get_phrase('Blogs') }}</h1>
        <p class="text-muted mb-0 fs-5">{{ $is_arabic_page ? 'اطلع على أحدث المقالات والأخبار والرؤى التعليمية.' : get_phrase('Explore our latest articles, news, and creative insights.') }}</p>
    </div>
</section>

<div class="blog-listing-section">
    <div class="container">
        <div class="row g-5">

            <!-- Blog Grid -->
            <div class="col-lg-8">
                <div class="row g-4">
                    @foreach ($blogs as $blog)
                        <div class="col-md-6">
                            <div class="blog-card h-100">
                                <div class="overflow-hidden position-relative">
                                    <a href="{{ route('blog.details', $blog->slug) }}">
                                        <img src="{{ get_image($blog->thumbnail) }}" alt="{{ $blog->title }}">
                                    </a>
                                    <span class="position-absolute badge bg-vibrant-primary rounded-pill px-3 py-2 fw-bold"
                                          style="top:15px;{{ $is_arabic_page ? 'right' : 'left' }}:15px;z-index:2;">
                                        {{ get_blog_category_name($blog->category_id) }}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <div class="d-flex align-items-center gap-2 mb-3 text-muted small fw-bold">
                                        <i class="fa-solid fa-calendar-days text-vibrant-primary"></i>
                                        {{ date('d M, Y', strtotime($blog->created_at)) }}
                                    </div>
                                    <h5 class="fw-900 text-dark mb-3 lh-base" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                        <a href="{{ route('blog.details', $blog->slug) }}" class="text-dark text-decoration-none">{{ ucfirst($blog->title) }}</a>
                                    </h5>
                                    <p class="text-muted small mb-4" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                        {{ ellipsis(strip_tags($blog->description), 140) }}
                                    </p>
                                    <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                        <a href="{{ route('blog.details', $blog->slug) }}" class="fw-900 text-vibrant-primary text-decoration-none small">
                                            {{ $is_arabic_page ? 'اقرأ المزيد' : get_phrase('Read More') }}
                                            <i class="fa-solid fa-arrow-{{ $is_arabic_page ? 'left' : 'right' }}-long ms-1"></i>
                                        </a>
                                        <div class="d-flex gap-3 text-muted small">
                                            <span><i class="fa-solid fa-heart me-1 text-danger"></i>{{ count_likes_by_blog_id($blog->id) }}</span>
                                            <span><i class="fa-solid fa-comment me-1 text-vibrant-primary"></i>{{ count_comments_by_blog_id($blog->id) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($blogs->count() == 0)
                        <div class="col-12 bg-white rounded-4 py-5 shadow-sm text-center">
                            @include('frontend.default.empty')
                        </div>
                    @endif
                </div>

                @if(count($blogs) > 0)
                    <div class="entry-pagination mt-5 d-flex justify-content-center">{{ $blogs->links() }}</div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Search -->
                <div class="blog-sidebar-card mb-4">
                    <form action="{{ route('blogs') }}" method="get">
                        <div class="position-relative">
                            <input type="text" name="search"
                                   class="form-control rounded-pill px-4 py-3 border-0 shadow-sm"
                                   style="background:#f1f5f9;"
                                   placeholder="{{ $is_arabic_page ? 'ابحث في المدونة...' : get_phrase('Search blogs...') }}"
                                   @if(request()->has('search')) value="{{ request()->input('search') }}" @endif>
                            <button type="submit" class="position-absolute end-0 top-0 h-100 px-4"
                                    style="background:var(--vibrant-primary);color:#fff;border:none;border-radius:100px;">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
                <div class="blog-sidebar-card mb-4">
                    <h5 class="fw-900 mb-4">{{ $is_arabic_page ? 'التصنيفات' : get_phrase('Categories') }}</h5>
                    <ul class="list-unstyled mb-0" id="blog-category" style="max-height:360px;overflow:hidden;">
                        @php $active_category = request()->route()->parameter('category'); $rq = request()->query(); @endphp
                        @foreach(App\Models\BlogCategory::latest()->get() as $category)
                            @php $rq['category'] = $category->slug; @endphp
                            <li class="mb-2">
                                <a href="{{ route('blogs', $rq) }}"
                                   class="d-flex align-items-center justify-content-between p-3 rounded-4 text-decoration-none"
                                   style="{{ $category->slug == $active_category ? 'background:var(--vibrant-primary);color:#fff;' : 'background:#f8fafc;color:var(--vibrant-dark);' }}">
                                    <span class="fw-700">{{ $category->title }}</span>
                                    <span class="badge rounded-pill {{ $category->slug == $active_category ? 'bg-white text-primary' : 'bg-vibrant-primary text-white' }}">
                                        {{ count_blogs_by_category($category->id) }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-center mt-3">
                        <button id="see-more" class="btn btn-link text-vibrant-primary fw-bold text-decoration-none p-0 small">
                            {{ get_phrase('Show More') }} <i class="fa-solid fa-plus small ms-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Latest Posts -->
                <div class="blog-sidebar-card">
                    <h5 class="fw-900 mb-4">{{ $is_arabic_page ? 'أحدث المقالات' : get_phrase('Popular Posts') }}</h5>
                    <div class="d-flex flex-column gap-4">
                        @foreach(App\Models\Blog::where('status', 1)->latest()->take(4)->get() as $p_blog)
                            <a href="{{ route('blog.details', $p_blog->slug) }}" class="d-flex gap-3 text-decoration-none align-items-center">
                                <div class="rounded-3 overflow-hidden flex-shrink-0" style="width:72px;height:56px;">
                                    <img src="{{ get_image($p_blog->thumbnail) }}" class="w-100 h-100 object-fit-cover" alt="">
                                </div>
                                <div>
                                    <span class="text-muted d-block mb-1" style="font-size:0.75rem;">
                                        <i class="fa-solid fa-calendar-days me-1 text-vibrant-primary"></i>{{ date('d M, Y', strtotime($p_blog->created_at)) }}
                                    </span>
                                    <p class="text-dark fw-700 mb-0 lh-base" style="font-size:0.85rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                        {{ ucfirst($p_blog->title) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function() {
    $('#see-more').on('click', function() {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $('#blog-category').css('max-height','none');
            $(this).html('{{ get_phrase("Show Less") }} <i class="fa-solid fa-minus small ms-1"></i>');
        } else {
            $('#blog-category').css('max-height','360px');
            $(this).html('{{ get_phrase("Show More") }} <i class="fa-solid fa-plus small ms-1"></i>');
        }
    });
});
</script>
@endpush
