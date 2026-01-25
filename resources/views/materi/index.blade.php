<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi - Bursa Low Rider</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Russo+One&family=Inter:wght@400;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#75B06F',
                        'street-black': '#0a0a0a',
                        'street-grey': '#1c1c1c',
                    },
                    fontFamily: {
                        'bebas': ['"Bebas Neue"', 'cursive'],
                        'stencil': ['"Russo One"', 'sans-serif'],
                        'inter': ['"Inter"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0a0a0a;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        .stencil-text {
            font-family: 'Russo One', sans-serif;
        }
    </style>
</head>

<body class="selection:bg-brand-green selection:text-black">
    <nav class="sticky top-0 z-50 bg-[#0a0a0a]/90 backdrop-blur-md border-b border-brand-green/20 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="/" class="text-3xl stencil-text text-brand-green tracking-tighter">LOW<span
                    class="text-white">RIDER</span></a>
            <div class="flex items-center gap-6">
                <a href="/materi" class="text-xs font-black uppercase tracking-widest text-brand-green">Materi</a>
                @auth
                    <a href="/dashboard"
                        class="text-xs font-black uppercase tracking-widest hover:text-brand-green transition-colors">Dashboard</a>
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-xs font-black uppercase tracking-widest text-red-500 hover:text-white transition-colors">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xs font-black uppercase tracking-widest hover:text-brand-green transition-colors">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-12">
        <div class="mb-12">
            <h1 class="stencil-text text-5xl mb-4 text-white">Materi Pembelajaran</h1>
            <p class="text-gray-400">Sistem Rekomendasi - Silabus & Topik</p>
        </div>

        <div class="bg-street-grey border border-white/10 rounded-sm p-8">
            <img src="/materi.png" alt="Materi Pembelajaran" class="w-full h-auto rounded-sm shadow-2xl">
        </div>
    </main>

    <footer class="bg-street-grey py-8 border-t border-white/10 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center text-xs font-bold uppercase tracking-widest text-gray-600">
            &copy; 2026 Bursa Low Rider. Street Certified.
        </div>
    </footer>
</body>

</html>