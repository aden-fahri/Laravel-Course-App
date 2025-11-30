{{-- resources/views/lessons/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit: ' . $lesson->title)

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-serene-100 p-6 mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Materi</h1>
                <p class="text-serene-700 font-medium mt-1">{{ $lesson->title }}</p>
            </div>
            <a href="{{ route('lessons.index', $lesson->course_id) }}"
               class="px-4 py-2 bg-white border border-serene-200 text-gray-700 rounded-lg font-medium hover:bg-serene-50 transition text-sm flex items-center gap-2">
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('lessons.update', [$course, $lesson]) }}" method="POST" enctype="multipart/form-data" class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-serene-100 p-6 space-y-7">
        @csrf @method('PUT')

        {{-- Judul & Urutan --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Judul Materi</label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}" required 
                       class="w-full px-4 py-2.5 border border-serene-200 rounded-lg text-sm focus:ring-2 focus:ring-serene-500">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Urutan</label>
                <input type="number" name="order" value="{{ old('order', $lesson->order) }}" min="1"
                       class="w-full px-4 py-2.5 border border-serene-200 rounded-lg text-sm">
            </div>
        </div>

        {{-- Konten Teks --}}
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Konten Teks</label>
            <textarea name="content" rows="6" 
                      class="w-full px-4 py-3 border border-serene-200 rounded-lg text-sm focus:ring-2 focus:ring-serene-500">{{ old('content', $lesson->content) }}</textarea>
        </div>

        {{-- Video & File --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Link Video YouTube</label>
                <input type="url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}"
                       class="w-full px-4 py-2.5 border border-serene-200 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Ganti File</label>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx"
                       class="w-full px-4 py-2.5 border border-serene-200 rounded-lg text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:bg-serene-50 file:text-serene-700">
                @if($lesson->file_path)
                    <p class="text-xs text-gray-500 mt-1">File: <a href="{{ Storage::url($lesson->file_path) }}" target="_blank" class="text-serene-600 hover:underline">Lihat</a></p>
                @endif
            </div>
        </div>

        {{-- TUGAS --}}
        <div class="bg-serene-50/50 rounded-xl p-6 border border-serene-200">
            <h3 class="text-lg font-bold text-serene-800 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pengaturan Tugas
            </h3>

            <div class="mb-5">
                <div class="flex items-center gap-8">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="has_assignment" value="0" {{ !$lesson->hasAssignment() ? 'checked' : '' }} onchange="toggleAssignment(this.value)"
                               class="w-5 h-5 text-serene-600 focus:ring-serene-500">
                        <span class="ml-2 text-sm font-medium">Tidak ada tugas</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="has_assignment" value="1" {{ $lesson->hasAssignment() ? 'checked' : '' }} onchange="toggleAssignment(this.value)"
                               class="w-5 h-5 text-serene-600 focus:ring-serene-500">
                        <span class="ml-2 text-sm font-bold text-serene-700">Ada tugas!</span>
                    </label>
                </div>
            </div>

            <div id="assignment-fields" class="space-y-5 {{ $lesson->hasAssignment() ? '' : 'hidden' }}">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Instruksi Tugas</label>
                    <textarea name="assignment_instruction" rows="3"
                              class="w-full px-4 py-3 border border-serene-200 rounded-lg text-sm focus:ring-2 focus:ring-serene-500">{{ old('assignment_instruction', $lesson->assignment_instruction) }}</textarea>
                </div>
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tipe Jawaban</label>
                        <select name="assignment_type" class="w-full px-4 py-2.5 border border-serene-200 rounded-lg text-sm focus:ring-2 focus:ring-serene-500">
                            <option value="file" {{ old('assignment_type', $lesson->assignment_type) == 'file' ? 'selected' : '' }}>Upload File</option>
                            <option value="text" {{ old('assignment_type', $lesson->assignment_type) == 'text' ? 'selected' : '' }}>Teks</option>
                            <option value="link" {{ old('assignment_type', $lesson->assignment_type) == 'link' ? 'selected' : '' }}>Link</option>
                            <option value="mixed" {{ old('assignment_type', $lesson->assignment_type) == 'mixed' ? 'selected' : '' }}>Campuran</option>
                        </select>
                    </div>
                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="assignment_required" value="1" {{ old('assignment_required', $lesson->assignment_required) ? 'checked' : '' }}
                                   class="w-5 h-5 text-red-600 rounded focus:ring-red-500">
                            <span class="text-sm font-bold text-red-700">Wajib</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-serene-500 to-serene-600 text-white rounded-lg font-medium text-sm hover:from-serene-600 hover:to-serene-700 transition shadow-sm">
                Update Materi
            </button>
            <a href="{{ route('lessons.index', $lesson->course_id) }}" class="px-6 py-2.5 bg-white border border-serene-200 text-gray-700 rounded-lg font-medium text-sm hover:bg-serene-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
function toggleAssignment(value) {
    const fields = document.getElementById('assignment-fields');
    if (value === '1') fields.classList.remove('hidden');
    else fields.classList.add('hidden');
}
</script>
@endsection