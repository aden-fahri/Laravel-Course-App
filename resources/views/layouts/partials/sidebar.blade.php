{{-- resources/views/layouts/partials/sidebar.blade.php --}}
<aside class="fixed inset-y-0 left-0 z-40 w-64 bg-white/90 backdrop-blur-xl shadow-xl border-r border-serene-200/50 
               flex flex-col transition-transform duration-300 ease-in-out">
    
    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto px-6 py-8">
        <!-- User Info -->
        <div class="flex items-center gap-3 mb-8 pb-6 border-b border-serene-200/50">
            <div class="w-10 h-10 bg-gradient-to-br from-serene-500 to-serene-700 rounded-full flex items-center justify-center text-white font-black text-xl shadow-md">
                {{ Str::substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</h3>
                <p class="text-xs font-medium capitalize 
                    {{ Auth::user()->role === 'admin' ? 'text-red-600' : 'text-serene-600' }}">
                    {{ Auth::user()->role }}
                </p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1">
            @php $current = request()->route()->getName(); @endphp

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group
                      {{ request()->routeIs('dashboard') 
                         ? 'bg-gradient-to-r from-serene-100 to-serene-50 text-serene-700 shadow-sm font-bold' 
                         : 'text-gray-700 hover:bg-serene-50 hover:text-serene-700' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-serene-600' : 'text-gray-500 group-hover:text-serene-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Admin Only -->
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('manage.users') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group
                          {{ request()->routeIs('manage.users') 
                             ? 'bg-gradient-to-r from-red-100 to-pink-50 text-red-700 shadow-sm font-bold' 
                             : 'text-gray-700 hover:bg-red-50 hover:text-red-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('manage.users') ? 'text-red-600' : 'text-gray-500 group-hover:text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H9a1 1 0 01-1-1v-1a6 6 0 0112 0v1a1 1 0 01-1 1zm-3-9a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                    <span>Kelola Pengguna</span>
                </a>
            @endif

            <!-- Instructor & Admin -->
            @if(in_array(Auth::user()->role, ['instructor', 'admin']))
                <a href="{{ route('courses.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group
                          {{ request()->routeIs('courses.*') || request()->routeIs('instructor.courses.*')
                             ? 'bg-gradient-to-r from-serene-100 to-serene-50 text-serene-700 shadow-sm font-bold' 
                             : 'text-gray-700 hover:bg-serene-50 hover:text-serene-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('courses.*') || request()->routeIs('instructor.courses.*') ? 'text-serene-600' : 'text-gray-500 group-hover:text-serene-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Kursus Saya</span>
                </a>

                @php $pendingCount = Auth::user()->pendingReviewsCount() ?? 0; @endphp
                <a href="{{ route('reviews.pending') }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-xl font-medium transition group
                          {{ request()->routeIs('reviews.pending') 
                             ? 'bg-gradient-to-r from-serene-100 to-serene-50 text-serene-700 shadow-sm font-bold' 
                             : 'text-gray-700 hover:bg-serene-50 hover:text-serene-700' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('reviews.pending') ? 'text-serene-600' : 'text-gray-500 group-hover:text-serene-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Review Tugas Siswa</span>
                    </div>
                    @if($pendingCount > 0)
                        <span class="px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('reviews.history') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group
                          {{ request()->routeIs('reviews.history') 
                             ? 'bg-gradient-to-r from-serene-100 to-serene-50 text-serene-700 shadow-sm font-bold' 
                             : 'text-gray-700 hover:bg-serene-50 hover:text-serene-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('reviews.history') ? 'text-serene-600' : 'text-gray-500 group-hover:text-serene-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span>History Tugas</span>
                </a>
            @endif

            <!-- Student Only -->
            @if(Auth::user()->role === 'student')
                <a href="{{ route('courses.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group
                          {{ request()->routeIs('courses.*') 
                             ? 'bg-gradient-to-r from-serene-100 to-serene-50 text-serene-700 shadow-sm font-bold' 
                             : 'text-gray-700 hover:bg-serene-50 hover:text-serene-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('courses.*') ? 'text-serene-600' : 'text-gray-500 group-hover:text-serene-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Kursus</span>
                </a>
                <a href="{{ route('student.dashboard') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group
                        {{ request()->routeIs('student.*') 
                            ? 'bg-gradient-to-r from-serene-100 to-serene-50 text-serene-700 shadow-sm font-bold' 
                            : 'text-gray-700 hover:bg-serene-50 hover:text-serene-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('student.*') ? 'text-serene-600' : 'text-gray-500 group-hover:text-serene-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-6 9 6M4 10h16v11H4V10z"/>
                    </svg>
                    <span>Kursus Terdaftar</span>
                </a>
            @endif

            <!-- Sedang di Kursus (Materi) -->
            @if($isInCourse ?? false)
                @php
                    $course = request()->route('course');
                    $courseId = is_object($course) ? $course->id : $course;
                @endphp

                @if($courseId)
                    <div class="mt-8 pt-6 border-t border-serene-200/50">
                        <p class="text-xs font-bold text-serene-500 uppercase tracking-wider mb-3 px-4">
                            Sedang di Kursus
                        </p>

                        {{-- Link Materi Kursus --}}
                        <a href="{{ route('lessons.index', $courseId) }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group
                                {{ request()->routeIs('lessons.*') 
                                    ? 'bg-gradient-to-r from-serene-100 to-serene-50 text-serene-700 shadow-sm font-bold' 
                                    : 'text-gray-700 hover:bg-serene-50 hover:text-serene-700' }}">
                            <svg class="w-5 h-5 
                                        {{ request()->routeIs('lessons.*') 
                                            ? 'text-serene-600' 
                                            : 'text-gray-500 group-hover:text-serene-600' }}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Materi Kursus</span>
                        </a>

                        {{-- Link Kursus Saya --}}
                        <a href="{{ route('courses.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group
                                {{ request()->routeIs('instructor.courses.*') || request()->routeIs('courses.*') 
                                    ? 'bg-gradient-to-r from-serene-100 to-serene-50 text-serene-700 shadow-sm font-bold' 
                                    : 'text-gray-700 hover:bg-serene-50 hover:text-serene-700' }}">
                            <svg class="w-5 h-5 
                                        {{ request()->routeIs('instructor.courses.*') || request()->routeIs('courses.*') 
                                            ? 'text-serene-600' 
                                            : 'text-gray-500 group-hover:text-serene-600' }}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span>Kursus Saya</span>
                        </a>
                    </div>
                @endif
            @endif
        </nav>
    </div>
</aside>