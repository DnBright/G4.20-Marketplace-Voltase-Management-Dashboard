<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LowRider</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Russo+One&family=Inter:wght@300;400;600;800&display=swap');

        :root {
            --primary: #75B06F;
            --primary-glow: rgba(117, 176, 111, 0.4);
            --bg: #050505;
            --card-bg: rgba(26, 26, 26, 0.6);
            --border: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: #ffffff;
            overflow-x: hidden;
        }

        .stencil-text {
            font-family: 'Russo One', sans-serif;
        }

        /* Glassmorphism Card */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 32px var(--primary-glow);
            transform: translateY(-4px);
        }

        /* Ambient Glow Background */
        .ambient-glow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 80% 20%, rgba(117, 176, 111, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 10% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
            z-index: -1;
            pointer-events: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -2px;
            background: linear-gradient(to bottom right, #fff, #75B06F);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">
    <div class="ambient-glow"></div>

    <!-- Navbar Admin -->
    <nav class="bg-black/50 backdrop-blur-md border-b border-white/5 px-8 py-4 sticky top-0 z-50">
        <div class="max-w-[1400px] mx-auto flex items-center justify-between">
            <div class="flex items-center gap-8">
                <div class="flex flex-col">
                    <span class="stencil-text text-2xl text-[#75B06F] tracking-tighter leading-none">ADMIN HUB</span>
                    <span class="text-[8px] font-bold uppercase tracking-[0.4em] text-gray-500 mt-1">Advanced
                        Analytics</span>
                </div>
                <div class="h-8 w-px bg-white/10 hidden md:block"></div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-[10px] font-black uppercase tracking-widest text-[#75B06F] italic">Dashboard</a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-white transition-colors italic">Data
                        Order</a>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right hidden sm:block">
                    <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest leading-none">Logged In As
                    </p>
                    <p class="text-xs font-bold text-white">{{ auth()->user()->name }}</p>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-4 py-2 border border-red-500/20 rounded-sm text-[10px] font-black uppercase tracking-widest transition-all italic">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-[1400px] mx-auto w-full px-8 py-10">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12 animate-fade-in">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-8 h-1 bg-[#75B06F]"></span>
                    <p class="text-[#75B06F] text-[10px] font-black uppercase tracking-[0.3em]">Real-time Performance
                    </p>
                </div>
                <h1 class="stencil-text text-5xl md:text-6xl uppercase italic leading-none">
                    Command <span class="text-[#75B06F]">Center</span>
                </h1>
                <p class="text-gray-500 text-sm mt-4 max-w-xl font-medium">
                    Welcome back, Manager. All systems are operational. Tracking <span
                        class="text-white">{{ $totalOrders }} orders</span> across multiple sectors.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <select id="analysisType"
                        class="bg-black border border-white/10 text-[10px] font-black uppercase tracking-widest text-[#75B06F] outline-none px-6 py-4 rounded-sm appearance-none cursor-pointer hover:border-[#75B06F] transition-all italic pr-12">
                        <option value="trending">Market Trend (AI)</option>
                        <option value="sold">Paling Laku (Terbanyak)</option>
                        <option value="rating">Rating Terbaik</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                        <span class="text-[8px]">▼</span>
                    </div>
                </div>
                <button id="btnAnalyze"
                    class="group relative overflow-hidden bg-[#75B06F] text-black px-8 py-4 rounded-sm transition-all hover:scale-105 active:scale-95 shadow-[0_0_20px_rgba(117,176,111,0.3)]">
                    <span class="relative z-10 stencil-text text-sm uppercase italic">Run Market Analysis ⚡</span>
                    <div
                        class="absolute inset-0 bg-white translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    </div>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div
                class="bg-[#75B06F]/10 border-l-4 border-[#75B06F] text-[#75B06F] p-5 mb-10 text-xs font-bold uppercase tracking-widest flex items-center gap-4 animate-fade-in">
                <span class="text-xl">✓</span>
                {{ session('success') }}
            </div>
        @endif

        <!-- Top Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total Revenue -->
            <div class="glass-card p-6 animate-fade-in delay-1 overflow-hidden relative">
                <div class="relative z-10">
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Net Sales Revenue</p>
                    <p class="text-2xl font-black text-white italic">Rp
                        {{ number_format($totalSalesValuation, 0, ',', '.') }}</p>
                    <div class="mt-4 flex items-center gap-2 text-[10px]">
                        <span class="text-[#75B06F] font-bold">+12.5%</span>
                        <span class="text-gray-600 uppercase">vs last month</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <span class="stencil-text text-8xl italic">$$</span>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="glass-card p-6 animate-fade-in delay-1 overflow-hidden relative">
                <div class="relative z-10">
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Total Transactions
                    </p>
                    <p class="text-3xl font-black text-white italic">{{ $totalOrders }} <span
                            class="text-sm font-normal text-gray-500 not-italic">Items</span></p>
                    <div class="mt-4 flex items-center gap-2 text-[10px]">
                        <span class="text-[#75B06F] font-bold">Live</span>
                        <span class="text-gray-600 uppercase">System Active</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <span class="stencil-text text-8xl italic">OK</span>
                </div>
            </div>

            <!-- Avg Rating -->
            <div class="glass-card p-6 animate-fade-in delay-1 overflow-hidden relative">
                <div class="relative z-10">
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Customer Satisfaction
                    </p>
                    <p class="text-3xl font-black text-yellow-500 italic">⭐ {{ number_format($avgRating, 1) }}</p>
                    <div class="mt-4 flex items-center gap-2 text-[10px]">
                        <span class="text-yellow-500 font-bold">Excellent</span>
                        <span class="text-gray-600 uppercase">User Feedback</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <span class="stencil-text text-8xl italic">SAT</span>
                </div>
            </div>

            <!-- Total Cities -->
            <div class="glass-card p-6 animate-fade-in delay-1 overflow-hidden relative">
                <div class="relative z-10">
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Regional Reach</p>
                    <p class="text-3xl font-black text-blue-400 italic">{{ count($cities) }} <span
                            class="text-sm font-normal text-gray-500 not-italic">Cities</span></p>
                    <div class="mt-4 flex items-center gap-2 text-[10px]">
                        <span class="text-blue-400 font-bold">Expanding</span>
                        <span class="text-gray-600 uppercase">Market Coverage</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <span class="stencil-text text-8xl italic">MAP</span>
                </div>
            </div>
        </div>

        <!-- Main Insights Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Left Side: Main Growth Chart -->
            <div class="lg:col-span-2 glass-card p-8 animate-fade-in delay-2">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-[#75B06F] mb-1">Growth Dynamics
                        </h3>
                        <p class="text-2xl font-black italic uppercase">Financial Stream</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#75B06F]"></span>
                        <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Monthly
                            Revenue</span>
                    </div>
                </div>
                <div class="h-80 w-full">
                    <canvas id="chartMainLine"></canvas>
                </div>
            </div>

            <!-- Right Side: Category Breakdown -->
            <div class="glass-card p-8 animate-fade-in delay-2">
                <h3 class="text-xs font-black uppercase tracking-widest text-[#75B06F] mb-1">Sector Analysis</h3>
                <p class="text-2xl font-black italic uppercase mb-8">Best Sellers</p>
                <div class="relative h-64 flex items-center justify-center">
                    <canvas id="chartBigDonut"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-[10px] text-gray-500 uppercase font-black tracking-[0.3em]">Total</span>
                        <span class="stencil-text text-3xl">{{ $totalOrders }}</span>
                    </div>
                </div>
                <div id="customLegend" class="mt-8 grid grid-cols-2 gap-3">
                    <!-- Legend will be populated via JS -->
                </div>
            </div>
        </div>

        <!-- AI-Based Prediction Analysis (Collaborative Filtering) -->
        <div id="analysisSection" class="hidden mb-12">
            <div id="analysisLoading" class="hidden glass-card p-12 text-center mb-12">
                <div class="flex flex-col items-center gap-6">
                    <div
                        class="w-16 h-16 border-4 border-[#75B06F]/20 border-t-[#75B06F] rounded-full animate-spin shadow-[0_0_15px_#75B06F]">
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="stencil-text text-xl animate-pulse text-[#75B06F]">Processing Neural Matrix...</p>
                        <p class="text-[10px] text-gray-500 uppercase tracking-[0.4em]">Collaborative Filtering Activity
                            Detected</p>
                    </div>
                </div>
            </div>

            <div id="analysisResults" class="hidden animate-fade-in">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-[#75B06F] mb-1 italic">Intelligence
                            Report</h3>
                        <p id="resultTitle" class="text-3xl font-black italic uppercase">Market Trend Analysis</p>
                        <p id="resultFormula" class="text-[9px] text-gray-500 uppercase tracking-widest mt-1">Formula:
                            User-Based Collaborative Filtering Weighted</p>
                    </div>
                    <div class="px-4 py-2 bg-[#75B06F]/10 border border-[#75B06F]/20 rounded-sm">
                        <span class="text-[10px] font-black text-[#75B06F] uppercase tracking-widest italic leading-none">AI
                            INSIGHT: READY</span>
                    </div>
                </div>

                <!-- Trending (AI) Container -->
                <div id="container-trending" class="analysis-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($globalRecommendations as $rec)
                        <div class="glass-card p-6 flex flex-col group relative overflow-hidden border-l-2 border-[#75B06F]">
                            <div
                                class="absolute top-0 right-0 bg-[#75B06F] text-black px-3 py-1 text-[8px] font-black uppercase tracking-widest italic z-10">
                                Growth Index: {{ number_format($rec->ai_score, 2) }}
                            </div>
                            <div class="flex gap-4 mb-4">
                                <div
                                    class="w-16 h-16 bg-black border border-white/5 rounded-sm flex items-center justify-center group-hover:border-[#75B06F]/50 transition-colors">
                                    <span class="stencil-text text-xl text-gray-700 italic">BEST</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">
                                        {{ $rec->category }}</p>
                                    <h4 class="text-xs font-bold text-white uppercase leading-tight line-clamp-2">
                                        {{ $rec->product_name }}</h4>
                                </div>
                            </div>
                            <div class="mt-auto pt-4 border-t border-white/5 flex items-end justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-500 uppercase font-bold italic mb-0.5">Focus Point</p>
                                    <p class="text-sm font-black text-[#75B06F]">Rp
                                        {{ number_format($rec->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[9px] text-gray-500 uppercase font-bold italic mb-0.5">Confidence</p>
                                    <span class="text-xs font-black text-white italic">⭐
                                        {{ number_format($rec->rating, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Most Sold Container -->
                <div id="container-sold"
                    class="analysis-container hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($mostSoldProducts as $rec)
                        <div class="glass-card p-6 flex flex-col group relative overflow-hidden border-l-2 border-blue-500">
                            <div
                                class="absolute top-0 right-0 bg-blue-500 text-white px-3 py-1 text-[8px] font-black uppercase tracking-widest italic z-10">
                                Total Sold: {{ number_format($rec->ai_score, 0) }}
                            </div>
                            <div class="flex gap-4 mb-4">
                                <div
                                    class="w-16 h-16 bg-black border border-white/5 rounded-sm flex items-center justify-center group-hover:border-blue-500/50 transition-colors">
                                    <span class="stencil-text text-xl text-gray-700 italic">HOT</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">
                                        {{ $rec->category }}</p>
                                    <h4 class="text-xs font-bold text-white uppercase leading-tight line-clamp-2">
                                        {{ $rec->product_name }}</h4>
                                </div>
                            </div>
                            <div class="mt-auto pt-4 border-t border-white/5 flex items-end justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-500 uppercase font-bold italic mb-0.5">Market Price</p>
                                    <p class="text-sm font-black text-blue-500">Rp
                                        {{ number_format($rec->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[9px] text-gray-500 uppercase font-bold italic mb-0.5">Customer Rating
                                    </p>
                                    <span class="text-xs font-black text-white italic">⭐
                                        {{ number_format($rec->rating, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Top Rated Container -->
                <div id="container-rating"
                    class="analysis-container hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($topRatedProducts as $rec)
                        <div class="glass-card p-6 flex flex-col group relative overflow-hidden border-l-2 border-yellow-500">
                            <div
                                class="absolute top-0 right-0 bg-yellow-500 text-black px-3 py-1 text-[8px] font-black uppercase tracking-widest italic z-10">
                                Rating: {{ number_format($rec->ai_score, 1) }}
                            </div>
                            <div class="flex gap-4 mb-4">
                                <div
                                    class="w-16 h-16 bg-black border border-white/5 rounded-sm flex items-center justify-center group-hover:border-yellow-500/50 transition-colors">
                                    <span class="stencil-text text-xl text-gray-700 italic">TOP</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1 italic">
                                        {{ $rec->category }}</p>
                                    <h4 class="text-xs font-bold text-white uppercase leading-tight line-clamp-2">
                                        {{ $rec->product_name }}</h4>
                                </div>
                            </div>
                            <div class="mt-auto pt-4 border-t border-white/5 flex items-end justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-500 uppercase font-bold italic mb-0.5">Premium Price</p>
                                    <p class="text-sm font-black text-yellow-500">Rp
                                        {{ number_format($rec->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[9px] text-gray-500 uppercase font-bold italic mb-0.5">Quality Assurance
                                    </p>
                                    <span class="text-xs font-black text-white italic">⭐
                                        {{ number_format($rec->rating, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 p-4 bg-white/5 border border-white/10 rounded-sm">
                    <p class="text-[10px] text-[#75B06F] font-black uppercase tracking-[0.2em] italic mb-1">💡 Strategy
                        Tip:</p>
                    <p id="resultTip" class="text-[11px] text-gray-400 italic">Produk di atas memiliki probabilitas
                        transaksi tertinggi bulan ini. Fokuskan stok dan marketing pada item ini untuk memaksimalkan profit.
                    </p>
                </div>
            </div>
        </div>

        <!-- Detail Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- City Distribution (Polar Area for creativity) -->
            <div class="glass-card p-8 animate-fade-in delay-3">
                <h3 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-6 italic">Geographic Pulse</h3>
                <div class="h-64">
                    <canvas id="chartPolar"></canvas>
                </div>
            </div>

            <!-- Recent Activity / Table -->
            <div class="lg:col-span-2 glass-card overflow-hidden animate-fade-in delay-3 flex flex-col">
                <div class="p-8 pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Inventory Feed</h3>
                        <p class="text-xl font-black italic uppercase">Recent Listings</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}"
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#75B06F] hover:underline">View
                        All Orders →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5">
                                <th
                                    class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500 italic">
                                    Resource</th>
                                <th
                                    class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500 italic">
                                    Sector</th>
                                <th
                                    class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500 italic">
                                    Valuation</th>
                                <th
                                    class="px-8 py-4 text-right text-[10px] font-black uppercase tracking-widest text-gray-500 italic">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($recentActivity as $activity)
                                @php
                                    $name = $activity->product_name ?? $activity->name;
                                    $category = $activity->category ?? 'General';
                                    $price = $activity->price;
                                    $city = $activity->city;
                                @endphp
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-sm bg-gray-800 flex items-center justify-center border border-white/5 group-hover:border-[#75B06F]/50 transition-colors">
                                                <span class="text-[8px] font-bold text-gray-600 italic">ACT</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-xs font-bold uppercase truncate max-w-[150px]">{{ $name }}</span>
                                                <span class="text-[9px] text-gray-500 uppercase">{{ $city }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span
                                            class="text-[9px] font-bold text-gray-400 uppercase tracking-widest border border-white/10 px-2 py-1 rounded-sm">{{ $category }}</span>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="text-xs font-black text-[#75B06F]">Rp
                                            {{ number_format($price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <span
                                            class="w-2 h-2 rounded-full bg-[#75B06F] inline-block shadow-[0_0_8px_#75B06F]"></span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <footer class="bg-black border-t border-white/5 py-12">
        <div class="max-w-[1400px] mx-auto px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <span class="stencil-text text-xl text-gray-700 italic">LOWRIDER</span>
                <span class="text-[9px] text-gray-700 font-black uppercase tracking-[0.5em]">Command Center v2.0</span>
            </div>
            <p class="text-[10px] font-medium text-gray-600 uppercase tracking-widest italic text-center">
                Built for High Performance Visual Data Processing © 2026
            </p>
        </div>
    </footer>

    <!-- Chart Configuration Script -->
    <script>
        // Data from Controller
        const categoryLabels = @json($categories->pluck('category'));
        const categoryData = @json($categories->pluck('total'));

        const cityLabels = @json($cities->pluck('city'));
        const cityData = @json($cities->pluck('total'));

        const incomeDataRaw = @json($incomeData);
        const incomeLabels = incomeDataRaw.map(item => {
            const date = new Date(item.month);
            return date.toLocaleString('default', { month: 'short' }).toUpperCase();
        });
        const incomeValues = incomeDataRaw.map(item => item.total_income);

        // --- CHART DEFAULTS ---
        Chart.defaults.color = 'rgba(255,255,255,0.4)';
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.weight = '600';
        Chart.defaults.scale.grid.color = 'rgba(255,255,255,0.03)';
        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(0,0,0,0.95)';
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.cornerRadius = 4;
        Chart.defaults.plugins.tooltip.titleColor = '#75B06F';
        Chart.defaults.plugins.tooltip.titleFont = { size: 10, weight: '900', family: 'Russo One' };
        Chart.defaults.plugins.tooltip.borderColor = 'rgba(117,176,111,0.2)';
        Chart.defaults.plugins.tooltip.borderWidth = 1;

        // Custom Plugin for Shadow/Glow
        const shadowPlugin = {
            id: 'shadowPlugin',
            beforeDatasetsDraw(chart) {
                const ctx = chart.ctx;
                ctx.save();
                ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
                ctx.shadowBlur = 20;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 10;
            },
            afterDatasetsDraw(chart) {
                chart.ctx.restore();
            }
        };

        // --- 1. Main Growth Line Chart ---
        const ctxLine = document.getElementById('chartMainLine').getContext('2d');
        const gradientLine = ctxLine.createLinearGradient(0, 0, 0, 400);
        gradientLine.addColorStop(0, 'rgba(117,176,111, 0.3)');
        gradientLine.addColorStop(1, 'rgba(117,176,111, 0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: incomeLabels,
                datasets: [{
                    label: 'Revenue',
                    data: incomeValues,
                    borderColor: '#75B06F',
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#75B06F',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradientLine
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) { return (value / 1000000).toFixed(1) + 'M'; }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            },
            plugins: [shadowPlugin]
        });

        // --- 2. Sector Donut Chart ---
        const colors = ['#75B06F', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'];
        new Chart(document.getElementById('chartBigDonut'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: colors,
                    hoverOffset: 12,
                    borderWidth: 0,
                    spacing: 4
                }]
            },
            options: {
                cutout: '80%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Populate Custom Legend
        const legendContainer = document.getElementById('customLegend');
        categoryLabels.forEach((label, i) => {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 bg-white/5 p-2 rounded-sm border border-white/5';
            div.innerHTML = `
                <span class="w-2 h-2 rounded-full" style="background: ${colors[i % colors.length]}"></span>
                <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">${label}</span>
                <span class="ml-auto text-[10px] font-black text-white italic">${categoryData[i]}</span>
            `;
            legendContainer.appendChild(div);
        });

        // --- 3. Polar Area for Geographics (Creative Choice) ---
        new Chart(document.getElementById('chartPolar'), {
            type: 'polarArea',
            data: {
                labels: cityLabels,
                datasets: [{
                    data: cityData,
                    backgroundColor: colors.map(c => c + '44'),
                    borderColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        angleLines: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Interactive Analysis Handler
        document.getElementById('btnAnalyze').addEventListener('click', function () {
            const type = document.getElementById('analysisType').value;
            const section = document.getElementById('analysisSection');
            const loading = document.getElementById('analysisLoading');
            const results = document.getElementById('analysisResults');
            const btn = this;

            // UI Elements to update
            const title = document.getElementById('resultTitle');
            const formula = document.getElementById('resultFormula');
            const tip = document.getElementById('resultTip');

            // Scroll to section
            window.scrollTo({
                top: section.offsetTop - 100,
                behavior: 'smooth'
            });

            // Toggle Visibility
            section.classList.remove('hidden');
            loading.classList.remove('hidden');
            results.classList.add('hidden');
            btn.innerHTML = '<span class="relative z-10 stencil-text text-sm uppercase italic">Analyzing Matrix...</span>';
            btn.disabled = true;

            // Update Metadata based on selection
            if (type === 'sold') {
                title.innerText = 'Most Sold Products';
                formula.innerText = 'Formula: Recursive Transaction Count (Volume Based)';
                tip.innerText = 'Produk ini adalah yang paling banyak dibeli oleh pelanggan. Pastikan stok selalu tersedia untuk memenuhi permintaan pasar yang tinggi.';
            } else if (type === 'rating') {
                title.innerText = 'Top Rated Quality';
                formula.innerText = 'Formula: Average Customer Sentiment (Rating Weighted)';
                tip.innerText = 'Produk ini memiliki tingkat kepuasan tertinggi. Pertahankan kualitas ini dan pertimbangkan untuk menaikkan harga atau menjadikannya produk unggulan.';
            } else {
                title.innerText = 'Market Trend Analysis';
                formula.innerText = 'Formula: User-Based Collaborative Filtering Weighted';
                tip.innerText = 'Produk di atas memiliki probabilitas transaksi tertinggi bulan ini berdasarkan pola kemiripan pelanggan. Fokuskan stok pada item ini.';
            }

            // Hide all containers first
            document.querySelectorAll('.analysis-container').forEach(c => c.classList.add('hidden'));

            // Simulate AI Processing
            setTimeout(() => {
                loading.classList.add('hidden');
                results.classList.remove('hidden');
                
                // Show specific container
                document.getElementById('container-' + type).classList.remove('hidden');

                btn.innerHTML = '<span class="relative z-10 stencil-text text-sm uppercase italic">Analysis Complete ✓</span>';
                btn.classList.replace('bg-[#75B06F]', 'bg-blue-600');

                // Re-enable after a while or leave enabled for re-analysis
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<span class="relative z-10 stencil-text text-sm uppercase italic">Run New Analysis ⚡</span>';
                    btn.classList.replace('bg-blue-600', 'bg-[#75B06F]');
                }, 3000);
            }, 2500);
        });
    </script>
</body>

</html>