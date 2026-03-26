<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCourseData extends Command
{
    protected $signature = 'courses:update-data';
    protected $description = 'Fix course ratings, languages, SEO settings, and seo_fields';

    public function handle()
    {
        // ── 1. Reviews → rating 5 ──────────────────────────────────────────
        DB::table('reviews')->update(['rating' => 5]);
        $this->info('Reviews: set all to 5');

        // ── 2. Courses → detect language + set rating 5 ───────────────────
        foreach (DB::table('courses')->get() as $course) {
            $isArabic = preg_match('/\p{Arabic}/u', $course->title);
            $lang = $isArabic ? 'arabic' : 'english';
            DB::table('courses')->where('id', $course->id)->update([
                'average_rating' => 5,
                'language'       => $lang,
            ]);
            $this->line("  [{$lang}] {$course->title}");
        }
        $this->info('Courses: language + rating updated');

        // ── 3. Site settings ───────────────────────────────────────────────
        $settings = [
            'system_title'        => 'Swiss Bridge Academy',
            'website_description' => 'منصة Swiss Bridge Academy - تعلم البرمجة والتصميم والتسويق بأسلوب احترافي يجمع بين العربية والإنجليزية، بإدارة سويسرية متميزة.',
            'website_keywords'    => 'Swiss Bridge Academy, تعليم, كورسات, برمجة, تصميم, تسويق, تطوير ويب, دورات تدريبية, سويسرا, تعلم أونلاين',
        ];
        foreach ($settings as $type => $value) {
            if (DB::table('settings')->where('type', $type)->exists()) {
                DB::table('settings')->where('type', $type)->update(['description' => $value]);
            } else {
                DB::table('settings')->insert(['type' => $type, 'description' => $value]);
            }
            $this->info("Setting: {$type} = {$value}");
        }

        // ── 4. Fix seo_fields table - clear dummy OG values ────────────────
        // Clear any seo_field rows that have placeholder/dummy og_title or og_description
        $badPatterns = ['000', 'zzz', 'xxx', 'test', 'example', 'dummy', 'placeholder'];
        $seoFields = DB::table('seo_fields')->get();
        foreach ($seoFields as $field) {
            $needsUpdate = false;
            $updateData  = [];

            foreach ($badPatterns as $pattern) {
                if (!empty($field->og_title) && stripos($field->og_title, $pattern) !== false) {
                    $updateData['og_title'] = '';
                    $needsUpdate = true;
                }
                if (!empty($field->og_description) && stripos($field->og_description, $pattern) !== false) {
                    $updateData['og_description'] = '';
                    $needsUpdate = true;
                }
                if (!empty($field->meta_title) && stripos($field->meta_title, $pattern) !== false) {
                    $updateData['meta_title'] = '';
                    $needsUpdate = true;
                }
                if (!empty($field->meta_description) && stripos($field->meta_description, $pattern) !== false) {
                    $updateData['meta_description'] = '';
                    $needsUpdate = true;
                }
            }

            if ($needsUpdate) {
                DB::table('seo_fields')->where('id', $field->id)->update($updateData);
                $this->warn("  seo_field #{$field->id} ({$field->name_route}): cleared dummy values");
            }
        }
        $this->info('SEO fields: dummy values cleared');

        $this->info('Done!');
    }
}
