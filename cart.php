<?php 
$page_title = "Your Shopping Cart";
require_once 'includes/header.php'; 

$user_id = $_SESSION['user_id'] ?? null;
$session_id = session_id();

$sql = "SELECT c.*, p.name, p.base_price, p.discounted_price, 
        (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) as image,
        cat.name as category_name
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        JOIN categories cat ON p.category_id = cat.id
        WHERE " . ($user_id ? "c.user_id = ?" : "c.session_id = ?");

$params = [$user_id ?: $session_id];
$cart_items = db_fetch_all($sql, $params);

$subtotal = 0;
foreach($cart_items as $item) {
    $price = $item['discounted_price'] ?? $item['base_price'];
    $subtotal += $price * $item['quantity'];
}
?>

<main class="pt-10">
    <div class="container mx-auto px-4 lg:px-20">
        <h1 class="text-4xl font-bold tracking-tight mb-10">Shopping Bag</h1>

        <?php if(empty($cart_items)): ?>
        <div class="py-32 text-center glass rounded-[40px]">
            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="shopping-cart" class="w-12 h-12 text-slate-300"></i>
            </div>
            <h2 class="text-2xl font-bold mb-4">Your bag is empty</h2>
            <p class="text-slate-500 mb-8 max-w-sm mx-auto">Looks like you haven't added anything to your cart yet. Let's find something awesome for you!</p>
            <a href="shop.php" class="px-8 py-4 bg-black text-white rounded-2xl font-bold hover:bg-slate-800 transition-all inline-block">
                Start Shopping
            </a>
        </div>
        <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-16">
            <!-- Items List -->
            <div class="flex-grow space-y-8">
                <?php foreach($cart_items as $item): 
                    $price = $item['discounted_price'] ?? $item['base_price'];
                    $custom_data = json_decode($item['custom_data'], true);
                ?>
                <div class="flex flex-col sm:flex-row gap-6 p-6 glass rounded-3xl border border-slate-100 relative group">
                    <button class="absolute top-4 right-4 p-2 text-slate-300 hover:text-red-500 transition-colors">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>

                    <div class="w-full sm:w-40 aspect-square rounded-2xl overflow-hidden bg-slate-100 flex-shrink-0">
                        <img src="<?php echo $item['image'] ?? 'https://via.placeholder.com/300?text=' . urlencode($item['name']); ?>" 
                             class="w-full h-full object-cover">
                    </div>

                    <div class="flex-grow py-2">
                        <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1"><?php echo $item['category_name']; ?></p>
                        <h3 class="text-xl font-bold mb-2"><?php echo $item['name']; ?></h3>
                        
                        <div class="flex flex-wrap gap-4 text-sm text-slate-500 mb-6">
                            <?php if($custom_data['size'] ?? ''): ?>
                            <span class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                <span class="font-bold text-slate-400">Size:</span> <?php echo $custom_data['size']; ?>
                            </span>
                            <?php endif; ?>
                            <?php if($custom_data['color'] ?? ''): ?>
                            <span class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                <span class="font-bold text-slate-400">Color:</span> 
                                <span class="w-3 h-3 rounded-full border border-slate-200" style="background-color: <?php echo $custom_data['color']; ?>"></span>
                            </span>
                            <?php endif; ?>
                            <?php if($item['custom_data']): ?>
                            <span class="flex items-center gap-1.5 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg border border-blue-100">
                                <i data-lucide="palette" class="w-3 h-3"></i> Custom Print
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center bg-slate-100 rounded-xl h-11 p-1">
                                <button class="w-8 h-full flex items-center justify-center hover:bg-white rounded-lg transition-colors">
                                    <i data-lucide="minus" class="w-3 h-3 text-slate-500"></i>
                                </button>
                                <input type="number" value="<?php echo $item['quantity']; ?>" class="w-12 bg-transparent text-center font-bold text-sm focus:outline-none">
                                <button class="w-8 h-full flex items-center justify-center hover:bg-white rounded-lg transition-colors">
                                    <i data-lucide="plus" class="w-3 h-3 text-slate-500"></i>
                                </button>
                            </div>
                            <p class="text-xl font-bold"><?php echo format_price($price * $item['quantity']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Continue Shopping -->
                <a href="shop.php" class="inline-flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    Continue Shopping
                </a>
            </div>

            <!-- Summary Sidebar -->
            <aside class="w-full lg:w-[400px]">
                <div class="sticky top-24 glass p-10 rounded-[40px] border border-slate-100">
                    <h3 class="text-2xl font-bold mb-8">Order Summary</h3>

                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-slate-500">
                            <span>Subtotal (<?php echo count($cart_items); ?> items)</span>
                            <span class="font-bold text-black"><?php echo format_price($subtotal); ?></span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Shipping</span>
                            <span class="text-emerald-500 font-bold uppercase tracking-widest text-xs">Free</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>GST (18%)</span>
                            <span class="font-bold text-black"><?php echo format_price($subtotal * 0.18); ?></span>
                        </div>
                    </div>

                    <div class="h-px bg-slate-100 mb-8"></div>

                    <div class="flex justify-between items-end mb-10">
                        <span class="font-bold text-lg">Total Amount</span>
                        <div class="text-right">
                            <p class="text-3xl font-black text-primary tracking-tighter"><?php echo format_price($subtotal * 1.18); ?></p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Inclusive of all taxes</p>
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    <div class="relative mb-8">
                        <input type="text" placeholder="Promo Code" class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-colors pr-24 font-medium">
                        <button class="absolute right-2 top-2 bottom-2 px-4 bg-black text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition-colors">
                            Apply
                        </button>
                    </div>

                    <a href="checkout.php" class="w-full h-16 bg-black text-white rounded-2xl font-bold text-lg flex items-center justify-center gap-3 hover:bg-slate-800 transition-all transform active:scale-95 shadow-xl shadow-black/10">
                        <span>Checkout Now</span>
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>

                    <!-- Security Badge -->
                    <div class="mt-8 flex items-center gap-3 justify-center text-slate-400">
                        <i data-lucide="shield-check" class="w-5 h-5 text-emerald-500"></i>
                        <span class="text-xs font-medium uppercase tracking-widest">Secure SSL Checkout</span>
                    </div>
                </div>
            </aside>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
