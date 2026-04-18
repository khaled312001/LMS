<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;

// ============================================
// Arabic twin of course 25 (English)
// ============================================
$course = new Course();
$course->title = 'تطوير الويب والمتاجر الإلكترونية Full Stack بأدوات الذكاء الاصطناعي';
$course->slug = 'full-stack-web-ecommerce-ai-arabic-' . rand(100, 999);
$course->short_description = 'أتقن تطوير الويب والمتاجر الإلكترونية Full Stack باستخدام أدوات الذكاء الاصطناعي. ابنِ مشاريع حقيقية بـ Laravel و MERN و WordPress ثم انشرها على Hostinger.';
$course->user_id = 4;
$course->category_id = 1;
$course->course_type = 'general';
$course->status = 'active';
$course->level = 'intermediate';
$course->language = 'arabic';
$course->is_paid = 1;
$course->is_best = 1;
$course->price = 299.99;
$course->discounted_price = 199.99;
$course->discount_flag = 1;
$course->enable_drip_content = 0;
$course->meta_keywords = 'تطوير الويب, برمجة المواقع, Full Stack, Laravel, MERN, WordPress, متاجر إلكترونية, Hostinger, ذكاء اصطناعي, Cursor, ChatGPT, MySQL, MongoDB, React, Node.js, TypeScript';
$course->meta_description = 'معسكر تدريبي من 24 درساً يأخذك من الصفر إلى إطلاق مواقع ومتاجر إلكترونية احترافية باستخدام أدوات الذكاء الاصطناعي عبر ثلاث تقنيات: Laravel و MERN و WordPress، مع النشر المباشر على Hostinger.';
$course->thumbnail = 'uploads/course-thumbnail/complete-web-development-bootcamp-1768997398.jpg';
$course->banner = 'uploads/course-banner/complete-web-development-bootcamp-1768997398.jpg';
$course->description = '<p><strong>المعسكر التدريبي الكامل لتطوير الويب Full Stack بأدوات الذكاء الاصطناعي (24 درساً).</strong></p>
<p>انتقل من الصفر المطلق إلى إطلاق مواقع ومتاجر إلكترونية حقيقية بمساعدة أدوات الذكاء الاصطناعي الحديثة مثل Cursor و ChatGPT و GitHub Copilot و Claude. ستبني نفس مشروع المتجر الإلكتروني <em>ثلاث مرات</em> باستخدام ثلاث تقنيات مختلفة:</p>
<ol>
<li><strong>Laravel Stack</strong> — PHP 8, MySQL, Blade, Laravel 11</li>
<li><strong>MERN Stack</strong> — MongoDB, Express, React, Node.js, TypeScript</li>
<li><strong>WordPress Stack</strong> — WordPress + WooCommerce + قوالب مخصصة</li>
</ol>
<p>كل درس عبارة عن جلسة تدريبية متعمقة لعدة ساعات تحتوي على شرائح تفاعلية، وشرح للكود، ومخططات، وتدفقات عمل مدعومة بالذكاء الاصطناعي. في النهاية ستقوم بنشر متجر إلكتروني كامل على <strong>Hostinger</strong> مع قاعدة بيانات MySQL حية، وشهادة SSL، ودومين مخصص، وتكامل مع بوابات الدفع.</p>';
$course->requirements = json_encode([
    'جهاز كمبيوتر متصل بالإنترنت (Windows أو Mac أو Linux)',
    'إلمام بسيط باستخدام متصفح الإنترنت',
    'لا تحتاج خبرة سابقة في البرمجة',
    'حساب Hostinger اختياري لدرس النشر النهائي',
    'الاستعداد لاستخدام أدوات الذكاء الاصطناعي (النسخ المجانية من ChatGPT/Claude/Cursor كافية)'
]);
$course->outcomes = json_encode([
    'بناء مواقع كاملة ومتجاوبة باستخدام HTML5 و CSS3 و JavaScript و Bootstrap و Tailwind',
    'إتقان React مع TypeScript لتطبيقات الصفحة الواحدة الحديثة',
    'بناء واجهات APIs على الخادم باستخدام PHP و Laravel و Node.js و Express',
    'تصميم قواعد البيانات والاستعلام منها في MySQL و MongoDB',
    'إطلاق ثلاثة مشاريع متاجر إلكترونية كاملة: Laravel و MERN و WordPress',
    'استخدام Cursor AI و GitHub Copilot و ChatGPT و Claude لمضاعفة سرعة البرمجة 10 أضعاف',
    'تكامل بوابات الدفع الحقيقية (Stripe و PayPal و Razorpay)',
    'نشر المواقع الإنتاجية على Hostinger بدومين مخصص و SSL و MySQL',
    'تطبيق SEO وتعزيز الأمان وتحسين الأداء',
    'قراءة وتصحيح وإعادة هيكلة الكود بمساعدة مساعدات الذكاء الاصطناعي'
]);
$course->faqs = json_encode([
    [
        'title' => 'هل أحتاج خبرة سابقة في البرمجة؟',
        'description' => 'لا. الدورة تبدأ من الصفر المطلق ومساعدات الذكاء الاصطناعي تعمل كمعلم شخصي لك في كل خطوة.'
    ],
    [
        'title' => 'لماذا ثلاث تقنيات وليس واحدة؟',
        'description' => 'لأن كل تقنية تتفوق في سيناريوهات مختلفة: Laravel للاستضافة الكلاسيكية، MERN للتطبيقات الحديثة، WordPress للعملاء الذين يحتاجون نظام إدارة محتوى. تتخرج جاهزاً للعمل بالثلاث.'
    ],
    [
        'title' => 'ما أدوات الذكاء الاصطناعي المستخدمة؟',
        'description' => 'Cursor AI (المحرر) و ChatGPT و Claude و GitHub Copilot. النسخ المجانية كافية لجميع دروس هذه الدورة.'
    ],
    [
        'title' => 'هل سأنشر موقعاً فعلياً؟',
        'description' => 'نعم. الدرس 23 يأخذك خطوة بخطوة لنشر متجرك الإلكتروني الجاهز على حساب Hostinger حقيقي بدومين مخصص وقاعدة بيانات MySQL.'
    ],
    [
        'title' => 'ما مدة كل درس؟',
        'description' => 'كل درس من الـ 24 عبارة عن شرح متعمق لعدة ساعات مع عرض تقديمي من 20 إلى 40 شريحة، وشرح للكود، وتمارين تطبيقية.'
    ]
]);
$course->instructor_ids = json_encode([4]);
$course->average_rating = 5;
$course->save();
$courseId = $course->id;
echo "✅ Arabic course created: ID={$courseId}, slug={$course->slug}\n";

// Sections (Arabic)
$sections = [
    ['title' => 'الوحدة 1: الأساسيات وإعداد بيئة التطوير بالذكاء الاصطناعي', 'sort' => 1],
    ['title' => 'الوحدة 2: إتقان الواجهة الأمامية — HTML و CSS و JS و React و TypeScript', 'sort' => 2],
    ['title' => 'الوحدة 3: PHP و Laravel Full-Stack', 'sort' => 3],
    ['title' => 'الوحدة 4: MERN Stack (MongoDB, Express, React, Node)', 'sort' => 4],
    ['title' => 'الوحدة 5: WordPress و WooCommerce', 'sort' => 5],
    ['title' => 'الوحدة 6: النشر و SEO والأمان والإطلاق المباشر على Hostinger', 'sort' => 6],
];
$sectionIds = [];
foreach ($sections as $sec) {
    $section = new Section();
    $section->title = $sec['title'];
    $section->sort = $sec['sort'];
    $section->user_id = 4;
    $section->course_id = $courseId;
    $section->save();
    $sectionIds[$sec['sort']] = $section->id;
    echo "✅ Section {$sec['sort']}: {$section->id}\n";
}

// 24 Lessons (Arabic)
$lessons = [
    ['section' => 1, 'sort' => 1, 'duration' => '03:30:00', 'title' => 'الدرس 01: عقلية المطور المدعوم بالذكاء الاصطناعي وكيف يعمل الويب'],
    ['section' => 1, 'sort' => 2, 'duration' => '03:15:00', 'title' => 'الدرس 02: إعداد بيئة العمل الاحترافية بمساعدة الذكاء الاصطناعي'],
    ['section' => 1, 'sort' => 3, 'duration' => '03:45:00', 'title' => 'الدرس 03: إتقان هندسة الـ Prompts والبرمجة الزوجية مع AI'],
    ['section' => 1, 'sort' => 4, 'duration' => '03:00:00', 'title' => 'الدرس 04: Git و GitHub وسير العمل للتحكم بالنسخ بمساعدة AI'],
    ['section' => 2, 'sort' => 1, 'duration' => '04:00:00', 'title' => 'الدرس 05: HTML5 — الترميز الدلالي والبنية الوصولية مع AI'],
    ['section' => 2, 'sort' => 2, 'duration' => '04:30:00', 'title' => 'الدرس 06: تعمق في CSS3 — Flexbox و Grid والحركات والتصميم المتجاوب'],
    ['section' => 2, 'sort' => 3, 'duration' => '03:45:00', 'title' => 'الدرس 07: Bootstrap 5 و Tailwind CSS — بناء صفحات الهبوط بسرعة مع AI'],
    ['section' => 2, 'sort' => 4, 'duration' => '05:00:00', 'title' => 'الدرس 08: أساسيات JavaScript ES2024 — من المتغيرات إلى Async/Await'],
    ['section' => 2, 'sort' => 5, 'duration' => '04:30:00', 'title' => 'الدرس 09: TypeScript و React 19 الحديث مع الـ Hooks و Context'],
    ['section' => 2, 'sort' => 6, 'duration' => '05:00:00', 'title' => 'الدرس 10: بناء واجهة متجر إلكتروني بـ React + TypeScript مع AI'],
    ['section' => 3, 'sort' => 1, 'duration' => '04:30:00', 'title' => 'الدرس 11: أساسيات PHP 8 والبرمجة الكائنية OOP'],
    ['section' => 3, 'sort' => 2, 'duration' => '04:00:00', 'title' => 'الدرس 12: تصميم قاعدة بيانات MySQL والعلاقات والمخططات المولّدة بالذكاء الاصطناعي'],
    ['section' => 3, 'sort' => 3, 'duration' => '05:30:00', 'title' => 'الدرس 13: تعمق في Laravel 11 — Eloquent و Blade والمصادقة و API'],
    ['section' => 3, 'sort' => 4, 'duration' => '06:00:00', 'title' => 'الدرس 14: مشروع #1 — بناء متجر إلكتروني كامل بـ Laravel'],
    ['section' => 4, 'sort' => 1, 'duration' => '04:00:00', 'title' => 'الدرس 15: Node.js و Express — بناء REST APIs مع TypeScript'],
    ['section' => 4, 'sort' => 2, 'duration' => '04:00:00', 'title' => 'الدرس 16: MongoDB و Mongoose — تصميم المخططات للتجارة الإلكترونية'],
    ['section' => 4, 'sort' => 3, 'duration' => '05:00:00', 'title' => 'الدرس 17: مصادقة JWT والـ Middleware وأنماط REST الآمنة'],
    ['section' => 4, 'sort' => 4, 'duration' => '06:00:00', 'title' => 'الدرس 18: مشروع #2 — بناء متجر إلكتروني كامل بـ MERN Stack'],
    ['section' => 5, 'sort' => 1, 'duration' => '04:00:00', 'title' => 'الدرس 19: إتقان WordPress — القوالب والإضافات ومحرر Block'],
    ['section' => 5, 'sort' => 2, 'duration' => '05:30:00', 'title' => 'الدرس 20: مشروع #3 — بناء متجر WordPress + WooCommerce'],
    ['section' => 6, 'sort' => 1, 'duration' => '03:30:00', 'title' => 'الدرس 21: SEO والتحليلات و Core Web Vitals مع تحسين AI'],
    ['section' => 6, 'sort' => 2, 'duration' => '03:30:00', 'title' => 'الدرس 22: أمان الويب — OWASP Top 10 و HTTPS ومراجعة الكود بالذكاء الاصطناعي'],
    ['section' => 6, 'sort' => 3, 'duration' => '04:00:00', 'title' => 'الدرس 23: النشر على Hostinger — الدومين و MySQL و SSL والبريد'],
    ['section' => 6, 'sort' => 4, 'duration' => '04:30:00', 'title' => 'الدرس 24: الإطلاق والصيانة والنسخ الاحتياطية وخارطة طريق المطور بالذكاء الاصطناعي'],
];
$lessonIds = [];
foreach ($lessons as $l) {
    $lesson = new Lesson();
    $lesson->title = $l['title'];
    $lesson->user_id = 4;
    $lesson->course_id = $courseId;
    $lesson->section_id = $sectionIds[$l['section']];
    $lesson->lesson_type = 'text';
    $lesson->duration = $l['duration'];
    $lesson->sort = $l['sort'];
    $lesson->is_free = ($l['section'] === 1 && $l['sort'] === 1) ? 1 : 0;
    $lesson->description = '<p>سيتم تعبئة المحتوى بواسطة مولد العروض التقديمية.</p>';
    $lesson->save();
    $lessonIds[] = $lesson->id;
    echo "   📝 Lesson {$lesson->id}: {$l['title']}\n";
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "✅ ARABIC COURSE CREATED\n";
echo "Course ID: {$courseId} | Slug: {$course->slug}\n";
echo "Sections: " . count($sectionIds) . " | Lessons: " . count($lessonIds) . "\n";
echo "═══════════════════════════════════════════════════════════\n";

file_put_contents(
    __DIR__ . '/course_mapping_ar.json',
    json_encode([
        'course_id' => $courseId,
        'course_slug' => $course->slug,
        'section_ids' => $sectionIds,
        'lesson_ids' => $lessonIds,
        'lessons' => $lessons,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);
echo "📁 Saved to course_mapping_ar.json\n";
