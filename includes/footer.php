    <!-- Footer -->
    <footer class="bg-white border-t-[3px] border-black pt-24 pb-32 lg:pb-24 mt-32 bg-grid">
        <div class="container mx-auto px-4 lg:px-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16">
                <!-- Brand Info -->
                <div class="lg:col-span-1">
                    <a href="<?php echo SITE_URL; ?>" class="text-4xl font-black tracking-tighter uppercase mb-8 block">
                        Wear<span class="text-primary italic">Kraft</span>
                    </a>
                    <p class="text-lg font-bold leading-tight mb-10 text-black">
                        High-key the best custom apparel in the game. Built for the creators, by creators.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-12 h-12 bg-white border-[3px] border-black rounded-xl flex items-center justify-center hover:bg-neon-yellow transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                            <i data-lucide="instagram" class="w-6 h-6"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white border-[3px] border-black rounded-xl flex items-center justify-center hover:bg-neon-green transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                            <i data-lucide="twitter" class="w-6 h-6"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white border-[3px] border-black rounded-xl flex items-center justify-center hover:bg-neon-pink transition-all shadow-[2px_2px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                            <i data-lucide="youtube" class="w-6 h-6"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Links 1 -->
                <div>
                    <h4 class="font-black text-xl uppercase tracking-tighter mb-8 border-b-2 border-black inline-block">The Goods</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="font-bold text-lg hover:text-primary transition-colors">Oversized Tees</a></li>
                        <li><a href="#" class="font-bold text-lg hover:text-primary transition-colors">Baggy Hoodies</a></li>
                        <li><a href="#" class="font-bold text-lg hover:text-primary transition-colors">Daily Sweats</a></li>
                        <li><a href="#" class="font-bold text-lg hover:text-primary transition-colors">Bulk Catalog</a></li>
                    </ul>
                </div>

                <!-- Links 2 -->
                <div>
                    <h4 class="font-black text-xl uppercase tracking-tighter mb-8 border-b-2 border-black inline-block">Support</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="font-bold text-lg hover:text-primary transition-colors">Track Order</a></li>
                        <li><a href="#" class="font-bold text-lg hover:text-primary transition-colors">Size Guide</a></li>
                        <li><a href="#" class="font-bold text-lg hover:text-primary transition-colors">Returns</a></li>
                        <li><a href="#" class="font-bold text-lg hover:text-primary transition-colors">FAQs</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="font-black text-xl uppercase tracking-tighter mb-8 border-b-2 border-black inline-block">Join the Crew</h4>
                    <p class="font-bold mb-6 text-sm">Get early access to drops and exclusive drip codes.</p>
                    <div class="flex flex-col gap-3">
                        <input type="email" placeholder="Email Address" class="w-full h-14 border-[3px] border-black rounded-2xl px-6 font-bold focus:outline-none focus:bg-neon-yellow/10 transition-colors">
                        <button class="chunky-btn h-14 bg-black text-white rounded-2xl font-black uppercase text-sm tracking-widest hover:bg-primary transition-colors">Subscribe</button>
                    </div>
                </div>
            </div>
            
            <div class="mt-24 pt-10 border-t-2 border-black flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="font-black text-sm uppercase tracking-widest">
                    &copy; <?php echo date('Y'); ?> WearKraft. Crafted With <i data-lucide="heart" class="w-4 h-4 fill-red-500 inline"></i> By Creators
                </div>
                <div class="flex items-center gap-8">
                    <a href="<?php echo SITE_URL; ?>/privacy-policy.php" class="font-black text-xs uppercase tracking-widest hover:text-primary">Privacy</a>
                    <a href="#" class="font-black text-xs uppercase tracking-widest hover:text-primary">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Premium Mobile Bottom Navigation (Visible on all mobile/tablet sizes) -->
    <nav class="mobile-nav">
        <a href="<?php echo SITE_URL; ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-primary' : 'text-black'; ?> flex flex-col items-center gap-1 group">
            <i data-lucide="zap" class="w-6 h-6 <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'fill-current' : ''; ?> group-active:scale-90 transition-transform"></i>
            <span class="text-[9px] font-black uppercase tracking-tighter">Home</span>
        </a>
        <a href="<?php echo SITE_URL; ?>/shop.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'shop.php' ? 'text-primary' : 'text-black'; ?> flex flex-col items-center gap-1 group">
            <i data-lucide="layout-grid" class="w-6 h-6 group-active:scale-90 transition-transform"></i>
            <span class="text-[9px] font-black uppercase tracking-tighter">Drops</span>
        </a>
        
        <!-- Center Action (Open Cart) -->
        <a href="javascript:void(0)" onclick="toggleCart(true)" class="relative -mt-10 group">
            <div class="w-16 h-16 bg-black text-white rounded-2xl border-[3px] border-black flex items-center justify-center shadow-[3px_3px_0px_0px_#FF6B00] group-active:translate-x-0.5 group-active:translate-y-0.5 group-active:shadow-none transition-all">
                <i data-lucide="plus" class="w-8 h-8 group-hover:rotate-90 transition-transform"></i>
            </div>
        </a>

        <a href="javascript:void(0)" id="open-cart-mobile" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'text-primary' : 'text-black'; ?> flex flex-col items-center gap-1 relative group">
            <i data-lucide="shopping-bag" class="w-6 h-6 group-active:scale-90 transition-transform"></i>
            <span class="text-[9px] font-black uppercase tracking-tighter">Bag</span>
            <?php if(get_cart_count() > 0): ?>
            <span class="absolute -top-1 -right-1 w-5 h-5 bg-accent text-white border-[2px] border-black rounded-full flex items-center justify-center text-[9px] font-black animate-bounce"><?php echo get_cart_count(); ?></span>
            <?php endif; ?>
        </a>

        <?php if(is_logged_in()): ?>
            <a href="<?php echo is_admin() ? SITE_URL.'/admin' : SITE_URL.'/user'; ?>" class="<?php echo strpos($_SERVER['PHP_SELF'], 'user/') !== false ? 'text-primary' : 'text-black'; ?> flex flex-col items-center gap-1 group">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['full_name']); ?>&background=FF6B00&color=fff" class="w-6 h-6 rounded-lg border-[2px] border-black group-active:scale-90 transition-transform" alt="Me">
                <span class="text-[9px] font-black uppercase tracking-tighter">Me</span>
            </a>
        <?php else: ?>
            <a href="<?php echo SITE_URL; ?>/login.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'text-primary' : 'text-black'; ?> flex flex-col items-center gap-1 group">
                <i data-lucide="user" class="w-6 h-6 group-active:scale-90 transition-transform"></i>
                <span class="text-[9px] font-black uppercase tracking-tighter">Join</span>
            </a>
        <?php endif; ?>
    </nav>
    <!-- Core Scripts -->
    <script>window.SITE_URL = "<?php echo SITE_URL; ?>";</script>
    <script src="<?php echo SITE_URL; ?>/assets/js/cart.js"></script>
    
    <?php 
    // Conditional Page Scripts
    $current_page = basename($_SERVER['PHP_SELF']);
    if($current_page == 'login.php' || $current_page == 'register.php') {
        echo '<script src="'.SITE_URL.'/assets/js/auth.js"></script>';
    }
    if($current_page == 'shop.php') {
        echo '<script src="'.SITE_URL.'/assets/js/shop.js"></script>';
    }
    ?>
</body>
</html>
