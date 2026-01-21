-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 21, 2026 at 12:17 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u790947786_lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `is_paid` int(11) DEFAULT NULL,
  `is_best` int(11) NOT NULL DEFAULT 0,
  `price` double DEFAULT NULL,
  `discounted_price` double DEFAULT NULL,
  `discount_flag` int(11) DEFAULT NULL,
  `enable_drip_content` int(11) DEFAULT NULL,
  `drip_content_settings` longtext DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `preview` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `requirements` mediumtext DEFAULT NULL,
  `outcomes` mediumtext DEFAULT NULL,
  `faqs` mediumtext DEFAULT NULL,
  `instructor_ids` text DEFAULT NULL,
  `average_rating` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `expiry_period` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `short_description`, `user_id`, `category_id`, `course_type`, `status`, `level`, `language`, `is_paid`, `is_best`, `price`, `discounted_price`, `discount_flag`, `enable_drip_content`, `drip_content_settings`, `meta_keywords`, `meta_description`, `thumbnail`, `banner`, `preview`, `description`, `requirements`, `outcomes`, `faqs`, `instructor_ids`, `average_rating`, `created_at`, `updated_at`, `expiry_period`) VALUES
(1, 'Complete Web Development Bootcamp', 'complete-web-development-bootcamp', 'Master web development from scratch. Learn HTML, CSS, JavaScript, React, and Node.js.', 4, 1, 'general', 'active', 'beginner', 'English', 1, 0, 99.99, 79.99, 1, 1, '{\"lesson_completion_role\":\"percentage\",\"minimum_duration\":15,\"minimum_percentage\":\"90\",\"locked_lesson_message\":\"&lt;h3 style=&quot;text-align: center;&quot;&gt;&lt;span&gt;&lt;strong&gt;Permission denied!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/h3&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span&gt;This course supports drip content, so you must complete the previous lessons.&lt;\\/span&gt;&lt;\\/p&gt;\"}', 'Complete Web Development Bootcamp, online course, learn, tutorial', 'Master web development from scratch. Learn HTML, CSS, JavaScript, React, and Node.js.', 'uploads/course-thumbnail/complete-web-development-bootcamp-1768997398.jpg', 'uploads/course-banner/complete-web-development-bootcamp-1768997398.jpg', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[4]', 5, '2026-01-16 13:39:40', '2026-01-21 18:09:58', NULL),
(2, 'Advanced JavaScript and React', 'advanced-javascript-and-react', 'Deep dive into modern JavaScript and React development patterns.', 5, 2, 'general', 'active', 'intermediate', 'English', 1, 0, 149.99, NULL, 0, NULL, NULL, 'Advanced JavaScript and React, online course, learn, tutorial', 'Deep dive into modern JavaScript and React development patterns.', 'uploads/course-thumbnail/advanced-javascript-and-react-1768997348.jpg', 'uploads/course-banner/advanced-javascript-and-react-1768997348.jpg', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[5]', 5, '2026-01-16 13:39:40', '2026-01-21 18:09:08', NULL),
(3, 'Python for Data Science', 'python-for-data-science', 'Learn Python programming and data analysis with real-world projects.', 10, 3, 'general', 'active', 'beginner', 'English', 1, 0, 89.99, 69.99, 1, NULL, NULL, 'Python for Data Science, online course, learn, tutorial', 'Learn Python programming and data analysis with real-world projects.', 'uploads/course-thumbnail/python-for-data-science-1768997294.webp', 'uploads/course-banner/python-for-data-science-1768997294.webp', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[10]', 4, '2026-01-16 13:39:40', '2026-01-21 18:08:15', NULL),
(4, 'Machine Learning Masterclass', 'machine-learning-masterclass', 'Comprehensive machine learning course covering algorithms and practical applications.', 4, 4, 'general', 'active', 'advanced', 'English', 1, 0, 199.99, NULL, 0, NULL, NULL, 'Machine Learning Masterclass, online course, learn, tutorial', 'Comprehensive machine learning course covering algorithms and practical applications.', 'uploads/course-thumbnail/machine-learning-masterclass-1768997487.webp', 'uploads/course-banner/machine-learning-masterclass-1768997487.webp', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[4]', 5, '2026-01-16 13:39:40', '2026-01-21 18:11:27', NULL),
(5, 'UI/UX Design Fundamentals', 'uiux-design-fundamentals', 'Learn the principles of user interface and user experience design.', 9, 5, 'general', 'active', 'beginner', 'English', 1, 0, 79.99, 59.99, 1, NULL, NULL, 'UI/UX Design Fundamentals, online course, learn, tutorial', 'Learn the principles of user interface and user experience design.', 'uploads/course-thumbnail/uiux-design-fundamentals-1768997244.jpg', 'uploads/course-banner/uiux-design-fundamentals-1768997244.jpg', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[9]', 4, '2026-01-16 13:39:40', '2026-01-21 18:07:24', NULL),
(6, 'Digital Marketing Complete Guide', 'digital-marketing-complete-guide', 'Master digital marketing strategies including SEO, social media, and content marketing.', 8, 6, 'general', 'active', 'beginner', 'English', 1, 0, 119.99, NULL, 0, NULL, NULL, 'Digital Marketing Complete Guide, online course, learn, tutorial', 'Master digital marketing strategies including SEO, social media, and content marketing.', 'uploads/course-thumbnail/digital-marketing-complete-guide-1768997214.webp', 'uploads/course-banner/digital-marketing-complete-guide-1768997214.webp', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[8]', 5, '2026-01-16 13:39:40', '2026-01-21 18:06:54', NULL),
(7, 'Mobile App Development with Flutter', 'mobile-app-development-with-flutter', 'Build cross-platform mobile apps using Flutter framework.', 4, 7, 'general', 'active', 'intermediate', 'English', 1, 0, 129.99, 99.99, 1, NULL, NULL, 'Mobile App Development with Flutter, online course, learn, tutorial', 'Build cross-platform mobile apps using Flutter framework.', 'uploads/course-thumbnail/mobile-app-development-with-flutter-1768997181.jpg', 'uploads/course-banner/mobile-app-development-with-flutter-1768997181.jpg', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[4]', 5, '2026-01-16 13:39:40', '2026-01-21 18:06:21', NULL),
(8, 'Professional Photography Course', 'professional-photography-course', 'Learn professional photography techniques and post-processing.', 9, 8, 'general', 'active', 'beginner', 'English', 1, 0, 89.99, NULL, 0, NULL, NULL, 'Professional Photography Course, online course, learn, tutorial', 'Learn professional photography techniques and post-processing.', 'uploads/course-thumbnail/professional-photography-course-1768997143.webp', 'uploads/course-banner/professional-photography-course-1768997143.webp', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[9]', 5, '2026-01-16 13:39:40', '2026-01-21 18:05:43', NULL),
(9, 'Cybersecurity Essentials', 'cybersecurity-essentials', 'Learn cybersecurity fundamentals and ethical hacking techniques.', 8, 9, 'general', 'active', 'intermediate', 'English', 1, 0, 159.99, 129.99, 1, NULL, NULL, 'Cybersecurity Essentials, online course, learn, tutorial', 'Learn cybersecurity fundamentals and ethical hacking techniques.', 'uploads/course-thumbnail/cybersecurity-essentials-1768997078.webp', 'uploads/course-banner/cybersecurity-essentials-1768997078.webp', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[8]', 5, '2026-01-16 13:39:40', '2026-01-21 18:04:38', NULL),
(10, 'Business Strategy and Leadership', 'business-strategy-and-leadership', 'Develop strategic thinking and leadership skills for business success.', 7, 10, 'general', 'active', 'advanced', 'English', 1, 0, 179.99, NULL, 0, NULL, NULL, 'Business Strategy and Leadership, online course, learn, tutorial', 'Develop strategic thinking and leadership skills for business success.', 'uploads/course-thumbnail/-1768996572.jpg', 'uploads/course-banner/-1768996572.jpg', NULL, 'This comprehensive course will take you from beginner to advanced level. You\'ll learn through hands-on projects and real-world examples. Our step-by-step approach ensures you understand every concept thoroughly. By the end of this course, you\'ll have the skills and confidence to apply what you\'ve learned in professional settings.', 'Basic computer skills, internet connection, willingness to learn', 'Master the fundamentals, build real-world projects, gain practical experience', '[{\"question\":\"Is this course suitable for beginners?\",\"answer\":\"Yes, this course is designed for all skill levels.\"},{\"question\":\"How long do I have access?\",\"answer\":\"Lifetime access to all course materials.\"}]', '[7]', 5, '2026-01-16 13:39:40', '2026-01-21 17:56:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_user_id_index` (`user_id`),
  ADD KEY `courses_category_id_index` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
