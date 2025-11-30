{{-- resources/views/instructor/assignments.blade.php --}}
@extends('layouts.app')
@section('title', 'Review Tugas Siswa')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-gray-900">Review Tugas Siswa</h1>
        <p class="text-sm text-gray-600 mt-1.5">
            Ada 
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                {{ $submissions->where('status', 'pending')->count() }} tugas menunggu
            </span>
        </p>
    </div>

    @if($submissions->count() > 0)
        <div class="space-y-5">
            @foreach($submissions as $submission)
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-gray-100/80 shadow-sm hover:shadow-lg transition-all duration-300">
                    <!-- Header Card -->
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-serene-500 to-serene-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ strtoupper(substr($submission->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $submission->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $submission->lesson->course->title }} → {{ $submission->lesson->title }}</p>
                                </div>
                            </div>
                            <div class="text-right text-xs text-gray-500">
                                <p>{{ $submission->submitted_at->format('d M Y') }}</p>
                                <p>{{ $submission->submitted_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6 grid md:grid-cols-3 gap-6">
                        <!-- Jawaban -->
                        <div class="md:col-span-2 space-y-4">
                            @if($submission->answer_text)
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-2">Jawaban</p>
                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">
                                        {{ $submission->answer_text }}
                                    </div>
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-3 text-sm">
                                @if($submission->external_link)
                                    <a href="{{ $submission->external_link }}" target="_blank" class="inline-flex items-center gap-1.5 text-serene-600 hover:text-serene-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Buka Link
                                    </a>
                                @endif
                                @if($submission->file_path)
                                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-serene-600 hover:text-serene-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        {{ basename($submission->file_path) }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="flex flex-col justify-center gap-3">
                            <form action="{{ route('assignment.review', $submission) }}" method="POST" class="space-y-3">
                                @csrf
                                <input type="hidden" name="status" value="approved" id="status-{{ $submission->id }}">

                                <button type="submit"
                                        onclick="this.closest('form').querySelector('input[name=status]').value='approved'"
                                        class="w-full py-2.5 px-4 bg-serene-600 text-white text-sm font-medium rounded-xl hover:bg-serene-700 hover:shadow-md transition">
                                    Approve
                                </button>

                                <button type="submit"
                                        onclick="this.closest('form').querySelector('input[name=status]').value='rejected'"
                                        class="w-full py-2.5 px-4 bg-gray-200 text-gray-800 text-sm font-medium rounded-xl hover:bg-red-100 hover:text-red-700 transition">
                                    Reject
                                </button>

                                <textarea name="feedback" rows="3" placeholder="Feedback (opsional)..."
                                          class="w-full p-3 text-sm border border-gray-200 rounded-xl focus:border-serene-500 focus:ring-4 focus:ring-serene-100 transition"></textarea>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-serene-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-lg font-medium text-gray-700">Semua tugas sudah direview</p>
            <p class="text-sm text-gray-500 mt-1">Tidak ada tugas yang menunggu.</p>
        </div>
    @endif
</div>
@endsection