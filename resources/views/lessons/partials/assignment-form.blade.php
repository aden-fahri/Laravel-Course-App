@php
    $submission = $lesson->submissionFrom(Auth::user());
    $canSubmit = !$submission || $submission->isRejected();
    $isPending = $submission?->isPending();
@endphp

<div class="bg-white rounded-xl border border-serene-200 shadow-sm p-5">
    <h4 class="font-bold text-slate-900 mb-4">Tugas Materi</h4>

    <div class="bg-serene-50 border border-serene-200 rounded-lg p-4 mb-5 text-sm">
        {!! nl2br(e($lesson->assignment_instruction)) !!}
    </div>

    {{-- PESAN SUKSES DIBATALKAN --}}
    @if(session('success') && str_contains(session('success'), 'dibatalkan'))
        <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg mb-5 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($submission?->isApproved())
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 text-center">
            <p class="font-bold text-emerald-800">Tugas Disetujui!</p>
        </div>

    @elseif($submission?->isRejected())
        <div class="bg-red-50 border border-red-300 rounded-lg p-4 mb-5">
            <p class="font-bold text-red-800">Revisi Diperlukan</p>
            @if($submission->instructor_feedback)
                <div class="mt-2 p-3 bg-white rounded border text-xs">
                    {{ $submission->instructor_feedback }}
                </div>
            @endif
        </div>
        @include('lessons.partials.assignment-submit-form', compact('lesson', 'submission', 'canSubmit', 'isPending'))

    @elseif($isPending)
        <div class="bg-amber-50 border border-amber-300 rounded-lg p-4 mb-5 text-center">
            <p class="font-bold text-amber-800">Sedang Direview</p>
            <p class="text-xs text-amber-700">Dikirim: {{ $submission->submitted_at?->translatedFormat('d M Y H:i') }}</p>
        </div>
        @include('lessons.partials.assignment-submit-form', compact('lesson', 'submission', 'canSubmit', 'isPending'))

    @else
        @include('lessons.partials.assignment-submit-form', compact('lesson', 'submission', 'canSubmit', 'isPending'))
    @endif
</div>