<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar ke CourseApp</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-serene-50 via-white to-serene-100 min-h-screen flex items-center justify-center p-4 font-sans">

    <!-- Card Utama (Centered) -->
    <div class="w-full max-w-md">
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-serene-200/50">

            <!-- Logo + Tagline -->
            <div class="text-center mb-10">
                <div class="w-20 h-20 bg-gradient-to-br from-serene-500 to-serene-600 rounded-2xl mx-auto mb-5 flex items-center justify-center shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-serene-800">CourseApp</h1>
                <p class="text-serene-600 text-sm mt-2">Mulai belajar, wujudkan mimpi</p>
            </div>

            <!-- Alert Error -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="student">

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3.5 bg-serene-50/50 border border-serene-300 rounded-xl focus:ring-2 focus:ring-serene-500 focus:border-serene-500 focus:bg-white transition-all duration-200 placeholder:text-serene-400"
                           placeholder="Nama">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3.5 bg-serene-50/50 border border-serene-300 rounded-xl focus:ring-2 focus:ring-serene-500 focus:border-serene-500 focus:bg-white transition-all duration-200 placeholder:text-serene-400"
                           placeholder="you@example.com">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3.5 bg-serene-50/50 border border-serene-300 rounded-xl focus:ring-2 focus:ring-serene-500 focus:border-serene-500 focus:bg-white transition-all duration-200"
                           placeholder="Minimal 8 karakter">
                </div>

                <!-- Konfirmasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3.5 bg-serene-50/50 border border-serene-300 rounded-xl focus:ring-2 focus:ring-serene-500 focus:border-serene-500 focus:bg-white transition-all duration-200"
                           placeholder="Ulangi password">
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-serene-600 to-serene-700 text-white font-bold py-3.5 rounded-xl hover:from-serene-700 hover:to-serene-800 transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Login Link -->
            <p class="text-center mt-8 text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login.page') }}" class="font-bold text-serene-600 hover:text-serene-700 transition">
                    Masuk di sini
                </a>
            </p>
        </div>

        <!-- Footer Text -->
        <p class="text-center mt-6 text-xs text-serene-500">
            © {{ date('Y') }} CourseApp by Mizuki
        </p>
    </div>
</body>
</html>