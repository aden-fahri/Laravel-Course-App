{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseApp - Kelola Kursus & Tugas dengan Mudah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-serene-50 to-white text-gray-800 antialiased">

    <!-- Header / Navbar (Desktop Only) -->
    <header class="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur-md z-50 shadow-soft border-b border-serene-100">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-18">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-2 group">
                    <div class="w-11 h-11 bg-gradient-to-br from-serene-500 to-serene-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-card group-hover:shadow-float transition-shadow">
                        CA
                    </div>
                    <span class="font-bold text-xl text-gray-800">CourseApp</span>
                </a>

                <!-- Desktop Menu (Selalu Tampil) -->
                <div class="flex items-center gap-10">
                    <a href="#about" class="text-gray-600 hover:text-serene-600 font-medium transition">Tentang</a>
                    <a href="#features" class="text-gray-600 hover:text-serene-600 font-medium transition">Fitur</a>
                    <div class="flex gap-3">
                        {{-- GANTI route('login') → route('login.page') --}}
                        <a href="{{ route('login.page') }}" class="px-5 py-2.5 text-serene-600 font-semibold hover:text-serene-700 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-serene-600 text-white font-bold rounded-xl hover:bg-serene-700 transition shadow-card hover:shadow-float">
                            Daftar Gratis
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-gray-900 leading-tight">
                Kelola Kursus <span class="text-serene-600">Lebih Efisien</span>
            </h1>
            <p class="mt-6 text-xl text-gray-600 max-w-3xl mx-auto">
                Platform modern untuk pengajar dan siswa. Buat kursus, kirim tugas, review, dan pantau progress — semuanya terintegrasi.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-serene-600 text-white font-bold text-lg rounded-2xl hover:bg-serene-700 transition shadow-card hover:shadow-float">
                    Mulai Gratis
                </a>
                <a href="#features" class="px-8 py-4 bg-white text-serene-600 font-bold text-lg rounded-2xl border-2 border-serene-600 hover:bg-serene-50 transition">
                    Lihat Fitur
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-6 lg:px-8 bg-serene-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900">Apa itu CourseApp?</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Sistem manajemen kursus dan tugas berbasis web yang dirancang untuk meningkatkan produktivitas pengajar dan siswa.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-card text-center hover:shadow-float transition">
                    <div class="w-16 h-16 bg-serene-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Tugas Fleksibel</h3>
                    <p class="text-gray-600">File, teks, link, atau campuran — semua didukung.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-card text-center hover:shadow-float transition">
                    <div class="w-16 h-16 bg-serene-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Review Instan</h3>
                    <p class="text-gray-600">Approve atau reject dengan feedback langsung.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-card text-center hover:shadow-float transition">
                    <div class="w-16 h-16 bg-serene-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-serene-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Progress Otomatis</h3>
                    <p class="text-gray-600">Siswa otomatis maju setelah tugas disetujui.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900">Fitur Unggulan</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-10">
                <div class="flex gap-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-serene-600 text-white rounded-xl flex items-center justify-center font-bold text-lg">
                        1
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Dashboard Terpusat</h3>
                        <p class="text-gray-600">Pantau semua kursus, tugas, dan siswa dalam satu tempat.</p>
                    </div>
                </div>

                <div class="flex gap-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-serene-600 text-white rounded-xl flex items-center justify-center font-bold text-lg">
                        2
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Revisi Mudah</h3>
                        <p class="text-gray-600">Siswa bisa revisi tugas yang ditolak dengan cepat.</p>
                    </div>
                </div>

                <div class="flex gap-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-serene-600 text-white rounded-xl flex items-center justify-center font-bold text-lg">
                        3
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Manajemen Kursus</h3>
                        <p class="text-gray-600">Buat, edit, dan atur kursus dengan mudah.</p>
                    </div>
                </div>

                <div class="flex gap-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-serene-600 text-white rounded-xl flex items-center justify-center font-bold text-lg">
                        4
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Akses di Mana Saja</h3>
                        <p class="text-gray-600">Gunakan di laptop, tablet, atau ponsel.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-6 lg:px-8 bg-serene-600">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-white mb-6">
                Mulai Kelola Kursus Anda Sekarang
            </h2>
            <p class="text-xl text-serene-100 mb-8">
                Daftar gratis dan rasakan kemudahan CourseApp.
            </p>
            <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white text-serene-600 font-bold text-lg rounded-2xl hover:bg-serene-50 transition shadow-card hover:shadow-float">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-sm">
                © {{ date('Y') }} CourseApp. Dibuat dengan 
                <span class="text-red-500">❤</span> untuk pendidikan.
            </p>
        </div>
    </footer>

    <!-- Smooth Scroll Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>