<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolicyContentSeeder extends Seeder
{
    public function run(): void
    {
        $termsHtml = <<<'HTML'
<div style="direction:ltr;">

<p style="color:#64748b;font-size:0.95rem;">Last updated: January 1, 2026 &nbsp;|&nbsp; Effective date: January 1, 2026</p>

<p>Welcome to <strong>Swiss Bridge Academy</strong>. By accessing or using our platform at <a href="https://swissbridgeacademy.com" style="color:#4f46e5;">swissbridgeacademy.com</a>, you agree to be bound by these Terms and Conditions. Please read them carefully before registering or purchasing any course.</p>

<h2>1. About Swiss Bridge Academy</h2>
<p>Swiss Bridge Academy is an internationally oriented online learning platform operated under Swiss management standards. Our mission is to empower the next generation of creators, professionals, and leaders through world-class education, expertly crafted courses, and modern learning experiences accessible from anywhere in the world.</p>

<h2>2. Eligibility</h2>
<p>To use our platform, you must:</p>
<ul>
  <li>Be at least 16 years of age, or have parental/guardian consent if under 18.</li>
  <li>Provide accurate, complete, and current registration information.</li>
  <li>Agree to these Terms in their entirety.</li>
  <li>Not be prohibited from receiving our services under applicable law.</li>
</ul>

<h2>3. User Accounts</h2>
<p>You are responsible for maintaining the confidentiality of your account credentials. You agree to notify us immediately of any unauthorized use of your account. Swiss Bridge Academy is not liable for any loss or damage resulting from your failure to safeguard your login information.</p>
<p>Each account is for a single individual. Account sharing or transferring access to third parties is strictly prohibited and may result in immediate termination of the account.</p>

<h2>4. Course Enrollment and Access</h2>
<p>Upon successful payment, you receive a non-exclusive, non-transferable, limited license to access and view the purchased course content for personal, non-commercial educational purposes only.</p>
<ul>
  <li>Course access is granted for the lifetime of the course on our platform unless otherwise specified.</li>
  <li>We reserve the right to update, modify, or discontinue course content at any time.</li>
  <li>Certificate of completion is issued upon satisfying all course requirements as defined by the instructor.</li>
</ul>

<h2>5. Payments and Pricing</h2>
<p>All prices are displayed in the currency shown at checkout and may be subject to local taxes. Swiss Bridge Academy accepts major credit/debit cards and other payment methods as displayed on the platform.</p>
<ul>
  <li>Prices are subject to change without prior notice.</li>
  <li>Promotional discounts are time-limited and cannot be applied retroactively.</li>
  <li>Failed or declined transactions are the responsibility of the user and their financial institution.</li>
</ul>

<h2>6. Refund Policy</h2>
<p>We offer a <strong>7-day money-back guarantee</strong> on most courses, subject to the following conditions:</p>
<ul>
  <li>The refund request must be submitted within 7 days of purchase.</li>
  <li>You must not have completed more than 20% of the course content.</li>
  <li>Courses purchased during flash sales or promotional periods may not be eligible for refunds.</li>
  <li>Certificates already issued are non-refundable.</li>
</ul>
<p>To request a refund, contact our support team at <strong>support@swissbridgeacademy.com</strong> with your order details.</p>

<h2>7. Intellectual Property</h2>
<p>All content on Swiss Bridge Academy — including but not limited to course videos, lecture notes, quizzes, graphics, logos, and software — is the intellectual property of Swiss Bridge Academy or the respective content creators and is protected by applicable copyright and intellectual property laws.</p>
<p>You may not reproduce, distribute, transmit, display, publish, license, or create derivative works from any content on our platform without express written permission.</p>

<h2>8. Prohibited Conduct</h2>
<p>While using Swiss Bridge Academy, you agree not to:</p>
<ul>
  <li>Download, copy, or distribute course materials in any unauthorized manner.</li>
  <li>Share your account credentials or allow third parties to access your account.</li>
  <li>Use automated tools, bots, or scrapers to access the platform.</li>
  <li>Engage in any fraudulent, abusive, or harmful activity toward other users or our staff.</li>
  <li>Post or transmit any content that is unlawful, defamatory, or infringes on third-party rights.</li>
  <li>Attempt to gain unauthorized access to any part of the platform or its infrastructure.</li>
</ul>

<h2>9. Instructor Content</h2>
<p>Courses on our platform may be created by third-party instructors. Swiss Bridge Academy does not guarantee the accuracy, completeness, or fitness for a particular purpose of any instructor-created content. We review courses for quality standards, but ultimate responsibility for course content rests with the respective instructor.</p>

<h2>10. Disclaimers and Limitation of Liability</h2>
<p>Swiss Bridge Academy provides the platform and its content on an "as-is" and "as-available" basis. We make no warranties, express or implied, regarding the platform's reliability, accuracy, or fitness for a particular purpose.</p>
<p>To the maximum extent permitted by law, Swiss Bridge Academy shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of, or inability to use, the platform.</p>

<h2>11. Third-Party Links and Services</h2>
<p>Our platform may contain links to third-party websites or services. These links are provided for your convenience only. Swiss Bridge Academy has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third-party sites.</p>

<h2>12. Modifications to Terms</h2>
<p>Swiss Bridge Academy reserves the right to modify these Terms at any time. Changes will be posted on this page with an updated effective date. Your continued use of the platform after any changes constitutes your acceptance of the revised Terms.</p>

<h2>13. Governing Law</h2>
<p>These Terms shall be governed by and construed in accordance with Swiss law. Any disputes arising under or in connection with these Terms shall be subject to the exclusive jurisdiction of the competent courts of Switzerland.</p>

<h2>14. Contact Us</h2>
<p>If you have any questions about these Terms and Conditions, please contact us:</p>
<ul>
  <li><strong>Email:</strong> legal@swissbridgeacademy.com</li>
  <li><strong>Support:</strong> support@swissbridgeacademy.com</li>
  <li><strong>Website:</strong> <a href="https://swissbridgeacademy.com/contact-us" style="color:#4f46e5;">swissbridgeacademy.com/contact-us</a></li>
</ul>

</div>
HTML;

        $privacyHtml = <<<'HTML'
<div style="direction:ltr;">

<p style="color:#64748b;font-size:0.95rem;">Last updated: January 1, 2026 &nbsp;|&nbsp; Effective date: January 1, 2026</p>

<p>At <strong>Swiss Bridge Academy</strong>, your privacy is a fundamental priority. This Privacy Policy explains how we collect, use, disclose, and protect your personal information when you visit our website at <a href="https://swissbridgeacademy.com" style="color:#4f46e5;">swissbridgeacademy.com</a> or use any of our services.</p>

<h2>1. Who We Are</h2>
<p>Swiss Bridge Academy is an online education platform managed under Swiss quality standards, dedicated to delivering high-impact learning experiences to students globally. We are committed to protecting your personal data and complying with applicable data protection regulations, including the Swiss Federal Act on Data Protection (FADP) and, where applicable, the EU General Data Protection Regulation (GDPR).</p>

<h2>2. Information We Collect</h2>
<p>We collect information you provide directly to us and information gathered automatically when you use our platform:</p>

<h3>2.1 Information You Provide</h3>
<ul>
  <li><strong>Account information:</strong> Full name, email address, password, profile photo.</li>
  <li><strong>Payment information:</strong> Billing address, card details (processed securely via our payment providers — we do not store full card numbers).</li>
  <li><strong>Profile information:</strong> Professional background, learning interests, preferred language.</li>
  <li><strong>Communications:</strong> Messages you send us via contact forms, support tickets, or email.</li>
  <li><strong>User-generated content:</strong> Course reviews, forum posts, quiz responses.</li>
</ul>

<h3>2.2 Information Collected Automatically</h3>
<ul>
  <li><strong>Usage data:</strong> Pages visited, courses accessed, time spent, progress tracking.</li>
  <li><strong>Device information:</strong> IP address, browser type, operating system, device identifiers.</li>
  <li><strong>Cookies and tracking technologies:</strong> Session cookies, preference cookies, analytics cookies.</li>
</ul>

<h2>3. How We Use Your Information</h2>
<p>We use your personal information to:</p>
<ul>
  <li>Create and manage your account and course enrollments.</li>
  <li>Process payments and issue certificates of completion.</li>
  <li>Deliver, personalize, and improve our educational content and platform features.</li>
  <li>Send transactional emails (enrollment confirmations, receipts, password resets).</li>
  <li>Send marketing communications and course recommendations (with your consent, and always with an opt-out option).</li>
  <li>Analyze usage patterns to improve the platform experience.</li>
  <li>Comply with legal obligations and enforce our Terms and Conditions.</li>
  <li>Prevent fraud, abuse, and security threats.</li>
</ul>

<h2>4. Cookies and Tracking Technologies</h2>
<p>We use cookies and similar technologies to enhance your experience on our platform. Types of cookies we use:</p>
<ul>
  <li><strong>Essential cookies:</strong> Required for the platform to function (authentication, session management).</li>
  <li><strong>Preference cookies:</strong> Remember your language and display settings.</li>
  <li><strong>Analytics cookies:</strong> Help us understand how users interact with the platform (e.g., Google Analytics).</li>
  <li><strong>Marketing cookies:</strong> Used to deliver relevant advertisements (only with your consent).</li>
</ul>
<p>You can manage or disable cookies through your browser settings. Note that disabling certain cookies may affect platform functionality.</p>

<h2>5. How We Share Your Information</h2>
<p>We do not sell, rent, or trade your personal information. We may share data with:</p>
<ul>
  <li><strong>Service providers:</strong> Payment processors, email delivery services, cloud hosting providers who process data on our behalf under strict data processing agreements.</li>
  <li><strong>Instructors:</strong> Course instructors may access aggregate (anonymized) data about their students' progress.</li>
  <li><strong>Legal authorities:</strong> When required by law, court order, or to protect the rights and safety of Swiss Bridge Academy and its users.</li>
  <li><strong>Business transfers:</strong> In the event of a merger, acquisition, or sale of assets, your data may be transferred as part of that transaction.</li>
</ul>

<h2>6. Data Retention</h2>
<p>We retain your personal data for as long as your account is active or as needed to provide our services. Specifically:</p>
<ul>
  <li>Account data is retained for the life of your account plus 3 years after closure for legal compliance.</li>
  <li>Transaction records are retained for 10 years as required by Swiss financial regulations.</li>
  <li>Marketing consent records are retained until you withdraw consent.</li>
</ul>

<h2>7. Your Rights</h2>
<p>Depending on your location, you may have the following rights regarding your personal data:</p>
<ul>
  <li><strong>Access:</strong> Request a copy of the personal data we hold about you.</li>
  <li><strong>Rectification:</strong> Request correction of inaccurate or incomplete data.</li>
  <li><strong>Erasure:</strong> Request deletion of your personal data ("right to be forgotten"), subject to legal obligations.</li>
  <li><strong>Restriction:</strong> Request that we limit the processing of your data.</li>
  <li><strong>Data portability:</strong> Receive your data in a structured, machine-readable format.</li>
  <li><strong>Objection:</strong> Object to processing based on legitimate interests or for direct marketing.</li>
  <li><strong>Withdraw consent:</strong> Withdraw consent at any time where processing is based on consent.</li>
</ul>
<p>To exercise any of these rights, contact us at <strong>privacy@swissbridgeacademy.com</strong>. We will respond within 30 days.</p>

<h2>8. Data Security</h2>
<p>We implement industry-standard security measures to protect your personal information, including:</p>
<ul>
  <li>SSL/TLS encryption for all data transmitted between your browser and our servers.</li>
  <li>Secure, access-controlled data storage on reputable cloud infrastructure.</li>
  <li>Regular security audits and vulnerability assessments.</li>
  <li>Strict access controls ensuring only authorized personnel can access personal data.</li>
</ul>
<p>While we take all reasonable precautions, no method of data transmission or storage is 100% secure. We encourage you to use strong, unique passwords for your account.</p>

<h2>9. International Data Transfers</h2>
<p>Swiss Bridge Academy operates globally. Your data may be transferred to and processed in countries outside your country of residence. When transferring data internationally, we ensure appropriate safeguards are in place, such as Standard Contractual Clauses or adequacy decisions recognized under applicable law.</p>

<h2>10. Children's Privacy</h2>
<p>Our platform is not intended for children under the age of 16. We do not knowingly collect personal information from children under 16. If you believe a child under 16 has provided us with personal information, please contact us immediately and we will take steps to delete that information.</p>

<h2>11. Third-Party Services</h2>
<p>Our platform may integrate with third-party services (payment processors, video hosting, analytics). Each third-party service has its own privacy policy, and we encourage you to review them. Swiss Bridge Academy is not responsible for the privacy practices of third-party services.</p>

<h2>12. Changes to This Policy</h2>
<p>We may update this Privacy Policy from time to time. When we make significant changes, we will notify you via email or a prominent notice on the platform. Your continued use of the platform after changes are posted constitutes your acceptance of the revised policy.</p>

<h2>13. Contact Us</h2>
<p>For any questions, requests, or concerns regarding this Privacy Policy or how we handle your personal data, please contact our Data Protection Officer:</p>
<ul>
  <li><strong>Email:</strong> privacy@swissbridgeacademy.com</li>
  <li><strong>Support:</strong> support@swissbridgeacademy.com</li>
  <li><strong>Website:</strong> <a href="https://swissbridgeacademy.com/contact-us" style="color:#4f46e5;">swissbridgeacademy.com/contact-us</a></li>
</ul>

</div>
HTML;

        $items = [
            ['key' => 'terms_and_condition', 'value' => $termsHtml],
            ['key' => 'privacy_policy',      'value' => $privacyHtml],
        ];

        foreach ($items as $item) {
            DB::table('frontend_settings')->updateOrInsert(
                ['key' => $item['key']],
                ['value' => $item['value'], 'updated_at' => now()]
            );
        }
    }
}
