<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')->latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'instructor_id' => Auth::id(),
        ]);

        return redirect()->route('courses.index')->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function show($id)
    {
        $course = Course::with(['instructor', 'lessons', 'enrollments'])->findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('courses.index')->withErrors('Akses ditolak.');
        }

        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('courses.index')->withErrors('Akses ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course->update($request->only('title', 'description'));

        return redirect()->route('courses.index')->with('success', 'Kursus diperbarui!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('courses.index')->withErrors('Akses ditolak.');
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Kursus dihapus!');
    }
}
