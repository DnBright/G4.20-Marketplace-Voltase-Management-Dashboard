<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - LowRider Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Russo+One&family=Inter:wght@400;700;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0a0a;
            color: #ffffff;
        }

        .stencil-text {
            font-family: 'Russo One', sans-serif;
        }

        .input-dark {
            background-color: #1c1c1c;
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 2px;
            font-size: 0.875rem;
            width: 100%;
            outline: none;
            transition: all 0.2s;
        }

        .input-dark:focus {
            border-color: #75B06F;
            background-color: #252525;
        }

        label {
            display: block;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #555;
            margin-bottom: 0.5rem;
            font-style: italic;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <nav class="bg-[#1c1c1c] border-b border-white/10 px-6 py-4 sticky top-0 z-50">
        <div class="max-w-3xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="stencil-text text-2xl text-[#75B06F] tracking-tighter">ADMIN HUB</a>
                <span class="h-6 w-px bg-white/10"></span>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 italic">Edit Order
                    #{{ $order->id }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-white transition-colors italic">Batal</a>
        </div>
    </nav>

    <main class="flex-1 max-w-3xl mx-auto w-full px-6 py-12">
        <div class="mb-10">
            <h1 class="stencil-text text-4xl uppercase italic mb-1">Update <span class="text-[#75B06F]">Data</span></h1>
            <p class="text-gray-500 text-sm italic">Modifikasi informasi transaksi yang sudah ada.</p>
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST"
            class="bg-[#1c1c1c] border border-white/5 p-8 shadow-2xl space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label>Nama Barang / Produk</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $order->product_name) }}"
                        class="input-dark" required>
                    @error('product_name') <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}
                    </p> @enderror
                </div>
                <div>
                    <label>Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $order->category) }}"
                        class="input-dark" required>
                    @error('category') <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label>Harga (IDR)</label>
                    <input type="number" name="price" value="{{ old('price', (int) $order->price) }}" class="input-dark"
                        required>
                    @error('price') <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Kota Tujuan</label>
                    <input type="text" name="city" value="{{ old('city', $order->city) }}" class="input-dark" required>
                    @error('city') <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label>Rating Kepuasan (0.0 - 5.0)</label>
                <input type="number" step="0.1" name="rating" min="0" max="5"
                    value="{{ old('rating', $order->rating) }}" class="input-dark" required>
                @error('rating') <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-white/5 flex justify-end">
                <button type="submit"
                    class="bg-[#75B06F] text-black px-10 py-4 text-[10px] font-black uppercase tracking-widest italic hover:scale-105 transition-transform">
                    Update Order ✓
                </button>
            </div>
        </form>
    </main>

    <footer class="bg-[#1c1c1c] border-t border-white/10 py-6 mt-12">
        <div
            class="max-w-7xl mx-auto px-6 text-[10px] font-black uppercase tracking-[0.3em] text-gray-600 italic text-center">
            Dashboard Admin LowRider © 2026
        </div>
    </footer>

</body>

</html>