<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lesson;

$mapping = json_decode(file_get_contents(__DIR__ . '/course_mapping.json'), true);
$lessonIds = $mapping['lesson_ids'];

$outDir = __DIR__ . '/slides_source';
if (!is_dir($outDir)) mkdir($outDir, 0777, true);

echo "Exporting lesson HTMLs for PPTX conversion...\n";

$metaData = [];

foreach ($lessonIds as $i => $id) {
    $n = $i + 1;
    $lesson = Lesson::find($id);
    if (!$lesson) continue;

    $title = $lesson->title;
    $html = $lesson->attachment;
    $slideCount = substr_count($html, '<section style=');

    // Wrap each section in a paginated container (1280x720 slide aspect)
    // We inject CSS to force each <section> to take exactly the viewport size.
    $wrapped = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lesson {$n}</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
    margin: 0;
    padding: 0;
    background: #0a0a0f;
    font-family: -apple-system,BlinkMacSystemFont,'Segoe UI','Inter',sans-serif;
}
.deck section {
    width: 1280px !important;
    height: 720px !important;
    margin: 0 !important;
    border-radius: 0 !important;
    padding: 40px 48px !important;
    overflow: hidden !important;
    display: block !important;
    page-break-after: always;
}
.deck section h2 {
    font-size: 28px !important;
    margin-bottom: 16px !important;
}
.deck section h1 {
    font-size: 36px !important;
}
.deck section p,
.deck section li,
.deck section td,
.deck section th {
    font-size: 13px !important;
    line-height: 1.5 !important;
}
.deck section pre {
    font-size: 11px !important;
    padding: 12px !important;
}
.deck section code {
    font-size: 11px !important;
}
.deck section table {
    font-size: 12px !important;
}
.deck section ul li,
.deck section ol li {
    padding: 7px 12px 7px 36px !important;
    margin: 4px 0 !important;
    font-size: 12px !important;
}
</style>
</head>
<body>
<div class="deck">
{$html}
</div>
</body>
</html>
HTML;

    $filename = sprintf("lesson_%02d.html", $n);
    file_put_contents("{$outDir}/{$filename}", $wrapped);

    $metaData[] = [
        'number' => $n,
        'id'     => $id,
        'title'  => $title,
        'slides' => $slideCount,
        'file'   => $filename,
    ];
    echo "✅ Lesson {$n} ({$slideCount} slides) -> {$filename}\n";
}

file_put_contents(__DIR__ . '/slides_source/lessons_meta.json', json_encode($metaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "\n📁 HTML files + metadata saved to: {$outDir}\n";
echo "Total lessons: " . count($metaData) . "\n";
echo "Total slides: " . array_sum(array_column($metaData, 'slides')) . "\n";
