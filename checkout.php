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

                    <!-- Section 2: Magic Shipping -->
                    <div class="bg-white p-8 lg:p-12 rounded-[40px] shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)] border-[3px] border-black relative overflow-hidden group">
                         <!-- Decorative Flash -->
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-neon-yellow rounded-full blur-3xl opacity-20 group-hover:opacity-40 transition-opacity"></div>

                        <h2 class="text-2xl font-black uppercase tracking-tighter flex items-center gap-4 mb-8">
                            <span class="w-12 h-12 bg-black text-neon-yellow border-[2px] border-black rounded-xl flex items-center justify-center text-lg shadow-[4px_4px_0px_0px_rgba(204,253,50,1)]">2</span>
                            Shipping Details
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php 
                            // Split full name
                            $name_parts = explode(' ', $user['full_name'] ?? '');
                            $fname = $name_parts[0] ?? '';
                            $lname = isset($name_parts[1]) ? implode(' ', array_slice($name_parts, 1)) : '';
                            ?>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">First Name</label>
                                <input type="text" name="first_name" value="<?php echo $fname; ?>" class="w-full bg-slate-50 border-[3px] border-black h-14 rounded-2xl px-6 focus:outline-none focus:shadow-[4px_4px_0px_0px_#ccfd32] transition-all font-bold" required>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Last Name</label>
                                <input type="text" name="last_name" value="<?php echo $lname; ?>" class="w-full bg-slate-50 border-[3px] border-black h-14 rounded-2xl px-6 focus:outline-none focus:shadow-[4px_4px_0px_0px_#ccfd32] transition-all font-bold" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 flex justify-between">
                                    Address
                                    <span class="text-emerald-600 animate-pulse hidden" id="magic-fill-badge">✨ Magic Fill Active</span>
                                </label>
                                <input type="text" name="address" value="<?php echo $user['saved_address'] ?? ''; ?>" class="w-full bg-slate-50 border-[3px] border-black h-14 rounded-2xl px-6 focus:outline-none focus:shadow-[4px_4px_0px_0px_#ccfd32] transition-all font-bold" placeholder="House / Flat / Street" required>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">City</label>
                                <input type="text" name="city" value="<?php echo $user['saved_city'] ?? ''; ?>" class="w-full bg-slate-50 border-[3px] border-black h-14 rounded-2xl px-6 focus:outline-none focus:shadow-[4px_4px_0px_0px_#ccfd32] transition-all font-bold" required>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Pincode</label>
                                <input type="text" name="zip" value="<?php echo $user['saved_zip'] ?? ''; ?>" class="w-full bg-slate-50 border-[3px] border-black h-14 rounded-2xl px-6 focus:outline-none focus:shadow-[4px_4px_0px_0px_#ccfd32] transition-all font-bold" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Phone Number</label>
                                <div class="flex gap-3">
                                    <div class="w-20 bg-slate-100 border-[3px] border-black h-14 rounded-2xl flex items-center justify-center font-black text-slate-500">+91</div>
                                    <input type="tel" name="phone" value="<?php echo $user['saved_phone'] ?? $user['phone'] ?? ''; ?>" class="flex-grow bg-slate-50 border-[3px] border-black h-14 rounded-2xl px-6 focus:outline-none focus:shadow-[4px_4px_0px_0px_#ccfd32] transition-all font-bold" required>
                                </div>
                            </div>
                            
                            <?php if($user_id): ?>
                            <div class="md:col-span-2">
                                <label class="flex items-center gap-3 cursor-pointer group/check">
                                    <div class="w-6 h-6 border-[3px] border-black rounded flex items-center justify-center bg-white group-hover/check:bg-neon-yellow transition-colors relative">
                                        <input type="checkbox" name="save_info" checked class="w-full h-full opacity-0 absolute cursor-pointer">
                                        <i data-lucide="check" class="w-4 h-4 opacity-100 pointer-events-none"></i>
                                    </div>
                                    <span class="text-xs font-bold uppercase tracking-widest">Save for next time (Magic Fill ⚡)</span>
                                </label>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Section 3: Payment -->
                    <div class="bg-white p-8 lg:p-12 rounded-[40px] shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)] border-[3px] border-black">
                        <h2 class="text-2xl font-black uppercase tracking-tighter flex items-center gap-4 mb-8">
                            <span class="w-12 h-12 bg-black text-neon-yellow border-[2px] border-black rounded-xl flex items-center justify-center text-lg shadow-[4px_4px_0px_0px_rgba(204,253,50,1)]">3</span>
                            Payment Method
                        </h2>

                        <div class="space-y-4">
                            <label class="flex items-center justify-between p-6 border-[3px] border-black bg-neon-yellow/10 rounded-[28px] cursor-pointer shadow-[4px_4px_0px_0px_#000] relative overflow-hidden transition-all hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#000]">
                                <div class="flex items-center gap-4 z-10">
                                    <div class="w-6 h-6 rounded-full border-[3px] border-black flex items-center justify-center bg-white">
                                        <div class="w-3 h-3 bg-black rounded-full"></div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-lg uppercase tracking-tight">Razorpay (Secure)</span>
                                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">UPI, Cards, Netbanking</span>
                                    </div>
                                </div>
                                <div class="flex gap-2 opacity-50 grayscale hover:grayscale-0 transition-all z-10">
                                     <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/Razorpay_logo.svg" class="h-6" alt="Razorpay">
                                </div>
                                <input type="radio" name="payment" value="razorpay" checked class="hidden">
                            </label>

                            <label class="flex items-center justify-between p-6 border-[3px] border-slate-200 rounded-[28px] cursor-pointer hover:border-black hover:bg-slate-50 transition-all opacity-60 hover:opacity-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-6 h-6 rounded-full border-[3px] border-slate-300 flex items-center justify-center bg-white"></div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-lg uppercase tracking-tight text-slate-400">Cash on Delivery</span>
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Unavailable for this order</span>
                                    </div>
                                </div>
                                <i data-lucide="truck" class="w-6 h-6 text-slate-300"></i>
                                <input type="radio" name="payment" value="cod" disabled class="hidden">
                            </label>
                        </div>
                    </div>

                    <!-- Action -->
                    <div class="pt-6">
                        <button id="complete-order-btn" class="w-full h-20 bg-black text-white rounded-3xl font-black text-2xl hover:bg-primary transition-all shadow-[8px_8px_0px_0px_#ccfd32] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none flex items-center justify-center gap-4 group">
                            <span>Secure Checkout</span>
                            <i data-lucide="lock" class="w-6 h-6 group-hover:scale-110 transition-transform"></i>
                        </button>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center mt-6">
                            Encrypted & Secure · 100% Cotton Guarantee
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

</main>

<script>
document.getElementById('complete-order-btn').addEventListener('click', function() {
    const btn = this;
    const originalText = btn.innerHTML;
    
    // Collect data
    const inputs = document.querySelectorAll('input, select');
    const data = new FormData();
    
    inputs.forEach(input => {
        if(input.type === 'radio' && !input.checked) return;
        if(input.type === 'checkbox') {
             if(input.checked) data.append(input.name, input.value);
        } else {
             data.append(input.name, input.value);
        }
    });

    btn.innerHTML = '<i data-lucide="loader-2" class="w-6 h-6 animate-spin"></i> Processing...';
    if(typeof lucide !== 'undefined') lucide.createIcons();
    btn.disabled = true;

    fetch('ajax/checkout_process.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(result => {
        if(result.success) {
            window.location.href = result.redirect;
        } else {
            alert(result.message);
            btn.innerHTML = originalText;
            btn.disabled = false;
            if(typeof lucide !== 'undefined') lucide.createIcons();
        }
    })
    .catch(err => {
        console.error(err);
        alert('Something went wrong. Please try again.');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
