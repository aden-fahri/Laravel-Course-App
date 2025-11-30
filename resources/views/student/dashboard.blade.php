{{-- resources/views/student/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Kursus Terdaftar')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header Selamat Datang --}}
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-serene-100 p-8 mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Selamat Datang Kembali, {{ Auth::user()->name }}!
        </h1>
        <p class="text-serene-700 font-medium">
            Lanjutkan perjalanan belajarmu. Kamu sedang menaklukkan ilmu!
        </p>
    </div>

    @if(Auth::user()->enrolledCourses->count() > 0)
        {{-- Grid Kursus --}}
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach(Auth::user()->enrolledCourses as $course)
                @php
                    $progress = $course->progressPercentageFor(Auth::user());
                    $color = $progress >= 100 ? 'from-emerald-500 to-teal-600' : 
                            ($progress >= 70 ? 'from-amber-500 to-orange-600' : 'from-serene-500 to-serene-600');
                @endphp

                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-serene-100 overflow-hidden hover:shadow-lg transition-all hover:-translate-y-1">
                    
                    {{-- Header Card: Judul + Icon --}}
                    <div class="p-5 border-b border-serene-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-800 line-clamp-1">{{ $course->title }}</h3>
                            <div class="w-10 h-10 bg-gradient-to-br {{ $progress >= 100 ? 'from-emerald-400 to-teal-500' : 'from-serene-400 to-serene-600' }} rounded-full flex items-center justify-center text-white font-black text-sm shadow-sm">
                                {{ Str::substr($course->title, 0, 1) }}
                            </div>
                        </div>
                    </div>

                    {{-- Progress Section --}}
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Progress</span>
                            <span class="text-lg font-black text-serene-700">{{ $progress }}%</span>
                        </div>

                        <div class="w-full bg-serene-100 rounded-full h-3 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-700 ease-out bg-gradient-to-r {{ $color }}"
                                 style="width: {{ $progress }}%">
                            </div>
                        </div>

                        @if($progress >= 100)
                            <div class="mt-3 flex items-center gap-2 text-emerald-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-bold">Kursus Selesai!</span>
                            </div>
                        @else
                            <p class="mt-2 text-xs text-gray-500">
                                {{ $course->lessons->count() }} materi • 
                                {{ $course->completedLessonsFor(Auth::user())->count() }} selesai
                            </p>
                        @endif
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="px-5 pb-5 mt-auto">
                        <a href="{{ route('lessons.index', $course->id) }}"
                           class="block text-center py-2.5 bg-serene-600 text-white font-medium rounded-lg hover:bg-serene-700 transition text-sm group-hover:shadow-md">
                            Lanjut Belajar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Stats Ringkasan --}}
        @php
            $completedCount = Auth::user()->enrolledCourses->filter(function($course) {
                return $course->progressPercentageFor(Auth::user()) >= 100;
            })->count();

            $averageProgress = Auth::user()->enrolledCourses->avg(function($course) {
                return $course->progressPercentageFor(Auth::user());
            }) ?: 0;
        @endphp

        <!-- Stats -->
        <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-5 text-center border border-serene-100">
                <p class="text-2xl font-black text-serene-600">{{ Auth::user()->enrolledCourses->count() }}</p>
                <p class="text-xs text-gray-600 mt-1">Kursus Aktif</p>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-5 text-center border border-serene-100">
                <p class="text-2xl font-black text-emerald-600">{{ $completedCount }}</p>
                <p class="text-xs text-gray-600 mt-1">Selesai</p>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-5 text-center border border-serene-100">
                <p class="text-2xl font-black text-amber-600">{{ round($averageProgress) }}%</p>
                <p class="text-xs text-gray-600 mt-1">Rata-rata</p>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-5 text-center border border-serene-100">
                <p class="text-2xl font-black text-indigo-600">{{ Auth::user()->totalLessonsCompleted() }}</p>
                <p class="text-xs text-gray-600 mt-1">Materi Selesai</p>
            </div>
        </div>

    @else
        {{-- Empty State: Motivasi + CTA --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-serene-100 p-16 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-serene-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-serene-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-3">Belum Terdaftar di Kursus</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Mulai perjalanan belajarmu sekarang! Pilih kursus yang sesuai dengan minatmu.
            </p>
            <a href="{{ route('courses.index') }}"
               class="inline-block px-6 py-3 bg-gradient-to-r from-serene-500 to-serene-600 text-white font-bold rounded-xl hover:from-serene-600 hover:to-serene-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Cari Kursus
            </a>
        </div>
    @endif
</div>
@endsection