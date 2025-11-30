{{-- resources/views/instructor/review.blade.php --}}
@extends('layouts.app')
@section('title', 'Review Tugas Siswa')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-9">
        <h1 class="text-2xl font-bold text-gray-900">Review Tugas Siswa</h1>
        <p class="text-sm text-gray-600 mt-1.5">
            Ada <span class="font-semibold text-serene-700">{{ $submissions->where('status', 'pending')->count() }}</span> tugas yang menunggu review
        </p>
    </div>

    @if($submissions->count() > 0)
        <div class="space-y-6">
            @foreach($submissions as $submission)
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300">
                    <!-- Header Card -->
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-serene-500 to-serene-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ strtoupper(substr($submission->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $submission->user->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $submission->lesson->course->title }} → {{ $submission->lesson->title }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">{{ $submission->submitted_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $submission->submitted_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Body: Jawaban -->
                    <div class="p-6 space-y-5">
                        @if($submission->answer_text)
                            <div>
                                <p class="text-xs font-medium text-gray-600 mb-2">Jawaban Teks</p>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">
                                    {{ $submission->answer_text }}
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-wrap gap-4 text-sm">
                            @if($submission->external_link)
                                <a href="{{ $submission->external_link }}" target="_blank"
                                   class="inline-flex items-center gap-2 text-serene-600 hover:text-serene-700 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Buka Link Eksternal
                                </a>
                            @endif
                            @if($submission->file_path)
                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank"
                                   class="inline-flex items-center gap-2 text-serene-600 hover:text-serene-700 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ basename($submission->file_path) }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-6 pb-6 flex gap-3">
                        <form action="{{ route('assignment.approve', $submission) }}" method="POST" class="flex-1">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="w-full py-3 px-5 bg-serene-600 text-white text-sm font-medium rounded-xl hover:bg-serene-700 hover:shadow-md transition">
                                Approve Tugas
                            </button>
                        </form>

                        <button type="button"
                                onclick="openRejectModal({{ $submission->id }})"
                                class="flex-1 py-3 px-5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-red-50 hover:text-red-700 hover:border-red-200 border border-transparent transition">
                            Reject Tugas
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {{ $submissions->links('pagination::tailwind') }}
        </div>
    @else
        <div class="text-center py-24">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-serene-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-lg font-medium text-gray-700">Semua tugas sudah direview!</p>
            <p class="text-sm text-gray-500 mt-1">Tidak ada tugas yang menunggu.</p>
        </div>
    @endif
</div>

{{-- Modal Reject – Lebih Clean & Modern --}}
@foreach($submissions as $submission)
<div id="reject-modal-{{ $submission->id }}"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 animate-in fade-in zoom-in duration-200">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Tolak Tugas</h3>
        <form action="{{ route('assignment.reject', $submission) }}" method="POST">
            @csrf @method('PATCH')
            <textarea name="feedback" rows="4" required
                      class="w-full p-4 border border-gray-200 rounded-xl text-sm focus:border-red-400 focus:ring-4 focus:ring-red-50 transition"
                      placeholder="Tulis alasan penolakan..."></textarea>

            <div class="flex gap-3 mt-5">
                <button type="submit"
                        class="flex-1 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition">
                    Tolak Tugas
                </button>
                <button type="button" onclick="closeRejectModal({{ $submission->id }})"
                        class="flex-1 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function openRejectModal(id) {
    document.getElementById('reject-modal-' + id).classList.remove('hidden');
}
function closeRejectModal(id) {
    document.getElementById('reject-modal-' + id).classList.add('hidden');
}
</script>
@endsection