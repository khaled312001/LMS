<div class="vibrant-sidebar">
    <!-- Search Widget -->
    <div class="filter-widget mb-4 pb-3 border-bottom">
        <form action="{{ route('blogs') }}" method="get">
            <div class="position-relative">
                <input type="text" name="search" class="form-control rounded-pill px-4 py-3 border-0 bg-white shadow-sm" style="padding-right: 50px;" placeholder="{{ get_phrase('Search blogs...') }}" @if (request()->has('search')) value="{{ request()->input('search') }}" @endif>
                <button type="submit" class="btn btn-vibrant position-absolute end-0 top-0 h-100 rounded-pill px-3">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Category Widget -->
    <div class="filter-widget mb-4 pb-3 border-bottom">
        <h5 class="fw-bold mb-4">{{ get_phrase('Categories') }}</h5>
        <ul class="list-unstyled mb-0" id="blog-category" style="max-height: 400px; overflow: hidden;">
            @php
                $active_category = request()->route()->parameter('category');
                $route_queries = request()->query();
            @endphp
            @foreach (App\Models\BlogCategory::latest()->get() as $category)
                @php $route_queries['category'] = $category->slug; @endphp
                <li class="mb-2">
                    <a href="{{ route('blogs', $route_queries) }}" class="d-flex align-items-center justify-content-between p-3 rounded-4 transition-all text-decoration-none {{ $category->slug == $active_category ? 'bg-vibrant-primary text-white shadow-lg' : 'bg-white text-dark hover-translate-x' }}">
                        <span class="fw-bold">{{ $category->title }}</span>
                        <span class="badge rounded-pill {{ $category->slug == $active_category ? 'bg-white text-primary' : 'bg-vibrant-primary' }}">{{ count_blogs_by_category($category->id) }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="text-center mt-3">
            <button id="see-more" class="btn btn-link text-vibrant-primary fw-bold text-decoration-none p-0">
                {{ get_phrase('Show More') }} <i class="fa-solid fa-plus small ms-1"></i>
            </button>
        </div>
    </div>

    <!-- Popular Posts -->
    <div class="filter-widget mb-4 pb-3 border-bottom">
        <h5 class="fw-bold mb-4">{{ get_phrase('Popular Posts') }}</h5>
        <div class="d-flex flex-column gap-4">
            @foreach (App\Models\Blog::where('status', 1)->latest()->take(3)->get() as $p_blog)
                <a href="{{ route('blog.details', $p_blog->slug) }}" class="d-flex gap-3 text-decoration-none group">
                    <div class="rounded-3 overflow-hidden" style="width: 80px; height: 60px; flex-shrink: 0;">
                        <img src="{{ get_image($p_blog->thumbnail) }}" class="w-100 h-100 object-fit-cover transition-all group-hover-scale" alt="thumb">
                    </div>
                    <div>
                        <span class="text-muted small d-block mb-1">{{ date('d M, Y', strtotime($p_blog->created_at)) }}</span>
                        <h6 class="text-dark fw-bold ellipsis-2 mb-0 transition-all group-hover-text-primary small lh-base">{{ ucfirst($p_blog->title) }}</h6>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Tags Widget -->
    <div class="filter-widget">
        <h5 class="fw-bold mb-4">{{ get_phrase('Tags') }}</h5>
        <div class="d-flex flex-wrap gap-2">
            @foreach (get_blog_tags() as $tag)
                <a href="{{ route('blogs', ['tag' => $tag]) }}" class="badge rounded-pill border-0 px-3 py-2 transition-all {{ (isset($_GET['tag']) && $_GET['tag'] == $tag) ? 'bg-vibrant-primary text-white' : 'bg-white text-dark shadow-sm hover-bg-primary' }}">
                    {{ ucfirst($tag) }}
                </a>
            @endforeach
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        $('#see-more').on('click', function() {
            $(this).toggleClass('active');
            if($(this).hasClass('active')) {
                $('#blog-category').css('max-height', 'none');
                $(this).html('{{ get_phrase("Show Less") }} <i class="fa-solid fa-minus small ms-1"></i>');
            } else {
                $('#blog-category').css('max-height', '400px');
                $(this).html('{{ get_phrase("Show More") }} <i class="fa-solid fa-plus small ms-1"></i>');
            }
        });
    });
</script>
@endpush
