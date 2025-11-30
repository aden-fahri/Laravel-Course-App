<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    // Tampilkan semua lesson di kursus
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        $lessons = $course->lessons()->orderBy('order')->get(); // pastikan orderBy

        $user = Auth::user();
        $isEnrolled = $user->enrolledCourses->contains($course->id);
        $isInstructor = $course->instructor_id === $user->id;
        $isAdmin = $user->role === 'admin';

        if (!$isEnrolled && !$isInstructor && !$isAdmin) {
            return redirect()->route('courses.index')
                ->withErrors('Anda harus terdaftar untuk melihat materi.');
        }

        return view('lessons.index', compact('course', 'lessons'));
    }

    // Form buat lesson baru
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);

        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->withErrors('Akses ditolak.');
        }

        return view('lessons.create', compact('course'));
    }

    // Simpan lesson
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'nullable|string',
            'video_url'   => 'nullable|url',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20480', // 20MB
            'has_assignment' => 'sometimes|boolean',
            'assignment_instruction' => 'nullable|string',
            'assignment_type' => 'nullable|in:file,text,link,mixed',
            'assignment_required' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'content', 'video_url']);

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('lessons/files', 'public');
        }

        // Handle tugas
        $data['assignment_instruction'] = $request->has_assignment ? $request->assignment_instruction : null;
        $data['assignment_type']        = $request->has_assignment ? $request->assignment_type : null;
        $data['assignment_required']    = $request->has_assignment ? ($request->assignment_required ? 1 : 0) : 0;

        $data['course_id'] = $courseId;
        $data['order']     = Lesson::where('course_id', $courseId)->max('order') + 1;

        Lesson::create($data);

        return redirect()->route('lessons.index', $courseId)
            ->with('success', 'Materi berhasil ditambahkan!');
    }

    // Edit lesson
    public function edit($courseId, $id)
    {
        $course = Course::findOrFail($courseId);
        $lesson = Lesson::findOrFail($id);

        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->withErrors('Akses ditolak.');
        }

        return view('lessons.edit', compact('course', 'lesson'));
    }

    // Update lesson
    public function update(Request $request, $courseId, $id)
    {
        $lesson = Lesson::findOrFail($id);

        if ($lesson->course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->withErrors('Akses ditolak.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'nullable|string',
            'video_url'   => 'nullable|url',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20480',
            'has_assignment' => 'sometimes|boolean',
            'assignment_instruction' => 'nullable|string',
            'assignment_type' => 'nullable|in:file,text,link,mixed',
            'assignment_required' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'content', 'video_url']);

        // Hapus file lama jika upload file baru
        if ($request->hasFile('file')) {
            if ($lesson->file_path) {
                Storage::disk('public')->delete($lesson->file_path);
            }
            $data['file_path'] = $request->file('file')->store('lessons/files', 'public');
        }

        // Update tugas
        $data['assignment_instruction'] = $request->has_assignment ? $request->assignment_instruction : null;
        $data['assignment_type']        = $request->has_assignment ? $request->assignment_type : null;
        $data['assignment_required']    = $request->has_assignment ? ($request->assignment_required ? 1 : 0) : 0;

        $lesson->update($data);

        return redirect()->route('lessons.index', $courseId)
            ->with('success', 'Materi berhasil diperbarui!');
    }

    // Hapus lesson
    public function destroy($courseId, $id)
    {
        $lesson = Lesson::findOrFail($id);

        if ($lesson->course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->withErrors('Akses ditolak.');
        }

        $lesson->delete();

        return redirect()->route('lessons.index', $courseId)->with('success', 'Materi dihapus!');
    }
}
