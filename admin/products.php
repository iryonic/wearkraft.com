<?php
// admin/products.php
require_once 'includes/header.php';

$products = db_fetch_all("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
?>

<div class="flex items-center justify-between mb-10">
    <div>
        <h1 class="text-3xl font-black tracking-tight mb-2">Catalog Management</h1>
        <p class="text-slate-500">Add, edit, and organize your apparel inventory.</p>
    </div>
    <button class="px-8 py-4 bg-primary text-white rounded-[20px] font-bold hover:bg-primary-dark transition-all flex items-center gap-2 shadow-lg shadow-primary/20">
        <i data-lucide="plus" class="w-5 h-5"></i> Add New Product
    </button>
</div>

<div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-0">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    <th class="px-8 py-5">Product Info</th>
                    <th class="px-8 py-5">Category</th>
                    <th class="px-8 py-5">Base Price</th>
                    <th class="px-8 py-5">Stock</th>
                    <th class="px-8 py-5">Status</th>
                    <th class="px-8 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach($products as $p): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="https://via.placeholder.com/100?text=<?php echo urlencode($p['name']); ?>" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900"><?php echo $p['name']; ?></p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">SKU: <?php echo $p['sku'] ?: 'N/A'; ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                         <span class="text-sm font-medium text-slate-600 bg-slate-100 px-3 py-1 rounded-lg"><?php echo $p['category_name']; ?></span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-sm"><?php echo format_price($p['base_price']); ?></p>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full <?php echo $p['stock_quantity'] > 10 ? 'bg-emerald-500' : 'bg-red-500'; ?>"></div>
                             <span class="text-sm font-bold"><?php echo $p['stock_quantity']; ?></span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase rounded-full"><?php echo $p['status']; ?></span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="p-2 hover:bg-white rounded-lg border border-transparent hover:border-slate-100 transition-all text-slate-400 hover:text-primary">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button class="p-2 hover:bg-white rounded-lg border border-transparent hover:border-slate-100 transition-all text-slate-400 hover:text-red-500">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
