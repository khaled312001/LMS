<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentProgressController extends Controller
{
    /**
     * Convert a "HH:MM:SS" duration string to total seconds.
     */
    private function durationToSeconds($duration): int
    {
        if (empty($duration)) {
            return 0;
        }
        $parts = explode(':', $duration);
        if (count($parts) !== 3) {
            return 0;
        }
        return ((int) $parts[0] * 3600) + ((int) $parts[1] * 60) + (int) $parts[2];
    }

    /**
     * Format a number of seconds into a short human label, e.g. "2h 15m" or "12m".
     */
    public static function humanDuration(int $seconds): string
    {
        if ($seconds <= 0) {
            return '0m';
        }
        $h = intdiv($seconds, 3600);
        $m = intdiv($seconds % 3600, 60);
        if ($h > 0) {
            return $h . 'h ' . $m . 'm';
        }
        if ($m > 0) {
            return $m . 'm';
        }
        return $seconds . 's';
    }

    /**
     * Level 1 — overview of every course with enrollment count and average
     * student progress.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));

        $query = DB::table('courses')->select('id', 'title', 'thumbnail', 'status', 'language', 'is_paid');
        if ($search !== '') {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Enrollment counts per course
        $enrollCounts = DB::table('enrollments')
            ->select('course_id', DB::raw('COUNT(DISTINCT user_id) as cnt'))
            ->groupBy('course_id')->pluck('cnt', 'course_id');

        // Order: most enrolled first, then newest
        $courses = $query->orderByDesc('id')->paginate(12)->appends($request->query());

        $courseIds = collect($courses->items())->pluck('id')->all();

        // Lesson counts per course (only the courses on this page)
        $lessonCounts = DB::table('lessons')->whereIn('course_id', $courseIds)
            ->select('course_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('course_id')->pluck('cnt', 'course_id');

        // All watch_histories for these courses, to compute average progress
        $histories = DB::table('watch_histories')->whereIn('course_id', $courseIds)
            ->select('course_id', 'completed_lesson')->get()->groupBy('course_id');

        $stats = [];
        foreach ($courseIds as $cid) {
            $totalLessons = (int) ($lessonCounts[$cid] ?? 0);
            $enrolled     = (int) ($enrollCounts[$cid] ?? 0);

            $progressSum = 0;
            $progressN   = 0;
            foreach (($histories[$cid] ?? collect()) as $h) {
                $completed = json_decode($h->completed_lesson, true);
                $completed = is_array($completed) ? count($completed) : 0;
                $p = $totalLessons > 0 ? min(100, ($completed / $totalLessons) * 100) : 0;
                $progressSum += $p;
                $progressN++;
            }
            $avgProgress = $progressN > 0 ? round($progressSum / $progressN) : 0;

            $stats[$cid] = [
                'enrolled'      => $enrolled,
                'total_lessons' => $totalLessons,
                'avg_progress'  => $avgProgress,
                'active_learners' => $progressN,
            ];
        }

        $page_data['courses'] = $courses;
        $page_data['stats']   = $stats;
        $page_data['search']  = $search;
        return view('admin.report.student_progress', $page_data);
    }

    /**
     * Level 2 — per-course breakdown of every enrolled student's progress.
     */
    public function course(Request $request, $id)
    {
        $course = DB::table('courses')->where('id', $id)->first();
        if (! $course) {
            abort(404);
        }

        // Lessons of this course: id => duration(seconds)
        $lessons = DB::table('lessons')->where('course_id', $id)->get(['id', 'duration']);
        $lessonDuration = [];
        foreach ($lessons as $l) {
            $lessonDuration[$l->id] = $this->durationToSeconds($l->duration);
        }
        $totalLessons = count($lessons);
        $courseTotalSeconds = array_sum($lessonDuration);

        // Enrolled students
        $search = trim((string) $request->get('search', ''));
        $enrollQuery = DB::table('enrollments')
            ->join('users', 'users.id', '=', 'enrollments.user_id')
            ->where('enrollments.course_id', $id)
            ->select('users.id as user_id', 'users.name', 'users.email', 'users.photo', 'enrollments.entry_date', 'enrollments.expiry_date');
        if ($search !== '') {
            $enrollQuery->where(function ($q) use ($search) {
                $q->where('users.name', 'like', '%' . $search . '%')
                  ->orWhere('users.email', 'like', '%' . $search . '%');
            });
        }
        $students = $enrollQuery->orderBy('enrollments.entry_date', 'desc')->paginate(15)->appends($request->query());

        $studentIds = collect($students->items())->pluck('user_id')->all();

        // Watch histories for these students keyed by student
        $histories = DB::table('watch_histories')->where('course_id', $id)
            ->whereIn('student_id', $studentIds)->get()->keyBy('student_id');

        // Watch durations for these students, grouped by student
        $durations = DB::table('watch_durations')->where('watched_course_id', $id)
            ->whereIn('watched_student_id', $studentIds)
            ->get(['watched_student_id', 'watched_lesson_id', 'current_duration', 'updated_at'])
            ->groupBy('watched_student_id');

        $rows = [];
        foreach ($students as $s) {
            $h = $histories[$s->user_id] ?? null;
            $completedIds = $h ? (json_decode($h->completed_lesson, true) ?: []) : [];
            $completedIds = is_array($completedIds) ? array_intersect($completedIds, array_keys($lessonDuration)) : [];
            $completedCount = count($completedIds);

            $watchedSeconds = 0;
            $lastActivity   = $h->updated_at ?? null;
            foreach (($durations[$s->user_id] ?? collect()) as $d) {
                $pos = (int) $d->current_duration;
                $cap = $lessonDuration[$d->watched_lesson_id] ?? $pos;
                $watchedSeconds += ($cap > 0) ? min($pos, $cap) : $pos;
                if ($d->updated_at && (! $lastActivity || $d->updated_at > $lastActivity)) {
                    $lastActivity = $d->updated_at;
                }
            }

            $progress = $totalLessons > 0 ? min(100, round(($completedCount / $totalLessons) * 100)) : 0;

            $rows[] = [
                'user_id'        => $s->user_id,
                'name'           => $s->name,
                'email'          => $s->email,
                'photo'          => $s->photo,
                'entry_date'     => $s->entry_date,
                'completed'      => $completedCount,
                'total_lessons'  => $totalLessons,
                'progress'       => $progress,
                'watched_label'  => self::humanDuration($watchedSeconds),
                'watched_seconds' => $watchedSeconds,
                'last_activity'  => $lastActivity,
                'is_completed'   => $totalLessons > 0 && $completedCount >= $totalLessons,
            ];
        }

        $page_data['course']         = $course;
        $page_data['students']       = $students;
        $page_data['rows']           = $rows;
        $page_data['total_lessons']  = $totalLessons;
        $page_data['course_total_label'] = self::humanDuration($courseTotalSeconds);
        $page_data['search']         = $search;
        return view('admin.report.student_progress_course', $page_data);
    }

    /**
     * Level 3 — one student's per-lesson breakdown inside a course.
     */
    public function student(Request $request, $course_id, $student_id)
    {
        $course  = DB::table('courses')->where('id', $course_id)->first();
        $student = DB::table('users')->where('id', $student_id)->first();
        if (! $course || ! $student) {
            abort(404);
        }

        // Sections + lessons ordered as the player shows them
        $sections = DB::table('sections')->where('course_id', $course_id)->orderBy('sort')->get();
        $lessons  = DB::table('lessons')->where('course_id', $course_id)->orderBy('sort')->get();

        $h = DB::table('watch_histories')->where('course_id', $course_id)
            ->where('student_id', $student_id)->first();
        $completedIds = $h ? (json_decode($h->completed_lesson, true) ?: []) : [];
        $completedIds = is_array($completedIds) ? $completedIds : [];

        $durations = DB::table('watch_durations')->where('watched_course_id', $course_id)
            ->where('watched_student_id', $student_id)
            ->get(['watched_lesson_id', 'current_duration', 'updated_at'])
            ->keyBy('watched_lesson_id');

        $totalLessons   = $lessons->count();
        $completedCount = count(array_intersect($completedIds, $lessons->pluck('id')->all()));
        $watchedSeconds = 0;

        $lessonsBySection = $lessons->groupBy('section_id');
        $sectionData = [];
        foreach ($sections as $section) {
            $sectionLessons = [];
            foreach (($lessonsBySection[$section->id] ?? collect()) as $lesson) {
                $durSec = $this->durationToSeconds($lesson->duration);
                $d      = $durations[$lesson->id] ?? null;
                $pos    = $d ? (int) $d->current_duration : 0;
                $watched = $durSec > 0 ? min($pos, $durSec) : $pos;
                $watchedSeconds += $watched;

                $sectionLessons[] = [
                    'title'         => $lesson->title,
                    'type'          => $lesson->lesson_type,
                    'duration_label' => self::humanDuration($durSec),
                    'watched_label' => self::humanDuration($watched),
                    'watched_pct'   => $durSec > 0 ? min(100, round(($watched / $durSec) * 100)) : ($pos > 0 ? 100 : 0),
                    'is_completed'  => in_array($lesson->id, $completedIds),
                    'last_activity' => $d->updated_at ?? null,
                ];
            }
            $sectionData[] = [
                'title'   => $section->title,
                'lessons' => $sectionLessons,
            ];
        }

        $page_data['course']          = $course;
        $page_data['student']         = $student;
        $page_data['section_data']    = $sectionData;
        $page_data['total_lessons']   = $totalLessons;
        $page_data['completed_count'] = $completedCount;
        $page_data['progress']        = $totalLessons > 0 ? min(100, round(($completedCount / $totalLessons) * 100)) : 0;
        $page_data['watched_label']   = self::humanDuration($watchedSeconds);
        return view('admin.report.student_progress_student', $page_data);
    }
}
