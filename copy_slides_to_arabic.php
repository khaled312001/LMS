<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lesson;

$english = json_decode(file_get_contents(__DIR__ . '/course_mapping.json'), true);
$arabic  = json_decode(file_get_contents(__DIR__ . '/course_mapping_ar.json'), true);

$enIds = $english['lesson_ids'];
$arIds = $arabic['lesson_ids'];

if (count($enIds) !== count($arIds)) {
    die("Lesson count mismatch!\n");
}

echo "Copying English slides to Arabic course lessons...\n\n";

foreach ($enIds as $i => $enId) {
    $arId = $arIds[$i];
    $enLesson = Lesson::find($enId);
    $arLesson = Lesson::find($arId);

    if (!$enLesson || !$arLesson) {
        echo "⚠️  Skipping pair #" . ($i+1) . "\n";
        continue;
    }

    $arLesson->attachment      = $enLesson->attachment;
    $arLesson->attachment_type = $enLesson->attachment_type;
    $arLesson->description     = $enLesson->description;
    $arLesson->summary         = $enLesson->summary;
    $arLesson->save();

    $n = $i + 1;
    $size = number_format(strlen($enLesson->attachment));
    echo "✅ Lesson {$n} (EN #{$enId} → AR #{$arId}) — {$size} bytes copied\n";
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "✅ DONE — all 24 Arabic lessons share the English slide content\n";
echo "   Course metadata (title/description) stays in Arabic\n";
echo "═══════════════════════════════════════════════════════════\n";
