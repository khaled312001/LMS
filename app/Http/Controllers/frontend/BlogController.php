<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function index(Request $request, $category = '')
    {
        $category_row = BlogCategory::where('slug', $category)->first();
        $query = Blog::query();

        // Filter by current UI language so Arabic users see Arabic blogs only
        $current_lang = strtolower(session('language') ?? get_settings('language'));
        if (in_array($current_lang, ['english', 'arabic'])) {
            $query->where(function ($q) use ($current_lang) {
                $q->where('language', $current_lang)->orWhereNull('language');
            });
        }

        // search result
        if (request()->has('search')) {
            $search = request()->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        // if blog has category
        if ($category != '') {
            $query->where('category_id', $category_row->id);
        }

        $page_data['blogs'] = $query->latest('id')->paginate(6)->appends($request->query());
        $view_path          = 'frontend' . '.' . get_frontend_settings('theme') . '.blog.index';
        return view($view_path, $page_data);
    }

    public function blog_details($slug = null)
    {
        if (empty($slug)) {
            return redirect()->route('blogs');
        }
        $query = Blog::join('users', 'blogs.user_id', 'users.id')
            ->select(
                'blogs.*',
                'users.name as author_name',
                'users.email as author_email',
                'users.photo as author_photo',
                'users.skills as author_skills',
                'users.biography as author_biography',
                'users.facebook as author_facebook',
                'users.linkedin as author_linkedin',
                'users.twitter as author_twitter',
            )
            ->where('blogs.slug', $slug);

        // if selected blog doesn't exists return back page
        if ($query->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $blog_details               = $query->first();

        // Smart language redirect for blogs (mirrors the one in CourseController)
        $current_lang = strtolower(session('language') ?? get_settings('language'));
        $blog_lang    = strtolower($blog_details->language ?? 'english');
        if (in_array($current_lang, ['english', 'arabic']) && $current_lang !== $blog_lang && !empty($blog_details->pair_id)) {
            $twin = Blog::where('id', $blog_details->pair_id)->where('language', $current_lang)->first();
            if ($twin) {
                return redirect()->route('blog.details', $twin->slug);
            }
        }
        $page_data['blog_details']  = $blog_details;
        $page_data['blog_comments'] = BlogComment::join('users', 'blog_comments.user_id', '=', 'users.id')
            ->select('blog_comments.*', 'users.name as commentator_name', 'users.photo as commentator_photo')
            ->where('blog_comments.blog_id', $blog_details->id)
            ->where('blog_comments.parent_id', null)
            ->latest('id')->get();

        // Get related blogs — same category first, then other blogs.
        // Filter by the current blog's language so the related list stays consistent.
        $blog_lang_filter = strtolower($blog_details->language ?? 'english');

        $related_blogs = Blog::where('status', 1)
            ->where('id', '!=', $blog_details->id)
            ->where('language', $blog_lang_filter)
            ->where(function($query) use ($blog_details) {
                // Same category
                if ($blog_details->category_id) {
                    $query->where('category_id', $blog_details->category_id);
                }
            })
            ->latest('id')
            ->take(3)
            ->get();

        // If not enough blogs from same category, add more from other categories (same language)
        if ($related_blogs->count() < 3) {
            $additional_blogs = Blog::where('status', 1)
                ->where('id', '!=', $blog_details->id)
                ->where('language', $blog_lang_filter)
                ->whereNotIn('id', $related_blogs->pluck('id'))
                ->when($blog_details->category_id, function($query) use ($blog_details) {
                    $query->where('category_id', '!=', $blog_details->category_id);
                })
                ->latest('id')
                ->take(3 - $related_blogs->count())
                ->get();

            $related_blogs = $related_blogs->merge($additional_blogs);
        }

        $page_data['related_blogs'] = $related_blogs;

        $view_path = 'frontend' . '.' . get_frontend_settings('theme') . '.blog.details';
        return view($view_path, $page_data);
    }
}
