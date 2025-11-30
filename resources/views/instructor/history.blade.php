{{-- resources/views/instructor/history.blade.php --}}
@extends('layouts.app')
@section('title', 'History Tugas')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">History Pengumpulan Tugas</h1>
        <p class="text-sm text-gray-600 mt-1">Total {{ $submissions->count() }} pengumpulan</p>
    </div>

    <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-gray-100 shadow-sm divide-y divide-gray-100">
        @forelse($submissions as $submission)
            @php
                $isApproved = $submission->status === 'approved';
                $badgeColor = $isApproved ? 'bg-serene-100 text-serene-700' : 'bg-red-100 text-red-700';
                $icon = $isApproved ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z';
            @endphp

            <div class="p-5 hover:bg-gray-50/50 transition">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-serene-500 to-serene-600 flex-shrink-0 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr($submission->user->name, 0, 2)) }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <p class="font-medium text-gray-900 truncate">{{ $submission->user->name }}</p>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                                {{ ucfirst($submission->status) }}
                            </span>
                        </div>

                        <p class="text-xs text-gray-500 mb-2">
                            {{ $submission->lesson->title }} • {{ $submission->submitted_at->diffForHumans() }}
                        </p>

                        @if($submission->answer_text || $submission->external_link || $submission->file_path)
                            <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600 mt-3">
                                @if($submission->answer_text)
                                    <p class="line-clamp-2">{{ $submission->answer_text }}</p>
                                @endif
                                @if($submission->external_link)
                                    <a href="{{ $submission->external_link }}" target="_blank" class="text-serene-600 hover:underline">Link eksternal</a>
                                @endif
                                @if($submission->file_path)
                                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-serene-600 hover:underline">{{ basename($submission->file_path) }}</a>
                                @endif
                            </div>
                        @endif

                        @if($submission->instructor_feedback)
                            <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs">
                                <p class="font-medium text-amber-800">Feedback:</p>
                                <p class="text-amber-700 mt-1">{{ $submission->instructor_feedback }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 text-gray-500">
                <p>Belum ada pengumpulan tugas.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection