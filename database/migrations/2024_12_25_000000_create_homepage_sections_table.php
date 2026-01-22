<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('homepage_sections')) {
            Schema::create('homepage_sections', function (Blueprint $table) {
                $table->id();
                $table->string('section_key')->unique(); // مثل: banner, hero, courses, testimonials
                $table->string('section_name'); // اسم القسم بالعربي/إنجليزي
                $table->text('title')->nullable(); // عنوان القسم
                $table->text('subtitle')->nullable(); // عنوان فرعي
                $table->longText('content')->nullable(); // محتوى القسم (HTML)
                $table->text('description')->nullable(); // وصف القسم
                $table->integer('sort_order')->default(0); // ترتيب القسم
                $table->boolean('is_active')->default(true); // تفعيل/تعطيل القسم
                $table->json('settings')->nullable(); // إعدادات إضافية (JSON)
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_sections');
    }
};
