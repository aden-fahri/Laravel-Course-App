{{-- resources/views/enrollments/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Pendaftar: ' . $course->title)

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header Card --}}
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-serene-100 p-6 mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pendaftar Kursus</h1>
                <p class="text-lg text-serene-700 font-medium mt-1">{{ $course->title }}</p>
            </div>
            <a href="{{ route('courses.show', $course) }}"
               class="px-4 py-2 bg-white border border-serene-200 text-gray-700 rounded-lg font-medium hover:bg-serene-50 transition text-sm flex items-center gap-2">
                Kembali
            </a>
        </div>
    </div>

    @if($course->enrollments->count() > 0)
        {{-- Table Container --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-serene-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-serene-500 to-serene-600 text-white">
                            <th class="px-5 py-4 text-left text-sm font-bold uppercase tracking-wider rounded-tl-xl">No</th>
                            <th class="px-5 py-4 text-left text-sm font-bold uppercase tracking-wider">Nama</th>
                            <th class="px-5 py-4 text-left text-sm font-bold uppercase tracking-wider">Email</th>
                            <th class="px-5 py-4 text-left text-sm font-bold uppercase tracking-wider rounded-tr-xl">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-serene-100">
                        @foreach($course->enrollments as $index => $enrollment)
                            <tr class="hover:bg-serene-50/50 transition-all duration-200">
                                <td class="px-5 py-4 text-sm text-gray-700 font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Avatar Kecil --}}
                                        <div class="w-9 h-9 bg-gradient-to-br from-serene-400 to-serene-600 rounded-full flex items-center justify-center text-white font-black text-sm shadow-sm">
                                            {{ Str::substr($enrollment->user->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $enrollment->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">
                                    {{ $enrollment->user->email }}
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-serene-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ $enrollment->enrolled_at->format('d M Y') }}</span>
                                        <span class="text-gray-400">•</span>
                                        <span>{{ $enrollment->enrolled_at->format('H:i') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer Stats --}}
            <div class="px-5 py-4 bg-serene-50 border-t border-serene-100 flex justify-between items-center text-sm">
                <span class="text-gray-600">
                    Total: <span class="font-bold text-serene-700">{{ $course->enrollments->count() }} siswa</span>
                </span>
                <span class="text-gray-500">
                    Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
                </span>
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-serene-100 p-16 text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-serene-100 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-serene-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H9a1 1 0 01-1-1v-1a6 6 0 0112 0v1a1 1 0 01-1 1zm-3-9a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Pendaftar</h3>
            <p class="text-gray-500 mb-6">Siswa belum mendaftar ke kursus ini.</p>
            <a href="{{ route('courses.show', $course) }}"
               class="inline-block px-5 py-2.5 bg-serene-600 text-white font-medium rounded-lg hover:bg-serene-700 transition text-sm">
                Lihat Detail Kursus
            </a>
        </div>
    @endif
</div>
@endsection