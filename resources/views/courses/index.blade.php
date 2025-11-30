{{-- resources/views/courses/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Daftar Kursus')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Kursus</h1>

        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'instructor')
            <a href="{{ route('courses.create') }}" 
               class="px-5 py-2.5 bg-gradient-to-r from-serene-500 to-serene-600 text-white font-bold rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5 text-sm">
                + Buat Kursus
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- GRID: 4 KOTAK PER BARIS, SAMBIL RENDAH --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($courses as $course)
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-serene-100 overflow-hidden hover:shadow-lg transition-all hover:-translate-y-1 
                        flex flex-col h-full">
                
                {{-- SAMBIL KECIL: h-32 (sebelumnya h-48) --}}
                <div class="bg-gradient-to-br from-serene-400 to-serene-600 h-32 flex items-center justify-center flex-shrink-0">
                    <p class="text-white text-2xl font-black tracking-wider">
                        {{ Str::substr($course->title, 0, 2) }}
                    </p>
                </div>

                {{-- ISI KARTU: Teks lebih ringkas --}}
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-base font-bold text-gray-800 mb-1.5 line-clamp-1">{{ $course->title }}</h3>
                    <p class="text-gray-600 text-xs mb-2 line-clamp-2 flex-grow">{{ $course->description }}</p>
                    
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                        <span class="font-medium text-serene-700 truncate">{{ $course->instructor->name }}</span>
                        <span>{{ $course->enrollments->count() }} siswa</span>
                    </div>

                    {{-- TOMBOL AKSI: Lebih kecil, tetap rapi --}}
                    <div class="flex gap-1.5 mt-auto">
                        <a href="{{ route('courses.show', $course) }}" 
                           class="flex-1 text-center py-1.5 bg-serene-600 text-white rounded-lg font-medium hover:bg-serene-700 transition text-xs">
                            Lihat
                        </a>

                        @if(Auth::user()->role === 'admin' || $course->instructor_id === Auth::id())
                            <a href="{{ route('courses.edit', $course) }}" 
                               class="p-1.5 bg-white border border-serene-200 text-serene-600 rounded-lg hover:bg-serene-50 transition"
                               title="Edit Kursus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Yakin ingin menghapus kursus ini?')"
                                        class="p-1.5 bg-white border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition"
                                        title="Hapus Kursus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <p class="text-lg text-gray-500 mb-4">Belum ada kursus tersedia</p>
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'instructor')
                    <a href="{{ route('courses.create') }}" 
                       class="inline-block px-6 py-3 bg-serene-600 text-white font-bold rounded-xl hover:bg-serene-700 transition">
                        Buat Kursus Pertama
                    </a>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection