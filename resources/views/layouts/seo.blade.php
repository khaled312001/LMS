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

@if (!empty($seo_field['meta_title']) && stripos($seo_field['meta_title'], 'Example Domain') === false)
    <title>{{ $seo_field['meta_title'] }}</title>
@else
    <title>@stack('title') | {{ config('app.name') }}</title>
@endif
<meta name="keywords" content="{{ $seo_field['mets_keywords'] ?? '' }}">
<meta name="description" content="{{ $seo_field['meta_description'] ?? '' }}">
<meta name="robots" content="{{ $seo_field['meta_robot'] ?? '' }}">
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
    
    // Use fallbacks if empty
    if (empty($og_title)) {
        if (!empty($seo_field['meta_title']) && stripos($seo_field['meta_title'], 'Example Domain') === false) {
            $og_title = $seo_field['meta_title'];
        } else {
            $og_title = config('app.name');
        }
    }
    if (empty($og_description)) {
        $og_description = $seo_field['meta_description'] ?? '';
    }
@endphp

@if (!empty($og_title))
<meta property="og:title" content="{{ $og_title }}" />
@endif
@if (!empty($og_description))
<meta property="og:description" content="{{ $og_description }}" />
@endif
@if (!empty($seo_field['og_image']))
<meta property="og:image" content="{{ get_image($seo_field['og_image']) }}" />
@endif
<meta property="og:url" content="{{ url()->current() }}" />
