<?php

namespace App\Http\Controllers;

use App\Models\Payment_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function syncData()
    {
        // Set all reviews to rating 5
        DB::table('reviews')->update(['rating' => 5]);

        // Detect language from title and set average_rating = 5
        foreach (DB::table('courses')->get() as $course) {
            $isArabic = preg_match('/\p{Arabic}/u', $course->title);
            DB::table('courses')->where('id', $course->id)->update([
                'average_rating' => 5,
                'language'       => $isArabic ? 'arabic' : 'english',
            ]);
        }

        // Update site settings
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
        }

        // Clear dummy seo_fields values
        $badPatterns = ['000', 'zzz', 'xxx', 'dummy', 'placeholder'];
        foreach (DB::table('seo_fields')->get() as $field) {
            $updateData = [];
            foreach ($badPatterns as $p) {
                if (!empty($field->og_title)         && stripos($field->og_title,         $p) !== false) $updateData['og_title']         = null;
                if (!empty($field->og_description)   && stripos($field->og_description,   $p) !== false) $updateData['og_description']   = null;
                if (!empty($field->meta_title)       && stripos($field->meta_title,       $p) !== false) $updateData['meta_title']       = null;
                if (!empty($field->meta_description) && stripos($field->meta_description, $p) !== false) $updateData['meta_description'] = null;
            }
            if (!empty($updateData)) {
                DB::table('seo_fields')->where('id', $field->id)->update($updateData);
            }
        }

        // Set homepage SEO
        $homeData = [
            'name_route' => 'home', 'route' => '/',
            'meta_title' => 'Swiss Bridge Academy | منصة تعليمية متخصصة',
            'meta_description' => 'تعلم البرمجة والتصميم والتسويق مع خبراء بإدارة سويسرية. دورات احترافية بمزيج عربي-إنجليزي.',
            'og_title'   => 'Swiss Bridge Academy | منصة تعليمية متخصصة',
            'og_description' => 'تعلم البرمجة والتصميم والتسويق مع خبراء بإدارة سويسرية. دورات احترافية بمزيج عربي-إنجليزي.',
            'meta_robot' => 'index, follow', 'updated_at' => now(),
        ];
        if (DB::table('seo_fields')->where('name_route', 'home')->exists()) {
            DB::table('seo_fields')->where('name_route', 'home')->update($homeData);
        } else {
            DB::table('seo_fields')->insert(array_merge($homeData, ['created_at' => now()]));
        }

        return back()->with('success', 'تم تحديث البيانات بنجاح ✓');
    }

    public function index()
    {

        $monthly_amount = array(0);
        for ($i = 1; $i <= 12; $i++) {
            $total_amount = date('t', strtotime(date("Y-$i-1 00:00:00")));
            $amount       = Payment_history::whereDate('created_at', '>=', date("Y-$i-1 00:00:00"))->whereDate('created_at', '<=', date("Y-$i-$total_amount 23:59:59"))->get();
            if (count($amount) > 0) {
                array_push($monthly_amount, array_sum($amount->pluck('admin_revenue')->toArray()));
            } else {
                array_push($monthly_amount, 0);
            }
        }
        $page_data['monthly_amount'] = $monthly_amount;
        return view('admin.dashboard.index', $page_data);
    }
}
