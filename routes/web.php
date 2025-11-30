<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [SesiController::class, 'index'])->name('login');
    Route::get('/login', [SesiController::class, 'index'])->name('login.page');
    Route::post('/login', [SesiController::class, 'login'])->name('login.post');
    Route::get('/register', [SesiController::class, 'register'])->name('register');
    Route::post('/register', [SesiController::class, 'store'])->name('register.post');
});

Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::get('/logout', function () {
    return redirect('/login')->with('error', 'Gunakan tombol logout untuk keluar.');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard'); // semua role masuk sini cuy
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->middleware('userAkses:admin')->name('manage.users');
    Route::patch('/admin/manage-users/{id}', [AdminController::class, 'updateRole'])->middleware('userAkses:admin')->name('update.role');
    Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
    Route::delete('/admin/manage-users/{id}', [AdminController::class, 'destroy'])->middleware('userAkses:admin')->name('delete.user');

    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->middleware('userAkses:instructor')->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->middleware('userAkses:instructor')->name('courses.store');
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');

    Route::post('/enroll/{course}', [EnrollmentController::class, 'store'])->name('enroll.store');
    Route::delete('/enroll/{course}', [EnrollmentController::class, 'destroy'])->name('enroll.destroy');
    Route::get('/courses/{course}/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
});

Route::get('/student', function () {
    return view('student.dashboard');
})->middleware('userAkses:student')->name('student.dashboard');

Route::prefix('courses/{course}')->group(function () {
    Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
});

Route::post('/lessons/{lesson}/assignment', [AssignmentController::class, 'store'])
    ->name('assignment.store')
    ->middleware('auth');

Route::post('/assignment/{submission}/review', [AssignmentController::class, 'review'])
    ->name('assignment.review')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/instructor/assignments', [AssignmentController::class, 'instructorIndex'])
        ->name('instructor.assignments');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/instructor/assignments', [AssignmentController::class, 'instructorAssignments'])
        ->name('instructor.assignments');

    Route::get('/reviews/pending', [AssignmentController::class, 'pendingReview'])
        ->name('reviews.pending');

    // History (Approved + Rejected)
    Route::get('/reviews/history', [AssignmentController::class, 'history'])
        ->name('reviews.history');

    // Approve & Reject
    Route::patch('/assignment/{submission}/approve', [AssignmentController::class, 'approve'])
        ->name('assignment.approve');
    Route::patch('/assignment/{submission}/reject', [AssignmentController::class, 'reject'])
        ->name('assignment.reject');

    // Batalkan Pengiriman (WAJIB DELETE!)
    Route::delete('/assignment/cancel/{submission}', [AssignmentController::class, 'cancel'])
        ->name('assignment.cancel')
        ->middleware('auth');
});
