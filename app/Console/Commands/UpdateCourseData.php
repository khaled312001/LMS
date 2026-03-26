<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCourseData extends Command
{
    protected $signature = 'courses:update-data';
    protected $description = 'Fix course ratings, languages, and SEO site settings';

    public function handle()
    {
        // ── 1. Reviews → rating 5 ──────────────────────────────────────────
        $reviews = DB::table('reviews')->update(['rating' => 5]);
        $this->info("Reviews updated: {$reviews} rows");

        // ── 2. Courses → detect language + set rating 5 ───────────────────
        $courses = DB::table('courses')->get();
        $updated = 0;
        foreach ($courses as $course) {
            $isArabic = preg_match('/\p{Arabic}/u', $course->title);
            $lang = $isArabic ? 'arabic' : 'english';
            DB::table('courses')->where('id', $course->id)->update([
                'average_rating' => 5,
                'language'       => $lang,
            ]);
            $updated++;
            $this->line("  [{$lang}] {$course->title}");
        }
        $this->info("Courses updated: {$updated} rows");

        // ── 3. SEO / Site settings ─────────────────────────────────────────
        $settings = [
            'system_title'       => 'Swiss Bridge Academy',
            'website_description'=> 'منصة Swiss Bridge Academy - تعلم البرمجة والتصميم والتسويق بأسلوب احترافي يجمع بين العربية والإنجليزية، بإدارة سويسرية متميزة.',
            'website_keywords'   => 'Swiss Bridge Academy, تعليم, كورسات, برمجة, تصميم, تسويق, تطوير ويب, دورات تدريبية, سويسرا, تعلم أونلاين',
        ];

        foreach ($settings as $type => $value) {
            $exists = DB::table('settings')->where('type', $type)->exists();
            if ($exists) {
                DB::table('settings')->where('type', $type)->update(['description' => $value]);
                $this->info("Setting updated: {$type}");
            } else {
                DB::table('settings')->insert(['type' => $type, 'description' => $value]);
                $this->info("Setting inserted: {$type}");
            }
        }

        $this->info('Done!');
    }
}
