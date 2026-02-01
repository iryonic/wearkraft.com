<?php
// User Dashboard Redirect/Wrapper
require_once '../includes/functions.php';
if (!is_logged_in()) redirect('../login.php');

$page_title = "My Studio";
require_once '../includes/header.php';

$user_id = $_SESSION['user_id'];
$user = db_fetch_one("SELECT * FROM users WHERE id = ?", [$user_id]);
?>

<main class="min-h-screen bg-slate-50 pt-10">
    <div class="container mx-auto px-4 lg:px-20 pb-20">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Sidebar Navigation -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-[24px] p-8 border-[3px] border-black shadow-[8px_8px_0px_0px_#000] sticky top-24">
                    <div class="flex flex-col items-center mb-10">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['full_name']); ?>&background=random" class="w-20 h-20 rounded-2xl mb-4 border-[3px] border-black shadow-[4px_4px_0px_0px_#000]" alt="User">
                        <h3 class="font-black text-lg uppercase tracking-wider"><?php echo $user['full_name']; ?></h3>
                        <div class="mt-2 inline-block px-3 py-1 bg-neon-green text-black border-[2px] border-black text-[10px] font-black uppercase tracking-widest rounded-lg">
                             <?php echo $user['role']; ?>
                        </div>
                    </div>

                    <nav class="space-y-3">
                        <a href="index.php" class="flex items-center gap-3 px-5 py-4 bg-black text-white border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest shadow-[4px_4px_0px_0px_#FF6B00] transition-all hover:-translate-y-1">
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                            Dashboard
                        </a>
                        <a href="orders.php" class="flex items-center gap-3 px-5 py-4 bg-white text-black border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-gray-100 transition-all">
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

            <!-- Dashboard Content -->
            <div class="flex-grow">
                <div class="mb-10 flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-black uppercase tracking-tighter mb-2">My Studio</h1>
                        <p class="text-slate-500 font-bold text-sm">Track your creations and manage your account.</p>
                    </div>
                    <a href="../shop.php" class="px-6 py-3 bg-neon-yellow text-black border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-white transition-all flex items-center gap-2 shadow-[4px_4px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                        <i data-lucide="plus" class="w-4 h-4"></i> Create New
                    </a>
                </div>

                <!-- Stats -->
                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white p-6 rounded-2xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] hover:-translate-y-1 transition-transform">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Orders</p>
                        <p class="text-4xl font-black">0</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] hover:-translate-y-1 transition-transform">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">In Transit</p>
                        <p class="text-4xl font-black">0</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] hover:-translate-y-1 transition-transform">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Wishlist</p>
                        <p class="text-4xl font-black">0</p>
                    </div>
                </div>

                <!-- Recent Activity -->
                <!-- Recent Activity -->
                <div class="bg-white rounded-[24px] border-[3px] border-black shadow-[8px_8px_0px_0px_#000] overflow-hidden">
                    <div class="p-6 border-b-[3px] border-black bg-gray-50 flex items-center justify-between">
                        <h3 class="text-xl font-black uppercase tracking-tighter">Recent Orders</h3>
                    </div>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl border-[3px] border-black flex items-center justify-center mx-auto mb-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                            <i data-lucide="package" class="w-8 h-8 text-slate-400"></i>
                        </div>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs mb-6">No recent orders found.</p>
                        <a href="../shop.php" class="text-black font-black text-sm border-b-[3px] border-primary hover:bg-primary hover:text-white transition-colors px-1">Start designing your first piece →</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
