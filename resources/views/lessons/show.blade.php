{{-- resources/views/lessons/show.blade.php --}}
@extends('layouts.app')
@section('title', $lesson->title)

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-serene-100 p-6 mb-8">
        <div class="flex justify-between items-center">
            <div>
                <nav class="text-sm text-gray-500 mb-2">
                    <a href="{{ route('courses.index') }}" class="hover:text-serene-600">Kursus</a> ›
                    <a href="{{ route('lessons.index', $lesson->course_id) }}" class="hover:text-serene-600">{{ $lesson->course->title }}</a> ›
                    <span class="text-gray-700">{{ $lesson->title }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-800">{{ $lesson->title }}</h1>
            </div>
            <a href="{{ route('lessons.index', $lesson->course_id) }}"
               class="px-4 py-2 bg-white border border-serene-200 text-gray-700 rounded-lg font-medium hover:bg-serene-50 transition text-sm flex items-center gap-2">
                Kembali
            </a>
        </div>
    </div>

    {{-- Konten --}}
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-serene-100 p-6 mb-6">
        @if($lesson->content)
            <div class="prose prose-sm max-w-none text-gray-700">{!! nl2br(e($lesson->content)) !!}</div>
        @else
            <p class="text-gray-500 italic">Tidak ada konten teks.</p>
        @endif
    </div>

    {{-- Media --}}
    @if($lesson->video_url || $lesson->file_path)
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            @if($lesson->video_url)
                <div class="bg-serene-50/50 rounded-xl p-5 border border-serene-200">
                    <h3 class="font-bold text-serene-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l7 4-7 4z"/></svg>
                        Video Materi
                    </h3>
                    <a href="{{ $lesson->video_url }}" target="_blank" class="text-serene-600 hover:underline text-sm">
                        Buka di YouTube
                    </a>
                </div>
            @endif
            @if($lesson->file_path)
                <div class="bg-serene-50/50 rounded-xl p-5 border border-serene-200">
                    <h3 class="font-bold text-serene-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        File Lampiran
                    </h3>
                    <a href="{{ Storage::url($lesson->file_path) }}" target="_blank" class="text-serene-600 hover:underline text-sm">
                        Download File
                    </a>
                </div>
            @endif
        </div>
    @endif

    {{-- TUGAS: SISWA --}}
    @if($lesson->hasAssignment() && Auth::user()->role === 'student')
        <div class="bg-serene-50/50 rounded-xl p-6 border border-serene-200">
            <h3 class="font-bold text-serene-800 mb-4">Tugas</h3>
            <div class="prose prose-sm text-gray-700 mb-4">{!! nl2br(e($lesson->assignment_instruction)) !!}</div>
            @include('lessons.partials.assignment-form', compact('lesson', 'submission'))
        </div>
    @endif

    {{-- TUGAS: INSTRUCTOR --}}
    @can('update', $lesson->course)
        <div class="mt-8 bg-serene-50/50 rounded-xl p-6 border border-serene-200">
            <h3 class="font-bold text-serene-800 mb-4">Pengumpulan Tugas ({{ $lesson->submissions()->count() }})</h3>
            @include('lessons.partials.assignment-submissions', ['submissions' => $lesson->submissions()->with('user')->get()])
        </div>
    @endcan
</div>
@endsection