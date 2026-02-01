<?php require_once 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo get_meta_title($page_title ?? ""); ?></title>
    
    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css?v=<?php echo time(); ?>">
    
    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF6B00',
                        secondary: '#64748b',
                        accent: '#FF3366',
                        'neon-yellow': '#FACC15',
                        'neon-green': '#22C55E',
                        background: '#F3F4F6'
                    },
                    borderRadius: {
                        '2xl': '1.5rem',
                        '3xl': '2rem',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Lexend Mega', 'sans-serif'],
                    }
                }
            }
        }
        window.SITE_URL = '<?php echo SITE_URL; ?>';
    </script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js" defer></script>
</head>
<body class="bg-background text-black antialiased selection:bg-neon-yellow selection:text-black">

    <!-- Announcement Bar -->
    <div class="marquee-container">
        <div class="marquee-content">
            <span class="px-4"><?php echo get_setting('announcement_text'); ?></span>
            <span class="px-4"><?php echo get_setting('announcement_text'); ?></span>
            <span class="px-4"><?php echo get_setting('announcement_text'); ?></span>
            <span class="px-4"><?php echo get_setting('announcement_text'); ?></span>
        </div>
    </div>

    <!-- Header -->
    <header id="main-header" class="sticky top-0 z-50 py-4 lg:py-6 bg-white/90 backdrop-blur-md border-b-[3px] border-black transition-all duration-300">
        <div class="container mx-auto px-4 lg:px-20 flex items-center justify-between">
            
            <div class="flex items-center gap-4 lg:gap-12">
                <!-- Mobile Hamburger - Visible on lg screens and below -->
                <button id="open-mobile-menu" class="lg:hidden w-10 h-10 bg-white border-[3px] border-black rounded-xl flex items-center justify-center shadow-[2px_2px_0px_0px_#000] active:shadow-none active:translate-x-[2px] active:translate-y-[2px] transition-all">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

                <!-- Logo -->
                <a href="<?php echo SITE_URL; ?>" class="text-xl lg:text-3xl font-black tracking-tighter uppercase group flex items-center gap-2">
                    <div class="w-10 h-10 bg-black text-white rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform">
                        <i data-lucide="zap" class="w-6 h-6 fill-current"></i>
                    </div>
                    <span>Wear<span class="text-primary italic">Kraft</span></span>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-10">
                    <a href="<?php echo SITE_URL; ?>" class="font-black text-xs uppercase tracking-[0.2em] hover:text-primary transition-colors">Home</a>
                    
                    <a href="<?php echo SITE_URL; ?>/shop.php" class="font-black text-xs uppercase tracking-[0.2em] hover:text-primary transition-colors">Shop</a>

                    <!-- Dynamic Mega Dropdown -->
                    <div class="group relative">
                        <a href="<?php echo SITE_URL; ?>/shop.php" class="font-black text-xs uppercase tracking-[0.2em] hover:text-primary transition-colors flex items-center gap-1">
                            Drops <i data-lucide="chevron-down" class="w-3 h-3"></i>
                        </a>
                        
                        <!-- The Mega Menu -->
                        <div class="mega-menu absolute left-[-200px] w-[800px] bg-white shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] rounded-3xl p-10 flex gap-12 border-[3px] border-black transition-all">
                            <div class="w-1/3">
                                <h3 class="text-4xl font-black uppercase tracking-tighter leading-none mb-6">Explore <br/><span class="text-primary italic">The Vault.</span></h3>
                                <p class="font-bold text-sm opacity-70 mb-8">Premium custom threads for the next generation of creators.</p>
                                <a href="shop.php" class="inline-block px-6 py-3 bg-black text-white rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-primary transition-colors">View All</a>
                            </div>
                            <div class="w-2/3 grid grid-cols-2 gap-4">
                                <?php 
                                $header_cats = get_active_categories();
                                foreach(array_slice($header_cats, 0, 6) as $h_cat): 
                                ?>
                                <a href="shop.php?category=<?php echo $h_cat['slug']; ?>" class="mega-menu-item p-4 rounded-2xl flex items-center gap-4 group/item">
                                    <div class="w-12 h-12 bg-gray-100 rounded-xl overflow-hidden border-[2px] border-black flex-shrink-0">
                                        <img src="<?php echo SITE_URL; ?>/assets/images/categories/<?php echo $h_cat['image'] ?: 'placeholder.jpg'; ?>" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="block font-black uppercase text-xs tracking-wider"><?php echo $h_cat['name']; ?></span>
                                        <span class="text-[10px] font-bold opacity-50 uppercase tracking-tighter">Shop Now</span>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <a href="<?php echo SITE_URL; ?>/about.php" class="font-black text-xs uppercase tracking-[0.2em] hover:text-primary transition-colors">Story</a>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="font-black text-xs uppercase tracking-[0.2em] hover:text-primary transition-colors">Bulk</a>
                </nav>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-6">
                <!-- Search -->
                <!-- Search -->
                <button id="open-search" class="w-14 h-14 bg-white border-[3px] border-black rounded-2xl flex items-center justify-center hover:bg-neon-yellow transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none group">
                    <i data-lucide="search" class="w-6 h-6 group-hover:scale-110 transition-transform"></i>
                </button>

                <!-- Cart -->
                <a href="javascript:void(0)" id="open-cart" class="w-14 h-14 bg-white border-[3px] border-black rounded-2xl flex items-center justify-center relative group hover:bg-neon-green transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                    <i data-lucide="shopping-bag" class="w-6 h-6 group-hover:scale-110 transition-transform"></i>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-accent text-white border-[2px] border-black text-[10px] w-6 h-6 rounded-full flex items-center justify-center font-black">
                        <?php echo get_cart_count(); ?>
                    </span>
                </a>

                <!-- account -->
               
                <?php if (is_logged_in()): ?>
                    <div class="relative group z-50">
                        <button class="flex items-center gap-3 pl-2 pr-5 py-2 bg-black text-white rounded-2xl hover:bg-slate-900 transition-all border-[3px] border-black shadow-[2px_2px_0px_0px_#FF6B00]">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['full_name']); ?>&background=random" class="w-9 h-9 rounded-xl border-[2px] border-white" alt="User">
                            <div class="text-left hidden xl:block">
                                <span class="block text-[10px] font-black uppercase tracking-widest leading-none"><?php echo explode(' ', $_SESSION['full_name'])[0]; ?></span>
                                <span class="block text-[8px] font-bold text-white/60 uppercase tracking-widest leading-none mt-1"><?php echo is_admin() ? 'Admin' : 'Member'; ?></span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-white/50 group-hover:rotate-180 transition-transform"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute top-full right-0 mt-3 w-56 bg-white border-[3px] border-black rounded-2xl shadow-[6px_6px_0px_0px_#000] overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100">
                            <div class="p-2 space-y-1">
                                <a href="<?php echo is_admin() ? SITE_URL.'/admin' : SITE_URL.'/user'; ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-bold text-xs uppercase tracking-widest transition-colors">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                    Dashboard
                                </a>
                                <?php if(!is_admin()): ?>
                                <a href="<?php echo SITE_URL; ?>/user/orders.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-bold text-xs uppercase tracking-widest transition-colors">
                                    <i data-lucide="package" class="w-4 h-4"></i>
                                    My Orders
                                </a>
                                <a href="<?php echo SITE_URL; ?>/user/profile.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-bold text-xs uppercase tracking-widest transition-colors">
                                    <i data-lucide="user-cog" class="w-4 h-4"></i>
                                    Profile
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="border-t-[3px] border-gray-100 p-2">
                                <a href="<?php echo SITE_URL; ?>/logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 text-red-500 font-black text-xs uppercase tracking-widest transition-colors group/logout">
                                    <i data-lucide="log-out" class="w-4 h-4 group-hover/logout:translate-x-1 transition-transform"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo SITE_URL; ?>/login.php" class="hidden lg:flex items-center gap-3 px-8 py-4 bg-black text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-[2px_2px_0px_0px_#FF6B00]">
                        Join Crew
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Drawer (Hidden by default) -->
    <div class="fixed inset-0 z-50 pointer-events-none opacity-0 transition-opacity duration-300" id="mobile-menu-overlay">
        <div class="absolute inset-0 bg-black/20 backdrop-blur-sm"></div>
    </div>
    <div class="fixed top-0 left-0 h-full w-[80vw] max-w-[300px] bg-white z-[51] transform -translate-x-full transition-transform duration-300 flex flex-col border-r-[3px] border-black" id="mobile-menu-drawer">
         <div class="p-6 border-b-[3px] border-black flex items-center justify-between bg-neon-yellow">
            <span class="font-black text-xl uppercase tracking-tighter">Menu</span>
            <button id="close-mobile-menu" class="w-10 h-10 bg-white border-[3px] border-black rounded-xl flex items-center justify-center hover:bg-black hover:text-white transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            <nav class="flex flex-col gap-4">
                <a href="<?php echo SITE_URL; ?>" class="text-xl font-black uppercase tracking-widest hover:text-primary transition-colors">Home</a>
                <a href="<?php echo SITE_URL; ?>/shop.php" class="text-xl font-black uppercase tracking-widest hover:text-primary transition-colors">Drops</a>
                
                <div class="pl-4 border-l-[3px] border-slate-200 space-y-3">
                     <?php 
                    $header_cats = get_active_categories();
                    foreach(array_slice($header_cats, 0, 4) as $h_cat): 
                    ?>
                    <a href="shop.php?category=<?php echo $h_cat['slug']; ?>" class="block font-bold text-sm text-slate-500 hover:text-black uppercase tracking-wider"><?php echo $h_cat['name']; ?></a>
                    <?php endforeach; ?>
                </div>

                <a href="<?php echo SITE_URL; ?>/about.php" class="text-xl font-black uppercase tracking-widest hover:text-primary transition-colors">Story</a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="text-xl font-black uppercase tracking-widest hover:text-primary transition-colors">Bulk</a>
            </nav>
        </div>
        <div class="p-6 border-t-[3px] border-black bg-gray-50">
            <?php if (is_logged_in()): ?>
                <a href="<?php echo is_admin() ? SITE_URL . '/admin' : SITE_URL . '/user'; ?>" class="flex items-center gap-3 p-4 bg-white border-[3px] border-black rounded-2xl shadow-[4px_4px_0px_0px_#000]">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['full_name']); ?>&background=random" class="w-10 h-10 rounded-xl border-[2px] border-black" alt="User">
                    <div>
                        <span class="block font-black uppercase text-xs tracking-widest">Signed in as</span>
                        <span class="block font-bold text-sm truncate max-w-[150px]"><?php echo $_SESSION['full_name']; ?></span>
                    </div>
                </a>
            <?php else: ?>
                <a href="<?php echo SITE_URL; ?>/login.php" class="block w-full py-4 bg-black text-white text-center rounded-2xl font-black uppercase tracking-widest shadow-[4px_4px_0px_0px_#FF6B00]">Join Crew</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar Cart (Moved from Footer) -->
    <div class="fixed inset-0 z-[100] pointer-events-none opacity-0 transition-opacity duration-300" id="cart-overlay">
        <div class="absolute inset-0 bg-black/20 backdrop-blur-sm"></div>
    </div>
    <div class="fixed top-0 right-0 h-full w-[100vw] sm:w-[450px] bg-white z-[101] transform translate-x-full transition-transform duration-300 flex flex-col border-l-[3px] border-black shadow-[-10px_0px_0px_0px_rgba(0,0,0,0.1)]" id="side-cart">
        <div class="p-6 border-b-[3px] border-black flex items-center justify-between bg-white relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-neon-green border-[3px] border-black rounded-xl flex items-center justify-center shadow-[2px_2px_0px_0px_#000]">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tighter">Your Bag</h3>
            </div>
            <button id="close-cart" class="w-10 h-10 bg-white border-[3px] border-black rounded-xl flex items-center justify-center hover:bg-black hover:text-white transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6 scrollbar-hide" id="side-cart-items">
            <!-- Items filled via AJAX -->
            <div class="flex flex-col items-center justify-center h-full opacity-30 invert-0">
                <i data-lucide="shopping-bag" class="w-16 h-16 mb-4"></i>
                <p class="font-black uppercase text-sm tracking-widest">Bag is empty</p>
            </div>
        </div>

        <div class="p-6 border-t-[3px] border-black bg-gray-50 relative z-10">
            <div class="flex items-center justify-between mb-6">
                <span class="font-bold uppercase text-xs tracking-widest opacity-50">Subtotal</span>
                <span class="text-3xl font-black tracking-tight" id="side-cart-subtotal">₹0.00</span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <a href="<?php echo SITE_URL; ?>/cart.php" class="w-full h-14 bg-white border-[3px] border-black rounded-xl flex items-center justify-center font-black uppercase text-xs tracking-widest hover:bg-gray-100 transition-colors shadow-[4px_4px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">View Bag</a>
                <a href="<?php echo SITE_URL; ?>/checkout.php" class="w-full h-14 bg-black text-white border-[3px] border-black rounded-xl flex items-center justify-center font-black uppercase text-xs tracking-widest hover:bg-primary transition-colors shadow-[4px_4px_0px_0px_#FF6B00] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">Checkout</a>
            </div>
        </div>
    </div>

    <!-- Search Modal (Moved from Footer) -->
    <div class="fixed inset-0 z-[100] bg-white/95 backdrop-blur-xl opacity-0 pointer-events-none transition-opacity duration-300" id="search-modal">
        <div class="container mx-auto px-4 h-full flex flex-col">
            <div class="py-8 flex items-center justify-between border-b-[3px] border-black">
                <div class="flex items-center gap-4">
                     <div class="w-12 h-12 bg-neon-yellow border-[3px] border-black rounded-xl flex items-center justify-center shadow-[3px_3px_0px_0px_#000]">
                        <i data-lucide="search" class="w-6 h-6"></i>
                    </div>
                    <div class="text-3xl font-black uppercase tracking-tighter">Search Drops</div>
                </div>
                <button id="close-search" class="w-12 h-12 bg-white border-[3px] border-black rounded-xl flex items-center justify-center hover:bg-black hover:text-white transition-all shadow-[4px_4px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div class="py-12">
                <input type="text" id="search-input" placeholder="Type to hunt..." class="w-full h-24 text-4xl lg:text-6xl font-black uppercase tracking-tighter bg-transparent border-none focus:ring-0 placeholder-gray-200 text-black" autocomplete="off" autofocus>
                <div class="h-1 w-full bg-gray-100 mt-4 rounded-full overflow-hidden">
                    <div class="h-full bg-black w-0 transition-all duration-300" id="search-bar-loader"></div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto pb-12 scrollbar-hide">
                <div id="search-results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Results filled via AJAX -->
                </div>
            </div>
        </div>
    </div>
