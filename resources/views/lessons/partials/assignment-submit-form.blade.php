{{-- resources/views/lessons/partials/assignment-submit-form.blade.php --}}
@php
    $canSubmit = !$submission || $submission->isRejected();
    $isPending = $submission?->isPending();
@endphp

{{-- FORM UTAMA: Kirim / Revisi Tugas --}}
<form action="{{ route('assignment.store', $lesson) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="form-{{ $lesson->id }}">
    @csrf

    {{-- Teks, Link, File Upload (sama seperti sebelumnya) --}}
    @if(in_array($lesson->assignment_type, ['text', 'mixed']))
        <div>
            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Jawaban Teks
                @if($lesson->assignment_type === 'text') <span class="text-red-600">*</span> @endif
            </label>
            <textarea name="answer_text" rows="4"
                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-serene-500 focus:border-serene-500 transition text-sm resize-none"
                placeholder="Tulis jawabanmu..."
                {{ $lesson->assignment_type === 'text' ? 'required' : '' }}
            >{{ old('answer_text', $submission?->answer_text ?? '') }}</textarea>
        </div>
    @endif

    @if(in_array($lesson->assignment_type, ['link', 'mixed']))
        <div>
            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Link Eksternal
                @if($lesson->assignment_type === 'link') <span class="text-red-600">*</span> @endif
            </label>
            <input type="url" name="external_link"
                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-serene-500 focus:border-serene-500 transition text-sm"
                placeholder="https://drive.google.com/..."
                {{ $lesson->assignment_type === 'link' ? 'required' : '' }}
                value="{{ old('external_link', $submission?->external_link ?? '') }}"
            />
        </div>
    @endif

    @if(in_array($lesson->assignment_type, ['file', 'mixed']))
        <div>
            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Upload File
                @if($lesson->assignment_type === 'file') <span class="text-red-600">*</span> @endif
            </label>

            <div class="dropzone border-2 border-dashed border-slate-300 rounded-xl p-6 text-center transition-all cursor-pointer hover:border-serene-400"
                 onclick="document.getElementById('file-{{ $lesson->id }}').click()">
                <input type="file" name="file" id="file-{{ $lesson->id }}" class="hidden"
                       accept=".pdf,.doc,.docx,.zip,.rar,.mp4,.jpg,.png"
                       {{ $lesson->assignment_type === 'file' ? 'required' : '' }}>

                <div class="placeholder {{ $submission?->file_path ? 'hidden' : '' }}">
                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm text-slate-600">Klik atau drag & drop</p>
                    <p class="text-xs text-slate-500 mt-1">PDF, DOCX, ZIP, Video, Gambar • Max 50MB</p>
                </div>

                <div class="preview flex items-center justify-center gap-3 {{ $submission?->file_path ? '' : 'hidden' }}">
                    <svg class="w-10 h-10 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div class="text-left">
                        <p class="filename font-medium text-sm text-slate-800">
                            {{ $submission?->file_path ? basename($submission->file_path) : '' }}
                        </p>
                        <p class="text-xs text-serene-600">Klik untuk ganti</p>
                    </div>
                    <button type="button" class="remove-file ml-4 text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            @error('file')
                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    {{-- TOMBOL KIRIM --}}
    <div class="pt-4">
        @if($canSubmit)
            <button type="submit"
                    class="w-full bg-gradient-to-r from-serene-600 to-emerald-600 text-white font-bold py-3 rounded-xl hover:from-serene-700 hover:to-emerald-700 transition text-sm">
                {{ $submission?->isRejected() ? 'Kirim Revisi' : 'Kirim Tugas' }}
            </button>
        @endif
    </div>
</form>

{{-- FORM CANCEL: DI LUAR FORM UTAMA! --}}
@if($isPending)
    <div class="mt-4 pt-4 border-t border-slate-200">
        <form action="{{ route('assignment.cancel', $submission) }}" method="POST" class="w-full">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Yakin ingin membatalkan pengiriman tugas ini?')"
                    class="w-full bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold py-3 rounded-xl hover:from-red-600 hover:to-rose-700 transition text-sm shadow-md">
                Batalkan Pengiriman
            </button>
        </form>
    </div>
@endif

{{-- JS Drag & Drop (tetap sama) --}}
<script>
    (function() {
        const lessonId = '{{ $lesson->id }}';
        const fileInput = document.getElementById('file-' + lessonId);
        const dropzone = document.querySelector('#form-' + lessonId + ' .dropzone');
        const placeholder = dropzone?.querySelector('.placeholder');
        const preview = dropzone?.querySelector('.preview');
        const filename = dropzone?.querySelector('.filename');
        const removeBtn = dropzone?.querySelector('.remove-file');

        if (!dropzone) return;

        ['dragover', 'dragenter'].forEach(e => dropzone.addEventListener(e, ev => {
            ev.preventDefault();
            dropzone.classList.add('border-serene-500', 'bg-serene-50');
        }));
        ['dragleave', 'drop'].forEach(e => dropzone.addEventListener(e, ev => {
            ev.preventDefault();
            dropzone.classList.remove('border-serene-500', 'bg-serene-50');
        }));

        dropzone.addEventListener('drop', e => {
            const file = e.dataTransfer.files[0];
            if (file) setFile(file);
        });

        fileInput?.addEventListener('change', () => {
            if (fileInput.files[0]) setFile(fileInput.files[0]);
        });

        removeBtn?.addEventListener('click', () => {
            fileInput.value = '';
            placeholder.classList.remove('hidden');
            preview.classList.add('hidden');
        });

        function setFile(file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            filename.textContent = file.name;
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
        }
    })();
</script>