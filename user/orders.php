<?php
require_once '../includes/functions.php';
if (!is_logged_in()) redirect('../login.php');

$user_id = $_SESSION['user_id'];
$orders = db_fetch_all("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC", [$user_id]);

$page_title = "Order History";
require_once '../includes/header.php';
?>

<main class="min-h-screen bg-slate-50 pt-10">
    <div class="container mx-auto px-4 lg:px-20 pb-20">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Sidebar Navigation -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-[24px] p-8 border-[3px] border-black shadow-[8px_8px_0px_0px_#000] sticky top-24">
                    <nav class="space-y-3">
                        <a href="index.php" class="flex items-center gap-3 px-5 py-4 bg-white text-black border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-gray-100 transition-all">
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                            Dashboard
                        </a>
                        <a href="orders.php" class="flex items-center gap-3 px-5 py-4 bg-black text-white border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest shadow-[4px_4px_0px_0px_#FF6B00] transition-all hover:-translate-y-1">
                            <i data-lucide="package" class="w-4 h-4"></i>
                            My Orders
                        </a>
                        <a href="profile.php" class="flex items-center gap-3 px-5 py-4 bg-white text-black border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-gray-100 transition-all">
                            <i data-lucide="user-cog" class="w-4 h-4"></i>
                            Profile
                        </a>
                        <div class="h-1 bg-black rounded-full my-6 opacity-10"></div>
                        <a href="../logout.php" class="flex items-center gap-3 px-5 py-4 bg-white text-red-500 border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-red-50 transition-all">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Log Out
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Orders Content -->
            <div class="flex-grow">
                <div class="mb-10">
                    <h1 class="text-4xl font-black uppercase tracking-tighter mb-2">Order History</h1>
                    <p class="text-slate-500 font-bold text-sm">View and track all your custom creations.</p>
                </div>

                <?php if(empty($orders)): ?>
                <div class="bg-white rounded-[24px] border-[3px] border-black shadow-[8px_8px_0px_0px_#000] p-20 text-center">
                    <div class="w-24 h-24 bg-gray-100 border-[3px] border-black rounded-full flex items-center justify-center mx-auto mb-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                        <i data-lucide="package-search" class="w-10 h-10 text-slate-400"></i>
                    </div>
                    <h2 class="text-2xl font-black uppercase tracking-tighter mb-4">No orders yet</h2>
                    <p class="text-slate-500 font-bold mb-8 max-w-xs mx-auto">Your masterpiece is waiting to be created. Head over to the shop to start designing.</p>
                    <a href="../shop.php" class="inline-flex px-8 py-4 bg-black text-white border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-primary transition-all shadow-[4px_4px_0px_0px_#FF6B00] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none items-center gap-2">
                        Browse Catalog <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
                <?php else: ?>
                <div class="space-y-6">
                    <?php foreach($orders as $o): ?>
                    <div class="bg-white rounded-[24px] border-[3px] border-black shadow-[6px_6px_0px_0px_#000] overflow-hidden p-8 flex flex-col md:flex-row gap-8 items-center hover:-translate-y-1 transition-transform">
                        <div class="flex-grow text-center md:text-left">
                            <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                                <span class="text-xs font-black bg-gray-100 border border-black px-2 py-1 rounded-lg uppercase tracking-widest"><?php echo $o['order_number']; ?></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?php echo date('M d, Y', strtotime($o['created_at'])); ?></span>
                            </div>
                            <p class="text-3xl font-black mb-4"><?php echo format_price($o['total_amount']); ?></p>
                            <div class="flex items-center justify-center md:justify-start gap-3">
                                <span class="px-3 py-1 bg-neon-green text-black border-[2px] border-black text-[10px] font-black uppercase rounded-lg shadow-[2px_2px_0px_0px_#000]">
                                    <?php echo $o['order_status']; ?>
                                </span>
                                <span class="px-3 py-1 bg-white text-black border-[2px] border-black text-[10px] font-bold uppercase rounded-lg shadow-[2px_2px_0px_0px_#000]">
                                    Paid: <?php echo ucfirst($o['payment_status']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                            <button class="flex-1 md:flex-none px-6 py-3 bg-white border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-gray-100 transition-all shadow-[4px_4px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                                Details
                            </button>
                            <button class="flex-1 md:flex-none px-6 py-3 bg-black text-white border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-primary transition-all shadow-[4px_4px_0px_0px_#FF6B00] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                                Track Order
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
