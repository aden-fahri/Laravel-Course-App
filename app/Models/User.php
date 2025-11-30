<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }

    public function pendingReviewsCount()
    {
        return AssignmentSubmission::where('status', 'pending')
            ->whereHas('lesson.course', fn($q) => $q->where('instructor_id', $this->id))
            ->count();
    }

    public function totalLessonsCompleted()
    {
        return $this->enrolledCourses()
            ->with(['lessons.submissions']) // ← BISA JUGA PAKAI DOT NOTATION (LEBIH BERSIH)
            ->get()
            ->sum(function ($course) {
                return $course->lessons->filter(fn($lesson) => $lesson->isCompletedBy($this))->count();
            });
    }
}
