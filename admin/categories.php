<?php
require_once 'includes/header.php';

$categories = db_fetch_all("SELECT * FROM categories ORDER BY id ASC");
?>

<div class="flex items-center justify-between mb-10">
    <div>
        <h1 class="text-3xl font-black tracking-tight mb-2">Categories</h1>
        <p class="text-slate-500">Organize your apparel by styles and collections.</p>
    </div>
    <button class="px-8 py-4 bg-primary text-white rounded-[20px] font-bold hover:bg-primary-dark transition-all flex items-center gap-2 shadow-lg shadow-primary/20">
        <i data-lucide="plus" class="w-5 h-5"></i> Add Category
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
    <?php foreach($categories as $c): ?>
    <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 group hover:border-primary transition-all relative overflow-hidden">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <span class="px-3 py-1 bg-slate-100 text-[10px] font-bold uppercase rounded-lg text-slate-500 mb-2 inline-block">Collection</span>
                <h3 class="text-2xl font-black tracking-tight truncate w-48"><?php echo $c['name']; ?></h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">slug: /<?php echo $c['slug']; ?></p>
            </div>
            <div class="flex gap-2">
                <button class="p-2 hover:bg-slate-50 rounded-lg text-slate-400 hover:text-primary transition-all">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        
        <div class="mt-8 flex items-center justify-between relative z-10">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-bold text-slate-600 uppercase tracking-widest"><?php echo $c['status']; ?></span>
            </div>
            <a href="../shop.php?category=<?php echo $c['slug']; ?>" target="_blank" class="text-slate-400 hover:text-black transition-all">
                <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Background decoration -->
        <i data-lucide="layers" class="absolute -bottom-6 -right-6 w-32 h-32 text-slate-50 opacity-[0.03] group-hover:scale-110 transition-transform duration-700"></i>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
