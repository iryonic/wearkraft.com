<?php 
require_once 'includes/functions.php';

if (is_logged_in()) redirect('user/index.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $user = db_fetch_one("SELECT * FROM users WHERE email = ?", [$email]);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        
        if (is_admin()) redirect('admin/index.php');
        redirect('user/index.php');
    } else {
        $error = "Invalid email or password.";
    }
}

$page_title = "Login";
require_once 'includes/header.php'; 
?>

<main class="min-h-[80vh] flex items-center justify-center py-20 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white p-10 lg:p-12 rounded-[40px] border-[3px] border-black shadow-[10px_10px_0px_0px_#000] relative overflow-hidden">
            <!-- Decorative blur -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-neon-yellow border-[3px] border-black rounded-full"></div>
            
            <div class="text-center mb-10 relative z-10">
                <h1 class="text-4xl font-black tracking-tighter mb-2 uppercase">Welcome Back</h1>
                <p class="text-slate-500 font-bold">Log in to your WearKraft account</p>
            </div>

            <?php if($error): ?>
            <div class="bg-red-50 text-red-500 p-4 rounded-2xl text-xs font-bold mb-8 flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-6">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                        <input type="email" name="email" required
                               class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl pl-12 pr-6 focus:outline-none focus:border-primary transition-all font-medium" 
                               placeholder="name@example.com">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Password</label>
                        <a href="#" class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline">Forgot?</a>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-black"></i>
                        <input type="password" name="password" id="login-password" required
                               class="w-full bg-white border-[3px] border-black h-14 rounded-2xl pl-12 pr-12 focus:outline-none focus:bg-yellow-50 transition-all font-bold" 
                               placeholder="••••••••">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-black transition-colors" onclick="togglePassword('login-password', this)">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full h-14 bg-black text-white rounded-2xl font-bold hover:bg-slate-800 transition-all transform active:scale-95 shadow-xl shadow-black/10 flex items-center justify-center gap-3">
                    Sign In
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-10 text-center">
                <p class="text-sm text-slate-500">
                    New to WearKraft? <a href="register.php" class="text-primary font-bold hover:underline">Create an account</a>
                </p>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
