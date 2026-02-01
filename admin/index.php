<?php require_once 'includes/header.php'; ?>

<div class="mb-10">
    <h1 class="text-3xl font-black tracking-tight mb-2">Dashboard Overlook</h1>
    <p class="text-slate-500">Welcome back. Here's what's happening with WearKraft today.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 group hover:border-primary transition-all">
        <div class="w-12 h-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-all">
            <i data-lucide="trending-up" class="w-6 h-6"></i>
        </div>
        <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mb-1">Total Revenue</p>
        <h3 class="text-3xl font-black tracking-tighter">₹1,24,500</h3>
        <p class="text-emerald-500 text-xs font-bold mt-2 flex items-center gap-1">
            <i data-lucide="arrow-up-right" class="w-3 h-3"></i> +12.5% vs last month
        </p>
    </div>

    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 group hover:border-primary transition-all">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-600 group-hover:text-white transition-all">
            <i data-lucide="shopping-bag" class="w-6 h-6"></i>
        </div>
        <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mb-1">Active Orders</p>
        <h3 class="text-3xl font-black tracking-tighter">42</h3>
        <p class="text-slate-400 text-xs font-bold mt-2 tracking-widest uppercase">
            8 In Production
        </p>
    </div>

    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 group hover:border-primary transition-all">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all">
            <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mb-1">New Customers</p>
        <h3 class="text-3xl font-black tracking-tighter">128</h3>
        <p class="text-emerald-500 text-xs font-bold mt-2 flex items-center gap-1">
            <i data-lucide="arrow-up-right" class="w-3 h-3"></i> +5.2% grow
        </p>
    </div>

    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 group hover:border-primary transition-all">
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-600 group-hover:text-white transition-all">
            <i data-lucide="zap" class="w-6 h-6"></i>
        </div>
        <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mb-1">Conversion Rate</p>
        <h3 class="text-3xl font-black tracking-tighter">3.2%</h3>
        <p class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1">
            <i data-lucide="arrow-down-right" class="w-3 h-3"></i> -0.4% drop
        </p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Recent Orders -->
    <div class="lg:col-span-2 bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="text-xl font-bold">Recent Orders</h3>
            <button class="text-primary font-bold text-sm">View All</button>
        </div>
        <div class="p-0">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <th class="px-8 py-4">Order ID</th>
                        <th class="px-8 py-4">Customer</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-6 font-bold text-sm">#WK-82910</td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-500">SK</div>
                                <div>
                                    <p class="text-sm font-bold">Sumit Kraft</p>
                                    <p class="text-[10px] text-slate-400">sumit@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-bold uppercase rounded-full">In Production</span>
                        </td>
                        <td class="px-8 py-6 text-right font-bold">₹1,299.00</td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-6 font-bold text-sm">#WK-82909</td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-500">AJ</div>
                                <div>
                                    <p class="text-sm font-bold">Animesh Jha</p>
                                    <p class="text-[10px] text-slate-400">ani@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase rounded-full">Delivered</span>
                        </td>
                        <td class="px-8 py-6 text-right font-bold">₹2,499.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions / Alerts -->
    <div class="space-y-8">
        <div class="bg-slate-900 rounded-[40px] p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-10">
                <i data-lucide="layers" class="w-24 h-24"></i>
            </div>
            <h3 class="text-xl font-bold mb-4 relative z-10">Need Bulk Pricing?</h3>
            <p class="text-slate-400 text-sm mb-8 leading-relaxed relative z-10">Adjust your global bulk pricing rules to increase your conversion for corporate clients.</p>
            <button class="w-full py-4 bg-white text-black rounded-2xl font-bold hover:bg-slate-100 transition-all relative z-10">Adjust Now</button>
        </div>

        <div class="bg-white rounded-[40px] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-xl font-bold mb-6">Stock Alerts</h3>
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="alert-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Classic Tee (Black, S)</p>
                        <p class="text-xs text-slate-500">Only 3 items remaining in stock</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="alert-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Essential Hoodie (L)</p>
                        <p class="text-xs text-slate-500">Out of stock</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
