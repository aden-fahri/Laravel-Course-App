{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CourseApp')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        html { scroll-behavior: smooth; -webkit-font-smoothing: antialiased; }
        *, *::before, *::after { transform: translateZ(0); backface-visibility: hidden; }
        img { image-rendering: -webkit-optimize-contrast; }

        button:focus-visible, a:focus-visible {
            outline: 2px solid #2dd4bf;
            outline-offset: 2px;
        }

        .content-card {
            background: rgba(255, 255, 255, 0.95);
        }
        .dark .content-card {
            background: rgba(54, 61, 77, 0.95); /* gray-900 transparan */
            border-color: #657185; /* gray-700 */
        }

        @media (min-width: 768px) {
            .content-card { padding: 2rem; }
        }
    </style>
</head>
<body class="bg-serene-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen font-sans">

    {{-- Header (Navbar atas) --}}
    @include('layouts.partials.header')

    {{-- Layout Utama: Sidebar Fixed + Content dengan padding kiri --}}
    <div class="flex">
        {{-- Sidebar: Hanya muncul di desktop (lg+) --}}
        <div class="hidden lg:block">
            @include('layouts.partials.sidebar')
        </div>

        {{-- Main Content: Kasih margin kiri biar nggak ketutupan sidebar fixed --}}
        <main class="flex-1 min-h-screen lg:ml-64 transition-all duration-300">
            <div class="p-4 md:p-6 lg:p-8">
                <div class="max-w-5xl mx-auto">
                    <div class="content-card">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    @stack('scripts')
</body>
</html>