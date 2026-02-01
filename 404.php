<?php
require_once 'includes/header.php';
?>

<main class="min-h-[80vh] flex items-center justify-center p-4">
    <div class="text-center">
        <div class="relative inline-block mb-10">
            <h1 class="text-[180px] font-black text-slate-100 leading-none">404</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <i data-lucide="compass" class="w-24 h-24 text-primary animate-pulse"></i>
            </div>
        </div>
        <h2 class="text-4xl font-black tracking-tight mb-4">You've reached deep space.</h2>
        <p class="text-slate-500 mb-10 max-w-sm mx-auto">The page you're looking for was either perfectly customized into something else or never existed.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="index.php" class="px-8 py-4 bg-black text-white rounded-2xl font-bold hover:bg-slate-800 transition-all flex items-center justify-center gap-2">
                <i data-lucide="home" class="w-5 h-5"></i> Back Home
            </a>
            <a href="shop.php" class="px-8 py-4 bg-white border border-slate-200 text-black rounded-2xl font-bold hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i> Explore Shop
            </a>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
