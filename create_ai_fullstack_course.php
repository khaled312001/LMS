<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;

// ============================================
// STEP 1: CREATE THE COURSE
// ============================================
$course = new Course();
$course->title = 'AI-Powered Full Stack Web & E-commerce Development: From Zero to Production';
$course->slug = 'ai-powered-full-stack-web-ecommerce-development-' . rand(100, 999);
$course->short_description = 'Master full-stack web & e-commerce development using AI tools. Build real projects with Laravel, MERN, and WordPress stacks, then deploy to Hostinger.';
$course->user_id = 4; // Adam Johnson (instructor)
$course->category_id = 1; // Web Development
$course->course_type = 'general';
$course->status = 'active';
$course->level = 'intermediate';
$course->language = 'english';
$course->is_paid = 1;
$course->is_best = 1;
$course->price = 299.99;
$course->discounted_price = 199.99;
$course->discount_flag = 1;
$course->enable_drip_content = 0;
$course->meta_keywords = 'AI Web Development, Full Stack, Laravel, MERN, WordPress, E-commerce, Hostinger, MySQL, MongoDB, React, Node.js, TypeScript, Tailwind, Bootstrap, Cursor AI, ChatGPT, Copilot';
$course->meta_description = 'The complete 24-lesson bootcamp: learn to design, build, and deploy professional websites and online stores using AI tools (Cursor, ChatGPT, Copilot) across Laravel, MERN (MongoDB, Express, React, Node), and WordPress stacks. End with live deployment on Hostinger.';
$course->thumbnail = 'uploads/course-thumbnail/complete-web-development-bootcamp-1768997398.jpg';
$course->banner = 'uploads/course-banner/complete-web-development-bootcamp-1768997398.jpg';
$course->description = '<p><strong>The ultimate 24-lesson AI-powered full-stack web development bootcamp.</strong></p>
<p>Go from absolute zero to launching real-world websites and e-commerce stores with the help of modern AI tools like Cursor, ChatGPT, GitHub Copilot, and Claude. You will build the <em>same</em> e-commerce project three times using three different stacks:</p>
<ol>
<li><strong>Laravel Stack</strong> — PHP 8, MySQL, Blade, Laravel 11</li>
<li><strong>MERN Stack</strong> — MongoDB, Express, React, Node.js, TypeScript</li>
<li><strong>WordPress Stack</strong> — WordPress + WooCommerce + custom themes</li>
</ol>
<p>Every lesson is a multi-hour deep-dive with slides, code walkthroughs, diagrams, and AI-driven workflows. By the end you will deploy a production e-commerce website to <strong>Hostinger</strong> with a live MySQL database, SSL, custom domain, and payment integration.</p>';
$course->requirements = json_encode([
    'A computer with internet connection (Windows, Mac, or Linux)',
    'Basic familiarity with using a web browser',
    'No prior coding experience required',
    'An optional Hostinger account for the final deployment lesson',
    'Willingness to use AI tools (ChatGPT/Claude/Cursor free tiers are enough)'
]);
$course->outcomes = json_encode([
    'Build complete, responsive websites with HTML5, CSS3, JavaScript, Bootstrap and Tailwind',
    'Master React with TypeScript for modern single-page applications',
    'Build server-side APIs with PHP, Laravel, Node.js and Express',
    'Design and query databases in both MySQL and MongoDB',
    'Ship three complete e-commerce projects: Laravel, MERN, and WordPress',
    'Use Cursor AI, GitHub Copilot, ChatGPT and Claude to 10x your coding speed',
    'Integrate real payment gateways (Stripe, PayPal, Razorpay)',
    'Deploy production sites to Hostinger with custom domains, SSL, and MySQL',
    'Apply SEO, security hardening and performance optimization',
    'Read, debug, and refactor code with the help of AI assistants'
]);
$course->faqs = json_encode([
    [
        'title' => 'Do I need prior programming experience?',
        'description' => 'No. The course starts from absolute zero and the AI assistants act as a personal tutor at every step.'
    ],
    [
        'title' => 'Why three stacks instead of one?',
        'description' => 'Because each stack excels in different scenarios. Laravel for classic PHP hosting, MERN for modern SPAs, and WordPress for clients who need a CMS. You graduate employable across all three.'
    ],
    [
        'title' => 'Which AI tools are used?',
        'description' => 'Cursor AI (editor), ChatGPT, Claude, and GitHub Copilot. Free tiers are sufficient for every lesson in this course.'
    ],
    [
        'title' => 'Will I actually deploy a live website?',
        'description' => 'Yes. Lesson 23 walks you step-by-step through deploying your finished e-commerce store to a real Hostinger account with a custom domain and MySQL database.'
    ],
    [
        'title' => 'How long is each lesson?',
        'description' => 'Each of the 24 lessons is a multi-hour deep-dive with a 20-40 slide presentation, code walkthroughs, and hands-on exercises.'
    ]
]);
$course->instructor_ids = json_encode([4]);
$course->average_rating = 5;
$course->save();

$courseId = $course->id;
echo "✅ Course created: ID={$courseId}, slug={$course->slug}\n";

// ============================================
// STEP 2: CREATE 6 SECTIONS
// ============================================
$sections = [
    ['title' => 'Module 1: Foundations & AI-Powered Development Setup', 'sort' => 1],
    ['title' => 'Module 2: Frontend Mastery — HTML, CSS, JS, React & TypeScript', 'sort' => 2],
    ['title' => 'Module 3: PHP & Laravel Full-Stack', 'sort' => 3],
    ['title' => 'Module 4: MERN Stack (MongoDB, Express, React, Node)', 'sort' => 4],
    ['title' => 'Module 5: WordPress & WooCommerce', 'sort' => 5],
    ['title' => 'Module 6: Deployment, SEO, Security & Going Live on Hostinger', 'sort' => 6],
];

$sectionIds = [];
foreach ($sections as $sec) {
    $section = new Section();
    $section->title = $sec['title'];
    $section->sort = $sec['sort'];
    $section->user_id = 4;
    $section->course_id = $courseId;
    $section->save();
    $sectionIds[$sec['sort']] = $section->id;
    echo "✅ Section {$sec['sort']}: {$section->id} - {$sec['title']}\n";
}

// ============================================
// STEP 3: CREATE 24 LESSONS
// ============================================
$lessons = [
    // MODULE 1: Foundations & AI Setup (Lessons 1-4)
    ['section' => 1, 'sort' => 1, 'duration' => '03:30:00', 'title' => 'Lesson 01: The AI-Powered Developer Mindset & How The Web Works'],
    ['section' => 1, 'sort' => 2, 'duration' => '03:15:00', 'title' => 'Lesson 02: Setting Up Your Professional AI-Assisted Workstation'],
    ['section' => 1, 'sort' => 3, 'duration' => '03:45:00', 'title' => 'Lesson 03: Mastering Prompt Engineering & AI Pair-Programming'],
    ['section' => 1, 'sort' => 4, 'duration' => '03:00:00', 'title' => 'Lesson 04: Git, GitHub & AI-Assisted Version Control Workflows'],

    // MODULE 2: Frontend Mastery (Lessons 5-10)
    ['section' => 2, 'sort' => 1, 'duration' => '04:00:00', 'title' => 'Lesson 05: HTML5 — Semantic Markup & Accessible Structure with AI'],
    ['section' => 2, 'sort' => 2, 'duration' => '04:30:00', 'title' => 'Lesson 06: CSS3 Deep Dive — Flexbox, Grid, Animations & Responsive Design'],
    ['section' => 2, 'sort' => 3, 'duration' => '03:45:00', 'title' => 'Lesson 07: Bootstrap 5 & Tailwind CSS — Build Landing Pages Fast with AI'],
    ['section' => 2, 'sort' => 4, 'duration' => '05:00:00', 'title' => 'Lesson 08: JavaScript ES2024 Essentials — From Variables to Async/Await'],
    ['section' => 2, 'sort' => 5, 'duration' => '04:30:00', 'title' => 'Lesson 09: TypeScript & Modern React 19 with Hooks and Context'],
    ['section' => 2, 'sort' => 6, 'duration' => '05:00:00', 'title' => 'Lesson 10: Building a React + TypeScript Storefront UI with AI'],

    // MODULE 3: PHP & Laravel (Lessons 11-14)
    ['section' => 3, 'sort' => 1, 'duration' => '04:30:00', 'title' => 'Lesson 11: PHP 8 Fundamentals & Object-Oriented Programming'],
    ['section' => 3, 'sort' => 2, 'duration' => '04:00:00', 'title' => 'Lesson 12: MySQL Database Design, Relationships & AI-Generated Schemas'],
    ['section' => 3, 'sort' => 3, 'duration' => '05:30:00', 'title' => 'Lesson 13: Laravel 11 Deep Dive — Eloquent, Blade, Auth & API'],
    ['section' => 3, 'sort' => 4, 'duration' => '06:00:00', 'title' => 'Lesson 14: Project #1 — Build a Complete Laravel E-commerce Store'],

    // MODULE 4: MERN Stack (Lessons 15-18)
    ['section' => 4, 'sort' => 1, 'duration' => '04:00:00', 'title' => 'Lesson 15: Node.js & Express — Building REST APIs with TypeScript'],
    ['section' => 4, 'sort' => 2, 'duration' => '04:00:00', 'title' => 'Lesson 16: MongoDB & Mongoose — Schema Design for E-commerce'],
    ['section' => 4, 'sort' => 3, 'duration' => '05:00:00', 'title' => 'Lesson 17: JWT Authentication, Middleware & Secure REST Patterns'],
    ['section' => 4, 'sort' => 4, 'duration' => '06:00:00', 'title' => 'Lesson 18: Project #2 — Build a Complete MERN E-commerce Store'],

    // MODULE 5: WordPress (Lessons 19-20)
    ['section' => 5, 'sort' => 1, 'duration' => '04:00:00', 'title' => 'Lesson 19: WordPress Mastery — Themes, Plugins & the Block Editor'],
    ['section' => 5, 'sort' => 2, 'duration' => '05:30:00', 'title' => 'Lesson 20: Project #3 — Build a WordPress + WooCommerce Store'],

    // MODULE 6: Deployment & Production (Lessons 21-24)
    ['section' => 6, 'sort' => 1, 'duration' => '03:30:00', 'title' => 'Lesson 21: SEO, Analytics & Core Web Vitals with AI Optimization'],
    ['section' => 6, 'sort' => 2, 'duration' => '03:30:00', 'title' => 'Lesson 22: Web Security — OWASP Top 10, HTTPS, and AI Code Review'],
    ['section' => 6, 'sort' => 3, 'duration' => '04:00:00', 'title' => 'Lesson 23: Deploying to Hostinger — Domains, MySQL, SSL & Email'],
    ['section' => 6, 'sort' => 4, 'duration' => '04:30:00', 'title' => 'Lesson 24: Launch, Maintenance, Backups & The AI-Powered Developer Roadmap'],
];

$lessonIds = [];
foreach ($lessons as $l) {
    $lesson = new Lesson();
    $lesson->title = $l['title'];
    $lesson->user_id = 4;
    $lesson->course_id = $courseId;
    $lesson->section_id = $sectionIds[$l['section']];
    $lesson->lesson_type = 'text';
    $lesson->duration = $l['duration'];
    $lesson->sort = $l['sort'];
    $lesson->is_free = ($l['section'] === 1 && $l['sort'] === 1) ? 1 : 0; // First lesson free
    $lesson->description = '<p>Content will be populated by the presentation generator.</p>';
    $lesson->save();
    $lessonIds[] = $lesson->id;
    echo "   📝 Lesson {$lesson->id}: {$l['title']} ({$l['duration']})\n";
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "✅ COURSE CREATED SUCCESSFULLY\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "Course ID: {$courseId}\n";
echo "Slug: {$course->slug}\n";
echo "Sections: " . count($sectionIds) . "\n";
echo "Lessons: " . count($lessonIds) . "\n";
echo "Lesson IDs: " . implode(', ', $lessonIds) . "\n";
echo "═══════════════════════════════════════════════════════════\n";

// Save mapping for the generator script
file_put_contents(
    __DIR__ . '/course_mapping.json',
    json_encode([
        'course_id' => $courseId,
        'course_slug' => $course->slug,
        'section_ids' => $sectionIds,
        'lesson_ids' => $lessonIds,
        'lessons' => $lessons,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);
echo "📁 Mapping saved to course_mapping.json\n";
