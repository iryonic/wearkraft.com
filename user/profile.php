<?php
require_once '../includes/functions.php';
if (!is_logged_in()) redirect('../login.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $phone = sanitize($_POST['phone']);
    
    db_query("UPDATE users SET full_name = ?, phone = ? WHERE id = ?", [$full_name, $phone, $user_id]);
    redirect("profile.php?success=1");
}

$page_title = "My Profile";
require_once '../includes/header.php';

$user = db_fetch_one("SELECT * FROM users WHERE id = ?", [$user_id]);
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
                        <a href="orders.php" class="flex items-center gap-3 px-5 py-4 bg-white text-black border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest hover:bg-gray-100 transition-all">
                            <i data-lucide="package" class="w-4 h-4"></i>
                            My Orders
                        </a>
                        <a href="profile.php" class="flex items-center gap-3 px-5 py-4 bg-black text-white border-[3px] border-black rounded-xl font-black uppercase text-xs tracking-widest shadow-[4px_4px_0px_0px_#FF6B00] transition-all hover:-translate-y-1">
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

            <!-- Profile Content -->
            <div class="flex-grow">
                <div class="mb-10">
                    <h1 class="text-4xl font-black tracking-tight mb-2">My Profile</h1>
                    <p class="text-slate-500">Manage your personal information and security.</p>
                </div>

                <div class="bg-white rounded-[24px] border-[3px] border-black shadow-[8px_8px_0px_0px_#000] p-8 lg:p-10">
                    <?php if(isset($_GET['success'])): ?>
                    <div class="bg-neon-green text-black border-[3px] border-black shadow-[4px_4px_0px_0px_#000] p-6 rounded-2xl text-xs font-black uppercase tracking-widest mb-10 flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                        Profile updated successfully!
                    </div>
                    <?php endif; ?>

                    <form action="profile.php" method="POST" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Full Name</label>
                                <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>"
                                       class="w-full bg-slate-50 border-[3px] border-black h-14 rounded-2xl px-6 focus:outline-none focus:bg-neon-yellow shadow-[4px_4px_0px_0px_#e2e8f0] focus:shadow-[4px_4px_0px_0px_#000] transition-all font-bold text-lg">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Email Address</label>
                                <input type="email" value="<?php echo $user['email']; ?>" disabled
                                       class="w-full bg-slate-100 border-[3px] border-slate-200 h-14 rounded-2xl px-6 font-bold text-slate-400 cursor-not-allowed opacity-60">
                                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-widest flex items-center gap-1"><i data-lucide="lock" class="w-3 h-3"></i> Locked</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Phone Number</label>
                                <input type="tel" name="phone" value="<?php echo $user['phone'] ?? ''; ?>"
                                       class="w-full bg-slate-50 border-[3px] border-black h-14 rounded-2xl px-6 focus:outline-none focus:bg-neon-yellow shadow-[4px_4px_0px_0px_#e2e8f0] focus:shadow-[4px_4px_0px_0px_#000] transition-all font-bold text-lg" placeholder="+91 XXXX XXX XXX">
                            </div>
                        </div>

                        <div class="pt-8 border-t-[3px] border-black border-dashed">
                            <button type="submit" class="px-12 h-14 bg-black text-white rounded-2xl font-black uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-3 shadow-[6px_6px_0px_0px_#FF6B00] border-[3px] border-black active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                                <i data-lucide="save" class="w-5 h-5"></i>
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
