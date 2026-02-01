<?php 
$page_title = "Home";
require_once 'includes/header.php'; 
$sale_end_time = get_setting('sale_end_time');
?>

<main class="fade-up">
    <!-- Hero Section -->
    <section id="hero-interactive" class="relative min-h-[95vh] flex flex-col items-center justify-center overflow-hidden bg-white border-b-[3px] border-black pt-32 pb-24 group">
        <!-- Dynamic Grid Background -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#00000008_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <!-- Interactive Spotlight -->
        <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(800px_circle_at_var(--mouse-x,50%)_var(--mouse-y,50%),rgba(204,253,50,0.15),transparent_40%)] opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"></div>

        <!-- Animated Blobs (Parallax) -->
        <div data-parallax="-20" class="absolute top-0 right-0 w-[500px] h-[500px] bg-neon-yellow/10 rounded-full blur-[120px] animate-pulse transition-transform duration-100 ease-out"></div>
        <div data-parallax="20" class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-neon-green/10 rounded-full blur-[120px] animate-pulse delay-700 transition-transform duration-100 ease-out"></div>

        <!-- Floating Elements (Parallax) -->
        <div data-parallax="40" class="absolute top-24 left-10 md:left-24 animate-bounce delay-100 opacity-20 hidden lg:block transition-transform duration-75 ease-out">
            <i data-lucide="sparkles" class="w-12 h-12 text-black"></i>
        </div>
        <div data-parallax="-40" class="absolute bottom-24 right-10 md:right-24 animate-bounce delay-300 opacity-20 hidden lg:block transition-transform duration-75 ease-out">
            <i data-lucide="zap" class="w-12 h-12 text-black"></i>
        </div>

        <div class="container mx-auto px-4 relative z-10 flex flex-col items-center">
            <!-- Top Part: Typography -->
            <div class="max-w-6xl mx-auto flex flex-col items-center text-center mb-12 lg:mb-16">
                <span class="inline-block py-2 px-6 bg-neon-yellow border-[3px] border-black text-black rounded-full text-xs lg:text-sm font-black tracking-widest uppercase mb-6 shadow-[2px_2px_0px_0px_#000] rotate-[-2deg]">
                    Wear Your Vibe ⚡
                </span>
                <h1 class="text-hero font-black tracking-tighter mb-8 uppercase leading-[0.8]">
                    Make It <br/>
                    <span class="text-gradient italic">Your Own.</span>
                </h1>
                <p class="text-lg lg:text-2xl text-black font-bold mb-10 leading-tight max-w-2xl mx-auto opacity-90">
                    High-key premium custom apparel for creators. <br class="hidden lg:block"/> Express yourself. No limits. Pure drip.
                </p>
                <div class="flex flex-col sm:flex-row gap-5 justify-center w-full sm:w-auto px-4">
                    <a href="shop.php" class="chunky-btn px-10 py-5 bg-primary text-white rounded-2xl font-black text-xl flex items-center justify-center gap-3 w-full sm:w-auto">
                        Design Now <i data-lucide="zap" class="w-6 h-6 fill-current"></i>
                    </a>
                    <a href="#" class="chunky-btn px-10 py-5 bg-white text-black rounded-2xl font-black text-xl flex items-center justify-center w-full sm:w-auto">
                        Bulk Inquiry
                    </a>
                </div>
            </div>

            <!-- Bottom Part: Mockup (Optimized for Visibility) -->
            <div class="w-full max-w-5xl mx-auto px-4 flex justify-center perspective-1000">
                <div id="hero-card" class="relative w-full max-w-4xl group transition-transform duration-100 ease-out transform-style-3d">
                    <div class="chunky-card rotate-1 group-hover:rotate-0 p-3 lg:p-4 rounded-[40px] bg-white h-full shadow-[10px_10px_0px_0px_#000] flex items-center justify-center overflow-hidden transition-all duration-500">
                         <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&q=80" 
                         class="w-full max-h-[400px] object-contain lg:object-cover rounded-[32px] border-[3px] border-black" 
                         alt="Gen-Z Hoodie">
                    </div>
                    
                    <!-- Floating Badges -->
                    <div class="absolute -top-6 -right-5 md:right-0 bg-neon-green border-[3px] border-black px-5 py-3 rounded-2xl font-black uppercase text-sm shadow-[3px_3px_0px_0px_#000] -rotate-6 z-20">
                        Verified Drip 🛠️
                    </div>
                    <div class="absolute -bottom-4 left-0 md:left-[-2%] bg-accent border-[3px] border-black px-5 py-3 rounded-2xl font-black uppercase text-sm text-white shadow-[3px_3px_0px_0px_#000] rotate-12 z-20">
                        48H Shipping 🚀
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ⚡ Dynamic Sale Countdown -->
    <?php if($sale_end_time && strtotime($sale_end_time) > time()): ?>
    <section class="bg-black py-8 md:py-12 border-b-[3px] border-black overflow-hidden relative group">
        <!-- Animated Background Patterns -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent animate-pulse"></div>
        <div class="absolute inset-0 bg-[linear-gradient(45deg,#222_25%,transparent_25%,transparent_75%,#222_75%,#222),linear-gradient(45deg,#222_25%,transparent_25%,transparent_75%,#222_75%,#222)] bg-[length:40px_40px] bg-[position:0_0,20px_20px] opacity-10"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12 bg-white/5 backdrop-blur-sm border-[3px] border-white/20 rounded-[40px] p-6 md:p-10 shadow-[8px_8px_0px_0px_rgba(255,255,255,0.1)] hover:shadow-[12px_12px_0px_0px_#ccfd32] hover:border-neon-yellow transition-all duration-300">
                
                <!-- Left Content -->
                <div class="text-center lg:text-left flex-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-neon-yellow text-black rounded-lg border-[2px] border-black text-xs font-black uppercase tracking-widest mb-4 shadow-[2px_2px_0px_0px_#fff]">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span> Live Now
                    </div>
                    <h3 class="text-white font-black uppercase text-3xl md:text-5xl tracking-tighter mb-4 leading-none">
                        Flash Drop <span class="text-transparent bg-clip-text bg-gradient-to-r from-neon-yellow to-neon-green">Ending.</span>
                    </h3>
                    <p class="text-white/70 font-bold text-sm md:text-lg max-w-md mx-auto lg:mx-0">
                        Secure your grail before it's gone forever. Stocks running low.
                    </p>
                </div>
                
                <!-- Countdown Timer -->
                <div class="flex items-center gap-2 md:gap-4" id="countdown-timer" data-end="<?php echo $sale_end_time; ?>">
                    <!-- Days -->
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 md:w-24 md:h-24 bg-black border-[3px] border-neon-yellow rounded-2xl flex items-center justify-center relative overflow-hidden group/box">
                            <div class="absolute inset-0 bg-neon-yellow/10 translate-y-full group-hover/box:translate-y-0 transition-transform"></div>
                            <span class="text-2xl md:text-4xl font-black text-white z-10" id="days">00</span>
                        </div>
                        <span class="text-[10px] md:text-xs font-black text-neon-yellow uppercase tracking-widest mt-3 bg-black px-2 rounded">Days</span>
                    </div>
                    
                    <span class="text-2xl md:text-4xl font-black text-white/20 -mt-8">:</span>
                    
                    <!-- Hours -->
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 md:w-24 md:h-24 bg-black border-[3px] border-neon-yellow rounded-2xl flex items-center justify-center relative overflow-hidden group/box">
                            <div class="absolute inset-0 bg-neon-yellow/10 translate-y-full group-hover/box:translate-y-0 transition-transform"></div>
                            <span class="text-2xl md:text-4xl font-black text-white z-10" id="hours">00</span>
                        </div>
                        <span class="text-[10px] md:text-xs font-black text-neon-yellow uppercase tracking-widest mt-3 bg-black px-2 rounded">Hours</span>
                    </div>
                    
                    <span class="text-2xl md:text-4xl font-black text-white/20 -mt-8">:</span>

                    <!-- Minutes -->
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 md:w-24 md:h-24 bg-black border-[3px] border-neon-yellow rounded-2xl flex items-center justify-center relative overflow-hidden group/box">
                            <div class="absolute inset-0 bg-neon-yellow/10 translate-y-full group-hover/box:translate-y-0 transition-transform"></div>
                            <span class="text-2xl md:text-4xl font-black text-white z-10" id="minutes">00</span>
                        </div>
                        <span class="text-[10px] md:text-xs font-black text-neon-yellow uppercase tracking-widest mt-3 bg-black px-2 rounded">Mins</span>
                    </div>
                    
                    <span class="text-2xl md:text-4xl font-black text-white/20 -mt-8">:</span>

                    <!-- Seconds -->
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 md:w-24 md:h-24 bg-neon-yellow border-[3px] border-white rounded-2xl flex items-center justify-center shadow-[0px_0px_20px_rgba(204,253,50,0.5)] animate-pulse">
                            <span class="text-2xl md:text-4xl font-black text-black" id="seconds">00</span>
                        </div>
                        <span class="text-[10px] md:text-xs font-black text-white uppercase tracking-widest mt-3 bg-white/10 px-2 rounded">Secs</span>
                    </div>
                </div>

                <!-- CTA -->
                <div class="hidden md:block">
                     <a href="shop.php" class="h-20 w-20 rounded-full bg-white border-[3px] border-black flex items-center justify-center group/cta hover:scale-110 transition-transform shadow-[4px_4px_0px_0px_#ccfd32]">
                        <i data-lucide="arrow-right" class="w-8 h-8 text-black group-hover/cta:-rotate-45 transition-transform duration-300"></i>
                     </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Hot Drops (Categories Carousel) -->
    <section class="section-py bg-background overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex items-end justify-between mb-12 gap-8">
                <div>
                    <h2 class="text-section-title font-black tracking-tighter uppercase mb-4">Hot Drops</h2>
                    <p class="text-xl font-bold opacity-70">Pick your canvas. Start your craft.</p>
                </div>
                <!-- Custom Navigation -->
                <div class="flex gap-4">
                    <button class="cat-prev w-12 h-12 border-[3px] border-black bg-white rounded-xl flex items-center justify-center hover:bg-neon-yellow transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                        <i data-lucide="chevron-left" class="w-6 h-6"></i>
                    </button>
                    <button class="cat-next w-12 h-12 border-[3px] border-black bg-white rounded-xl flex items-center justify-center hover:bg-neon-yellow transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                        <i data-lucide="chevron-right" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <div class="swiper catSwiper overflow-visible">
                <div class="swiper-wrapper">
                    <!-- Category 1 -->
                    <div class="swiper-slide">
                        <a href="shop.php?category=t-shirts" class="chunky-card group overflow-hidden rounded-[40px] block">
                            <div class="aspect-[4/5] relative">
                                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Tees">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                                <div class="absolute bottom-8 left-8">
                                    <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Oversized Tees</h3>
                                    <p class="text-neon-yellow font-black uppercase text-xs mt-2">Level Up Your Fit</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Category 2 -->
                    <div class="swiper-slide">
                        <a href="shop.php?category=hoodies" class="chunky-card group overflow-hidden rounded-[40px] block">
                            <div class="aspect-[4/5] relative">
                                <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Hoodies">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                                <div class="absolute bottom-8 left-8">
                                    <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Street Hoodies</h3>
                                    <p class="text-neon-yellow font-black uppercase text-xs mt-2">Cozy x Cool</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Category 3 -->
                    <div class="swiper-slide">
                        <a href="shop.php?category=sweatshirts" class="chunky-card group overflow-hidden rounded-[40px] block">
                            <div class="aspect-[4/5] relative">
                                <img src="https://images.unsplash.com/photo-1578587018452-892bacefd3f2?auto=format&fit=crop&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Sweats">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                                <div class="absolute bottom-8 left-8">
                                    <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Essentials</h3>
                                    <p class="text-neon-yellow font-black uppercase text-xs mt-2">Daily Drip</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Category 4 -->
                    <div class="swiper-slide">
                        <a href="shop.php?category=uppers" class="chunky-card group overflow-hidden rounded-[40px] block">
                            <div class="aspect-[4/5] relative">
                                <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Jackets">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                                <div class="absolute bottom-8 left-8">
                                    <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Grails</h3>
                                    <p class="text-neon-yellow font-black uppercase text-xs mt-2">Limited Edition</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Latest Products Carousel -->
    <section class="section-py bg-white overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex items-end justify-between mb-12 gap-8">
                <div>
                    <h2 class="text-section-title font-black tracking-tighter uppercase mb-4">Fresh Drops</h2>
                    <p class="text-xl font-bold opacity-70">New items just landed in the studio.</p>
                </div>
                <div class="flex gap-4">
                    <button class="prod-prev w-12 h-12 border-[3px] border-black bg-white rounded-xl flex items-center justify-center hover:bg-neon-yellow transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                        <i data-lucide="chevron-left" class="w-6 h-6"></i>
                    </button>
                    <button class="prod-next w-12 h-12 border-[3px] border-black bg-white rounded-xl flex items-center justify-center hover:bg-neon-yellow transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                        <i data-lucide="chevron-right" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <div class="swiper prodSwiper overflow-visible">
                <div class="swiper-wrapper">
                    <?php 
                    $latest_products = get_latest_products(10);
                    foreach($latest_products as $product): 
                    ?>
                    <div class="swiper-slide">
                        <div class="chunky-card group rounded-[32px] overflow-hidden bg-white">
                            <div class="relative aspect-square overflow-hidden bg-gray-100 border-b-2 border-black">
                                <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo !empty($product['main_image']) ? $product['main_image'] : 'placeholder.jpg'; ?>" 
                                     alt="<?php echo $product['name'] ?? 'Product'; ?>"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 right-4">
                                    <span class="bg-black text-white text-[10px] font-black px-3 py-1.5 rounded-full uppercase">New</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-black uppercase tracking-tight mb-2 truncate"><?php echo $product['name']; ?></h3>
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-xl font-black text-primary italic"><?php echo format_price($product['base_price']); ?></span>
                                    <div class="flex gap-2">
                                        <button data-product-id="<?php echo $product['id']; ?>" class="add-to-cart-btn w-10 h-10 bg-black text-white rounded-xl flex items-center justify-center hover:bg-neon-green hover:text-black transition-colors">
                                            <i data-lucide="plus" class="w-5 h-5"></i>
                                        </button>
                                        <a href="product.php?id=<?php echo $product['id']; ?>" class="w-10 h-10 border-[3px] border-black rounded-xl flex items-center justify-center hover:bg-primary transition-colors">
                                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔥 WearKraft Reels: Brand Stories (9:16 Carousel) -->
    <section id="wk-reels-section" class="section-py bg-black text-white overflow-hidden py-24">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-8">
                <div>
                    <h2 class="text-4xl md:text-7xl font-black tracking-tighter uppercase mb-4 leading-none">
                        Vibe <span class="text-primary italic">Check.</span>
                    </h2>
                    <p class="text-lg md:text-xl font-bold opacity-60 uppercase tracking-widest">Street stories and community drops.</p>
                </div>
                <div class="flex gap-4">
                    <button id="wk-reels-prev" class="w-14 h-14 border-[3px] border-white bg-transparent text-white rounded-2xl flex items-center justify-center hover:bg-white hover:text-black transition-all">
                        <i data-lucide="chevron-left" class="w-8 h-8"></i>
                    </button>
                    <button id="wk-reels-next" class="w-14 h-14 border-[3px] border-white bg-transparent text-white rounded-2xl flex items-center justify-center hover:bg-white hover:text-black transition-all">
                        <i data-lucide="chevron-right" class="w-8 h-8"></i>
                    </button>
                </div>
            </div>

            <div class="swiper wkReelsSwiper !overflow-visible">
                <div class="swiper-wrapper">
                    <?php 
                    $reels = get_active_reels();
                    foreach($reels as $reel): 
                    ?>
                    <div class="swiper-slide !w-[280px] md:!w-[340px]">
                        <div class="wk-reel-card group relative aspect-[9/16] rounded-[32px] overflow-hidden border-[3px] border-white/20 hover:border-primary transition-all duration-500 cursor-pointer" 
                             onclick="wkOpenReel(<?php echo htmlspecialchars(json_encode($reel)); ?>)">
                            <!-- Video Background -->
                            <video class="wk-reel-video absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity" 
                                   src="<?php echo $reel['video_url']; ?>" muted loop playsinline preload="metadata">
                            </video>

                            <!-- Glass Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>
                            
                            <!-- Content -->
                            <div class="absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 transition-transform">
                                <p class="text-sm font-bold opacity-80 mb-3 line-clamp-2"><?php echo $reel['caption']; ?></p>
                                <div class="flex flex-wrap gap-2">
                                    <?php if($reel['cta_type'] == 'shop'): ?>
                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-black rounded-xl text-[10px] font-black uppercase tracking-widest">
                                            Shop Look <i data-lucide="shopping-bag" class="w-3 h-3"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-neon-yellow text-black rounded-xl text-[10px] font-black uppercase tracking-widest">
                                            Design Yours <i data-lucide="zap" class="w-3 h-3"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Fullscreen Viewer Modal -->
        <div id="wk-reel-viewer" class="fixed inset-0 z-[11000] bg-black hidden flex-col items-center justify-center">
            <button onclick="wkCloseReel()" class="absolute top-8 right-8 w-14 h-14 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center z-[11001] transition-all">
                <i data-lucide="x" class="w-8 h-8"></i>
            </button>
            <div class="relative h-[90vh] aspect-[9/16] max-w-[95vw] rounded-[40px] overflow-hidden border-[3px] border-white/20">
                <video id="wk-viewer-video" class="w-full h-full object-cover" controls autoplay loop playsinline></video>
                <div class="absolute bottom-0 left-0 w-full p-10 bg-gradient-to-t from-black/80 to-transparent">
                    <h4 id="wk-viewer-caption" class="text-xl md:text-2xl font-black mb-6 uppercase tracking-tight"></h4>
                    <div class="flex gap-4">
                        <a id="wk-viewer-cta" href="#" class="px-8 py-4 bg-primary text-white rounded-2xl font-black uppercase text-xs tracking-widest hover:scale-105 transition-all">
                             Shop This Vibe
                        </a>
                        <button onclick="wkCloseReel()" class="px-8 py-4 bg-white/10 text-white rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-white/20 transition-all border border-white/20">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .wk-reel-card:hover .wk-reel-video { transform: scale(1.05); }
        .wk-reel-video { transition: transform 2s cubic-bezier(0.1, 0, 0.3, 1); }
        @media (max-width: 768px) {
            #wk-reels-section { padding-top: 4rem; padding-bottom: 4rem; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Reels Swiper
            const wkReelsSwiper = new Swiper('.wkReelsSwiper', {
                slidesPerView: 'auto',
                spaceBetween: 20,
                centeredSlides: false,
                initialSlide: 0,
                grabCursor: true,
                navigation: {
                    nextEl: '#wk-reels-next',
                    prevEl: '#wk-reels-prev',
                },
                breakpoints: {
                    768: { spaceBetween: 30 }
                }
            });

            // Autoplay videos when they enter viewport
            const wkVideoObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    if (video.tagName === 'VIDEO') {
                        if (entry.isIntersecting) {
                            video.play().catch(() => {});
                        } else {
                            video.pause();
                        }
                    }
                });
            }, { threshold: 0.6 });

            document.querySelectorAll('.wk-reel-video').forEach(video => {
                wkVideoObserver.observe(video);
            });
        });

        function wkOpenReel(reel) {
            const viewer = document.getElementById('wk-reel-viewer');
            const video = document.getElementById('wk-viewer-video');
            const caption = document.getElementById('wk-viewer-caption');
            const cta = document.getElementById('wk-viewer-cta');

            video.src = reel.video_url;
            caption.innerText = reel.caption;
            cta.href = reel.product_id ? `product.php?id=${reel.product_id}` : 'shop.php';
            cta.innerText = reel.cta_type === 'shop' ? 'Shop This Look' : 'Design Yours';
            
            viewer.classList.remove('hidden');
            viewer.classList.add('flex');
            document.body.classList.add('no-scroll');
        }

        function wkCloseReel() {
            const viewer = document.getElementById('wk-reel-viewer');
            const video = document.getElementById('wk-viewer-video');
            video.pause();
            video.src = "";
            viewer.classList.add('hidden');
            viewer.classList.remove('flex');
            document.body.classList.remove('no-scroll');
        }
    </script>

    <!-- Why Us (Brutalist Grid) -->
    <section class="section-py bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-0 border-[3px] border-black">
                <!-- Box 1 -->
                <div class="p-10 lg:p-12 bg-white hover:bg-neon-yellow transition-colors group border-b-2 lg:border-b-0 lg:border-r-2 border-black">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 border-[3px] border-black bg-white rounded-2xl flex items-center justify-center mb-8 lg:mb-10 group-hover:rotate-6 transition-transform text-black">
                        <i data-lucide="zap" class="w-8 h-8 lg:w-10 lg:h-10 text-black fill-current"></i>
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-black mb-6 uppercase leading-none">Instant Drip</h3>
                    <p class="text-base lg:text-lg font-bold leading-tight">We print and ship faster than you can find a matching fit. 48hr turnaround average.</p>
                </div>
                <!-- Box 2 -->
                <div class="p-10 lg:p-12 bg-neon-green hover:rotate-2 transition-transform border-b-2 lg:border-b-0 lg:border-r-2 border-black">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 border-[3px] border-black bg-white rounded-2xl flex items-center justify-center mb-8 lg:mb-10 text-black">
                        <i data-lucide="shield-check" class="w-8 h-8 lg:w-10 lg:h-10 text-black"></i>
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-black mb-6 uppercase leading-none text-black">God Tier Quality</h3>
                    <p class="text-base lg:text-lg font-bold leading-tight text-white">240 GSM organic cotton. Built to last through 100+ washes.</p>
                </div>
                <!-- Box 3 -->
                <div class="p-10 lg:p-12 bg-primary hover:-rotate-2 transition-transform">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 border-[3px] border-black bg-white rounded-2xl flex items-center justify-center mb-8 lg:mb-10 text-black">
                        <i data-lucide="layers" class="w-8 h-8 lg:w-10 lg:h-10 text-black"></i>
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-black mb-6 uppercase text-white leading-none">Bulk Savings</h3>
                    <p class="text-base lg:text-lg font-bold leading-tight text-white">Scale your brand. Automatic price drops for squads and crews.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 🌟 Community Voice: Testimonial Carousel -->
    <section class="section-py bg-[#F9FAFB] overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 lg:mb-16 gap-8">
                <div>
                    <span class="inline-block py-2 px-4 bg-accent text-white font-black uppercase text-[10px] tracking-widest rounded-lg mb-4">Real Reviews 💬</span>
                    <h2 class="text-4xl md:text-7xl font-black tracking-tighter uppercase leading-none">
                        The <span class="text-primary italic">WK Crew.</span>
                    </h2>
                    <p class="text-lg md:text-xl font-bold opacity-60 mt-4 uppercase tracking-widest">Pure drip verified by the community.</p>
                </div>
                <!-- Navigation -->
                <div class="flex gap-4">
                    <button class="testi-prev w-14 h-14 border-[3px] border-black bg-white rounded-2xl flex items-center justify-center hover:bg-neon-yellow transition-all shadow-[3px_3px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                        <i data-lucide="arrow-left" class="w-8 h-8"></i>
                    </button>
                    <button class="testi-next w-14 h-14 border-[3px] border-black bg-white rounded-2xl flex items-center justify-center hover:bg-neon-yellow transition-all shadow-[3px_3px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                        <i data-lucide="arrow-right" class="w-8 h-8"></i>
                    </button>
                </div>
            </div>

            <div class="swiper testiSwiper !overflow-visible">
                <div class="swiper-wrapper">
                    <?php 
                    $testimonials = get_active_testimonials();
                    foreach($testimonials as $testi): 
                    ?>
                    <div class="swiper-slide h-auto">
                        <div class="chunky-card p-8 md:p-10 h-full flex flex-col justify-between bg-white rounded-[40px] relative">
                            <!-- Large Quote Icon -->
                            <div class="absolute -top-6 -left-2 w-16 h-16 bg-neon-yellow border-[3px] border-black rounded-2xl flex items-center justify-center -rotate-12 z-10 shadow-[3px_3px_0px_0px_#000]">
                                <i data-lucide="quote" class="w-8 h-8 text-black fill-current"></i>
                            </div>

                            <div>
                                <!-- Rating -->
                                <div class="flex gap-1 mb-6">
                                    <?php for($i=0; $i<5; $i++): ?>
                                        <i data-lucide="star" class="w-5 h-5 <?php echo $testi['rating'] > $i ? 'text-primary fill-primary' : 'text-gray-300'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-xl md:text-2xl font-bold leading-tight mb-8 italic">
                                    "<?php echo $testi['testimony']; ?>"
                                </p>
                            </div>

                            <div class="flex items-center gap-4 border-t-2 border-black/5 pt-8">
                                <div class="w-14 h-14 bg-gray-100 rounded-full border-[3px] border-black overflow-hidden flex-shrink-0 flex items-center justify-center font-black text-xl text-black">
                                    <?php if($testi['user_image']): ?>
                                        <img src="<?php echo $testi['user_image']; ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <?php echo substr($testi['user_name'], 0, 1); ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="font-black uppercase text-sm tracking-widest"><?php echo $testi['user_name']; ?></h4>
                                    <span class="text-xs font-bold opacity-50 uppercase tracking-tighter"><?php echo $testi['user_handle']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Initialize Carousels -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category Swiper
            new Swiper('.catSwiper', {
                slidesPerView: 1.2,
                spaceBetween: 20,
                loop: true,
                navigation: {
                    nextEl: '.cat-next',
                    prevEl: '.cat-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2.2, spaceBetween: 24 },
                    1024: { slidesPerView: 3.5, spaceBetween: 30 },
                    1280: { slidesPerView: 4, spaceBetween: 40 }
                }
            });

            // Product Swiper
            new Swiper('.prodSwiper', {
                slidesPerView: 1.2,
                spaceBetween: 20,
                loop: false,
                navigation: {
                    nextEl: '.prod-next',
                    prevEl: '.prod-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2.2, spaceBetween: 24 },
                    1024: { slidesPerView: 3.2, spaceBetween: 30 },
                    1280: { slidesPerView: 4, spaceBetween: 32 }
                }
            });

            // Testimonial Swiper
            new Swiper('.testiSwiper', {
                slidesPerView: 1.1,
                spaceBetween: 20,
                loop: true,
                centeredSlides: false,
                navigation: {
                    nextEl: '.testi-next',
                    prevEl: '.testi-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 1.5, spaceBetween: 24 },
                    1024: { slidesPerView: 2.2, spaceBetween: 30 },
                    1280: { slidesPerView: 2.8, spaceBetween: 40 }
                }
            });

            // Interactive Hero Effect
            const heroSection = document.getElementById('hero-interactive');
            const heroCard = document.getElementById('hero-card');
            const parallaxElements = document.querySelectorAll('[data-parallax]');

            if(heroSection) {
                heroSection.addEventListener('mousemove', (e) => {
                    const rect = heroSection.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    // Spotlight
                    heroSection.style.setProperty('--mouse-x', `${x}px`);
                    heroSection.style.setProperty('--mouse-y', `${y}px`);

                    // Parallax for Background Elements
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const moveX = (x - centerX) / centerX;
                    const moveY = (y - centerY) / centerY;

                    parallaxElements.forEach(el => {
                        const speed = el.getAttribute('data-parallax');
                        const xOffset = moveX * speed;
                        const yOffset = moveY * speed;
                        el.style.transform = `translate(${xOffset}px, ${yOffset}px)`;
                    });

                    // 3D Tilt for Hero Card
                    if(heroCard) {
                        const rotateY = moveX * 5; // Max 5deg rotation
                        const rotateX = -moveY * 5;
                        heroCard.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                    }
                });

                // Reset on leave
                heroSection.addEventListener('mouseleave', () => {
                   if(heroCard) heroCard.style.transform = `perspective(1000px) rotateX(0) rotateY(0)`;
                   parallaxElements.forEach(el => el.style.transform = `translate(0,0)`);
                });
            }

            // Countdown Timer Logic
            const timerContainer = document.getElementById('countdown-timer');
            if(timerContainer) {
                const endTime = new Date(timerContainer.dataset.end).getTime();
                
                function updateTimer() {
                    const now = new Date().getTime();
                    const distance = endTime - now;

                    if (distance < 0) {
                        timerContainer.innerHTML = "<div class='text-white font-black text-2xl uppercase'>Sale Ended</div>";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById('days').innerText = String(days).padStart(2, '0');
                    document.getElementById('hours').innerText = String(hours).padStart(2, '0');
                    document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
                    document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
                }

                setInterval(updateTimer, 1000);
                updateTimer(); // Initial call
            }
        });
    </script>
</main>

<?php require_once 'includes/footer.php'; ?>
