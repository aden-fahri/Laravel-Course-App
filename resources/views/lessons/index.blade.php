{{-- resources/views/lessons/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Materi: ' . $course->title)

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl flex items-center gap-3 shadow-md">
            <svg class="w-6 h-6 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl flex items-center gap-3 shadow-md">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span class="font-semibold">{{ session('error') ?? 'Terjadi kesalahan, silakan coba lagi.' }}</span>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-serene-100 p-6 mb-8">
        <nav class="text-sm text-gray-500 mb-3">
            <a href="{{ route('courses.index') }}" class="hover:text-serene-600">Kursus</a>
            <span class="mx-2">›</span>
            <a href="{{ route('courses.show', $course) }}" class="hover:text-serene-600">{{ $course->title }}</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700">Materi</span>
        </nav>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $course->title }}</h1>
                <p class="text-gray-600">Instruktur: <span class="font-medium text-serene-700">{{ $course->instructor->name }}</span></p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('courses.show', $course) }}" class="px-5 py-2.5 bg-white border border-serene-200 text-gray-700 rounded-lg font-medium hover:bg-serene-50 transition">
                    Kembali
                </a>
                @if($course->instructor_id === Auth::id() || Auth::user()->role === 'admin')
                    <a href="{{ route('lessons.create', $course->id) }}" class="px-5 py-2.5 bg-serene-600 text-white rounded-lg font-medium hover:bg-serene-700 transition">
                        + Tambah Materi
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Progress Bar Student -->
    @if(Auth::user()->role === 'student')
        <div class="bg-serene-50/70 backdrop-blur-sm rounded-2xl p-6 mb-8 border border-serene-200">
            <div class="flex justify-between items-center mb-3">
                <span class="font-semibold text-gray-700">Progress Belajar</span>
                <span class="text-3xl font-black text-serene-700">{{ $course->progressPercentageFor(Auth::user()) }}%</span>
            </div>
            <div class="w-full bg-serene-200 rounded-full h-4 overflow-hidden">
                <div class="h-full rounded-full transition-all duration-1000 bg-gradient-to-r from-serene-500 to-serene-600"
                     style="width: {{ $course->progressPercentageFor(Auth::user()) }}%"></div>
            </div>
        </div>
    @endif

    <!-- Daftar Materi -->
    <div class="space-y-6">
        @forelse($lessons as $lesson)
            @php
                $submission = $lesson->submissionFrom(Auth::user());
                $isCompleted = $lesson->isCompletedBy(Auth::user());
                $isInstructor = $course->instructor_id === Auth::id() || Auth::user()->role === 'admin';
            @endphp

            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-md border border-serene-100 overflow-hidden hover:shadow-xl transition-all duration-300
                        {{ $isCompleted && Auth::user()->role === 'student' ? 'ring-2 ring-emerald-500/30' : '' }}">

                <div class="p-6">
                    <!-- Judul + Nomor + Status + Aksi -->
                    <div class="flex justify-between items-start mb-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-serene-500 to-serene-700 rounded-full flex items-center justify-center text-white font-black text-lg shadow-md">
                                {{ $loop->iteration }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $lesson->title }}</h3>
                        </div>

                        <div class="flex items-center gap-3">
                            @if(Auth::user()->role === 'student')
                                @if($isCompleted)
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700">Selesai</span>
                                @endif
                                @if($lesson->hasAssignment())
                                    <span class="px-3 py-1 text-xs font-bold rounded-full
                                        {{ !$submission ? 'bg-red-100 text-red-700' :
                                           ($submission->isPending() ? 'bg-amber-100 text-amber-700' :
                                           ($submission->isApproved() ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700')) }}">
                                        {{ !$submission ? 'Belum Dikumpul' :
                                           ($submission->isPending() ? 'Menunggu Review' :
                                           ($submission->isApproved() ? 'Disetujui' : 'Revisi')) }}
                                    </span>
                                @endif
                            @endif

                            @if($isInstructor)
                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('lessons.edit', [$course, $lesson]) }}"
                                       class="p-2.5 bg-serene-50 border border-serene-200 text-serene-600 rounded-lg hover:bg-serene-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <form action="{{ route('lessons.destroy', [$course, $lesson]) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus materi \"{{ addslashes($lesson->title) }}\"?\n\nSemua data siswa (progress, tugas, dll) akan dihapus permanen!')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-2.5 bg-red-50 border border-red-200 text-red-600 rounded-lg hover:bg-red-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2.2 2 0 0116.138 21H7.862a2.2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Deskripsi Singkat -->
                    @if($lesson->content)
                        <p class="text-gray-600 text-sm leading-relaxed mb-5 line-clamp-3">
                            {!! Str::limit(strip_tags($lesson->content), 180) !!}
                        </p>
                    @endif

                    <!-- VIDEO & FILE — IKON KECIL + LABEL DI BAWAH -->
                    <div class="flex flex-wrap items-center gap-6 text-sm">
                        @if($lesson->video_url)
                            <a href="{{ $lesson->video_url }}" target="_blank" class="flex items-center gap-2 text-purple-700 hover:text-purple-900 font-medium">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l7 4-7 4z"/>
                                </svg>
                                <span>Video</span>
                            </a>
                        @endif

                        @if($lesson->file_path)
                            <a href="{{ Storage::url($lesson->file_path) }}" target="_blank" class="flex items-center gap-2 text-blue-700 hover:text-blue-900 font-medium">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span>Download {{ strtoupper(pathinfo($lesson->file_path, PATHINFO_EXTENSION)) }}</span>
                            </a>
                        @endif
                    </div>

                    <!-- Tugas Student -->
                    @if(Auth::user()->role === 'student' && $lesson->hasAssignment())
                        <div class="mt-5 pt-5 border-t border-slate-200">
                            <button onclick="toggleAssignment('assignment-{{ $lesson->id }}', 'icon-{{ $lesson->id }}')"
                                    class="w-full text-left px-4 py-3 rounded-lg font-medium flex justify-between items-center transition text-sm
                                        {{ $submission?->isRejected() ? 'bg-red-50 text-red-700 hover:bg-red-100' :
                                        ($submission?->isPending() ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' :
                                        ($submission?->isApproved() ? 'bg-emerald-50 text-emerald-700' : 'bg-serene-50 text-serene-700 hover:bg-serene-100')) }}">
                                <span>
                                    @if($submission?->isApproved()) Tugas Disetujui
                                    @elseif($submission?->isPending()) Sedang Direview
                                    @elseif($submission?->isRejected()) Revisi Diperlukan
                                    @else Kirim Tugas
                                    @endif
                                </span>
                                <svg id="icon-{{ $lesson->id }}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div id="assignment-{{ $lesson->id }}" class="mt-3 hidden">
                                @include('lessons.partials.assignment-form', compact('lesson', 'submission'))
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white/80 backdrop-blur-sm rounded-2xl border-2 border-dashed border-serene-200">
                <div class="w-24 h-24 mx-auto mb-6 bg-serene-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-serene-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-xl font-semibold text-gray-700 mb-4">Belum Ada Materi</p>
                @if($course->instructor_id === Auth::id() || Auth::user()->role === 'admin')
                    <a href="{{ route('lessons.create', $course->id) }}" 
                       class="inline-block px-8 py-4 bg-serene-600 text-white font-bold rounded-xl hover:bg-serene-700 transition shadow-lg">
                        + Tambah Materi Pertama
                    </a>
                @endif
            </div>
        @endforelse
    </div>
</div>

<script>
function toggleAssignment(formId, iconId) {
    document.getElementById(formId).classList.toggle('hidden');
    document.getElementById(iconId).classList.toggle('rotate-180');
}
</script>
@endsection