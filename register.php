<?php 
require_once 'includes/functions.php';

if (is_logged_in()) redirect('user/index.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists
    $check = db_fetch_one("SELECT id FROM users WHERE email = ?", [$email]);
    if ($check) {
        $error = "Email already registered!";
    } else {
        $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
        if (db_query($sql, [$full_name, $email, $password])) {
            $_SESSION['user_id'] = db_insert_id();
            $_SESSION['full_name'] = $full_name;
            $_SESSION['role'] = 'user';
            redirect('user/index.php');
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}

$page_title = "Create Account";
require_once 'includes/header.php'; 
?>

<main class="min-h-[80vh] flex items-center justify-center py-20 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white p-10 lg:p-12 rounded-[40px] border-[3px] border-black shadow-[10px_10px_0px_0px_#000] relative overflow-hidden">
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-neon-green border-[3px] border-black rounded-full"></div>
            
            <div class="text-center mb-10 relative z-10">
                <h1 class="text-4xl font-black tracking-tighter mb-2 uppercase">Join WearKraft</h1>
                <p class="text-slate-500 font-bold">Create your creator profile today</p>
            </div>

            <?php if($error): ?>
            <div class="bg-red-50 text-red-500 p-4 rounded-2xl text-xs font-bold mb-8 flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <form action="register.php" method="POST" class="space-y-6">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Full Name</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                        <input type="text" name="full_name" required
                               class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl pl-12 pr-6 focus:outline-none focus:border-primary transition-all font-medium" 
                               placeholder="John Doe">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                        <input type="email" name="email" required
                               class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl pl-12 pr-6 focus:outline-none focus:border-primary transition-all font-medium" 
                               placeholder="john@example.com">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-black"></i>
                        <input type="password" name="password" id="register-password" required
                               class="w-full bg-white border-[3px] border-black h-14 rounded-2xl pl-12 pr-12 focus:outline-none focus:bg-yellow-50 transition-all font-bold" 
                               placeholder="Min. 8 characters" onkeyup="checkPasswordStrength(this.value)">
                         <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-black transition-colors" onclick="togglePassword('register-password', this)">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <!-- Password Validators -->
                    <!-- Password Validators -->
                    <div class="mt-4 flex flex-wrap gap-2" id="password-requirements">
                        <div class="validator-pill px-3 py-1.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-400 flex items-center gap-2 transition-all duration-300" id="req-length">
                            <i data-lucide="circle" class="w-3 h-3"></i> 8+ Characters
                        </div>
                        <div class="validator-pill px-3 py-1.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-400 flex items-center gap-2 transition-all duration-300" id="req-number">
                             <i data-lucide="circle" class="w-3 h-3"></i> Number
                        </div>
                        <div class="validator-pill px-3 py-1.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-400 flex items-center gap-2 transition-all duration-300" id="req-upper">
                             <i data-lucide="circle" class="w-3 h-3"></i> Uppercase
                        </div>
                         <div class="validator-pill px-3 py-1.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-400 flex items-center gap-2 transition-all duration-300" id="req-special">
                             <i data-lucide="circle" class="w-3 h-3"></i> Special Char
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-3 py-2">
                    <input type="checkbox" required class="mt-1 w-4 h-4 rounded border-gray-300 text-primary">
                    <p class="text-[10px] text-slate-500 leading-tight">
                        I agree to the <a href="#" class="text-primary font-bold">Terms of Service</a> and <a href="#" class="text-primary font-bold">Privacy Policy</a>.
                    </p>
                </div>

                <button type="submit" class="w-full h-14 bg-black text-white rounded-2xl font-bold hover:bg-slate-800 transition-all transform active:scale-95 shadow-xl shadow-black/10 flex items-center justify-center gap-3">
                    Register Account
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-10 text-center">
                <p class="text-sm text-slate-500">
                    Already have an account? <a href="login.php" class="text-primary font-bold hover:underline">Log in here</a>
                </p>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
