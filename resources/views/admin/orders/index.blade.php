<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Order - LowRider Admin</title>
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

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1c1c1c;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #75B06F;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <!-- Navbar Admin -->
    <nav class="bg-[#1c1c1c] border-b border-white/10 px-6 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="stencil-text text-2xl text-[#75B06F] tracking-tighter">ADMIN HUB</a>
                <span class="h-6 w-px bg-white/10"></span>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 italic">Data Order</p>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-[#75B06F] transition-colors italic">Dashboard</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-[10px] font-black uppercase tracking-widest text-red-500 hover:text-white transition-colors italic">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto w-full px-6 py-8">
        <!-- Header Section -->
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h1 class="stencil-text text-4xl uppercase italic mb-1">Riwayat <span
                        class="text-[#75B06F]">Order</span>
                </h1>
                <p class="text-gray-500 text-sm italic">Menampilkan semua transaksi masuk melalui platform.</p>
            </div>
            <a href="{{ route('admin.orders.create') }}"
                class="bg-[#75B06F] text-black px-6 py-3 text-[10px] font-black uppercase tracking-widest italic hover:scale-105 transition-transform">
                Tambah Order +
            </a>
        </div>

        @if(session('success'))
            <div
                class="bg-[#75B06F]/10 border-l-4 border-[#75B06F] text-[#75B06F] p-4 mb-8 text-[10px] font-black uppercase tracking-widest flex items-center gap-3">
                <span class="text-lg">✓</span>
                {{ session('success') }}
            </div>
        @endif

        <!-- AI Recommendations Hub -->
        <div class="mb-12 animate-fade-in">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-1.5 h-6 bg-[#75B06F]"></span>
                <h2 class="stencil-text text-xl uppercase italic tracking-wider">AI <span
                        class="text-[#75B06F]">Recommendation</span> Hub</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($userRecommendations as $rec)
                    <div
                        class="bg-[#1c1c1c]/50 backdrop-blur-sm border border-white/5 p-4 relative group hover:border-[#75B06F]/30 transition-all">
                        <!-- AI Badge -->
                        <div
                            class="absolute -top-2 -right-2 bg-[#75B06F] text-black text-[7px] font-black px-2 py-0.5 uppercase tracking-[0.2em] italic shadow-lg z-10">
                            98% Match
                        </div>

                        <div class="flex flex-col gap-3">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">
                                        {{ $rec->category }}</p>
                                    <h4 class="text-[10px] font-bold text-white uppercase leading-tight line-clamp-2">
                                        {{ $rec->product_name }}</h4>
                                </div>
                            </div>
                            <div class="flex items-end justify-between border-t border-white/5 pt-3 mt-1">
                                <span class="text-xs font-black text-[#75B06F]">Rp
                                    {{ number_format($rec->price, 0, ',', '.') }}</span>
                                <span class="text-[9px] text-gray-500 font-bold uppercase italic">Affinity:
                                    {{ number_format($rec->ai_score, 1) }}</span>
                            </div>
                        </div>

                        <!-- Hover Overlay -->
                        <div
                            class="absolute inset-0 bg-[#75B06F]/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Filter & Export Section -->
        <div class="bg-[#1c1c1c] border border-white/5 p-6 mb-8 rounded-sm">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-end gap-6">
                <div class="flex-1 min-w-[200px]">
                    <label
                        class="block text-[10px] font-black font-russo uppercase tracking-widest text-gray-500 mb-2 italic">Filter
                        Bulan</label>
                    <select name="month"
                        class="w-full bg-black border border-white/10 text-xs text-white px-4 py-2.5 outline-none focus:border-[#75B06F] transition-colors">
                        <option value="">Semua Bulan</option>
                        @foreach($months as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($m)->format('F Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label
                        class="block text-[10px] font-black font-russo uppercase tracking-widest text-gray-500 mb-2 italic">Filter
                        Kategori</label>
                    <select name="category"
                        class="w-full bg-black border border-white/10 text-xs text-white px-4 py-2.5 outline-none focus:border-[#75B06F] transition-colors">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[300px] flex gap-4">
                    <div class="flex-1">
                        <label
                            class="block text-[10px] font-black font-russo uppercase tracking-widest text-gray-500 mb-2 italic">Harga
                            Min</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Rp"
                            class="w-full bg-black border border-white/10 text-xs text-white px-4 py-2.5 outline-none focus:border-[#75B06F] transition-colors">
                    </div>
                    <div class="flex-1">
                        <label
                            class="block text-[10px] font-black font-russo uppercase tracking-widest text-gray-500 mb-2 italic">Harga
                            Max</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Rp"
                            class="w-full bg-black border border-white/10 text-xs text-white px-4 py-2.5 outline-none focus:border-[#75B06F] transition-colors">
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-white/10 hover:bg-white/20 text-white px-6 py-2.5 text-[10px] font-black uppercase tracking-widest italic transition-all">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.orders.export', request()->all()) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 text-[10px] font-black uppercase tracking-widest italic transition-all flex items-center gap-2">
                        <span>Export Excel (CSV)</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-[#1c1c1c] border border-white/5 rounded-sm overflow-hidden flex flex-col shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-black/40">
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Order
                                ID</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Barang
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">
                                Kategori</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Harga
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Kota
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Rating
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Tanggal
                            </th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">
                                AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($orders as $order)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4 text-xs font-mono text-gray-500">
                                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-xs font-bold uppercase text-white group-hover:text-[#75B06F] transition-colors">{{ $order->product_name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-[10px] px-2 py-0.5 border border-white/10 rounded-full text-gray-400 uppercase tracking-tighter">{{ $order->category }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-[#75B06F]">Rp
                                    {{ number_format($order->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-400">{{ $order->city }}</td>
                                <td class="px-6 py-4 text-xs text-yellow-500">⭐ {{ number_format($order->rating, 1) }}</td>
                                <td class="px-6 py-4 text-xs text-gray-500 italic">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                                            class="text-[10px] font-black uppercase tracking-widest text-[#75B06F] hover:underline italic">Edit</a>
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus order ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-[10px] font-black uppercase tracking-widest text-red-500 hover:underline italic">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <p class="text-xs text-gray-600 uppercase tracking-widest italic font-bold">Belum ada
                                        order masuk.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-white/5 bg-black/20">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </main>

    <footer class="bg-[#1c1c1c] border-t border-white/10 py-6 mt-8">
        <div
            class="max-w-7xl mx-auto px-6 text-[10px] font-black uppercase tracking-[0.3em] text-gray-600 italic text-center">
            Dashboard Admin LowRider © 2026
        </div>
    </footer>

</body>

</html>