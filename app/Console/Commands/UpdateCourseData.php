<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCourseData extends Command
{
    protected $signature = 'courses:update-data';
    protected $description = 'Set all course ratings to 5 and language to Arabic, English';

    public function handle()
    {
        $reviews = DB::table('reviews')->update(['rating' => 5]);
        $this->info("Reviews updated: {$reviews} rows");

        $courses = DB::table('courses')->update([
            'average_rating' => 5,
            'language' => 'Arabic, English',
        ]);
        $this->info("Courses updated: {$courses} rows");

        $this->info('Done!');
    }
}
