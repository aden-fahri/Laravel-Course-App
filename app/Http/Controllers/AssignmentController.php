<?php

namespace App\Http\Controllers;

use App\Models\AssignmentSubmission;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function store(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        if ($user->role !== 'student') {
            abort(403);
        }

        $submission = $lesson->submissionFrom($user);

        // Validasi berdasarkan assignment_type
        $rules = [];
        $type = $lesson->assignment_type;

        if (in_array($type, ['text', 'mixed'])) {
            $rules['answer_text'] = $type === 'text' ? 'required|string' : 'nullable|string';
        }
        if (in_array($type, ['link', 'mixed'])) {
            $rules['external_link'] = $type === 'link' ? 'required|url' : 'nullable|url';
        }
        if (in_array($type, ['file', 'mixed'])) {
            $rules['file'] = $type === 'file'
                ? 'required|file|mimes:pdf,doc,docx,zip,rar,mp4|max:51200'
                : 'nullable|file|mimes:pdf,doc,docx,zip,rar,mp4|max:51200';
        }

        $request->validate($rules);

        // Tentukan answer_type
        $answerType = $type;

        if ($type === 'mixed') {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $answerType = 'file';
            } elseif ($request->filled('external_link')) {
                $answerType = 'link';
            } elseif ($request->filled('answer_text')) {
                $answerType = 'text';
            } else {
                $answerType = 'text'; // default
            }
        }

        $data = [
            'answer_text'    => $request->answer_text,
            'external_link'  => $request->external_link,
            'answer_type'    => $answerType,
            'status'         => 'pending',
            'submitted_at'   => now(),
        ];

        // Upload file
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            if ($submission?->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        if ($submission) {
            $submission->update($data);
        } else {
            $lesson->submissions()->create(array_merge($data, ['user_id' => $user->id]));
        }

        return back()->with('success', 'Tugas berhasil ' . ($submission ? 'direvisi' : 'dikirim') . '!');
    }

    public function pendingReview()
    {
        $submissions = AssignmentSubmission::with(['user', 'lesson.course'])
            ->where('status', 'pending')
            ->whereHas('lesson.course', fn($q) => $q->where('instructor_id', Auth::id()))
            ->latest('submitted_at')
            ->paginate(10);

        return view('instructor.review', compact('submissions'));
    }

    public function approve(AssignmentSubmission $submission)
    {
        $this->authorizeSubmission($submission);
        $submission->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);
        return back()->with('success', 'Tugas disetujui!');
    }

    public function reject(Request $request, AssignmentSubmission $submission)
    {
        $this->authorizeSubmission($submission);
        $request->validate(['feedback' => 'required|string|max:1000']);
        $submission->update([
            'status' => 'rejected',
            'instructor_feedback' => $request->feedback,
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);
        return back()->with('success', 'Tugas ditolak.');
    }

    protected function authorizeSubmission($submission)
    {
        if ($submission->lesson->course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function history()
    {
        $submissions = AssignmentSubmission::with(['user', 'lesson.course'])
            ->whereIn('status', ['approved', 'rejected'])
            ->whereHas('lesson.course', fn($q) => $q->where('instructor_id', Auth::id()))
            ->orWhere(function ($query) {
                return $query->where('user_id', Auth::id())
                    ->whereIn('status', ['approved', 'rejected']);
            })
            ->latest('submitted_at')
            ->paginate(15);

        return view('instructor.history', compact('submissions'));
    }

    public function cancel(AssignmentSubmission $submission)
    {
        // Cek pemilik & status
        if ($submission->user_id !== Auth::id() || $submission->status !== 'pending') {
            abort(403);
        }

        // Hapus file
        if ($submission->file_path) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();

        return back()->with('success', 'Pengiriman tugas berhasil dibatalkan!');
    }
}
