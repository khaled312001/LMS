<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Enrollment;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Payment_history;
use App\Models\Coupon;
use App\Models\Certificate;
use App\Models\Watch_history;
use App\Models\WatchDuration;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogLike;
use App\Models\MessageThread;
use App\Models\Message;
use App\Models\Setting;
use App\Models\CartItem;
use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use App\Models\Newsletter;
use App\Models\Live_class;
use App\Models\Bootcamp;
use App\Models\BootcampCategory;
use App\Models\TutorCategory;
use App\Models\TutorSubject;
use App\Models\TutorCanTeach;
use App\Models\TutorSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing data (optional - comment out if you want to keep existing data)
        // $this->command->info('Clearing existing data...');
        // $this->truncateTables();

        $this->command->info('Seeding demo data...');

        // Seed in order to maintain relationships
        $admin = $this->seedUsers();
        $categories = $this->seedCategories();
        $instructors = User::where('role', 'instructor')->get();
        $students = User::where('role', 'student')->get();
        
        $courses = $this->seedCourses($instructors, $categories);
        $this->seedSectionsAndLessons($courses, $instructors);
        $this->seedQuizzesAndQuestions($courses);
        $this->seedEnrollments($courses, $students);
        $this->seedReviews($courses, $students);
        $this->seedWishlists($courses, $students);
        $this->seedPayments($courses, $students);
        $this->seedCoupons();
        $this->seedCertificates($courses, $students);
        $this->seedWatchHistory($courses, $students);
        $this->seedWatchDurations($courses, $students);
        $this->seedBlogs($instructors);
        $this->seedMessages($instructors, $students);
        $this->seedSettings();
        $this->seedCartItems($courses, $students);
        $this->seedContacts();
        $this->seedNewsletterSubscribers();
        $this->seedNewsletters();
        $this->seedLiveClasses($courses, $instructors);
        $this->seedBootcamps($instructors);
        $this->seedTutors($instructors);

        $this->command->info('Demo data seeded successfully!');
    }

    private function seedUsers()
    {
        $this->command->info('Seeding users...');

        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@lms.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 1,
                'email_verified_at' => now(),
                'about' => 'System Administrator with 10+ years of experience in education technology.',
                'photo' => null,
            ]
        );

        // Instructors
        $instructorNames = [
            'John Smith', 'Sarah Johnson', 'Michael Brown', 'Emily Davis', 
            'David Wilson', 'Lisa Anderson', 'Robert Taylor', 'Jennifer Martinez'
        ];

        $instructorSkills = [
            'Web Development, JavaScript, React, Node.js',
            'Data Science, Python, Machine Learning, AI',
            'Graphic Design, UI/UX, Adobe Creative Suite',
            'Digital Marketing, SEO, Social Media',
            'Mobile Development, iOS, Android, Flutter',
            'Photography, Video Editing, Adobe Premiere',
            'Business Strategy, Entrepreneurship, Leadership',
            'Cybersecurity, Ethical Hacking, Network Security'
        ];

        $instructorBios = [
            'Full-stack developer with expertise in modern web technologies. Passionate about teaching and helping students build real-world applications.',
            'Data scientist and AI researcher. Published author and speaker at international conferences.',
            'Award-winning graphic designer with 15 years of experience. Specializes in brand identity and user interface design.',
            'Digital marketing expert with proven track record of growing businesses online. Google Ads and Facebook Ads certified.',
            'Mobile app developer with 50+ published apps. Expert in cross-platform development.',
            'Professional photographer and videographer. Worked with major brands and celebrities.',
            'Business consultant and entrepreneur. Helped launch 100+ successful startups.',
            'Cybersecurity expert and ethical hacker. Certified in multiple security frameworks.'
        ];

        foreach ($instructorNames as $index => $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@instructor.com';
            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'instructor',
                    'status' => 1,
                    'email_verified_at' => now(),
                    'skills' => $instructorSkills[$index],
                    'about' => $instructorBios[$index],
                    'photo' => null,
                ]
            );
        }

        // Students
        $studentNames = [
            'Alice Johnson', 'Bob Williams', 'Carol White', 'Daniel Black',
            'Emma Green', 'Frank Miller', 'Grace Lee', 'Henry Brown',
            'Ivy Chen', 'Jack Davis', 'Kate Wilson', 'Liam Moore',
            'Mia Taylor', 'Noah Anderson', 'Olivia Thomas', 'Paul Jackson',
            'Quinn Harris', 'Rachel Martin', 'Sam Thompson', 'Tina Garcia'
        ];

        foreach ($studentNames as $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@student.com';
            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'status' => 1,
                    'email_verified_at' => now(),
                    'about' => 'Enthusiastic learner passionate about acquiring new skills and knowledge.',
                    'photo' => null,
                ]
            );
        }

        return $admin;
    }

    private function seedCategories()
    {
        $this->command->info('Seeding categories...');

        $parentCategories = [
            ['title' => 'Web Development', 'slug' => 'web-development', 'icon' => 'code'],
            ['title' => 'Data Science', 'slug' => 'data-science', 'icon' => 'chart'],
            ['title' => 'Design', 'slug' => 'design', 'icon' => 'palette'],
            ['title' => 'Marketing', 'slug' => 'marketing', 'icon' => 'megaphone'],
            ['title' => 'Business', 'slug' => 'business', 'icon' => 'briefcase'],
            ['title' => 'Photography', 'slug' => 'photography', 'icon' => 'camera'],
        ];

        $categories = [];

        foreach ($parentCategories as $parent) {
            $parentCategory = Category::firstOrCreate(
                ['slug' => $parent['slug']],
                [
                    'parent_id' => 0,
                    'title' => $parent['title'],
                    'icon' => $parent['icon'],
                    'sort' => 0,
                    'status' => 1,
                    'keywords' => $parent['title'] . ', online course, learn ' . strtolower($parent['title']),
                    'description' => 'Learn ' . $parent['title'] . ' with our comprehensive courses.',
                    'thumbnail' => null,
                ]
            );

            $categories[] = $parentCategory;

            // Create subcategories
            $subcategories = $this->getSubcategories($parent['title']);
            foreach ($subcategories as $sub) {
                $subSlug = Str::slug($sub);
                $subCategory = Category::firstOrCreate(
                    ['slug' => $subSlug, 'parent_id' => $parentCategory->id],
                    [
                        'title' => $sub,
                        'icon' => null,
                        'sort' => 0,
                        'status' => 1,
                        'keywords' => $sub . ', ' . $parent['title'],
                        'description' => 'Learn ' . $sub . ' in ' . $parent['title'],
                        'thumbnail' => null,
                    ]
                );
                $categories[] = $subCategory;
            }
        }

        return $categories;
    }

    private function getSubcategories($parent)
    {
        $subcategories = [
            'Web Development' => ['HTML/CSS', 'JavaScript', 'React', 'Vue.js', 'Node.js', 'PHP', 'Laravel'],
            'Data Science' => ['Python', 'Machine Learning', 'Data Analysis', 'Deep Learning', 'Statistics'],
            'Design' => ['UI/UX Design', 'Graphic Design', 'Web Design', 'Logo Design', 'Illustration'],
            'Marketing' => ['Digital Marketing', 'SEO', 'Social Media', 'Content Marketing', 'Email Marketing'],
            'Business' => ['Entrepreneurship', 'Management', 'Finance', 'Leadership', 'Strategy'],
            'Photography' => ['Portrait Photography', 'Landscape Photography', 'Product Photography', 'Video Editing'],
        ];

        return $subcategories[$parent] ?? [];
    }

    private function seedCourses($instructors, $categories)
    {
        $this->command->info('Seeding courses...');

        $courseData = [
            [
                'title' => 'Complete Web Development Bootcamp',
                'short_description' => 'Master web development from scratch. Learn HTML, CSS, JavaScript, React, and Node.js.',
                'course_type' => 'general',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 99.99,
                'discount_flag' => 1,
                'discounted_price' => 79.99,
                'status' => 'active',
            ],
            [
                'title' => 'Advanced JavaScript and React',
                'short_description' => 'Deep dive into modern JavaScript and React development patterns.',
                'course_type' => 'general',
                'level' => 'intermediate',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 149.99,
                'discount_flag' => 0,
                'discounted_price' => null,
                'status' => 'active',
            ],
            [
                'title' => 'Python for Data Science',
                'short_description' => 'Learn Python programming and data analysis with real-world projects.',
                'course_type' => 'general',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 89.99,
                'discount_flag' => 1,
                'discounted_price' => 69.99,
                'status' => 'active',
            ],
            [
                'title' => 'Machine Learning Masterclass',
                'short_description' => 'Comprehensive machine learning course covering algorithms and practical applications.',
                'course_type' => 'general',
                'level' => 'advanced',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 199.99,
                'discount_flag' => 0,
                'discounted_price' => null,
                'status' => 'active',
            ],
            [
                'title' => 'UI/UX Design Fundamentals',
                'short_description' => 'Learn the principles of user interface and user experience design.',
                'course_type' => 'general',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 79.99,
                'discount_flag' => 1,
                'discounted_price' => 59.99,
                'status' => 'active',
            ],
            [
                'title' => 'Digital Marketing Complete Guide',
                'short_description' => 'Master digital marketing strategies including SEO, social media, and content marketing.',
                'course_type' => 'general',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 119.99,
                'discount_flag' => 0,
                'discounted_price' => null,
                'status' => 'active',
            ],
            [
                'title' => 'Mobile App Development with Flutter',
                'short_description' => 'Build cross-platform mobile apps using Flutter framework.',
                'course_type' => 'general',
                'level' => 'intermediate',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 129.99,
                'discount_flag' => 1,
                'discounted_price' => 99.99,
                'status' => 'active',
            ],
            [
                'title' => 'Professional Photography Course',
                'short_description' => 'Learn professional photography techniques and post-processing.',
                'course_type' => 'general',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 89.99,
                'discount_flag' => 0,
                'discounted_price' => null,
                'status' => 'active',
            ],
            [
                'title' => 'Cybersecurity Essentials',
                'short_description' => 'Learn cybersecurity fundamentals and ethical hacking techniques.',
                'course_type' => 'general',
                'level' => 'intermediate',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 159.99,
                'discount_flag' => 1,
                'discounted_price' => 129.99,
                'status' => 'active',
            ],
            [
                'title' => 'Business Strategy and Leadership',
                'short_description' => 'Develop strategic thinking and leadership skills for business success.',
                'course_type' => 'general',
                'level' => 'advanced',
                'language' => 'English',
                'is_paid' => 1,
                'price' => 179.99,
                'discount_flag' => 0,
                'discounted_price' => null,
                'status' => 'active',
            ],
        ];

        $courses = [];
        $categoryIndex = 0;

        foreach ($courseData as $index => $data) {
            $instructor = $instructors->random();
            $category = $categories[($categoryIndex % count($categories))];
            $categoryIndex++;

            $slug = Str::slug($data['title']);
            $course = Course::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'short_description' => $data['short_description'],
                    'user_id' => $instructor->id,
                    'category_id' => $category->id,
                    'course_type' => $data['course_type'],
                    'status' => $data['status'],
                    'level' => $data['level'],
                    'language' => $data['language'],
                    'is_paid' => $data['is_paid'],
                    'price' => $data['price'],
                    'discount_flag' => $data['discount_flag'],
                    'discounted_price' => $data['discounted_price'],
                    'meta_keywords' => $data['title'] . ', online course, learn, tutorial',
                    'meta_description' => $data['short_description'],
                    'description' => $this->generateDescription($data['title']),
                    'requirements' => 'Basic computer skills, internet connection, willingness to learn',
                    'outcomes' => 'Master the fundamentals, build real-world projects, gain practical experience',
                    'faqs' => json_encode([
                        ['question' => 'Is this course suitable for beginners?', 'answer' => 'Yes, this course is designed for all skill levels.'],
                        ['question' => 'How long do I have access?', 'answer' => 'Lifetime access to all course materials.'],
                    ]),
                    'instructor_ids' => json_encode([$instructor->id]),
                    'thumbnail' => null,
                    'banner' => null,
                    'preview' => null,
                ]
            );

            $courses[] = $course;
        }

        return collect($courses);
    }

    private function generateDescription($title)
    {
        return "This comprehensive course will take you from beginner to advanced level. You'll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you'll have the skills and confidence to apply what you've learned in professional settings.";
    }

    private function seedSectionsAndLessons($courses, $instructors)
    {
        $this->command->info('Seeding sections and lessons...');

        $lessonTypes = ['video', 'text', 'quiz', 'assignment'];
        $durations = ['00:10:00', '00:15:00', '00:20:00', '00:25:00', '00:30:00', '00:45:00'];

        foreach ($courses as $course) {
            // Create 4-6 sections per course
            $numSections = rand(4, 6);
            $sections = [];

            for ($i = 1; $i <= $numSections; $i++) {
                $section = Section::create([
                    'user_id' => $course->user_id,
                    'course_id' => $course->id,
                    'title' => "Section $i: " . $this->getSectionTitle($i),
                    'sort' => $i,
                ]);
                $sections[] = $section;
            }

            // Create lessons for each section
            $lessonSort = 1;
            foreach ($sections as $section) {
                $numLessons = rand(3, 6);
                
                for ($j = 1; $j <= $numLessons; $j++) {
                    $lessonType = $lessonTypes[array_rand($lessonTypes)];
                    $duration = $durations[array_rand($durations)];
                    $isFree = ($j === 1) ? 1 : 0; // First lesson is free

                    Lesson::create([
                        'title' => "Lesson $lessonSort: " . $this->getLessonTitle($lessonSort),
                        'user_id' => $course->user_id,
                        'course_id' => $course->id,
                        'section_id' => $section->id,
                        'lesson_type' => $lessonType,
                        'duration' => $duration,
                        'lesson_src' => $lessonType === 'video' ? 'https://example.com/video.mp4' : null,
                        'thumbnail' => null,
                        'is_free' => $isFree,
                        'sort' => $lessonSort,
                        'description' => "Learn important concepts in this comprehensive lesson.",
                        'status' => 1,
                    ]);

                    $lessonSort++;
                }
            }
        }
    }

    private function getSectionTitle($index)
    {
        $titles = [
            'Introduction and Setup',
            'Core Concepts',
            'Advanced Topics',
            'Practical Applications',
            'Best Practices',
            'Final Project',
        ];
        return $titles[($index - 1) % count($titles)];
    }

    private function getLessonTitle($index)
    {
        $titles = [
            'Getting Started',
            'Understanding the Basics',
            'Working with Variables',
            'Control Structures',
            'Functions and Methods',
            'Object-Oriented Programming',
            'Working with APIs',
            'Database Integration',
            'Testing and Debugging',
            'Deployment Strategies',
        ];
        return $titles[($index - 1) % count($titles)];
    }

    private function seedQuizzesAndQuestions($courses)
    {
        $this->command->info('Seeding quizzes and questions...');

        foreach ($courses as $course) {
            // Create 2-3 quizzes per course
            $numQuizzes = rand(2, 3);
            $sections = Section::where('course_id', $course->id)->get();

            if ($sections->isEmpty()) {
                continue;
            }

            for ($i = 0; $i < $numQuizzes; $i++) {
                $section = $sections->random();
                
                // Format duration as HH:MM:SS
                $hours = rand(0, 1);
                $minutes = rand(30, 60);
                $seconds = 0;
                $duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                
                $quiz = Quiz::create([
                    'user_id' => $course->user_id,
                    'title' => 'Quiz ' . ($i + 1) . ': ' . $section->title,
                    'section_id' => $section->id,
                    'duration' => $duration,
                    'total_mark' => 100,
                    'pass_mark' => 60,
                    'drip_rule' => 0,
                    'summary' => 'This quiz covers the key concepts from ' . $section->title . '. Make sure to review the material before attempting.',
                    'attempts' => json_encode(['max' => 3]),
                    'sort' => $i + 1,
                ]);

                // Create questions for this quiz
                $numQuestions = rand(10, 15);
                for ($j = 1; $j <= $numQuestions; $j++) {
                    $questionType = ['multiple_choice', 'true_false'][array_rand(['multiple_choice', 'true_false'])];
                    
                    if ($questionType === 'multiple_choice') {
                        $options = [
                            'Option A: Correct Answer',
                            'Option B: Incorrect',
                            'Option C: Incorrect',
                            'Option D: Incorrect',
                        ];
                        $answer = 'Option A: Correct Answer';
                    } else {
                        $options = ['True', 'False'];
                        $answer = rand(0, 1) ? 'True' : 'False';
                    }

                    Question::create([
                        'quiz_id' => $quiz->id,
                        'title' => "Question $j: What is the correct answer?",
                        'type' => $questionType,
                        'answer' => $answer,
                        'options' => json_encode($options),
                        'sort' => $j,
                    ]);
                }
            }
        }
    }

    private function seedEnrollments($courses, $students)
    {
        $this->command->info('Seeding enrollments...');

        foreach ($courses as $course) {
            // Enroll 5-10 random students in each course
            $numEnrollments = rand(5, 10);
            $selectedStudents = $students->random(min($numEnrollments, $students->count()));

            foreach ($selectedStudents as $student) {
                $enrollmentType = ['lifetime', 'subscription'][array_rand(['lifetime', 'subscription'])];
                
                $enrollmentData = [
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'enrollment_type' => $enrollmentType,
                    'entry_date' => time(),
                ];

                // For lifetime enrollments, expiry_date is null
                // For subscription enrollments, set expiry_date as Unix timestamp
                if ($enrollmentType === 'subscription') {
                    $months = rand(1, 12);
                    $enrollmentData['expiry_date'] = strtotime("+{$months} months");
                } else {
                    $enrollmentData['expiry_date'] = null;
                }

                Enrollment::create($enrollmentData);
            }
        }
    }

    private function seedReviews($courses, $students)
    {
        $this->command->info('Seeding reviews...');

        foreach ($courses as $course) {
            $enrolledStudents = Enrollment::where('course_id', $course->id)
                ->pluck('user_id')
                ->toArray();

            // Create 3-8 reviews per course
            $numReviews = rand(3, 8);
            $reviewedStudents = collect($enrolledStudents)->random(min($numReviews, count($enrolledStudents)));

            foreach ($reviewedStudents as $studentId) {
                Review::create([
                    'user_id' => $studentId,
                    'course_id' => $course->id,
                    'rating' => rand(3, 5),
                    'review_type' => 'course',
                    'review' => $this->generateReviewText(),
                ]);
            }
        }
    }

    private function generateReviewText()
    {
        $reviews = [
            'Excellent course! Very well structured and easy to follow.',
            'Great instructor, clear explanations, and practical examples.',
            'This course exceeded my expectations. Highly recommended!',
            'Learned a lot from this course. The content is comprehensive.',
            'Good course for beginners. The pace is just right.',
            'Amazing course! The instructor explains everything clearly.',
            'Very informative and well-organized course material.',
            'Great value for money. I learned so much!',
        ];
        return $reviews[array_rand($reviews)];
    }

    private function seedWishlists($courses, $students)
    {
        $this->command->info('Seeding wishlists...');

        foreach ($students as $student) {
            // Add 2-5 random courses to each student's wishlist
            $numWishlist = rand(2, 5);
            $wishlistCourses = $courses->random(min($numWishlist, $courses->count()));

            foreach ($wishlistCourses as $course) {
                // Only add if not already enrolled
                $enrolled = Enrollment::where('user_id', $student->id)
                    ->where('course_id', $course->id)
                    ->exists();

                if (!$enrolled) {
                    Wishlist::create([
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                    ]);
                }
            }
        }
    }

    private function seedPayments($courses, $students)
    {
        $this->command->info('Seeding payment histories...');

        foreach ($courses as $course) {
            if ($course->is_paid) {
                $enrollments = Enrollment::where('course_id', $course->id)->get();

                foreach ($enrollments as $enrollment) {
                    $amount = $course->discounted_price ?? $course->price;
                    $adminRevenue = $amount * 0.3; // 30% admin
                    $instructorRevenue = $amount * 0.7; // 70% instructor

                    Payment_history::create([
                        'user_id' => $enrollment->user_id,
                        'course_id' => $course->id,
                        'payment_type' => ['stripe', 'paypal', 'bank_transfer'][array_rand(['stripe', 'paypal', 'bank_transfer'])],
                        'amount' => $amount,
                        'admin_revenue' => $adminRevenue,
                        'instructor_revenue' => $instructorRevenue,
                        'tax' => $amount * 0.1, // 10% tax
                        'coupon' => null,
                        'invoice' => 'INV-' . strtoupper(Str::random(10)),
                        'instructor_payment_status' => rand(0, 1),
                        'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                        'session_id' => 'SESS-' . strtoupper(Str::random(10)),
                    ]);
                }
            }
        }
    }

    private function seedCoupons()
    {
        $this->command->info('Seeding coupons...');

        $coupons = [
            ['code' => 'WELCOME10', 'discount' => 10.00, 'expiry' => Carbon::now()->addMonths(3)],
            ['code' => 'SUMMER20', 'discount' => 20.00, 'expiry' => Carbon::now()->addMonths(2)],
            ['code' => 'STUDENT15', 'discount' => 15.00, 'expiry' => Carbon::now()->addMonths(6)],
            ['code' => 'NEWYEAR25', 'discount' => 25.00, 'expiry' => Carbon::now()->addMonths(1)],
            ['code' => 'BULK30', 'discount' => 30.00, 'expiry' => Carbon::now()->addMonths(4)],
        ];

        foreach ($coupons as $coupon) {
            Coupon::firstOrCreate(
                ['code' => $coupon['code']],
                [
                    'user_id' => null,
                    'discount' => $coupon['discount'],
                    'expiry' => $coupon['expiry']->format('Y-m-d'),
                ]
            );
        }
    }

    private function seedCertificates($courses, $students)
    {
        $this->command->info('Seeding certificates...');

        foreach ($courses as $course) {
            $enrollments = Enrollment::where('course_id', $course->id)->get();
            
            // Issue certificates to 30-50% of enrolled students
            $numCertificates = (int)($enrollments->count() * (rand(30, 50) / 100));
            $certifiedStudents = $enrollments->random(min($numCertificates, $enrollments->count()));

            foreach ($certifiedStudents as $enrollment) {
                Certificate::create([
                    'user_id' => $enrollment->user_id,
                    'course_id' => $course->id,
                    'identifier' => 'CERT-' . strtoupper(Str::random(12)),
                    'created_at' => Carbon::now()->subDays(rand(1, 90)),
                ]);
            }
        }
    }

    private function seedWatchHistory($courses, $students)
    {
        $this->command->info('Seeding watch history...');

        foreach ($courses as $course) {
            $enrollments = Enrollment::where('course_id', $course->id)->get();
            $lessons = Lesson::where('course_id', $course->id)->get();

            foreach ($enrollments as $enrollment) {
                // Mark 30-80% of lessons as completed
                $numCompleted = (int)($lessons->count() * (rand(30, 80) / 100));
                $completedLessons = $lessons->random(min($numCompleted, $lessons->count()));
                
                // Get lesson IDs as array
                $completedLessonIds = $completedLessons->pluck('id')->toArray();
                
                // completed_date is only set when course is 100% complete, otherwise null
                // For demo purposes, set it if completion is 100%, otherwise null
                $completedDate = (count($completedLessonIds) == $lessons->count()) ? time() : null;
                
                // Check if watch history already exists for this student and course
                $watchHistory = Watch_history::where('course_id', $course->id)
                    ->where('student_id', $enrollment->user_id)
                    ->first();
                
                if ($watchHistory) {
                    // Update existing record
                    $watchHistory->update([
                        'completed_lesson' => json_encode($completedLessonIds),
                        'watching_lesson_id' => $completedLessons->last()->id ?? null,
                        'completed_date' => $completedDate,
                    ]);
                } else {
                    // Create new record
                    Watch_history::create([
                        'course_id' => $course->id,
                        'student_id' => $enrollment->user_id,
                        'completed_lesson' => json_encode($completedLessonIds),
                        'watching_lesson_id' => $completedLessons->last()->id ?? null,
                        'completed_date' => $completedDate,
                    ]);
                }
            }
        }
    }

    private function seedWatchDurations($courses, $students)
    {
        $this->command->info('Seeding watch durations...');

        foreach ($courses as $course) {
            $enrollments = Enrollment::where('course_id', $course->id)->get();
            $lessons = Lesson::where('course_id', $course->id)->get();

            foreach ($enrollments as $enrollment) {
                $watchedLessons = $lessons->random(rand(1, min(5, $lessons->count())));

                foreach ($watchedLessons as $lesson) {
                    // Parse duration (format: HH:MM:SS)
                    $durationParts = explode(':', $lesson->duration);
                    $totalSeconds = ($durationParts[0] * 3600) + ($durationParts[1] * 60) + ($durationParts[2] ?? 0);
                    $watchedSeconds = (int)($totalSeconds * (rand(20, 100) / 100)); // 20-100% watched

                    WatchDuration::create([
                        'watched_student_id' => $enrollment->user_id,
                        'watched_course_id' => $course->id,
                        'watched_lesson_id' => $lesson->id,
                        'current_duration' => $watchedSeconds,
                        'watched_counter' => json_encode(['count' => rand(1, 5)]),
                    ]);
                }
            }
        }
    }

    private function seedBlogs($instructors)
    {
        $this->command->info('Seeding blogs...');

        // Create blog categories
        $blogCategories = [
            ['title' => 'Technology', 'slug' => 'technology'],
            ['title' => 'Education', 'slug' => 'education'],
            ['title' => 'Tips & Tricks', 'slug' => 'tips-tricks'],
            ['title' => 'Industry News', 'slug' => 'industry-news'],
        ];

        $categoryIds = [];
        foreach ($blogCategories as $cat) {
            $category = BlogCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'title' => $cat['title'],
                    'subtitle' => $cat['title'] . ' Articles',
                ]
            );
            $categoryIds[] = $category->id;
        }

        $blogTitles = [
            '10 Essential Web Development Tools for 2024',
            'How to Start Your Career in Data Science',
            'The Future of Online Learning',
            'Best Practices for UI/UX Design',
            'Digital Marketing Trends You Should Know',
            'Building Your First Mobile App',
            'Photography Tips for Beginners',
            'Cybersecurity: Protecting Your Digital Life',
            'Leadership Skills Every Professional Needs',
            'How to Stay Motivated While Learning Online',
        ];

        foreach ($blogTitles as $index => $title) {
            $blog = Blog::firstOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'user_id' => $instructors->random()->id,
                    'category_id' => $categoryIds[$index % count($categoryIds)],
                    'title' => $title,
                    'description' => $this->generateBlogContent($title),
                    'thumbnail' => null,
                    'banner' => null,
                    'keywords' => $title . ', blog, article',
                    'is_popular' => rand(0, 1),
                    'status' => 1,
                ]
            );

            // Create some comments and likes
            $students = User::where('role', 'student')->get();
            $commenters = $students->random(rand(2, 5));

            foreach ($commenters as $commenter) {
                BlogComment::create([
                    'blog_id' => $blog->id,
                    'user_id' => $commenter->id,
                    'comment' => $this->generateComment(),
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }

            $likers = $students->random(rand(5, 15));
            foreach ($likers as $liker) {
                BlogLike::create([
                    'blog_id' => $blog->id,
                    'user_id' => $liker->id,
                ]);
            }
        }
    }

    private function generateBlogContent($title)
    {
        return "In this comprehensive article, we'll explore " . strtolower($title) . ". This topic is crucial for anyone looking to advance their skills and knowledge. We'll cover the fundamentals, best practices, and real-world applications. Whether you're a beginner or an experienced professional, you'll find valuable insights in this guide.";
    }

    private function generateComment()
    {
        $comments = [
            'Great article! Very informative.',
            'Thanks for sharing these insights.',
            'This helped me understand the topic better.',
            'Excellent write-up. Looking forward to more!',
            'Very useful information. Thank you!',
        ];
        return $comments[array_rand($comments)];
    }

    private function seedMessages($instructors, $students)
    {
        $this->command->info('Seeding messages...');

        // Create message threads between students and instructors
        foreach ($students->take(10) as $student) {
            $instructor = $instructors->random();
            
            $thread = MessageThread::create([
                'code' => 'THREAD-' . strtoupper(Str::random(10)),
                'contact_one' => $student->id,
                'contact_two' => $instructor->id,
            ]);

            // Create 3-8 messages in each thread
            $numMessages = rand(3, 8);
            for ($i = 0; $i < $numMessages; $i++) {
                $sender = ($i % 2 === 0) ? $student : $instructor;
                $receiver = ($i % 2 === 0) ? $instructor : $student;

                Message::create([
                    'thread_id' => $thread->id,
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id,
                    'message' => $this->generateMessage(),
                    'read' => ($i < $numMessages - 1) ? 1 : 0, // Last message unread
                ]);
            }
        }
    }

    private function generateMessage()
    {
        $messages = [
            'Hello, I have a question about the course material.',
            'Thank you for your help!',
            'Could you explain this concept in more detail?',
            'I really enjoyed the lesson. Great job!',
            'When will the next lesson be available?',
            'I need some clarification on the assignment.',
        ];
        return $messages[array_rand($messages)];
    }

    private function seedSettings()
    {
        $this->command->info('Seeding settings...');

        $settings = [
            ['type' => 'system_name', 'description' => 'Academy LMS'],
            ['type' => 'system_email', 'description' => 'admin@lms.com'],
            ['type' => 'system_title', 'description' => 'Academy Learning Management System'],
            ['type' => 'language', 'description' => 'english'],
            ['type' => 'currency', 'description' => 'USD'],
            ['type' => 'paypal', 'description' => '1'],
            ['type' => 'stripe', 'description' => '1'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }

    private function seedCartItems($courses, $students)
    {
        $this->command->info('Seeding cart items...');

        foreach ($students->take(5) as $student) {
            $cartCourses = $courses->where('is_paid', 1)->random(rand(1, 3));

            foreach ($cartCourses as $course) {
                // Only add if not enrolled and not in wishlist
                $enrolled = Enrollment::where('user_id', $student->id)
                    ->where('course_id', $course->id)
                    ->exists();
                
                $inWishlist = Wishlist::where('user_id', $student->id)
                    ->where('course_id', $course->id)
                    ->exists();

                if (!$enrolled && !$inWishlist) {
                    CartItem::create([
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                    ]);
                }
            }
        }
    }

    private function seedContacts()
    {
        $this->command->info('Seeding contacts...');

        $contactMessages = [
            'I would like to know more about your courses.',
            'How do I become an instructor?',
            'I have a question about pricing.',
            'Can you help me with technical support?',
            'I want to provide feedback on the platform.',
        ];

        foreach ($contactMessages as $message) {
            Contact::create([
                'name' => 'Contact User ' . rand(1, 100),
                'email' => 'contact' . rand(1, 100) . '@example.com',
                'phone' => '+1' . rand(1000000000, 9999999999),
                'address' => '123 Main St, City, State',
                'message' => $message,
                'has_read' => rand(0, 1),
                'replied' => rand(0, 1),
            ]);
        }
    }

    private function seedNewsletterSubscribers()
    {
        $this->command->info('Seeding newsletter subscribers...');

        for ($i = 0; $i < 15; $i++) {
            NewsletterSubscriber::create([
                'email' => 'subscriber' . $i . '@example.com',
            ]);
        }
    }

    private function seedNewsletters()
    {
        $this->command->info('Seeding newsletters...');

        $newsletters = [
            ['subject' => 'Welcome to Our Platform', 'body' => 'Thank you for subscribing to our newsletter!'],
            ['subject' => 'New Courses Available', 'body' => 'Check out our latest courses and special offers.'],
            ['subject' => 'Weekly Learning Tips', 'body' => 'Here are some tips to help you learn more effectively.'],
        ];

        foreach ($newsletters as $newsletter) {
            Newsletter::create([
                'subject' => $newsletter['subject'],
                'description' => $newsletter['body'],
            ]);
        }
    }

    private function seedLiveClasses($courses, $instructors)
    {
        $this->command->info('Seeding live classes...');

        foreach ($courses->take(5) as $course) {
            Live_class::create([
                'course_id' => $course->id,
                'user_id' => $course->user_id,
                'class_topic' => 'Live Q&A Session: ' . $course->title,
                'provider' => ['Zoom', 'Google Meet', 'Microsoft Teams'][array_rand(['Zoom', 'Google Meet', 'Microsoft Teams'])],
                'class_date_and_time' => Carbon::now()->addDays(rand(1, 30))->addHours(rand(1, 12)),
                'additional_info' => 'Join us for an interactive Q&A session about ' . $course->title,
                'note' => 'Please join 5 minutes early to test your connection.',
            ]);
        }
    }

    private function seedBootcamps($instructors)
    {
        $this->command->info('Seeding bootcamps...');

        // Create bootcamp categories
        $bootcampCategories = [
            ['title' => 'Web Development', 'slug' => 'web-development'],
            ['title' => 'Data Science', 'slug' => 'data-science'],
            ['title' => 'Mobile Development', 'slug' => 'mobile-development'],
            ['title' => 'Digital Marketing', 'slug' => 'digital-marketing'],
            ['title' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
        ];

        $categoryIds = [];
        foreach ($bootcampCategories as $category) {
            $cat = BootcampCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
            $categoryIds[] = $cat->id;
        }

        // Create bootcamps
        $bootcampTitles = [
            'Full Stack Web Development Bootcamp',
            'Python Data Science Masterclass',
            'React Native Mobile App Development',
            'Complete Digital Marketing Course',
            'UI/UX Design Fundamentals',
            'Advanced JavaScript Bootcamp',
            'Machine Learning with Python',
            'iOS App Development with Swift',
            'Social Media Marketing Bootcamp',
            'Figma UI Design Course',
        ];

        foreach ($bootcampTitles as $index => $title) {
            $instructor = $instructors->random();
            $slug = Str::slug($title);
            
            Bootcamp::firstOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $instructor->id,
                    'title' => $title,
                    'slug' => $slug,
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'description' => 'This comprehensive bootcamp covers all the essential topics you need to master ' . $title . '. Learn from industry experts and build real-world projects.',
                    'short_description' => 'Master ' . $title . ' with hands-on projects and expert guidance.',
                    'is_paid' => rand(0, 1),
                    'price' => rand(0, 1) ? rand(50, 500) : 0,
                    'discount_flag' => rand(0, 1),
                    'discounted_price' => rand(0, 1) ? rand(30, 400) : null,
                    'publish_date' => Carbon::now()->subDays(rand(1, 100))->timestamp,
                    'thumbnail' => null,
                    'faqs' => json_encode([
                        ['title' => 'What will I learn?', 'description' => 'You will learn all the fundamentals and advanced concepts.'],
                        ['title' => 'How long is the bootcamp?', 'description' => 'The bootcamp runs for 12 weeks with flexible scheduling.'],
                    ]),
                    'requirements' => json_encode(['Basic computer skills', 'Internet connection', 'Dedication to learn']),
                    'outcomes' => json_encode(['Build real-world projects', 'Get job-ready skills', 'Receive a certificate']),
                    'meta_keywords' => $title . ', bootcamp, online course, learn',
                    'meta_description' => 'Learn ' . $title . ' with our comprehensive bootcamp.',
                    'status' => 1,
                ]
            );
        }
    }

    private function seedTutors($instructors)
    {
        $this->command->info('Seeding tutors...');

        // Create tutor categories
        $tutorCategories = [
            ['name' => 'Mathematics', 'slug' => 'mathematics', 'status' => 1],
            ['name' => 'Science', 'slug' => 'science', 'status' => 1],
            ['name' => 'Programming', 'slug' => 'programming', 'status' => 1],
            ['name' => 'Languages', 'slug' => 'languages', 'status' => 1],
            ['name' => 'Business', 'slug' => 'business', 'status' => 1],
            ['name' => 'Arts', 'slug' => 'arts', 'status' => 1],
        ];

        $tutorCategoryIds = [];
        foreach ($tutorCategories as $category) {
            $cat = TutorCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
            $tutorCategoryIds[] = $cat->id;
        }

        // Create tutor subjects
        $tutorSubjects = [
            ['name' => 'Algebra', 'slug' => 'algebra', 'status' => 1],
            ['name' => 'Calculus', 'slug' => 'calculus', 'status' => 1],
            ['name' => 'Physics', 'slug' => 'physics', 'status' => 1],
            ['name' => 'Chemistry', 'slug' => 'chemistry', 'status' => 1],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'status' => 1],
            ['name' => 'Python', 'slug' => 'python', 'status' => 1],
            ['name' => 'English', 'slug' => 'english', 'status' => 1],
            ['name' => 'Spanish', 'slug' => 'spanish', 'status' => 1],
            ['name' => 'Marketing', 'slug' => 'marketing', 'status' => 1],
            ['name' => 'Finance', 'slug' => 'finance', 'status' => 1],
            ['name' => 'Drawing', 'slug' => 'drawing', 'status' => 1],
            ['name' => 'Music', 'slug' => 'music', 'status' => 1],
        ];

        $tutorSubjectIds = [];
        foreach ($tutorSubjects as $subject) {
            $sub = TutorSubject::firstOrCreate(
                ['slug' => $subject['slug']],
                $subject
            );
            $tutorSubjectIds[] = $sub->id;
        }

        // Update some instructors to have tutor profiles (add video_url and biography)
        $tutorInstructors = $instructors->take(10);
        foreach ($tutorInstructors as $instructor) {
            $instructor->update([
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'biography' => 'Experienced tutor with ' . rand(5, 15) . ' years of teaching experience. Specialized in helping students achieve their academic goals.',
            ]);
        }

        // Create tutor_can_teach entries (linking tutors to subjects and categories)
        foreach ($tutorInstructors as $instructor) {
            $numSubjects = rand(2, 4);
            $selectedSubjects = collect($tutorSubjectIds)->random($numSubjects);
            
            foreach ($selectedSubjects as $subjectId) {
                // Determine category based on subject
                $categoryId = $tutorCategoryIds[array_rand($tutorCategoryIds)];
                
                TutorCanTeach::firstOrCreate(
                    [
                        'instructor_id' => $instructor->id,
                        'category_id' => $categoryId,
                        'subject_id' => $subjectId,
                    ],
                    [
                        'instructor_id' => $instructor->id,
                        'category_id' => $categoryId,
                        'subject_id' => $subjectId,
                        'price' => rand(20, 100),
                    ]
                );
            }
        }

        // Create tutor schedules
        foreach ($tutorInstructors as $instructor) {
            $canTeach = TutorCanTeach::where('instructor_id', $instructor->id)->get();
            
            if ($canTeach->count() > 0) {
                // Create 5-10 schedules per tutor
                $numSchedules = rand(5, 10);
                
                for ($i = 0; $i < $numSchedules; $i++) {
                    $teach = $canTeach->random();
                    // Create schedules starting from today, spread over next 30 days
                    $daysOffset = rand(0, 30);
                    $hour = rand(9, 18);
                    $minute = rand(0, 59);
                    $startTime = Carbon::today()->addDays($daysOffset)->addHours($hour)->addMinutes($minute)->timestamp;
                    $duration = rand(30, 120); // minutes
                    $endTime = $startTime + ($duration * 60);
                    
                    $subject = TutorSubject::find($teach->subject_id);
                    TutorSchedule::create([
                        'tutor_id' => $instructor->id,
                        'category_id' => $teach->category_id,
                        'subject_id' => $teach->subject_id,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'duration' => $duration,
                        'description' => 'One-on-one tutoring session for ' . ($subject ? $subject->name : 'Subject'),
                        'tution_type' => rand(0, 2), // 0=online, 1=offline, 2=both
                        'status' => 1,
                        'booking_id' => null,
                    ]);
                }
            }
        }
    }
}
