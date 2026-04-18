<?php
/**
 * Professional Slide Template Engine — INLINE STYLES edition
 * The LMS sanitizer strips <style> and <link> tags, so every rule is inline.
 */

class SlideTemplate
{
    private const LOGO_URL = 'https://swissbridgeacademy.com/public/uploads/light_logo/lightlogo-1773741888.png';

    // Shared style strings
    private const FONT = "font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Inter',sans-serif;";
    private const DECK_WRAPPER = "max-width:100%;margin:0 auto;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Inter',sans-serif;line-height:1.7;color:#e2e8f0;";

    private const SLIDE_BASE = "background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);border:1px solid #334155;border-radius:16px;padding:48px 40px;margin:24px 0;position:relative;min-height:400px;box-shadow:0 10px 40px rgba(0,0,0,0.3);overflow:hidden;color:#e2e8f0;";
    private const SLIDE_ACCENT_BAR = "position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#6366f1,#ec4899,#06b6d4);";
    private const SLIDE_NUM = "position:absolute;top:20px;right:24px;background:rgba(99,102,241,0.15);color:#a5b4fc;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:700;border:1px solid rgba(99,102,241,0.3);";
    private const SLIDE_FOOTER = "margin-top:32px;padding-top:12px;border-top:1px solid #334155;display:flex;justify-content:space-between;align-items:center;font-size:12px;color:#94a3b8;";

    private const TITLE = "font-size:30px;font-weight:800;color:#ffffff;margin:0 0 24px 0;padding-bottom:16px;border-bottom:3px solid #6366f1;display:inline-block;";
    private const P = "font-size:16px;color:#cbd5e1;margin:0 0 16px 0;line-height:1.7;";
    private const LEAD = "font-size:18px;color:#e2e8f0;line-height:1.7;margin:0 0 20px 0;";

    private const CODE_PRE = "background:#020617;border:1px solid #334155;border-radius:10px;padding:20px;overflow-x:auto;font-family:'Fira Code','Cascadia Code',Consolas,monospace;font-size:14px;line-height:1.6;color:#e2e8f0;margin:16px 0;position:relative;white-space:pre;";
    private const CODE_LANG = "position:absolute;top:10px;right:14px;background:#6366f1;color:#fff;padding:2px 10px;border-radius:4px;font-size:11px;font-weight:700;text-transform:uppercase;font-family:-apple-system,sans-serif;";
    private const CODE_INLINE = "background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);color:#a5b4fc;padding:2px 8px;border-radius:4px;font-size:0.9em;font-family:'Fira Code',Consolas,monospace;";

    public static function deckOpen(): string
    {
        return '<div style="' . self::DECK_WRAPPER . '">';
    }

    public static function deckClose(): string
    {
        return '</div>';
    }

    /**
     * COVER slide.
     */
    public static function cover(int $lessonNumber, int $totalLessons, string $title, string $subtitle, string $module, string $duration): string
    {
        $logo = self::LOGO_URL;
        $coverStyle = "background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 40%,#db2777 100%);border-radius:16px;padding:72px 48px;margin:24px 0;min-height:560px;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;position:relative;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.4);";
        $badgeStyle = "display:inline-block;padding:8px 20px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);border-radius:30px;font-size:13px;font-weight:700;letter-spacing:2px;color:#fff;margin-bottom:24px;";
        $titleStyle = "font-size:40px;font-weight:800;color:#fff;margin:12px 0;line-height:1.2;max-width:900px;";
        $subtitleStyle = "font-size:18px;color:rgba(255,255,255,0.9);max-width:720px;margin:16px 0 32px 0;line-height:1.6;";
        $metaRow = "display:flex;gap:16px;margin-top:24px;flex-wrap:wrap;justify-content:center;";
        $metaItem = "background:rgba(255,255,255,0.12);padding:14px 22px;border-radius:12px;border:1px solid rgba(255,255,255,0.2);min-width:110px;";
        $metaStrong = "display:block;font-size:22px;color:#fff;font-weight:800;";
        $metaSpan = "font-size:11px;color:rgba(255,255,255,0.75);text-transform:uppercase;letter-spacing:1px;";
        return <<<HTML
<section style="{$coverStyle}">
  <img src="{$logo}" alt="Swiss Bridge Academy" style="height:52px;margin-bottom:28px;filter:brightness(0) invert(1);">
  <div style="{$badgeStyle}">LESSON {$lessonNumber} / {$totalLessons}</div>
  <h1 style="{$titleStyle}">{$title}</h1>
  <p style="{$subtitleStyle}">{$subtitle}</p>
  <div style="{$metaRow}">
    <div style="{$metaItem}"><strong style="{$metaStrong}">{$duration}</strong><span style="{$metaSpan}">Duration</span></div>
    <div style="{$metaItem}"><strong style="{$metaStrong}">{$module}</strong><span style="{$metaSpan}">Module</span></div>
    <div style="{$metaItem}"><strong style="{$metaStrong}">English</strong><span style="{$metaSpan}">Language</span></div>
    <div style="{$metaItem}"><strong style="{$metaStrong}">Hands-on</strong><span style="{$metaSpan}">Format</span></div>
  </div>
</section>
HTML;
    }

    /**
     * Standard content slide.
     */
    public static function slide(int $num, int $total, string $title, string $bodyHtml, string $variant = ''): string
    {
        $logo = self::LOGO_URL;
        $base = self::SLIDE_BASE;
        if ($variant === 'recap') {
            $base = "background:linear-gradient(135deg,#064e3b 0%,#065f46 100%);border:1px solid rgba(16,185,129,0.4);border-radius:16px;padding:48px 40px;margin:24px 0;position:relative;min-height:400px;box-shadow:0 10px 40px rgba(0,0,0,0.3);overflow:hidden;color:#e2e8f0;";
        }
        $accent = self::SLIDE_ACCENT_BAR;
        $number = self::SLIDE_NUM;
        $title_s = self::TITLE;
        $footer = self::SLIDE_FOOTER;
        return <<<HTML
<section style="{$base}">
  <div style="{$accent}"></div>
  <div style="{$number}">Slide {$num} / {$total}</div>
  <h2 style="{$title_s}">{$title}</h2>
  {$bodyHtml}
  <div style="{$footer}">
    <span>Swiss Bridge Academy — AI-Powered Full Stack Bootcamp</span>
    <img src="{$logo}" alt="logo" style="height:22px;opacity:0.8;">
  </div>
</section>
HTML;
    }

    public static function lead(string $text): string { return '<p style="' . self::LEAD . '">' . $text . '</p>'; }
    public static function paragraph(string $text): string { return '<p style="' . self::P . '">' . $text . '</p>'; }

    public static function heroImage(string $imageUrl, string $alt = ''): string
    {
        return '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($alt, ENT_QUOTES) . '" style="width:100%;max-height:280px;object-fit:cover;border-radius:12px;margin:16px 0;border:1px solid #334155;">';
    }

    public static function unsplashImage(string $keywords, string $alt = ''): string
    {
        $q = urlencode(strtolower(str_replace(' ', ',', $keywords)));
        return self::heroImage("https://source.unsplash.com/1200x600/?{$q}", $alt);
    }

    public static function bulletList(array $items): string
    {
        $ul = '<ul style="list-style:none;padding:0;margin:16px 0;">';
        foreach ($items as $i) {
            $ul .= '<li style="padding:12px 16px 12px 44px;margin:8px 0;background:rgba(255,255,255,0.04);border-left:3px solid #6366f1;border-radius:8px;position:relative;font-size:15px;color:#e2e8f0;">'
                . '<span style="position:absolute;left:16px;color:#a5b4fc;font-weight:900;font-size:18px;">&#9654;</span>'
                . $i . '</li>';
        }
        return $ul . '</ul>';
    }

    public static function numberedList(array $items): string
    {
        $ol = '<ol style="padding:0;margin:16px 0;list-style:none;counter-reset:sba;">';
        $n = 0;
        foreach ($items as $i) {
            $n++;
            $ol .= '<li style="position:relative;padding:14px 14px 14px 60px;margin:10px 0;background:rgba(255,255,255,0.04);border-radius:8px;font-size:15px;color:#e2e8f0;">'
                . '<span style="position:absolute;left:14px;top:14px;background:linear-gradient(135deg,#6366f1,#ec4899);color:#fff;width:30px;height:30px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:13px;">' . $n . '</span>'
                . $i . '</li>';
        }
        return $ol . '</ol>';
    }

    public static function codeBlock(string $code, string $lang = 'js'): string
    {
        $escaped = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
        $pre = self::CODE_PRE;
        $labelStyle = self::CODE_LANG;
        return '<div style="position:relative;margin:16px 0;">'
            . '<span style="' . $labelStyle . '">' . htmlspecialchars($lang) . '</span>'
            . '<pre style="' . $pre . '">' . $escaped . '</pre>'
            . '</div>';
    }

    public static function callout(string $type, string $title, string $text): string
    {
        $colors = [
            'info'    => ['#06b6d4', 'rgba(6,182,212,0.08)'],
            'warning' => ['#f59e0b', 'rgba(245,158,11,0.08)'],
            'success' => ['#10b981', 'rgba(16,185,129,0.08)'],
            'danger'  => ['#ef4444', 'rgba(239,68,68,0.08)'],
        ];
        [$border, $bg] = $colors[$type] ?? $colors['info'];
        return '<div style="padding:16px 20px;border-radius:10px;margin:16px 0;border-left:4px solid ' . $border . ';background:' . $bg . ';font-size:15px;color:#e2e8f0;">'
            . '<strong style="color:#fff;display:block;margin-bottom:6px;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">' . $title . '</strong>'
            . $text . '</div>';
    }

    public static function quote(string $text, string $author = ''): string
    {
        $cite = $author ? '<cite style="display:block;font-size:14px;color:#94a3b8;font-style:normal;margin-top:10px;">— ' . $author . '</cite>' : '';
        return '<blockquote style="font-size:20px;font-style:italic;color:#fff;padding:24px 32px;background:rgba(99,102,241,0.08);border-left:4px solid #6366f1;border-radius:10px;margin:20px 0;line-height:1.5;">&ldquo;' . $text . '&rdquo;' . $cite . '</blockquote>';
    }

    public static function cardGrid(array $cards, int $cols = 2): string
    {
        $gridCols = $cols === 3 ? 'repeat(3,1fr)' : 'repeat(2,1fr)';
        $grid = '<div style="display:grid;grid-template-columns:' . $gridCols . ';gap:16px;margin:20px 0;">';
        $accents = [
            'sba-pink'  => '#ec4899',
            'sba-cyan'  => '#06b6d4',
            'sba-green' => '#10b981',
        ];
        foreach ($cards as $c) {
            $color = $c['color'] ?? '';
            $borderColor = $accents[$color] ?? '#6366f1';
            $bg = 'rgba(99,102,241,0.08)';
            if ($color === 'sba-pink')  $bg = 'rgba(236,72,153,0.08)';
            if ($color === 'sba-cyan')  $bg = 'rgba(6,182,212,0.08)';
            if ($color === 'sba-green') $bg = 'rgba(16,185,129,0.08)';
            $icon = isset($c['icon']) ? '<div style="font-size:28px;margin-bottom:10px;">' . $c['icon'] . '</div>' : '';
            $grid .= '<div style="background:' . $bg . ';border:1px solid ' . $borderColor . '40;border-radius:12px;padding:20px;">'
                . $icon
                . '<h4 style="font-size:17px;color:#fff;margin:0 0 8px 0;font-weight:700;">' . $c['title'] . '</h4>'
                . '<p style="font-size:14px;margin:0;color:#cbd5e1;line-height:1.6;">' . $c['text'] . '</p>'
                . '</div>';
        }
        return $grid . '</div>';
    }

    public static function table(array $headers, array $rows): string
    {
        $t = '<table style="width:100%;border-collapse:collapse;margin:16px 0;background:rgba(255,255,255,0.03);border-radius:10px;overflow:hidden;">';
        $t .= '<thead><tr>';
        foreach ($headers as $h) {
            $t .= '<th style="background:#6366f1;color:#fff;padding:12px 16px;text-align:left;font-size:14px;font-weight:700;">' . $h . '</th>';
        }
        $t .= '</tr></thead><tbody>';
        foreach ($rows as $row) {
            $t .= '<tr>';
            foreach ($row as $cell) {
                $t .= '<td style="padding:10px 16px;border-top:1px solid #334155;font-size:14px;color:#cbd5e1;">' . $cell . '</td>';
            }
            $t .= '</tr>';
        }
        return $t . '</tbody></table>';
    }

    public static function sectionHeading(string $text): string
    {
        return '<h3 style="font-size:22px;color:#a5b4fc;margin:24px 0 12px 0;font-weight:700;">' . $text . '</h3>';
    }
}
