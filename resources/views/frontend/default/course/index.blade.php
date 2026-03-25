@extends('layouts.landing')
@push('title', get_phrase('Courses'))
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
    .filter-card {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        border-radius: 24px !important;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important;
    }
    .course-listing-section {
        background-color: #f8fafc;
        padding: 80px 0;
    }
    .g-title {
        font-weight: 900 !important;
        letter-spacing: -1px;
    }
    .tab-list ul {
        background: rgba(0,0,0,0.03);
        padding: 5px;
        border-radius: 100px;
        display: inline-flex;
    }
    .tab-list li {
        margin: 0 !important;
    }
    .tab-list li a {
        border-radius: 100px !important;
        padding: 8px 20px !important;
        border: none !important;
        background: transparent !important;
        color: var(--vibrant-dark) !important;
        font-weight: 700;
    }
    .tab-list li.active a {
        background: #fff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
        color: var(--vibrant-primary) !important;
    }
    .entry-pagination .pagination {
        gap: 10px;
    }
    .entry-pagination .page-link {
        border: none !important;
        border-radius: 12px !important;
        padding: 12px 20px;
        font-weight: 700;
        color: var(--vibrant-dark);
        background: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    .entry-pagination .page-item.active .page-link {
        background: var(--vibrant-primary) !important;
        color: #fff !important;
    }
</style>
@endpush
@section('content')
    <!------------------- Breadcum Area Start  ------>
    <!------------------- Breadcum Area Start  ------>
    <section class="mesh-gradient-breadcrumb">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $category_details['title'] ?? get_phrase('All Courses') }}
                            </li>
                        </ol>
                    </nav>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                        <div>
                            <h1 class="display-4 g-title mb-2">{{ $category_details['title'] ?? get_phrase('All Courses') }}</h1>
                            <p class="text-muted mb-0">{{ get_phrase('Showing') . ' ' . count($courses) . ' ' . get_phrase('of') . ' ' . $courses->total() . ' ' . get_phrase('results') }}</p>
                        </div>
                        <div class="tab-list">
                            <ul>
                                <li class="@if ($layout == 'grid') active @endif">
                                    <a href="#" class="layout" id="grid">
                                        <i class="fi-rr-apps me-2"></i> {{ get_phrase('Grid') }}
                                    </a>
                                </li>
                                <li class="@if ($layout == 'list') active @endif">
                                    <a href="#" class="layout" id="list">
                                        <i class="fi-rr-list me-2"></i> {{ get_phrase('List') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->
    <!------------------- Breadcum Area End  --------->



    <!-------------- List Item Start   --------------->
    <div class="course-listing-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row g-4">
                        @foreach ($courses as $course)
                            @include('frontend.default.course.course_' . $layout)
                        @endforeach

                        @if ($courses->count() == 0)
                            <div class="col-12 bg-white radius-24 py-5 shadow-sm text-center">
                                @include('frontend.default.empty')
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                        @if (count($courses) > 0)
                            <div class="entry-pagination mt-5 d-flex justify-content-center">
                                <nav aria-label="Page navigation">
                                    {{ $courses->links() }}
                                </nav>
                            </div>
                        @endif
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
    <!-------------- List Item End  --------------->
@endsection
