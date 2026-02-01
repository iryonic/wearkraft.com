<?php 
require_once '../includes/functions.php'; 
if (!is_admin()) redirect('../login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WearKraft Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .admin-sidebar { height: 100vh; position: sticky; top: 0; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-72 bg-slate-900 text-slate-400 admin-sidebar hidden lg:block overflow-y-auto">
            <div class="p-8">
                <a href="index.php" class="text-white text-2xl font-black tracking-tighter flex items-center gap-2 mb-12">
                    <i data-lucide="layers" class="text-primary"></i>
                    WEARKRAFT
                </a>

                <nav class="space-y-8">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] mb-4 text-slate-500">Core</p>
                        <div class="space-y-1">
                            <a href="index.php" class="flex items-center gap-3 px-4 py-3 bg-[#6366f1] text-white rounded-xl font-bold">
                                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                Dashboard
                            </a>
                            <a href="orders.php" class="flex items-center gap-3 px-4 py-3 hover:text-white transition-colors">
                                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                                Orders
                                <span class="ml-auto bg-slate-800 text-[10px] px-2 py-0.5 rounded-full">12</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] mb-4 text-slate-500">Inventory</p>
                        <div class="space-y-1">
                            <a href="products.php" class="flex items-center gap-3 px-4 py-3 hover:text-white transition-colors">
                                <i data-lucide="package" class="w-5 h-5"></i>
                                Products
                            </a>
                            <a href="categories.php" class="flex items-center gap-3 px-4 py-3 hover:text-white transition-colors">
                                <i data-lucide="folder-tree" class="w-5 h-5"></i>
                                Categories
                            </a>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] mb-4 text-slate-500">Marketing</p>
                        <div class="space-y-1">
                            <a href="coupons.php" class="flex items-center gap-3 px-4 py-3 hover:text-white transition-colors">
                                <i data-lucide="ticket" class="w-5 h-5"></i>
                                Coupons
                            </a>
                            <a href="affiliates.php" class="flex items-center gap-3 px-4 py-3 hover:text-white transition-colors">
                                <i data-lucide="users" class="w-5 h-5"></i>
                                Affiliates
                            </a>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] mb-4 text-slate-500">Settings</p>
                        <div class="space-y-1">
                            <a href="settings.php" class="flex items-center gap-3 px-4 py-3 hover:text-white transition-colors">
                                <i data-lucide="settings" class="w-5 h-5"></i>
                                Site Settings
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow min-h-screen">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-slate-200 sticky top-0 z-10 px-8 flex items-center justify-between">
                <button class="lg:hidden p-2 bg-slate-100 rounded-lg">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                
                <div class="hidden lg:flex items-center bg-slate-100 px-4 py-2 rounded-xl w-96 border border-slate-200">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 mr-3"></i>
                    <input type="text" placeholder="Search orders, products..." class="bg-transparent text-sm focus:outline-none w-full">
                </div>

                <div class="flex items-center gap-6">
                    <button class="relative p-2 text-slate-400 hover:text-black transition-colors">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="h-8 w-px bg-slate-200"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-900">Admin WearKraft</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Master Admin</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin+WearKraft&background=000&color=fff" class="w-10 h-10 rounded-xl" alt="Admin">
                    </div>
                </div>
            </header>
            
            <div class="p-8 lg:p-12">
