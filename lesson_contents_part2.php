<?php
require_once __DIR__ . '/slide_template.php';

/**
 * Lessons 5-10 — Frontend Mastery (HTML, CSS, Bootstrap, Tailwind, JS, TS, React).
 */

function lesson_05_content(): string {
    $T = 'SlideTemplate'; $total = 21;
    $p = [];
    $p[] = $T::cover(5, 24,
        'HTML5 — Semantic Markup & Accessible Structure with AI',
        'HTML is the skeleton of every web page. Modern HTML5 gives us semantic tags, forms, media, and accessibility super-powers — let\'s master them with AI as our co-pilot.',
        'Module 2', '4h');

    $p[] = $T::slide(2, $total, 'Lesson Objectives', $T::bulletList([
        'Write clean, <b>semantic</b> HTML5 that search engines and screen readers love',
        'Master every form input type, including HTML5 validation',
        'Embed images, video, and audio correctly and responsively',
        'Use ARIA attributes to make pages accessible (WCAG AA)',
        'Use AI to generate markup from plain-English descriptions',
    ]));

    $p[] = $T::slide(3, $total, 'The Anatomy of an HTML5 Document',
        $T::codeBlock(
"<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <title>Swiss Bridge Academy</title>
  <meta name=\"description\" content=\"AI-powered full-stack bootcamp\">
  <link rel=\"stylesheet\" href=\"style.css\">
</head>
<body>
  <header><!-- nav --></header>
  <main>
    <article>
      <h1>Welcome</h1>
      <p>Content goes here…</p>
    </article>
  </main>
  <footer>© 2026</footer>
  <script src=\"app.js\" defer></script>
</body>
</html>", 'html'));

    $p[] = $T::slide(4, $total, 'Semantic Tags — Why They Matter',
        $T::table(['Tag', 'Use for'], [
            ['<code class="sba-inline">&lt;header&gt;</code>', 'Top bar, logo + nav'],
            ['<code class="sba-inline">&lt;nav&gt;</code>', 'Primary navigation'],
            ['<code class="sba-inline">&lt;main&gt;</code>', 'The unique page content (only one per page)'],
            ['<code class="sba-inline">&lt;article&gt;</code>', 'A standalone piece (blog post, product card)'],
            ['<code class="sba-inline">&lt;section&gt;</code>', 'A thematic grouping with a heading'],
            ['<code class="sba-inline">&lt;aside&gt;</code>', 'Related but tangential (sidebar)'],
            ['<code class="sba-inline">&lt;footer&gt;</code>', 'Page or section footer'],
            ['<code class="sba-inline">&lt;figure&gt;/&lt;figcaption&gt;</code>', 'Image with a caption'],
        ]) .
        $T::callout('success', 'SEO bonus', 'Semantic HTML helps Google understand page structure → higher rankings.'));

    $p[] = $T::slide(5, $total, 'Heading Hierarchy (h1-h6)',
        $T::codeBlock(
"<h1>Swiss Bridge Academy</h1>        <!-- one per page -->
  <h2>Courses</h2>
    <h3>Web Development</h3>
      <h4>Lesson 5 – HTML</h4>
    <h3>Data Science</h3>
  <h2>Instructors</h2>", 'html') .
        $T::callout('warning', 'Rule', 'Never skip levels (h1 → h3). It breaks screen readers and SEO.'));

    $p[] = $T::slide(6, $total, 'Lists, Links & Images',
        $T::codeBlock(
"<!-- Unordered list -->
<ul>
  <li>HTML</li><li>CSS</li><li>JavaScript</li>
</ul>

<!-- Ordered list -->
<ol>
  <li>First</li><li>Second</li><li>Third</li>
</ol>

<!-- Link -->
<a href=\"/courses\" title=\"Browse all courses\">All Courses</a>

<!-- Image with modern attributes -->
<img src=\"/hero.webp\"
     alt=\"Students coding together\"
     width=\"1200\" height=\"600\"
     loading=\"lazy\"
     decoding=\"async\">", 'html'));

    $p[] = $T::slide(7, $total, 'Forms — The Complete Toolkit',
        $T::codeBlock(
"<form action=\"/register\" method=\"post\" novalidate>
  <label for=\"email\">Email</label>
  <input id=\"email\" name=\"email\" type=\"email\"
         required autocomplete=\"email\">

  <label for=\"pw\">Password</label>
  <input id=\"pw\" name=\"password\" type=\"password\"
         required minlength=\"12\" autocomplete=\"new-password\">

  <label for=\"dob\">Date of birth</label>
  <input id=\"dob\" name=\"dob\" type=\"date\" required>

  <fieldset>
    <legend>Plan</legend>
    <label><input type=\"radio\" name=\"plan\" value=\"free\" checked> Free</label>
    <label><input type=\"radio\" name=\"plan\" value=\"pro\"> Pro — \$9/mo</label>
  </fieldset>

  <button type=\"submit\">Create account</button>
</form>", 'html'));

    $p[] = $T::slide(8, $total, 'All 22 HTML5 Input Types',
        $T::table(['Type', 'Use for'], [
            ['text, email, password, url, tel', 'Common text inputs'],
            ['number, range', 'Numeric input + slider'],
            ['date, time, datetime-local, month, week', 'Temporal inputs'],
            ['color', 'Native color picker'],
            ['search', 'Styled differently by browsers'],
            ['file', 'File upload with <code class="sba-inline">accept="image/*"</code>'],
            ['checkbox, radio', 'Multi / single selection'],
            ['hidden', 'CSRF tokens, IDs'],
        ]));

    $p[] = $T::slide(9, $total, 'Responsive Media: <code>&lt;picture&gt;</code> and <code>&lt;video&gt;</code>',
        $T::codeBlock(
"<picture>
  <source srcset=\"/hero-small.webp 480w,
                   /hero-large.webp 1200w\"
          sizes=\"(max-width: 600px) 480px, 1200px\"
          type=\"image/webp\">
  <img src=\"/hero.jpg\" alt=\"Hero banner\">
</picture>

<video controls poster=\"/poster.jpg\" width=\"640\" preload=\"metadata\">
  <source src=\"/intro.webm\" type=\"video/webm\">
  <source src=\"/intro.mp4\"  type=\"video/mp4\">
  Sorry, your browser doesn't support HTML5 video.
</video>", 'html'));

    $p[] = $T::slide(10, $total, 'Accessibility — Quick Wins',
        $T::bulletList([
            'Every <code class="sba-inline">&lt;img&gt;</code> has an <code class="sba-inline">alt</code> attribute (empty if decorative)',
            'Every form input has a <code class="sba-inline">&lt;label&gt;</code> associated by <code class="sba-inline">for</code>/<code class="sba-inline">id</code>',
            'Buttons say what they do: "Add to cart" beats "Click here"',
            'Use real <code class="sba-inline">&lt;button&gt;</code> elements, not <code class="sba-inline">&lt;div onclick&gt;</code>',
            'Keyboard users can tab through every interactive element in logical order',
            'Color contrast ≥ 4.5:1 for normal text (WCAG AA)',
        ]));

    $p[] = $T::slide(11, $total, 'ARIA — When HTML Is Not Enough',
        $T::codeBlock(
"<!-- A custom dialog -->
<div role=\"dialog\"
     aria-labelledby=\"dlgTitle\"
     aria-describedby=\"dlgDesc\"
     aria-modal=\"true\">
  <h2 id=\"dlgTitle\">Delete account?</h2>
  <p id=\"dlgDesc\">This action cannot be undone.</p>
  <button>Cancel</button>
  <button aria-label=\"Confirm delete\">Delete</button>
</div>

<!-- Live region (dynamic updates) -->
<div role=\"status\" aria-live=\"polite\">3 items in cart</div>

<!-- Hiding decorative icon from screen readers -->
<svg aria-hidden=\"true\">…</svg>", 'html'));

    $p[] = $T::slide(12, $total, 'SEO Meta & Open Graph',
        $T::codeBlock(
"<head>
  <title>AI-Powered Full Stack Bootcamp – Swiss Bridge Academy</title>
  <meta name=\"description\" content=\"24 lessons that take you from zero to deploying real e-commerce stores with AI.\">
  <link rel=\"canonical\" href=\"https://swissbridgeacademy.com/courses/ai-full-stack\">

  <!-- Open Graph (Facebook, LinkedIn, iMessage) -->
  <meta property=\"og:title\"       content=\"AI Full Stack Bootcamp\">
  <meta property=\"og:description\" content=\"Zero to deployed in 24 lessons\">
  <meta property=\"og:image\"       content=\"https://.../og-image.png\">
  <meta property=\"og:type\"        content=\"website\">

  <!-- Twitter Card -->
  <meta name=\"twitter:card\" content=\"summary_large_image\">
</head>", 'html'));

    $p[] = $T::slide(13, $total, 'Hands-On — Build Your Portfolio Homepage',
        $T::paragraph('Create <code class="sba-inline">portfolio/index.html</code> with these sections:') .
        $T::numberedList([
            '<code class="sba-inline">&lt;header&gt;</code> with your logo + <code class="sba-inline">&lt;nav&gt;</code> (Home, About, Projects, Contact)',
            '<code class="sba-inline">&lt;main&gt;</code> containing three <code class="sba-inline">&lt;section&gt;</code>s: hero, projects, contact form',
            'At least three <code class="sba-inline">&lt;article&gt;</code> cards in the projects section',
            'A working contact form with at least 4 inputs',
            'A <code class="sba-inline">&lt;footer&gt;</code> with copyright + social links',
        ]));

    $p[] = $T::slide(14, $total, 'Prompting AI to Generate HTML',
        $T::codeBlock(
"ROLE: Senior web developer.
TASK: Generate a single index.html for a SaaS landing page
      for an app called 'BudgetWise'.
REQUIREMENTS:
  - Pure semantic HTML5, no CSS or JS
  - Sections: hero, features (3 cards), testimonials (2),
              pricing table (3 tiers), FAQ (4 items), footer
  - Open Graph & Twitter meta in the head
  - All images use /placeholder.jpg with good alts
  - Form at the bottom: email + CTA button
  - Add aria-labels where semantics are ambiguous
OUTPUT: the full file only — no commentary.", 'prompt'));

    $p[] = $T::slide(15, $total, 'Common HTML Mistakes The AI Will Catch',
        $T::bulletList([
            'Multiple <code class="sba-inline">&lt;h1&gt;</code> tags on one page',
            'Using <code class="sba-inline">&lt;b&gt;</code> instead of <code class="sba-inline">&lt;strong&gt;</code>, or <code class="sba-inline">&lt;i&gt;</code> instead of <code class="sba-inline">&lt;em&gt;</code>',
            'Missing <code class="sba-inline">alt</code> on images',
            'Using <code class="sba-inline">&lt;table&gt;</code> for layout',
            'Inline styles instead of a stylesheet',
            'Omitting <code class="sba-inline">lang</code> on <code class="sba-inline">&lt;html&gt;</code>',
        ]));

    $p[] = $T::slide(16, $total, 'HTML Entities & Characters',
        $T::table(['Entity', 'Renders', 'Use for'], [
            ['<code class="sba-inline">&amp;amp;</code>', '&amp;', 'Ampersand in text'],
            ['<code class="sba-inline">&amp;lt; &amp;gt;</code>', '&lt; &gt;', 'Showing code'],
            ['<code class="sba-inline">&amp;copy;</code>', '©', 'Copyright'],
            ['<code class="sba-inline">&amp;nbsp;</code>', 'non-breaking space', 'Keeping words together'],
            ['<code class="sba-inline">&amp;mdash;</code>', '—', 'Em-dash'],
            ['<code class="sba-inline">&amp;hellip;</code>', '…', 'Ellipsis'],
        ]));

    $p[] = $T::slide(17, $total, 'Validating Your HTML',
        $T::numberedList([
            'Go to <code class="sba-inline">validator.w3.org</code>',
            'Paste your URL or upload your file',
            'Fix every error and warning',
            'Repeat until the page is "clean"',
        ]) .
        $T::callout('info', 'Why validate', 'Invalid markup is the #1 cause of weird cross-browser bugs.'));

    $p[] = $T::slide(18, $total, 'Testing Screen Readers',
        $T::table(['OS', 'Built-in reader', 'Shortcut'], [
            ['Windows', 'Narrator', 'Win + Ctrl + Enter'],
            ['macOS', 'VoiceOver', 'Cmd + F5'],
            ['Chromebook', 'ChromeVox', 'Ctrl + Alt + Z'],
            ['iOS', 'VoiceOver', 'Settings → Accessibility'],
        ]) .
        $T::paragraph('Listen to your own page for 2 minutes. If something feels awkward, fix the markup — don\'t blame the reader.'));

    $p[] = $T::slide(19, $total, 'Performance Checklist',
        $T::bulletList([
            'Use <code class="sba-inline">loading="lazy"</code> for below-the-fold images',
            'Use <code class="sba-inline">decoding="async"</code> to avoid blocking render',
            'Preload critical assets: <code class="sba-inline">&lt;link rel="preload" as="font"&gt;</code>',
            'Use WebP or AVIF instead of JPEG/PNG where possible',
            'Put <code class="sba-inline">&lt;script defer&gt;</code> at the bottom of <code class="sba-inline">&lt;body&gt;</code>',
        ]));

    $p[] = $T::slide(20, $total, 'Key Takeaways', $T::bulletList([
        'HTML5 is <b>semantic first</b> — pick the tag that describes the meaning',
        'Forms have 22 input types and built-in validation',
        'Accessibility is a baseline requirement, not a bonus',
        'Meta tags control how you appear in Google and social',
        'AI can generate whole pages — but you must still read and validate them',
    ]), 'sba-recap');

    $p[] = $T::slide(21, $total, 'Up Next — Lesson 6',
        $T::lead('Markup gives pages meaning — CSS gives them beauty. Next: <b>CSS3 Deep Dive — Flexbox, Grid, Animations & Responsive Design</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_06_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(6, 24,
        'CSS3 Deep Dive — Flexbox, Grid, Animations & Responsive Design',
        'From zero CSS knowledge to writing production-grade layouts with Flexbox, CSS Grid, custom properties, keyframe animations and a mobile-first mindset.',
        'Module 2', '4h 30m');

    $p[] = $T::slide(2, $total, 'What You Will Learn', $T::bulletList([
        'The three CSS inheritance rules (Cascade, Specificity, Inheritance)',
        'Every unit you need: <code class="sba-inline">px, rem, em, %, vh, vw, fr, ch</code>',
        '<b>Flexbox</b> for 1D layouts (nav bars, card rows)',
        '<b>CSS Grid</b> for 2D layouts (entire page templates)',
        '<b>@media</b> queries + container queries for responsive design',
        'Smooth animations with <code class="sba-inline">transition</code> and <code class="sba-inline">@keyframes</code>',
        'Custom properties (CSS variables) and modern color spaces',
    ]));

    $p[] = $T::slide(3, $total, 'How CSS Is Applied',
        $T::codeBlock(
"<!-- 1. External (best) -->
<link rel=\"stylesheet\" href=\"style.css\">

<!-- 2. Internal -->
<style>
  body { background: #0f172a; color: #fff; }
</style>

<!-- 3. Inline (avoid) -->
<p style=\"color:red\">Warning</p>", 'html'));

    $p[] = $T::slide(4, $total, 'Specificity — Who Wins?',
        $T::paragraph('When two rules target the same element, the more <b>specific</b> selector wins. Think of specificity as a four-digit number:') .
        $T::table(['Selector', 'Specificity', 'Example'], [
            ['Inline style', '1,0,0,0', '<code class="sba-inline">style="color:red"</code>'],
            ['#id', '0,1,0,0', '<code class="sba-inline">#main</code>'],
            ['.class, [attr], :pseudo', '0,0,1,0', '<code class="sba-inline">.card</code>'],
            ['tag, ::pseudo-element', '0,0,0,1', '<code class="sba-inline">p</code>, <code class="sba-inline">::before</code>'],
        ]) .
        $T::callout('warning', '!important', 'Overrides everything. Use only as a last resort.'));

    $p[] = $T::slide(5, $total, 'The Box Model',
        $T::codeBlock(
"/* Every element is a box with four boundaries */
.card {
  box-sizing: border-box;  /* include padding+border in width */
  width: 320px;
  padding: 16px;
  border: 2px solid #6366f1;
  margin: 12px;
}

/* Universal rule — put this at the top of every stylesheet */
*, *::before, *::after { box-sizing: border-box; }", 'css'));

    $p[] = $T::slide(6, $total, 'Units — When To Use What',
        $T::table(['Unit', 'Meaning', 'Use for'], [
            ['<b>px</b>', 'Absolute pixels', 'Borders, shadows'],
            ['<b>rem</b>', 'Root font-size', 'Fonts, spacing, sizing'],
            ['<b>em</b>', 'Parent font-size', 'Component-relative spacing'],
            ['<b>%</b>', 'Parent dimension', 'Fluid widths'],
            ['<b>vh / vw</b>', 'Viewport height/width', 'Full-screen heroes'],
            ['<b>fr</b>', 'Grid fraction', 'Grid columns'],
            ['<b>ch</b>', '"0" character width', 'Ideal line length'],
        ]) .
        $T::callout('success', 'Rule of thumb', 'Use <code class="sba-inline">rem</code> for fonts and spacing so users can zoom.'));

    $p[] = $T::slide(7, $total, 'Flexbox — 1D Layout',
        $T::codeBlock(
".nav {
  display: flex;
  justify-content: space-between;  /* main-axis  */
  align-items: center;             /* cross-axis */
  gap: 1rem;
  padding: 1rem 2rem;
}

.nav-links {
  display: flex;
  gap: 1.5rem;
  list-style: none;
}

/* Responsive: stack vertically on mobile */
@media (max-width: 640px) {
  .nav { flex-direction: column; }
}", 'css') .
        $T::callout('info', 'Mental model', 'Flex thinks in rows (or columns). For full 2D layouts use Grid.'));

    $p[] = $T::slide(8, $total, 'The 5 Flex Properties You Use Daily',
        $T::table(['Property', 'Values'], [
            ['<code class="sba-inline">flex-direction</code>', 'row | column | row-reverse'],
            ['<code class="sba-inline">justify-content</code>', 'flex-start | center | space-between | space-around'],
            ['<code class="sba-inline">align-items</code>', 'stretch | flex-start | center | flex-end'],
            ['<code class="sba-inline">gap</code>', 'any length — replaces margin hacks'],
            ['<code class="sba-inline">flex</code> (shorthand)', '<code class="sba-inline">1 1 0</code> on children for equal columns'],
        ]));

    $p[] = $T::slide(9, $total, 'CSS Grid — 2D Layout',
        $T::codeBlock(
".page {
  display: grid;
  grid-template-columns: 240px 1fr;
  grid-template-rows: auto 1fr auto;
  grid-template-areas:
    \"header header\"
    \"sidebar main\"
    \"footer footer\";
  min-height: 100vh;
  gap: 1rem;
}
header  { grid-area: header;  }
nav     { grid-area: sidebar; }
main    { grid-area: main;    }
footer  { grid-area: footer;  }", 'css') .
        $T::callout('success', 'Cheat code', '<code class="sba-inline">grid-template-areas</code> makes layouts readable like ASCII art.'));

    $p[] = $T::slide(10, $total, 'Responsive Product Grid In 6 Lines',
        $T::codeBlock(
".products {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 1.5rem;
}", 'css') .
        $T::paragraph('That one rule creates a responsive grid that grows from 1 to N columns automatically, without media queries.'));

    $p[] = $T::slide(11, $total, 'Media Queries — The Mobile-First Way',
        $T::codeBlock(
"/* Base = mobile */
.card { font-size: 1rem; padding: 1rem; }

/* 640px+ */
@media (min-width: 40rem) {
  .card { font-size: 1.125rem; padding: 1.5rem; }
}

/* 1024px+ */
@media (min-width: 64rem) {
  .card { font-size: 1.25rem; padding: 2rem; }
}", 'css') .
        $T::callout('info', 'Why mobile-first', '70%+ of traffic is mobile. Write for phones first, enhance for desktops.'));

    $p[] = $T::slide(12, $total, 'Container Queries (2024+)',
        $T::codeBlock(
".product-card {
  container-type: inline-size;
  container-name: card;
}

@container card (min-width: 400px) {
  .product-card { display: grid; grid-template-columns: 120px 1fr; }
}", 'css') .
        $T::paragraph('Container queries style an element based on its <b>own</b> size, not the viewport — essential for reusable components.'));

    $p[] = $T::slide(13, $total, 'Custom Properties (CSS Variables)',
        $T::codeBlock(
":root {
  --primary:   #6366f1;
  --secondary: #ec4899;
  --radius:    0.75rem;
  --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
}
.button {
  background: var(--primary);
  border-radius: var(--radius);
  box-shadow: var(--shadow-md);
}
/* Dark-mode override */
@media (prefers-color-scheme: dark) {
  :root { --primary: #8b5cf6; }
}", 'css'));

    $p[] = $T::slide(14, $total, 'Transitions — Smooth Interactions',
        $T::codeBlock(
".button {
  background: #6366f1;
  transform: translateY(0);
  transition: background 200ms ease,
              transform  200ms ease;
}
.button:hover {
  background: #4f46e5;
  transform: translateY(-2px);
}", 'css') .
        $T::callout('warning', 'Rule', 'Transition only <code class="sba-inline">transform</code> and <code class="sba-inline">opacity</code> — they are GPU-accelerated and won\'t jank.'));

    $p[] = $T::slide(15, $total, '@keyframes Animations',
        $T::codeBlock(
"@keyframes fadeUp {
  from { opacity: 0; transform: translateY(30px); }
  to   { opacity: 1; transform: translateY(0);   }
}
.hero-text { animation: fadeUp 700ms 100ms ease-out both; }

/* Respect user\'s motion preference */
@media (prefers-reduced-motion: reduce) {
  * { animation: none !important; transition: none !important; }
}", 'css'));

    $p[] = $T::slide(16, $total, 'Modern Color — OKLCH',
        $T::codeBlock(
":root {
  /* Perceptually uniform — consistent brightness */
  --brand-500: oklch(60% 0.2 270);
  --brand-600: oklch(52% 0.22 270);
  --brand-700: oklch(44% 0.22 270);
}

.button {
  background: var(--brand-500);
  color: oklch(98% 0.02 270);
}", 'css') .
        $T::paragraph('OKLCH replaces HSL. It lets you build perceptually even color ramps from a single hue.'));

    $p[] = $T::slide(17, $total, 'Typography Best Practices',
        $T::codeBlock(
"body {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  font-size: clamp(1rem, 0.9rem + 0.3vw, 1.125rem);
  line-height: 1.7;
  color: #1e293b;
  text-wrap: pretty;  /* avoid widows */
}

h1 { font-size: clamp(2rem, 1.3rem + 2vw, 3.5rem); line-height: 1.1; }

/* Ideal reading measure */
article p { max-width: 72ch; }", 'css'));

    $p[] = $T::slide(18, $total, 'CSS Prompt Patterns',
        $T::codeBlock(
"Write CSS for a pricing-card component.

REQUIREMENTS:
  - Vertical card 320px wide
  - Gradient purple-pink border (2px)
  - Rounded 16px corners
  - 24px inner padding
  - Slight lift on hover (translateY + shadow)
  - Respect prefers-reduced-motion

OUTPUT: A single BEM-named block (.pricing-card__*).", 'prompt'));

    $p[] = $T::slide(19, $total, 'Debugging CSS',
        $T::bulletList([
            'Temporary <code class="sba-inline">outline: 1px solid red</code> on every element to see boxes',
            'Chrome DevTools "Computed" tab shows the final value',
            'The "Layers" tab shows GPU layers for perf',
            '<code class="sba-inline">* { background: rgba(255,0,0,0.1) !important }</code> exposes overflow',
            'Cmd/Ctrl + Shift + C = pick an element then live-edit',
        ]));

    $p[] = $T::slide(20, $total, 'Performance Tips',
        $T::bulletList([
            'Avoid <code class="sba-inline">@import</code> in CSS (extra request); use <code class="sba-inline">&lt;link&gt;</code>',
            'Minify and tree-shake in production',
            'Use <code class="sba-inline">will-change: transform</code> only for animating elements — then remove it',
            'Audit with Lighthouse — keep "Unused CSS" under 10%',
            'Self-host fonts with <code class="sba-inline">font-display: swap</code>',
        ]));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Start mobile-first, enhance with <code class="sba-inline">min-width</code> media queries',
        'Flexbox for rows, Grid for pages, container queries for components',
        'CSS variables unify themes and enable dark mode',
        'Animate only <code class="sba-inline">transform</code> and <code class="sba-inline">opacity</code>',
        'Respect <code class="sba-inline">prefers-reduced-motion</code>',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 7',
        $T::lead('Writing CSS from scratch every time is slow. Next: <b>Bootstrap 5 & Tailwind CSS — build landing pages fast with AI</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_07_content(): string {
    $T = 'SlideTemplate'; $total = 21;
    $p = [];
    $p[] = $T::cover(7, 24,
        'Bootstrap 5 & Tailwind CSS — Build Landing Pages Fast with AI',
        'Stop reinventing buttons. In this lesson you ship two identical landing pages — once with Bootstrap components, once with Tailwind utilities — and let AI do the heavy lifting in both.',
        'Module 2', '3h 45m');

    $p[] = $T::slide(2, $total, 'Bootstrap vs Tailwind — The Honest Comparison',
        $T::table(['Axis', 'Bootstrap', 'Tailwind'], [
            ['Philosophy', 'Pre-designed components', 'Utility classes'],
            ['Setup', 'One <code class="sba-inline">&lt;link&gt;</code>', 'npm + build step'],
            ['Custom design', 'Override + Sass', 'Native configuration'],
            ['File size', '~200 KB CSS', '10-30 KB (after purge)'],
            ['Learning curve', 'A few hours', 'A weekend'],
            ['AI compatibility', '9/10 (classes memorised)', '10/10 (any LLM nails it)'],
        ]));

    $p[] = $T::slide(3, $total, 'When To Pick Which',
        $T::cardGrid([
            ['icon' => '📦', 'title' => 'Pick Bootstrap', 'text' => 'Admin panels, internal tools, quick prototypes, or when you need mature pre-built components (modals, dropdowns, tabs).'],
            ['icon' => '🎨', 'title' => 'Pick Tailwind', 'text' => 'Custom branded sites, marketing pages, design-led teams, or when every px of the UI must be unique.', 'color' => 'sba-pink'],
        ], 2));

    $p[] = $T::slide(4, $total, 'Bootstrap In 30 Seconds',
        $T::codeBlock(
"<!-- Drop the CDN link in <head> -->
<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\">

<!-- And the JS bundle at the end of <body> -->
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/js/bootstrap.bundle.min.js\"></script>", 'html') .
        $T::paragraph('Two lines and you get a responsive grid, 25+ components, and theming via Sass.'));

    $p[] = $T::slide(5, $total, 'Bootstrap Grid — 12 Columns',
        $T::codeBlock(
"<div class=\"container\">
  <div class=\"row g-4\">
    <div class=\"col-12 col-md-6 col-lg-4\">
      <div class=\"card shadow-sm\">
        <img src=\"/p1.jpg\" class=\"card-img-top\">
        <div class=\"card-body\">
          <h5 class=\"card-title\">Product 1</h5>
          <p class=\"card-text\">A great product.</p>
          <a href=\"#\" class=\"btn btn-primary\">Buy</a>
        </div>
      </div>
    </div>
    <!-- repeat .col-* for more cards -->
  </div>
</div>", 'html'));

    $p[] = $T::slide(6, $total, 'Bootstrap Components You Will Use Daily',
        $T::table(['Component', 'Class start'], [
            ['Navbar', '<code class="sba-inline">.navbar .navbar-expand-lg</code>'],
            ['Card', '<code class="sba-inline">.card</code>'],
            ['Modal', '<code class="sba-inline">.modal .fade</code>'],
            ['Dropdown', '<code class="sba-inline">.dropdown</code>'],
            ['Tabs', '<code class="sba-inline">.nav .nav-tabs</code>'],
            ['Form floating labels', '<code class="sba-inline">.form-floating</code>'],
            ['Alerts', '<code class="sba-inline">.alert .alert-danger</code>'],
            ['Toasts', '<code class="sba-inline">.toast</code>'],
            ['Accordion', '<code class="sba-inline">.accordion</code>'],
        ]));

    $p[] = $T::slide(7, $total, 'Tailwind In 60 Seconds',
        $T::codeBlock(
"# Create a new project
npm create vite@latest my-landing -- --template vanilla
cd my-landing
npm install -D tailwindcss@4 @tailwindcss/vite
# add to vite.config
import tailwindcss from '@tailwindcss/vite'
export default { plugins: [tailwindcss()] }
# style.css
@import \"tailwindcss\";", 'bash') .
        $T::paragraph('Tailwind 4 is zero-config — no PostCSS, no tailwind.config.js required for the basics.'));

    $p[] = $T::slide(8, $total, 'Tailwind Philosophy — Utility First',
        $T::codeBlock(
"<!-- OLD: custom CSS for everything -->
<button class=\"btn-primary\">Buy</button>

/* Somewhere in CSS */
.btn-primary {
  background: #6366f1;
  color: white;
  padding: 0.75rem 1.5rem;
  border-radius: 0.5rem;
  font-weight: 600;
}

<!-- NEW: utilities inline -->
<button class=\"bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700\">
  Buy
</button>", 'html') .
        $T::callout('info', 'Objection', '"That looks like inline styles!" — It\'s not. Utilities are constrained to your design tokens and compose under media queries.'));

    $p[] = $T::slide(9, $total, 'Tailwind Responsive Modifiers',
        $T::codeBlock(
"<div class=\"
  grid
  grid-cols-1
  md:grid-cols-2
  lg:grid-cols-3
  gap-4
  p-4
  md:p-8
\">
  <!-- children -->
</div>", 'html') .
        $T::table(['Prefix', 'Breakpoint'], [
            ['sm:', '≥ 640px'],
            ['md:', '≥ 768px'],
            ['lg:', '≥ 1024px'],
            ['xl:', '≥ 1280px'],
            ['2xl:', '≥ 1536px'],
        ]));

    $p[] = $T::slide(10, $total, 'The Same Hero — Bootstrap vs Tailwind',
        $T::codeBlock(
"<!-- BOOTSTRAP -->
<section class=\"bg-dark text-white py-5\">
  <div class=\"container text-center py-5\">
    <h1 class=\"display-3 fw-bold\">Ship Faster</h1>
    <p class=\"lead mt-3\">Build with AI.</p>
    <a href=\"#\" class=\"btn btn-primary btn-lg mt-4\">Start Free</a>
  </div>
</section>

<!-- TAILWIND -->
<section class=\"bg-slate-900 text-white py-20\">
  <div class=\"max-w-6xl mx-auto text-center\">
    <h1 class=\"text-5xl md:text-7xl font-black\">Ship Faster</h1>
    <p class=\"mt-4 text-xl\">Build with AI.</p>
    <a class=\"mt-8 inline-block bg-indigo-500 px-6 py-3 rounded-lg font-bold hover:bg-indigo-600\">
      Start Free
    </a>
  </div>
</section>", 'html'));

    $p[] = $T::slide(11, $total, 'Prompting AI for Tailwind',
        $T::codeBlock(
"Generate a pricing section with three tiers in Tailwind v4.

TIERS:  Free (\$0), Pro (\$9/mo, highlighted), Team (\$29/mo)
EACH CARD:
  - Tier name, price, 5 features (checkmark icons), CTA button
HIGHLIGHT:  Scale-105, purple ring, 'POPULAR' badge
RESPONSIVE: single col on mobile, 3 cols on md+
DARK MODE:  fully supported via dark:* prefixes

Output: a self-contained <section> HTML block, nothing else.", 'prompt'));

    $p[] = $T::slide(12, $total, '@apply — When Utilities Aren\'t Enough',
        $T::codeBlock(
"/* style.css */
@import \"tailwindcss\";

@utility btn-primary {
  @apply bg-indigo-600 hover:bg-indigo-700 text-white
         px-6 py-3 rounded-lg font-semibold
         transition-colors duration-150;
}

/* HTML */
<button class=\"btn-primary\">Buy</button>", 'css') .
        $T::paragraph('Use for repeated component patterns (e.g. 20 buttons across a site).'));

    $p[] = $T::slide(13, $total, 'Tailwind Dark Mode',
        $T::codeBlock(
"<div class=\"bg-white dark:bg-slate-900 text-slate-900 dark:text-white\">
  <h1 class=\"text-2xl\">Hello</h1>
  <p class=\"text-slate-600 dark:text-slate-300\">Works everywhere.</p>
</div>", 'html') .
        $T::paragraph('Pair with <code class="sba-inline">class="dark"</code> on <code class="sba-inline">&lt;html&gt;</code> for a toggleable theme.'));

    $p[] = $T::slide(14, $total, 'Customising Tailwind (v4)',
        $T::codeBlock(
"@import \"tailwindcss\";

@theme {
  --font-display: \"Poppins\", sans-serif;
  --color-brand-50:  oklch(97% 0.02 270);
  --color-brand-500: oklch(60% 0.2 270);
  --color-brand-900: oklch(25% 0.18 270);
  --radius-lg: 0.875rem;
}", 'css') .
        $T::paragraph('Variables are instantly available as <code class="sba-inline">bg-brand-500</code>, <code class="sba-inline">rounded-lg</code>, etc.'));

    $p[] = $T::slide(15, $total, 'Bootstrap Theming',
        $T::codeBlock(
"// custom.scss
@import \"bootstrap/scss/functions\";

\$primary:   #6366f1;
\$secondary: #ec4899;
\$border-radius: 0.875rem;

@import \"bootstrap/scss/variables\";
@import \"bootstrap/scss/bootstrap\";", 'scss'));

    $p[] = $T::slide(16, $total, 'Hands-On — Build The Same Landing Page Twice',
        $T::numberedList([
            'Create <code class="sba-inline">landing-bootstrap/index.html</code> using Bootstrap CDN',
            'Create <code class="sba-inline">landing-tailwind/index.html</code> using Tailwind v4',
            'Include: navbar, hero, 3 feature cards, pricing table, FAQ, contact form, footer',
            'Compare file sizes and build times',
            'Ask AI to port the Bootstrap version to Tailwind — observe what changes',
        ]));

    $p[] = $T::slide(17, $total, 'Icon Libraries',
        $T::table(['Library', 'Size', 'Use with'], [
            ['Lucide (lucide.dev)', '~1 KB per icon', 'Any framework'],
            ['Heroicons', '~1 KB per icon', 'Tailwind Labs official'],
            ['Font Awesome', '~200 KB CDN', 'Bootstrap projects'],
            ['Phosphor Icons', '~1 KB per icon', 'Beautiful 6 weights'],
            ['Bootstrap Icons', '~1 KB per icon', 'Bootstrap ecosystem'],
        ]));

    $p[] = $T::slide(18, $total, 'Polished Component Libraries',
        $T::bulletList([
            '<b>shadcn/ui</b> — copy-paste Tailwind + React components (the industry favourite)',
            '<b>DaisyUI</b> — pre-built Tailwind themes (no React needed)',
            '<b>Flowbite</b> — Tailwind components for vanilla or React',
            '<b>Headless UI</b> — unstyled, accessible primitives from Tailwind Labs',
            '<b>Radix UI</b> — unstyled primitives (used by shadcn)',
        ]));

    $p[] = $T::slide(19, $total, 'Performance — Keep Your CSS Slim',
        $T::bulletList([
            'Tailwind v4 automatically purges unused classes',
            'Bootstrap: only import the Sass partials you use',
            'Always minify CSS in production',
            'Lazy-load non-critical fonts with <code class="sba-inline">font-display: swap</code>',
            'Lighthouse "Unused CSS" should be under 20 KB',
        ]));

    $p[] = $T::slide(20, $total, 'Key Takeaways', $T::bulletList([
        'Bootstrap = components, Tailwind = utilities — both shine',
        'AI generates utility class soups better than any human',
        'CDN Bootstrap for prototypes, npm-build for production',
        'Tailwind v4 is zero-config and blazingly fast',
        'Dark mode is one class prefix away in both',
    ]), 'sba-recap');

    $p[] = $T::slide(21, $total, 'Up Next — Lesson 8',
        $T::lead('Your page looks great, but it is not alive yet. Next: <b>JavaScript ES2024 Essentials — from variables to async/await</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_08_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(8, 24,
        'JavaScript ES2024 Essentials — From Variables to Async/Await',
        'JavaScript powers 99% of interactive web experiences. From variables and control flow all the way to promises, async/await and modules — the complete practitioner\'s guide.',
        'Module 2', '5h');

    $p[] = $T::slide(2, $total, 'What You Will Master', $T::bulletList([
        'Variables (let/const), types, and coercion rules',
        'Functions — arrows, defaults, rest/spread, higher-order',
        'Arrays & objects — destructuring, spread, map/filter/reduce',
        'DOM manipulation and event handling',
        'Fetch, Promises, and async/await',
        'ES modules and how to structure a JS codebase',
    ]));

    $p[] = $T::slide(3, $total, 'Variables — Prefer <code>const</code> by default',
        $T::codeBlock(
"const price = 99.99;             // cannot be reassigned
let  cartTotal = 0;              // will change over time
// var is legacy; do not use it in 2026

const user = { id: 1, name: 'Alice' };
user.name = 'Bob';               // OK — object contents are mutable
// user = { ... }                // ERROR — reference is const", 'javascript'));

    $p[] = $T::slide(4, $total, 'Primitives & Reference Types',
        $T::table(['Primitive', 'Reference'], [
            ['string', 'Object'],
            ['number', 'Array'],
            ['bigint', 'Function'],
            ['boolean', 'Date'],
            ['symbol', 'Map / Set'],
            ['null / undefined', '...'],
        ]) .
        $T::callout('warning', 'Gotcha',
            'Primitives are compared by <b>value</b>, objects by <b>reference</b>. <code class="sba-inline">[] === []</code> is <code class="sba-inline">false</code>!'));

    $p[] = $T::slide(5, $total, 'Template Literals',
        $T::codeBlock(
"const name = 'Alice';
const cart = 3;

// Old concat (don't)
const msg1 = 'Hi ' + name + ', you have ' + cart + ' items.';

// Template literal
const msg2 = `Hi \${name}, you have \${cart} items.`;

// Multi-line + expressions
const html = `
  <article>
    <h2>\${user.name.toUpperCase()}</h2>
    <p>Total: \$\${total.toFixed(2)}</p>
  </article>
`;", 'javascript'));

    $p[] = $T::slide(6, $total, 'Arrow Functions',
        $T::codeBlock(
"// Classic
function add(a, b) { return a + b; }

// Arrow
const add = (a, b) => a + b;

// Default params, rest args
const greet = (name = 'friend', ...more) =>
  `Hi \${name}, \${more.length} others`;

// Block body when you need multiple statements
const save = async (user) => {
  const res = await fetch('/api/save', { method: 'POST' });
  return res.json();
};", 'javascript') .
        $T::callout('info', 'Rule',
            'Use arrows everywhere except object methods and class constructors.'));

    $p[] = $T::slide(7, $total, 'Destructuring',
        $T::codeBlock(
"// Object destructuring
const { id, name, email = 'n/a' } = user;

// Array destructuring
const [first, second, ...rest] = [1, 2, 3, 4, 5];

// In function params — very common
function fetchUser({ id, include = ['posts'] }) { /* … */ }

// Renaming
const { name: fullName } = user;", 'javascript'));

    $p[] = $T::slide(8, $total, 'Spread & Rest',
        $T::codeBlock(
"// Merge arrays
const a = [1, 2];
const b = [3, 4];
const c = [...a, ...b, 5];          // [1,2,3,4,5]

// Clone an object (shallow)
const clone = { ...user, updated: Date.now() };

// Rest in function args
function sum(...nums) {
  return nums.reduce((t, n) => t + n, 0);
}
sum(1, 2, 3, 4);                    // 10", 'javascript'));

    $p[] = $T::slide(9, $total, 'Arrays — The Big Five',
        $T::codeBlock(
"const prices = [10, 20, 30, 40];

prices.map(p => p * 1.2);           // [12,24,36,48] transform
prices.filter(p => p > 15);         // [20,30,40]   keep some
prices.reduce((t, p) => t + p, 0);  // 100          summarise
prices.find(p => p > 25);           // 30           first match
prices.some(p => p > 35);           // true         any match", 'javascript') .
        $T::callout('success', 'Why prefer these', 'Declarative, immutable, and chainable — unlike <code class="sba-inline">for</code> loops.'));

    $p[] = $T::slide(10, $total, 'Objects — Useful Modern Patterns',
        $T::codeBlock(
"const user = { name: 'Alice', age: 30 };

Object.keys(user);                   // ['name','age']
Object.values(user);                 // ['Alice', 30]
Object.entries(user);                // [['name','Alice'],['age',30]]

// Iterate with for…of
for (const [key, val] of Object.entries(user)) {
  console.log(key, val);
}

// Optional chaining + nullish coalescing
const city = user?.address?.city ?? 'Unknown';

// Shorthand
const name = 'Bob';
const obj = { name };                 // { name: 'Bob' }", 'javascript'));

    $p[] = $T::slide(11, $total, 'Control Flow — Modern JS',
        $T::codeBlock(
"// Switch with explicit fall-through
switch (role) {
  case 'admin':
  case 'owner':
    dashboard();
    break;
  default:
    home();
}

// Ternary
const fee = isPremium ? 0 : 5;

// Short-circuit
user.isLoggedIn && showLogout();

// Logical assignment
options.retries ??= 3;", 'javascript'));

    $p[] = $T::slide(12, $total, 'The DOM — Selecting & Modifying Elements',
        $T::codeBlock(
"// Select
const btn   = document.querySelector('#submit-btn');
const items = document.querySelectorAll('.todo');

// Modify
btn.textContent = 'Submitting…';
btn.classList.add('loading');
btn.classList.toggle('active');
btn.setAttribute('disabled', '');

// Create & append
const li = document.createElement('li');
li.textContent = 'New item';
document.querySelector('#list').append(li);", 'javascript'));

    $p[] = $T::slide(13, $total, 'Events',
        $T::codeBlock(
"const form = document.querySelector('#login');

form.addEventListener('submit', (e) => {
  e.preventDefault();                                   // stop default
  const data = Object.fromEntries(new FormData(form));  // → plain object
  login(data);
});

// Event delegation — one listener, many children
document.querySelector('#list').addEventListener('click', (e) => {
  if (e.target.matches('.delete-btn')) {
    e.target.closest('li')?.remove();
  }
});", 'javascript'));

    $p[] = $T::slide(14, $total, 'Fetch API — Hitting A Real Server',
        $T::codeBlock(
"async function loadProducts() {
  const res = await fetch('/api/products', {
    headers: { 'Accept': 'application/json' }
  });
  if (!res.ok) throw new Error(`HTTP \${res.status}`);
  return res.json();
}

async function createOrder(payload) {
  const res = await fetch('/api/orders', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify(payload),
  });
  return res.json();
}", 'javascript'));

    $p[] = $T::slide(15, $total, 'Promises vs Async/Await',
        $T::codeBlock(
"// Promise chain
fetch('/api/me')
  .then(r => r.json())
  .then(data => render(data))
  .catch(err => toast(err.message));

// Same code with async/await
try {
  const res  = await fetch('/api/me');
  const data = await res.json();
  render(data);
} catch (err) {
  toast(err.message);
}", 'javascript') .
        $T::callout('info', 'Choose async/await',
            'It reads top-to-bottom like synchronous code — much easier to follow.'));

    $p[] = $T::slide(16, $total, 'Error Handling That Survives Production',
        $T::codeBlock(
"class HttpError extends Error {
  constructor(status, message) {
    super(message);
    this.status = status;
  }
}

async function json(url) {
  const res = await fetch(url);
  if (!res.ok) throw new HttpError(res.status, res.statusText);
  return res.json();
}

try {
  const user = await json('/api/me');
} catch (e) {
  if (e instanceof HttpError && e.status === 401) logout();
  else reportToSentry(e);
}", 'javascript'));

    $p[] = $T::slide(17, $total, 'ES Modules — Structuring Code',
        $T::codeBlock(
"// math.js
export const add = (a, b) => a + b;
export const PI  = 3.14159;
export default function multiply(a, b) { return a * b; }

// app.js
import multiply, { add, PI } from './math.js';
import * as math from './math.js';

console.log(add(2, 3), math.PI);

<!-- index.html -->
<script type=\"module\" src=\"app.js\"></script>", 'javascript'));

    $p[] = $T::slide(18, $total, 'Debugging JS Like A Pro',
        $T::bulletList([
            '<code class="sba-inline">console.log</code> is fine, but prefer <code class="sba-inline">console.table</code> for arrays of objects',
            'Set a breakpoint in the Sources tab — pause execution, inspect variables',
            '<code class="sba-inline">debugger;</code> keyword pauses when DevTools is open',
            '<code class="sba-inline">$_</code> in the Console is the last expression\'s value',
            'Use <code class="sba-inline">copy(obj)</code> in the console to copy JSON to clipboard',
        ]));

    $p[] = $T::slide(19, $total, 'Hands-On — Build A To-Do App (No Framework)',
        $T::numberedList([
            'Create <code class="sba-inline">index.html</code> with a form and a <code class="sba-inline">&lt;ul&gt;</code>',
            'On submit: add a new <code class="sba-inline">&lt;li&gt;</code> with a Delete button',
            'Persist the list in <code class="sba-inline">localStorage</code>',
            'Filter by "All / Active / Done" buttons',
            'Bonus: export as JSON, import from JSON',
        ]) .
        $T::callout('info', 'AI prompt', 'Ask Cursor: "Generate a vanilla JS todo app with localStorage persistence, ES modules, and accessible HTML."'));

    $p[] = $T::slide(20, $total, 'Common JavaScript Gotchas',
        $T::bulletList([
            '<code class="sba-inline">typeof null === "object"</code> (historical bug)',
            '<code class="sba-inline">0.1 + 0.2 !== 0.3</code> — use cents or BigInt for money',
            '<code class="sba-inline">[] == false</code> is <code class="sba-inline">true</code>; always use <code class="sba-inline">===</code>',
            '<code class="sba-inline">this</code> in arrow functions = enclosing scope, not the caller',
            '<code class="sba-inline">Array(3)</code> creates an empty sparse array of length 3',
        ]));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        '<code class="sba-inline">const</code> by default, <code class="sba-inline">let</code> when you must, never <code class="sba-inline">var</code>',
        'Arrow functions, destructuring, spread — muscle memory',
        'Array methods beat for-loops for readability',
        'async/await beats then-chains; always catch errors',
        'Use ES modules to split code into files',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 9',
        $T::lead('JavaScript without types gets messy in big apps. Next: <b>TypeScript & Modern React 19 with Hooks and Context</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}
