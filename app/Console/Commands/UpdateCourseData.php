<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCourseData extends Command
{
    protected $signature = 'courses:update-data';
    protected $description = 'Set course ratings to 5 and detect language from title (arabic/english)';

    public function handle()
    {
        // Update all reviews to 5
        $reviews = DB::table('reviews')->update(['rating' => 5]);
        $this->info("Reviews updated: {$reviews} rows");

        // Update average_rating and detect language from title
        $courses = DB::table('courses')->get();
        $updated = 0;
        foreach ($courses as $course) {
            // Detect Arabic by checking for Arabic Unicode characters in title
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
        $this->info('Done!');
    }
}
