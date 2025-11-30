{{-- resources/views/admin/manage-users.blade.php --}}
@extends('layouts.app')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
            <p class="text-sm text-gray-600 mt-1">Ubah role atau hapus pengguna dari sistem</p>
        </div>
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 text-serene-600 hover:text-serene-700 font-medium text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-serene-50 border border-serene-200 text-serene-800 px-5 py-3.5 rounded-xl mb-6 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-serene-600 to-serene-700 text-white text-left text-sm font-semibold">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role Saat Ini</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-serene-50/50 transition text-sm">
                            <td class="px-6 py-4 text-gray-600 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-serene-500 to-serene-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 
                                       ($user->role === 'instructor' ? 'bg-blue-100 text-blue-700' : 
                                       'bg-serene-100 text-serene-700') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <!-- Change Role -->
                                    <form action="{{ route('update.role', $user->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <select name="role" onchange="this.form.submit()"
                                                class="text-xs px-3 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-serene-500 focus:border-serene-500 cursor-pointer transition">
                                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="instructor" {{ $user->role === 'instructor' ? 'selected' : '' }}>Instructor</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>

                                    <!-- Delete (kecuali diri sendiri) -->
                                    @if(Auth::id() !== $user->id)
                                        <form action="{{ route('delete.user', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus {{ addslashes($user->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-700 font-medium text-xs transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">Diri sendiri</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <p class="text-sm font-medium">Belum ada pengguna terdaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection