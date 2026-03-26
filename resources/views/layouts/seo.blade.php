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
    $meta_description = !empty($seo_field['meta_description']) ? $seo_field['meta_description'] : $site_description;
    $meta_keywords = !empty($seo_field['mets_keywords']) ? $seo_field['mets_keywords'] : $site_keywords;
@endphp

<title>@stack('title') | {{ $meta_title }}</title>
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
        $page_title = trim($__env->yieldPushContent('title'));
        $og_title = $page_title ? $page_title . ' | ' . $meta_title : $meta_title;
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
<meta property="og:image" content="{{ $og_image }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $og_title }}" />
<meta name="twitter:description" content="{{ $og_description }}" />
<meta name="twitter:image" content="{{ $og_image }}" />
