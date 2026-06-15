<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Bootcamp;
use App\Models\BootcampCategory;
use App\Models\BootcampModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BootcampController extends Controller
{
    public function index($category = '')
    {
        $query = Bootcamp::join('users', 'bootcamps.user_id', 'users.id')
            ->join('bootcamp_categories', 'bootcamps.category_id', 'bootcamp_categories.id')
            ->select('bootcamps.*', 'bootcamp_categories.slug as category_slug', 'users.name as instructor_name', 'users.email as instructor_email', 'users.photo as instructor_image')
            ->where('bootcamps.status', 1);

        if (request()->has('search')) {
            $query = $query->where('bootcamps.title', 'LIKE', '%' . request()->query('search') . '%');
        }

        if ($category) {
            $query->where('bootcamp_categories.slug', $category);
        }

        $page_data['bootcamps'] = $query->paginate(9)->appends(request()->query());
        
        $theme = get_frontend_settings('theme');
        if (empty($theme) || $theme === false) {
            $theme = 'default';
        }
        $view_path = 'frontend.' . $theme . '.bootcamp.index';
        return view($view_path, $page_data);
    }

    public function show($slug)
    {
        // bootcamp details
        $bootcamp = Bootcamp::where(['status' => 1, 'slug' => $slug]);
        if ($bootcamp->doesntExist()) {
            abort(404);
        }

        $bootcamp_details              = $bootcamp->first();
        $page_data['bootcamp_details'] = $bootcamp_details;
        $page_data['modules']          = BootcampModule::where('bootcamp_id', $bootcamp_details->id)->get() ?? collect([]);

        $theme = get_frontend_settings('theme');
        if (empty($theme) || $theme === false) {
            $theme = 'default';
        }
        $view_path = 'frontend.' . $theme . '.bootcamp.details';
        return view($view_path, $page_data);
    }
}
