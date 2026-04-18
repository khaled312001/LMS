<?php
require_once __DIR__ . '/slide_template.php';

/**
 * Lessons 21-24 — SEO, Security, Hostinger Deployment, Launch.
 */

function lesson_21_content(): string {
    $T = 'SlideTemplate'; $total = 21;
    $p = [];
    $p[] = $T::cover(21, 24,
        'SEO, Analytics & Core Web Vitals with AI Optimization',
        'A beautiful site that nobody finds is a failed project. This lesson covers technical SEO, on-page SEO, Core Web Vitals, and the AI tools that automate 80% of the work.',
        'Module 6', '3h 30m');

    $p[] = $T::slide(2, $total, 'SEO In 2026', $T::bulletList([
        'Google AI Overviews now handle 40%+ of searches',
        'Quality + E-E-A-T (Experience, Expertise, Authoritativeness, Trust) matter more than ever',
        'Core Web Vitals are direct ranking signals',
        'LLM crawlers (GPTBot, ClaudeBot, Perplexity) read your content too',
        'Structured data (schema.org) drives rich results',
    ]));

    $p[] = $T::slide(3, $total, 'On-Page SEO Checklist',
        $T::bulletList([
            'Unique <code class="sba-inline">&lt;title&gt;</code> (50-60 chars)',
            'Unique <code class="sba-inline">meta description</code> (120-160 chars)',
            'Single <code class="sba-inline">&lt;h1&gt;</code> that matches user intent',
            '<code class="sba-inline">alt</code> text on every image',
            'Fast-loading pages (CWV green)',
            'Clean URL slugs: <code class="sba-inline">/products/swiss-classic-chrono</code>',
            'Internal links to related content',
            '<code class="sba-inline">&lt;link rel="canonical"&gt;</code> set',
        ]));

    $p[] = $T::slide(4, $total, 'Structured Data (Schema.org)',
        $T::codeBlock(
"<script type=\"application/ld+json\">
{
  \"@context\": \"https://schema.org\",
  \"@type\": \"Product\",
  \"name\": \"Swiss Classic Chrono\",
  \"image\": [\"https://…/front.jpg\", \"https://…/back.jpg\"],
  \"description\": \"Automatic chronograph with sapphire crystal…\",
  \"sku\": \"SCC-42\",
  \"brand\": { \"@type\": \"Brand\", \"name\": \"SwissShop\" },
  \"offers\": {
    \"@type\": \"Offer\",
    \"url\": \"https://swissshop.com/products/scc-42\",
    \"priceCurrency\": \"CHF\",
    \"price\": \"1299.00\",
    \"availability\": \"https://schema.org/InStock\"
  },
  \"aggregateRating\": { \"@type\": \"AggregateRating\", \"ratingValue\": \"4.8\", \"reviewCount\": \"36\" }
}
</script>", 'html'));

    $p[] = $T::slide(5, $total, 'Core Web Vitals',
        $T::table(['Metric', 'What it measures', 'Good'], [
            ['LCP', 'Time to largest paint', '< 2.5s'],
            ['INP', 'Interaction responsiveness', '< 200ms'],
            ['CLS', 'Visual stability (layout shift)', '< 0.1'],
        ]) .
        $T::callout('info', 'Why you care',
            'Google ranks slow pages lower. A fast site = more organic traffic + higher conversion.'));

    $p[] = $T::slide(6, $total, 'Measure With Lighthouse',
        $T::numberedList([
            'Open Chrome DevTools → Lighthouse tab',
            'Tick "Performance, Accessibility, Best Practices, SEO"',
            'Mode: Navigation, Device: Mobile',
            'Generate report — aim ≥ 90 in every category',
            'Export JSON and run PageSpeed Insights on your live URL',
        ]));

    $p[] = $T::slide(7, $total, 'Speeding Up Images',
        $T::bulletList([
            'Use <code class="sba-inline">&lt;img width&gt; and height</code> to prevent CLS',
            'WebP or AVIF (30-70% smaller than JPEG)',
            'Responsive <code class="sba-inline">srcset</code> + <code class="sba-inline">sizes</code>',
            '<code class="sba-inline">loading="lazy"</code> for below-the-fold',
            'CDN — Cloudflare Polish, Bunny Optimiser',
        ]));

    $p[] = $T::slide(8, $total, 'JavaScript Performance',
        $T::bulletList([
            'Code-split by route — React.lazy + Suspense / Next dynamic imports',
            'Remove unused JS libraries (audit bundle with <code class="sba-inline">vite-bundle-visualizer</code>)',
            'Defer non-critical scripts with <code class="sba-inline">async/defer</code>',
            'Prefer Edge runtime / streaming where possible',
            'Avoid heavy framework updates on every keystroke — use <code class="sba-inline">useDeferredValue</code>',
        ]));

    $p[] = $T::slide(9, $total, 'Sitemap & robots.txt',
        $T::codeBlock(
"# robots.txt
User-agent: *
Allow: /
Disallow: /admin
Disallow: /cart
Disallow: /checkout
Sitemap: https://swissshop.com/sitemap.xml

# sitemap.xml (one per section)
<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
  <url>
    <loc>https://swissshop.com/products/scc-42</loc>
    <lastmod>2026-04-18</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
  </url>
</urlset>", 'xml'));

    $p[] = $T::slide(10, $total, 'Analytics — What To Track',
        $T::bulletList([
            '<b>Acquisition</b>: source/medium (organic, paid, direct)',
            '<b>Engagement</b>: time on page, scroll depth, clicks',
            '<b>Conversion</b>: add-to-cart, begin-checkout, purchase',
            '<b>Revenue</b>: value, AOV, LTV',
            '<b>Attribution</b>: first-click vs last-click',
        ]));

    $p[] = $T::slide(11, $total, 'Setting Up GA4 With GDPR Consent',
        $T::codeBlock(
"// Use Google Tag Manager for easier switching
<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-XXXX\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('consent', 'default', {
    'ad_storage':         'denied',
    'analytics_storage':  'denied'
  });
  gtag('js', new Date());
  gtag('config', 'G-XXXX');
</script>
<!-- Call gtag('consent', 'update', {...}) after banner accept -->", 'html'));

    $p[] = $T::slide(12, $total, 'E-commerce Tracking Events',
        $T::codeBlock(
"// Fire on add to cart
gtag('event', 'add_to_cart', {
  currency: 'CHF',
  value: 1299,
  items: [{ item_id: 'SCC-42', item_name: 'Swiss Classic Chrono', price: 1299, quantity: 1 }]
});

// Fire on purchase
gtag('event', 'purchase', {
  transaction_id: 'ORD-4821',
  currency: 'CHF',
  value: 1299,
  tax: 95.38,
  shipping: 0,
  items: [ /* ... */ ]
});", 'javascript'));

    $p[] = $T::slide(13, $total, 'Search Console',
        $T::numberedList([
            'Add and verify your site at <code class="sba-inline">search.google.com/search-console</code>',
            'Submit your sitemap',
            'Monitor Coverage → fix any errors',
            'Core Web Vitals report → fix URLs flagged poor',
            'Performance → which queries bring you traffic',
        ]));

    $p[] = $T::slide(14, $total, 'Content SEO With AI',
        $T::codeBlock(
"Prompt:
You are an SEO content strategist.
My niche: luxury Swiss watches for men aged 35-55.
List 20 long-tail SEO keywords with search intent
(informational / commercial / transactional) and
difficulty (low/med/high). Also suggest 10 blog titles
that would rank for at least two of these keywords each.
Output as a markdown table.", 'prompt'));

    $p[] = $T::slide(15, $total, 'Writing For LLMs (Answer Engine Optimisation)',
        $T::bulletList([
            'Use clear H2/H3 hierarchy — LLMs parse structure',
            'Put direct answers in the first paragraph',
            'Add summary / TL;DR sections',
            'Use lists, tables, and bolded key phrases',
            'Cite authoritative sources and link out — improves trust',
        ]));

    $p[] = $T::slide(16, $total, 'Internal Linking Strategy',
        $T::bulletList([
            'Every new post links to ≥ 3 older, related posts',
            'Pillar + cluster model: one long guide + 5-10 deep-dive articles',
            'Link from high-traffic pages to conversion pages',
            'Use descriptive anchor text — "best Swiss watches", not "click here"',
        ]));

    $p[] = $T::slide(17, $total, 'Backlinks (Off-Page SEO)',
        $T::bulletList([
            'Guest posts on industry blogs',
            'Digital PR — data-driven studies journalists quote',
            'Podcast appearances with show-notes links',
            'Partnerships & co-marketing',
            'Never buy links — Google penalises',
        ]));

    $p[] = $T::slide(18, $total, 'Monitoring & Alerts',
        $T::bulletList([
            'UptimeRobot / Better Stack — alert when site is down',
            'Search Console — weekly performance email',
            'GA4 intelligence alerts on anomalies',
            'Cron job that checks the homepage daily for regressions',
        ]));

    $p[] = $T::slide(19, $total, 'Automating SEO With AI',
        $T::numberedList([
            'Crawl your site with Screaming Frog or Sitebulb',
            'Export the URL list',
            'Ask Claude to audit titles, meta descriptions, H1s',
            'Produce a CSV with recommended changes',
            'Update in bulk via WP-CLI or a Laravel artisan command',
        ]));

    $p[] = $T::slide(20, $total, 'Key Takeaways', $T::bulletList([
        'Core Web Vitals + structured data = baseline for ranking',
        'Write for humans first, machines second',
        'AI accelerates keyword research, content drafts, audits',
        'Measure — GA4, Search Console, Lighthouse, real-user monitoring',
        'Internal links + backlinks + authority > keyword stuffing',
    ]), 'sba-recap');

    $p[] = $T::slide(21, $total, 'Up Next — Lesson 22',
        $T::lead('You can be found. Now we make sure you can\'t be hacked: <b>Web Security — OWASP Top 10</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_22_content(): string {
    $T = 'SlideTemplate'; $total = 21;
    $p = [];
    $p[] = $T::cover(22, 24,
        'Web Security — OWASP Top 10, HTTPS, and AI Code Review',
        'Every site gets attacked. Learn to defend against the ten most common web vulnerabilities, enable proper HTTPS and HSTS, and use AI as a second pair of eyes on every change.',
        'Module 6', '3h 30m');

    $p[] = $T::slide(2, $total, 'The OWASP Top 10 (2025 edition)',
        $T::numberedList([
            'Broken Access Control',
            'Cryptographic Failures',
            'Injection (SQL, NoSQL, LDAP, OS)',
            'Insecure Design',
            'Security Misconfiguration',
            'Vulnerable and Outdated Components',
            'Identification and Authentication Failures',
            'Software and Data Integrity Failures',
            'Security Logging and Monitoring Failures',
            'Server-Side Request Forgery (SSRF)',
        ]));

    $p[] = $T::slide(3, $total, 'Broken Access Control',
        $T::codeBlock(
"// BAD: any user can delete any order
Route::delete('/orders/{id}', fn(\$id) => Order::destroy(\$id));

// GOOD: only the owner or admin
Route::delete('/orders/{order}', function (Order \$order) {
    Gate::authorize('delete', \$order);
    \$order->delete();
});", 'php') .
        $T::callout('danger', 'Test this',
            'Log in as User A, try to fetch User B\'s resources. If you succeed, you have a bug.'));

    $p[] = $T::slide(4, $total, 'SQL Injection',
        $T::codeBlock(
"// BAD
\$name = \$_GET['name'];
DB::select(\"SELECT * FROM users WHERE name = '\$name'\");

// GOOD (Laravel, auto-prepared)
DB::select('SELECT * FROM users WHERE name = ?', [\$name]);

// GOOD (Eloquent)
User::where('name', \$name)->first();

// GOOD (Node mongo — don't concat queries)
User.find({ name: { \$eq: req.body.name } });", 'php'));

    $p[] = $T::slide(5, $total, 'XSS (Cross-Site Scripting)',
        $T::codeBlock(
"// BAD — raw user HTML
<p>{!! \$post->body !!}</p>

// GOOD — escaped
<p>{{ \$post->body }}</p>

// In React, auto-escaped by default:
<p>{post.body}</p>

// Allow only specific HTML (use HTMLPurifier)
<p>{{ Purifier::clean(\$post->body) }}</p>", 'php'));

    $p[] = $T::slide(6, $total, 'CSRF',
        $T::codeBlock(
"<!-- Blade -->
<form method=\"POST\" action=\"/account/delete\">
  @csrf
  @method('DELETE')
  <button>Delete account</button>
</form>

<!-- Express (cookie-based SPA) -->
app.get('/csrf', csurf(), (req, res) => res.json({ token: req.csrfToken() }));
// Frontend includes 'csrf-token' header on mutating requests.", 'php'));

    $p[] = $T::slide(7, $total, 'Secure Cookies',
        $T::codeBlock(
"res.cookie('session', value, {
  httpOnly: true,      // JS can't read it → blocks XSS theft
  secure:   true,      // only sent over HTTPS
  sameSite: 'strict',  // never sent on cross-site requests
  maxAge:   30 * 24 * 60 * 60 * 1000,
  path:     '/',
});", 'javascript'));

    $p[] = $T::slide(8, $total, 'HTTPS & HSTS',
        $T::bulletList([
            'Always use HTTPS — Let\'s Encrypt is free',
            'Enable HSTS once confident: <code class="sba-inline">Strict-Transport-Security: max-age=31536000; includeSubDomains; preload</code>',
            'Submit to <code class="sba-inline">hstspreload.org</code>',
            'Redirect all <code class="sba-inline">http://</code> to <code class="sba-inline">https://</code>',
            'Use TLS 1.2+ only (disable TLS 1.0/1.1)',
        ]));

    $p[] = $T::slide(9, $total, 'Content Security Policy',
        $T::codeBlock(
"Content-Security-Policy:
  default-src 'self';
  script-src  'self' https://js.stripe.com;
  img-src     'self' data: https:;
  connect-src 'self' https://api.stripe.com;
  style-src   'self' 'unsafe-inline';
  frame-ancestors 'none';
  base-uri    'self';
  form-action 'self';
  object-src  'none';", 'http'));

    $p[] = $T::slide(10, $total, 'Password Security',
        $T::bulletList([
            'Minimum length 12, no complexity rules (NIST 800-63)',
            'Block 1 million most-leaked passwords (<code class="sba-inline">haveibeenpwned.com</code>)',
            'Argon2id or bcrypt 12+',
            'Never log or email passwords',
            'Encourage / require 2FA for high-value accounts',
        ]));

    $p[] = $T::slide(11, $total, 'Secrets Management',
        $T::bulletList([
            'Never commit <code class="sba-inline">.env</code>, API keys, private certificates',
            'Rotate secrets quarterly and after any staff departure',
            'Use a manager: <b>Doppler</b>, <b>1Password CLI</b>, <b>AWS Secrets Manager</b>, <b>HashiCorp Vault</b>',
            'Audit git history with <code class="sba-inline">trufflehog</code> / <code class="sba-inline">gitleaks</code>',
        ]));

    $p[] = $T::slide(12, $total, 'Dependency Hygiene',
        $T::codeBlock(
"# Node
npm audit
npm audit fix
npx npm-check-updates -u

# PHP
composer audit
composer outdated --direct

# GitHub
Dependabot → automatic PRs for security updates
Snyk / Socket — deeper scans", 'bash'));

    $p[] = $T::slide(13, $total, 'SSRF Prevention',
        $T::codeBlock(
"// BAD — fetches whatever the user provides
const r = await fetch(req.body.url);

// GOOD — allow only whitelisted domains
const ALLOWED = ['images.unsplash.com', 'cdn.shopify.com'];
const u = new URL(req.body.url);
if (!ALLOWED.includes(u.hostname)) throw new HttpError(400, 'bad url');

// Also block localhost / private IP ranges before fetching", 'typescript'));

    $p[] = $T::slide(14, $total, 'Rate Limiting & DDoS',
        $T::bulletList([
            'Cloudflare in front of every site — free tier stops 99% of DDoS',
            'Per-endpoint rate-limits (Express, Laravel throttle)',
            'CAPTCHA on sensitive endpoints (login, sign-up, contact)',
            '<code class="sba-inline">fail2ban</code> on SSH',
        ]));

    $p[] = $T::slide(15, $total, 'Logging & Monitoring',
        $T::bulletList([
            'Centralise logs — Logtail, Papertrail, Datadog',
            'Sentry for error tracking',
            'Alert on 5xx spikes, failed logins, DB errors',
            'Keep logs ≥ 90 days for forensic analysis',
            'Never log PII, passwords, full credit cards',
        ]));

    $p[] = $T::slide(16, $total, 'AI Code Review Prompt',
        $T::codeBlock(
"You are a principal security engineer.
Review the following <pr-diff>. For each hunk:
 - Quote the line
 - Label the issue (A01-A10 from OWASP 2025)
 - Suggest the exact fix
Ignore lint / cosmetic issues. Be strict.
If clean, reply 'LGTM — no security issues found'.", 'prompt'));

    $p[] = $T::slide(17, $total, 'Pen-Testing Basics',
        $T::bulletList([
            'Use <b>Burp Suite Community</b> to intercept requests',
            'Try <b>OWASP ZAP</b> automated scan on staging',
            'Check mobile apps with <b>mitmproxy</b>',
            'Never scan sites you do not own',
            'Maintain a <code class="sba-inline">security.txt</code> file for disclosures',
        ]));

    $p[] = $T::slide(18, $total, 'Incident Response',
        $T::numberedList([
            'Contain — rotate keys, revoke tokens, block the attacker IP',
            'Assess — what data did they reach?',
            'Notify — customers, authorities (GDPR 72h rule)',
            'Fix root cause',
            'Postmortem — blameless, actionable, published internally',
        ]));

    $p[] = $T::slide(19, $total, 'Security Headers Cheatsheet',
        $T::table(['Header', 'Value'], [
            ['Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload'],
            ['X-Content-Type-Options', 'nosniff'],
            ['X-Frame-Options', 'DENY or SAMEORIGIN'],
            ['Referrer-Policy', 'strict-origin-when-cross-origin'],
            ['Permissions-Policy', 'geolocation=(), microphone=(), camera=()'],
            ['Cross-Origin-Opener-Policy', 'same-origin'],
        ]));

    $p[] = $T::slide(20, $total, 'Key Takeaways', $T::bulletList([
        'Every input is hostile — validate and escape',
        'Auth + authorisation are separate — always check both',
        'HTTPS, HSTS, CSP, and secure cookies are non-negotiable',
        'Use AI to double-check every PR for OWASP issues',
        'Have an incident-response plan <b>before</b> you need it',
    ]), 'sba-recap');

    $p[] = $T::slide(21, $total, 'Up Next — Lesson 23',
        $T::lead('Time to go live! Next: <b>Deploying to Hostinger — domains, MySQL, SSL &amp; email</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_23_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(23, 24,
        'Deploying to Hostinger — Domains, MySQL, SSL & Email',
        'Everything you\'ve built lives on localhost. Now we push the Laravel store, the MERN API, and the WordPress site to a live Hostinger account with a real domain, free SSL, and transactional email.',
        'Module 6', '4h');

    $p[] = $T::slide(2, $total, 'Why Hostinger', $T::bulletList([
        '\$1.99-\$10/mo — unbeatable price for shared hosting',
        'Built-in MySQL, phpMyAdmin, free SSL',
        'Node.js VPS plans start at \$5',
        'cPanel-like <b>hPanel</b> — clean, localised, beginner-friendly',
        '24/7 chat support and free domain on yearly plans',
    ]));

    $p[] = $T::slide(3, $total, 'Account Setup',
        $T::numberedList([
            'Sign up at <code class="sba-inline">hostinger.com</code>',
            'Buy a "Premium Web Hosting" plan (+ free domain)',
            'Pick the data-centre closest to your users',
            'Set the admin email you actually read',
            'Enable 2FA on your account immediately',
        ]));

    $p[] = $T::slide(4, $total, 'Domain & DNS',
        $T::numberedList([
            'Domains → Claim free domain (or buy separately)',
            'Point DNS A record to your hosting IP (done by default for free domains)',
            'Add www CNAME → your apex',
            'Wait 15-60 minutes for propagation (<code class="sba-inline">dig</code> or <code class="sba-inline">whatsmydns.net</code>)',
        ]));

    $p[] = $T::slide(5, $total, 'Free SSL',
        $T::bulletList([
            'hPanel → SSL → Let\'s Encrypt → Install',
            'Force HTTPS option → Enable',
            'Auto-renewal happens; verify monthly the first time',
            'Also enable HSTS header (see lesson 22)',
        ]));

    $p[] = $T::slide(6, $total, 'Deploying The Laravel Store',
        $T::numberedList([
            'Push your Laravel repo to GitHub',
            'hPanel → Git Integration → Create Repo → connect GitHub → choose branch',
            'Auto-pull on every push (webhook)',
            'SSH in via the in-browser Terminal: <code class="sba-inline">cd ~/domains/yourdomain/public_html</code>',
            '<code class="sba-inline">composer install --no-dev --optimize-autoloader</code>',
            '<code class="sba-inline">php artisan migrate --force</code>',
            '<code class="sba-inline">php artisan storage:link</code>',
        ]));

    $p[] = $T::slide(7, $total, '.htaccess & public Directory',
        $T::codeBlock(
"# Simplest: set \"Document Root\" to public/ in hPanel

# Alternative — root .htaccess that rewrites to /public
RewriteEngine On
RewriteRule ^(.*)\$ public/\$1 [L]

# File in /public/.htaccess (ships with Laravel)
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)/\$ /\$1 [L,R=301]
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>", 'apache'));

    $p[] = $T::slide(8, $total, 'Creating The MySQL Database',
        $T::numberedList([
            'hPanel → Databases → MySQL Databases',
            'Create database <code class="sba-inline">yourname_shop</code>',
            'Create user <code class="sba-inline">yourname_app</code> with strong password',
            'Assign user → grant ALL privileges on the new DB',
            'Copy host/user/pw into Laravel <code class="sba-inline">.env</code>',
        ]) .
        $T::codeBlock(
"DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u492425110_shop
DB_USERNAME=u492425110_app
DB_PASSWORD=strong-secret", 'ini'));

    $p[] = $T::slide(9, $total, 'Laravel Production Config',
        $T::codeBlock(
"# .env on Hostinger
APP_ENV=production
APP_DEBUG=false
APP_URL=https://swissshop.com

LOG_LEVEL=warning
QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_DRIVER=file
MAIL_MAILER=smtp

# Run once
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache", 'ini') .
        $T::callout('danger', 'Never', 'Never deploy with <code class="sba-inline">APP_DEBUG=true</code> — it leaks stack traces.'));

    $p[] = $T::slide(10, $total, 'Queues & Cron',
        $T::codeBlock(
"# hPanel → Advanced → Cron Jobs → Add
# Laravel scheduler (runs every minute)
* * * * * cd ~/domains/swissshop.com/public_html \\
    && php artisan schedule:run >> /dev/null 2>&1

# Queue worker (supervisor not always available; use a kick-cron)
*/5 * * * * cd ~/domains/swissshop.com/public_html \\
    && php artisan queue:work --stop-when-empty --tries=3 \\
    >> storage/logs/queue.log 2>&1", 'bash'));

    $p[] = $T::slide(11, $total, 'Deploying The MERN App',
        $T::paragraph('Shared hosting does not run Node easily; use a Hostinger VPS or Cloud Startup plan for Node. Otherwise deploy the API to Render / Fly.io and the web to Vercel — both free tiers.') .
        $T::codeBlock(
"# On the Hostinger VPS (Ubuntu)
sudo apt update && sudo apt install -y nginx nodejs npm git
git clone git@github.com:you/mern-shop.git
cd mern-shop/apps/api && npm ci && npm run build
pm2 start dist/server.js --name shop-api
pm2 save

# Nginx reverse proxy /api → 3000
sudo nano /etc/nginx/sites-available/api.swissshop.com
# (paste proxy_pass config)
sudo ln -s /etc/nginx/sites-available/api.swissshop.com /etc/nginx/sites-enabled/
sudo certbot --nginx -d api.swissshop.com
sudo systemctl reload nginx", 'bash'));

    $p[] = $T::slide(12, $total, 'Deploying WordPress on Hostinger',
        $T::numberedList([
            'hPanel → Auto-Installer → WordPress → one-click install',
            'Point it to your domain/subfolder',
            'Set strong admin password; enable 2FA plugin immediately',
            'Install LiteSpeed Cache and WooCommerce',
            'Import the site (Duplicator / All-in-One WP Migration)',
        ]));

    $p[] = $T::slide(13, $total, 'WordPress wp-config Hardening',
        $T::codeBlock(
"// wp-config.php production settings
define('WP_DEBUG', false);
define('DISALLOW_FILE_EDIT', true);
define('FORCE_SSL_ADMIN', true);
define('AUTOMATIC_UPDATER_DISABLED', false);
define('WP_AUTO_UPDATE_CORE', 'minor');
define('WP_POST_REVISIONS', 5);
\$table_prefix = 'sba_';      // non-default prefix
// Rotate AUTH_KEY, SECURE_AUTH_KEY, etc via api.wordpress.org/secret-key/1.1/salt/", 'php'));

    $p[] = $T::slide(14, $total, 'Transactional Email (Hostinger)',
        $T::numberedList([
            'hPanel → Emails → Create mailbox <code class="sba-inline">info@yourdomain.com</code>',
            'Copy SMTP host: <code class="sba-inline">smtp.hostinger.com</code>, port 465, SSL',
            'Use in Laravel .env / WordPress WP Mail SMTP plugin',
            'Add SPF, DKIM, DMARC DNS records (hPanel has a wizard)',
            'Test deliverability with <code class="sba-inline">mail-tester.com</code> — aim 10/10',
        ]));

    $p[] = $T::slide(15, $total, 'DNS Records You Need',
        $T::table(['Record', 'Example'], [
            ['A', '<code class="sba-inline">@ → 84.2xx.xxx.xxx</code>'],
            ['CNAME', '<code class="sba-inline">www → yourdomain.com</code>'],
            ['MX', '<code class="sba-inline">@ → mail.yourdomain.com (priority 10)</code>'],
            ['TXT (SPF)', '<code class="sba-inline">v=spf1 include:_spf.hostinger.com ~all</code>'],
            ['TXT (DKIM)', '<code class="sba-inline">hostingermail._domainkey → v=DKIM1; k=rsa; p=…</code>'],
            ['TXT (DMARC)', '<code class="sba-inline">_dmarc → v=DMARC1; p=quarantine; rua=mailto:dmarc@yourdomain</code>'],
        ]));

    $p[] = $T::slide(16, $total, 'Backup Strategy',
        $T::bulletList([
            'hPanel → Daily backups (Premium plan) — 7-day retention',
            'Offsite copy once a week — rsync + cron to a DigitalOcean Space / Backblaze',
            'Snapshot before every deploy',
            'Document restore procedure; test quarterly',
        ]));

    $p[] = $T::slide(17, $total, 'Zero-Downtime Deploys',
        $T::codeBlock(
"# Blue-green on Hostinger (simple version)
current/           → symlink to releases/2026-04-18
releases/
  2026-04-18/     # previous
  2026-04-19/     # new

# Pull new, install, then flip the symlink
ln -sfn /home/…/releases/2026-04-19 /home/…/current
php artisan config:cache                # warm caches", 'bash'));

    $p[] = $T::slide(18, $total, 'SSL Certificate Rotation',
        $T::bulletList([
            'Let\'s Encrypt auto-renews every 90 days',
            'Check status monthly via hPanel SSL page',
            'If using Cloudflare, <b>Full (Strict)</b> mode + origin cert + LE at Hostinger',
            'Enable OCSP stapling for faster handshakes',
        ]));

    $p[] = $T::slide(19, $total, 'Post-Deploy Smoke Tests',
        $T::numberedList([
            'Visit homepage over HTTPS',
            'Create a test order with a Stripe test card',
            'Receive order-confirmation email',
            'Open the admin panel and log in',
            'Run Lighthouse — performance > 90, accessibility > 90',
            'Run SSL Labs test — grade A or higher',
        ]));

    $p[] = $T::slide(20, $total, 'Troubleshooting Checklist',
        $T::table(['Symptom', 'Common cause'], [
            ['500 error', '.env missing APP_KEY, permissions on storage/bootstrap'],
            ['CSS missing', 'Forgot to <code class="sba-inline">npm run build</code> or wrong APP_URL'],
            ['DB connection refused', 'Host <code class="sba-inline">localhost</code> vs <code class="sba-inline">mysql.yourhost</code>'],
            ['Emails not arriving', 'SPF/DKIM missing — check DNS'],
            ['WordPress redirect loop', 'Scheme mismatch — set siteurl to <code class="sba-inline">https://</code>'],
        ]));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Hostinger hPanel makes shared hosting a breeze',
        'Laravel via Git + composer on shared hosting works great',
        'MERN needs a VPS or external platform',
        'Free Let\'s Encrypt SSL + auto-renew',
        'SPF + DKIM + DMARC for reliable email',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 24',
        $T::lead('You are live! Final lesson: <b>Launch, maintenance, backups &amp; your AI-powered developer roadmap</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_24_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(24, 24,
        'Launch, Maintenance, Backups & The AI-Powered Developer Roadmap',
        'The final lesson. Ship your launch, set up the systems that keep your site healthy for years, and plot your next steps as an AI-powered full-stack engineer.',
        'Module 6', '4h 30m');

    $p[] = $T::slide(2, $total, 'The Launch Checklist',
        $T::numberedList([
            'Domain, SSL, HSTS working',
            'All forms work (tested end-to-end)',
            'Emails arrive and pass mail-tester.com',
            'Stripe is switched to live mode',
            'GA4 + Search Console verified',
            'Sitemap submitted',
            'Legal: Privacy, Terms, Refund, Imprint (GDPR/CCPA)',
            'Cookie consent banner',
            '404 + 500 custom pages',
            'Backups automated and tested',
        ]));

    $p[] = $T::slide(3, $total, 'Marketing Launch Plan',
        $T::bulletList([
            'Soft launch to 20 friends/customers — gather feedback',
            'Warm email list with launch discount',
            'Social announcement (LinkedIn, Twitter, Instagram)',
            'ProductHunt / BetaList (for SaaS)',
            'First blog post + backlinks from partner sites',
            'Paid ads on day 7 after organic runs',
        ]));

    $p[] = $T::slide(4, $total, 'Day-2 Operations',
        $T::bulletList([
            'Check logs every morning for 5xx spikes',
            'Triage customer support within 24h',
            'Patch security updates within 48h of release',
            'Monthly backup restore drill',
            'Quarterly load test with k6 or Artillery',
        ]));

    $p[] = $T::slide(5, $total, 'The Four Rituals Of Healthy Codebases',
        $T::cardGrid([
            ['icon' => '🧪', 'title' => 'Run tests on every PR', 'text' => 'CI blocks merges if tests fail'],
            ['icon' => '🤖', 'title' => 'AI review every PR', 'text' => 'Claude / Copilot PR review adds a second pair of eyes', 'color' => 'sba-pink'],
            ['icon' => '🗓️', 'title' => 'Monthly dependency update', 'text' => 'Dependabot PRs bundled + merged', 'color' => 'sba-cyan'],
            ['icon' => '📈', 'title' => 'Quarterly architecture review', 'text' => 'Diagram the system, identify debt, plan refactors', 'color' => 'sba-green'],
        ], 2));

    $p[] = $T::slide(6, $total, 'Backup Strategy (3-2-1 Rule)',
        $T::bulletList([
            '<b>3</b> copies of your data',
            '<b>2</b> different media (disk + cloud)',
            '<b>1</b> off-site copy',
            'Daily DB dump (mysqldump / mongodump) → encrypted → uploaded to Backblaze',
            'Monthly restore test — don\'t trust backups you haven\'t restored',
        ]));

    $p[] = $T::slide(7, $total, 'Automated Backup Script',
        $T::codeBlock(
"#!/bin/bash
set -euo pipefail
DATE=\$(date +%Y-%m-%d)
TMP=/tmp/shop-\$DATE.sql.gz
mysqldump -u app -p\"\$DB_PW\" shop | gzip > \$TMP
# Upload to Backblaze B2
b2 upload-file --noProgress shop-backups \$TMP db/\$DATE.sql.gz
rm \$TMP
# Keep last 30 days
b2 ls shop-backups db/ | head -n -30 | awk '{print \$7}' | xargs -I{} b2 delete-file-version {}", 'bash'));

    $p[] = $T::slide(8, $total, 'Handling An Outage',
        $T::numberedList([
            'Post to status page: "Investigating"',
            'Check error tracker (Sentry) and server logs',
            'Roll back to last green release (if recent deploy)',
            'Mitigate (scale up, cache, rate-limit, disable feature flag)',
            'Communicate resolution',
            'Write a postmortem within 48h',
        ]));

    $p[] = $T::slide(9, $total, 'Growing The Product',
        $T::bulletList([
            'Talk to 5 customers per week',
            'Feature-flag new features so you can A/B test',
            'Measure adoption, retention, NPS',
            'Kill features nobody uses',
            'Ship small, ship often, ship safely',
        ]));

    $p[] = $T::slide(10, $total, 'Your AI-Powered Stack For 2026',
        $T::table(['Role', 'Tool'], [
            ['Editor', 'Cursor AI'],
            ['Reviewer', 'Claude Opus (code review prompts)'],
            ['Autocomplete', 'GitHub Copilot'],
            ['Research', 'ChatGPT / Perplexity'],
            ['Docs', 'Notion AI / Mintlify'],
            ['Design', 'v0.dev / Uizard / Figma AI'],
            ['Testing', 'Cursor + Vitest / PHPUnit'],
            ['Analytics', 'GA4 + Fathom / PostHog'],
            ['Monitoring', 'Sentry + BetterStack'],
        ]));

    $p[] = $T::slide(11, $total, 'Where To Deepen Your Skills',
        $T::cardGrid([
            ['icon' => '⚙️', 'title' => 'DevOps', 'text' => 'Docker, Kubernetes, Terraform, AWS/GCP'],
            ['icon' => '📊', 'title' => 'Data', 'text' => 'Postgres, data warehouses, dbt, Metabase', 'color' => 'sba-pink'],
            ['icon' => '🧠', 'title' => 'AI Engineering', 'text' => 'RAG, agents, fine-tuning, embeddings', 'color' => 'sba-cyan'],
            ['icon' => '📱', 'title' => 'Mobile', 'text' => 'React Native, Expo, Swift, Kotlin', 'color' => 'sba-green'],
            ['icon' => '🔒', 'title' => 'Security', 'text' => 'OSCP, OWASP, threat modelling'],
            ['icon' => '🎨', 'title' => 'Design', 'text' => 'Systems, typography, UX research', 'color' => 'sba-pink'],
        ], 3));

    $p[] = $T::slide(12, $total, 'Getting Hired (or Hiring Clients)',
        $T::numberedList([
            'Have a polished portfolio with 3 public case studies',
            'GitHub with green commit activity',
            'LinkedIn headline states exactly what you do',
            'Case studies show results, not just features (e.g. "Cut checkout time 38%")',
            'Apply + reach out to 5 opportunities per week',
            'Raise rates by 15-25% every 6 months',
        ]));

    $p[] = $T::slide(13, $total, 'Freelance Rates (2026 USD)',
        $T::table(['Level', 'Hourly', 'Annual'], [
            ['Junior Full-Stack', '\$25-\$45', '\$40k-\$80k'],
            ['Mid Full-Stack', '\$50-\$90', '\$80k-\$130k'],
            ['Senior / AI-Powered', '\$90-\$180', '\$130k-\$250k'],
            ['Specialist / Architect', '\$180-\$350', '\$250k-\$500k+'],
        ]) .
        $T::callout('info', 'Reality check',
            'AI amplifies output — the gap between junior and senior will grow faster than ever.'));

    $p[] = $T::slide(14, $total, 'The 90-Day Mastery Plan',
        $T::numberedList([
            'Days 1-30 — rebuild one of the three projects from scratch without help',
            'Days 31-60 — add one new feature: subscriptions, analytics, or i18n',
            'Days 61-75 — take on a freelance or open-source project',
            'Days 76-90 — ship it to real users and measure',
            'Publish a case study each month',
        ]));

    $p[] = $T::slide(15, $total, 'Communities Worth Joining',
        $T::bulletList([
            'Laravel — <code class="sba-inline">laracasts.com</code>, <code class="sba-inline">r/laravel</code>',
            'React / Node — <code class="sba-inline">reactiflux</code> Discord',
            'WordPress — WP Tavern, Post Status',
            'AI Coding — <code class="sba-inline">cursor.sh/community</code>',
            'Freelancing — IndieHackers, MegaMaker',
        ]));

    $p[] = $T::slide(16, $total, 'Recommended Reading',
        $T::bulletList([
            'The Pragmatic Programmer — Hunt & Thomas',
            'Designing Data-Intensive Applications — Kleppmann',
            'Refactoring — Martin Fowler',
            'Staff Engineer — Will Larson',
            'The Mom Test — Rob Fitzpatrick (for talking to customers)',
        ]));

    $p[] = $T::slide(17, $total, 'Recommended Podcasts & Channels',
        $T::bulletList([
            'Syntax.fm (frontend)',
            'Lex Fridman Podcast (AI/ML)',
            'The Laracasts Snippet',
            'Dan Abramov\'s Overreacted blog',
            'Fireship YouTube (100-sec summaries)',
        ]));

    $p[] = $T::slide(18, $total, 'Things That Will Change In 2026-2027',
        $T::bulletList([
            'AI agents that ship entire features autonomously',
            'Typescript-first PHP & Laravel tooling',
            'Rust-based JavaScript build tools (Oxc, Rolldown)',
            'Edge-first databases (Turso, PlanetScale, Neon)',
            'Passkeys replacing passwords',
        ]));

    $p[] = $T::slide(19, $total, 'Give Back',
        $T::bulletList([
            'Write about what you learned — tutorials get you noticed',
            'Answer StackOverflow questions',
            'Open-source a utility library',
            'Mentor one junior developer',
            'Speak at a local meetup',
        ]));

    $p[] = $T::slide(20, $total, 'Final Words',
        $T::quote('The best way to predict the future is to build it. You now have the tools to build entire websites, APIs, and stores — augmented by the most capable AI ever created. Ship relentlessly, stay curious, keep the user in mind.', 'Your instructor — Adam Johnson'));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Launch is the start, not the end',
        '3-2-1 backups + monthly restore drills',
        'AI changes the role — build, measure, iterate 10x faster',
        'Invest in learning new stacks every 6-12 months',
        'Ship in public — portfolios compound',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, '🎓 Congratulations — You Completed The Bootcamp',
        $T::lead('You built three full-stack e-commerce sites, learned eight programming languages, and shipped a real product to a real domain. This is only the start.') .
        $T::callout('success', 'Your next step',
            'Pick <b>one</b> project from this bootcamp and deploy it to production with your own brand by the end of this week.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}
