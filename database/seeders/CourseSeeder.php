<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Category;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding courses with complete content...');

        // Get instructors and categories
        $instructors = User::where('role', 'instructor')->get();
        $categories = Category::all();

        if ($instructors->isEmpty() || $categories->isEmpty()) {
            $this->command->error('Please seed users and categories first!');
            return;
        }

        // Course data from SQL file with complete information
        $coursesData = [
            [
                'title' => 'Complete Web Development Bootcamp',
                'slug' => 'complete-web-development-bootcamp',
                'short_description' => 'Master web development from scratch. Learn HTML, CSS, JavaScript, React, and Node.js.',
                'category_id' => $categories->where('title', 'Web Development')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 4)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 99.99,
                'discounted_price' => 79.99,
                'discount_flag' => 1,
                'enable_drip_content' => 1,
                'drip_content_settings' => json_encode([
                    'lesson_completion_role' => 'percentage',
                    'minimum_duration' => 15,
                    'minimum_percentage' => '90',
                    'locked_lesson_message' => '<h3 style="text-align: center;"><span><strong>Permission denied!</strong></span></h3><p style="text-align: center;"><span>This course supports drip content, so you must complete the previous lessons.</span></p>'
                ]),
                'meta_keywords' => 'Complete Web Development Bootcamp, online course, learn, tutorial',
                'meta_description' => 'Master web development from scratch. Learn HTML, CSS, JavaScript, React, and Node.js.',
                'description' => 'This comprehensive course will take you from beginner to advanced level in web development. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to build modern, responsive websites and web applications using the latest technologies.',
                'requirements' => 'Basic computer skills, internet connection, willingness to learn, no prior programming experience required',
                'outcomes' => 'Master HTML5 and CSS3 fundamentals, Build responsive websites, Learn JavaScript ES6+, Create React applications, Develop Node.js backend, Deploy web applications, Build a portfolio of projects',
                'faqs' => json_encode([
                    ['question' => 'Is this course suitable for beginners?', 'answer' => 'Yes, this course is designed for all skill levels, including complete beginners.'],
                    ['question' => 'How long do I have access?', 'answer' => 'Lifetime access to all course materials and future updates.'],
                    ['question' => 'What tools do I need?', 'answer' => 'Just a computer with internet connection. All software is free and we\'ll guide you through installation.'],
                    ['question' => 'Will I get a certificate?', 'answer' => 'Yes, you\'ll receive a certificate of completion after finishing the course.']
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 4)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 5,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Introduction to Web Development',
                        'lessons' => [
                            ['title' => 'Welcome to the Course', 'type' => 'video', 'duration' => '00:15:00', 'description' => 'Course overview, what you\'ll learn, and how to get the most out of this bootcamp.'],
                            ['title' => 'Setting Up Your Development Environment', 'type' => 'video', 'duration' => '00:25:00', 'description' => 'Install and configure VS Code, Node.js, Git, and essential browser extensions.'],
                            ['title' => 'Understanding How the Web Works', 'type' => 'text', 'duration' => '00:20:00', 'description' => 'Learn about HTTP, DNS, browsers, servers, and the client-server model.'],
                            ['title' => 'Your First HTML Page', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Create your first HTML page and understand the basic structure of HTML documents.'],
                        ]
                    ],
                    [
                        'title' => 'HTML5 Fundamentals',
                        'lessons' => [
                            ['title' => 'HTML Structure and Semantic Elements', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Learn semantic HTML5 elements like header, nav, article, section, and footer.'],
                            ['title' => 'Forms and Input Types', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Create interactive forms with validation and various input types.'],
                            ['title' => 'HTML5 Media Elements', 'type' => 'video', 'duration' => '00:25:00', 'description' => 'Embed audio and video content using HTML5 media elements.'],
                            ['title' => 'Building a Complete HTML Page', 'type' => 'assignment', 'duration' => '01:00:00', 'description' => 'Practice project: Build a complete HTML page with all learned elements.'],
                        ]
                    ],
                    [
                        'title' => 'CSS3 Styling and Layout',
                        'lessons' => [
                            ['title' => 'CSS Basics and Selectors', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Master CSS selectors, properties, and the box model.'],
                            ['title' => 'Flexbox Layout', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Learn modern layout techniques with Flexbox.'],
                            ['title' => 'CSS Grid System', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Create complex layouts using CSS Grid.'],
                            ['title' => 'Responsive Design and Media Queries', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Make your websites responsive for all devices.'],
                            ['title' => 'CSS Animations and Transitions', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Add smooth animations and transitions to your websites.'],
                            ['title' => 'Building a Responsive Website', 'type' => 'assignment', 'duration' => '02:00:00', 'description' => 'Project: Create a fully responsive website from scratch.'],
                        ]
                    ],
                    [
                        'title' => 'JavaScript Fundamentals',
                        'lessons' => [
                            ['title' => 'JavaScript Basics and Variables', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Learn variables, data types, and basic operations in JavaScript.'],
                            ['title' => 'Functions and Scope', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Understand functions, arrow functions, and scope in JavaScript.'],
                            ['title' => 'Arrays and Objects', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Work with arrays and objects, including array methods and object manipulation.'],
                            ['title' => 'DOM Manipulation', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Interact with HTML elements using JavaScript and the DOM API.'],
                            ['title' => 'Event Handling', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Handle user interactions with event listeners and event objects.'],
                            ['title' => 'JavaScript Quiz', 'type' => 'quiz', 'duration' => '00:30:00', 'description' => 'Test your JavaScript knowledge with this comprehensive quiz.'],
                        ]
                    ],
                    [
                        'title' => 'React Development',
                        'lessons' => [
                            ['title' => 'Introduction to React', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Learn what React is and why it\'s popular for building user interfaces.'],
                            ['title' => 'Components and JSX', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Create React components and understand JSX syntax.'],
                            ['title' => 'Props and State', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Manage component data with props and state.'],
                            ['title' => 'React Hooks', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Use modern React hooks like useState, useEffect, and custom hooks.'],
                            ['title' => 'Building a React Application', 'type' => 'assignment', 'duration' => '03:00:00', 'description' => 'Project: Build a complete React application with multiple components.'],
                        ]
                    ],
                    [
                        'title' => 'Node.js Backend Development',
                        'lessons' => [
                            ['title' => 'Introduction to Node.js', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Understand Node.js and the server-side JavaScript environment.'],
                            ['title' => 'Express.js Framework', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Build RESTful APIs using Express.js framework.'],
                            ['title' => 'Working with Databases', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Connect to MongoDB and perform CRUD operations.'],
                            ['title' => 'Authentication and Security', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Implement user authentication and secure your applications.'],
                        ]
                    ],
                    [
                        'title' => 'Final Project and Deployment',
                        'lessons' => [
                            ['title' => 'Planning Your Full-Stack Application', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Learn how to plan and structure a complete web application.'],
                            ['title' => 'Building the Full-Stack App', 'type' => 'assignment', 'duration' => '05:00:00', 'description' => 'Capstone project: Build a complete full-stack web application.'],
                            ['title' => 'Deployment Strategies', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Deploy your applications to platforms like Heroku, Netlify, and Vercel.'],
                            ['title' => 'Course Wrap-up and Next Steps', 'type' => 'video', 'duration' => '00:20:00', 'description' => 'Review what you\'ve learned and discover resources for continued learning.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Advanced JavaScript and React',
                'slug' => 'advanced-javascript-and-react',
                'short_description' => 'Deep dive into modern JavaScript and React development patterns.',
                'category_id' => $categories->where('title', 'Web Development')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 5)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'intermediate',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 149.99,
                'discounted_price' => null,
                'discount_flag' => 0,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'Advanced JavaScript and React, online course, learn, tutorial',
                'meta_description' => 'Deep dive into modern JavaScript and React development patterns.',
                'description' => 'Take your JavaScript and React skills to the next level. This course covers advanced patterns, performance optimization, state management, and building scalable applications. Perfect for developers who already know the basics and want to master advanced concepts.',
                'requirements' => 'Solid understanding of JavaScript fundamentals, Basic React knowledge, Experience with ES6+ features, Familiarity with npm and build tools',
                'outcomes' => 'Master advanced JavaScript patterns, Implement complex state management, Optimize React performance, Build scalable applications, Understand design patterns, Master testing strategies',
                'faqs' => json_encode([
                    ['question' => 'What level is this course?', 'answer' => 'This is an intermediate to advanced course. You should have solid JavaScript and React fundamentals.'],
                    ['question' => 'Do I need to know Redux?', 'answer' => 'No, we\'ll cover Redux and other state management solutions in the course.'],
                    ['question' => 'Will this cover React 18?', 'answer' => 'Yes, we cover the latest React features including hooks, concurrent rendering, and more.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 5)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 5,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Advanced JavaScript Concepts',
                        'lessons' => [
                            ['title' => 'Closures and Scope Mastery', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Deep dive into closures, lexical scope, and execution context.'],
                            ['title' => 'Prototypes and Inheritance', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Understand JavaScript\'s prototype-based inheritance system.'],
                            ['title' => 'Async Patterns: Promises and Async/Await', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Master asynchronous programming with modern JavaScript patterns.'],
                            ['title' => 'Generators and Iterators', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Learn advanced iteration patterns with generators.'],
                        ]
                    ],
                    [
                        'title' => 'React Advanced Patterns',
                        'lessons' => [
                            ['title' => 'Higher-Order Components', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Create reusable component logic with HOCs.'],
                            ['title' => 'Render Props Pattern', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Share code between components using render props.'],
                            ['title' => 'Custom Hooks Deep Dive', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Build powerful custom hooks for reusable logic.'],
                            ['title' => 'Context API Advanced Usage', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Manage global state efficiently with Context API.'],
                        ]
                    ],
                    [
                        'title' => 'State Management',
                        'lessons' => [
                            ['title' => 'Redux Fundamentals', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Learn Redux architecture and core concepts.'],
                            ['title' => 'Redux Toolkit', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Simplify Redux with Redux Toolkit.'],
                            ['title' => 'Zustand and Modern Alternatives', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Explore lightweight state management solutions.'],
                            ['title' => 'State Management Best Practices', 'type' => 'text', 'duration' => '00:30:00', 'description' => 'Learn when and how to use different state management approaches.'],
                        ]
                    ],
                    [
                        'title' => 'Performance Optimization',
                        'lessons' => [
                            ['title' => 'React Performance Profiling', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Use React DevTools to identify performance bottlenecks.'],
                            ['title' => 'Memoization Techniques', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Optimize with useMemo, useCallback, and React.memo.'],
                            ['title' => 'Code Splitting and Lazy Loading', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Improve load times with code splitting strategies.'],
                            ['title' => 'Virtualization and Large Lists', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Handle large datasets efficiently with virtualization.'],
                        ]
                    ],
                    [
                        'title' => 'Testing and Quality',
                        'lessons' => [
                            ['title' => 'Jest and React Testing Library', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Write effective unit and integration tests.'],
                            ['title' => 'Testing Hooks and Context', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Test custom hooks and context providers.'],
                            ['title' => 'E2E Testing with Cypress', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Set up end-to-end testing for your applications.'],
                        ]
                    ],
                    [
                        'title' => 'Advanced Project',
                        'lessons' => [
                            ['title' => 'Building a Scalable React App', 'type' => 'assignment', 'duration' => '06:00:00', 'description' => 'Capstone project: Build a production-ready React application with all advanced patterns.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Python for Data Science',
                'slug' => 'python-for-data-science',
                'short_description' => 'Learn Python programming and data analysis with real-world projects.',
                'category_id' => $categories->where('title', 'Data Science')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 10)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 89.99,
                'discounted_price' => 69.99,
                'discount_flag' => 1,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'Python for Data Science, online course, learn, tutorial',
                'meta_description' => 'Learn Python programming and data analysis with real-world projects.',
                'description' => 'Master Python for data science with hands-on projects. Learn to analyze data, create visualizations, and build machine learning models. This comprehensive course covers everything from Python basics to advanced data science techniques.',
                'requirements' => 'Basic computer skills, No prior programming experience required, Willingness to learn, Internet connection',
                'outcomes' => 'Master Python programming fundamentals, Work with NumPy and Pandas, Create data visualizations, Perform statistical analysis, Build machine learning models, Handle real-world datasets',
                'faqs' => json_encode([
                    ['question' => 'Do I need prior programming experience?', 'answer' => 'No, this course starts from the basics and is suitable for beginners.'],
                    ['question' => 'What tools will I use?', 'answer' => 'We\'ll use Jupyter Notebooks, Python, and popular data science libraries like Pandas and NumPy.'],
                    ['question' => 'Will I work on real projects?', 'answer' => 'Yes, you\'ll complete multiple real-world data science projects throughout the course.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 10)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 4,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Python Fundamentals',
                        'lessons' => [
                            ['title' => 'Introduction to Python', 'type' => 'video', 'duration' => '00:25:00', 'description' => 'Get started with Python: installation, setup, and your first program.'],
                            ['title' => 'Variables and Data Types', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Learn about Python data types: strings, numbers, lists, and dictionaries.'],
                            ['title' => 'Control Flow and Loops', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Master if/else statements, loops, and control structures.'],
                            ['title' => 'Functions and Modules', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Create reusable code with functions and organize code with modules.'],
                        ]
                    ],
                    [
                        'title' => 'Working with Data',
                        'lessons' => [
                            ['title' => 'Introduction to NumPy', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Learn NumPy arrays and numerical computing in Python.'],
                            ['title' => 'Pandas DataFrames', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Master Pandas for data manipulation and analysis.'],
                            ['title' => 'Data Cleaning Techniques', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Clean and preprocess messy real-world datasets.'],
                            ['title' => 'Data Wrangling Project', 'type' => 'assignment', 'duration' => '02:00:00', 'description' => 'Practice project: Clean and analyze a real dataset.'],
                        ]
                    ],
                    [
                        'title' => 'Data Visualization',
                        'lessons' => [
                            ['title' => 'Matplotlib Basics', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Create static visualizations with Matplotlib.'],
                            ['title' => 'Seaborn for Statistical Plots', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Build beautiful statistical visualizations with Seaborn.'],
                            ['title' => 'Interactive Visualizations', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Create interactive plots with Plotly.'],
                            ['title' => 'Visualization Project', 'type' => 'assignment', 'duration' => '01:30:00', 'description' => 'Create a comprehensive data visualization dashboard.'],
                        ]
                    ],
                    [
                        'title' => 'Statistical Analysis',
                        'lessons' => [
                            ['title' => 'Descriptive Statistics', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Calculate and interpret descriptive statistics.'],
                            ['title' => 'Probability Distributions', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Understand and work with probability distributions.'],
                            ['title' => 'Hypothesis Testing', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Perform statistical hypothesis tests.'],
                            ['title' => 'Correlation and Regression', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Analyze relationships between variables.'],
                        ]
                    ],
                    [
                        'title' => 'Machine Learning Basics',
                        'lessons' => [
                            ['title' => 'Introduction to Machine Learning', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Learn the fundamentals of machine learning.'],
                            ['title' => 'Scikit-learn Basics', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Get started with the scikit-learn library.'],
                            ['title' => 'Supervised Learning Models', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Build and evaluate classification and regression models.'],
                            ['title' => 'Model Evaluation', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Learn how to properly evaluate machine learning models.'],
                            ['title' => 'ML Project', 'type' => 'assignment', 'duration' => '03:00:00', 'description' => 'Complete project: Build and deploy a machine learning model.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Machine Learning Masterclass',
                'slug' => 'machine-learning-masterclass',
                'short_description' => 'Comprehensive machine learning course covering algorithms and practical applications.',
                'category_id' => $categories->where('title', 'Data Science')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 4)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'advanced',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 199.99,
                'discounted_price' => null,
                'discount_flag' => 0,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'Machine Learning Masterclass, online course, learn, tutorial',
                'meta_description' => 'Comprehensive machine learning course covering algorithms and practical applications.',
                'description' => 'Master machine learning from theory to production. This advanced course covers deep learning, neural networks, and deploying ML models. Perfect for data scientists and developers who want to build production-ready ML systems.',
                'requirements' => 'Strong Python programming skills, Understanding of statistics and linear algebra, Experience with data science libraries, Basic machine learning knowledge',
                'outcomes' => 'Master advanced ML algorithms, Build deep neural networks, Implement computer vision models, Work with NLP, Deploy ML models to production, Optimize model performance',
                'faqs' => json_encode([
                    ['question' => 'What level is this course?', 'answer' => 'This is an advanced course. You should have strong Python and data science fundamentals.'],
                    ['question' => 'Do I need a GPU?', 'answer' => 'Helpful but not required. We\'ll show you how to use cloud GPU services.'],
                    ['question' => 'What frameworks will we use?', 'answer' => 'TensorFlow, PyTorch, and scikit-learn for various projects.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 4)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 5,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Advanced ML Algorithms',
                        'lessons' => [
                            ['title' => 'Ensemble Methods', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Master Random Forests, Gradient Boosting, and XGBoost.'],
                            ['title' => 'Support Vector Machines', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Deep dive into SVM theory and implementation.'],
                            ['title' => 'Clustering Algorithms', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'K-means, DBSCAN, and hierarchical clustering.'],
                            ['title' => 'Dimensionality Reduction', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'PCA, t-SNE, and feature selection techniques.'],
                        ]
                    ],
                    [
                        'title' => 'Deep Learning Fundamentals',
                        'lessons' => [
                            ['title' => 'Neural Networks from Scratch', 'type' => 'video', 'duration' => '01:00:00', 'description' => 'Build neural networks from scratch to understand the fundamentals.'],
                            ['title' => 'Backpropagation Explained', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Deep understanding of how neural networks learn.'],
                            ['title' => 'TensorFlow and Keras', 'type' => 'video', 'duration' => '00:55:00', 'description' => 'Build models with TensorFlow and Keras.'],
                            ['title' => 'PyTorch Deep Dive', 'type' => 'video', 'duration' => '01:00:00', 'description' => 'Master PyTorch for research and production.'],
                        ]
                    ],
                    [
                        'title' => 'Convolutional Neural Networks',
                        'lessons' => [
                            ['title' => 'CNN Architecture', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Understand convolutional layers and pooling.'],
                            ['title' => 'Transfer Learning', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Use pre-trained models for your projects.'],
                            ['title' => 'Image Classification Project', 'type' => 'assignment', 'duration' => '04:00:00', 'description' => 'Build an image classification system.'],
                        ]
                    ],
                    [
                        'title' => 'Natural Language Processing',
                        'lessons' => [
                            ['title' => 'Text Preprocessing', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Clean and prepare text data for ML models.'],
                            ['title' => 'Word Embeddings', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Word2Vec, GloVe, and modern embeddings.'],
                            ['title' => 'RNNs and LSTMs', 'type' => 'video', 'duration' => '01:00:00', 'description' => 'Recurrent neural networks for sequence data.'],
                            ['title' => 'Transformers and BERT', 'type' => 'video', 'duration' => '01:10:00', 'description' => 'Modern transformer architectures for NLP.'],
                        ]
                    ],
                    [
                        'title' => 'Model Deployment',
                        'lessons' => [
                            ['title' => 'Model Serialization', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Save and load trained models.'],
                            ['title' => 'Building ML APIs', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Create REST APIs for ML models.'],
                            ['title' => 'Cloud Deployment', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Deploy models to AWS, GCP, and Azure.'],
                            ['title' => 'Model Monitoring', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Monitor model performance in production.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'UI/UX Design Fundamentals',
                'slug' => 'uiux-design-fundamentals',
                'short_description' => 'Learn the principles of user interface and user experience design.',
                'category_id' => $categories->where('title', 'Design')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 9)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 79.99,
                'discounted_price' => 59.99,
                'discount_flag' => 1,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'UI/UX Design Fundamentals, online course, learn, tutorial',
                'meta_description' => 'Learn the principles of user interface and user experience design.',
                'description' => 'Master the fundamentals of UI/UX design. Learn to create beautiful, user-friendly interfaces and improve user experiences. This course covers design principles, tools, and real-world projects.',
                'requirements' => 'No prior design experience needed, Access to design software (we\'ll cover free options), Creative mindset, Willingness to practice',
                'outcomes' => 'Understand design principles, Create wireframes and prototypes, Design user interfaces, Conduct user research, Build a design portfolio, Use design tools effectively',
                'faqs' => json_encode([
                    ['question' => 'Do I need design experience?', 'answer' => 'No, this course is designed for complete beginners.'],
                    ['question' => 'What software will I use?', 'answer' => 'We\'ll use Figma (free) and cover other popular tools like Adobe XD and Sketch.'],
                    ['question' => 'Will I build a portfolio?', 'answer' => 'Yes, you\'ll complete multiple projects to build your design portfolio.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 9)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 4,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Design Fundamentals',
                        'lessons' => [
                            ['title' => 'Introduction to UI/UX Design', 'type' => 'video', 'duration' => '00:25:00', 'description' => 'Learn what UI/UX design is and why it matters.'],
                            ['title' => 'Design Principles', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Master color theory, typography, spacing, and layout principles.'],
                            ['title' => 'User Psychology', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Understand how users think and interact with interfaces.'],
                            ['title' => 'Design Thinking Process', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Learn the design thinking methodology.'],
                        ]
                    ],
                    [
                        'title' => 'User Research',
                        'lessons' => [
                            ['title' => 'Understanding Your Users', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Conduct user interviews and surveys.'],
                            ['title' => 'Creating User Personas', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Develop detailed user personas for your designs.'],
                            ['title' => 'User Journey Mapping', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Map user journeys to identify pain points.'],
                            ['title' => 'Research Project', 'type' => 'assignment', 'duration' => '02:00:00', 'description' => 'Complete a user research project for a real product.'],
                        ]
                    ],
                    [
                        'title' => 'Wireframing and Prototyping',
                        'lessons' => [
                            ['title' => 'Information Architecture', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Organize content and structure your designs.'],
                            ['title' => 'Low-Fidelity Wireframes', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Create quick wireframes to test ideas.'],
                            ['title' => 'High-Fidelity Prototypes', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Build interactive prototypes in Figma.'],
                            ['title' => 'Prototyping Project', 'type' => 'assignment', 'duration' => '02:30:00', 'description' => 'Create a complete interactive prototype.'],
                        ]
                    ],
                    [
                        'title' => 'Visual Design',
                        'lessons' => [
                            ['title' => 'Color Systems', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Create effective color palettes and systems.'],
                            ['title' => 'Typography in UI Design', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Choose and pair fonts effectively.'],
                            ['title' => 'Icons and Illustrations', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Use icons and illustrations in your designs.'],
                            ['title' => 'Design Systems', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Build scalable design systems.'],
                        ]
                    ],
                    [
                        'title' => 'Usability and Testing',
                        'lessons' => [
                            ['title' => 'Usability Principles', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Learn key usability principles and heuristics.'],
                            ['title' => 'User Testing Methods', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Conduct effective user testing sessions.'],
                            ['title' => 'Iterating Based on Feedback', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Improve designs based on user feedback.'],
                        ]
                    ],
                    [
                        'title' => 'Portfolio Project',
                        'lessons' => [
                            ['title' => 'Complete Design Project', 'type' => 'assignment', 'duration' => '05:00:00', 'description' => 'Capstone project: Design a complete app from research to prototype.'],
                            ['title' => 'Building Your Portfolio', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Learn how to present your work in a portfolio.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Digital Marketing Complete Guide',
                'slug' => 'digital-marketing-complete-guide',
                'short_description' => 'Master digital marketing strategies including SEO, social media, and content marketing.',
                'category_id' => $categories->where('title', 'Marketing')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 8)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 119.99,
                'discounted_price' => null,
                'discount_flag' => 0,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'Digital Marketing Complete Guide, online course, learn, tutorial',
                'meta_description' => 'Master digital marketing strategies including SEO, social media, and content marketing.',
                'description' => 'Master digital marketing from strategy to execution. Learn SEO, social media marketing, content creation, email marketing, and paid advertising. Build campaigns that drive real results.',
                'requirements' => 'Basic computer skills, Internet connection, Interest in marketing, No prior experience needed',
                'outcomes' => 'Create effective marketing strategies, Master SEO techniques, Run social media campaigns, Create engaging content, Set up email marketing, Understand analytics and metrics',
                'faqs' => json_encode([
                    ['question' => 'Is this course for beginners?', 'answer' => 'Yes, we start from the basics and build up to advanced strategies.'],
                    ['question' => 'Will I learn about paid advertising?', 'answer' => 'Yes, we cover Google Ads, Facebook Ads, and other paid platforms.'],
                    ['question' => 'Do I need marketing experience?', 'answer' => 'No prior experience needed. This course is perfect for beginners.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 8)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 5,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Digital Marketing Fundamentals',
                        'lessons' => [
                            ['title' => 'Introduction to Digital Marketing', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Overview of digital marketing landscape and opportunities.'],
                            ['title' => 'Marketing Funnel', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Understand the customer journey and marketing funnel.'],
                            ['title' => 'Setting Marketing Goals', 'type' => 'video', 'duration' => '00:25:00', 'description' => 'Define SMART marketing objectives and KPIs.'],
                            ['title' => 'Target Audience Research', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Identify and understand your target audience.'],
                        ]
                    ],
                    [
                        'title' => 'Search Engine Optimization (SEO)',
                        'lessons' => [
                            ['title' => 'SEO Fundamentals', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Learn how search engines work and ranking factors.'],
                            ['title' => 'Keyword Research', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Find and target the right keywords for your business.'],
                            ['title' => 'On-Page SEO', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Optimize your website content and structure.'],
                            ['title' => 'Off-Page SEO and Link Building', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Build authority through backlinks and off-page optimization.'],
                            ['title' => 'SEO Project', 'type' => 'assignment', 'duration' => '02:00:00', 'description' => 'Optimize a website for search engines.'],
                        ]
                    ],
                    [
                        'title' => 'Social Media Marketing',
                        'lessons' => [
                            ['title' => 'Social Media Strategy', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Develop a comprehensive social media strategy.'],
                            ['title' => 'Facebook and Instagram Marketing', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Master Facebook and Instagram advertising and organic growth.'],
                            ['title' => 'LinkedIn Marketing', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Build your brand on LinkedIn for B2B marketing.'],
                            ['title' => 'Twitter and TikTok', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Engage audiences on Twitter and TikTok.'],
                        ]
                    ],
                    [
                        'title' => 'Content Marketing',
                        'lessons' => [
                            ['title' => 'Content Strategy', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Plan and execute a content marketing strategy.'],
                            ['title' => 'Blog Writing and SEO', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Write SEO-optimized blog posts that rank.'],
                            ['title' => 'Video Content Creation', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Create engaging video content for marketing.'],
                            ['title' => 'Content Calendar', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Plan and organize your content with a calendar.'],
                        ]
                    ],
                    [
                        'title' => 'Email Marketing',
                        'lessons' => [
                            ['title' => 'Email Marketing Basics', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Set up email marketing campaigns.'],
                            ['title' => 'Email Automation', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Create automated email sequences.'],
                            ['title' => 'Email Design and Copywriting', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Write and design effective marketing emails.'],
                        ]
                    ],
                    [
                        'title' => 'Paid Advertising',
                        'lessons' => [
                            ['title' => 'Google Ads Fundamentals', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Set up and optimize Google Ads campaigns.'],
                            ['title' => 'Facebook Ads Mastery', 'type' => 'video', 'duration' => '00:55:00', 'description' => 'Create high-converting Facebook ad campaigns.'],
                            ['title' => 'Analytics and Measurement', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Track and measure marketing performance.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Mobile App Development with Flutter',
                'slug' => 'mobile-app-development-with-flutter',
                'short_description' => 'Build cross-platform mobile apps using Flutter framework.',
                'category_id' => $categories->where('title', 'Web Development')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 4)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'intermediate',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 129.99,
                'discounted_price' => 99.99,
                'discount_flag' => 1,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'Mobile App Development with Flutter, online course, learn, tutorial',
                'meta_description' => 'Build cross-platform mobile apps using Flutter framework.',
                'description' => 'Learn Flutter and Dart to build beautiful, native mobile apps for iOS and Android from a single codebase. This course covers everything from basics to publishing your app.',
                'requirements' => 'Basic programming knowledge, Familiarity with object-oriented programming, Willingness to learn Dart, Computer with Flutter SDK',
                'outcomes' => 'Master Flutter framework, Build iOS and Android apps, Understand Dart programming, Create beautiful UIs, Handle state management, Publish apps to stores',
                'faqs' => json_encode([
                    ['question' => 'Do I need to know Dart?', 'answer' => 'No, we\'ll teach Dart as part of the course.'],
                    ['question' => 'Can I build for both iOS and Android?', 'answer' => 'Yes, Flutter allows you to build for both platforms with one codebase.'],
                    ['question' => 'Will I publish a real app?', 'answer' => 'Yes, you\'ll build and publish a complete app by the end of the course.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 4)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 5,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Flutter and Dart Basics',
                        'lessons' => [
                            ['title' => 'Introduction to Flutter', 'type' => 'video', 'duration' => '00:25:00', 'description' => 'What is Flutter and why use it for mobile development.'],
                            ['title' => 'Dart Programming Language', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Learn Dart syntax and fundamentals.'],
                            ['title' => 'Flutter Setup and Installation', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Install Flutter SDK and set up your development environment.'],
                            ['title' => 'Your First Flutter App', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Create and run your first Flutter application.'],
                        ]
                    ],
                    [
                        'title' => 'Flutter Widgets',
                        'lessons' => [
                            ['title' => 'Understanding Widgets', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Learn Flutter\'s widget-based architecture.'],
                            ['title' => 'Layout Widgets', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Row, Column, Stack, and other layout widgets.'],
                            ['title' => 'Material Design Widgets', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Use Material Design components in Flutter.'],
                            ['title' => 'Custom Widgets', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Create reusable custom widgets.'],
                        ]
                    ],
                    [
                        'title' => 'State Management',
                        'lessons' => [
                            ['title' => 'Stateful vs Stateless Widgets', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Understand state in Flutter applications.'],
                            ['title' => 'setState and State Management', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Manage state with setState and Provider.'],
                            ['title' => 'Riverpod State Management', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Advanced state management with Riverpod.'],
                            ['title' => 'State Management Project', 'type' => 'assignment', 'duration' => '02:30:00', 'description' => 'Build an app with proper state management.'],
                        ]
                    ],
                    [
                        'title' => 'Navigation and Routing',
                        'lessons' => [
                            ['title' => 'Basic Navigation', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Navigate between screens in Flutter.'],
                            ['title' => 'Named Routes', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Implement named routing for better navigation.'],
                            ['title' => 'Deep Linking', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Handle deep links in your Flutter app.'],
                        ]
                    ],
                    [
                        'title' => 'Working with Data',
                        'lessons' => [
                            ['title' => 'HTTP Requests', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Make API calls and handle network requests.'],
                            ['title' => 'Local Storage', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Store data locally with SharedPreferences and SQLite.'],
                            ['title' => 'Firebase Integration', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Integrate Firebase for backend services.'],
                        ]
                    ],
                    [
                        'title' => 'Advanced Features',
                        'lessons' => [
                            ['title' => 'Animations', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Create smooth animations in Flutter.'],
                            ['title' => 'Platform Channels', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Access native platform features.'],
                            ['title' => 'Testing Flutter Apps', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Write unit and widget tests.'],
                        ]
                    ],
                    [
                        'title' => 'Publishing Your App',
                        'lessons' => [
                            ['title' => 'Building for Production', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Prepare your app for release.'],
                            ['title' => 'Publishing to Google Play', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Publish your app to Google Play Store.'],
                            ['title' => 'Publishing to App Store', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Publish your app to Apple App Store.'],
                            ['title' => 'Final Project', 'type' => 'assignment', 'duration' => '05:00:00', 'description' => 'Build and publish a complete Flutter app.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Professional Photography Course',
                'slug' => 'professional-photography-course',
                'short_description' => 'Learn professional photography techniques and post-processing.',
                'category_id' => $categories->where('title', 'Photography')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 9)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'beginner',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 89.99,
                'discounted_price' => null,
                'discount_flag' => 0,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'Professional Photography Course, online course, learn, tutorial',
                'meta_description' => 'Learn professional photography techniques and post-processing.',
                'description' => 'Master professional photography from camera basics to advanced techniques. Learn composition, lighting, editing, and build a photography portfolio. Perfect for aspiring photographers.',
                'requirements' => 'A camera (DSLR, mirrorless, or smartphone), Basic computer skills, Interest in photography, No prior experience needed',
                'outcomes' => 'Master camera settings, Understand composition rules, Work with natural and artificial light, Edit photos professionally, Build a photography portfolio, Start a photography business',
                'faqs' => json_encode([
                    ['question' => 'Do I need an expensive camera?', 'answer' => 'No, you can start with a smartphone or entry-level camera. We\'ll cover all types.'],
                    ['question' => 'What editing software will I learn?', 'answer' => 'We\'ll cover Lightroom and Photoshop, plus free alternatives.'],
                    ['question' => 'Is this for beginners?', 'answer' => 'Yes, we start from the very basics and build up to professional techniques.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 9)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 5,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Camera Fundamentals',
                        'lessons' => [
                            ['title' => 'Understanding Your Camera', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Learn camera types, sensors, and basic functions.'],
                            ['title' => 'Exposure Triangle', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Master aperture, shutter speed, and ISO.'],
                            ['title' => 'Camera Modes', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'When to use manual, aperture priority, and other modes.'],
                            ['title' => 'Focusing Techniques', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Achieve sharp focus in various situations.'],
                        ]
                    ],
                    [
                        'title' => 'Composition and Framing',
                        'lessons' => [
                            ['title' => 'Rule of Thirds', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Master the fundamental composition rule.'],
                            ['title' => 'Leading Lines and Patterns', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Use lines and patterns to guide the viewer\'s eye.'],
                            ['title' => 'Depth and Perspective', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Create depth in your photographs.'],
                            ['title' => 'Composition Project', 'type' => 'assignment', 'duration' => '01:30:00', 'description' => 'Practice composition with a photo series.'],
                        ]
                    ],
                    [
                        'title' => 'Lighting Techniques',
                        'lessons' => [
                            ['title' => 'Natural Light Photography', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Work with different types of natural light.'],
                            ['title' => 'Artificial Lighting', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Use flash, strobes, and continuous lights.'],
                            ['title' => 'Portrait Lighting Setups', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Classic portrait lighting patterns.'],
                            ['title' => 'Lighting Project', 'type' => 'assignment', 'duration' => '02:00:00', 'description' => 'Create portraits using different lighting setups.'],
                        ]
                    ],
                    [
                        'title' => 'Photography Genres',
                        'lessons' => [
                            ['title' => 'Portrait Photography', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Capture stunning portraits of people.'],
                            ['title' => 'Landscape Photography', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Photograph beautiful landscapes and nature.'],
                            ['title' => 'Street Photography', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Document everyday life and moments.'],
                            ['title' => 'Product Photography', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Photograph products for e-commerce and advertising.'],
                        ]
                    ],
                    [
                        'title' => 'Photo Editing',
                        'lessons' => [
                            ['title' => 'Lightroom Basics', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Organize and edit photos in Adobe Lightroom.'],
                            ['title' => 'Color Correction', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Correct and enhance colors in your photos.'],
                            ['title' => 'Photoshop Techniques', 'type' => 'video', 'duration' => '01:00:00', 'description' => 'Advanced editing techniques in Photoshop.'],
                            ['title' => 'Editing Workflow', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Efficient editing workflow from import to export.'],
                        ]
                    ],
                    [
                        'title' => 'Building Your Portfolio',
                        'lessons' => [
                            ['title' => 'Selecting Your Best Work', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Curate a portfolio that showcases your skills.'],
                            ['title' => 'Creating an Online Portfolio', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Build a professional photography website.'],
                            ['title' => 'Portfolio Project', 'type' => 'assignment', 'duration' => '03:00:00', 'description' => 'Create a complete photography portfolio.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Cybersecurity Essentials',
                'slug' => 'cybersecurity-essentials',
                'short_description' => 'Learn cybersecurity fundamentals and ethical hacking techniques.',
                'category_id' => $categories->where('title', 'Business')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 8)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'intermediate',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 159.99,
                'discounted_price' => 129.99,
                'discount_flag' => 1,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'Cybersecurity Essentials, online course, learn, tutorial',
                'meta_description' => 'Learn cybersecurity fundamentals and ethical hacking techniques.',
                'description' => 'Master cybersecurity fundamentals and ethical hacking. Learn to protect systems, identify vulnerabilities, and understand security best practices. Perfect for IT professionals and security enthusiasts.',
                'requirements' => 'Basic computer knowledge, Understanding of networking basics, Interest in security, Ethical mindset',
                'outcomes' => 'Understand cybersecurity fundamentals, Identify security vulnerabilities, Perform ethical hacking, Implement security measures, Understand compliance and regulations, Build security awareness',
                'faqs' => json_encode([
                    ['question' => 'Is this for ethical hacking?', 'answer' => 'Yes, we focus on ethical hacking and defensive security.'],
                    ['question' => 'Do I need programming knowledge?', 'answer' => 'Basic knowledge is helpful but we\'ll cover scripting basics.'],
                    ['question' => 'Will I learn about tools?', 'answer' => 'Yes, we\'ll cover popular security tools like Wireshark, Nmap, and Metasploit.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 8)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 5,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Cybersecurity Fundamentals',
                        'lessons' => [
                            ['title' => 'Introduction to Cybersecurity', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'Overview of cybersecurity landscape and threats.'],
                            ['title' => 'Security Principles', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'CIA triad, defense in depth, and security models.'],
                            ['title' => 'Threat Landscape', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Understand common threats and attack vectors.'],
                            ['title' => 'Security Frameworks', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'NIST, ISO 27001, and other security frameworks.'],
                        ]
                    ],
                    [
                        'title' => 'Network Security',
                        'lessons' => [
                            ['title' => 'Network Protocols and Security', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'TCP/IP, DNS, and common network vulnerabilities.'],
                            ['title' => 'Firewalls and IDS/IPS', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Configure firewalls and intrusion detection systems.'],
                            ['title' => 'VPN and Encryption', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Implement VPNs and encryption protocols.'],
                            ['title' => 'Network Security Lab', 'type' => 'assignment', 'duration' => '02:00:00', 'description' => 'Set up and secure a network environment.'],
                        ]
                    ],
                    [
                        'title' => 'Web Application Security',
                        'lessons' => [
                            ['title' => 'OWASP Top 10', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Understand the most critical web vulnerabilities.'],
                            ['title' => 'SQL Injection', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Identify and prevent SQL injection attacks.'],
                            ['title' => 'XSS and CSRF Attacks', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Protect against cross-site scripting and CSRF.'],
                            ['title' => 'Web Security Testing', 'type' => 'assignment', 'duration' => '02:30:00', 'description' => 'Test and secure a web application.'],
                        ]
                    ],
                    [
                        'title' => 'Ethical Hacking',
                        'lessons' => [
                            ['title' => 'Hacking Methodology', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Learn the ethical hacking process and methodology.'],
                            ['title' => 'Reconnaissance and Scanning', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Information gathering and network scanning techniques.'],
                            ['title' => 'Vulnerability Assessment', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Identify and assess system vulnerabilities.'],
                            ['title' => 'Penetration Testing', 'type' => 'video', 'duration' => '01:00:00', 'description' => 'Perform authorized penetration tests.'],
                        ]
                    ],
                    [
                        'title' => 'Security Tools',
                        'lessons' => [
                            ['title' => 'Wireshark for Network Analysis', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Analyze network traffic with Wireshark.'],
                            ['title' => 'Nmap for Network Scanning', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Scan networks and identify services with Nmap.'],
                            ['title' => 'Metasploit Framework', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Use Metasploit for security testing.'],
                            ['title' => 'Burp Suite for Web Testing', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Test web applications with Burp Suite.'],
                        ]
                    ],
                    [
                        'title' => 'Incident Response',
                        'lessons' => [
                            ['title' => 'Incident Response Process', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Learn the incident response lifecycle.'],
                            ['title' => 'Forensics Basics', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Digital forensics and evidence collection.'],
                            ['title' => 'Security Monitoring', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Monitor systems for security events.'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Business Strategy and Leadership',
                'slug' => 'business-strategy-and-leadership',
                'short_description' => 'Develop strategic thinking and leadership skills for business success.',
                'category_id' => $categories->where('title', 'Business')->first()->id ?? $categories->first()->id,
                'user_id' => $instructors->where('id', 7)->first()->id ?? $instructors->first()->id,
                'course_type' => 'general',
                'status' => 'active',
                'level' => 'advanced',
                'language' => 'English',
                'is_paid' => 1,
                'is_best' => 0,
                'price' => 179.99,
                'discounted_price' => null,
                'discount_flag' => 0,
                'enable_drip_content' => null,
                'drip_content_settings' => null,
                'meta_keywords' => 'Business Strategy and Leadership, online course, learn, tutorial',
                'meta_description' => 'Develop strategic thinking and leadership skills for business success.',
                'description' => 'Master business strategy and leadership. Learn to develop strategic plans, lead teams effectively, make data-driven decisions, and drive organizational success. Perfect for managers, executives, and entrepreneurs.',
                'requirements' => 'Business experience helpful but not required, Interest in leadership, Willingness to learn strategic thinking, Open to new perspectives',
                'outcomes' => 'Develop strategic thinking, Lead teams effectively, Make data-driven decisions, Create business strategies, Understand organizational dynamics, Drive business growth',
                'faqs' => json_encode([
                    ['question' => 'Is this for executives only?', 'answer' => 'No, this course is valuable for anyone in a leadership role or aspiring to lead.'],
                    ['question' => 'Will I learn about specific frameworks?', 'answer' => 'Yes, we cover SWOT, Porter\'s Five Forces, and other strategic frameworks.'],
                    ['question' => 'Is there practical application?', 'answer' => 'Yes, you\'ll work on real case studies and develop your own strategic plans.'],
                ]),
                'instructor_ids' => json_encode([$instructors->where('id', 7)->first()->id ?? $instructors->first()->id]),
                'average_rating' => 5,
                'expiry_period' => null,
                'sections' => [
                    [
                        'title' => 'Strategic Thinking Fundamentals',
                        'lessons' => [
                            ['title' => 'Introduction to Strategy', 'type' => 'video', 'duration' => '00:30:00', 'description' => 'What is strategy and why it matters for business success.'],
                            ['title' => 'Strategic Analysis Tools', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'SWOT analysis, PESTEL, and other strategic frameworks.'],
                            ['title' => 'Competitive Advantage', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Build and sustain competitive advantages.'],
                            ['title' => 'Strategic Planning Process', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Develop comprehensive strategic plans.'],
                        ]
                    ],
                    [
                        'title' => 'Leadership Principles',
                        'lessons' => [
                            ['title' => 'Leadership vs Management', 'type' => 'video', 'duration' => '00:35:00', 'description' => 'Understand the difference and when to use each approach.'],
                            ['title' => 'Leadership Styles', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Explore different leadership styles and when to apply them.'],
                            ['title' => 'Emotional Intelligence', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Develop emotional intelligence for effective leadership.'],
                            ['title' => 'Leading Change', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Lead organizational change effectively.'],
                        ]
                    ],
                    [
                        'title' => 'Team Building and Management',
                        'lessons' => [
                            ['title' => 'Building High-Performance Teams', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Create and develop effective teams.'],
                            ['title' => 'Conflict Resolution', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Handle conflicts and difficult conversations.'],
                            ['title' => 'Performance Management', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Set goals, provide feedback, and manage performance.'],
                            ['title' => 'Team Project', 'type' => 'assignment', 'duration' => '02:00:00', 'description' => 'Develop a team management strategy for a case study.'],
                        ]
                    ],
                    [
                        'title' => 'Decision Making',
                        'lessons' => [
                            ['title' => 'Decision-Making Frameworks', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Use structured approaches to make better decisions.'],
                            ['title' => 'Data-Driven Decisions', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Leverage data and analytics for decision making.'],
                            ['title' => 'Risk Management', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Assess and manage business risks.'],
                            ['title' => 'Decision-Making Case Study', 'type' => 'assignment', 'duration' => '01:30:00', 'description' => 'Analyze and make decisions for real business scenarios.'],
                        ]
                    ],
                    [
                        'title' => 'Business Growth Strategies',
                        'lessons' => [
                            ['title' => 'Growth Frameworks', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Ansoff Matrix and other growth strategies.'],
                            ['title' => 'Market Expansion', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'Strategies for entering new markets.'],
                            ['title' => 'Innovation and Disruption', 'type' => 'video', 'duration' => '00:50:00', 'description' => 'Foster innovation and navigate disruption.'],
                        ]
                    ],
                    [
                        'title' => 'Strategic Implementation',
                        'lessons' => [
                            ['title' => 'Executing Strategy', 'type' => 'video', 'duration' => '00:45:00', 'description' => 'Turn strategy into action and results.'],
                            ['title' => 'Measuring Success', 'type' => 'video', 'duration' => '00:40:00', 'description' => 'KPIs and metrics for strategic success.'],
                            ['title' => 'Strategic Plan Project', 'type' => 'assignment', 'duration' => '04:00:00', 'description' => 'Develop a complete strategic plan for a business.'],
                        ]
                    ],
                ]
            ],
        ];

        // Create courses with sections and lessons
        foreach ($coursesData as $courseData) {
            $sections = $courseData['sections'];
            unset($courseData['sections']);

            // Create or update course
            $course = Course::updateOrCreate(
                ['slug' => $courseData['slug']],
                $courseData
            );

            $this->command->info("Created/Updated course: {$course->title}");

            // Delete existing sections and lessons for this course
            Section::where('course_id', $course->id)->delete();

            $sectionSort = 1;
            $lessonSort = 1;

            // Create sections and lessons
            foreach ($sections as $sectionData) {
                $lessons = $sectionData['lessons'];
                unset($sectionData['lessons']);

                $section = Section::create([
                    'user_id' => $course->user_id,
                    'course_id' => $course->id,
                    'title' => $sectionData['title'],
                    'sort' => $sectionSort,
                ]);

                $sectionSort++;

                // Create lessons for this section
                foreach ($lessons as $lessonData) {
                    $lessonType = $lessonData['type'];
                    $duration = $lessonData['duration'];
                    $isFree = ($lessonSort === 1) ? 1 : 0; // First lesson is free

                    // Generate lesson source based on type
                    $lessonSrc = null;
                    $videoType = null;
                    if ($lessonType === 'video') {
                        $lessonSrc = 'https://example.com/video-' . Str::random(10) . '.mp4';
                        $videoType = 'mp4';
                    } elseif ($lessonType === 'text') {
                        $lessonSrc = null;
                    } elseif ($lessonType === 'quiz') {
                        $lessonSrc = null;
                    }

                    Lesson::create([
                        'title' => $lessonData['title'],
                        'user_id' => $course->user_id,
                        'course_id' => $course->id,
                        'section_id' => $section->id,
                        'lesson_type' => $lessonType,
                        'duration' => $duration,
                        'lesson_src' => $lessonSrc,
                        'video_type' => $videoType,
                        'thumbnail' => null,
                        'is_free' => $isFree,
                        'sort' => $lessonSort,
                        'description' => $lessonData['description'],
                        'summary' => substr($lessonData['description'], 0, 150) . '...',
                        'status' => 1,
                        'total_mark' => $lessonType === 'quiz' ? 100 : null,
                        'pass_mark' => $lessonType === 'quiz' ? 60 : null,
                        'retake' => $lessonType === 'quiz' ? 3 : null,
                    ]);

                    $lessonSort++;
                }
            }

            $this->command->info("  - Created {$sectionSort - 1} sections with " . ($lessonSort - 1) . " lessons");
        }

        $this->command->info('Courses seeded successfully!');
    }
}
