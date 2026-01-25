<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Bursa Low Rider</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Animation Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script>
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
                    }
                }
            }
        }
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Russo+One&family=Inter:wght@400;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0a0a;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Custom Cursor Glow */
        #cursor-glow {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(117, 176, 111, 0.15) 0%, rgba(117, 176, 111, 0) 70%);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 1;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s ease;
        }

        .street-text {
            font-family: 'Bebas Neue', cursive;
        }

        .stencil-text {
            font-family: 'Russo One', sans-serif;
        }

        .text-outline {
            -webkit-text-stroke: 1px white;
        }
    </style>
</head>

<body class="selection:bg-brand-green selection:text-black">
    <div id="cursor-glow" class="hidden md:block"></div>

    <nav class="sticky top-0 z-50 bg-[#0a0a0a]/90 backdrop-blur-md border-b border-brand-green/20 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="/" class="text-3xl stencil-text text-brand-green tracking-tighter">LOW<span
                    class="text-white">RIDER</span></a>
            <div class="flex items-center gap-6">
                @auth
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Yo,
                        {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-xs font-black uppercase tracking-widest text-red-500 hover:text-white transition-colors">Cabut
                            (Logout)</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xs font-black uppercase tracking-widest hover:text-brand-green transition-colors">Masuk
                        / Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="min-h-screen max-w-7xl mx-auto px-6 py-20">
        <div class="grid lg:grid-cols-2 gap-16 items-start">

            <!-- Product Image -->
            <div class="relative group product-image opacity-0 -translate-x-10">
                <div class="absolute inset-0 bg-brand-green/10 blur-3xl rounded-full"></div>
                <div class="relative rounded-sm border border-white/10 p-2 overflow-hidden bg-street-grey">
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1552346154-21d32810aba3?q=80&w=1000&auto=format&fit=crop' }}"
                        alt="{{ $product->name }}"
                        class="w-full h-[600px] object-cover grayscale contrast-125 group-hover:grayscale-0 transition-all duration-700">
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-8 product-details opacity-0 translate-x-10">
                <div>
                    <span
                        class="text-brand-green font-black uppercase tracking-[0.2em] text-xs italic mb-2 block">{{ $product->category ?? 'Street Item' }}</span>
                    <h1 class="street-text text-7xl uppercase italic leading-none mb-2">{{ $product->name }}</h1>
                    <div class="h-1 w-32 bg-brand-green"></div>
                </div>

                <p class="text-4xl font-black italic text-white/90">Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <div class="prose prose-invert prose-lg text-gray-400 italic leading-relaxed">
                    <p>{{ $product->description ?? 'Deskripsi produk belum tersedia. Barang masih anget dari bengkel.' }}
                    </p>
                </div>

                <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row gap-5">
                    @auth
                        <button id="pay-button"
                            class="bg-brand-green text-black px-10 py-5 stencil-text text-xl rounded-sm hover:shadow-[0_0_30px_rgba(117,176,111,0.4)] hover:scale-105 transition-all text-center uppercase">
                            Beli Sekarang (Midtrans)
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-street-grey border border-white/20 text-white px-10 py-5 stencil-text text-xl rounded-sm hover:bg-brand-green hover:text-black hover:border-brand-green transition-all text-center uppercase">
                            Login Buat Beli
                        </a>
                    @endauth
                    <a href="https://wa.me/?text=Halo%20Bursa%20Lowrider,%20saya%20mau%20order%20{{ urlencode($product->name) }}"
                        target="_blank"
                        class="border border-white/20 px-10 py-5 stencil-text text-xl rounded-sm hover:bg-white hover:text-black transition-all text-center uppercase">
                        Chat WA
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-10">
                    <div class="bg-street-grey p-4 border border-white/5 rounded-sm">
                        <h4 class="stencil-text text-sm text-brand-green mb-1 uppercase">Garansi Bengkel</h4>
                        <p class="text-xs text-gray-500">Jaminan originalitas atau duit balik.</p>
                    </div>
                    <div class="bg-street-grey p-4 border border-white/5 rounded-sm">
                        <h4 class="stencil-text text-sm text-brand-green mb-1 uppercase">Pengiriman Kilat</h4>
                        <p class="text-xs text-gray-500">Packing aman, siap kirim se-Indonesia.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="bg-street-grey py-8 border-t border-white/10 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center text-xs font-bold uppercase tracking-widest text-gray-600">
            &copy; 2026 Bursa Low Rider. Street Certified.
        </div>
    </footer>

    <script>
        // Initialize Lenis
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            orientation: 'vertical',
            smoothWheel: true,
        });
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Animations
        gsap.to(".product-image", { opacity: 1, x: 0, duration: 1.5, ease: "power3.out", delay: 0.2 });
        gsap.to(".product-details", { opacity: 1, x: 0, duration: 1.5, ease: "power3.out", delay: 0.4 });

        // Cursor Glow
        const cursor = document.getElementById('cursor-glow');
        window.addEventListener('mousemove', (e) => {
            gsap.to(cursor, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.5,
                ease: "power2.out"
            });
        });

        // Midtrans Payment Logic
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', async () => {
            try {
                payButton.innerHTML = 'Loading...';
                payButton.disabled = true;

                const response = await fetch('{{ route('payment.checkout', $product) }}');
                const data = await response.json();

                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function (result) {
                            alert("Pembayaran Berhasil! Gas pol!");
                            console.log(result);
                        },
                        onPending: function (result) {
                            alert("Menunggu pembayaran bro...");
                            console.log(result);
                        },
                        onError: function (result) {
                            alert("Pembayaran gagal. Coba lagi.");
                            console.log(result);
                        },
                        onClose: function () {
                            alert('Lo belum nyelesain pembayaran tadi.');
                            payButton.innerHTML = 'Beli Sekarang (Midtrans)';
                            payButton.disabled = false;
                        }
                    });
                } else {
                    alert('Gagal dapet token pembayaran.\nError: ' + (data.error || 'Unknown error'));
                    console.error('Full Error:', data);
                    payButton.innerHTML = 'Beli Sekarang (Midtrans)';
                    payButton.disabled = false;
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('Ada masalah koneksi atau server error.\nCek console buat detailnya.');
                payButton.innerHTML = 'Beli Sekarang (Midtrans)';
                payButton.disabled = false;
            }
        });
    </script>
</body>

</html>