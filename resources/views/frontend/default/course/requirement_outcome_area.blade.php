@php
    $requirements = [];
    if (!empty($course_details->requirements)) {
        $decoded = json_decode($course_details->requirements);
        $requirements = is_array($decoded) ? $decoded : (is_object($decoded) ? (array) $decoded : []);
    }

    $outcomes = [];
    if (!empty($course_details->outcomes)) {
        $decoded = json_decode($course_details->outcomes);
        $outcomes = is_array($decoded) ? $decoded : (is_object($decoded) ? (array) $decoded : []);
    }

    $technologies = [];
    if (!empty($course_details->technologies)) {
        $decoded = json_decode($course_details->technologies);
        $technologies = is_array($decoded) ? $decoded : (is_object($decoded) ? (array) $decoded : []);
    }
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';

    $sba_detail_sections = [
        [
            'title'       => $is_arabic ? 'ماذا ستتعلم؟' : get_phrase('What you will learn'),
            'subtitle'    => $is_arabic ? 'مهارات وقدرات ستكتسبها من هذه الدورة' : get_phrase('Skills you will gain from this course'),
            'icon'        => 'fi-rr-star-octogram',
            'items'       => $outcomes,
            'empty_label' => $is_arabic ? 'لم يتم إدراج نتائج لهذه الدورة' : get_phrase('No outcomes listed for this course'),
            'color'       => '#f59e0b',
            'tint'        => '#fef3c7',
            'tint_border' => '#fde68a',
            'gradient'    => 'linear-gradient(135deg, #f59e0b 0%, #f97316 100%)',
            'item_icon'   => 'fi-rr-bulb',
        ],
        [
            'title'       => $is_arabic ? 'التقنيات والأدوات' : get_phrase('Technologies & Tools'),
            'subtitle'    => $is_arabic ? 'الأدوات التي ستعمل بها طوال الدورة' : get_phrase('Tools you will work with throughout the course'),
            'icon'        => 'fi-rr-settings',
            'items'       => $technologies,
            'empty_label' => $is_arabic ? 'لم يتم إدراج تقنيات' : get_phrase('No technologies listed'),
            'color'       => '#0ea5e9',
            'tint'        => '#e0f2fe',
            'tint_border' => '#bae6fd',
            'gradient'    => 'linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%)',
            'item_icon'   => 'fi-rr-check',
        ],
        [
            'title'       => $is_arabic ? 'المتطلبات' : get_phrase('Requirements'),
            'subtitle'    => $is_arabic ? 'ما تحتاجه قبل بدء الدورة' : get_phrase('What you need before starting'),
            'icon'        => 'fi-rr-list-check',
            'items'       => $requirements,
            'empty_label' => $is_arabic ? 'لا توجد متطلبات لهذه الدورة' : get_phrase('No requirements listed for this course'),
            'color'       => '#6366f1',
            'tint'        => '#e0e7ff',
            'tint_border' => '#c7d2fe',
            'gradient'    => 'linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%)',
            'item_icon'   => 'fi-rr-check',
        ],
    ];
@endphp

<style>
    .sba-detail-card {
        background: #fff;
        border: 1px solid #eef1f6;
        border-radius: 24px;
        overflow: hidden;
        transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
        position: relative;
    }

    .sba-detail-card:hover {
        transform: translateY(-4px);
        border-color: transparent;
        box-shadow: 0 25px 50px -18px rgba(15, 23, 42, 0.18);
    }

    .sba-detail-card .sba-detail-header {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 26px 28px;
        position: relative;
        background: #f8fafc;
        border-bottom: 1px solid #eef1f6;
    }

    .sba-detail-card .sba-detail-icon {
        flex: 0 0 auto;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        color: #fff;
        font-size: 1.5rem;
        box-shadow: 0 10px 22px -10px rgba(15, 23, 42, 0.35);
    }

    .sba-detail-card .sba-detail-meta h4 {
        font-weight: 800;
        font-size: 1.25rem;
        color: #0f172a;
        margin: 0 0 4px;
        line-height: 1.3;
    }

    .sba-detail-card .sba-detail-meta p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .sba-detail-card .sba-detail-count {
        margin-inline-start: auto;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 6px 14px;
        font-weight: 800;
        color: #0f172a;
        font-size: 0.85rem;
        box-shadow: 0 4px 10px -6px rgba(15, 23, 42, 0.2);
    }

    .sba-detail-body {
        padding: 24px 28px 28px;
    }

    .sba-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px 28px;
    }

    @media (max-width: 640px) {
        .sba-detail-grid {
            grid-template-columns: 1fr;
        }

        .sba-detail-card .sba-detail-header {
            padding: 20px;
        }

        .sba-detail-body {
            padding: 18px 20px 22px;
        }
    }

    .sba-detail-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 8px 0;
    }

    .sba-detail-item .sba-item-check {
        flex: 0 0 auto;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        margin-top: 3px;
    }

    .sba-detail-item p {
        margin: 0;
        color: #1e293b;
        font-size: 0.95rem;
        line-height: 1.55;
    }

    .sba-detail-empty {
        padding: 18px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        color: #64748b;
        font-size: 0.92rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

@php
    $sba_visible_sections = array_filter($sba_detail_sections, function ($s) {
        return !empty($s['items']) && is_array($s['items']);
    });
@endphp

@if (count($sba_visible_sections) > 0)
    <div class="d-flex flex-column gap-4 animate__animated animate__fadeIn">
        @foreach ($sba_visible_sections as $section)
            <div class="sba-detail-card">
                <div class="sba-detail-header">
                    <div class="sba-detail-icon" style="background: {{ $section['gradient'] }};">
                        <i class="{{ $section['icon'] }}"></i>
                    </div>
                    <div class="sba-detail-meta">
                        <h4>{{ $section['title'] }}</h4>
                        <p>{{ $section['subtitle'] }}</p>
                    </div>
                    <span class="sba-detail-count">{{ count($section['items']) }}</span>
                </div>
                <div class="sba-detail-body">
                    <div class="sba-detail-grid">
                        @foreach ($section['items'] as $item)
                            <div class="sba-detail-item">
                                <span class="sba-item-check"
                                    style="background: {{ $section['tint'] }}; border: 1px solid {{ $section['tint_border'] }}; color: {{ $section['color'] }};">
                                    <i class="{{ $section['item_icon'] }}"></i>
                                </span>
                                <p>{{ $item }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="sba-detail-empty" style="padding: 32px; text-align: center;">
        <i class="fi-rr-info fs-3 d-block mb-2"></i>
        <span>{{ $is_arabic ? 'لا توجد تفاصيل إضافية لهذه الدورة' : get_phrase('No additional details for this course') }}</span>
    </div>
@endif
