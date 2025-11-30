<header class="bg-white/85 backdrop-blur-xl border-b border-serene-200/50 shadow-soft sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 lg:px-6 py-4 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold bg-gradient-to-r from-serene-600 to-serene-700 bg-clip-text text-transparent">
            CourseApp
        </a>

        <div class="flex items-center gap-3">
            <span class="hidden sm:block text-sm font-medium text-serene-700">
                {{ Auth::user()->name }}
            </span>

            <button id="dark-toggle" class="p-2 rounded-xl bg-serene-100 hover:bg-serene-200 transition">
                <svg class="w-5 h-5 hidden dark:block text-serene-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.485-11.485l-.707.707M5.636 18.364l-.707.707m12.021 0l-.707-.707M5.636 5.636l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <svg class="w-5 h-5 block dark:hidden text-serene-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-gradient-to-r from-serene-500 to-serene-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:from-serene-600 hover:to-serene-700 transition shadow-md">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>

<script>
    document.getElementById('dark-toggle').addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
    });
    if (localStorage.getItem('darkMode') === 'true') document.documentElement.classList.add('dark');
</script>