<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - LowRider</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Russo+One&family=Inter:wght@400;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0a0a;
            color: #ffffff;
        }

        .stencil-text {
            font-family: 'Russo One', sans-serif;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-[#1c1c1c] p-8 border border-white/10 rounded-sm">
        <div class="text-center mb-10">
            <h1 class="stencil-text text-3xl text-[#75B06F] tracking-tighter mb-2">LOWRIDER ADMIN</h1>
            <p class="text-gray-500 text-xs uppercase tracking-[0.2em]">Akses Terbatas Jalanan</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 mb-6 text-sm italic">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 italic">Email
                    Admin</label>
                <input type="email" name="email" required
                    class="w-full bg-black border border-white/10 rounded-sm px-4 py-3 placeholder:text-gray-700 focus:border-[#75B06F] outline-none transition-all italic">
            </div>
            <div>
                <label
                    class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 italic">Password</label>
                <input type="password" name="password" required
                    class="w-full bg-black border border-white/10 rounded-sm px-4 py-3 placeholder:text-gray-700 focus:border-[#75B06F] outline-none transition-all italic">
            </div>
            <button type="submit"
                class="w-full bg-[#75B06F] text-black py-4 stencil-text text-xl hover:shadow-[0_0_20px_rgba(117,176,111,0.4)] transition-all uppercase">MASUK
                SEKARANG</button>
        </form>

        <div class="mt-8 text-center">
            <a href="/"
                class="text-[10px] font-black text-gray-600 hover:text-white uppercase tracking-widest italic transition-colors">Kembali
                ke Aspal</a>
        </div>
    </div>
</body>

</html>