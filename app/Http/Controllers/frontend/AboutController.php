<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function index()
    {
        // Get statistics
        $page_data['total_students'] = User::where('role', 'student')->count();
        $page_data['total_instructors'] = User::where('role', 'instructor')->count();
        $page_data['total_courses'] = Course::where('status', 'active')->count();
        $page_data['total_enrollments'] = Enrollment::count();
        $page_data['free_courses'] = Course::where('status', 'active')->where('is_paid', 0)->count();
        $page_data['premium_courses'] = Course::where('status', 'active')->where('is_paid', 1)->count();
        $page_data['total_lessons'] = Lesson::count();
        
        // Get featured instructors
        $page_data['instructors'] = User::where('role', 'instructor')
            ->where('status', 1)
            ->inRandomOrder()
            ->take(8)
            ->get();
        
        // Get about us content from settings
        $page_data['about_content'] = get_frontend_settings('about_us');
        
        $theme = get_frontend_settings('theme');
        if (empty($theme) || $theme === false) {
            $theme = 'default';
        }
        $view_path = 'frontend.' . $theme . '.about_us.index';
        return view($view_path, $page_data);
    }
}
