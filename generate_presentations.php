<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

require_once __DIR__ . '/lesson_contents_part1.php';
require_once __DIR__ . '/lesson_contents_part2.php';
require_once __DIR__ . '/lesson_contents_part3.php';
require_once __DIR__ . '/lesson_contents_part4.php';
require_once __DIR__ . '/lesson_contents_part5.php';

use App\Models\Lesson;

$mapping = json_decode(file_get_contents(__DIR__ . '/course_mapping.json'), true);
$lessonIds = $mapping['lesson_ids'];

echo "═══════════════════════════════════════════════════════════\n";
echo "  Generating Presentations for 24 Lessons\n";
echo "═══════════════════════════════════════════════════════════\n";

$totalSlides = 0;
$totalChars  = 0;

for ($i = 1; $i <= 24; $i++) {
    $fnName = sprintf('lesson_%02d_content', $i);
    if (!function_exists($fnName)) {
        echo "⚠️  Missing function: {$fnName}\n";
        continue;
    }

    $html = $fnName();

    // Post-process: replace any remaining class-based code tags with inline styles
    $codeInline = 'background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);color:#a5b4fc;padding:2px 8px;border-radius:4px;font-size:0.9em;font-family:\'Fira Code\',Consolas,monospace;';
    $html = preg_replace('/<code class="sba-inline">/', '<code style="' . $codeInline . '">', $html);
    // Any leftover class="sba-*" attributes can be removed
    $html = preg_replace('/\sclass="sba-[^"]*"/', '', $html);

    $slideCount = substr_count($html, '<section style=');
    $chars = strlen($html);

    $lessonId = $lessonIds[$i - 1];
    $lesson = Lesson::find($lessonId);
    if (!$lesson) {
        echo "⚠️  Lesson {$lessonId} not found\n";
        continue;
    }

    $lesson->attachment      = $html;
    $lesson->attachment_type = 'text';
    $lesson->description     = $html;
    $lesson->summary         = "Professional {$slideCount}-slide presentation covering this lesson end-to-end.";
    $lesson->save();

    $totalSlides += $slideCount;
    $totalChars  += $chars;

    echo sprintf("✅ Lesson %02d (ID=%d): %d slides, %s bytes — %s\n",
        $i, $lessonId, $slideCount, number_format($chars), substr($lesson->title, 0, 60));
}

echo "═══════════════════════════════════════════════════════════\n";
echo "  COMPLETE\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "Total slides: {$totalSlides}\n";
echo "Total content: " . number_format($totalChars) . " bytes (" . round($totalChars / 1024) . " KB)\n";
echo "═══════════════════════════════════════════════════════════\n";
