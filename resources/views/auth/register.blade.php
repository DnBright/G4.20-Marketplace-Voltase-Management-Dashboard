<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Bursa Low Rider</title>
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

<body class="flex items-center justify-center min-h-screen bg-street-black py-10">
    <div class="w-full max-w-md p-8 bg-street-grey border border-white/10 rounded-sm shadow-2xl">
        <div class="text-center mb-10">
            <h1 class="text-3xl stencil-text text-brand-green tracking-tighter mb-2">LOW<span
                    class="text-white">RIDER</span></h1>
            <p class="text-gray-400 text-sm uppercase tracking-widest">Gabung Komunitas</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-900/20 border border-red-500/50 text-red-500 p-4 mb-6 text-sm rounded-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Nama
                    Panggilan</label>
                <input type="text" name="name" id="name" required
                    class="w-full bg-street-black border border-white/20 p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition-colors rounded-sm"
                    placeholder="Siapa nama beken lo?">
            </div>

            <div>
                <label for="email"
                    class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full bg-street-black border border-white/20 p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition-colors rounded-sm"
                    placeholder="email@jalan.com">
            </div>

            <div>
                <label for="password"
                    class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full bg-street-black border border-white/20 p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition-colors rounded-sm"
                    placeholder="Minimal 8 karakter bro">
            </div>

            <div>
                <label for="password_confirmation"
                    class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Konfirmasi
                    Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full bg-street-black border border-white/20 p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition-colors rounded-sm"
                    placeholder="Ulangi lagi passwordnya">
            </div>

            <button type="submit"
                class="w-full bg-brand-green text-black font-bold uppercase tracking-widest py-4 hover:bg-white transition-colors stencil-text rounded-sm">
                Gas Daftar!
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-500 text-sm">Udah punya akun? <a href="{{ route('login') }}"
                    class="text-brand-green hover:text-white transition-colors underline decoration-brand-green/30">Login
                    sini</a></p>
        </div>

        <div class="mt-4 text-center">
            <a href="/" class="text-xs text-gray-600 hover:text-gray-400 transition-colors">Kembali ke Aspal</a>
        </div>
    </div>
</body>

</html>