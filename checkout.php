<?php 
$page_title = "Checkout";
require_once 'includes/header.php'; 

$user_id = $_SESSION['user_id'] ?? null;
$session_id = session_id();

// Simplified cart check
$cart_count = get_cart_count();
if ($cart_count == 0) redirect('cart.php');

// Fetch user data if logged in
$user = $user_id ? db_fetch_one("SELECT * FROM users WHERE id = ?", [$user_id]) : null;
?>

<main class="pt-10 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4 lg:px-20 pb-32">
        <div class="flex flex-col lg:flex-row gap-16">
            
            <!-- Left: Checkout Form -->
            <div class="flex-grow">
                <div class="space-y-8">
                    
                    <!-- Section 1: Information -->
                    <div class="bg-white p-8 lg:p-12 rounded-[40px] shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold flex items-center gap-4">
                                <span class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center text-sm">1</span>
                                Contact Information
                            </h2>
                            <?php if(!$user_id): ?>
                            <p class="text-sm">Already have an account? <a href="login.php" class="text-primary font-bold">Log in</a></p>
                            <?php endif; ?>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Email Address</label>
                                <input type="email" value="<?php echo $user['email'] ?? ''; ?>" 
                                       class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-colors font-medium" placeholder="your@email.com">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" checked class="w-5 h-5 rounded border-gray-300 text-primary">
                                    <span class="text-sm text-slate-500">Email me with news and offers</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Shipping -->
                    <div class="bg-white p-8 lg:p-12 rounded-[40px] shadow-sm border border-slate-100">
                        <h2 class="text-2xl font-bold flex items-center gap-4 mb-8">
                            <span class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center text-sm">2</span>
                            Shipping Address
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">First Name</label>
                                <input type="text" class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-colors font-medium">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Last Name</label>
                                <input type="text" class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-colors font-medium">
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Address</label>
                                <input type="text" class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-colors font-medium" placeholder="House / Flat / Street">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">City</label>
                                <input type="text" class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-colors font-medium">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Pincode</label>
                                <input type="text" class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-colors font-medium">
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Phone Number</label>
                                <div class="flex gap-3">
                                    <div class="w-20 bg-slate-100 border border-slate-200 h-14 rounded-2xl flex items-center justify-center font-bold text-slate-500">+91</div>
                                    <input type="tel" class="flex-grow bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-colors font-medium">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Payment -->
                    <div class="bg-white p-8 lg:p-12 rounded-[40px] shadow-sm border border-slate-100">
                        <h2 class="text-2xl font-bold flex items-center gap-4 mb-8">
                            <span class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center text-sm">3</span>
                            Payment Method
                        </h2>

                        <div class="space-y-4">
                            <label class="flex items-center justify-between p-6 border-2 border-primary bg-blue-50/30 rounded-[28px] cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <input type="radio" name="payment" checked class="w-5 h-5 text-primary">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-lg">Razorpay (Secure)</span>
                                        <span class="text-sm text-slate-500">Cards, Netbanking, UPI, Wallets</span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/Razorpay_logo.svg" class="h-5" alt="Razorpay">
                                </div>
                            </label>

                            <label class="flex items-center justify-between p-6 border-2 border-slate-100 rounded-[28px] cursor-pointer hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <input type="radio" name="payment" class="w-5 h-5 text-primary">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-lg">Cash on Delivery</span>
                                        <span class="text-sm text-slate-500">Pay when you receive your order</span>
                                    </div>
                                </div>
                                <i data-lucide="truck" class="w-6 h-6 text-slate-300"></i>
                            </label>
                        </div>
                    </div>

                    <!-- Action -->
                    <div class="flex flex-col sm:flex-row gap-6 items-center pt-6">
                        <button class="w-full sm:w-auto px-12 h-16 bg-primary text-white rounded-2xl font-bold text-xl hover:bg-primary-dark transition-all transform active:scale-95 shadow-xl shadow-primary/20">
                            Complete Order
                        </button>
                        <p class="text-xs text-slate-400 max-w-xs text-center sm:text-left">
                            By clicking "Complete Order", you agree to our <a href="#" class="underline">Terms of Service</a> and <a href="#" class="underline">Privacy Policy</a>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary Sticky -->
            <aside class="w-full lg:w-[450px]">
                <div class="sticky top-24 space-y-8">
                    <div class="glass p-10 rounded-[40px] border border-slate-100">
                        <h3 class="text-2xl font-bold mb-8">Cart Summary</h3>
                        
                        <!-- Simple list of items -->
                        <div class="space-y-6 mb-10 max-h-[400px] overflow-y-auto pr-4">
                            <?php 
                            // Re-fetch items for side view
                            $sql = "SELECT c.*, p.name, p.base_price, p.discounted_price, 
                                    (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) as image 
                                    FROM cart c JOIN products p ON c.product_id = p.id 
                                    WHERE " . ($user_id ? "c.user_id = ?" : "c.session_id = ?");
                            $items = db_fetch_all($sql, [$user_id ?: $session_id]);
                            $subtotal = 0;
                            foreach($items as $i): 
                                $price = $i['discounted_price'] ?? $i['base_price'];
                                $subtotal += $price * $i['quantity'];
                            ?>
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="<?php echo $i['image'] ?? 'https://via.placeholder.com/100'; ?>" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-bold text-sm mb-1 truncate w-40"><?php echo $i['name']; ?></h4>
                                    <p class="text-xs text-slate-400">Qty: <?php echo $i['quantity']; ?></p>
                                </div>
                                <p class="font-bold text-sm"><?php echo format_price($price * $i['quantity']); ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="space-y-4 pt-6 border-t border-slate-100">
                            <div class="flex justify-between text-slate-500 text-sm">
                                <span>Subtotal</span>
                                <span class="font-bold text-black"><?php echo format_price($subtotal); ?></span>
                            </div>
                            <div class="flex justify-between text-slate-500 text-sm">
                                <span>Shipping</span>
                                <span class="font-bold text-emerald-600">Free</span>
                            </div>
                            <div class="flex justify-between pt-6">
                                <span class="font-bold text-lg">Total Amount</span>
                                <span class="font-black text-2xl text-primary"><?php echo format_price($subtotal * 1.18); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-3xl p-6 border border-slate-100 flex flex-col items-center text-center">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="shield-check" class="w-6 h-6"></i>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Quality Guarantee</span>
                        </div>
                        <div class="bg-white rounded-3xl p-6 border border-slate-100 flex flex-col items-center text-center">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="rotate-ccw" class="w-6 h-6"></i>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-widest">7-Day Return</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
