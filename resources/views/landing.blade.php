<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOWRIDER - Underground Street Style</title>
    
    <!-- Vite for Tailwind 4 & Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fallback/Additional Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Russo+One&family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

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

        .street-text { font-family: 'Bebas Neue', cursive; }
        .stencil-text { font-family: 'Russo One', sans-serif; }

        #cursor-glow {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(117, 176, 111, 0.15) 0%, rgba(117, 176, 111, 0) 70%);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 100;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s ease;
        }

        .glass-dark {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .text-outline {
            -webkit-text-stroke: 1px rgba(255,255,255,0.3);
            color: transparent;
        }

        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(117, 176, 111, 0.1) 0%, transparent 70%);
        }

        .image-parallax-container {
            mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
        }
    </style>
</head>

<body class="selection:bg-brand-green selection:text-black bg-street-black">
    <div id="cursor-glow" class="hidden md:block"></div>

    <!-- Header / Navbar -->
    <nav class="sticky top-0 z-[100] glass-dark border-b border-white/5 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-10">
                <a href="/" class="text-4xl stencil-text text-brand-green tracking-tighter hover:scale-105 transition-transform">
                    LOW<span class="text-white">RIDER</span>
                </a>
                <div class="hidden md:flex items-center gap-8 text-[11px] font-black uppercase tracking-[0.2em]">
                    <a href="#" class="hover:text-brand-green transition-colors py-2 relative group uppercase">
                        Modifikasi
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-green transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#" class="hover:text-brand-green transition-colors py-2 relative group uppercase">
                        Pakaian
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-green transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#" class="hover:text-brand-green transition-colors py-2 relative group uppercase">
                        Aksesoris
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-green transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#" class="hover:text-brand-green transition-colors py-2 relative group uppercase">
                        Komunitas
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-green transition-all group-hover:w-full"></span>
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <button class="hidden lg:flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-2 rounded-sm hover:border-brand-green/50 transition-all group">
                    <svg class="w-4 h-4 text-brand-green group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="text-[10px] font-black opacity-40 uppercase tracking-widest group-hover:opacity-100 transition-opacity">Cari Barang...</span>
                </button>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-[10px] font-black uppercase tracking-[0.2em] hover:text-brand-green transition-colors mt-1">Masuk</a>
                    <a href="#" class="bg-brand-green text-black px-8 py-3 stencil-text text-sm rounded-sm hover:bg-brand-lime hover:shadow-[0_0_20px_rgba(224,255,0,0.3)] transition-all">GABUNG</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative min-h-screen flex items-center px-6 overflow-hidden pt-10">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-grain opacity-10 pointer-events-none"></div>
        <div class="hero-gradient absolute inset-0 pointer-events-none"></div>
        
        <div class="parallax-element absolute -left-20 top-20 w-96 h-96 bg-brand-green/5 rounded-full blur-[120px]" data-speed="0.1"></div>
        <div class="parallax-element absolute right-0 bottom-0 w-[600px] h-[600px] bg-brand-lime/5 rounded-full blur-[150px]" data-speed="0.2"></div>

        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center relative z-10 w-full mt-10">
            <div class="hero-content space-y-10">
                <div class="flex items-center gap-4 overflow-hidden">
                    <span class="h-[2px] w-16 bg-brand-green"></span>
                    <span class="text-brand-green font-black uppercase tracking-[0.4em] text-[10px] italic">Premium Street Culture</span>
                </div>
                <h1 class="street-text text-[10rem] lg:text-[14rem] leading-[0.75] tracking-tighter uppercase italic opacity-0 hero-title font-black">
                    GAS <span class="text-brand-green transition-colors hover:text-brand-lime">POL</span><br>
                    <span class="text-outline">REDAH</span> <span class="text-brand-green transition-colors hover:text-brand-orange">POL</span>
                </h1>
                <p class="text-gray-400 text-xl max-w-md font-medium leading-relaxed italic opacity-0 hero-p border-l-2 border-brand-green/30 pl-6">
                    Bursa eksklusif modifikasi, street wear, dan gaya hidup low rider. <br><span class="text-white">Kualitas jalanan, estetika kelas atas.</span>
                </p>
                <div class="flex flex-col sm:flex-row gap-6 pt-6 opacity-0 hero-btns">
                    <a href="#" class="group relative bg-brand-green text-black px-12 py-6 stencil-text text-2xl overflow-hidden rounded-sm hover:scale-105 transition-transform hover:bg-brand-lime">
                        <span class="relative z-10">MULAI BELANJA</span>
                        <div class="absolute inset-0 bg-white/30 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                    <a href="#" class="group border-2 border-white px-12 py-6 stencil-text text-2xl rounded-sm hover:bg-white hover:text-black transition-all italic tracking-tighter">
                        KATALOG
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-12 pt-12 border-t border-white/5 opacity-0 hero-stats">
                    <div class="group">
                        <p class="text-4xl font-black italic group-hover:text-brand-green transition-colors">15K+</p>
                        <p class="text-[10px] uppercase text-gray-500 font-bold tracking-widest mt-1">Anggota</p>
                    </div>
                    <div class="group">
                        <p class="text-4xl font-black italic group-hover:text-brand-green transition-colors">8K+</p>
                        <p class="text-[10px] uppercase text-gray-500 font-bold tracking-widest mt-1">Custom</p>
                    </div>
                    <div class="group">
                        <p class="text-4xl font-black italic group-hover:text-brand-green transition-colors">24/7</p>
                        <p class="text-[10px] uppercase text-gray-500 font-bold tracking-widest mt-1">Support</p>
                    </div>
                </div>
            </div>

            <div class="relative group hero-image opacity-0">
                <div class="absolute inset-0 bg-brand-green/10 blur-[100px] group-hover:bg-brand-lime/15 transition-all duration-1000"></div>
                <div class="relative rounded-sm border border-white/10 p-3 transform rotate-2 transition-transform group-hover:rotate-0 duration-1000 image-parallax-container overflow-hidden bg-white/5 backdrop-blur-sm">
                    <img src="/images/hero_vibe.png" alt="Premium Lowrider" class="w-full h-[700px] object-cover contrast-[1.1] brightness-90 group-hover:brightness-105 transition-all duration-1000 image-parallax">
                    <div class="absolute top-12 -right-12 bg-street-black border border-brand-green/30 text-brand-green p-6 stencil-text text-3xl -rotate-12 shadow-2xl backdrop-blur-xl">
                        EST. 2026
                    </div>
                    <div class="absolute bottom-8 left-8 flex gap-2">
                        <span class="w-12 h-1 bg-brand-green"></span>
                        <span class="w-4 h-1 bg-white/20"></span>
                        <span class="w-4 h-1 bg-white/20"></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hot Items Section -->
    <section class="max-w-7xl mx-auto px-6 py-40">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 mb-24">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="h-[1px] w-8 bg-brand-green"></span>
                    <span class="text-brand-green font-black uppercase tracking-[0.3em] text-[10px] italic">Drop Terbaru</span>
                </div>
                <h2 class="street-text text-8xl uppercase italic leading-none">BARANG <span class="text-brand-green">PALING GALAK</span></h2>
            </div>
            <p class="text-gray-500 max-w-sm italic text-lg leading-relaxed">Koleksi terbatas yang bakal bikin gaya lo makin sangar di aspal aspal keras.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
                <!-- Dynamic Product -->
                <div class="product-card group relative opacity-0 translate-y-20">
                    <a href="{{ route('product.show', $product) }}" class="block p-4 bg-white/5 border border-white/10 rounded-sm hover:border-brand-green/40 transition-all duration-500 bg-grain">
                        <div class="aspect-[4/5] overflow-hidden mb-8 relative bg-street-black rounded-sm">
                            <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1552346154-21d32810aba3?q=80&w=1000&auto=format&fit=crop' }}"
                                class="w-full h-full object-cover grayscale brightness-75 group-hover:grayscale-0 group-hover:brightness-100 group-hover:scale-110 transition-all duration-1000">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-street-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            @if($loop->first)
                                <div class="absolute top-0 left-0 bg-brand-green text-black px-4 py-2 text-[10px] font-black uppercase italic tracking-[0.2em] shadow-2xl">
                                    TOP PICK
                                </div>
                            @endif
                        </div>
                        
                        <div class="space-y-2 relative">
                            <p class="text-[10px] uppercase text-brand-green font-black tracking-[0.3em]">{{ $product->category ?? 'STREET CUSTOM' }}</p>
                            <h3 class="street-text text-3xl group-hover:text-brand-green transition-colors uppercase italic font-black tracking-tight">
                                {{ $product->name }}
                            </h3>
                            <div class="flex items-center justify-between pt-4">
                                <span class="text-2xl font-black italic tracking-tighter">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <div class="w-12 h-12 bg-white/5 border border-white/10 flex items-center justify-center rounded-sm group-hover:bg-brand-green group-hover:text-black transition-all group-hover:rotate-12">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <!-- Fallback -->
                <div class="col-span-full bg-white/5 border border-white/10 p-32 text-center rounded-sm bg-grain">
                    <p class="text-gray-500 italic uppercase font-black tracking-[0.5em] opacity-40">Belum ada barang di aspal.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-street-black pt-40 pb-20 border-t border-white/5 relative overflow-hidden">
        <div class="absolute inset-0 bg-grain opacity-5 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-20 mb-32">
                <div class="space-y-8">
                    <a href="/" class="text-5xl stencil-text text-brand-green tracking-tighter">LOWRIDER</a>
                    <p class="text-gray-500 text-lg italic font-medium leading-relaxed">
                        Bukan cuma soal kendaraan, tapi soal jati diri di jalanan. Bergabung dengan komunitas terbesar di Indonesia.
                    </p>
                    <div class="flex gap-6">
                        <a href="#" class="w-12 h-12 border border-white/10 flex items-center justify-center rounded-sm hover:bg-brand-green hover:text-black hover:border-brand-green transition-all group">
                           <span class="text-xs font-black">IG</span>
                        </a>
                        <a href="#" class="w-12 h-12 border border-white/10 flex items-center justify-center rounded-sm hover:bg-brand-green hover:text-black hover:border-brand-green transition-all group">
                           <span class="text-xs font-black">YT</span>
                        </a>
                    </div>
                </div>

                <div>
                    <h5 class="stencil-text text-xl mb-12 uppercase italic text-brand-green tracking-widest">Navigasi</h5>
                    <ul class="space-y-6 text-xs font-black uppercase tracking-[0.3em] text-gray-500">
                        <li><a href="#" class="hover:text-white italic transition-colors flex items-center gap-3">
                            <span class="w-4 h-[1px] bg-brand-green"></span> Modifikasi Mesin
                        </a></li>
                        <li><a href="#" class="hover:text-white italic transition-colors flex items-center gap-3">
                            <span class="w-4 h-[1px] bg-brand-green"></span> Body Custom
                        </a></li>
                        <li><a href="#" class="hover:text-white italic transition-colors flex items-center gap-3">
                            <span class="w-4 h-[1px] bg-brand-green"></span> Cat & Chrome
                        </a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="stencil-text text-xl mb-12 uppercase italic text-brand-green tracking-widest">Bantuan</h5>
                    <ul class="space-y-6 text-xs font-black uppercase tracking-[0.3em] text-gray-500">
                        <li><a href="#" class="hover:text-white italic transition-colors flex items-center gap-3">
                            <span class="w-4 h-[1px] bg-brand-green"></span> Cara Order
                        </a></li>
                        <li><a href="#" class="hover:text-white italic transition-colors flex items-center gap-3">
                            <span class="w-4 h-[1px] bg-brand-green"></span> Pengiriman
                        </a></li>
                        <li><a href="#" class="hover:text-white italic transition-colors flex items-center gap-3">
                            <span class="w-4 h-[1px] bg-brand-green"></span> Kontak Admin
                        </a></li>
                    </ul>
                </div>

                <div class="bg-white/5 p-10 border-l-4 border-brand-green rounded-sm bg-grain backdrop-blur-md">
                    <h5 class="stencil-text text-2xl mb-6 uppercase italic font-black">Stay Underground.</h5>
                    <p class="text-xs text-gray-500 mb-8 italic leading-relaxed">Daftar sekarang buat dapet info barang drop rahasia langsung ke kotak masuk lo.</p>
                    <div class="space-y-4">
                        <input type="email" placeholder="Email lo disini..."
                            class="w-full bg-street-black border border-white/10 rounded-sm px-6 py-4 text-sm focus:border-brand-green outline-none italic transition-all">
                        <button class="w-full bg-brand-green text-black py-5 stencil-text text-xl italic hover:bg-brand-lime hover:shadow-[0_0_30px_rgba(117,176,111,0.4)] transition-all">
                            GABUNG SEKARANG
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center pt-16 border-t border-white/5 text-[10px] font-black uppercase tracking-[0.5em] text-gray-600 italic">
                <p>© 2026 Bursa Lowrider Indonesia. Aspal Milik Kita.</p>
                <div class="flex gap-10 mt-6 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                </div>
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
            smoothWheel: true,
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
                duration: 0.6,
                ease: "power2.out"
            });
        });

        // Hero Entrance Animations
        const heroTl = gsap.timeline({ defaults: { ease: "power4.out", duration: 1.8 } });
        
        heroTl.to(".hero-title", { opacity: 1, y: 0, delay: 0.2 })
            .to(".hero-p", { opacity: 1, y: 0 }, "-=1.5")
            .to(".hero-btns", { opacity: 1, y: 0 }, "-=1.4")
            .to(".hero-stats", { opacity: 1, y: 0 }, "-=1.3")
            .to(".hero-image", { opacity: 1, y: 0 }, "-=1.8");

        // Scroll Reveal for Product Cards
        gsap.utils.toArray('.product-card').forEach((card, i) => {
            gsap.to(card, {
                opacity: 1,
                y: 0,
                duration: 1.2,
                scrollTrigger: {
                    trigger: card,
                    start: "top 90%",
                    toggleActions: "play none none none"
                },
                delay: (i % 4) * 0.15
            });
        });

        // Parallax Effect for Background Elements
        gsap.utils.toArray(".parallax-element").forEach(el => {
            const speed = el.dataset.speed;
            gsap.to(el, {
                y: -100 * speed,
                scrollTrigger: {
                    trigger: "body",
                    start: "top top",
                    end: "bottom bottom",
                    scrub: true
                }
            });
        });

        // Image Parallax on Mouse Move (Hero)
        const heroImageContainer = document.querySelector('.image-parallax-container');
        const heroImage = document.querySelector('.image-parallax');
        if (heroImageContainer) {
            heroImageContainer.addEventListener('mousemove', (e) => {
                const { width, height, left, top } = heroImageContainer.getBoundingClientRect();
                const xVal = (e.clientX - (left + width / 2)) / 30;
                const yVal = (e.clientY - (top + height / 2)) / 30;

                gsap.to(heroImage, {
                    x: xVal,
                    y: yVal,
                    scale: 1.05,
                    duration: 0.8,
                    ease: "power2.out"
                });
            });

            heroImageContainer.addEventListener('mouseleave', () => {
                gsap.to(heroImage, {
                    x: 0,
                    y: 0,
                    scale: 1,
                    duration: 0.8
                });
            });
        }
    </script>
</body>
</html>