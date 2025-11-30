<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'file_path',
        'order',
        'assignment_instruction',
        'assignment_type',
        'assignment_required'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // RELASI TUGAS
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'lesson_id');
    }

    public function submissionFrom($user)
    {
        return $this->submissions()->where('user_id', $user->id)->first();
    }

    public function hasAssignment()
    {
        return $this->assignment_type && $this->assignment_type !== 'none';
    }

    public function isCompletedBy($user)
    {
        // Jika tidak ada tugas atau tidak wajib → otomatis selesai
        if (!$this->hasAssignment() || !$this->assignment_required) {
            return true;
        }

        return $this->submissions()
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();
    }
}
