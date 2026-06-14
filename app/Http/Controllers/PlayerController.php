<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Forum;
use App\Models\Lesson;
use App\Models\Watch_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PlayerController extends Controller
{
    public function course_player(Request $request, $slug, $id = '')
    {
        $course = Course::where('slug', $slug)->firstOrNew();

        if (! $course->exists) {
            // Old slug fallback: slugs historically ended with "-{id}".
            if (preg_match('/-(\d+)$/', $slug, $slug_match)) {
                $course_by_id = Course::find($slug_match[1]);
                if ($course_by_id && $course_by_id->slug != $slug) {
                    return redirect()->route('course.player', ['slug' => $course_by_id->slug, 'id' => $id ?: null], 301);
                }
            }
            return redirect()->route('home');
        }

        // check if course is paid
        if ($course->is_paid && auth()->user()->role != 'admin') {
            if (auth()->user()->role == 'student') { // for student check enrollment status
                $enroll_status = enroll_status($course->id, auth()->user()->id);
                if ($enroll_status == 'expired') {
                    Session::flash('error', get_phrase('Your course accessibility has expired. You need to buy it again'));
                    return redirect()->route('course.details', ['slug' => $slug]);
                } elseif(! $enroll_status) {
                    Session::flash('error', get_phrase('Not registered for this course.'));
                    return redirect()->route('course.details', ['slug' => $slug]);
                }
            } elseif (auth()->user()->role == 'instructor') { // for instructor check who is course instructor
                if ($course->user_id != auth()->user()->id) {
                    Session::flash('error', get_phrase('Not valid instructor.'));
                    return redirect()->route('my.courses');
                }
            }
        }

        $check_lesson_history = Watch_history::where('course_id', $course->id)
            ->where('student_id', auth()->user()->id)->first();
        $first_lesson_of_course = Lesson::where('course_id', $course->id)->orderBy('sort', 'asc')->value('id');
        if ($id == '') {
            $id = $check_lesson_history->watching_lesson_id ?? $first_lesson_of_course;
        }

        // if user has any watched history or not
        if (! $check_lesson_history && $id > 0) {
            $data = [
                'course_id'          => $course->id,
                'student_id'         => auth()->user()->id,
                'watching_lesson_id' => $id,
                'completed_lesson'   => json_encode([])
            ];
            Watch_history::insert($data);
        }

        // when user plays a lesson, update that lesson id as watch history
        if ($id > 0) {
            Watch_history::where('course_id', $course->id)
                ->where('student_id', auth()->user()->id)
                ->update(['watching_lesson_id' => $id]);
        }

        $page_data['course_details'] = $course;
        $page_data['lesson_details'] = Lesson::where('id', $id)->firstOrNew();
        $page_data['history']        = Watch_history::where('course_id', $course->id)->where('student_id', auth()->user()->id)->first();

        $forum_query = Forum::join('users', 'forums.user_id', 'users.id')
            ->select('forums.*', 'users.name as user_name', 'users.photo as user_photo')
            ->latest('forums.id')
            ->where('forums.parent_id', 0)
            ->where('forums.course_id', $course->id);

        if (isset($_GET['search'])) {
            $forum_query->where(function ($query) use ($request) {
                $query->where('forums.title', 'like', '%' . $request->search . '%')->where('forums.description', 'like', '%' . $request->search . '%');
            });
        }

        $page_data['questions'] = $forum_query->get();

        return view('course_player.index', $page_data);
    }

    public function set_watch_history(Request $request)
    {
        $course     = Course::where('id', $request->course_id)->first();
        $enrollment = Enrollment::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();
        if (! $enrollment && (auth()->user()->role != 'admin' || ! is_course_instructor($course->id))) {
            Session::flash('error', get_phrase('Not registered for this course.'));
            return redirect()->back();
        }

        $data['course_id']  = $request->course_id;
        $data['student_id'] = auth()->user()->id;

        $total_lesson = Lesson::where('course_id', $request->course_id)->pluck('id')->toArray();

        $watch_history = Watch_history::where('course_id', $request->course_id)
            ->where('student_id', auth()->user()->id)->first();

        if (isset($watch_history) && $watch_history->id) {
            $lessons = (array) json_decode($watch_history->completed_lesson);
            if (! in_array($request->lesson_id, $lessons)) {
                array_push($lessons, $request->lesson_id);
            } else {
                while (($key = array_search($request->lesson_id, $lessons)) !== false) {
                    unset($lessons[$key]);
                }
            }

            $data['completed_lesson']   = json_encode($lessons);
            $data['watching_lesson_id'] = $request->lesson_id;
            $data['completed_date']     = (count($total_lesson) == count($lessons)) ? time() : null;
            Watch_history::where('course_id', $request->course_id)->where('student_id', auth()->user()->id)->update($data);
        } else {
            $lessons                    = [$request->lesson_id];
            $data['completed_lesson']   = json_encode($lessons);
            $data['watching_lesson_id'] = $request->lesson_id;
            $data['completed_date']     = (count($total_lesson) == count($lessons)) ? time() : null;
            Watch_history::insert($data);
        }

        if (progress_bar($request->course_id) >= 100) {
            $certificate = Certificate::where('user_id', auth()->user()->id)->where('course_id', $request->course_id);

            if ($certificate->count() == 0) {
                $certificate_data['user_id']    = auth()->user()->id;
                $certificate_data['course_id']  = $request->course_id;
                $certificate_data['identifier'] = random(12);
                $certificate_data['created_at'] = date('Y-m-d H:i:s');
                Certificate::insert($certificate_data);
            }
        }

        return redirect()->back();
    }

    /**
     * Idempotent auto-completion used by the player when a video finishes.
     * Unlike set_watch_history (a toggle), this only ever ADDS the lesson to the
     * completed list, so firing it repeatedly on "video ended" is safe. Returns
     * JSON so the player can refresh progress in place without a reload.
     */
    public function complete_lesson(Request $request)
    {
        $course = Course::where('id', $request->course_id)->first();
        if (! $course) {
            return response()->json(['status' => 'error', 'message' => 'course_not_found'], 404);
        }

        $enrollment = Enrollment::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();
        if (! $enrollment && (auth()->user()->role != 'admin' || ! is_course_instructor($course->id))) {
            return response()->json(['status' => 'not_enrolled'], 403);
        }

        $lesson_ids   = Lesson::where('course_id', $course->id)->pluck('id')->toArray();
        $total_lesson = count($lesson_ids);

        // Guard: only accept a lesson that actually belongs to this course
        if (! in_array((int) $request->lesson_id, array_map('intval', $lesson_ids))) {
            return response()->json(['status' => 'invalid_lesson'], 422);
        }

        $watch_history = Watch_history::where('course_id', $course->id)
            ->where('student_id', auth()->user()->id)->first();

        if ($watch_history) {
            $completed = json_decode($watch_history->completed_lesson, true);
            $completed = is_array($completed) ? $completed : [];
            $already   = in_array($request->lesson_id, $completed);
            if (! $already) {
                $completed[] = (int) $request->lesson_id;
            }
            Watch_history::where('id', $watch_history->id)->update([
                'completed_lesson'   => json_encode(array_values($completed)),
                'watching_lesson_id' => $request->lesson_id,
                'completed_date'     => ($total_lesson > 0 && count($completed) >= $total_lesson) ? time() : $watch_history->completed_date,
            ]);
        } else {
            $completed = [(int) $request->lesson_id];
            Watch_history::insert([
                'course_id'          => $course->id,
                'student_id'         => auth()->user()->id,
                'completed_lesson'   => json_encode($completed),
                'watching_lesson_id' => $request->lesson_id,
                'completed_date'     => ($total_lesson <= 1) ? time() : null,
            ]);
        }

        // Issue the certificate once the whole course is complete
        if (progress_bar($course->id) >= 100) {
            $certificate = Certificate::where('user_id', auth()->user()->id)->where('course_id', $course->id);
            if ($certificate->count() == 0) {
                Certificate::insert([
                    'user_id'    => auth()->user()->id,
                    'course_id'  => $course->id,
                    'identifier' => random(12),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $completed_count = count(array_intersect(array_map('intval', $completed), array_map('intval', $lesson_ids)));
        $progress_pct    = $total_lesson > 0 ? min(100, round(($completed_count / $total_lesson) * 100)) : 0;

        return response()->json([
            'status'          => 'completed',
            'completed_count' => $completed_count,
            'total_lessons'   => $total_lesson,
            'progress_pct'    => $progress_pct,
        ]);
    }

    public function prepend_watermark()
    {
        return view('course_player.watermark');
    }
}
