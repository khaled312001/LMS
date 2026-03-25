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
        // Fix 500 server error caused by user_id being NULL on seeded courses
        DB::table('courses')
            ->whereNull('user_id')
            ->update(['user_id' => 1]);

        // Fix course thumbnails
        $thumbnailMap = [
            'تطوير الواجهات الأمامية' => 'uploads/course-thumbnail/ttoyr-aloaghat-alamamy.jpg',
            'تطوير الويب المتكامل Full Stack' => 'uploads/course-thumbnail/ttoyr-aloeb-almtkaml-full-stack.jpg',
            'تطوير التطبيقات المحمولة' => 'uploads/course-thumbnail/ttoyr-alttbykat-alhmol.jpg',
            'التسويق باستخدام أدوات الذكاء الاصطناعي' => 'uploads/course-thumbnail/altsyok-bastkhdam-adoat-althkaaa-alastnaaay.jpg',
            'التصميم باستخدام أدوات الذكاء الاصطناعي' => 'uploads/course-thumbnail/altsmym-bastkhdam-adoat-althkaaa-alastnaaay.jpg',
            'دورة المبيعات' => 'uploads/course-thumbnail/dor-almbyaaat.jpg',
            'تعلم البرمجة باستخدام أدوات الذكاء الاصطناعي الحديثة' => 'uploads/course-thumbnail/taalm-albrmg-bastkhdam.jpg'
        ];

        foreach ($thumbnailMap as $title => $path) {
            DB::table('courses')->where('title', $title)->update([
                'thumbnail' => $path
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
