<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'instructor_id'];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function progressPercentageFor($user)
    {
        $total = $this->lessons->count();
        if ($total === 0) return 0;

        $completed = $this->lessons->filter(fn($lesson) => $lesson->isCompletedBy($user))->count();
        return min(100, round(($completed / $total) * 100));
    }

    public function completedLessonsFor($user)
    {
        return $this->lessons()->whereHas('submissions', function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->where('status', 'approved');
        });
    }
}
