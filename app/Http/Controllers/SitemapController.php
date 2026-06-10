<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bootcamp;
use App\Models\Course;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = Cache::remember('sitemap_xml', 3600, function () {
            return $this->generate();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function generate()
    {
        $urls = [];

        // Static pages
        $static_routes = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('courses'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => route('blogs'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('bootcamps'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('about.us'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => route('contact.us'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => route('instructors'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['loc' => url('/faq'), 'priority' => '0.4', 'changefreq' => 'monthly'],
            ['loc' => url('/privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => url('/refund-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => url('/terms-and-condition'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => url('/cookie-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach ($static_routes as $route) {
            $urls[] = $route;
        }

        // Active courses
        $courses = Course::where('status', 'active')->whereNotNull('slug')->where('slug', '!=', '')
            ->orderBy('updated_at', 'desc')->get(['slug', 'updated_at']);
        foreach ($courses as $course) {
            $urls[] = [
                'loc' => route('course.details', $course->slug),
                'lastmod' => optional($course->updated_at)->toAtomString(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        }

        // Published blogs
        $blogs = Blog::where('status', 1)->whereNotNull('slug')->where('slug', '!=', '')
            ->orderBy('updated_at', 'desc')->get(['slug', 'updated_at']);
        foreach ($blogs as $blog) {
            $urls[] = [
                'loc' => route('blog.details', $blog->slug),
                'lastmod' => optional($blog->updated_at)->toAtomString(),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ];
        }

        // Active bootcamps
        $bootcamps = Bootcamp::where('status', 1)->whereNotNull('slug')->where('slug', '!=', '')
            ->orderBy('updated_at', 'desc')->get(['slug', 'updated_at']);
        foreach ($bootcamps as $bootcamp) {
            $urls[] = [
                'loc' => route('bootcamp.details', $bootcamp->slug),
                'lastmod' => optional($bootcamp->updated_at)->toAtomString(),
                'priority' => '0.6',
                'changefreq' => 'weekly',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1) . "</loc>\n";
            if (!empty($url['lastmod'])) {
                $xml .= '    <lastmod>' . $url['lastmod'] . "</lastmod>\n";
            }
            $xml .= '    <changefreq>' . $url['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return $xml;
    }

    public function robots()
    {
        $content = implode("\n", [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /admin/*',
            'Disallow: /instructor',
            'Disallow: /instructor/*',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /forgot-password',
            'Disallow: /my-courses',
            'Disallow: /cart',
            'Disallow: /checkout',
            'Disallow: /payment',
            'Disallow: /payment/*',
            'Disallow: /install/*',
            'Disallow: /modal/*',
            'Disallow: /clear-cache',
            'Allow: /',
            '',
            'Sitemap: ' . url('/sitemap.xml'),
            '',
        ]);

        return response($content, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
