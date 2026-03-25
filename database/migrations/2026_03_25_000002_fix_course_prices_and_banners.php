<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $courses = DB::table('courses')->where('language', 'arabic')->get();

        $priceMap = [
            'تطوير الواجهات الأمامية' => 250,
            'تطوير الويب المتكامل Full Stack' => 450,
            'تطوير التطبيقات المحمولة' => 350,
            'التسويق باستخدام أدوات الذكاء الاصطناعي' => 199,
            'التصميم باستخدام أدوات الذكاء الاصطناعي' => 199,
            'دورة المبيعات' => 150,
            'تعلم البرمجة باستخدام أدوات الذكاء الاصطناعي الحديثة' => 299,
        ];
        
        foreach ($courses as $course) {
            $price = $priceMap[$course->title] ?? 199;
            
            DB::table('courses')
                ->where('id', $course->id)
                ->update([
                    'banner' => $course->thumbnail,
                    'is_paid' => 1,
                    'price' => $price
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
