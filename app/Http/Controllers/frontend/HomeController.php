<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Builder_page;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Message;
use App\Models\Message_code;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;

use App\Http\Controllers\NewsletterController;

class HomeController extends Controller
{
    function homepage_switcher($id){
        session(['home' => $id]);
        return redirect(route('home'));
    }

    public function index()
    {
        $current_lang = strtolower(session('language') ?? get_settings('language'));

        $page_data = \Illuminate\Support\Facades\Cache::remember(
            'home:index_payload:' . $current_lang,
            600,
            function () use ($current_lang) {
                $blog_query = Blog::where('status', 1);
                if (in_array($current_lang, ['english', 'arabic'])) {
                    $blog_query->where('language', $current_lang);
                }
                return [
                    'blogs'      => $blog_query->orderBy('is_popular', 'desc')->orderBy('id', 'desc')->take(3)->get(),
                    'reviews'    => Review::orderBy('id', 'desc')->take(12)->get(),
                    'instructor' => User::where('role', 'instructor')
                        ->whereIn('id', \DB::table('courses')->select('user_id'))
                        ->take(4)->get(),
                    'category'   => Category::take(8)->get(),
                ];
            }
        );

        return view('components.home_permanent_templates.professional_landing', $page_data);
    }

    public function download_certificate($identifier)
    {
        $certificate = Certificate::where('identifier', $identifier);
        if ($certificate->count() > 0) {
            $qr_code_content_value = route('certificate', ['identifier' => $identifier]);
            $qrcode                = QrCode::size(300)->generate($qr_code_content_value);

            $page_data['certificate'] = $certificate->first();
            $page_data['qrcode']      = $qrcode;
            return view('curriculum.certificate.download', $page_data);
        } else {
            return redirect(route('home'))->with('error', get_phrase('Certificate not found at this url'));
        }
    }

    public function update_watch_history_with_duration(Request $request)
    {
        $userId = auth()->user()->id;  // Get the logged-in user's ID
        $courseProgress = 0;
        $isCompleted = 0;

        // Retrieve and sanitize input data
        $courseId = htmlspecialchars($request->input('course_id'));
        $lessonId = htmlspecialchars($request->input('lesson_id'));
        $currentDuration = htmlspecialchars($request->input('current_duration'));

        // Fetch current watch history record
        $currentHistory = DB::table('watch_durations')
            ->where([
                'watched_course_id' => $courseId,
                'watched_lesson_id' => $lessonId,
                'watched_student_id' => $userId,
            ])
            ->first();

        // Fetch course details
        $courseDetails = DB::table('courses')->where('id', $courseId)->first();
        $dripContentSettings = json_decode($courseDetails->drip_content_settings, true);

        if ($currentHistory) {
            $watchedDurationArr = json_decode($currentHistory->watched_counter, true);
            if (!is_array($watchedDurationArr)) $watchedDurationArr = [];

            if (!in_array($currentDuration, $watchedDurationArr)) {
                array_push($watchedDurationArr, $currentDuration);
            }

            $watchedDurationJson = json_encode($watchedDurationArr);

            DB::table('watch_durations')
                ->where([
                    'watched_course_id' => $courseId,
                    'watched_lesson_id' => $lessonId,
                    'watched_student_id' => $userId,
                ])
                ->update([
                    'watched_counter' => $watchedDurationJson,
                    'current_duration' => $currentDuration,
                ]);
        } else {
            $watchedDurationArr = [$currentDuration];
            DB::table('watch_durations')->insert([
                'watched_course_id' => $courseId,
                'watched_lesson_id' => $lessonId,
                'watched_student_id' => $userId,
                'current_duration' => $currentDuration,
                'watched_counter' => json_encode($watchedDurationArr),
            ]);
        }

        if ($courseDetails->enable_drip_content != 1) {
            return response()->json([
                'lesson_id' => $lessonId,
                'course_progress' => null,
                'is_completed' => null
            ]);
        }

        // Fetch lesson details for duration calculations
        $lessonTotalDuration = DB::table('lessons')->where('id', $lessonId)->value('duration');
        $lessonTotalDurationArr = explode(':', $lessonTotalDuration);
        $lessonTotalSeconds = ($lessonTotalDurationArr[0] * 3600) + ($lessonTotalDurationArr[1] * 60) + $lessonTotalDurationArr[2];
        $currentTotalSeconds = count($watchedDurationArr) * 5;  // Assuming each increment represents 5 seconds

        // Drip content completion logic
        if ($dripContentSettings['lesson_completion_role'] == 'duration') {
            if ($currentTotalSeconds >= $dripContentSettings['minimum_duration']) {
                $isCompleted = 1;
            } elseif (($currentTotalSeconds + 4) >= $lessonTotalSeconds) {
                $isCompleted = 1;
            }
        } else {
            $requiredDuration = ($lessonTotalSeconds / 100) * $dripContentSettings['minimum_percentage'];
            if ($currentTotalSeconds >= $requiredDuration) {
                $isCompleted = 1;
            } elseif (($currentTotalSeconds + 4) >= $lessonTotalSeconds) {
                $isCompleted = 1;
            }
        }

        // Update course progress if the lesson is completed
        if ($isCompleted == 1) {
            $watchHistory = DB::table('watch_histories')
                ->where([
                    'course_id' => $courseId,
                    'student_id' => $userId,
                ])
                ->first();

            if ($watchHistory) {
                $lessonIds = json_decode($watchHistory->completed_lesson, true);
                $courseProgress = $watchHistory->course_progress;

                if (!is_array($lessonIds)) $lessonIds = [];

                if (!in_array($lessonId, $lessonIds)) {
                    array_push($lessonIds, $lessonId);
                    $totalLesson = DB::table('lessons')->where('course_id', $courseId)->count();
                    $courseProgress = (100 / $totalLesson) * count($lessonIds);

                    $completedDate = ($courseProgress >= 100 && !$watchHistory->completed_date)
                        ? time()
                        : $watchHistory->completed_date;

                    DB::table('watch_histories')
                        ->where('id', $watchHistory->id)
                        ->update([
                            'course_progress' => $courseProgress,
                            'completed_lesson' => json_encode($lessonIds),
                            'completed_date' => $completedDate,
                        ]);
                }
            }
        }

        // Return the response
        return response()->json([
            'lesson_id' => $lessonId,
            'course_progress' => round($courseProgress),
            'is_completed' => $isCompleted,
        ]);
    }

    public function sendEmailToAssignedAddresses()
    {
        // Accessing the method from NewsletterController
        $newsletterController = new NewsletterController();
        $response = $newsletterController->sendEmailToAssignedAddresses();
        
        if ($response) {
            return response($response);
        }
        return response('No response', 404); // Default response if no data
    }
}
