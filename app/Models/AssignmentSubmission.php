<?php
// app/Models/AssignmentSubmission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $table = 'assignment_submissions';

    protected $fillable = [
        'lesson_id',
        'user_id',
        'answer_text',
        'file_path',
        'external_link',
        'answer_type',           // TAMBAHKAN
        'status',
        'instructor_feedback',
        'submitted_at',
        'reviewed_at',
        'reviewed_by'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at'  => 'datetime',
        'status'       => 'string',
        'answer_type'  => 'string'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
    public function isPending()
    {
        return $this->status === 'pending';
    }
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
