<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurriculumSeeder extends Seeder
{
    public function run()
    {
        $courses = DB::table('courses')->get();

        foreach ($courses as $course) {
            $exists = DB::table('sections')->where('course_id', $course->id)->exists();
            if ($exists) {
                echo "Skipping (already has content): " . $course->title . "\n";
                continue;
            }

            $curriculum = $this->getCurriculumForCourse($course->title);

            if (!$curriculum) {
                echo "No curriculum found for: " . $course->title . "\n";
                continue;
            }

            echo "Populating: " . $course->title . "\n";

            $sectionSort = 1;
            foreach ($curriculum as $sectionTitle => $lessons) {
                $sectionId = DB::table('sections')->insertGetId([
                    'course_id' => $course->id,
                    'title'     => $sectionTitle,
                    'sort'      => $sectionSort++,
                    'user_id'   => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $lessonSort = 1;
                foreach ($lessons as $lesson) {
                    DB::table('lessons')->insert([
                        'course_id'   => $course->id,
                        'section_id'  => $sectionId,
                        'title'       => $lesson['title'],
                        'duration'    => $lesson['duration'],
                        'sort'        => $lessonSort++,
                        'user_id'     => 1,
                        'lesson_type' => 'video',
                        'is_free'     => 0,
                        'lesson_src'  => '',
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }

            echo "Done: " . $course->title . " (" . ($sectionSort - 1) . " sections)\n";
        }
    }

    private function getCurriculumForCourse(string $title): ?array
    {
        if (str_contains($title, 'الواجهات الأمامية')) {
            return $this->frontendCurriculum();
        }
        if (str_contains($title, 'Full Stack') || str_contains($title, 'المتكامل')) {
            return $this->fullstackCurriculum();
        }
        if (str_contains($title, 'المحمولة') || str_contains($title, 'Flutter')) {
            return $this->mobileCurriculum();
        }
        if (str_contains($title, 'التسويق')) {
            return $this->marketingCurriculum();
        }
        if (str_contains($title, 'التصميم')) {
            return $this->designCurriculum();
        }
        if (str_contains($title, 'المبيعات') || str_contains($title, 'البيع')) {
            return $this->salesCurriculum();
        }
        if (str_contains($title, 'البرمجة') || str_contains($title, 'برمج')) {
            return $this->aiProgrammingCurriculum();
        }
        return null;
    }

    // =========================================================
    // 1. تطوير الواجهات الأمامية
    // =========================================================
    private function frontendCurriculum(): array
    {
        return [
            'مقدمة وإعداد بيئة العمل' => [
                ['title' => 'مرحبًا بك في دورة تطوير الواجهات الأمامية', 'duration' => '0:08:00'],
                ['title' => 'ما هو Front-End وكيف يعمل الويب؟', 'duration' => '0:15:00'],
                ['title' => 'تثبيت VS Code وأهم الإضافات', 'duration' => '0:20:00'],
                ['title' => 'مقدمة لـ Chrome DevTools', 'duration' => '0:18:00'],
                ['title' => 'خريطة الدورة والمسار الكامل', 'duration' => '0:10:00'],
            ],
            'أساسيات HTML5' => [
                ['title' => 'هيكل صفحة HTML الأساسية', 'duration' => '0:22:00'],
                ['title' => 'العناوين والفقرات والنصوص', 'duration' => '0:20:00'],
                ['title' => 'الروابط والصور والوسائط', 'duration' => '0:25:00'],
                ['title' => 'القوائم المرتبة وغير المرتبة', 'duration' => '0:18:00'],
                ['title' => 'الجداول Tables', 'duration' => '0:25:00'],
                ['title' => 'النماذج Forms وعناصر الإدخال', 'duration' => '0:35:00'],
                ['title' => 'العناصر الدلالية Semantic HTML5', 'duration' => '0:28:00'],
                ['title' => 'الوسوم الوصفية Meta Tags وSEO', 'duration' => '0:20:00'],
                ['title' => 'إمكانية الوصول Accessibility', 'duration' => '0:22:00'],
                ['title' => 'تمرين عملي: بناء صفحة Bio كاملة', 'duration' => '0:45:00'],
            ],
            'أساسيات CSS3' => [
                ['title' => 'ربط CSS بصفحة HTML', 'duration' => '0:15:00'],
                ['title' => 'المحددات Selectors بالتفصيل', 'duration' => '0:30:00'],
                ['title' => 'نموذج الصندوق Box Model', 'duration' => '0:28:00'],
                ['title' => 'الألوان والخلفيات Backgrounds', 'duration' => '0:25:00'],
                ['title' => 'الخطوط Typography وGoogle Fonts', 'duration' => '0:22:00'],
                ['title' => 'الـ Display وPositioning', 'duration' => '0:35:00'],
                ['title' => 'Flexbox من الصفر للاحتراف', 'duration' => '0:50:00'],
                ['title' => 'CSS Grid نظام الشبكة', 'duration' => '0:50:00'],
                ['title' => 'الظلال والتأثيرات البصرية', 'duration' => '0:20:00'],
                ['title' => 'CSS Variables المتغيرات المخصصة', 'duration' => '0:22:00'],
                ['title' => 'Transitions والانتقالات السلسة', 'duration' => '0:25:00'],
                ['title' => 'CSS Animations والإطارات المفتاحية', 'duration' => '0:35:00'],
                ['title' => 'تمرين: تصميم بطاقة مستخدم تفاعلية', 'duration' => '0:40:00'],
            ],
            'التصميم المتجاوب Responsive Design' => [
                ['title' => 'مفهوم التصميم المتجاوب', 'duration' => '0:18:00'],
                ['title' => 'Media Queries بالتفصيل', 'duration' => '0:30:00'],
                ['title' => 'Mobile First Strategy', 'duration' => '0:22:00'],
                ['title' => 'الصور المتجاوبة Responsive Images', 'duration' => '0:20:00'],
                ['title' => 'مقدمة لـ Bootstrap 5', 'duration' => '0:25:00'],
                ['title' => 'نظام الشبكة في Bootstrap', 'duration' => '0:35:00'],
                ['title' => 'مكونات Bootstrap: Navbar والأزرار والبطاقات', 'duration' => '0:40:00'],
                ['title' => 'تمرين: بناء صفحة هبوط متجاوبة', 'duration' => '1:00:00'],
            ],
            'JavaScript - الأساسيات' => [
                ['title' => 'مقدمة لـ JavaScript ودورها في الويب', 'duration' => '0:15:00'],
                ['title' => 'المتغيرات: var وlet وconst', 'duration' => '0:25:00'],
                ['title' => 'أنواع البيانات والمشغلات', 'duration' => '0:30:00'],
                ['title' => 'الجمل الشرطية if/else والـ switch', 'duration' => '0:28:00'],
                ['title' => 'الحلقات: for وwhile وfor...of', 'duration' => '0:30:00'],
                ['title' => 'الدوال Functions والنطاق Scope', 'duration' => '0:35:00'],
                ['title' => 'المصفوفات Arrays والطرق الأساسية', 'duration' => '0:35:00'],
                ['title' => 'الكائنات Objects والخصائص', 'duration' => '0:30:00'],
                ['title' => 'التعامل مع النصوص Strings', 'duration' => '0:25:00'],
                ['title' => 'معالجة الأخطاء try/catch', 'duration' => '0:22:00'],
                ['title' => 'تمرين: برنامج قائمة مهام بـ JS خالص', 'duration' => '0:50:00'],
            ],
            'JavaScript ES6+ المتقدم' => [
                ['title' => 'Arrow Functions والفرق عن الدوال العادية', 'duration' => '0:25:00'],
                ['title' => 'Destructuring للمصفوفات والكائنات', 'duration' => '0:30:00'],
                ['title' => 'Spread وRest Operators', 'duration' => '0:25:00'],
                ['title' => 'Template Literals', 'duration' => '0:15:00'],
                ['title' => 'Modules: import وexport', 'duration' => '0:25:00'],
                ['title' => 'البرمجة الكائنية OOP والـ Classes', 'duration' => '0:40:00'],
                ['title' => 'Promises والبرمجة غير المتزامنة', 'duration' => '0:35:00'],
                ['title' => 'Async/Await بالتفصيل', 'duration' => '0:30:00'],
                ['title' => 'مناهج المصفوفات: map وfilter وreduce', 'duration' => '0:35:00'],
                ['title' => 'تمرين: بناء تطبيق بحث بـ API', 'duration' => '0:55:00'],
            ],
            'DOM - التفاعل مع صفحات الويب' => [
                ['title' => 'ما هو DOM وكيف يعمل؟', 'duration' => '0:18:00'],
                ['title' => 'اختيار العناصر querySelector وgetElementById', 'duration' => '0:25:00'],
                ['title' => 'تعديل العناصر: المحتوى والأنماط', 'duration' => '0:28:00'],
                ['title' => 'إنشاء وحذف العناصر ديناميكيًا', 'duration' => '0:30:00'],
                ['title' => 'الأحداث Events والمستمعون', 'duration' => '0:35:00'],
                ['title' => 'Event Delegation وتحسين الأداء', 'duration' => '0:25:00'],
                ['title' => 'Fetch API والتواصل مع الخوادم', 'duration' => '0:35:00'],
                ['title' => 'LocalStorage وSessionStorage', 'duration' => '0:22:00'],
                ['title' => 'تمرين: تطبيق طقس باستخدام API حقيقي', 'duration' => '1:00:00'],
            ],
            'مقدمة لـ React.js' => [
                ['title' => 'لماذا React؟ Virtual DOM والفلسفة', 'duration' => '0:20:00'],
                ['title' => 'إعداد مشروع باستخدام Vite', 'duration' => '0:22:00'],
                ['title' => 'JSX: كتابة HTML داخل JavaScript', 'duration' => '0:25:00'],
                ['title' => 'المكونات Components وأنواعها', 'duration' => '0:28:00'],
                ['title' => 'Props: تمرير البيانات بين المكونات', 'duration' => '0:30:00'],
                ['title' => 'State وhook الـ useState', 'duration' => '0:35:00'],
                ['title' => 'التعامل مع الأحداث في React', 'duration' => '0:25:00'],
                ['title' => 'Rendering الشرطي وعرض القوائم', 'duration' => '0:30:00'],
                ['title' => 'hook الـ useEffect والتأثيرات الجانبية', 'duration' => '0:35:00'],
                ['title' => 'React Router: التنقل بين الصفحات', 'duration' => '0:40:00'],
                ['title' => 'Context API: إدارة الحالة العامة', 'duration' => '0:35:00'],
                ['title' => 'استدعاء APIs في React', 'duration' => '0:30:00'],
            ],
            'React المتقدم والأدوات' => [
                ['title' => 'Custom Hooks: إعادة استخدام المنطق', 'duration' => '0:35:00'],
                ['title' => 'useMemo وuseCallback: تحسين الأداء', 'duration' => '0:30:00'],
                ['title' => 'مقدمة لـ Tailwind CSS مع React', 'duration' => '0:35:00'],
                ['title' => 'إدارة النماذج Forms في React', 'duration' => '0:30:00'],
                ['title' => 'Git وGitHub: إدارة الكود احترافيًا', 'duration' => '0:40:00'],
                ['title' => 'npm والمكتبات الخارجية', 'duration' => '0:20:00'],
                ['title' => 'نشر المشروع على Vercel وNetlify', 'duration' => '0:25:00'],
            ],
            'المشروع النهائي: متجر إلكتروني' => [
                ['title' => 'تخطيط المشروع وتصميم الواجهات', 'duration' => '0:40:00'],
                ['title' => 'بناء الهيكل والمكونات الأساسية', 'duration' => '1:00:00'],
                ['title' => 'صفحة المنتجات والفلترة', 'duration' => '0:55:00'],
                ['title' => 'سلة الشراء وإدارة الحالة', 'duration' => '1:00:00'],
                ['title' => 'صفحة التفاصيل والانتقال بين الصفحات', 'duration' => '0:45:00'],
                ['title' => 'التصميم المتجاوب وتحسين الأداء', 'duration' => '0:50:00'],
                ['title' => 'نشر المشروع وتسليمه', 'duration' => '0:30:00'],
            ],
        ];
    }

    // =========================================================
    // 2. تطوير الويب المتكامل Full Stack
    // =========================================================
    private function fullstackCurriculum(): array
    {
        return [
            'مقدمة Full Stack وخريطة التعلم' => [
                ['title' => 'ما هو Full Stack Developer؟', 'duration' => '0:15:00'],
                ['title' => 'Front-End vs Back-End vs Full Stack', 'duration' => '0:18:00'],
                ['title' => 'تثبيت Node.js وVS Code والأدوات اللازمة', 'duration' => '0:25:00'],
                ['title' => 'كيف تعمل تطبيقات الويب: HTTP وClient-Server', 'duration' => '0:22:00'],
            ],
            'مراجعة HTML وCSS وJavaScript' => [
                ['title' => 'مراجعة سريعة لـ HTML5 وCSS3', 'duration' => '0:35:00'],
                ['title' => 'JavaScript الأساسيات المطلوبة', 'duration' => '0:40:00'],
                ['title' => 'ES6+ المميزات الجوهرية', 'duration' => '0:35:00'],
                ['title' => 'Async/Await والبرمجة غير المتزامنة', 'duration' => '0:30:00'],
            ],
            'React.js - الواجهة الأمامية' => [
                ['title' => 'إعداد مشروع React مع Vite', 'duration' => '0:20:00'],
                ['title' => 'Components وProps وState', 'duration' => '0:40:00'],
                ['title' => 'React Hooks: useState وuseEffect', 'duration' => '0:40:00'],
                ['title' => 'React Router للتنقل', 'duration' => '0:35:00'],
                ['title' => 'Context API وإدارة الحالة', 'duration' => '0:35:00'],
                ['title' => 'Axios: التواصل مع APIs', 'duration' => '0:30:00'],
                ['title' => 'نماذج Forms والتحقق من البيانات', 'duration' => '0:30:00'],
                ['title' => 'Tailwind CSS مع React', 'duration' => '0:35:00'],
            ],
            'Node.js - أساسيات الخادم' => [
                ['title' => 'ما هو Node.js ولماذا نستخدمه؟', 'duration' => '0:20:00'],
                ['title' => 'نظام الوحدات Modules في Node.js', 'duration' => '0:25:00'],
                ['title' => 'نظام الملفات File System', 'duration' => '0:28:00'],
                ['title' => 'الأحداث EventEmitter', 'duration' => '0:22:00'],
                ['title' => 'npm وإدارة الحزم', 'duration' => '0:20:00'],
                ['title' => 'بناء خادم HTTP بسيط', 'duration' => '0:30:00'],
                ['title' => 'Environment Variables وملف .env', 'duration' => '0:18:00'],
            ],
            'Express.js - إطار عمل الخادم' => [
                ['title' => 'مقدمة لـ Express.js وإعداده', 'duration' => '0:22:00'],
                ['title' => 'المسارات Routes: GET وPOST وPUT وDELETE', 'duration' => '0:35:00'],
                ['title' => 'Middleware: مفهومه وتطبيقاته', 'duration' => '0:30:00'],
                ['title' => 'معالجة البيانات: req.body وreq.params وreq.query', 'duration' => '0:28:00'],
                ['title' => 'معالجة الأخطاء في Express', 'duration' => '0:25:00'],
                ['title' => 'تنظيم المشروع: Controllers وRoutes', 'duration' => '0:30:00'],
                ['title' => 'رفع الملفات File Upload', 'duration' => '0:30:00'],
                ['title' => 'CORS وأمان API', 'duration' => '0:22:00'],
            ],
            'MongoDB وMongoose' => [
                ['title' => 'مقدمة لقواعد البيانات NoSQL', 'duration' => '0:20:00'],
                ['title' => 'تثبيت MongoDB وMongoose', 'duration' => '0:22:00'],
                ['title' => 'الـ Schema والـ Model', 'duration' => '0:30:00'],
                ['title' => 'CRUD: إنشاء وقراءة وتحديث وحذف', 'duration' => '0:45:00'],
                ['title' => 'الاستعلامات المتقدمة: Filter وSort وPagination', 'duration' => '0:35:00'],
                ['title' => 'العلاقات بين الوثائق: Populate', 'duration' => '0:30:00'],
                ['title' => 'Validation في Mongoose', 'duration' => '0:25:00'],
                ['title' => 'تمرين: بناء API لإدارة المنتجات', 'duration' => '0:55:00'],
            ],
            'المصادقة والتفويض Authentication' => [
                ['title' => 'مفاهيم المصادقة: Session vs Token', 'duration' => '0:20:00'],
                ['title' => 'تشفير كلمات المرور مع bcrypt', 'duration' => '0:25:00'],
                ['title' => 'JWT: توليد والتحقق من الرمز', 'duration' => '0:35:00'],
                ['title' => 'تسجيل المستخدم وتسجيل الدخول', 'duration' => '0:40:00'],
                ['title' => 'حماية المسارات Protected Routes', 'duration' => '0:30:00'],
                ['title' => 'إدارة الأدوار Roles والصلاحيات', 'duration' => '0:30:00'],
                ['title' => 'تحديث كلمة المرور ونسيانها', 'duration' => '0:28:00'],
                ['title' => 'ربط المصادقة بالواجهة الأمامية', 'duration' => '0:40:00'],
            ],
            'REST API المتقدم والاختبار' => [
                ['title' => 'مبادئ RESTful API التصميم', 'duration' => '0:22:00'],
                ['title' => 'Postman: اختبار API باحترافية', 'duration' => '0:30:00'],
                ['title' => 'Rate Limiting وحماية الـ API', 'duration' => '0:25:00'],
                ['title' => 'توثيق API مع Swagger', 'duration' => '0:30:00'],
                ['title' => 'اختبارات الوحدة Unit Testing', 'duration' => '0:35:00'],
            ],
            'النشر والإنتاج Deployment' => [
                ['title' => 'Git وGitHub: إدارة الإصدارات', 'duration' => '0:35:00'],
                ['title' => 'نشر الخادم على Render أو Railway', 'duration' => '0:35:00'],
                ['title' => 'نشر قاعدة البيانات على MongoDB Atlas', 'duration' => '0:25:00'],
                ['title' => 'نشر الواجهة الأمامية على Vercel', 'duration' => '0:25:00'],
                ['title' => 'المتغيرات البيئية في الإنتاج', 'duration' => '0:18:00'],
                ['title' => 'مراقبة الأداء والأخطاء', 'duration' => '0:22:00'],
            ],
            'المشروع النهائي: منصة متكاملة' => [
                ['title' => 'تخطيط مشروع منصة تعليمية صغيرة', 'duration' => '0:40:00'],
                ['title' => 'تصميم قاعدة البيانات والـ Models', 'duration' => '0:45:00'],
                ['title' => 'بناء الـ API: المستخدمون والمحتوى', 'duration' => '1:10:00'],
                ['title' => 'بناء الواجهة الأمامية والمصادقة', 'duration' => '1:15:00'],
                ['title' => 'ربط الـ API بالواجهة كاملًا', 'duration' => '1:00:00'],
                ['title' => 'النشر الكامل والاختبار النهائي', 'duration' => '0:50:00'],
            ],
        ];
    }

    // =========================================================
    // 3. تطوير التطبيقات المحمولة
    // =========================================================
    private function mobileCurriculum(): array
    {
        return [
            'مقدمة وإعداد بيئة التطوير' => [
                ['title' => 'لماذا Flutter؟ مقارنة مع React Native وKotlin', 'duration' => '0:18:00'],
                ['title' => 'تثبيت Flutter SDK وAndroid Studio', 'duration' => '0:30:00'],
                ['title' => 'إعداد المحاكي Emulator والتشغيل الأول', 'duration' => '0:25:00'],
                ['title' => 'هيكل مشروع Flutter', 'duration' => '0:20:00'],
                ['title' => 'مقدمة لـ VS Code مع Flutter', 'duration' => '0:15:00'],
            ],
            'أساسيات Dart' => [
                ['title' => 'متغيرات Dart وأنواع البيانات', 'duration' => '0:25:00'],
                ['title' => 'الجمل الشرطية والحلقات في Dart', 'duration' => '0:28:00'],
                ['title' => 'الدوال Functions في Dart', 'duration' => '0:25:00'],
                ['title' => 'البرمجة الكائنية OOP في Dart', 'duration' => '0:40:00'],
                ['title' => 'Collections: List وMap وSet', 'duration' => '0:30:00'],
                ['title' => 'Null Safety في Dart', 'duration' => '0:22:00'],
                ['title' => 'Async في Dart: Future وStreams', 'duration' => '0:35:00'],
                ['title' => 'تمرين: برنامج Dart من الصفر', 'duration' => '0:40:00'],
            ],
            'أساسيات Flutter والـ Widgets' => [
                ['title' => 'فلسفة Flutter: كل شيء Widget', 'duration' => '0:18:00'],
                ['title' => 'Stateless vs Stateful Widgets', 'duration' => '0:30:00'],
                ['title' => 'Text وImage وIcon والـ Container', 'duration' => '0:35:00'],
                ['title' => 'Column وRow وStack للتخطيط', 'duration' => '0:35:00'],
                ['title' => 'Padding وMargin والـ SizedBox', 'duration' => '0:22:00'],
                ['title' => 'Scaffold وAppBar وBottomNavigationBar', 'duration' => '0:30:00'],
                ['title' => 'Buttons: ElevatedButton وTextButton وIconButton', 'duration' => '0:25:00'],
                ['title' => 'TextField والنماذج Forms', 'duration' => '0:30:00'],
                ['title' => 'ListView وGridView لعرض القوائم', 'duration' => '0:35:00'],
                ['title' => 'تمرين: بناء واجهة تطبيق مطعم', 'duration' => '0:55:00'],
            ],
            'التنقل والتوجيه Navigation' => [
                ['title' => 'Navigator: الانتقال بين الشاشات', 'duration' => '0:28:00'],
                ['title' => 'Named Routes وتمرير البيانات', 'duration' => '0:30:00'],
                ['title' => 'مقدمة لـ GoRouter', 'duration' => '0:35:00'],
                ['title' => 'Bottom Navigation وTab Bar', 'duration' => '0:28:00'],
                ['title' => 'Drawer القائمة الجانبية', 'duration' => '0:22:00'],
            ],
            'إدارة الحالة State Management' => [
                ['title' => 'مشكلة إدارة الحالة في التطبيقات الكبيرة', 'duration' => '0:18:00'],
                ['title' => 'setState والـ InheritedWidget', 'duration' => '0:25:00'],
                ['title' => 'Provider: مقدمة وتطبيق', 'duration' => '0:40:00'],
                ['title' => 'Riverpod: الجيل الجديد', 'duration' => '0:45:00'],
                ['title' => 'مقدمة لـ Bloc Pattern', 'duration' => '0:35:00'],
                ['title' => 'تمرين: تطبيق سلة شراء كاملة', 'duration' => '1:00:00'],
            ],
            'الشبكة والبيانات Networking' => [
                ['title' => 'مكتبة http: الطلبات الأساسية', 'duration' => '0:28:00'],
                ['title' => 'Dio: مكتبة متقدمة للـ HTTP', 'duration' => '0:35:00'],
                ['title' => 'تحليل JSON وDart Models', 'duration' => '0:30:00'],
                ['title' => 'FutureBuilder وStreamBuilder', 'duration' => '0:30:00'],
                ['title' => 'التعامل مع الأخطاء وحالات التحميل', 'duration' => '0:25:00'],
                ['title' => 'تمرين: تطبيق أخبار بـ API حقيقي', 'duration' => '0:55:00'],
            ],
            'التخزين المحلي Local Storage' => [
                ['title' => 'SharedPreferences: بيانات بسيطة', 'duration' => '0:25:00'],
                ['title' => 'Hive: قاعدة بيانات محلية سريعة', 'duration' => '0:35:00'],
                ['title' => 'SQLite مع Sqflite', 'duration' => '0:35:00'],
                ['title' => 'تخزين وقراءة الملفات', 'duration' => '0:22:00'],
            ],
            'Firebase مع Flutter' => [
                ['title' => 'إعداد Firebase مع مشروع Flutter', 'duration' => '0:30:00'],
                ['title' => 'Firebase Authentication', 'duration' => '0:40:00'],
                ['title' => 'Firestore: قاعدة بيانات الوقت الفعلي', 'duration' => '0:45:00'],
                ['title' => 'Firebase Storage: رفع الصور', 'duration' => '0:30:00'],
                ['title' => 'Push Notifications', 'duration' => '0:35:00'],
            ],
            'تحسين الواجهات والتصميم' => [
                ['title' => 'Themes والـ Material Design 3', 'duration' => '0:28:00'],
                ['title' => 'الرسوم المتحركة Animations', 'duration' => '0:40:00'],
                ['title' => 'Custom Widgets', 'duration' => '0:30:00'],
                ['title' => 'Responsive Design في Flutter', 'duration' => '0:30:00'],
                ['title' => 'الدعم متعدد اللغات Localization', 'duration' => '0:25:00'],
            ],
            'المشروع النهائي: تطبيق تسوق' => [
                ['title' => 'تخطيط وتصميم شاشات التطبيق', 'duration' => '0:40:00'],
                ['title' => 'بناء شاشة الرئيسية والفئات', 'duration' => '0:55:00'],
                ['title' => 'شاشة المنتجات والبحث', 'duration' => '0:50:00'],
                ['title' => 'سلة الشراء وإدارة الحالة', 'duration' => '1:00:00'],
                ['title' => 'تسجيل الدخول والمستخدم', 'duration' => '0:50:00'],
                ['title' => 'ربط Firebase والنشر', 'duration' => '0:45:00'],
            ],
        ];
    }

    // =========================================================
    // 4. التسويق باستخدام أدوات الذكاء الاصطناعي
    // =========================================================
    private function marketingCurriculum(): array
    {
        return [
            'أساسيات التسويق الرقمي' => [
                ['title' => 'ما هو التسويق الرقمي وأهميته اليوم', 'duration' => '0:18:00'],
                ['title' => 'قنوات التسويق الرقمي: نظرة شاملة', 'duration' => '0:22:00'],
                ['title' => 'بناء هوية العلامة التجارية Brand Identity', 'duration' => '0:28:00'],
                ['title' => 'تحديد الجمهور المستهدف Target Audience', 'duration' => '0:30:00'],
                ['title' => 'نموذج Marketing Funnel', 'duration' => '0:25:00'],
                ['title' => 'Customer Journey: رحلة العميل كاملة', 'duration' => '0:28:00'],
            ],
            'استراتيجية المحتوى Content Strategy' => [
                ['title' => 'ما هو التسويق بالمحتوى Content Marketing', 'duration' => '0:20:00'],
                ['title' => 'أنواع المحتوى: مقالات وفيديو وBlog', 'duration' => '0:25:00'],
                ['title' => 'بناء خطة محتوى Content Calendar', 'duration' => '0:35:00'],
                ['title' => 'كتابة محتوى يقنع ويبيع Copywriting', 'duration' => '0:40:00'],
                ['title' => 'Storytelling في التسويق', 'duration' => '0:28:00'],
                ['title' => 'قياس فاعلية المحتوى', 'duration' => '0:22:00'],
            ],
            'التسويق عبر وسائل التواصل الاجتماعي' => [
                ['title' => 'اختيار المنصة المناسبة لعملك', 'duration' => '0:20:00'],
                ['title' => 'استراتيجية Instagram والـ Reels', 'duration' => '0:35:00'],
                ['title' => 'التسويق على LinkedIn للـ B2B', 'duration' => '0:30:00'],
                ['title' => 'TikTok Marketing والمحتوى القصير', 'duration' => '0:28:00'],
                ['title' => 'إدارة المجتمع Community Management', 'duration' => '0:25:00'],
                ['title' => 'Influencer Marketing', 'duration' => '0:30:00'],
                ['title' => 'أدوات جدولة المنشورات: Buffer وHootsuite', 'duration' => '0:25:00'],
            ],
            'تسويق البريد الإلكتروني Email Marketing' => [
                ['title' => 'لماذا البريد الإلكتروني لا يزال الأقوى؟', 'duration' => '0:15:00'],
                ['title' => 'بناء قائمة بريدية من الصفر', 'duration' => '0:28:00'],
                ['title' => 'تصميم حملات بريدية فعالة', 'duration' => '0:35:00'],
                ['title' => 'أتمتة البريد: Sequences وDrip Campaigns', 'duration' => '0:35:00'],
                ['title' => 'Segmentation: تقسيم الجمهور', 'duration' => '0:25:00'],
                ['title' => 'تحسين معدل الفتح والنقر', 'duration' => '0:28:00'],
                ['title' => 'Mailchimp وActiveCampaign: أدوات عملية', 'duration' => '0:30:00'],
            ],
            'SEO - تحسين محركات البحث' => [
                ['title' => 'كيف تعمل محركات البحث؟', 'duration' => '0:20:00'],
                ['title' => 'Keyword Research: البحث عن الكلمات المفتاحية', 'duration' => '0:35:00'],
                ['title' => 'On-Page SEO: تحسين صفحاتك', 'duration' => '0:35:00'],
                ['title' => 'Technical SEO: السرعة والبنية', 'duration' => '0:30:00'],
                ['title' => 'Link Building بناء الروابط', 'duration' => '0:28:00'],
                ['title' => 'Google Search Console وGoogle Analytics', 'duration' => '0:35:00'],
                ['title' => 'Local SEO: التسويق المحلي', 'duration' => '0:25:00'],
            ],
            'الإعلانات المدفوعة Paid Advertising' => [
                ['title' => 'مقدمة لـ Google Ads', 'duration' => '0:22:00'],
                ['title' => 'Search Campaigns: حملات البحث', 'duration' => '0:40:00'],
                ['title' => 'إعلانات Meta: Facebook وInstagram', 'duration' => '0:45:00'],
                ['title' => 'Retargeting: استهداف الزوار السابقين', 'duration' => '0:28:00'],
                ['title' => 'A/B Testing للإعلانات', 'duration' => '0:30:00'],
                ['title' => 'تحسين ROI وإدارة الميزانية', 'duration' => '0:30:00'],
            ],
            'أدوات الذكاء الاصطناعي في التسويق' => [
                ['title' => 'ChatGPT لإنشاء محتوى تسويقي', 'duration' => '0:35:00'],
                ['title' => 'Claude وGemini: مقارنة وتطبيق', 'duration' => '0:28:00'],
                ['title' => 'Midjourney وDALL-E لإنشاء صور إعلانية', 'duration' => '0:35:00'],
                ['title' => 'أتمتة التسويق بالذكاء الاصطناعي', 'duration' => '0:30:00'],
                ['title' => 'Prompt Engineering للتسويق', 'duration' => '0:35:00'],
                ['title' => 'أدوات تحليل المنافسين بالذكاء الاصطناعي', 'duration' => '0:25:00'],
                ['title' => 'Personalization: التخصيص الذكي', 'duration' => '0:28:00'],
                ['title' => 'Jasper وCopy.ai: أدوات الكتابة', 'duration' => '0:25:00'],
            ],
            'التحليلات وقياس النتائج' => [
                ['title' => 'مؤشرات الأداء KPIs الأساسية', 'duration' => '0:25:00'],
                ['title' => 'Google Analytics 4 بالتفصيل', 'duration' => '0:45:00'],
                ['title' => 'إنشاء Dashboards وتقارير', 'duration' => '0:30:00'],
                ['title' => 'تحليل بيانات الحملات واتخاذ القرار', 'duration' => '0:35:00'],
                ['title' => 'Customer Lifetime Value حساب قيمة العميل', 'duration' => '0:25:00'],
            ],
            'المشروع النهائي: خطة تسويقية كاملة' => [
                ['title' => 'اختيار منتج أو خدمة للمشروع', 'duration' => '0:25:00'],
                ['title' => 'تحليل السوق والمنافسين', 'duration' => '0:45:00'],
                ['title' => 'بناء الهوية والجمهور المستهدف', 'duration' => '0:40:00'],
                ['title' => 'خطة المحتوى والحملات', 'duration' => '0:50:00'],
                ['title' => 'تنفيذ حملة بمساعدة أدوات AI', 'duration' => '0:55:00'],
                ['title' => 'عرض النتائج والتحسين', 'duration' => '0:35:00'],
            ],
        ];
    }

    // =========================================================
    // 5. التصميم باستخدام أدوات الذكاء الاصطناعي
    // =========================================================
    private function designCurriculum(): array
    {
        return [
            'أسس التصميم المرئي' => [
                ['title' => 'مقدمة: ما هو التصميم الجيد؟', 'duration' => '0:18:00'],
                ['title' => 'مبادئ التصميم: التوازن والتكرار والتباين', 'duration' => '0:30:00'],
                ['title' => 'نظرية الألوان: الدائرة اللونية والمشاعر', 'duration' => '0:35:00'],
                ['title' => 'أنظمة الألوان: Complementary وAnalogous وTriadic', 'duration' => '0:25:00'],
                ['title' => 'الطباعة Typography: أنواع الخطوط واختيارها', 'duration' => '0:30:00'],
                ['title' => 'التسلسل الهرمي البصري Hierarchy', 'duration' => '0:25:00'],
                ['title' => 'Grid Systems وتنظيم التخطيط', 'duration' => '0:28:00'],
                ['title' => 'White Space والمساحة السلبية', 'duration' => '0:20:00'],
            ],
            'أدوات التصميم: Figma من الصفر' => [
                ['title' => 'مقدمة لـ Figma وإعداد الحساب', 'duration' => '0:15:00'],
                ['title' => 'واجهة Figma وأدواتها الأساسية', 'duration' => '0:30:00'],
                ['title' => 'الأشكال والنصوص والصور', 'duration' => '0:25:00'],
                ['title' => 'Auto Layout: تخطيط ذكي', 'duration' => '0:35:00'],
                ['title' => 'Components والـ Variants', 'duration' => '0:40:00'],
                ['title' => 'Styles: ألوان ونصوص وتأثيرات', 'duration' => '0:28:00'],
                ['title' => 'Prototyping: التنقل والتفاعل', 'duration' => '0:35:00'],
                ['title' => 'التعاون Team Libraries والـ Comments', 'duration' => '0:20:00'],
                ['title' => 'تصدير الملفات للمطورين Inspect Mode', 'duration' => '0:22:00'],
            ],
            'تجربة المستخدم UX Design' => [
                ['title' => 'ما هو UX وأهميته', 'duration' => '0:18:00'],
                ['title' => 'User Research: فهم المستخدم', 'duration' => '0:35:00'],
                ['title' => 'User Personas وUser Stories', 'duration' => '0:30:00'],
                ['title' => 'Information Architecture', 'duration' => '0:25:00'],
                ['title' => 'User Flow وWireframes', 'duration' => '0:40:00'],
                ['title' => 'Usability Testing: اختبار قابلية الاستخدام', 'duration' => '0:30:00'],
                ['title' => 'Heuristic Evaluation', 'duration' => '0:25:00'],
            ],
            'تصميم الواجهات UI Design' => [
                ['title' => 'الفرق بين UX وUI', 'duration' => '0:15:00'],
                ['title' => 'Design Systems أنظمة التصميم', 'duration' => '0:35:00'],
                ['title' => 'تصميم المكونات: الأزرار والنماذج والقوائم', 'duration' => '0:40:00'],
                ['title' => 'Mobile UI Design: تصميم تطبيقات الموبايل', 'duration' => '0:40:00'],
                ['title' => 'Web UI Design: تصميم مواقع الويب', 'duration' => '0:40:00'],
                ['title' => 'Dark Mode وLight Mode', 'duration' => '0:25:00'],
                ['title' => 'Micro-interactions والرسوم المتحركة', 'duration' => '0:30:00'],
                ['title' => 'Accessibility في التصميم', 'duration' => '0:25:00'],
            ],
            'أدوات الذكاء الاصطناعي في التصميم' => [
                ['title' => 'Midjourney: توليد صور إبداعية', 'duration' => '0:40:00'],
                ['title' => 'DALL-E وStable Diffusion', 'duration' => '0:35:00'],
                ['title' => 'Adobe Firefly وادماجه في Photoshop', 'duration' => '0:35:00'],
                ['title' => 'Prompt Engineering للصور', 'duration' => '0:30:00'],
                ['title' => 'أدوات AI داخل Figma', 'duration' => '0:30:00'],
                ['title' => 'Uizard وGalileo: تصميم بالـ AI', 'duration' => '0:28:00'],
                ['title' => 'إزالة الخلفيات والتحسين التلقائي', 'duration' => '0:22:00'],
                ['title' => 'توليد محتوى الـ Mockups تلقائيًا', 'duration' => '0:25:00'],
            ],
            'التصميم الجرافيكي وهوية العلامة' => [
                ['title' => 'تصميم الشعارات Logos', 'duration' => '0:45:00'],
                ['title' => 'دليل الهوية Brand Guidelines', 'duration' => '0:35:00'],
                ['title' => 'تصميم منشورات وسائل التواصل', 'duration' => '0:40:00'],
                ['title' => 'تصميم المطبوعات: كروت وبروشورات', 'duration' => '0:35:00'],
                ['title' => 'تصميم الـ Infographic', 'duration' => '0:35:00'],
                ['title' => 'Canva Pro: أداة سريعة للتسويق', 'duration' => '0:28:00'],
            ],
            'بناء Portfolio وإطلاق المسيرة' => [
                ['title' => 'ما يجب أن يحتويه Portfolio قوي', 'duration' => '0:22:00'],
                ['title' => 'Behance وDribbble: عرض أعمالك', 'duration' => '0:25:00'],
                ['title' => 'كتابة Case Studies مقنعة', 'duration' => '0:30:00'],
                ['title' => 'العمل الحر Freelancing: كيف تبدأ', 'duration' => '0:30:00'],
                ['title' => 'التسعير والتفاوض مع العملاء', 'duration' => '0:25:00'],
                ['title' => 'الفرص الوظيفية في التصميم', 'duration' => '0:20:00'],
            ],
            'المشروع النهائي: تصميم تطبيق كامل' => [
                ['title' => 'اختيار فكرة وتحديد المتطلبات', 'duration' => '0:30:00'],
                ['title' => 'User Research وPersonas', 'duration' => '0:40:00'],
                ['title' => 'Wireframes وUser Flow', 'duration' => '0:50:00'],
                ['title' => 'التصميم المرئي بـ Figma', 'duration' => '1:00:00'],
                ['title' => 'Prototype تفاعلي كامل', 'duration' => '0:50:00'],
                ['title' => 'تحسين بمساعدة AI وعرض المشروع', 'duration' => '0:40:00'],
            ],
        ];
    }

    // =========================================================
    // 6. دورة المبيعات
    // =========================================================
    private function salesCurriculum(): array
    {
        return [
            'المبيعات: العلم والفن' => [
                ['title' => 'ما هي المبيعات الحديثة؟', 'duration' => '0:18:00'],
                ['title' => 'علم نفس الشراء: لماذا يشتري الناس؟', 'duration' => '0:30:00'],
                ['title' => 'الفرق بين البائع العادي والاحترافي', 'duration' => '0:22:00'],
                ['title' => 'أخلاقيات المبيعات والثقة', 'duration' => '0:20:00'],
                ['title' => 'أنواع المبيعات: B2B وB2C وD2C', 'duration' => '0:25:00'],
            ],
            'إيجاد العملاء Lead Generation' => [
                ['title' => 'ما هو الـ Lead وكيف تصنفه؟', 'duration' => '0:20:00'],
                ['title' => 'Inbound vs Outbound Marketing', 'duration' => '0:25:00'],
                ['title' => 'التنقيب Prospecting: أين تجد عملاءك؟', 'duration' => '0:30:00'],
                ['title' => 'LinkedIn للبحث عن العملاء B2B', 'duration' => '0:35:00'],
                ['title' => 'Cold Email: البريد البارد الفعال', 'duration' => '0:35:00'],
                ['title' => 'Cold Calling: المكالمات الباردة', 'duration' => '0:30:00'],
                ['title' => 'Referrals والتوصيات: الذهب الخفي', 'duration' => '0:25:00'],
                ['title' => 'Social Selling عبر منصات التواصل', 'duration' => '0:28:00'],
            ],
            'Qualification: تأهيل العملاء' => [
                ['title' => 'ما هو Qualification ولماذا هو مهم؟', 'duration' => '0:18:00'],
                ['title' => 'نموذج BANT: الميزانية والصلاحية والحاجة والتوقيت', 'duration' => '0:30:00'],
                ['title' => 'MEDDIC وCHAMPS: نماذج متقدمة', 'duration' => '0:28:00'],
                ['title' => 'أسئلة الاكتشاف Discovery Questions', 'duration' => '0:35:00'],
                ['title' => 'فهم ألم العميل Pain Points', 'duration' => '0:25:00'],
                ['title' => 'Active Listening: الاستماع الفعال', 'duration' => '0:25:00'],
            ],
            'عرض القيمة والتقديم' => [
                ['title' => 'بناء Value Proposition قوية', 'duration' => '0:30:00'],
                ['title' => 'نموذج عرض المبيعات Sales Pitch', 'duration' => '0:35:00'],
                ['title' => 'العرض التقديمي Presentation الاحترافي', 'duration' => '0:40:00'],
                ['title' => 'Demo الفعال: عرض المنتج بشكل مقنع', 'duration' => '0:35:00'],
                ['title' => 'Storytelling في المبيعات', 'duration' => '0:28:00'],
                ['title' => 'Social Proof: شهادات العملاء والأرقام', 'duration' => '0:22:00'],
            ],
            'التعامل مع الاعتراضات Objection Handling' => [
                ['title' => 'لماذا الاعتراض فرصة لا عائق؟', 'duration' => '0:18:00'],
                ['title' => 'الاعتراضات الشائعة وردود احترافية', 'duration' => '0:40:00'],
                ['title' => '"السعر غالي": كيف تتعامل معها؟', 'duration' => '0:30:00'],
                ['title' => '"سأفكر في الأمر": إغلاق اللامبالاة', 'duration' => '0:25:00'],
                ['title' => '"لا أحتاجه الآن": خلق الإلحاح', 'duration' => '0:25:00'],
                ['title' => 'تقنية LAER: الاستماع والاعتراف والاستكشاف', 'duration' => '0:30:00'],
            ],
            'إغلاق الصفقات Closing' => [
                ['title' => 'إشارات الشراء: متى تطلب الإغلاق؟', 'duration' => '0:22:00'],
                ['title' => 'تقنيات الإغلاق الكلاسيكية', 'duration' => '0:35:00'],
                ['title' => 'Assumptive Close وSummary Close', 'duration' => '0:28:00'],
                ['title' => 'التفاوض على السعر والشروط', 'duration' => '0:35:00'],
                ['title' => 'التوثيق والعقود', 'duration' => '0:20:00'],
                ['title' => 'تمرين: محاكاة صفقة كاملة', 'duration' => '0:55:00'],
            ],
            'ما بعد البيع: بناء علاقات دائمة' => [
                ['title' => 'Customer Success: نجاح العميل أولًا', 'duration' => '0:22:00'],
                ['title' => 'المتابعة بعد البيع Follow-up', 'duration' => '0:25:00'],
                ['title' => 'Upselling وCross-selling', 'duration' => '0:28:00'],
                ['title' => 'برامج الولاء Loyalty Programs', 'duration' => '0:22:00'],
                ['title' => 'معالجة الشكاوى باحترافية', 'duration' => '0:25:00'],
                ['title' => 'NPS قياس رضا العملاء', 'duration' => '0:20:00'],
            ],
            'إدارة المبيعات والـ CRM' => [
                ['title' => 'Pipeline المبيعات وإدارتها', 'duration' => '0:28:00'],
                ['title' => 'CRM: مقدمة لـ HubSpot وSalesforce', 'duration' => '0:35:00'],
                ['title' => 'تتبع النشاط وتحديث البيانات', 'duration' => '0:22:00'],
                ['title' => 'تقارير المبيعات وتحليل الأداء', 'duration' => '0:30:00'],
                ['title' => 'Sales Forecasting: التنبؤ بالمبيعات', 'duration' => '0:25:00'],
                ['title' => 'أتمتة المبيعات بالأدوات الذكية', 'duration' => '0:30:00'],
            ],
            'المبيعات الرقمية والحديثة' => [
                ['title' => 'مبيعات التجارة الإلكترونية', 'duration' => '0:28:00'],
                ['title' => 'بناء Sales Funnel رقمي', 'duration' => '0:35:00'],
                ['title' => 'Video Selling بالفيديو', 'duration' => '0:25:00'],
                ['title' => 'AI في المبيعات: أدوات تزيد الإنتاجية', 'duration' => '0:30:00'],
                ['title' => 'Remote Selling: البيع عن بُعد', 'duration' => '0:25:00'],
            ],
            'المشروع النهائي: خطة مبيعات كاملة' => [
                ['title' => 'تحليل منتج أو خدمة حقيقية', 'duration' => '0:35:00'],
                ['title' => 'تحديد ICP وبناء Prospecting List', 'duration' => '0:40:00'],
                ['title' => 'كتابة Cold Email وSales Pitch', 'duration' => '0:45:00'],
                ['title' => 'محاكاة المكالمة البيعية كاملة', 'duration' => '0:50:00'],
                ['title' => 'بناء Sales Pipeline وخطة المتابعة', 'duration' => '0:40:00'],
            ],
        ];
    }

    // =========================================================
    // 7. تعلم البرمجة باستخدام أدوات الذكاء الاصطناعي
    // =========================================================
    private function aiProgrammingCurriculum(): array
    {
        return [
            'مقدمة: الذكاء الاصطناعي والبرمجة' => [
                ['title' => 'كيف غيّر AI طريقة تعلم البرمجة؟', 'duration' => '0:18:00'],
                ['title' => 'نظرة على أدوات AI للمطورين', 'duration' => '0:22:00'],
                ['title' => 'إعداد بيئة العمل: VS Code وCursor', 'duration' => '0:25:00'],
                ['title' => 'حسابات ChatGPT وClaude وGemini', 'duration' => '0:15:00'],
                ['title' => 'خريطة الدورة: ماذا ستتعلم؟', 'duration' => '0:10:00'],
            ],
            'أساسيات البرمجة مع Python' => [
                ['title' => 'تثبيت Python وأول برنامج', 'duration' => '0:22:00'],
                ['title' => 'المتغيرات والأنواع: int وstr وfloat وbool', 'duration' => '0:28:00'],
                ['title' => 'المشغلات والتعبيرات', 'duration' => '0:25:00'],
                ['title' => 'الجمل الشرطية if/elif/else', 'duration' => '0:28:00'],
                ['title' => 'الحلقات: for وwhile', 'duration' => '0:30:00'],
                ['title' => 'الدوال Functions والمعاملات', 'duration' => '0:35:00'],
                ['title' => 'القوائم Lists والمعجمات Dictionaries', 'duration' => '0:35:00'],
                ['title' => 'معالجة الأخطاء وException Handling', 'duration' => '0:25:00'],
                ['title' => 'استخدام ChatGPT لشرح الأخطاء وإصلاحها', 'duration' => '0:35:00'],
                ['title' => 'تمرين: بناء برنامج Python بمساعدة AI', 'duration' => '0:50:00'],
            ],
            'Prompt Engineering للمطورين' => [
                ['title' => 'ما هو Prompt Engineering؟', 'duration' => '0:18:00'],
                ['title' => 'هيكل Prompt الفعال', 'duration' => '0:28:00'],
                ['title' => 'تقنية Zero-Shot وFew-Shot', 'duration' => '0:30:00'],
                ['title' => 'Chain of Thought Prompting', 'duration' => '0:25:00'],
                ['title' => 'System Prompts وRole Playing', 'duration' => '0:25:00'],
                ['title' => 'كتابة Prompts لإنشاء كود احترافي', 'duration' => '0:35:00'],
                ['title' => 'تكرير الـ Prompt وتحسين المخرجات', 'duration' => '0:28:00'],
                ['title' => 'تمرين: بناء مكتبة Prompts للبرمجة', 'duration' => '0:40:00'],
            ],
            'GitHub Copilot: المساعد الذكي' => [
                ['title' => 'تثبيت GitHub Copilot في VS Code', 'duration' => '0:18:00'],
                ['title' => 'كيف يعمل Copilot؟', 'duration' => '0:20:00'],
                ['title' => 'إكمال الكود التلقائي Autocomplete', 'duration' => '0:28:00'],
                ['title' => 'Copilot Chat: محادثة داخل المحرر', 'duration' => '0:30:00'],
                ['title' => 'إنشاء Docstrings والتعليقات', 'duration' => '0:22:00'],
                ['title' => 'كتابة Tests بمساعدة Copilot', 'duration' => '0:30:00'],
                ['title' => 'Inline Suggestions والتحكم فيها', 'duration' => '0:22:00'],
                ['title' => 'نصائح للاستخدام الأمثل', 'duration' => '0:25:00'],
            ],
            'Cursor AI: محرر المستقبل' => [
                ['title' => 'ما يميز Cursor عن VS Code العادي', 'duration' => '0:20:00'],
                ['title' => 'Cursor Chat: اشرح ما تريد، Cursor ينفذ', 'duration' => '0:35:00'],
                ['title' => 'Cursor Composer: كتابة ملفات كاملة', 'duration' => '0:35:00'],
                ['title' => 'Apply Edits: تعديل الكود ذكيًا', 'duration' => '0:28:00'],
                ['title' => 'Codebase Context: فهم مشروعك كاملًا', 'duration' => '0:25:00'],
                ['title' => 'بناء تطبيق كامل بـ Cursor فقط', 'duration' => '1:00:00'],
            ],
            'JavaScript مع AI' => [
                ['title' => 'أساسيات JavaScript بمساعدة ChatGPT', 'duration' => '0:35:00'],
                ['title' => 'DOM Manipulation وتوليد كود تلقائي', 'duration' => '0:30:00'],
                ['title' => 'APIs وFetch باستخدام Copilot', 'duration' => '0:35:00'],
                ['title' => 'Async/Await وحل مشاكله بالـ AI', 'duration' => '0:30:00'],
                ['title' => 'مقدمة React بمساعدة Cursor', 'duration' => '0:40:00'],
                ['title' => 'تمرين: تطبيق ويب بـ JS وAI كاملًا', 'duration' => '0:55:00'],
            ],
            'Debugging الذكي' => [
                ['title' => 'أنواع الأخطاء البرمجية', 'duration' => '0:20:00'],
                ['title' => 'شرح الخطأ لـ ChatGPT والحصول على الحل', 'duration' => '0:28:00'],
                ['title' => 'Cursor Debugger المدمج', 'duration' => '0:30:00'],
                ['title' => 'تقنية Rubber Duck Debugging مع AI', 'duration' => '0:22:00'],
                ['title' => 'Stack Overflow مقابل AI: متى تستخدم أيًا؟', 'duration' => '0:20:00'],
                ['title' => 'تمرين: إصلاح 10 أخطاء برمجية حقيقية', 'duration' => '0:50:00'],
            ],
            'Refactoring وتحسين الكود' => [
                ['title' => 'ما هو Code Refactoring؟', 'duration' => '0:18:00'],
                ['title' => 'Clean Code مبادئ الكود النظيف', 'duration' => '0:30:00'],
                ['title' => 'استخدام AI لإعادة كتابة الكود', 'duration' => '0:35:00'],
                ['title' => 'Code Review بمساعدة ChatGPT', 'duration' => '0:30:00'],
                ['title' => 'تحسين الأداء Performance Optimization', 'duration' => '0:28:00'],
                ['title' => 'Security: كشف الثغرات بـ AI', 'duration' => '0:25:00'],
            ],
            'بناء مشاريع حقيقية بـ AI' => [
                ['title' => 'منهجية "Vibe Coding"', 'duration' => '0:20:00'],
                ['title' => 'بناء Chatbot بسيط بـ Python', 'duration' => '0:55:00'],
                ['title' => 'بناء REST API بـ Node.js وCursor', 'duration' => '1:00:00'],
                ['title' => 'بناء تطبيق ويب كامل بـ React', 'duration' => '1:10:00'],
                ['title' => 'نشر المشروع على GitHub وCloudflare', 'duration' => '0:35:00'],
            ],
            'المشروع النهائي: تطبيق كامل بـ AI' => [
                ['title' => 'اختيار فكرة المشروع وتخطيطه', 'duration' => '0:30:00'],
                ['title' => 'تحليل المتطلبات بمساعدة ChatGPT', 'duration' => '0:35:00'],
                ['title' => 'بناء الـ Backend بـ Cursor', 'duration' => '1:10:00'],
                ['title' => 'بناء الـ Frontend بـ Cursor', 'duration' => '1:10:00'],
                ['title' => 'Testing وDebugging الذكي', 'duration' => '0:45:00'],
                ['title' => 'النشر وعرض المشروع', 'duration' => '0:35:00'],
            ],
        ];
    }
}
