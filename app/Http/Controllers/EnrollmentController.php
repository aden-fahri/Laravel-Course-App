<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $alreadyEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->exists();

        if ($alreadyEnrolled) {
            return redirect()->back()->withErrors('Anda sudah terdaftar di kursus ini');
        }

        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
        ]);

        return redirect()->back()->with('success', 'berhasil mendaftar kursus ini');
    }

    public function destroy($courseId)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->firstOrFail();

        $enrollment->delete();

        return redirect()->back()->with('success', 'pendaftaran dibatalkan');
    }

    public function index($courseId)
    {
        $course = Course::with('students')->findOrFail($courseId);

        if ($course->instructor_id !== Auth::id() && auth::user()->role !== 'admin') {
            return redirect()->route('courses.index')->withErrors('akses ditolak');
        }

        return view('enrollments.index', compact('course'));
    }
}
