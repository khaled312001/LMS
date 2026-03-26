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
            'website_description' => 'منصة Swiss Bridge Academy | تعلم البرمجة والتصميم والتسويق بأسلوب احترافي يجمع بين العربية والإنجليزية، بإدارة سويسرية متميزة.',
            'website_keywords'    => 'Swiss Bridge Academy, تعليم, كورسات, برمجة, تصميم, تسويق, تطوير ويب, دورات تدريبية, سويسرا, تعلم أونلاين',
        ];
        foreach ($settings as $type => $value) {
            if (DB::table('settings')->where('type', $type)->exists()) {
                DB::table('settings')->where('type', $type)->update(['description' => $value]);
            } else {
                DB::table('settings')->insert(['type' => $type, 'description' => $value]);
            }
            $this->info("Setting updated: {$type}");
        }

        // ── 4. Fix seo_fields: clear dummy values ─────────────────────────
        $badPatterns = ['000', 'zzz', 'xxx', 'dummy', 'placeholder'];
        foreach (DB::table('seo_fields')->get() as $field) {
            $updateData = [];
            foreach ($badPatterns as $pattern) {
                if (!empty($field->og_title)        && stripos($field->og_title,        $pattern) !== false) $updateData['og_title']        = null;
                if (!empty($field->og_description)  && stripos($field->og_description,  $pattern) !== false) $updateData['og_description']  = null;
                if (!empty($field->meta_title)      && stripos($field->meta_title,      $pattern) !== false) $updateData['meta_title']      = null;
                if (!empty($field->meta_description)&& stripos($field->meta_description,$pattern) !== false) $updateData['meta_description']= null;
            }
            if (!empty($updateData)) {
                DB::table('seo_fields')->where('id', $field->id)->update($updateData);
                $this->warn("  seo_field #{$field->id} ({$field->name_route}): cleared dummy values");
            }
        }
        $this->info('SEO fields: dummy values cleared');

        // ── 5. Set homepage SEO (route: home) ─────────────────────────────
        $homeData = [
            'name_route'       => 'home',
            'route'            => '/',
            'meta_title'       => 'Swiss Bridge Academy | منصة تعليمية متخصصة',
            'meta_description' => 'تعلم البرمجة والتصميم والتسويق مع خبراء بإدارة سويسرية. دورات احترافية بمزيج عربي-إنجليزي تفتح لك أبواب سوق العمل.',
            'meta_keywords'    => 'Swiss Bridge Academy, برمجة, تصميم, تسويق, تطوير ويب, كورسات, دورات, سويسرا',
            'og_title'         => 'Swiss Bridge Academy | منصة تعليمية متخصصة',
            'og_description'   => 'تعلم البرمجة والتصميم والتسويق مع خبراء بإدارة سويسرية. دورات احترافية بمزيج عربي-إنجليزي تفتح لك أبواب سوق العمل.',
            'meta_robot'       => 'index, follow',
            'updated_at'       => now(),
        ];

        $existing = DB::table('seo_fields')->where('name_route', 'home')->first();
        if ($existing) {
            DB::table('seo_fields')->where('name_route', 'home')->update($homeData);
            $this->info('Homepage SEO: updated');
        } else {
            $homeData['created_at'] = now();
            DB::table('seo_fields')->insert($homeData);
            $this->info('Homepage SEO: inserted');
        }

        // ── 6. Set /courses page SEO ──────────────────────────────────────
        $coursesData = [
            'name_route'       => 'courses',
            'route'            => '/courses',
            'meta_title'       => 'كل الدورات | Swiss Bridge Academy',
            'meta_description' => 'استعرض جميع الدورات التدريبية في البرمجة والتصميم والتسويق. دورات احترافية باللغتين العربية والإنجليزية.',
            'meta_keywords'    => 'دورات تدريبية, كورسات, برمجة, تصميم, تسويق, Swiss Bridge Academy',
            'og_title'         => 'كل الدورات | Swiss Bridge Academy',
            'og_description'   => 'استعرض جميع الدورات التدريبية في البرمجة والتصميم والتسويق. دورات احترافية باللغتين العربية والإنجليزية.',
            'meta_robot'       => 'index, follow',
            'updated_at'       => now(),
        ];

        $existing = DB::table('seo_fields')->where('name_route', 'courses')->first();
        if ($existing) {
            DB::table('seo_fields')->where('name_route', 'courses')->update($coursesData);
            $this->info('/courses SEO: updated');
        } else {
            $coursesData['created_at'] = now();
            DB::table('seo_fields')->insert($coursesData);
            $this->info('/courses SEO: inserted');
        }

        $this->info('Done!');
    }
}
