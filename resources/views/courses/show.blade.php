{{-- resources/views/courses/show.blade.php --}}
@extends('layouts.app')
@section('title', $course->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Course Header --}}
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-serene-100 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-3">{{ $course->title }}</h1>
        <p class="text-gray-600 mb-5 leading-relaxed">{{ $course->description }}</p>
        <div class="flex items-center gap-4 text-sm text-gray-600">
            <span class="font-medium text-serene-700">{{ $course->instructor->name }}</span>
            <span>•</span>
            <span>{{ $course->enrollments->count() }} siswa terdaftar</span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('courses.index') }}"
           class="px-5 py-2.5 bg-white border border-serene-200 text-gray-700 rounded-lg font-medium hover:bg-serene-50 transition text-sm">
            Kembali
        </a>

        @auth
            @php
                $isEnrolled = Auth::user()->enrolledCourses->contains($course->id);
                $isOwner = $course->instructor_id === Auth::id();
                $isAdmin = Auth::user()->role === 'admin';
                $canAccess = $isEnrolled || $isOwner || $isAdmin;
            @endphp

            @if(Auth::user()->role === 'student')
                @if($isEnrolled)
                    <form action="{{ route('enroll.destroy', $course->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition text-sm">
                            Batal Daftar
                        </button>
                    </form>
                @else
                    <form action="{{ route('enroll.store', $course->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition text-sm">
                            Daftar Kursus
                        </button>
                    </form>
                @endif
            @endif

            @if($canAccess)
                <a href="{{ route('lessons.index', $course->id) }}"
                   class="px-5 py-2.5 bg-serene-600 text-white rounded-lg font-medium hover:bg-serene-700 transition text-sm">
                    Lihat Materi ({{ $course->lessons->count() }})
                </a>
            @endif

            @if($isOwner || $isAdmin)
                <a href="{{ route('enrollments.index', $course->id) }}"
                   class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition text-sm">
                    Pendaftar ({{ $course->enrollments->count() }})
                </a>
            @endif
        @endauth
    </div>
</div>
@endsection