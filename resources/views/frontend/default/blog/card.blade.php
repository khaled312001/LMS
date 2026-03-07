<div class="vibrant-course-card p-3 shadow-sm border-0 bg-white radius-30 h-100 position-relative transition-all hover-translate-y">
    <div class="rounded-24 overflow-hidden mb-4 position-relative">
        <a href="{{ route('blog.details', $blog->slug) }}">
            <img src="{{ get_image($blog->thumbnail) }}" class="w-100 object-fit-cover" alt="blog-thumbnail" style="height: 220px;">
        </a>
        <span class="position-absolute top-3 start-3 badge bg-vibrant-primary rounded-pill px-3 py-2 fw-bold" style="top: 15px; left: 15px;">{{ get_blog_category_name($blog->category_id) }}</span>
    </div>
    <div class="card-body p-2">
        <div class="d-flex align-items-center gap-2 mb-3 text-muted small fw-bold">
            <i class="fa-solid fa-calendar-days text-vibrant-primary"></i>
            {{ date('d M, Y', strtotime($blog->created_at)) }}
        </div>
        <h4 class="fw-900 text-dark mb-3 ellipsis-2 lh-base">
            <a href="{{ route('blog.details', $blog->slug) }}" class="text-dark text-decoration-none hover-text-primary transition-all">{{ ucfirst($blog->title) }}</a>
        </h4>
        <p class="text-muted small mb-4 ellipsis-line-2">
            {{ ellipsis(strip_tags($blog->description), 160) }}
        </p>
        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
            <a href="{{ route('blog.details', $blog->slug) }}" class="fw-900 text-vibrant-primary text-decoration-none small">
                {{ get_phrase('Read More') }} <i class="fa-solid fa-arrow-right-long ms-2"></i>
            </a>
            <div class="d-flex gap-2">
                <span class="text-muted small"><i class="fa-solid fa-heart me-1"></i> {{ count_likes_by_blog_id($blog->id) }}</span>
                <span class="text-muted small"><i class="fa-solid fa-comment me-1"></i> {{ count_comments_by_blog_id($blog->id) }}</span>
            </div>
        </div>
    </div>
</div>
