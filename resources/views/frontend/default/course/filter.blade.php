<div class="vibrant-sidebar">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <h5 class="fw-bold mb-0">{{get_phrase('Filter')}}</h5>
        @if(count(request()->all()) > 0 || !empty($category_details))
            <a class="btn btn-sm btn-outline-danger rounded-pill px-3" href="{{route('courses')}}">
                <i class="fi-rr-cross-circle me-1"></i> {{get_phrase('Clear')}}
            </a>
        @endif
    </div>

    <form class="mb-4" action="{{ route('courses') }}" method="get">
        <div class="search-widget mb-4">
            <div class="position-relative">
                <input type="text" class="form-control rounded-pill ps-4 pe-5 py-3 border-0 shadow-sm" name="search" placeholder="{{ get_phrase('Search...') }}"
                    @if (request()->has('search')) value="{{ request()->input('search') }}" @endif style="background: rgba(0,0,0,0.03);">
                <button type="submit" class="position-absolute top-50 end-0 translate-middle-y me-2 btn btn-vibrant rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-magnifying-glass fs-6"></i>
                </button>
            </div>
        </div>
    </form>

    <style>
        .filter-section-title {
            font-size: 0.95rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--vibrant-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .filter-section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(0,0,0,0.05);
        }
        .vibrant-filter-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }
        .vibrant-filter-list li {
            margin-bottom: 12px;
        }
        .vibrant-filter-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-radius: 12px;
            color: var(--vibrant-dark);
            text-decoration: none !important;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .vibrant-filter-link:hover, .vibrant-filter-link.active {
            background: var(--vibrant-primary);
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }
        .vibrant-filter-link span:last-child {
            background: rgba(0,0,0,0.05);
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
        }
        .vibrant-filter-link.active span:last-child {
            background: rgba(255,255,255,0.2);
        }
        .custom-radio-group .form-check {
            padding: 8px 12px;
            border-radius: 10px;
            transition: all 0.2s ease;
            margin-bottom: 5px;
            border: 1px solid transparent;
        }
        .custom-radio-group .form-check:hover {
            background: rgba(0,0,0,0.02);
            border-color: rgba(0,0,0,0.05);
        }
        .custom-radio-group .form-check-input:checked + .form-check-label {
            color: var(--vibrant-primary);
            font-weight: 700;
        }
    </style>

    <!------------------- categories start ------------------->
    <div class="filter-widget">
        <h6 class="filter-section-title">{{ get_phrase('Categories') }}</h6>
        <ul class="vibrant-filter-list" id="parent-category">
            @php
                $parent_categories = App\Models\Category::where('parent_id', 0)->get();
                $active_category = request()->route()->parameter('category');
                $route_queries = request()->query();
                $route_queries = collect($route_queries)->except('page')->all();
            @endphp
            @foreach ($parent_categories as $parent_category)
                @php $route_queries['category'] = $parent_category->slug; @endphp

                <li>
                    <a href="{{ route('courses', $route_queries) }}"
                        class="vibrant-filter-link @if ($parent_category->slug == $active_category) active @endif">
                        <span>{{ $parent_category->title }}</span>
                        <span>{{ count_category_courses($parent_category->id) }}</span>
                    </a>
                    
                    @php $children = App\Models\Category::where('parent_id', $parent_category->id)->get(); @endphp
                    @if($children->count() > 0)
                        <ul class="list-unstyled ms-3 mt-2">
                             @foreach ($children as $child_category)
                                @php $route_queries['category'] = $child_category->slug; @endphp
                                <li class="mb-1">
                                    <a href="{{ route('courses', $route_queries) }}"
                                        class="vibrant-filter-link py-1 px-3 @if ($child_category->slug == $active_category) active @endif" style="font-size: 0.85rem;">
                                        <span>{{ $child_category->title }}</span>
                                        <span>{{ count_category_courses($child_category->id) }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <!------------------- categories end ------------------->


    <form action="{{ route('courses', request()->route()->parameter('category')) }}" method="get" id="filter-courses">
        @if (request()->has('search'))
            <input type="hidden" name="search" value="{{ request()->input('search') }}">
        @endif

        <!------------------- price filter start ------------------->
        <div class="filter-widget">
            <h6 class="filter-section-title">{{ get_phrase('Price') }}</h6>
            <div class="custom-radio-group mb-4">
                @foreach (['paid', 'discount', 'free'] as $price)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="price"
                            value="{{ $price }}" id="price-{{ $price }}"
                            @if (request()->has('price') && request()->input('price') == $price) checked @endif />
                        <label class="form-check-label w-100 cursor-pointer" for="price-{{ $price }}">
                            {{ get_phrase(ucfirst($price)) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <!------------------- price filter end ------------------->

        <!------------------- level filter start ------------------->
        <div class="filter-widget">
            <h6 class="filter-section-title">{{ get_phrase('Level') }}</h6>
            <div class="custom-radio-group mb-4">
                @foreach (['beginner', 'intermediate', 'advanced'] as $level)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="level"
                            value="{{ $level }}" id="level-{{ $level }}"
                            @if (request()->has('level') && request()->input('level') == $level) checked @endif />
                        <label class="form-check-label w-100 cursor-pointer" for="level-{{ $level }}">
                            {{ get_phrase(ucfirst($level)) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <!------------------- level filter end ------------------->

        <!------------------- language filter start ------------------->
        <div class="filter-widget">
            <h6 class="filter-section-title">{{ get_phrase('language') }}</h6>
            <div class="custom-radio-group mb-4">
                @php $languages = App\Models\Language::get(); @endphp
                @foreach ($languages as $language)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="language"
                            value="{{ slugify($language->name) }}" id="language-{{ slugify($language->name) }}"
                            @if (request()->has('language') && request()->input('language') == slugify($language->name)) checked @endif />
                        <label class="form-check-label w-100 cursor-pointer" for="language-{{ slugify($language->name) }}">
                            {{ get_phrase(ucfirst($language->name)) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <!------------------- language filter end ------------------->

        <!------------------- ratings start ------------------->
        <div class="filter-widget">
            <h6 class="filter-section-title">{{ get_phrase('Ratings') }}</h6>
            <div class="custom-radio-group">
                @for ($i = 5; $i >= 1; $i--)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rating" value="{{ $i }}"
                            id="raging-{{ $i }}" @if (request()->has('rating') && request()->input('rating') == $i) checked @endif />
                        <label class="form-check-label w-100 cursor-pointer" for="raging-{{ $i }}">
                            <div class="d-flex gap-1 text-warning">
                                @for ($j = 1; $j <= 5; $j++)
                                    <i class="fa fa-star @if ($j > $i) text-secondary opacity-25 @endif" style="font-size: 0.8rem;"></i>
                                @endfor
                            </div>
                        </label>
                    </div>
                @endfor
            </div>
        </div>
        <!------------------- ratings end ------------------->
    </form>
</div>


@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('#see-more').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('active');
                let show_more = $(this).html();

                if ($(this).hasClass('active')) {
                    $(this).css('margin-top', '20px');
                    $(this).text('{{ get_phrase('Show Less') }}');
                } else {
                    $(this).css('margin-top', '0px');
                    $(this).html('{{ get_phrase('Show More') }}');
                }
            });

            var scrollTop = $(".scrollTop");
            $(scrollTop).on('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 100);
                return false;
            });

            $('input[type="radio"]').change(function(e) {
                $('#filter-courses').trigger('submit');
            });
        });
    </script>
@endpush
