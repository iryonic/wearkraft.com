<?php 
$page_title = "Shop";
require_once 'includes/header.php'; 

// Fetch categories for sidebar/filter
$categories = db_fetch_all("SELECT * FROM categories WHERE status = 'active'");
$selected_category = $_GET['category'] ?? null;

// Build Product Query
$sql = "SELECT p.*, c.name as category_name, 
        (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) as primary_image 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'active'";

$params = [];
if ($selected_category) {
    $sql .= " AND c.slug = ?";
    $params[] = $selected_category;
}

$products = db_fetch_all($sql, $params);
?>

<main class="pt-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-sm text-slate-400">
            <a href="index.php" class="hover:text-black">Home</a>
            <span class="mx-2">/</span>
            <span class="text-black font-medium">Shop</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-24">
                    <h3 class="text-xl font-bold mb-6">Categories</h3>
                    <div class="flex flex-wrap lg:flex-col gap-3">
                        <a href="shop.php" class="px-5 py-3 rounded-2xl border-[3px] border-black <?php echo !$selected_category ? 'bg-black text-white' : 'bg-white hover:bg-neon-yellow'; ?> font-bold transition-all text-sm shadow-[3px_3px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                            All Apparel
                        </a>
                        <?php foreach($categories as $cat): ?>
                        <a href="shop.php?category=<?php echo $cat['slug']; ?>" class="px-5 py-3 rounded-2xl border-[3px] border-black <?php echo $selected_category == $cat['slug'] ? 'bg-black text-white' : 'bg-white hover:bg-neon-yellow'; ?> font-bold transition-all text-sm shadow-[3px_3px_0px_0px_#000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none">
                            <?php echo $cat['name']; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-12 hidden lg:block">
                        <h3 class="text-xl font-bold mb-6">Price Range</h3>
                        <div class="space-y-4">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="group-hover:text-primary transition-colors">Under ₹499</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="group-hover:text-primary transition-colors">₹500 - ₹999</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="group-hover:text-primary transition-colors">₹1000 - ₹1999</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="group-hover:text-primary transition-colors">₹2000+</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="flex-grow">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold">
                        <?php echo $selected_category ? ucwords(str_replace('-', ' ', $selected_category)) : "All Products"; ?>
                        <span class="text-slate-400 font-normal ml-2 text-lg">(<?php echo count($products); ?>)</span>
                    </h2>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-slate-500">Sort by:</span>
                        <select class="bg-transparent font-bold text-sm focus:outline-none cursor-pointer">
                            <option>Latest</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Popularity</option>
                        </select>
                    </div>
                </div>

                <?php if(empty($products)): ?>
                <div class="py-20 text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="package-search" class="w-10 h-10 text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-bold">No products found</h3>
                    <p class="text-slate-500 mt-2">Try adjusting your filters or browse other categories.</p>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    <?php foreach($products as $product): ?>
                    <div class="product-card group">
                        <a href="product.php?slug=<?php echo $product['slug']; ?>" class="block relative aspect-[4/5] bg-white rounded-[32px] overflow-hidden border-[3px] border-black shadow-[6px_6px_0px_0px_#000] hover:shadow-[10px_10px_0px_0px_#000] transition-all duration-300 hover:-translate-y-1">
                            <?php if($product['featured']): ?>
                            <span class="absolute top-4 left-4 z-10 bg-neon-yellow border-[3px] border-black px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider shadow-[3px_3px_0px_0px_#000]">Featured</span>
                            <?php endif; ?>
                            
                            <img src="<?php echo $product['primary_image'] ?? 'https://via.placeholder.com/500x600?text=' . urlencode($product['name']); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                 alt="<?php echo $product['name']; ?>">
                            
                            <!-- Quick Action -->
                            <div class="absolute inset-x-4 bottom-4 translate-y-20 group-hover:translate-y-0 transition-transform duration-300">
                                <div class="bg-white border-[3px] border-black p-2 rounded-2xl flex items-center justify-between shadow-[4px_4px_0px_0px_#000]">
                                    <span class="text-black font-black px-3 uppercase text-xs tracking-wider">Customize</span>
                                    <div class="w-10 h-10 bg-black text-white rounded-xl flex items-center justify-center shadow-lg">
                                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="mt-6 px-2">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1"><?php echo $product['category_name']; ?></p>
                                    <h3 class="font-black text-lg mb-2 leading-tight">
                                        <a href="product.php?slug=<?php echo $product['slug']; ?>" class="hover:text-primary transition-colors underline decoration-2 decoration-transparent hover:decoration-primary underline-offset-4"><?php echo $product['name']; ?></a>
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-xl"><?php echo format_price($product['discounted_price'] ?? $product['base_price']); ?></p>
                                    <?php if($product['discounted_price']): ?>
                                    <p class="text-xs font-bold text-slate-400 line-through decoration-2 decoration-red-500"><?php echo format_price($product['base_price']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="flex text-black gap-0.5">
                                    <i data-lucide="star" class="w-3 h-3 fill-black"></i>
                                    <i data-lucide="star" class="w-3 h-3 fill-black"></i>
                                    <i data-lucide="star" class="w-3 h-3 fill-black"></i>
                                    <i data-lucide="star" class="w-3 h-3 fill-black"></i>
                                    <i data-lucide="star" class="w-3 h-3"></i>
                                </div>
                                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">4.8 (120)</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
