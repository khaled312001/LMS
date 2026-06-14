@if (isset($lesson_details->lesson_type))
    @if ($lesson_details->lesson_type == 'text')
        @php
            $sba_slide_content = removeScripts($lesson_details->attachment ?? '');
            $sba_section_count = substr_count((string) $sba_slide_content, '<section');
            $sba_is_carousel = $sba_section_count >= 2;
            $sba_is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';

            // Try to detect the lesson number (e.g. "الدرس 04:" or "Lesson 4:" or
            // "Lesson 04") so we can load the pre-built slide viewer file.
            $sba_slides_url = null;
            $sba_lesson_num = null;
            $sba_lesson_title = (string) ($lesson_details->title ?? '');
            if (preg_match('/(?:الدرس|lesson)\s*0*(\d{1,2})/iu', $sba_lesson_title, $m)) {
                $num = (int) $m[1];
                if ($num >= 1 && $num <= 24) {
                    $sba_lesson_num = $num;
                    $slides_path = public_path('slides/lesson_' . sprintf('%02d', $num) . '.html');
                    if (file_exists($slides_path)) {
                        $sba_slides_url = url('public/slides/lesson_' . sprintf('%02d', $num) . '.html');
                    }
                }
            }
        @endphp

        @if ($sba_slides_url)
            {{-- Premium slide viewer: loads the self-contained slide HTML in an iframe.
                 On mobile, the iframe takes the full viewport height minus the header
                 so the slide content has real space to breathe (no fixed aspect ratio). --}}
            <div class="sba-slide-frame-wrap" id="sbaSlideFrameWrap">
                <iframe
                    src="{{ $sba_slides_url }}{{ $sba_is_arabic ? '?rtl=1' : '' }}"
                    class="sba-slide-frame"
                    id="sbaSlideFrame"
                    title="{{ $sba_lesson_title }}"
                    loading="lazy"
                    allow="fullscreen"
                    allowfullscreen></iframe>
            </div>

            <style>
                .sba-slide-frame-wrap {
                    position: relative;
                    width: 100%;
                    height: 75vh;
                    min-height: 620px;
                    max-height: 900px;
                    border-radius: 20px;
                    overflow: hidden;
                    background: #0b1022;
                    box-shadow: 0 25px 50px -20px rgba(15, 23, 42, 0.5);
                    border: 1px solid rgba(99, 102, 241, 0.2);
                }

                .sba-slide-frame {
                    position: absolute;
                    inset: 0;
                    width: 100%;
                    height: 100%;
                    border: 0;
                    display: block;
                }

                /* === MOBILE: Pixel-precise height set by JS (no css height needed) ===
                   The wrapper is full-bleed (edge to edge) and its height is set
                   inline by syncHeight() based on real viewport measurements. */
                @media (max-width: 991.98px) {
                    .sba-slide-frame-wrap {
                        position: relative;
                        width: 100vw;
                        margin-left: calc(50% - 50vw);
                        margin-right: calc(50% - 50vw);
                        min-height: 0 !important;
                        max-height: none !important;
                        border-radius: 0 !important;
                        border: none !important;
                        box-shadow: none !important;
                        aspect-ratio: auto !important;
                        /* Fallback in case JS hasn't run yet — large enough to be usable */
                        height: 80vh;
                    }
                }
            </style>

            <script>
            (function () {
                /* Set the iframe height to exactly fill the visible viewport below
                   the sticky header. Uses pixel values measured from the actual
                   DOM, not viewport units — this is the only approach that works
                   reliably on iOS Safari, Chrome Android, and Samsung Internet. */
                var wrap = document.getElementById('sbaSlideFrameWrap');
                if (!wrap) return;
                function isMobile() { return window.matchMedia('(max-width: 991.98px)').matches; }
                function syncHeight() {
                    if (!isMobile()) {
                        wrap.style.height = '';
                        wrap.style.width = '';
                        wrap.style.marginLeft = '';
                        wrap.style.marginRight = '';
                        return;
                    }
                    var header = document.querySelector('.playing-header-section') || document.querySelector('.sba-player-header');
                    var hH = header ? Math.ceil(header.getBoundingClientRect().height) : 60;
                    var vH = (window.visualViewport && window.visualViewport.height) || window.innerHeight || document.documentElement.clientHeight;
                    var target = Math.max(440, vH - hH);
                    wrap.style.height = target + 'px';
                }
                // Run multiple times — once now, after fonts load, after iframe loads,
                // and on every viewport change. Belt and suspenders.
                syncHeight();
                requestAnimationFrame(syncHeight);
                setTimeout(syncHeight, 100);
                setTimeout(syncHeight, 500);
                window.addEventListener('load', syncHeight);
                window.addEventListener('resize', syncHeight, { passive: true });
                window.addEventListener('orientationchange', function () { setTimeout(syncHeight, 200); });
                if (window.visualViewport) {
                    window.visualViewport.addEventListener('resize', syncHeight);
                }
                var f = document.getElementById('sbaSlideFrame');
                if (f) f.addEventListener('load', function () { setTimeout(syncHeight, 50); });
            })();
            </script>
        @elseif ($sba_is_carousel)
            <div class="course-video-area has-deck border-0">
                <div class="sba-slides-deck" id="sbaSlidesDeck" dir="{{ $sba_is_arabic ? 'rtl' : 'ltr' }}">
                    <div class="sba-slides-toolbar">
                        <div class="sba-slides-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            <span>{{ $sba_is_arabic ? 'عارض الشرائح' : get_phrase('Slide viewer') }}</span>
                        </div>
                        <div class="sba-slides-indicator">
                            <span id="sbaSlideCurrent">1</span>
                            <span class="sba-slash">/</span>
                            <span id="sbaSlideTotal">{{ $sba_section_count }}</span>
                        </div>
                        <div class="sba-slides-actions">
                            <button type="button" class="sba-slides-action" id="sbaSlidesFullscreen" title="{{ $sba_is_arabic ? 'ملء الشاشة' : get_phrase('Fullscreen') }}">
                                <svg id="sbaFsIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3"></path><path d="M21 8V5a2 2 0 0 0-2-2h-3"></path><path d="M3 16v3a2 2 0 0 0 2 2h3"></path><path d="M16 21h3a2 2 0 0 0 2-2v-3"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="sba-slides-stage">
                        <button type="button" class="sba-slides-nav sba-slides-prev" id="sbaSlidesPrev" aria-label="{{ $sba_is_arabic ? 'السابق' : 'Previous' }}">
                            @if ($sba_is_arabic)
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            @endif
                        </button>

                        <div class="sba-slides-viewport" id="sbaSlidesViewport">
                            {!! $sba_slide_content !!}
                        </div>

                        <button type="button" class="sba-slides-nav sba-slides-next" id="sbaSlidesNext" aria-label="{{ $sba_is_arabic ? 'التالي' : 'Next' }}">
                            @if ($sba_is_arabic)
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            @endif
                        </button>
                    </div>

                    <div class="sba-slides-footer">
                        <div class="sba-slides-progress">
                            <div class="sba-slides-progress-bar" id="sbaSlidesProgressBar"></div>
                        </div>
                        <div class="sba-slides-dots" id="sbaSlidesDots"></div>
                    </div>
                </div>
            </div>

            <style>
                .sba-slides-deck {
                    border-radius: 24px;
                    overflow: hidden;
                    background: linear-gradient(155deg, #0f172a 0%, #1e1b4b 55%, #3b0764 100%);
                    box-shadow: 0 25px 50px -20px rgba(15, 23, 42, 0.5);
                    position: relative;
                    border: 1px solid rgba(255, 255, 255, 0.08);
                }

                .sba-slides-deck.is-fullscreen {
                    position: fixed;
                    inset: 0;
                    z-index: 10000;
                    border-radius: 0;
                    background: #0b1022;
                }

                .sba-slides-deck.is-fullscreen .sba-slides-viewport {
                    height: calc(100vh - 160px);
                }

                .sba-slides-toolbar {
                    display: flex;
                    align-items: center;
                    gap: 16px;
                    padding: 14px 22px;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                    background: rgba(255, 255, 255, 0.02);
                    color: #fff;
                }

                .sba-slides-title {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    font-weight: 700;
                    font-size: 0.95rem;
                    color: rgba(255, 255, 255, 0.9);
                }

                .sba-slides-title i {
                    color: #a5b4fc;
                    font-size: 1.1rem;
                }

                .sba-slides-indicator {
                    margin-inline-start: auto;
                    display: inline-flex;
                    align-items: baseline;
                    gap: 6px;
                    padding: 6px 16px;
                    background: rgba(255, 255, 255, 0.08);
                    border: 1px solid rgba(255, 255, 255, 0.12);
                    border-radius: 999px;
                    font-weight: 800;
                    color: #fff;
                    font-size: 0.9rem;
                }

                .sba-slides-indicator #sbaSlideCurrent {
                    color: #fbbf24;
                    font-size: 1rem;
                }

                .sba-slides-indicator .sba-slash {
                    color: rgba(255, 255, 255, 0.4);
                }

                .sba-slides-actions {
                    display: flex;
                    gap: 8px;
                }

                .sba-slides-action {
                    width: 36px;
                    height: 36px;
                    border-radius: 12px;
                    border: 1px solid rgba(255, 255, 255, 0.12);
                    background: rgba(255, 255, 255, 0.05);
                    color: #fff;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    transition: all 0.25s ease;
                }

                .sba-slides-action:hover {
                    background: rgba(255, 255, 255, 0.12);
                    transform: translateY(-1px);
                }

                .sba-slides-stage {
                    position: relative;
                    padding: 20px 60px;
                }

                .sba-slides-viewport {
                    position: relative;
                    border-radius: 18px;
                    min-height: 520px;
                    background: rgba(255, 255, 255, 0.02);
                    border: 1px solid rgba(255, 255, 255, 0.06);
                    overflow: hidden;
                }

                /* We don't touch the section's own layout — preserve its original
                   design (flex/grid/padding etc). We only toggle visibility by
                   mounting/unmounting it from the DOM via JS (see show()).
                   That keeps the original slide look intact. */
                .sba-slides-viewport section {
                    animation: sbaSlideIn 0.45s ease;
                }

                @keyframes sbaSlideIn {
                    from {
                        opacity: 0;
                        transform: translateY(14px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .sba-slides-nav {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 56px;
                    height: 56px;
                    border-radius: 50%;
                    border: 2px solid rgba(255, 255, 255, 0.15);
                    background: linear-gradient(135deg, #6366f1, #8b5cf6);
                    color: #fff;
                    font-size: 1.8rem;
                    display: inline-flex !important;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    box-shadow: 0 12px 30px -8px rgba(99, 102, 241, 0.7);
                    transition: transform 0.25s ease, box-shadow 0.25s ease, opacity 0.25s ease;
                    z-index: 5;
                    padding: 0;
                }

                .sba-slides-nav i {
                    line-height: 1;
                }

                .sba-slides-nav:hover {
                    transform: translateY(-50%) scale(1.08);
                    box-shadow: 0 14px 30px -8px rgba(99, 102, 241, 0.75);
                }

                .sba-slides-nav:disabled {
                    opacity: 0.35;
                    cursor: not-allowed;
                    filter: grayscale(0.3);
                }

                .sba-slides-prev {
                    inset-inline-start: 10px;
                }

                .sba-slides-next {
                    inset-inline-end: 10px;
                }

                .sba-slides-footer {
                    padding: 14px 22px 20px;
                    background: rgba(255, 255, 255, 0.02);
                    border-top: 1px solid rgba(255, 255, 255, 0.06);
                }

                .sba-slides-progress {
                    height: 4px;
                    border-radius: 999px;
                    background: rgba(255, 255, 255, 0.08);
                    overflow: hidden;
                    margin-bottom: 14px;
                }

                .sba-slides-progress-bar {
                    height: 100%;
                    width: 0%;
                    background: linear-gradient(90deg, #06b6d4, #8b5cf6, #ec4899);
                    border-radius: 999px;
                    transition: width 0.35s ease;
                }

                .sba-slides-dots {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 6px;
                }

                .sba-slides-dots button {
                    width: 10px;
                    height: 10px;
                    padding: 0;
                    border-radius: 50%;
                    border: none;
                    background: rgba(255, 255, 255, 0.18);
                    cursor: pointer;
                    transition: all 0.25s ease;
                }

                .sba-slides-dots button.is-active {
                    background: #fbbf24;
                    transform: scale(1.35);
                    box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2);
                }

                .sba-slides-dots button:hover {
                    background: rgba(255, 255, 255, 0.45);
                }

                /* === MOBILE: tall slide deck inside the normal flow ===
                   Stays inside the column (no full-bleed tricks), but takes
                   most of the viewport height so each slide has real space.
                   The JS at the end fine-tunes the exact height. */
                @media (max-width: 991.98px) {
                    .sba-slides-deck {
                        width: 100% !important;
                        margin: 0 0 14px !important;
                        border-radius: 14px !important;
                        border: 1px solid rgba(255,255,255,0.08) !important;
                        box-shadow: 0 14px 30px -16px rgba(15, 23, 42, 0.45) !important;
                        /* Use min-height (NOT height) so the deck is always visible
                           regardless of JS state. JS will set explicit pixel height. */
                        min-height: 78vh !important;
                        max-height: none !important;
                        height: auto !important;
                        display: flex !important;
                        flex-direction: column !important;
                        overflow: hidden;
                    }
                    .sba-slides-toolbar {
                        padding: 8px 14px;
                        gap: 8px;
                        flex-shrink: 0;
                    }
                    .sba-slides-title { font-size: 0.78rem; }
                    .sba-slides-title span { display: none; }
                    .sba-slides-indicator { padding: 3px 11px; font-size: 0.78rem; }
                    .sba-slides-action { width: 30px; height: 30px; }

                    /* Stage grows to fill the remaining space */
                    .sba-slides-stage {
                        flex: 1 1 auto;
                        padding: 10px 8px;
                        display: flex;
                        align-items: stretch;
                        min-height: 0;
                        position: relative;
                    }
                    .sba-slides-viewport {
                        flex: 1;
                        min-height: 0;
                        padding: 0 4px;
                        overflow-y: auto;
                        -webkit-overflow-scrolling: touch;
                        height: 100%;
                    }
                    .sba-slides-viewport > section,
                    .sba-slides-viewport section[data-sba-slide] {
                        min-height: 100% !important;
                        height: auto !important;
                    }

                    /* Nav arrows: smaller, positioned at bottom corners NOT center
                       (avoids overlap with header back button & gives slide the width). */
                    .sba-slides-nav {
                        position: absolute;
                        top: auto !important;
                        bottom: 6px;
                        transform: none !important;
                        width: 42px;
                        height: 42px;
                        font-size: 1.1rem;
                        border-width: 1.5px;
                        z-index: 10;
                    }
                    .sba-slides-nav:hover {
                        transform: scale(1.06) !important;
                    }
                    .sba-slides-prev { inset-inline-start: 8px; }
                    .sba-slides-next { inset-inline-end: 8px; }

                    /* Slide content responsive */
                    .sba-slides-viewport > section,
                    .sba-slides-viewport section * {
                        max-width: 100% !important;
                    }
                    .sba-slides-viewport section h1 { font-size: 1.5rem !important; line-height: 1.3 !important; }
                    .sba-slides-viewport section h2 { font-size: 1.2rem !important; line-height: 1.35 !important; }
                    .sba-slides-viewport section h3 { font-size: 1.05rem !important; line-height: 1.4 !important; }
                    .sba-slides-viewport section p,
                    .sba-slides-viewport section li,
                    .sba-slides-viewport section span:not([class*="badge"]) {
                        font-size: 0.94rem !important;
                        line-height: 1.6 !important;
                    }
                    .sba-slides-viewport section img,
                    .sba-slides-viewport section svg {
                        max-width: 100% !important;
                        height: auto !important;
                    }
                    /* Compress overly-padded slide sections */
                    .sba-slides-viewport section[style*="padding:72px"],
                    .sba-slides-viewport section[style*="padding: 72px"] {
                        padding: 32px 18px !important;
                    }
                    .sba-slides-viewport section[style*="padding:48px"],
                    .sba-slides-viewport section[style*="padding: 48px"] {
                        padding: 24px 14px !important;
                    }
                    .sba-slides-viewport section[style*="min-height:560px"],
                    .sba-slides-viewport section[style*="min-height: 560px"],
                    .sba-slides-viewport section[style*="min-height:400px"],
                    .sba-slides-viewport section[style*="min-height: 400px"] {
                        min-height: auto !important;
                    }

                    .sba-slides-footer {
                        padding: 8px 12px 12px;
                        flex-shrink: 0;
                    }
                    .sba-slides-dots button { width: 7px; height: 7px; }
                    .sba-slides-progress { margin-bottom: 8px; }
                }

                @media (max-width: 480px) {
                    .sba-slides-deck { height: calc(100dvh - 60px); }
                    @supports not (height: 100dvh) {
                        .sba-slides-deck { height: calc(100vh - 60px); }
                    }
                    .sba-slides-nav {
                        width: 38px;
                        height: 38px;
                        font-size: 1rem;
                    }
                    .sba-slides-stage { padding: 8px 4px; }
                    .sba-slides-viewport section h1 { font-size: 1.3rem !important; }
                    .sba-slides-viewport section h2 { font-size: 1.1rem !important; }
                    .sba-slides-viewport section[style*="padding:72px"],
                    .sba-slides-viewport section[style*="padding: 72px"] {
                        padding: 24px 14px !important;
                    }
                }
            </style>

            <script>
                /* === Mobile deck height syncer ===
                   Same pattern as the iframe viewer above: measure the real
                   header height in pixels, then set the deck's height inline.
                   This is the only thing that works reliably across iOS / Android. */
                (function () {
                    var deck = document.getElementById('sbaSlidesDeck');
                    if (!deck) return;
                    function isMobile() { return window.matchMedia('(max-width: 991.98px)').matches; }
                    function syncDeckHeight() {
                        if (!isMobile()) {
                            deck.style.height = '';
                            return;
                        }
                        var header = document.querySelector('.playing-header-section') || document.querySelector('.sba-player-header');
                        var hH = header ? Math.ceil(header.getBoundingClientRect().height) : 60;
                        var vH = (window.visualViewport && window.visualViewport.height) || window.innerHeight || document.documentElement.clientHeight;
                        var target = Math.max(440, vH - hH);
                        deck.style.height = target + 'px';
                    }
                    syncDeckHeight();
                    requestAnimationFrame(syncDeckHeight);
                    setTimeout(syncDeckHeight, 100);
                    setTimeout(syncDeckHeight, 500);
                    window.addEventListener('load', syncDeckHeight);
                    window.addEventListener('resize', syncDeckHeight, { passive: true });
                    window.addEventListener('orientationchange', function () { setTimeout(syncDeckHeight, 200); });
                    if (window.visualViewport) {
                        window.visualViewport.addEventListener('resize', syncDeckHeight);
                    }
                })();

                (function() {
                    'use strict';

                    function initDeck() {
                        const deck = document.getElementById('sbaSlidesDeck');
                        if (!deck || deck.dataset.sbaInit === '1') return;
                        deck.dataset.sbaInit = '1';

                        const viewport = deck.querySelector('#sbaSlidesViewport');
                        if (!viewport) return;

                        // Accept sections at any nesting level, since the source HTML often
                        // wraps them in a parent <div>.
                        const slides = Array.from(viewport.querySelectorAll('section'));
                        if (!slides.length) return;

                        // Tag every slide so our CSS can hide them and enforce the rule
                        // over inline "display:flex" styles baked in the lesson HTML.
                        slides.forEach((s, i) => {
                            s.setAttribute('data-sba-slide', i);
                        });

                        const btnPrev = deck.querySelector('#sbaSlidesPrev');
                        const btnNext = deck.querySelector('#sbaSlidesNext');
                        const btnFs = deck.querySelector('#sbaSlidesFullscreen');
                        const lblCur = deck.querySelector('#sbaSlideCurrent');
                        const bar = deck.querySelector('#sbaSlidesProgressBar');
                        const dotsWrap = deck.querySelector('#sbaSlidesDots');
                        const isRtl = deck.getAttribute('dir') === 'rtl';

                        let current = 0;

                        // Build the dot row
                        dotsWrap.innerHTML = '';
                        slides.forEach((s, i) => {
                            const dot = document.createElement('button');
                            dot.type = 'button';
                            dot.setAttribute('aria-label', 'Slide ' + (i + 1));
                            dot.addEventListener('click', () => show(i));
                            dotsWrap.appendChild(dot);
                        });

                        function show(idx) {
                            if (idx < 0 || idx >= slides.length) return;
                            slides.forEach((s, i) => s.classList.toggle('is-active', i === idx));
                            Array.from(dotsWrap.children).forEach((d, i) => d.classList.toggle('is-active', i === idx));
                            lblCur.textContent = idx + 1;
                            bar.style.width = (((idx + 1) / slides.length) * 100) + '%';
                            if (btnPrev) btnPrev.disabled = idx === 0;
                            if (btnNext) btnNext.disabled = idx === slides.length - 1;
                            current = idx;
                            viewport.scrollTop = 0;
                        }

                        if (btnPrev) btnPrev.addEventListener('click', () => show(current - 1));
                        if (btnNext) btnNext.addEventListener('click', () => show(current + 1));

                        document.addEventListener('keydown', (e) => {
                            if (e.target && (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.isContentEditable)) return;
                            if (e.key === 'ArrowLeft') {
                                isRtl ? show(current + 1) : show(current - 1);
                            } else if (e.key === 'ArrowRight') {
                                isRtl ? show(current - 1) : show(current + 1);
                            }
                        });

                        // Swipe support
                        let touchStartX = 0;
                        viewport.addEventListener('touchstart', (e) => {
                            touchStartX = e.changedTouches[0].screenX;
                        }, { passive: true });
                        viewport.addEventListener('touchend', (e) => {
                            const dx = e.changedTouches[0].screenX - touchStartX;
                            if (Math.abs(dx) < 50) return;
                            const goNext = isRtl ? dx > 0 : dx < 0;
                            show(current + (goNext ? 1 : -1));
                        }, { passive: true });

                        if (btnFs) {
                            btnFs.addEventListener('click', () => {
                                deck.classList.toggle('is-fullscreen');
                                btnFs.innerHTML = deck.classList.contains('is-fullscreen')
                                    ? '<i class="fi-rr-compress"></i>'
                                    : '<i class="fi-rr-expand"></i>';
                            });
                        }

                        show(0);
                    }

                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initDeck);
                    } else {
                        initDeck();
                    }
                })();
            </script>
        @else
            <div class="course-video-area border-primary">
                <div class="text_show">
                    {!! $sba_slide_content !!}
                </div>
            </div>
        @endif
    @elseif ($lesson_details->lesson_type == 'video-url')
        @php
            $lesson_src = $lesson_details->lesson_src ?? '';
            // Filter out example.com and example.org URLs
            if (stripos($lesson_src, 'example.com') !== false || stripos($lesson_src, 'example.org') !== false) {
                $lesson_src = '';
            }
        @endphp
        @if (!empty($lesson_src))
        <div class="course-video-area border-primary border">
            <!-- Video -->
            <div class="course-video-wrap">
                <div id="player">
                    <iframe src="{{ $lesson_src }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                </div>
                @include('course_player.player_config')
            </div>
        </div>
        @else
        <div class="course-video-area border-primary border">
            <div class="alert alert-warning">
                {{ get_phrase('Invalid video source. Please update the lesson video URL.') }}
            </div>
        </div>
        @endif
    @elseif ($lesson_details->lesson_type == 'scorm')
        <div class="course-video-area">
            <div class="course-video-wrap">
                <div>
                    @if ($lesson_details->attachment_type == 'iSpring')
                        <iframe class="embed-responsive-item"
                            src="{{ asset('uploads/lesson_file/scorm_content/' . $lesson_details->attachment . '/res/index.html') }}"
                            allowfullscreen allowtransparency width="100%" height="100%" allow="autoplay"></iframe>
                    @elseif ($lesson_details->attachment_type == 'articulate')
                        <iframe class="embed-responsive-item"
                            src="{{ asset('uploads/lesson_file/scorm_content/' . $lesson_details->attachment . '/index.html') }}"
                            allowfullscreen allowtransparency width="100%" height="100%" allow="autoplay"></iframe>
                    @elseif ($lesson_details->attachment_type == 'adobeCaptivate')
                        <iframe class="embed-responsive-item"
                            src="{{ asset('uploads/lesson_file/scorm_content/' . $lesson_details->attachment . '/index.html') }}"
                            allowfullscreen allowtransparency width="100%" height="100%" allow="autoplay"></iframe>
                    @endif

                </div>
            </div>
        </div>
    @elseif($lesson_details->lesson_type == 'system-video')
        @php
            $watermark_type = get_player_settings('watermark_type');
            $lesson_video = $lesson_details->lesson_src;
            if ($watermark_type == 'ffmpeg') {
                $origin = dirname($lesson_details->lesson_src);
                $dir = $origin . '/watermark';
                $file = str_replace($origin, '', $lesson_details->lesson_src);
                $lesson_video = "{$dir}{$file}";
            }
        @endphp
        <div class="course-video-area border-primary border">
            <!-- Video -->
            <div class="course-video-wrap">
                <div class=" bd-r-10 mb-16 position-relative bg-light custom-system-video">
                    <video id="player" playsinline controls oncontextmenu="return false;">
                        {{-- <source src="{{ asset($lesson_details->lesson_src) }}" type="video/mp4"> --}}
                        <source src="{{ route('course.get_file', ['course_id' => $lesson_details->course_id, 'lesson_id' => $lesson_details->id]) }}" type="video/mp4">
                    </video>
                    @include('course_player.player_config')
                </div>
            </div>
        </div>
    @elseif($lesson_details->lesson_type == 'image')
        @php
            // $img = asset('uploads/lesson_file/attachment/' . $lesson_details->attachment);
            $img = route('course.get_file', ['course_id' => $lesson_details->course_id, 'lesson_id' => $lesson_details->id])
        @endphp
        <img width="100%" class="max-w-auto" height="auto" src="{{ $img }}" />
    @elseif($lesson_details->lesson_type == 'vimeo-url' && $lesson_details->video_type == 'vimeo')
        @php
            $video_url = $lesson_details->lesson_src;
            $video_id = explode('https://vimeo.com/', $video_url);
            $video_id = str_replace('https://vimeo.com/', '', $video_url);
        @endphp

        <div class="course-video-area border-primary border">
            <!-- Video -->
            <div class="course-video-wrap">
                <div id="player">
                    <iframe height="500" src="https://player.vimeo.com/video/{{ $video_id }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                    @include('course_player.player_config')
                </div>
            </div>
        </div>
    @elseif($lesson_details->lesson_type == 'google_drive')
        @php
            // Extract the Drive file id from any common URL format:
            // /file/d/{id}/view, open?id={id}, uc?id={id}, or a bare id
            $video_url = trim($lesson_details->lesson_src ?? '');
            $video_id = null;
            if (preg_match('~/d/([a-zA-Z0-9_-]{10,})~', $video_url, $drive_match)) {
                $video_id = $drive_match[1];
            } elseif (preg_match('~[?&]id=([a-zA-Z0-9_-]{10,})~', $video_url, $drive_match)) {
                $video_id = $drive_match[1];
            } elseif (preg_match('~^[a-zA-Z0-9_-]{10,}$~', $video_url)) {
                $video_id = $video_url;
            }
        @endphp
        @if ($video_id)
            {{-- Google Drive's own preview player: streams without any API key.
                 The file must be shared as "anyone with the link can view". --}}
            <div class="course-video-area border-primary border">
                <div class="course-video-wrap">
                    <div class="ratio ratio-16x9 bd-r-10 overflow-hidden bg-dark">
                        <iframe src="https://drive.google.com/file/d/{{ $video_id }}/preview"
                            allow="autoplay; encrypted-media" allowfullscreen
                            style="border: 0; width: 100%; height: 100%;"></iframe>
                    </div>
                </div>
            </div>
        @else
            <div class="course-video-area border-primary border">
                <div class="alert alert-warning">
                    {{ get_phrase('Invalid video source. Please update the lesson video URL.') }}
                </div>
            </div>
        @endif
    @elseif($lesson_details->lesson_type == 'html5')
        <div class="course-video-area border-primary border">
            <!-- Video -->
            <div class="course-video-wrap">
                <video width="100%" height="680" id="player" playsinline controls>
                    <source class="remove_video_src" src="{{ $lesson_details->lesson_src }}" type="video/mp4">
                </video>
                @include('course_player.player_config')
            </div>
        </div>
    @elseif($lesson_details->lesson_type == 'document_type')
            @php
                $src = route('course.get_file', ['course_id' => $lesson_details->course_id, 'lesson_id' => $lesson_details->id])
            @endphp
        @if ($lesson_details->attachment_type == 'pdf')
            {{-- <iframe class="embed-responsive-item" width="100%" src="{{ $src }}" allowfullscreen></iframe> --}}

            <iframe class="embed-responsive-item" width="100%" height="600px" src="{{ route('pdf_canvas', ['course_id' => $lesson_details->course_id, 'lesson_id' => $lesson_details->id]) }}" allowfullscreen></iframe>




        @elseif($lesson_details->attachment_type == 'doc' || $lesson_details->attachment_type == 'ppt')
            <iframe class="embed-responsive-item" width='100%' src="https://view.officeapps.live.com/op/embed.aspx?src={{ $src }}" frameborder='0'></iframe>
        @elseif($lesson_details->attachment_type == 'txt')
            <iframe class="embed-responsive-item" width='100%' src="{{ $src }}" frameborder='0'></iframe>
        @endif
    @elseif($lesson_details->lesson_type == 'quiz')
        <div class="course-video-area border-primary pb-5">
            @include('course_player.quiz.index')
        </div>
    @else
        @php
            $lesson_src = $lesson_details->lesson_src ?? '';
            // Filter out example.com and example.org URLs
            if (stripos($lesson_src, 'example.com') !== false || stripos($lesson_src, 'example.org') !== false) {
                $lesson_src = '';
            }
        @endphp
        @if (!empty($lesson_src))
        <iframe class="embed-responsive-item" width="100%" src="{{ $lesson_src }}" allowfullscreen></iframe>
        @else
        <div class="alert alert-warning">
            {{ get_phrase('Invalid content source. Please update the lesson source URL.') }}
        </div>
        @endif
    @endif
@endif

<script>
    // Disable right-click on the video element when present
    (function() {
        const el = document.getElementById('player');
        if (el) {
            el.oncontextmenu = function() { return false; };
        }
    })();
</script>