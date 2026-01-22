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
        Schema::table('homepage_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('homepage_sections', 'image')) {
                $table->string('image')->nullable()->after('content');
            }
            if (!Schema::hasColumn('homepage_sections', 'video_url')) {
                $table->string('video_url')->nullable()->after('image');
            }
            if (!Schema::hasColumn('homepage_sections', 'design_type')) {
                $table->string('design_type')->default('default')->after('video_url'); // default, image_left, image_right, full_width, grid, etc.
            }
            if (!Schema::hasColumn('homepage_sections', 'background_color')) {
                $table->string('background_color')->nullable()->after('design_type');
            }
            if (!Schema::hasColumn('homepage_sections', 'text_color')) {
                $table->string('text_color')->nullable()->after('background_color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_sections', function (Blueprint $table) {
            $table->dropColumn(['image', 'video_url', 'design_type', 'background_color', 'text_color']);
        });
    }
};
