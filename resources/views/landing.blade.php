<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursa Low Rider - Street Style</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Animation Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script>

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

        .low-shadow {
            border-bottom: 4px solid #75B06F;
        }

        .acid-gradient {
            background: linear-gradient(135deg, #75B06F 0%, #4a7a44 100%);
        }

        .glass-dark {
            background: rgba(28, 28, 28, 0.8);
            backdrop-filter: blur(10px);
        }

        .text-outline {
            -webkit-text-stroke: 1px white;
        }
    </style>
</head>

<body class="selection:bg-brand-green selection:text-black">
    <div id="cursor-glow" class="hidden md:block"></div>

    <!-- Header / Navbar -->
    <nav class="sticky top-0 z-50 glass-dark border-b border-brand-green/20 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-10">
                <a href="/" class="text-3xl stencil-text text-brand-green tracking-tighter">LOW<span
                        class="text-white">RIDER</span></a>
                <div class="hidden md:flex items-center gap-8 text-sm font-bold uppercase tracking-widest">
                    <a href="#" class="hover:text-brand-green transition-colors">Modifikasi</a>
                    <a href="#" class="hover:text-brand-green transition-colors">Pakaian</a>
                    <a href="#" class="hover:text-brand-green transition-colors">Aksesoris</a>
                    <a href="#" class="hover:text-brand-green transition-colors">Komunitas</a>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <button
                    class="hidden lg:flex items-center gap-2 bg-street-grey border border-white/10 px-4 py-2 rounded-md hover:border-brand-green transition-all">
                    <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="text-xs font-bold opacity-60 uppercase">Cari Barang...</span>
                </button>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-xs font-black uppercase tracking-widest hover:text-brand-green">Masuk</a>
                    <a href="#"
                        class="bg-brand-green text-black px-6 py-2 stencil-text rounded-sm transform -skew-x-12 hover:scale-105 transition-all">GABUNG</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative min-h-screen flex items-center px-6 overflow-hidden pt-20">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-20 pointer-events-none"
            style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
        <div class="parallax-element absolute -left-20 top-20 w-96 h-96 bg-brand-green/10 rounded-full blur-[120px]"
            data-speed="0.2"></div>
        <div class="parallax-element absolute right-0 bottom-0 w-[500px] h-[500px] bg-brand-green/5 rounded-full blur-[150px]"
            data-speed="0.3"></div>

        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center relative z-10 w-full">
            <div class="hero-content space-y-8">
                <div class="flex items-center gap-3">
                    <span class="h-1 w-12 bg-brand-green"></span>
                    <span class="text-brand-green font-black uppercase tracking-[0.3em] text-sm italic">Underground
                        Culture</span>
                </div>
                <h1
                    class="street-text text-8xl lg:text-9xl leading-[0.8] tracking-tighter uppercase italic translate-y-20 opacity-0 hero-title">
                    GAS <span class="text-brand-green">POL</span><br>
                    REDAH <span class="text-outline text-transparent">POL</span>
                </h1>
                <p
                    class="text-gray-400 text-lg max-w-md font-medium leading-relaxed italic translate-y-10 opacity-0 hero-p">
                    Bursa khusus buat lo yang gila modifikasi, street wear, dan gaya hidup low rider. Kualitas jalanan,
                    harga temenan.
                </p>
                <div class="flex flex-col sm:flex-row gap-5 pt-4 translate-y-10 opacity-0 hero-btns">
                    <a href="#"
                        class="group relative bg-brand-green text-black px-10 py-5 stencil-text text-xl overflow-hidden rounded-sm hover:scale-105 transition-transform">
                        <span class="relative z-10">Mulai Belanja</span>
                        <div
                            class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-500">
                        </div>
                    </a>
                    <a href="#"
                        class="group border-2 border-white px-10 py-5 stencil-text text-xl rounded-sm hover:bg-white hover:text-black transition-all italic">
                        Cek Katalog
                    </a>
                </div>

                <div class="flex gap-12 pt-8 border-t border-white/10 translate-y-10 opacity-0 hero-stats">
                    <div>
                        <p class="text-3xl font-black italic">15K+</p>
                        <p class="text-xs uppercase text-gray-500 font-bold">Anggota</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black italic">8K+</p>
                        <p class="text-xs uppercase text-gray-500 font-bold">Produk Custom</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black italic">24/7</p>
                        <p class="text-xs uppercase text-gray-500 font-bold">Support Jalanan</p>
                    </div>
                </div>
            </div>

            <div class="relative group hero-image opacity-0 translate-x-20">
                <div
                    class="absolute inset-0 bg-brand-green/20 blur-3xl group-hover:bg-brand-green/30 transition-all duration-700">
                </div>
                <div
                    class="relative rounded-sm border-2 border-brand-green/30 p-2 transform rotate-1 transition-transform group-hover:rotate-0 duration-500 image-parallax-container overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1549490349-8643362247b5?q=80&w=1000&auto=format&fit=crop"
                        alt="Lowrider Bike"
                        class="w-full h-[600px] object-cover grayscale contrast-125 group-hover:grayscale-0 transition-all duration-700 image-parallax">
                    <div
                        class="absolute top-10 -right-10 bg-brand-green text-black p-4 stencil-text text-2xl -rotate-12 shadow-2xl">
                        PRODUK LOKAL!
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hot Items Section -->
    <section class="max-w-7xl mx-auto px-6 py-32">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-20">
            <div>
                <h2 class="street-text text-6xl uppercase italic leading-none mb-4">Barang <span
                        class="text-brand-green">Paling Galak</span></h2>
                <div class="h-2 w-32 bg-brand-green"></div>
            </div>
            <p class="text-gray-500 max-w-sm italic">Koleksi terbatas yang bakal bikin gaya lo makin sangar di aspal.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($products as $product)
                <!-- Dynamic Product -->
                <div
                    class="product-card bg-street-grey border border-white/5 p-4 rounded-sm group hover:border-brand-green transition-all translate-y-20 opacity-0">
                    <a href="{{ route('product.show', $product) }}" class="block">
                        <div class="aspect-[4/5] overflow-hidden mb-6 relative">
                            <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1552346154-21d32810aba3?q=80&w=1000&auto=format&fit=crop' }}"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700">
                            @if($loop->first)
                                <div
                                    class="absolute top-4 left-4 bg-brand-green text-black px-3 py-1 text-[10px] font-black uppercase italic tracking-tighter">
                                    Hot</div>
                            @endif
                        </div>
                        <h3
                            class="street-text text-2xl mb-1 group-hover:text-brand-green transition-colors uppercase italic">
                            {{ $product->name }}
                        </h3>
                    </a>
                    <p class="text-gray-500 text-xs mb-4">{{ $product->category ?? 'Street' }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-black italic">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <button
                            class="w-10 h-10 bg-brand-green text-black flex items-center justify-center rounded-sm hover/magnetic transition-transform active:scale-90">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <!-- Fallback to static if no products yet -->
                <div class="col-span-full bg-street-grey border border-white/5 p-20 text-center rounded-sm">
                    <p class="text-gray-500 italic uppercase font-bold tracking-widest">Belum ada barang di aspal.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-street-grey pt-24 pb-12 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">
                <div class="space-y-6">
                    <a href="/" class="text-4xl stencil-text text-brand-green tracking-tighter">LOWRIDER</a>
                    <p class="text-gray-500 text-sm italic font-medium">Bukan cuma soal kendaraan, tapi soal jati diri
                        di jalanan. Bergabung dengan komunitas terbesar di Indonesia.</p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-10 h-10 border border-white/20 flex items-center justify-center rounded-sm hover:bg-brand-green hover:text-black transition-all">IG</a>
                        <a href="#"
                            class="w-10 h-10 border border-white/20 flex items-center justify-center rounded-sm hover:bg-brand-green hover:text-black transition-all">YT</a>
                        <a href="#"
                            class="w-10 h-10 border border-white/20 flex items-center justify-center rounded-sm hover:bg-brand-green hover:text-black transition-all">TT</a>
                    </div>
                </div>

                <div>
                    <h5
                        class="stencil-text text-xl mb-8 uppercase italic underline decoration-brand-green decoration-4 underline-offset-8">
                        Navigasi</h5>
                    <ul class="space-y-4 text-sm font-bold uppercase tracking-widest text-gray-400">
                        <li><a href="#" class="hover:text-brand-green italic transition-colors">Modifikasi Mesin</a>
                        </li>
                        <li><a href="#" class="hover:text-brand-green italic transition-colors">Body Custom</a></li>
                        <li><a href="#" class="hover:text-brand-green italic transition-colors">Cat & Chrome</a></li>
                        <li><a href="#" class="hover:text-brand-green italic transition-colors">Event Jalanan</a></li>
                    </ul>
                </div>

                <div>
                    <h5
                        class="stencil-text text-xl mb-8 uppercase italic underline decoration-brand-green decoration-4 underline-offset-8">
                        Bantuan</h5>
                    <ul class="space-y-4 text-sm font-bold uppercase tracking-widest text-gray-400">
                        <li><a href="#" class="hover:text-brand-green italic transition-colors">Cara Order</a></li>
                        <li><a href="#" class="hover:text-brand-green italic transition-colors">Pengiriman</a></li>
                        <li><a href="#" class="hover:text-brand-green italic transition-colors">Garansi Barang</a></li>
                        <li><a href="#" class="hover:text-brand-green italic transition-colors">Kontak Admin</a></li>
                    </ul>
                </div>

                <div class="bg-brand-green/5 p-8 border-l-4 border-brand-green rounded-sm">
                    <h5 class="stencil-text text-xl mb-6 uppercase italic">Dapatkan Promo!</h5>
                    <p class="text-xs text-gray-400 mb-6 italic">Daftar sekarang buat dapet info barang drop rahasia.
                    </p>
                    <input type="email" placeholder="Email lo disini..."
                        class="w-full bg-black border border-white/10 rounded-sm px-4 py-3 mb-4 text-sm focus:border-brand-green outline-none italic">
                    <button
                        class="w-full bg-brand-green text-black py-4 stencil-text text-lg italic hover:shadow-[0_0_20px_rgba(117,176,111,0.5)] transition-all">SUBMIT</button>
                </div>
            </div>

            <div
                class="flex flex-col md:flex-row justify-between items-center pt-10 border-t border-white/5 text-[10px] font-black uppercase tracking-[0.3em] text-gray-600 italic">
                <p>© 2026 Bursa Lowrider Indonesia. Aspal Milik Kita.</p>
                <p>Designed for the Street</p>
            </div>
        </div>
    </footer>

    <script>
        // Register GSAP Plugins
        gsap.registerPlugin(ScrollTrigger);

        // Initialize Lenis Smooth Scroll
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: true,
            wheelMultiplier: 1,
            smoothTouch: false,
            touchMultiplier: 2,
            infinite: false,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Custom Cursor Glow
        const cursor = document.getElementById('cursor-glow');
        window.addEventListener('mousemove', (e) => {
            gsap.to(cursor, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.5,
                ease: "power2.out"
            });
        });

        // Hero Parallax on Scroll
        gsap.to(".parallax-element", {
            y: (i, el) => -ScrollTrigger.maxScroll(window) * el.dataset.speed,
            ease: "none",
            scrollTrigger: {
                start: 0,
                end: "max",
                scrub: true
            }
        });

        // Hero Entrance Animations
        const heroTl = gsap.timeline({ defaults: { ease: "power4.out", duration: 1.5 } });
        heroTl.to(".hero-title", { opacity: 1, y: 0, delay: 0.5 })
            .to(".hero-p", { opacity: 1, y: 0 }, "-=1.2")
            .to(".hero-btns", { opacity: 1, y: 0 }, "-=1.1")
            .to(".hero-stats", { opacity: 1, y: 0 }, "-=1.0")
            .to(".hero-image", { opacity: 1, x: 0 }, "-=1.5");

        // Scroll Reveal for Product Cards
        gsap.utils.toArray('.product-card').forEach((card, i) => {
            gsap.to(card, {
                opacity: 1,
                y: 0,
                duration: 1,
                scrollTrigger: {
                    trigger: card,
                    start: "top 90%",
                    toggleActions: "play none none none"
                },
                delay: i * 0.1
            });
        });

        // Image Parallax on Mouse Move (Hero)
        const heroImageContainer = document.querySelector('.image-parallax-container');
        const heroImage = document.querySelector('.image-parallax');
        if (heroImageContainer) {
            heroImageContainer.addEventListener('mousemove', (e) => {
                const { width, height } = heroImageContainer.getBoundingClientRect();
                const xVal = (e.clientX - (heroImageContainer.offsetLeft + width / 2)) / 20;
                const yVal = (e.clientY - (heroImageContainer.offsetTop + height / 2)) / 20;

                gsap.to(heroImage, {
                    x: xVal,
                    y: yVal,
                    scale: 1.1,
                    duration: 0.5,
                    ease: "power2.out"
                });
            });

            heroImageContainer.addEventListener('mouseleave', () => {
                gsap.to(heroImage, {
                    x: 0,
                    y: 0,
                    scale: 1,
                    duration: 0.5
                });
            });
        }

        // Magnetic Effect for Buttons (Simple)
        gsap.utils.toArray('.hover\/magnetic').forEach(btn => {
            btn.addEventListener('mousemove', (e) => {
                const { left, top, width, height } = btn.getBoundingClientRect();
                const x = e.clientX - left - width / 2;
                const y = e.clientY - top - height / 2;
                gsap.to(btn, { x: x * 0.3, y: y * 0.3, duration: 0.3 });
            });
            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, { x: 0, y: 0, duration: 0.3 });
            });
        });
    </script>
</body>

</html>