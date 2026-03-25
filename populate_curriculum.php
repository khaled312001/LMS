<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$courses = DB::table('courses')->get();

foreach ($courses as $course) {
    // Check if this course already has any sections
    $exists = DB::table('sections')->where('course_id', $course->id)->exists();
    if ($exists) continue;

    echo "Populating curriculum for: " . $course->title . "\n";

    $curriculum = [];

    // Define sections based on course type/title
    if (str_contains(strtolower($course->title), 'web') || str_contains(strtolower($course->title), 'front') || str_contains(strtolower($course->title), 'برمج')) {
        $curriculum = [
            'المرحلة الأولى: الأساسيات والمدخل' => ['مقدمة في عالم البرمجة', 'تجهيز بيئة العمل', 'نظرة عامة على التقنيات المستخدمة'],
            'المرحلة الثانية: بناء الواجهات' => ['أساسيات لغة HTML5', 'تنسيق الصفحات باستخدام CSS3', 'استخدام تقنيات التصميم المتجاوب'],
            'المرحلة الثالثة: تطوير المشاريع' => ['بدء مشروع حقيقي', 'أفضل الممارسات في كتابة الكود', 'الخلاصة والخطوات القادمة']
        ];
    } elseif (str_contains(strtolower($course->title), 'market') || str_contains(strtolower($course->title), 'تسويق')) {
        $curriculum = [
            'القسم الأول: استراتيجيات التسويق الحديثة' => ['أساسيات التسويق الرقمي', 'تحليل السوق والمنافسين', 'تحديد الجمهور المستهدف بدقة'],
            'القسم الثاني: استخدام الذكاء الاصطناعي' => ['أدوات الذكاء الاصطناعي في التسويق', 'أتمتة الحملات الإعلانية', 'تحليل البيانات الضخمة'],
            'القسم الثالث: قياس النتائج' => ['متابعة أداء الحملات', 'تحسين معدل التحويل', 'مستقبل التسويق']
        ];
    } elseif (str_contains(strtolower($course->title), 'design') || str_contains(strtolower($course->title), 'تصميم')) {
        $curriculum = [
            'الوحدة الأولى: مبادئ التصميم' => ['أساسيات نظرية الألوان', 'الخطوط وتنسيق النصوص', 'أساسيات تجربة المستخدم UX'],
            'الوحدة الثانية: أدوات التصميم الذكية' => ['استخدام Figma و Adobe', 'توظيف الذكاء الاصطناعي في التصميم', 'سرعة الإنجاز وجودة المخرجات'],
            'الوحدة الثالثة: الملف الشخصي' => ['بناء معرض أعمال احترافي', 'نصائح للعمل الحر', 'المراجعة النهائية']
        ];
    } elseif (str_contains(strtolower($course->title), 'sale') || str_contains(strtolower($course->title), 'مبيع')) {
        $curriculum = [
            'المقدمة: فن البيع' => ['علم نفس المبيعات', 'مهارات الإقناع والتأثير', 'أنواع العملاء وكيفية التعامل معهم'],
            'التنفيذ: العمليات البيعية' => ['إدارة قمع المبيعات', 'التعامل مع الاعتراضات', 'إغلاق الصفقات بنجاح'],
            'ما بعد البيع: ولاء العميل' => ['بناء علاقات طويلة الأمد', 'خدمة العملاء الاحترافية', 'تطوير الفريق البيعي']
        ];
    } else {
        // Generic Curriculum
        $curriculum = [
            'القسم الأول: البداية' => ['مقدمة عن الدورة', 'الأدوات المطلوبة', 'الخطة التدريبية'],
            'القسم الثاني: التطبيق العملي' => ['بدء التطبيق خطوة بخطوة', 'نصائح الخبراء', 'تجنب الأخطاء الشائعة'],
            'القسم الثالث: الإتمام' => ['مراجعة الدروس الأساسية', 'المشروع النهائي', 'الحصول على الشهادة']
        ];
    }

    foreach ($curriculum as $section_title => $lessons) {
        $section_id = DB::table('sections')->insertGetId([
            'course_id' => $course->id,
            'title' => $section_title,
            'sort' => 0,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($lessons as $lesson_title) {
            DB::table('lessons')->insert([
                'course_id' => $course->id,
                'section_id' => $section_id,
                'title' => $lesson_title,
                'duration' => '2:00:00',
                'sort' => 0,
                'user_id' => 1,
                'lesson_type' => 'video',
                'is_free' => 0,
                'lesson_src' => '',
                'video_type' => 'system',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
