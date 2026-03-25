<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $englishCourses = [
            [
                'title' => 'Front-End Web Development',
                'short_description' => 'Learn to build modern, responsive web interfaces using HTML, CSS, JavaScript, and React in a practical learning approach that combines explanation, application, and modern tools to boost productivity.',
                'description' => '<p>The Front-End Development program is designed to help students gain a practical and modern understanding of building website interfaces and web applications. It focuses on developing skills in structuring web pages, building clear interface components, and turning ideas into modern, responsive user experiences.</p><p>Learning in this program is highly practical, relying on direct explanation, step-by-step application, and working on exercises and projects while utilizing modern tools and technologies.</p>',
                'outcomes' => json_encode([
                    "Building modern and responsive web pages",
                    "Practical understanding of HTML, CSS, and JavaScript basics",
                    "Developing interactive interfaces using React",
                    "Handling interface components and in-app navigation",
                    "Improving workflow using modern tools and techniques",
                    "Building a strong foundation to start a professional Front-End career"
                ]),
                'requirements' => json_encode([
                    "No advanced prior experience required",
                    "Basic knowledge of using a computer and the internet",
                    "A desire for practical learning and building modern digital skills",
                    "Commitment to practice during the program"
                ]),
                'technologies' => json_encode([
                    "HTML5", "CSS3", "JavaScript", "React", "Git / GitHub", "Responsive Design", "Flexbox", "CSS Grid", "DOM Manipulation", "REST API Basics"
                ]),
                'faqs' => json_encode([
                    ['title' => "Do I need prior experience?", 'description' => "Not necessarily, the appropriate level will be determined before starting."],
                    ['title' => "Is the program practical?", 'description' => "Yes, it relies on explanation, application, and practical projects."],
                    ['title' => "Does the program include React?", 'description' => "Yes, it covers React basics and building modern interactive interfaces."],
                    ['title' => "Will I receive a certificate?", 'description' => "Yes, students receive a certificate of completion upon successfully finishing requirements."]
                ]),
                'thumbnail' => 'uploads/course-thumbnail/ttoyr-aloaghat-alamamy.jpg',
                'price' => 250
            ],
            [
                'title' => 'Full Stack Web Development',
                'short_description' => 'A comprehensive journey to learn creating complete web applications, from interactive interfaces (Front-End) to building back-end systems and managing databases (Back-End) using Node.js.',
                'description' => '<p>The Full Stack Web Development program is an integrated journey for learning how to build complete web applications. It covers everything from designing interactive user interfaces using Front-End technologies to setting up back-end servers and databases using Node.js and Express.</p>',
                'outcomes' => json_encode([
                    "Building complete applications from scratch to deployment",
                    "Linking Back-End with Front-End securely",
                    "Designing and managing databases efficiently",
                    "Understanding server operations",
                    "Developing faster workflow using modern tools",
                    "A strong foundation to launch a Full Stack career"
                ]),
                'requirements' => json_encode([
                    "Basic knowledge of web concepts",
                    "Commitment to applying concepts sequentially",
                    "A desire to understand how systems work behind the scenes",
                    "Sufficient time for application and project building"
                ]),
                'technologies' => json_encode([
                    "Node.js", "Express.js", "MongoDB", "REST APIs", "Authentication", "Git / GitHub", "Front-End Basics", "Deployment"
                ]),
                'faqs' => json_encode([
                    ['title' => "Is this program suitable for beginners?", 'description' => "Yes, but it requires commitment to gradual learning and continuous practice."],
                    ['title' => "Does it include both Front-End and Back-End?", 'description' => "Yes, the program covers both sides in an integrated track."],
                    ['title' => "Will I learn React and Node.js?", 'description' => "Yes, both are essential parts of this program."],
                    ['title' => "Is there a final project?", 'description' => "Yes, the program includes a complete Full Stack project."]
                ]),
                'thumbnail' => 'uploads/course-thumbnail/ttoyr-aloeb-almtkaml-full-stack.jpg',
                'price' => 450
            ],
            [
                'title' => 'Mobile App Development',
                'short_description' => 'Learn to build modern mobile apps for iOS and Android using cross-platform technologies (like React Native), focusing heavily on practical projects.',
                'description' => '<p>This program offers a practical approach to building smart device applications, from understanding the core structure to programming interfaces and linking data.</p>',
                'outcomes' => json_encode([
                    "Building functional applications matching UI design",
                    "Understanding App navigation",
                    "Managing app state efficiently",
                    "Linking with Back-End via APIs",
                    "Using modern methods supporting rapid development"
                ]),
                'requirements' => json_encode([
                    "Basic knowledge of programming logic",
                    "Willingness to learn and search for solutions",
                    "Commitment to completing assignments"
                ]),
                'technologies' => json_encode([
                    "React Native", "JavaScript / ES6", "React Navigation", "State Management", "API Integration", "Mobile UI Design"
                ]),
                'faqs' => json_encode([
                    ['title' => "Do I need prior experience?", 'description' => "Not necessarily, the appropriate level will be determined before starting."],
                    ['title' => "Is it for iOS or Android?", 'description' => "Yes, the program focuses on developing cross-platform applications."],
                    ['title' => "Does it include Backend integration?", 'description' => "Yes, it includes understanding how to integrate with Node.js in the background."],
                    ['title' => "Is there a practical project?", 'description' => "Yes, the program includes an integrated practical project."]
                ]),
                'thumbnail' => 'uploads/course-thumbnail/ttoyr-alttbykat-alhmol.jpg',
                'price' => 350
            ],
            [
                'title' => 'AI-Powered Digital Marketing',
                'short_description' => 'A practical program focusing on organizing marketing efforts and accelerating results using AI tools in content creation and ad management.',
                'description' => '<p>This program is designed to help trainees understand how modern marketing works and how to utilize AI tools to improve performance.</p>',
                'outcomes' => json_encode([
                    "Deep understanding of digital marketing basics",
                    "Creating structured and targeted content using AI",
                    "Managing ad campaigns efficiently",
                    "Making better decisions based on metrics",
                    "Building a practical foundation applicable in work"
                ]),
                'requirements' => json_encode([
                    "No prior marketing experience required",
                    "Interest in understanding the business environment",
                    "Willingness to apply concepts on real or mock projects"
                ]),
                'technologies' => json_encode([
                    "ChatGPT & AI Tools", "Social Media Management", "Content Strategy", "SEO Basics", "Ad Platforms (Meta, Google)", "Analytics Tools"
                ]),
                'faqs' => json_encode([
                    ['title' => "Is the program suitable for beginners?", 'description' => "Yes, it is suitable for beginners and those looking to develop their current skills."],
                    ['title' => "Does it focus only on AI?", 'description' => "No, the main focus is on marketing, using AI as a supporting tool."],
                    ['title' => "Does it include content marketing?", 'description' => "Yes, it includes practical content in creating and organizing marketing content."],
                    ['title' => "Are there practical applications?", 'description' => "Yes, it includes practical applications and a final project."]
                ]),
                'thumbnail' => 'uploads/course-thumbnail/altsyok-bastkhdam-adoat-althkaaa-alastnaaay.jpg',
                'price' => 199
            ],
            [
                'title' => 'AI-Powered Design',
                'short_description' => 'Learn how to utilize AI design tools to produce visual ideas quickly and practically, supporting content creation.',
                'description' => '<p>This program focuses on introducing participants to the latest AI-driven design tools and platforms, enabling them to generate and refine visual content efficiently.</p>',
                'outcomes' => json_encode([
                    "Producing high-quality visual content faster",
                    "Understanding basics of generating images via prompts",
                    "Improving visual feed for projects",
                    "Building a foundation for professional growth"
                ]),
                'requirements' => json_encode([
                    "No advanced design experience needed",
                    "Good taste and eye for detail",
                    "Willingness to explore new digital tools"
                ]),
                'technologies' => json_encode([
                    "Midjourney / DALL-E", "Figma Basics", "Canva Flow", "Generative AI", "Prompt Engineering for Design"
                ]),
                'faqs' => json_encode([
                    ['title' => "Is the program suitable for beginners?", 'description' => "Yes, suitable for beginners and those looking to develop current skills."],
                    ['title' => "Does it include modern tools?", 'description' => "Yes, modern tools and techniques are integrated practically into the program."],
                    ['title' => "Do I need prior design experience?", 'description' => "Not necessarily, the level is evaluated before starting."],
                    ['title' => "Is there a final project?", 'description' => "Yes, the program includes a final project or an initial portfolio."]
                ]),
                'thumbnail' => 'uploads/course-thumbnail/altsmym-bastkhdam-adoat-althkaaa-alastnaaay.jpg',
                'price' => 199
            ],
            [
                'title' => 'Sales Mastery',
                'short_description' => 'A practical program focusing on core sales fundamentals, understanding client needs, and building long-term relationships.',
                'description' => '<p>Designed for individuals who want to develop practical sales skills, learn negotiation techniques, and boost conversion rates professionally.</p>',
                'outcomes' => json_encode([
                    "Understanding modern sales methodologies",
                    "Building strong client relationships",
                    "Improving negotiation skills",
                    "Using modern methods supporting efficiency",
                    "Acquiring applicable skills in various environments"
                ]),
                'requirements' => json_encode([
                    "No prior sales experience required",
                    "Good communication skills",
                    "Willingness to train on real-world scenarios"
                ]),
                'technologies' => json_encode([
                    "CRM Systems Basics", "Communication Tools", "Sales Pipeline Management", "Negotiation Strategies", "Lead Generation"
                ]),
                'faqs' => json_encode([
                    ['title' => "Is the program suitable for beginners?", 'description' => "Yes, suitable for beginners and those who want to build a strong foundation in sales."],
                    ['title' => "Does it focus on the practical side?", 'description' => "Yes, it relies on understanding and practical application on real scenarios."],
                    ['title' => "Do I need prior experience?", 'description' => "Not necessarily, your level is evaluated at the start."],
                    ['title' => "Is there an evaluation or final project?", 'description' => "Yes, the program includes an evaluation or a final practical project."]
                ]),
                'thumbnail' => 'uploads/course-thumbnail/dor-almbyaaat.jpg',
                'price' => 150
            ],
            [
                'title' => 'Learning Programming with Modern AI Tools',
                'short_description' => 'A revolutionary approach to learning programming using AI tools, accelerating understanding and maximizing coding output from day one.',
                'description' => '<p>The "Learning Programming with Modern AI Tools" program represents a quality shift in how programming skills are learned today. The focus is no longer just on memorizing code, but on how to use AI as a personal assistant.</p>',
                'outcomes' => json_encode([
                    "Learn programming fundamentals alongside AI implementation",
                    "Building working applications instantly",
                    "Mastering intelligent debugging techniques",
                    "Acquiring indispensable market-ready skills"
                ]),
                'requirements' => json_encode([
                    "No prior programming knowledge required",
                    "Basic understanding of computers",
                    "Desire to embrace AI and modern tech"
                ]),
                'technologies' => json_encode([
                    "Python", "JavaScript", "Cursor AI Editor", "GitHub Copilot", "ChatGPT for Code", "Prompt Engineering for Devs"
                ]),
                'faqs' => json_encode([
                    ['title' => "Can I learn if I know nothing?", 'description' => "Yes, it covers basics from scratch, and AI will make complex concepts easier."],
                    ['title' => "Will AI replace learning basics?", 'description' => "No, AI is a powerful tool to double productivity, but it requires a developer who understands logic to guide it."],
                    ['title' => "What tools and languages are focused on?", 'description' => "We will focus on languages like Python and JavaScript with intensive use of editors like Cursor AI."],
                    ['title' => "Is the program practical?", 'description' => "100% practical. You will create your own code and programs from day one using AI."]
                ]),
                'thumbnail' => 'uploads/course-thumbnail/taalm-albrmg-bastkhdam.jpg',
                'price' => 299
            ]
        ];

        foreach ($englishCourses as $courseData) {
            
            // Check if already exists to prevent duplication
            $exists = DB::table('courses')
                ->where('title', $courseData['title'])
                ->where('language', 'english')
                ->exists();

            if (!$exists) {
                $slug = Str::slug($courseData['title']) . '-' . rand(100, 999);
                
                DB::table('courses')->insert([
                    'title' => $courseData['title'],
                    'short_description' => $courseData['short_description'],
                    'description' => $courseData['description'],
                    'outcomes' => $courseData['outcomes'],
                    'requirements' => $courseData['requirements'],
                    'technologies' => $courseData['technologies'],
                    'faqs' => $courseData['faqs'],
                    'thumbnail' => $courseData['thumbnail'] ?? null,
                    'banner' => $courseData['thumbnail'] ?? null,
                    'slug' => $slug,
                    'user_id' => 1,
                    'status' => 'active',
                    'language' => 'english',
                    'category_id' => 1,
                    'is_paid' => 1,
                    'price' => $courseData['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
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
