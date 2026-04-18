<?php
require_once __DIR__ . '/slide_template.php';

/**
 * Generates content for Lessons 1-8 (Foundations + Frontend).
 */

function lesson_01_content(): string {
    $T = 'SlideTemplate';
    $total = 22;
    $parts = [];
    $parts[] = $T::cover(1, 24,
        'The AI-Powered Developer Mindset & How The Web Works',
        'Welcome to the bootcamp. In this opening lesson you discover what it means to build software in 2026 — when every developer has an AI pair-programmer sitting next to them.',
        'Module 1', '3h 30m');

    $parts[] = $T::slide(2, $total, 'Learning Objectives',
        $T::lead('By the end of this lesson you will be able to:') .
        $T::bulletList([
            'Describe how a modern web request flows from a user\'s browser to a server and back',
            'Distinguish between <b>frontend</b>, <b>backend</b>, and <b>full-stack</b> development with concrete examples',
            'Explain the <b>HTTP/HTTPS</b>, <b>DNS</b>, <b>TCP</b>, and <b>TLS</b> layers in plain English',
            'Identify the four major AI coding assistants and when to use each',
            'Adopt the mental model of "AI as junior teammate" rather than "AI as magic oracle"',
        ]));

    $parts[] = $T::slide(3, $total, 'What is AI-Powered Development?',
        $T::lead('AI-Powered Development is the practice of using Large Language Models (LLMs) such as GPT-5, Claude, and Gemini as <i>collaborators</i> throughout the software development life-cycle — from planning, to writing code, to reviewing, to debugging and documenting.') .
        $T::unsplashImage('artificial intelligence coding', 'AI developer') .
        $T::callout('info', 'Key insight',
            'AI does not replace engineers — it amplifies them. A skilled developer with AI assistance ships in hours what used to take days.'));

    $parts[] = $T::slide(4, $total, 'The Four Pillars of the Modern Stack',
        $T::cardGrid([
            ['icon' => '🎨', 'title' => 'Client (Browser)', 'text' => 'HTML, CSS, JavaScript, React — everything your user sees and interacts with.'],
            ['icon' => '⚙️', 'title' => 'Server', 'text' => 'PHP, Node.js, Python — business logic, authentication, file storage.', 'color' => 'sba-pink'],
            ['icon' => '🗃️', 'title' => 'Database', 'text' => 'MySQL, PostgreSQL, MongoDB — persistent storage of users, orders, content.', 'color' => 'sba-cyan'],
            ['icon' => '🤖', 'title' => 'AI Assistant', 'text' => 'Cursor, Copilot, ChatGPT, Claude — your always-on senior teammate.', 'color' => 'sba-green'],
        ], 2));

    $parts[] = $T::slide(5, $total, 'How The Web Actually Works — Step by Step',
        $T::paragraph('When a user types <code class="sba-inline">https://swissbridgeacademy.com</code> and presses Enter, here is what happens in the ~200 milliseconds before the page appears.') .
        $T::numberedList([
            '<b>DNS lookup</b> — the browser asks a DNS server for the IP address of <code class="sba-inline">swissbridgeacademy.com</code>.',
            '<b>TCP handshake</b> — the browser opens a connection to that IP address on port 443.',
            '<b>TLS handshake</b> — the server presents its certificate and both sides agree on encryption keys.',
            '<b>HTTP request</b> — the browser sends <code class="sba-inline">GET / HTTP/2</code> along with cookies and headers.',
            '<b>Server routing</b> — Laravel / Node / PHP matches the request to a controller and executes business logic.',
            '<b>Database query</b> — the controller asks MySQL for the home-page data.',
            '<b>HTTP response</b> — the server streams back HTML (or JSON), the browser parses and renders it.',
        ]));

    $parts[] = $T::slide(6, $total, 'HTTP in 60 Seconds',
        $T::paragraph('Every network request has a <b>method</b>, a <b>URL</b>, <b>headers</b>, and an optional <b>body</b>.') .
        $T::codeBlock(
"GET /api/products?category=laptops HTTP/2
Host: api.store.com
Authorization: Bearer eyJhbGciOi...
Accept: application/json

HTTP/2 200 OK
Content-Type: application/json
Cache-Control: max-age=60

{
  \"products\": [
    { \"id\": 1, \"name\": \"MacBook Pro\", \"price\": 1999 },
    { \"id\": 2, \"name\": \"Dell XPS 15\", \"price\": 1499 }
  ]
}", 'http') .
        $T::callout('success', 'Pro tip', 'Memorise the six main verbs: <b>GET, POST, PUT, PATCH, DELETE, OPTIONS</b>. They map 1:1 to database operations.'));

    $parts[] = $T::slide(7, $total, 'Frontend vs Backend vs Full-Stack',
        $T::table(
            ['Role', 'What they build', 'Typical tech'],
            [
                ['<b>Frontend</b>', 'What the user sees and clicks', 'HTML, CSS, JS, React, Tailwind'],
                ['<b>Backend</b>', 'What runs on the server', 'PHP/Laravel, Node/Express, Python'],
                ['<b>Database engineer</b>', 'Data modelling, queries, indexes', 'MySQL, PostgreSQL, MongoDB'],
                ['<b>DevOps</b>', 'Servers, deployment, monitoring', 'Linux, Docker, CI/CD, Hostinger'],
                ['<b>Full-stack</b>', 'All of the above', 'Everything (that\'s what you become)'],
            ]));

    $parts[] = $T::slide(8, $total, 'Meet Your AI Teammates',
        $T::cardGrid([
            ['icon' => '🧠', 'title' => 'ChatGPT (GPT-5)', 'text' => 'Strong reasoning, explanation, teaching. Great for learning new concepts.'],
            ['icon' => '🔮', 'title' => 'Claude (Opus 4.7)', 'text' => 'Best-in-class for long code reviews, refactoring, and nuanced writing.', 'color' => 'sba-pink'],
            ['icon' => '✈️', 'title' => 'GitHub Copilot', 'text' => 'Inline auto-complete inside VS Code — feels like autocomplete on steroids.', 'color' => 'sba-cyan'],
            ['icon' => '⚡', 'title' => 'Cursor AI', 'text' => 'An entire IDE built around AI. Edit multiple files with one prompt.', 'color' => 'sba-green'],
        ], 2));

    $parts[] = $T::slide(9, $total, 'When To Use Which AI',
        $T::bulletList([
            '<b>Learning a new concept</b> → ChatGPT or Claude (ask them to explain like you\'re 12)',
            '<b>Writing a first draft of code</b> → Cursor Composer or GitHub Copilot',
            '<b>Reviewing a pull request</b> → Claude (upload the diff and ask for feedback)',
            '<b>Debugging a mysterious error</b> → Paste the stack trace + surrounding code into Claude',
            '<b>Architecting a new feature</b> → ChatGPT to brainstorm, Cursor to implement',
            '<b>Writing tests</b> → Cursor or Copilot (they love deterministic tasks)',
            '<b>Generating documentation</b> → any of them — all are excellent at docs',
        ]));

    $parts[] = $T::slide(10, $total, 'The "AI as Junior Teammate" Mindset',
        $T::quote('Treat AI the way you would treat a smart but inexperienced junior engineer. Give them context, review their output, never merge their code blindly.', 'Core principle of this bootcamp') .
        $T::paragraph('This mindset protects you from the two most common failure modes:') .
        $T::cardGrid([
            ['icon' => '❌', 'title' => 'Blind Trust', 'text' => 'Copy-pasting AI code without reading it. Leads to hallucinated APIs, security holes, and subtle bugs.', 'color' => 'sba-pink'],
            ['icon' => '❌', 'title' => 'Blind Distrust', 'text' => 'Refusing to use AI out of pride. Leads to being 10x slower than your peers.', 'color' => 'sba-pink'],
        ], 2));

    $parts[] = $T::slide(11, $total, 'Anatomy of a Great AI Prompt',
        $T::paragraph('A great prompt has four components: <b>Role</b>, <b>Context</b>, <b>Task</b>, <b>Format</b> (R-C-T-F).') .
        $T::codeBlock(
"ROLE:
  You are a senior Laravel developer with 10 years of e-commerce experience.

CONTEXT:
  I am building an online store that sells Swiss watches.
  The project uses Laravel 11, MySQL 8, and Blade templates.
  Orders table currently has: id, user_id, total, status.

TASK:
  Add a shipping_address_id column + migration + Eloquent relation.
  Validate that the address belongs to the same user.

FORMAT:
  Return the migration file, the updated Order model,
  and 3 PHPUnit tests covering happy path + 2 edge cases.", 'prompt') .
        $T::callout('success', 'Remember', 'Specificity beats eloquence. Numbers, names, and examples always help.'));

    $parts[] = $T::slide(12, $total, 'Hands-On: Your First AI-Assisted Code Session',
        $T::paragraph('Open ChatGPT or Claude in a new tab and paste this prompt:') .
        $T::codeBlock(
"You are a senior frontend engineer.

Write a single HTML file that displays a 'Hello, World!' message
centered on the page with:
  - A gradient purple-to-pink background
  - White text, font-size 48px, modern sans-serif font
  - A subtle fade-in animation on page load

Return only the file contents, no explanation.", 'prompt') .
        $T::paragraph('Save what it returns as <code class="sba-inline">hello.html</code>, open it in a browser. Congratulations — you just built your first AI-assisted web page.'));

    $parts[] = $T::slide(13, $total, 'What The Output Will Look Like',
        $T::codeBlock(
"<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <title>Hello World</title>
  <style>
    body {
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #6a11cb 0%, #ec4899 100%);
      font-family: system-ui, sans-serif;
      color: white;
      font-size: 48px;
      animation: fadeIn 1.2s ease-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0);    }
    }
  </style>
</head>
<body>Hello, World!</body>
</html>", 'html'));

    $parts[] = $T::slide(14, $total, 'The Full-Stack Journey You\'re About To Take',
        $T::numberedList([
            'Foundations → the tools, Git, and AI workflows (you are here)',
            'Frontend → HTML, CSS, JS, Bootstrap, Tailwind, TypeScript, React',
            'PHP + Laravel → build a full e-commerce site with MySQL',
            'MERN Stack → rebuild the same store with MongoDB + Node + React',
            'WordPress → rebuild it again with WooCommerce for client work',
            'Deployment → ship it live on Hostinger with a real domain',
        ]) .
        $T::callout('info', 'Why rebuild the same project three times?', 'Different clients need different stacks. After this course you will walk into any project and know exactly which stack fits the problem.'));

    $parts[] = $T::slide(15, $total, 'The Three Stacks You Will Master',
        $T::cardGrid([
            ['icon' => '🐘', 'title' => 'LAMP / Laravel', 'text' => 'Classic PHP stack: Linux + Apache + MySQL + PHP. Powers 78% of the web.'],
            ['icon' => '⚛️', 'title' => 'MERN', 'text' => 'MongoDB + Express + React + Node. The modern JS-everywhere stack.', 'color' => 'sba-pink'],
            ['icon' => '📝', 'title' => 'WordPress', 'text' => 'The world\'s #1 CMS — 43% of all websites. Clients love it.', 'color' => 'sba-cyan'],
        ], 3));

    $parts[] = $T::slide(16, $total, 'Browser Dev Tools — Your X-Ray Vision',
        $T::paragraph('Before writing a single line of code you must master <b>Chrome DevTools</b>. Press <code class="sba-inline">F12</code> (or <code class="sba-inline">Cmd+Option+I</code> on Mac) in any browser.') .
        $T::unsplashImage('chrome devtools inspector', 'DevTools panels') .
        $T::bulletList([
            '<b>Elements</b> tab — inspect & live-edit HTML + CSS',
            '<b>Console</b> tab — run JavaScript, see logs and errors',
            '<b>Network</b> tab — every request, its status, size, timing',
            '<b>Application</b> tab — cookies, localStorage, IndexedDB',
            '<b>Lighthouse</b> tab — performance, SEO and accessibility audits',
        ]));

    $parts[] = $T::slide(17, $total, 'Exercise 1 — Reverse Engineer a Real Website',
        $T::paragraph('Your first assignment:') .
        $T::numberedList([
            'Open <code class="sba-inline">swissbridgeacademy.com</code> in Chrome',
            'Press F12 to open DevTools',
            'In the Network tab, refresh the page',
            'Identify the <b>first document</b> request — that\'s the HTML',
            'Identify one <b>CSS</b>, one <b>JS</b>, one <b>image</b>, and one <b>API</b> request',
            'Ask ChatGPT: "Explain what each of these file types does for my users"',
        ]) .
        $T::callout('warning', 'Goal',
            'You should come away understanding that a single page is built from dozens of files downloaded in parallel.'));

    $parts[] = $T::slide(18, $total, 'Key Industry Terms You MUST Know',
        $T::table(['Term', 'One-line definition'], [
            ['<b>API</b>', 'An Application Programming Interface — how programs talk to each other'],
            ['<b>REST</b>', 'A style for designing APIs around HTTP verbs and URLs'],
            ['<b>JSON</b>', 'A lightweight data format (<code class="sba-inline">{"key":"value"}</code>)'],
            ['<b>SSR vs CSR</b>', 'Server-Side Rendering (Laravel) vs Client-Side Rendering (React)'],
            ['<b>CRUD</b>', 'Create, Read, Update, Delete — the four core data operations'],
            ['<b>SPA</b>', 'Single-Page Application (React, Vue, Angular)'],
            ['<b>CI/CD</b>', 'Continuous Integration / Continuous Deployment — automated testing + shipping'],
            ['<b>LLM</b>', 'Large Language Model (GPT, Claude, Gemini)'],
        ]));

    $parts[] = $T::slide(19, $total, 'Ethics & Responsibility of AI-Assisted Coding',
        $T::callout('warning', 'Never do this',
            'Never paste customer data, API keys, or passwords into a public AI tool. Use the enterprise or offline versions for sensitive code.') .
        $T::callout('info', 'Always do this',
            'Read every line of AI-generated code. Run it locally. Understand what it does <b>before</b> it hits production.') .
        $T::callout('success', 'Best practice',
            'Maintain a local <code class="sba-inline">.ai-context.md</code> file in each project so the AI always has the right background.'));

    $parts[] = $T::slide(20, $total, 'Tools Checklist for Lesson 2',
        $T::paragraph('Before the next lesson, confirm you have accounts for:') .
        $T::bulletList([
            '<b>GitHub</b> — free at github.com',
            '<b>ChatGPT</b> — free tier at chat.openai.com',
            '<b>Claude</b> — free tier at claude.ai',
            '<b>Cursor</b> — free tier at cursor.sh',
            '<b>Hostinger</b> — for the final deployment lesson (any shared hosting plan)',
        ]));

    $parts[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'The web is a <b>request/response</b> system built on HTTP and DNS',
        'A full-stack developer owns frontend + backend + database + deployment',
        'AI tools are <b>force multipliers</b>, not magic boxes',
        'Prompt engineering = Role + Context + Task + Format',
        'You will build three complete e-commerce sites in three stacks by the end',
    ]), 'sba-recap');

    $parts[] = $T::slide(22, $total, 'Next Up — Lesson 2',
        $T::lead('In the next lesson you will set up a professional AI-assisted workstation: VS Code + Cursor + Copilot + a polished terminal.') .
        $T::callout('success', 'Homework', 'Install Cursor, create a free GitHub account, and enable GitHub Copilot student access if you\'re a student.'));

    return $T::deckOpen() . implode("\n", $parts) . $T::deckClose();
}

function lesson_02_content(): string {
    $T = 'SlideTemplate';
    $total = 22;
    $parts = [];
    $parts[] = $T::cover(2, 24,
        'Setting Up Your Professional AI-Assisted Workstation',
        'Install, configure and tune every tool a modern full-stack developer needs — VS Code, Cursor, Git, Node, PHP, the terminal, and the AI assistants that glue them all together.',
        'Module 1', '3h 15m');

    $parts[] = $T::slide(2, $total, 'Lesson Objectives',
        $T::bulletList([
            'Install and configure <b>VS Code</b> and <b>Cursor AI</b> side by side',
            'Wire up <b>GitHub Copilot</b>, <b>Claude</b>, and <b>ChatGPT</b> inside your editor',
            'Install <b>Node 22</b>, <b>PHP 8.3</b>, <b>Composer</b>, <b>MySQL 8</b> and verify each',
            'Customise a productivity-focused terminal (PowerShell 7 / Oh My Zsh)',
            'Create your first AI-optimised project template',
        ]));

    $parts[] = $T::slide(3, $total, 'Hardware Recommendations',
        $T::table(['Resource', 'Minimum', 'Recommended', 'Why'], [
            ['RAM', '8 GB', '16+ GB', 'Docker, Node, Chrome, and AI eat RAM fast'],
            ['CPU', 'Any x86 or Apple Silicon', 'M-series or Ryzen 7', 'Faster builds + faster AI tab completions'],
            ['Storage', '256 GB SSD', '512 GB+ NVMe', 'Each full-stack project = ~500 MB of node_modules'],
            ['OS', 'Win 10 / macOS 12 / Ubuntu 22', 'Latest stable', 'Newer = fewer compatibility issues'],
        ]) .
        $T::callout('info', 'Tip', 'A student laptop with 16GB RAM + 512GB SSD is the sweet spot for 2026.'));

    $parts[] = $T::slide(4, $total, 'VS Code vs Cursor AI — The Honest Comparison',
        $T::cardGrid([
            ['icon' => '🆓', 'title' => 'VS Code', 'text' => 'Free forever, 30+ million users, infinite extensions. Copilot sold separately.'],
            ['icon' => '🚀', 'title' => 'Cursor AI', 'text' => 'VS Code fork with AI baked into the core. Composer lets you edit many files from one prompt.', 'color' => 'sba-pink'],
        ], 2) .
        $T::callout('success', 'Our recommendation',
            'Install BOTH. Use Cursor as your primary. Keep VS Code for non-AI tasks and as a backup.'));

    $parts[] = $T::slide(5, $total, 'Installing VS Code',
        $T::numberedList([
            'Go to <code class="sba-inline">code.visualstudio.com</code> and download for your OS',
            'Run the installer — accept all defaults',
            'On first launch, choose the "Dark Modern" theme',
            'Press <code class="sba-inline">Ctrl+Shift+X</code> to open Extensions',
            'Install the "Essentials Pack" from the next slide',
        ]));

    $parts[] = $T::slide(6, $total, 'Essential VS Code Extensions',
        $T::table(['Extension', 'What it does'], [
            ['GitHub Copilot + Copilot Chat', 'AI autocomplete + conversational AI inside the editor'],
            ['Prettier', 'Opinionated auto-formatter — prevents style wars'],
            ['ESLint', 'Catches JavaScript/TypeScript bugs as you type'],
            ['PHP Intelephense', 'Industry-standard PHP language server'],
            ['Laravel Extra Intellisense', 'Autocompletes routes, views, and config'],
            ['Tailwind CSS IntelliSense', 'Autocompletes utility class names'],
            ['Error Lens', 'Inlines errors next to the line — saves a trip to Problems tab'],
            ['Thunder Client', 'Built-in REST client (no more Postman tab)'],
            ['GitLens', 'Superpowers for Git blame, history, and branches'],
            ['Material Icon Theme', 'Beautiful file-type icons in the file tree'],
        ]));

    $parts[] = $T::slide(7, $total, 'Installing Cursor AI',
        $T::unsplashImage('computer screen code editor', 'Cursor editor') .
        $T::numberedList([
            'Download from <code class="sba-inline">cursor.sh</code>',
            'Run the installer — it imports your VS Code settings automatically',
            'Sign in with GitHub to activate the free tier',
            'Open Settings → Cursor Tab → enable GPT-5 or Claude Sonnet as the default model',
            'Press <code class="sba-inline">Ctrl+L</code> to open the chat, <code class="sba-inline">Ctrl+K</code> for inline edit, <code class="sba-inline">Ctrl+I</code> for Composer',
        ]));

    $parts[] = $T::slide(8, $total, 'Cursor Power Shortcuts (memorise these)',
        $T::table(['Shortcut', 'Action'], [
            ['<b>Ctrl + K</b>', 'Edit selected code in place with AI'],
            ['<b>Ctrl + L</b>', 'Open AI chat sidebar'],
            ['<b>Ctrl + I</b>', 'Open Composer (multi-file edits)'],
            ['<b>Ctrl + Enter</b>', 'Send with full codebase context'],
            ['<b>Tab</b>', 'Accept inline autocomplete suggestion'],
            ['<b>Ctrl + Shift + L</b>', 'Select all occurrences of the current word'],
            ['<b>@ + file name</b>', 'Attach a specific file to the AI prompt'],
            ['<b>@codebase</b>', 'Attach your entire project as context'],
        ]));

    $parts[] = $T::slide(9, $total, 'Installing Node.js 22 (LTS)',
        $T::paragraph('Node.js runs JavaScript outside the browser and powers npm, React tooling, and Express servers.') .
        $T::codeBlock(
"# Windows: use the official installer from nodejs.org

# macOS / Linux — use nvm (recommended)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
source ~/.bashrc
nvm install 22
nvm use 22

# Verify
node --version   # → v22.x.x
npm --version    # → 10.x.x", 'bash') .
        $T::callout('success', 'Why nvm?', 'Different projects need different Node versions. nvm lets you switch in one command.'));

    $parts[] = $T::slide(10, $total, 'Installing PHP 8.3 & Composer',
        $T::codeBlock(
"# Windows: download from windows.php.net, add to PATH
# macOS:
brew install php@8.3 composer

# Ubuntu:
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt install php8.3 php8.3-cli php8.3-mysql php8.3-xml php8.3-mbstring

# Install composer globally
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Verify
php --version           # → PHP 8.3.x
composer --version      # → Composer version 2.x", 'bash'));

    $parts[] = $T::slide(11, $total, 'Installing MySQL 8',
        $T::numberedList([
            'Download MySQL Community Server 8.x from <code class="sba-inline">dev.mysql.com</code>',
            'During install, set a strong root password and SAVE it in your password manager',
            'Install MySQL Workbench for a GUI (optional but recommended)',
            'Confirm installation: <code class="sba-inline">mysql --version</code>',
            'Start the server: <code class="sba-inline">mysqld --initialize --console</code>',
        ]) .
        $T::callout('warning', 'Password rule', 'Never reuse passwords between local and production. NEVER commit them.'));

    $parts[] = $T::slide(12, $total, 'Your Perfect Terminal',
        $T::paragraph('A beautiful, fast terminal is a joy to work in and saves minutes every hour.') .
        $T::cardGrid([
            ['icon' => '🪟', 'title' => 'Windows', 'text' => 'Windows Terminal + PowerShell 7 + Oh My Posh for themes'],
            ['icon' => '🍎', 'title' => 'macOS', 'text' => 'iTerm2 + Oh My Zsh + the "powerlevel10k" theme', 'color' => 'sba-pink'],
            ['icon' => '🐧', 'title' => 'Linux', 'text' => 'Any terminal + Zsh + Starship prompt', 'color' => 'sba-cyan'],
        ], 3) .
        $T::codeBlock(
"# Install Oh My Zsh (macOS/Linux)
sh -c \"\$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)\"

# Install Starship (cross-platform)
curl -sS https://starship.rs/install.sh | sh", 'bash'));

    $parts[] = $T::slide(13, $total, 'Global npm Tools Every Developer Needs',
        $T::codeBlock(
"npm install -g \\
  typescript \\
  ts-node \\
  nodemon \\
  pnpm \\
  vercel \\
  http-server \\
  eslint \\
  prettier

# Verify one of them
tsc --version", 'bash') .
        $T::table(['Tool', 'Purpose'], [
            ['typescript / ts-node', 'Run TypeScript files directly'],
            ['nodemon', 'Auto-restart your Node server on file changes'],
            ['pnpm', 'Drastically faster npm alternative — uses 80% less disk'],
            ['vercel', 'Deploy static sites in one command'],
            ['http-server', 'Serve any folder as a local website in 1 second'],
        ]));

    $parts[] = $T::slide(14, $total, 'Creating Your First AI-Ready Project',
        $T::codeBlock(
"mkdir my-first-ai-project && cd my-first-ai-project

# Initialise Git
git init

# Create an AI context file
cat > .ai-context.md << 'EOF'
# Project: My First AI Project
## Stack
- Node 22, TypeScript, React 19
- TailwindCSS 4
- Vitest for tests

## Conventions
- Use functional React components with hooks
- Tailwind only, no styled-components
- All files must pass \`pnpm lint\` before commit
EOF

# .gitignore
cat > .gitignore << 'EOF'
node_modules/
.env
.env.local
dist/
.DS_Store
EOF

code .", 'bash') .
        $T::callout('success', 'Power move',
            'A <code class="sba-inline">.ai-context.md</code> file at the root of every project primes Cursor/Copilot with your conventions.'));

    $parts[] = $T::slide(15, $total, 'Environment Variables 101',
        $T::paragraph('Never hard-code secrets. Always load them from <code class="sba-inline">.env</code>.') .
        $T::codeBlock(
".env   (never commit this file)
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=super-secret
OPENAI_API_KEY=sk-...

.env.example   (commit this so teammates know the keys)
DB_HOST=
DB_USER=
DB_PASSWORD=
OPENAI_API_KEY=", 'ini'));

    $parts[] = $T::slide(16, $total, 'Chrome — Your Debugging Browser',
        $T::bulletList([
            'Install Chrome (or Edge Dev — same engine, better privacy)',
            'Install the <b>React Developer Tools</b> extension',
            'Install the <b>Vue Devtools</b> extension (for when you explore Vue)',
            'Install the <b>Wappalyzer</b> extension — detects what tech a site uses',
            'Install the <b>JSON Viewer</b> extension — pretty-prints API responses',
        ]));

    $parts[] = $T::slide(17, $total, 'Installing & Using Postman (or Thunder Client)',
        $T::paragraph('You need a tool to hit your APIs before wiring up a UI. Thunder Client lives inside VS Code and is free.') .
        $T::unsplashImage('api documentation development', 'API testing') .
        $T::numberedList([
            'Open Thunder Client from the VS Code sidebar',
            'Click "New Request"',
            'Method = GET, URL = <code class="sba-inline">https://jsonplaceholder.typicode.com/users</code>',
            'Hit Send — observe the JSON response',
            'Try POST with a JSON body in the next practice',
        ]));

    $parts[] = $T::slide(18, $total, 'A Clean File-System Layout',
        $T::codeBlock(
"~/dev
├── bootcamp/
│   ├── lesson-01-foundations/
│   ├── lesson-05-html/
│   ├── lesson-14-laravel-store/
│   └── ...
├── clients/
│   └── (production work)
└── playground/
    └── (quick experiments)", 'text') .
        $T::callout('info', 'Why this matters', 'Muscle memory for <code class="sba-inline">cd ~/dev/bootcamp</code> beats hunting through Downloads every day.'));

    $parts[] = $T::slide(19, $total, 'Hands-On Lab — Verify the Stack',
        $T::paragraph('Open your terminal and run every command below. Each should print a version number.') .
        $T::codeBlock(
"node --version       # v22.x
npm  --version       # 10.x
php  --version       # 8.3.x
composer --version   # 2.x
mysql --version      # 8.x
git  --version       # 2.x
tsc  --version       # 5.x", 'bash') .
        $T::callout('danger', 'If any command fails', 'Paste the error into Claude/ChatGPT with your OS and follow its fix steps.'));

    $parts[] = $T::slide(20, $total, 'Common Installation Pitfalls',
        $T::table(['Error', 'Cause', 'Fix'], [
            ['"node is not recognised"', 'PATH missing', 'Reopen terminal or edit env PATH'],
            ['"zsh: command not found: brew"', 'Homebrew not installed', 'Run the brew install script'],
            ['MySQL won\'t start', 'Port 3306 in use', '<code class="sba-inline">net stop MySQL80</code> or use port 3307'],
            ['"SSL error" in composer', 'Corporate proxy', 'Set <code class="sba-inline">composer config --global secure-http false</code>'],
        ]));

    $parts[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'You now have VS Code, Cursor, Node, PHP, Composer and MySQL installed',
        'Your terminal is fast, themed, and ready',
        'Every project starts with a <code class="sba-inline">.ai-context.md</code> and a <code class="sba-inline">.env.example</code>',
        'Copilot + Claude + ChatGPT are sitting inside your editor, ready to help',
        'You can verify the full stack with seven shell commands',
    ]), 'sba-recap');

    $parts[] = $T::slide(22, $total, 'Up Next — Lesson 3',
        $T::lead('You have the tools. Next we master the skill that 10x your output with those tools: <b>Prompt Engineering</b>.'));

    return $T::deckOpen() . implode("\n", $parts) . $T::deckClose();
}

function lesson_03_content(): string {
    $T = 'SlideTemplate';
    $total = 22;
    $parts = [];
    $parts[] = $T::cover(3, 24,
        'Mastering Prompt Engineering & AI Pair-Programming',
        'Move from casual chatbot usage to professional AI pair-programming. Learn the frameworks (R-C-T-F, ReAct, Chain-of-Thought) that turn generic models into expert teammates.',
        'Module 1', '3h 45m');

    $parts[] = $T::slide(2, $total, 'Why Prompt Engineering Is A Real Skill',
        $T::quote('A great prompt is worth a thousand lines of documentation.') .
        $T::paragraph('Your prompts determine the quality of AI output. Two engineers on the same team, same model, same problem — one ships in 20 minutes, the other struggles for 3 hours. The difference is almost always prompt quality.'));

    $parts[] = $T::slide(3, $total, 'The R-C-T-F Framework',
        $T::cardGrid([
            ['icon' => '🎭', 'title' => 'R — Role', 'text' => 'Who should the AI pretend to be? "Senior Laravel engineer with 10 years..."'],
            ['icon' => '📋', 'title' => 'C — Context', 'text' => 'What project, stack, constraints, existing code?', 'color' => 'sba-pink'],
            ['icon' => '✅', 'title' => 'T — Task', 'text' => 'What exactly do you want done? Be specific.', 'color' => 'sba-cyan'],
            ['icon' => '📐', 'title' => 'F — Format', 'text' => 'JSON? Markdown? Numbered list? A code file only?', 'color' => 'sba-green'],
        ], 2));

    $parts[] = $T::slide(4, $total, 'Weak Prompt vs Strong Prompt',
        $T::codeBlock(
"❌ WEAK:
 \"Make me a login form\"", 'prompt') .
        $T::codeBlock(
"✅ STRONG:
ROLE: You are a senior React + TypeScript engineer.
CONTEXT: I am building a SPA with Next.js 15, TailwindCSS 4, and
         the <shadcn/ui> component library. Auth is handled by Clerk.
TASK: Create a login form component at
         src/components/auth/LoginForm.tsx with:
         - email + password fields (react-hook-form + zod validation)
         - \"Remember me\" checkbox
         - submit button with loading spinner
         - red error text under each invalid field
         - link to /forgot-password
FORMAT: Return only the .tsx file contents — no prose, no imports
         from libraries I didn't mention.", 'prompt') .
        $T::callout('success', 'Observe', 'Strong prompts take 30 seconds to write and save 30 minutes of rework.'));

    $parts[] = $T::slide(5, $total, 'Zero-Shot vs Few-Shot vs Chain-of-Thought',
        $T::table(['Technique', 'When to use', 'Example'], [
            ['<b>Zero-shot</b>', 'Simple, well-known tasks', '"Write a regex for email validation"'],
            ['<b>Few-shot</b>', 'Specific formats or styles', 'Show 2-3 examples of input+output'],
            ['<b>Chain-of-Thought</b>', 'Complex reasoning or multi-step logic', '"Think step by step"'],
            ['<b>ReAct</b>', 'Tasks requiring research + action', 'Reason → Act → Observe → Repeat'],
        ]));

    $parts[] = $T::slide(6, $total, 'Few-Shot Prompting In Action',
        $T::codeBlock(
"Convert English dates to ISO 8601.

Input:  'January 5, 2026'
Output: '2026-01-05'

Input:  'Dec 31st, 2025'
Output: '2025-12-31'

Input:  'March 2, 2024'
Output:", 'prompt') .
        $T::callout('info', 'Why it works', 'The AI pattern-matches your examples perfectly and follows the format every time.'));

    $parts[] = $T::slide(7, $total, 'Chain-of-Thought For Hard Problems',
        $T::codeBlock(
"I have 37 apples. I give 12 to Bob and buy 9 more.
How many do I have now? Think step by step.

Step 1: Start with 37
Step 2: Give away 12  → 37 - 12 = 25
Step 3: Buy 9 more    → 25 + 9 = 34
Answer: 34", 'prompt') .
        $T::paragraph('Use this for anything involving: algorithms, refactoring decisions, debugging, or architectural choices.'));

    $parts[] = $T::slide(8, $total, 'System Prompts & Personas',
        $T::paragraph('System prompts set long-term behaviour. In Cursor and the Claude API you can set one that persists across the whole session.') .
        $T::codeBlock(
"You are a senior TypeScript engineer at a fintech startup.

Rules you must ALWAYS follow:
1. Never suggest any library not listed in package.json.
2. Prefer async/await over .then chains.
3. Throw typed errors, never plain strings.
4. Add a JSDoc comment to every exported function.
5. When you change a file, show a full diff, not just the change.
6. If I ask for code you are not confident about, ask a
   clarifying question first.", 'prompt'));

    $parts[] = $T::slide(9, $total, 'The Five Anti-Patterns To Avoid',
        $T::numberedList([
            'Vague verbs ("<i>fix it</i>", "<i>make it nice</i>")',
            'Hidden context ("My code doesn\'t work" — without showing the code or the error)',
            'Asking for 10 features in one prompt — the AI will forget half of them',
            'Accepting output without reading it',
            'Blaming the AI for a bad output that came from a bad prompt',
        ]));

    $parts[] = $T::slide(10, $total, 'The "Clarifying Question" Move',
        $T::paragraph('Before asking for code, instruct the AI to ask <b>clarifying questions</b> first.') .
        $T::codeBlock(
"ME:  Build me a blog.
      BEFORE writing code, ask me 5 clarifying questions.

AI:  1. Who is the audience? (consumer/developer/enterprise)
     2. Should posts support comments and if so, auth required?
     3. Do you want Markdown or a WYSIWYG editor?
     4. Which stack: Laravel, Next.js, or WordPress?
     5. Where will it be hosted?

ME:  1. Developers  2. Comments via GitHub OAuth
     3. Markdown    4. Next.js    5. Vercel

AI:  (writes a perfect starter project)", 'prompt'));

    $parts[] = $T::slide(11, $total, 'AI For Code Review',
        $T::codeBlock(
"Act as a strict senior code reviewer.
Review the following function for:
  (1) correctness bugs
  (2) security issues (SQLi, XSS, auth)
  (3) performance problems
  (4) readability

For each issue: quote the line and suggest the fix.
If the code is clean, reply 'LGTM' and nothing else.

<code>
function login(req) {
  const user = db.query(
    'SELECT * FROM users WHERE email = \"' + req.body.email + '\"'
  );
  if (user.password === req.body.password) return user;
}
</code>", 'prompt') .
        $T::callout('danger', 'The AI will catch', 'SQL injection + plaintext password compare + no return-null case — three bugs in 4 lines!'));

    $parts[] = $T::slide(12, $total, 'AI For Debugging',
        $T::codeBlock(
"I'm getting this error:

Uncaught TypeError: Cannot read properties of undefined (reading 'map')
    at ProductList (products.tsx:23:14)

Here is products.tsx:
<paste the file>

Here is the API response:
<paste the JSON>

Think step by step about what is undefined and why,
then give me the minimal fix.", 'prompt'));

    $parts[] = $T::slide(13, $total, 'AI For Refactoring',
        $T::codeBlock(
"Refactor this 120-line function into smaller,
single-responsibility functions.

Rules:
 - Keep the public signature identical
 - Each extracted function must have a clear name & JSDoc
 - No change in behaviour; preserve all side effects
 - Add a short comment above each new function

Show the refactored file in full.", 'prompt'));

    $parts[] = $T::slide(14, $total, 'AI For Documentation',
        $T::codeBlock(
"Write developer-facing docs for this module.

Include:
 - One-paragraph overview
 - An architecture diagram in Mermaid syntax
 - Each exported symbol with a JSDoc-style signature
 - A quickstart example that shows common usage
 - A \"Gotchas\" section with 3 common mistakes

Target audience: developers who haven't seen this code before.", 'prompt'));

    $parts[] = $T::slide(15, $total, 'AI For Test Generation',
        $T::codeBlock(
"Generate exhaustive Vitest tests for this function.

 - Cover: happy path, edge cases, invalid input, async timeouts
 - Use describe() / it() blocks with clear names
 - Mock external dependencies with vi.mock()
 - Aim for 100% branch coverage

Show the test file only.", 'prompt') .
        $T::callout('success', 'Productivity hack',
            'Copilot+Claude can write tests faster than you can type. Use the time saved to review the tests carefully.'));

    $parts[] = $T::slide(16, $total, 'Context Attachment Patterns in Cursor',
        $T::bulletList([
            '<b>@file</b> — attach the currently selected file',
            '<b>@symbol</b> — attach a specific function/class by name',
            '<b>@codebase</b> — attach the entire project (use sparingly)',
            '<b>@docs</b> — attach pinned library docs',
            '<b>@web</b> — have the AI browse the live internet',
            '<b>@git</b> — attach recent git diff for PR review prompts',
        ]));

    $parts[] = $T::slide(17, $total, 'The Prompt Library Discipline',
        $T::paragraph('Professional AI users maintain a personal prompt library — reusable prompts for common tasks.') .
        $T::codeBlock(
"prompts/
├── code-review.md
├── refactor-function.md
├── generate-tests.md
├── write-migration.md
├── explain-error.md
├── design-api.md
└── write-readme.md", 'text') .
        $T::callout('info', 'Team benefit', 'A shared prompt library makes your team 3x more consistent.'));

    $parts[] = $T::slide(18, $total, 'Measuring Prompt Quality',
        $T::table(['Signal', 'Healthy', 'Red flag'], [
            ['First output quality', 'Mostly right, small tweaks', 'Completely wrong direction'],
            ['Follow-up turns', '0-2 to reach done', '5+ — you\'re fighting the AI'],
            ['Your time saved', '50-90%', '-50% (slower than solo)'],
            ['Bugs in AI code', '< 1 per 100 lines', '> 5 per 100 lines'],
        ]));

    $parts[] = $T::slide(19, $total, 'Ethics & Hallucinations',
        $T::callout('warning', 'AI Lies Confidently',
            'LLMs sometimes invent function names, library APIs, and docs that do not exist. This is called <b>hallucination</b>.') .
        $T::callout('success', 'Defence',
            'Always verify: run the code, check the docs, ask the AI "are you sure this API exists in version X?".') .
        $T::callout('info', 'Privacy',
            'Never paste private customer data. Use the enterprise/offline model tier for sensitive code.'));

    $parts[] = $T::slide(20, $total, 'Hands-On — Build Your First Prompt Library',
        $T::numberedList([
            'Create a folder <code class="sba-inline">~/dev/prompts/</code>',
            'Add <code class="sba-inline">code-review.md</code> with the code-review prompt from slide 11',
            'Add <code class="sba-inline">generate-tests.md</code> with the test prompt from slide 15',
            'Commit the folder to a private GitHub repo',
            'In Cursor, set that folder as a "Notepads" source so prompts are one-click away',
        ]));

    $parts[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Great prompts = <b>R-C-T-F</b> (Role, Context, Task, Format)',
        'Few-shot for format, Chain-of-Thought for reasoning',
        'Never accept output without reading it',
        'Build a personal prompt library and keep it in Git',
        'Verify every library/API the AI mentions — hallucinations are real',
    ]), 'sba-recap');

    $parts[] = $T::slide(22, $total, 'Up Next — Lesson 4',
        $T::lead('You can talk to AI fluently. Now we learn to keep our work safe and shareable with <b>Git, GitHub, and AI-assisted version control</b>.'));

    return $T::deckOpen() . implode("\n", $parts) . $T::deckClose();
}

function lesson_04_content(): string {
    $T = 'SlideTemplate';
    $total = 22;
    $parts = [];
    $parts[] = $T::cover(4, 24,
        'Git, GitHub & AI-Assisted Version Control Workflows',
        'Git is the universal language of code collaboration. This lesson turns you into a confident Git user who writes AI-generated commits, resolves merge conflicts with Claude, and ships code through Pull Requests.',
        'Module 1', '3h');

    $parts[] = $T::slide(2, $total, 'Objectives',
        $T::bulletList([
            'Explain what Git is and why <b>every</b> project needs it',
            'Execute the 15 Git commands you use daily',
            'Create, clone, branch, merge, and push repositories',
            'Resolve merge conflicts calmly with AI help',
            'Use the GitHub Pull Request workflow professionally',
            'Configure Cursor to generate commit messages automatically',
        ]));

    $parts[] = $T::slide(3, $total, 'What Is Git (and What It Is Not)',
        $T::cardGrid([
            ['icon' => '✅', 'title' => 'Git IS', 'text' => 'A distributed version-control system that tracks every change to every file.'],
            ['icon' => '❌', 'title' => 'Git is NOT', 'text' => 'GitHub, GitLab, or Bitbucket — those are hosting platforms built around Git.', 'color' => 'sba-pink'],
        ], 2) .
        $T::paragraph('You can use Git 100% offline. GitHub adds collaboration, issues, Pull Requests, Actions, and backup.'));

    $parts[] = $T::slide(4, $total, 'Installing & Configuring Git',
        $T::codeBlock(
"# Install
sudo apt install git           # Linux
brew install git               # macOS
winget install Git.Git         # Windows

# One-time setup
git config --global user.name \"Alice Johnson\"
git config --global user.email \"alice@example.com\"
git config --global init.defaultBranch main
git config --global pull.rebase false
git config --global core.editor \"code --wait\"

# Verify
git --version", 'bash'));

    $parts[] = $T::slide(5, $total, 'The 15 Commands That Are 95% Of Daily Git',
        $T::table(['Command', 'What it does'], [
            ['<code class="sba-inline">git init</code>', 'Turn a folder into a Git repo'],
            ['<code class="sba-inline">git clone &lt;url&gt;</code>', 'Copy a remote repo locally'],
            ['<code class="sba-inline">git status</code>', 'Show what\'s changed / staged'],
            ['<code class="sba-inline">git add .</code>', 'Stage every change'],
            ['<code class="sba-inline">git commit -m "…"</code>', 'Save a snapshot with a message'],
            ['<code class="sba-inline">git push</code>', 'Upload commits to the remote'],
            ['<code class="sba-inline">git pull</code>', 'Download and merge remote commits'],
            ['<code class="sba-inline">git branch</code>', 'List branches'],
            ['<code class="sba-inline">git checkout -b feat</code>', 'Create + switch to a new branch'],
            ['<code class="sba-inline">git merge feat</code>', 'Merge a branch into current'],
            ['<code class="sba-inline">git log --oneline</code>', 'Show history'],
            ['<code class="sba-inline">git diff</code>', 'Show unstaged differences'],
            ['<code class="sba-inline">git restore &lt;file&gt;</code>', 'Discard local changes'],
            ['<code class="sba-inline">git reset --hard</code>', 'Nuke unstaged & staged changes (careful!)'],
            ['<code class="sba-inline">git stash</code>', 'Temporarily shelve changes'],
        ]));

    $parts[] = $T::slide(6, $total, 'The Three States: Working Directory → Staging → Repository',
        $T::unsplashImage('git version control flow', 'Git three states') .
        $T::codeBlock(
"# 1) Modify a file
echo 'console.log(\"hi\")' > index.js

# 2) See it:
git status
# → modified:   index.js

# 3) Stage it (add to the \"about to commit\" list)
git add index.js

# 4) Commit it (snapshot to the repo)
git commit -m \"feat: add greeting\"

# 5) Push to GitHub
git push origin main", 'bash'));

    $parts[] = $T::slide(7, $total, 'Your First GitHub Repository',
        $T::numberedList([
            'Go to <code class="sba-inline">github.com/new</code>',
            'Name = <code class="sba-inline">my-first-repo</code>, keep it Public',
            'Do NOT tick "Initialize with README" (you\'ll push your own)',
            'Copy the SSH or HTTPS URL GitHub gives you',
            'Follow the next slide to push your local folder',
        ]));

    $parts[] = $T::slide(8, $total, 'Pushing An Existing Folder To GitHub',
        $T::codeBlock(
"cd my-project
git init
echo 'node_modules/' > .gitignore
git add .
git commit -m \"chore: initial commit\"
git branch -M main
git remote add origin git@github.com:alice/my-first-repo.git
git push -u origin main", 'bash') .
        $T::callout('success', 'The -u flag',
            'Sets this branch to always track origin/main — subsequent pushes are just <code class="sba-inline">git push</code>.'));

    $parts[] = $T::slide(9, $total, 'Branching — The Developer\'s Superpower',
        $T::paragraph('A <b>branch</b> is an independent line of work. You can experiment freely without touching <code class="sba-inline">main</code>.') .
        $T::codeBlock(
"# Create and switch in one go
git checkout -b feature/shopping-cart

# work work work...
git add .
git commit -m \"feat(cart): add quantity stepper\"

# Push the branch
git push -u origin feature/shopping-cart

# When merged on GitHub, delete locally
git checkout main
git pull
git branch -d feature/shopping-cart", 'bash'));

    $parts[] = $T::slide(10, $total, 'Conventional Commits — AI Loves Them',
        $T::paragraph('A commit-message convention that both humans and machines can parse. Cursor can auto-generate commits in this format.') .
        $T::table(['Prefix', 'Meaning'], [
            ['<code class="sba-inline">feat:</code>', 'New feature'],
            ['<code class="sba-inline">fix:</code>', 'Bug fix'],
            ['<code class="sba-inline">docs:</code>', 'Documentation only'],
            ['<code class="sba-inline">style:</code>', 'Formatting, no code change'],
            ['<code class="sba-inline">refactor:</code>', 'Code change that is not a fix or feature'],
            ['<code class="sba-inline">test:</code>', 'Adding tests'],
            ['<code class="sba-inline">chore:</code>', 'Build/tooling/dep updates'],
        ]) .
        $T::codeBlock('feat(auth): add Google OAuth login
fix(cart): prevent negative quantities
docs(readme): add deployment section
refactor(orders): extract calculateTotal helper', 'text'));

    $parts[] = $T::slide(11, $total, 'Pull Requests — The Review Ritual',
        $T::numberedList([
            'Push your feature branch to GitHub',
            'Open a Pull Request from <code class="sba-inline">feature/x</code> into <code class="sba-inline">main</code>',
            'Write a clear description: <b>what</b> + <b>why</b> + <b>how to test</b>',
            'Assign reviewers; they leave comments on specific lines',
            'CI runs tests automatically',
            'You push fixes; the PR updates automatically',
            'Reviewer approves → you click "Squash and merge"',
        ]));

    $parts[] = $T::slide(12, $total, 'PR Description Template (copy & paste)',
        $T::codeBlock(
"## What
Short description of the change.

## Why
Business/UX reason. Link the ticket if any.

## How to test
1. Clone the branch
2. Run \`pnpm install && pnpm dev\`
3. Navigate to /cart and add two items

## Screenshots
(Before/After if UI)

## Checklist
- [ ] Unit tests updated
- [ ] Docs updated
- [ ] No console.log left over", 'markdown'));

    $parts[] = $T::slide(13, $total, 'Resolving Merge Conflicts (Without Panicking)',
        $T::paragraph('A conflict happens when two branches edit the same lines differently. Git marks them:') .
        $T::codeBlock(
"<<<<<<< HEAD
const price = 99.99;
=======
const price = 79.99;
>>>>>>> feature/discount", 'diff') .
        $T::numberedList([
            'Open the file — VS Code highlights both versions',
            'Pick the right one, or combine them',
            'Remove the <code class="sba-inline">&lt;&lt;&lt;&lt;</code> markers',
            '<code class="sba-inline">git add &lt;file&gt;</code>',
            '<code class="sba-inline">git commit</code> (Git writes a merge commit for you)',
        ]));

    $parts[] = $T::slide(14, $total, 'Asking Claude To Resolve Conflicts',
        $T::codeBlock(
"I have a merge conflict in src/cart.ts:

<<<<<<< HEAD
<paste current version>
=======
<paste incoming version>
>>>>>>> feature/discount

Explain what each side changed, recommend which to keep,
and give me the merged file that preserves both intents.", 'prompt'));

    $parts[] = $T::slide(15, $total, 'AI-Generated Commit Messages In Cursor',
        $T::numberedList([
            'Stage your changes: <code class="sba-inline">git add .</code>',
            'Open the Source Control panel (<code class="sba-inline">Ctrl+Shift+G</code>)',
            'Click the ✨ sparkle icon next to the message box',
            'Cursor reads the diff and writes a conventional commit',
            'Review/edit → commit',
        ]) .
        $T::callout('success', 'Team impact',
            'Good commit messages = better blame, easier rollbacks, searchable history.'));

    $parts[] = $T::slide(16, $total, 'The .gitignore File — What NEVER Goes Into Git',
        $T::codeBlock(
"# Dependencies
node_modules/
vendor/

# Environment
.env
.env.local
*.key
*.pem

# Build artefacts
dist/
build/
.next/
.cache/

# Editor
.idea/
.vscode/*
!.vscode/settings.json

# OS
.DS_Store
Thumbs.db

# Logs
*.log", 'gitignore') .
        $T::callout('danger', 'If you commit a secret',
            'Rotate it <b>immediately</b>. The Git history keeps it forever even after deletion.'));

    $parts[] = $T::slide(17, $total, 'GitHub Actions — CI/CD In 20 Lines',
        $T::codeBlock(
".github/workflows/test.yml

name: Tests
on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: 22
      - run: npm ci
      - run: npm test", 'yaml') .
        $T::paragraph('Push this file and every future push runs your tests. Free for public repos.'));

    $parts[] = $T::slide(18, $total, 'Undoing Things Safely',
        $T::table(['Situation', 'Command'], [
            ['Unstage a file', '<code class="sba-inline">git restore --staged file</code>'],
            ['Discard local changes to a file', '<code class="sba-inline">git restore file</code>'],
            ['Amend the last commit message', '<code class="sba-inline">git commit --amend</code>'],
            ['Undo last commit (keep changes)', '<code class="sba-inline">git reset --soft HEAD~1</code>'],
            ['Undo last commit (nuke changes)', '<code class="sba-inline">git reset --hard HEAD~1</code>'],
            ['Revert a published commit', '<code class="sba-inline">git revert &lt;sha&gt;</code>'],
            ['Throw away all local state', '<code class="sba-inline">git reset --hard origin/main</code>'],
        ]) .
        $T::callout('warning', 'Golden rule', 'Never <code class="sba-inline">reset --hard</code> on a branch other developers rely on. Use <code class="sba-inline">revert</code>.'));

    $parts[] = $T::slide(19, $total, 'A Professional Branch Strategy (GitHub Flow)',
        $T::numberedList([
            '<b>main</b> is always deployable',
            'Every feature gets a branch named <code class="sba-inline">feat/*</code>, <code class="sba-inline">fix/*</code> or <code class="sba-inline">chore/*</code>',
            'Open a Pull Request from day one (even with partial work) and mark it Draft',
            'At least one reviewer must approve',
            'Squash-merge into main; delete the branch',
            'Tag releases with semantic versions (<code class="sba-inline">v1.2.0</code>)',
        ]));

    $parts[] = $T::slide(20, $total, 'Hands-On Lab',
        $T::numberedList([
            'Create a GitHub repo called <code class="sba-inline">ai-fullstack-playground</code>',
            'Clone it locally',
            'Create <code class="sba-inline">hello.html</code>, commit, push',
            'Open a branch <code class="sba-inline">feat/fancy-title</code>, change the title, commit, push',
            'Open a Pull Request from GitHub\'s UI — write a proper description',
            'Squash-merge it and delete the branch',
            'Pull locally: <code class="sba-inline">git checkout main &amp;&amp; git pull</code>',
        ]));

    $parts[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Git tracks history, GitHub is the social layer on top',
        'Branch for every feature, PR for every merge, CI for every push',
        'Conventional commits + AI-generated messages = cleaner history',
        'Merge conflicts are just "pick which version to keep" — AI can help',
        'Never commit secrets — and rotate them immediately if you do',
    ]), 'sba-recap');

    $parts[] = $T::slide(22, $total, 'Up Next — Lesson 5',
        $T::lead('Foundations complete! Now we step into the browser with <b>HTML5 — semantic markup &amp; accessible structure with AI</b>.'));

    return $T::deckOpen() . implode("\n", $parts) . $T::deckClose();
}
