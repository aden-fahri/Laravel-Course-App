{{-- resources/views/courses/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Buat Kursus Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-serene-100 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Buat Kursus Baru</h1>

        <form action="{{ route('courses.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Kursus</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-3 border border-serene-200 rounded-xl focus:border-serene-500 focus:ring-4 focus:ring-serene-100 transition text-base">
                @error('title')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="5" required
                          class="w-full px-4 py-3 border border-serene-200 rounded-xl focus:border-serene-500 focus:ring-4 focus:ring-serene-100 transition text-base resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-serene-500 to-serene-600 text-white font-bold rounded-xl hover:from-serene-600 hover:to-serene-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Simpan Kursus
                </button>
                <a href="{{ route('courses.index') }}" 
                   class="px-6 py-3 bg-white border border-serene-200 text-gray-700 font-medium rounded-xl hover:bg-serene-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection