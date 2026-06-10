<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

{{ config(['app.name' => get_settings('system_title')]) }}

@php
    //print SEO field values from database 'seo_field table', based on current route
    $current_route = Route::currentRouteName();
    $seo_field = App\Models\SeoField::where('name_route', $current_route);
    
    if($current_route == 'course.details' && isset($course_details)){
        $seo_field->where('course_id', $course_details->id ?? '');
    }
    if($current_route == 'blog.details' && isset($blog_details)){
        $seo_field->where('blog_id', $blog_details->id ?? '');
    }

    $seo_field = $seo_field->firstOrNew();
@endphp

@php
    // Filter out example.com and example.org URLs
    $canonical_url = $seo_field['canonical_url'] ?? '';
    $custom_url = $seo_field['custom_url'] ?? '';
    
    // Remove example.com/example.org URLs
    if (stripos($canonical_url, 'example.com') !== false || stripos($canonical_url, 'example.org') !== false) {
        $canonical_url = '';
    }
    if (stripos($custom_url, 'example.com') !== false || stripos($custom_url, 'example.org') !== false) {
        $custom_url = '';
    }
    
    // Use current URL as fallback for canonical if not set or invalid
    if (empty($canonical_url)) {
        $canonical_url = url()->current();
    }
@endphp

@php
    $site_name = get_settings('system_title') ?: 'Swiss Bridge Academy';
    $site_description = get_settings('website_description') ?: 'مرحبًا بكم في منصتنا التعليمية الرائدة التي تتيح لكم تعلم البرمجة, التصميم, التسويق بمزيج من العربية والإنجليزية تديرها إدارة سويسرية.';
    $site_keywords = get_settings('website_keywords') ?: 'تعليم, كورس, دورة, تطوير ويب, تصميم, تسويق إلكتروني, سويسرا, Swiss Bridge Academy';
    $meta_title = !empty($seo_field['meta_title']) && stripos($seo_field['meta_title'], 'Example Domain') === false ? $seo_field['meta_title'] : $site_name;

    // Per-page description: admin-defined first, then content-derived, then site default
    if (!empty($seo_field['meta_description'])) {
        $meta_description = $seo_field['meta_description'];
    } elseif (isset($course_details) && !empty(strip_tags($course_details->short_description ?? $course_details->description ?? ''))) {
        $meta_description = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($course_details->short_description ?? $course_details->description))), 160);
    } elseif (isset($blog_details) && !empty(strip_tags($blog_details->description ?? ''))) {
        $meta_description = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($blog_details->description))), 160);
    } elseif (isset($bootcamp_details) && !empty(strip_tags($bootcamp_details->short_description ?? $bootcamp_details->description ?? ''))) {
        $meta_description = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($bootcamp_details->short_description ?? $bootcamp_details->description))), 160);
    } else {
        $meta_description = $site_description;
    }

    $meta_keywords = !empty($seo_field['mets_keywords']) ? $seo_field['mets_keywords'] : $site_keywords;
@endphp

@php
    // Build a meaningful per-page title: real content titles beat generic pushed
    // titles like "Course Details", which beat the route-based fallbacks
    if (isset($course_details) && !empty($course_details->title)) {
        $page_title = $course_details->title;
    } elseif (isset($blog_details) && !empty($blog_details->title)) {
        $page_title = $blog_details->title;
    } elseif (isset($bootcamp_details) && !empty($bootcamp_details->title)) {
        $page_title = $bootcamp_details->title;
    } else {
        $page_title = trim(strip_tags($__env->yieldPushContent('title')));
    }

    if (empty($page_title)) {
        if (!empty($seo_field['meta_title']) && stripos($seo_field['meta_title'], 'Example Domain') === false && $seo_field['meta_title'] != $site_name) {
            $page_title = $seo_field['meta_title'];
        } else {
            $route_phrases = [
                'courses'                => 'Courses',
                'blogs'                  => 'Blogs',
                'about.us'               => 'About Us',
                'contact.us'             => 'Contact Us',
                'instructors'            => 'Instructors',
                'instructor.details'     => 'Instructor Details',
                'bootcamps'              => 'Bootcamps',
                'team.packages'          => 'Team Packages',
                'tutor_list'             => 'Tutors',
                'login'                  => 'Log In',
                'register'               => 'Sign Up',
                'compare'                => 'Compare Courses',
                'knowledge.base.topicks' => 'Knowledge Base',
            ];
            $path_phrases = [
                'faq'                 => 'FAQ',
                'privacy-policy'      => 'Privacy Policy',
                'refund-policy'       => 'Refund Policy',
                'terms-and-condition' => 'Terms And Condition',
                'cookie-policy'       => 'Cookie Policy',
            ];
            if (isset($route_phrases[$current_route])) {
                $page_title = get_phrase($route_phrases[$current_route]);
            } elseif (isset($path_phrases[request()->path()])) {
                $page_title = get_phrase($path_phrases[request()->path()]);
            }
        }
    }

    // Avoid "Site Name | Site Name" when a view pushes the site name as its title
    if (!empty($page_title) && strcasecmp(trim($page_title), trim($site_name)) === 0) {
        $page_title = '';
    }

    $full_title = !empty($page_title) ? $page_title . ' | ' . $site_name : $meta_title;
@endphp

<title>{{ $full_title }}</title>
<meta name="keywords" content="{{ $meta_keywords }}">
<meta name="description" content="{{ $meta_description }}">
<meta name="robots" content="{{ $seo_field['meta_robot'] ?? 'index, follow' }}">
@if (!empty($canonical_url) && stripos($canonical_url, 'example.com') === false && stripos($canonical_url, 'example.org') === false)
<link rel="canonical" href="{{ $canonical_url }}" />
@endif
@if (!empty($custom_url) && stripos($custom_url, 'example.com') === false && stripos($custom_url, 'example.org') === false)
<link rel="custom" href="{{ $custom_url }}" />
@endif
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
@if (!empty($seo_field['meta_title']) && stripos($seo_field['meta_title'], 'Example Domain') === false)
<meta name="apple-mobile-web-app-title" content="{{ $seo_field['meta_title'] }}">
@else
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
@endif

@if (!empty($seo_field['json_ld']) && stripos($seo_field['json_ld'], 'example.com') === false && stripos($seo_field['json_ld'], 'example.org') === false)
<script type="application/ld+json">{!! $seo_field['json_ld'] !!}</script>
@else
    {{-- Auto-generated structured data when no custom JSON-LD is set --}}
    @if (isset($course_details) && !empty($course_details->id))
        <script type="application/ld+json">{!! json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'Course',
            'name'        => $course_details->title,
            'description' => \Illuminate\Support\Str::limit(strip_tags($course_details->short_description ?? $course_details->description ?? ''), 500),
            'url'         => url()->current(),
            'image'       => get_image($course_details->thumbnail),
            'inLanguage'  => strtolower($course_details->language ?? '') == 'arabic' ? 'ar' : 'en',
            'provider'    => [
                '@type' => 'EducationalOrganization',
                'name'  => $site_name,
                'url'   => url('/'),
            ],
            'offers'      => [
                '@type'         => 'Offer',
                'category'      => $course_details->is_paid ? 'Paid' : 'Free',
                'price'         => $course_details->is_paid ? (string) ($course_details->discount_flag ? $course_details->discounted_price : $course_details->price) : '0',
                'priceCurrency' => get_settings('system_currency') ?: 'USD',
                'availability'  => 'https://schema.org/InStock',
                'url'           => url()->current(),
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @elseif (isset($blog_details) && !empty($blog_details->id))
        <script type="application/ld+json">{!! json_encode([
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'headline'         => $blog_details->title,
            'description'      => \Illuminate\Support\Str::limit(strip_tags($blog_details->description ?? ''), 300),
            'image'            => !empty($blog_details->thumbnail) ? get_image($blog_details->thumbnail) : asset(get_frontend_settings('dark_logo')),
            'datePublished'    => !empty($blog_details->created_at) ? date('c', strtotime($blog_details->created_at)) : null,
            'dateModified'     => !empty($blog_details->updated_at) ? date('c', strtotime($blog_details->updated_at)) : null,
            'mainEntityOfPage' => url()->current(),
            'inLanguage'       => strtolower($blog_details->language ?? 'arabic') == 'arabic' ? 'ar' : 'en',
            'author'           => ['@type' => 'Organization', 'name' => $site_name],
            'publisher'        => [
                '@type' => 'Organization',
                'name'  => $site_name,
                'logo'  => ['@type' => 'ImageObject', 'url' => asset(get_frontend_settings('dark_logo'))],
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @elseif ($current_route == 'home')
        <script type="application/ld+json">{!! json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'EducationalOrganization',
            'name'        => $site_name,
            'url'         => url('/'),
            'logo'        => asset(get_frontend_settings('dark_logo')),
            'description' => $site_description,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => $site_name,
            'url'      => url('/'),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endif
@endif

@php
    $og_title = $seo_field['og_title'] ?? '';
    $og_description = $seo_field['og_description'] ?? '';
    
    // Filter out Example Domain from OG tags
    if (stripos($og_title, 'Example Domain') !== false) {
        $og_title = '';
    }
    if (stripos($og_description, 'Example Domain') !== false) {
        $og_description = '';
    }
    
    // Use course/blog data if on a detail page
    if (isset($course_details) && !empty($course_details)) {
        $og_title       = $og_title       ?: $course_details->title . ' | ' . $site_name;
        $og_description = $og_description ?: strip_tags($course_details->short_description ?? $course_details->description ?? '');
    } elseif (isset($blog_details) && !empty($blog_details)) {
        $og_title       = $og_title       ?: ($blog_details->title ?? '') . ' | ' . $site_name;
        $og_description = $og_description ?: strip_tags($blog_details->description ?? '');
    }

    // Use fallbacks if still empty
    if (empty($og_title)) {
        $og_title = $full_title;
    }
    if (empty($og_description)) {
        $og_description = $meta_description;
    }

    // OG image: prefer course thumbnail, then seo_field image, then site logo
    if (isset($course_details) && !empty($course_details->thumbnail)) {
        $og_image = get_image($course_details->thumbnail);
    } elseif (!empty($seo_field['og_image'])) {
        $og_image = get_image($seo_field['og_image']);
    } else {
        $og_image = asset(get_frontend_settings('dark_logo'));
    }
@endphp

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ isset($course_details) ? 'article' : 'website' }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $og_title }}" />
<meta property="og:description" content="{{ $og_description }}" />
<meta property="og:site_name" content="{{ $site_name }}" />
@php
    $active_language = strtolower(session('language') ?? get_settings('language') ?? 'arabic');
    $og_locale = $active_language == 'arabic' ? 'ar_AR' : 'en_US';
@endphp
<meta property="og:locale" content="{{ $og_locale }}" />
<meta property="og:image" content="{{ $og_image }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $og_title }}" />
<meta name="twitter:description" content="{{ $og_description }}" />
<meta name="twitter:image" content="{{ $og_image }}" />
