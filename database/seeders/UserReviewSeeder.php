<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserReview;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get student users
        $students = User::where('role', 'student')->get();
        
        if ($students->isEmpty()) {
            $this->command->warn('No student users found. Please create student users first.');
            return;
        }

        // Demo review text
        $demoReviewText = "The industry's standard dummy text ever since the unknown printer took a galley of type and scrambled";

        // Additional demo review texts for variety
        $demoReviews = [
            "The industry's standard dummy text ever since the unknown printer took a galley of type and scrambled",
            "This platform has transformed my learning experience. The courses are well-structured and the instructors are knowledgeable.",
            "I've learned so much from the courses here. The content is comprehensive and easy to follow.",
            "Excellent platform with high-quality courses. Highly recommended for anyone looking to improve their skills.",
            "The best learning platform I've used. The interactive lessons make learning enjoyable and effective.",
            "Outstanding courses and great support. I've seen significant improvement in my skills.",
            "Amazing learning experience! The platform is user-friendly and the content is top-notch.",
            "Great value for money. The courses are detailed and the instructors are responsive to questions.",
        ];

        // Clear existing user reviews (optional - comment out if you want to keep existing data)
        // UserReview::truncate();

        // Create 8 demo reviews
        $reviewCount = min(8, count($demoReviews));
        
        for ($i = 0; $i < $reviewCount; $i++) {
            // Get a random student (cycle through if needed)
            $student = $students->get($i % $students->count());
            
            // Use the demo text provided by user for first review, then use variety
            $reviewText = $i === 0 ? $demoReviewText : $demoReviews[$i];
            
            // Create review with rating between 4 and 5 stars
            UserReview::create([
                'user_id' => $student->id,
                'rating' => rand(4, 5),
                'review' => $reviewText,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('Demo user reviews created successfully!');
    }
}
