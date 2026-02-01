<?php
// Includes security and functions within the header already.
require_once 'includes/header.php';

$orders = db_fetch_all("SELECT o.*, u.full_name as customer_name, u.email as customer_email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
?>

<div class="flex items-center justify-between mb-10">
    <div>
        <h1 class="text-3xl font-black tracking-tight mb-2">Order Logistics</h1>
        <p class="text-slate-500">Manage order fulfillment, printing, and shipping status.</p>
    </div>
    <div class="flex gap-4">
        <button class="px-6 py-3 bg-white border border-slate-200 rounded-2xl font-bold flex items-center gap-2 hover:bg-slate-50 transition-all">
            <i data-lucide="download" class="w-5 h-5"></i> Export
        </button>
    </div>
</div>

<!-- Simple Filter Tabs -->
<div class="flex gap-4 mb-8 overflow-x-auto no-scrollbar pb-2">
    <button class="px-6 py-2.5 bg-black text-white rounded-xl font-bold text-sm whitespace-nowrap">All Orders</button>
    <button class="px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-xl font-bold text-sm hover:border-black transition-all whitespace-nowrap">Pending</button>
    <button class="px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-xl font-bold text-sm hover:border-black transition-all whitespace-nowrap">Printing</button>
    <button class="px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-xl font-bold text-sm hover:border-black transition-all whitespace-nowrap">Shipped</button>
</div>

<div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
    <?php if(empty($orders)): ?>
    <div class="p-20 text-center">
        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
            <i data-lucide="package" class="w-8 h-8"></i>
        </div>
        <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No orders yet</p>
    </div>
    <?php else: ?>
    <div class="p-0">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    <th class="px-8 py-5">Order ID</th>
                    <th class="px-8 py-5">Customer</th>
                    <th class="px-8 py-5">Amount</th>
                    <th class="px-8 py-5">Payment</th>
                    <th class="px-8 py-5">Status</th>
                    <th class="px-8 py-5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach($orders as $o): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-slate-900"><?php echo $o['order_number']; ?></p>
                        <p class="text-[10px] text-slate-400 font-bold mt-0.5"><?php echo date('d M, Y H:i', strtotime($o['created_at'])); ?></p>
                    </td>
                    <td class="px-8 py-6">
                        <div>
                            <p class="text-sm font-bold text-slate-900"><?php echo $o['customer_name']; ?></p>
                            <p class="text-[10px] text-slate-400"><?php echo $o['customer_email']; ?></p>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-sm"><?php echo format_price($o['total_amount']); ?></p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-2.5 py-1 <?php echo $o['payment_status'] === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500'; ?> text-[10px] font-bold uppercase rounded-lg">
                            <?php echo $o['payment_status']; ?>
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <select class="bg-slate-100 border-none text-[10px] font-bold uppercase py-1.5 px-3 rounded-lg focus:ring-1 focus:ring-primary cursor-pointer">
                            <option <?php echo $o['order_status'] === 'placed' ? 'selected' : ''; ?>>Placed</option>
                            <option <?php echo $o['order_status'] === 'printing' ? 'selected' : ''; ?>>Printing</option>
                            <option <?php echo $o['order_status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                            <option <?php echo $o['order_status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                        </select>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <button class="p-2 hover:bg-white rounded-lg border border-transparent hover:border-slate-100 transition-all text-slate-400 hover:text-primary">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
