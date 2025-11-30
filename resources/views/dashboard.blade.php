{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">

    {{-- Welcome Card --}}
    <div class="bg-gradient-to-r from-serene-500 to-serene-600 text-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="mt-2 text-lg font-medium text-serene-50">
            Anda login sebagai 
            <span class="font-bold {{ Auth::user()->role === 'admin' ? 'text-red-300' : 'text-white' }}">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Action Cards --}}
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('manage.users') }}" 
               class="group block bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-serene-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center group-hover:bg-red-200 transition">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H9a1 1 0 01-1-1v-1a6 6 0 0112 0v1a1 1 0 01-1 1zm-3-9a4 4 0 100-8 4 4 0 000 8z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full">Admin</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Kelola Pengguna</h3>
                <p class="text-gray-600 mt-1 text-sm">Lihat, edit, dan atur peran pengguna</p>
                <span class="inline-block mt-4 text-red-600 font-bold text-sm group-hover:underline">Buka Panel</span>
            </a>

            <a href="{{ route('courses.index') }}" 
               class="group block bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-serene-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-serene-100 flex items-center justify-center group-hover:bg-serene-200 transition">
                        <svg class="w-7 h-7 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-serene-600 bg-serene-50 px-2 py-1 rounded-full">Semua</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Kelola Kursus</h3>
                <p class="text-gray-600 mt-1 text-sm">Lihat semua kursus di sistem</p>
                <span class="inline-block mt-4 text-serene-600 font-bold text-sm group-hover:underline">Lihat Semua</span>
            </a>

        @elseif(Auth::user()->role === 'instructor')
            <a href="{{ route('courses.index') }}" 
               class="group block bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-serene-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-serene-100 flex items-center justify-center group-hover:bg-serene-200 transition">
                        <svg class="w-7 h-7 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    @php $courseCount = Auth::user()->courses()->count(); @endphp
                    <span class="text-xs font-bold text-serene-600 bg-serene-50 px-2 py-1 rounded-full">{{ $courseCount }}</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Kursus Saya</h3>
                <p class="text-gray-600 mt-1 text-sm">Buat dan kelola kursus Anda</p>
                <span class="inline-block mt-4 text-serene-600 font-bold text-sm group-hover:underline">Kelola Kursus</span>
            </a>

            <a href="{{ route('reviews.pending') }}" 
               class="group block bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-serene-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    @php $pendingCount = Auth::user()->pendingReviewsCount() ?? 0; @endphp
                    <span class="px-2.5 py-1 text-xs font-bold text-white {{ $pendingCount > 0 ? 'bg-red-500 animate-pulse' : 'bg-gray-400' }} rounded-full">
                        {{ $pendingCount }}
                    </span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Review Tugas</h3>
                <p class="text-gray-600 mt-1 text-sm">Beri nilai dan feedback</p>
                <span class="inline-block mt-4 text-indigo-600 font-bold text-sm group-hover:underline">
                    {{ $pendingCount > 0 ? 'Lihat Tugas' : 'Tidak Ada' }}
                </span>
            </a>

            <a href="{{ route('reviews.history') }}" 
               class="group block bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-serene-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">Riwayat</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">History Review</h3>
                <p class="text-gray-600 mt-1 text-sm">Lihat tugas yang sudah direview</p>
                <span class="inline-block mt-4 text-green-600 font-bold text-sm group-hover:underline">Lihat Riwayat</span>
            </a>

        @elseif(Auth::user()->role === 'student')
            <a href="{{ route('student.dashboard') }}" 
               class="group block bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-serene-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-6 9 6M4 10h16v11H4V10z"/>
                        </svg>
                    </div>
                    @php $enrolled = Auth::user()->enrollments()->count(); @endphp
                    <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">{{ $enrolled }}</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Kursus Terdaftar</h3>
                <p class="text-gray-600 mt-1 text-sm">Lanjutkan belajar Anda</p>
                <span class="inline-block mt-4 text-purple-600 font-bold text-sm group-hover:underline">Lanjut Belajar</span>
            </a>
        @endif
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white/70 backdrop-blur-sm rounded-xl p-5 text-center border border-serene-100">
            <p class="text-2xl font-black text-serene-600">
                {{ Auth::user()->role === 'student' ? Auth::user()->enrollments()->count() : (Auth::user()->role === 'instructor' ? Auth::user()->courses()->count() : '—') }}
            </p>
            <p class="text-sm text-gray-600 mt-1">Kursus Aktif</p>
        </div>
        <div class="bg-white/70 backdrop-blur-sm rounded-xl p-5 text-center border border-serene-100">
            <p class="text-2xl font-black text-serene-600">
                {{ Auth::user()->role === 'instructor' ? Auth::user()->courses()->count() : '—' }}
            </p>
            <p class="text-sm text-gray-600 mt-1">Kursus Dibuat</p>
        </div>
        <div class="bg-white/70 backdrop-blur-sm rounded-xl p-5 text-center border border-serene-100">
            <p class="text-2xl font-black text-red-600">
                {{ Auth::user()->pendingReviewsCount() ?? 0 }}
            </p>
            <p class="text-sm text-gray-600 mt-1">Tugas Menunggu</p>
        </div>
        <div class="bg-white/70 backdrop-blur-sm rounded-xl p-5 text-center border border-serene-100">
            <p class="text-2xl font-black text-green-600">100%</p>
            <p class="text-sm text-gray-600 mt-1">Uptime</p>
        </div>
    </div>
</div>
@endsection