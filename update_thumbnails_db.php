<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course;

$map = json_decode(file_get_contents(__DIR__ . '/thumbnail_map.json'), true);

foreach ($map as $id => $paths) {
    $c = Course::find($id);
    if (!$c) continue;
    $c->thumbnail = $paths['thumbnail'];
    $c->banner    = $paths['banner'];
    $c->save();
    echo "✅ Course {$id}: updated thumbnail + banner\n";
}
echo "\n✅ All courses updated\n";
