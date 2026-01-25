<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembeli - Bursa Low Rider</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Russo+One&family=Inter:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Midtrans Snap -->
    <script type="text/javascript"
        src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
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
                 <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Yo, {{ Auth::user()->name }}</span>
                 <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-black uppercase tracking-widest text-red-500 hover:text-white transition-colors">Cabut (Logout)</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-12">
            <h1 class="stencil-text text-4xl mb-2 text-white">Garage Sale</h1>
            <p class="text-gray-400">Sikat barang impian lo sebelum diambil orang.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
            <div class="group bg-street-grey border border-white/5 rounded-sm overflow-hidden hover:border-brand-green/50 transition-all duration-300">
                <div class="relative h-[300px] overflow-hidden">
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1552346154-21d32810aba3?q=80&w=1000&auto=format&fit=crop' }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-street-black via-transparent to-transparent opacity-80"></div>
                    <div class="absolute bottom-4 left-4">
                         <span class="text-brand-green font-black uppercase tracking-widest text-xs mb-1 block">{{ $product->category }}</span>
                         <h3 class="stencil-text text-2xl">{{ $product->name }}</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                             <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Harga</p>
                             <p class="text-2xl font-black italic">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('product.show', $product) }}" 
                       class="block w-full bg-white text-black text-center py-3 font-bold uppercase tracking-widest hover:bg-brand-green transition-colors stencil-text rounded-sm">
                        Lihat & Beli
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <footer class="bg-street-grey py-8 border-t border-white/10 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center text-xs font-bold uppercase tracking-widest text-gray-600">
            &copy; 2026 Bursa Low Rider. Street Certified.
        </div>
    </footer>
</body>
</html>
