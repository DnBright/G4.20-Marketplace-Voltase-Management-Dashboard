<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - LowRider Admin</title>
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

<body class="flex flex-col min-h-screen">

    <nav class="bg-[#1c1c1c] border-b border-white/10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="stencil-text text-2xl text-[#75B06F] tracking-tighter">ADMIN
                HUB</a>
            <a href="{{ route('admin.dashboard') }}"
                class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-white transition-colors italic">Batal</a>
        </div>
    </nav>

    <main class="flex-1 max-w-2xl mx-auto w-full px-6 py-12">
        <h1 class="stencil-text text-4xl uppercase italic mb-10">Edit <span class="text-[#75B06F]">Barang</span></h1>

        <form action="{{ route('admin.products.update', $product) }}" method="POST"
            class="space-y-8 bg-[#1c1c1c] p-8 border border-white/10 rounded-sm">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 italic">Nama
                    Produk</label>
                <input type="text" name="name" value="{{ $product->name }}" required
                    class="w-full bg-black border border-white/10 rounded-sm px-4 py-3 focus:border-[#75B06F] outline-none transition-all italic">
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 italic">Harga
                        (Rp)</label>
                    <input type="number" name="price" value="{{ (int) $product->price }}" required
                        class="w-full bg-black border border-white/10 rounded-sm px-4 py-3 focus:border-[#75B06F] outline-none transition-all italic">
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 italic">Kategori</label>
                    <select name="category"
                        class="w-full bg-black border border-white/10 rounded-sm px-4 py-3 focus:border-[#75B06F] outline-none transition-all italic appearance-none">
                        <option value="Modifikasi" {{ $product->category == 'Modifikasi' ? 'selected' : '' }}>Modifikasi
                        </option>
                        <option value="Pakaian" {{ $product->category == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                        <option value="Aksesoris" {{ $product->category == 'Aksesoris' ? 'selected' : '' }}>Aksesoris
                        </option>
                    </select>
                </div>
            </div>

            <div>
                <label
                    class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 italic">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full bg-black border border-white/10 rounded-sm px-4 py-3 focus:border-[#75B06F] outline-none transition-all italic">{{ $product->description }}</textarea>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 italic">URL
                    Gambar (Opsional)</label>
                <input type="url" name="image" value="{{ $product->image }}"
                    class="w-full bg-black border border-white/10 rounded-sm px-4 py-3 focus:border-[#75B06F] outline-none transition-all italic">
            </div>

            <button type="submit"
                class="w-full bg-[#75B06F] text-black py-4 stencil-text text-xl hover:shadow-[0_0_20px_rgba(117,176,111,0.4)] transition-all uppercase">Update
                Barang</button>
        </form>
    </main>

</body>

</html>