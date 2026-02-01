<?php 
$slug = $_GET['slug'] ?? null;
require_once 'includes/header.php'; 

if (!$slug) redirect('shop.php');

$product = db_fetch_one("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.slug = ?", [$slug]);
if (!$product) redirect('shop.php');

$images = db_fetch_all("SELECT * FROM product_images WHERE product_id = ?", [$product['id']]);
$sizes = db_fetch_all("SELECT * FROM product_variants WHERE product_id = ? AND variant_type = 'size'", [$product['id']]);
$colors = db_fetch_all("SELECT * FROM product_variants WHERE product_id = ? AND variant_type = 'color'", [$product['id']]);
$bulk_pricing = db_fetch_all("SELECT * FROM bulk_pricing WHERE product_id = ? ORDER BY min_qty", [$product['id']]);
?>

<main class="lg:pt-10">
    <div class="container mx-auto px-4 lg:px-20 pb-20">
        <div class="flex flex-col lg:flex-row gap-16">
            
            <!-- Left: Configurator Preview -->
            <div class="w-full lg:w-3/5">
                <div class="sticky top-24">
                    <!-- Preview Container -->
                    <div id="mockup-container" class="relative aspect-square chunky-card rounded-[60px] overflow-hidden flex items-center justify-center p-12 bg-white">
                        <img id="base-mockup" src="https://m.media-amazon.com/images/I/71u92K3cXML._AC_UX679_.jpg" class="w-full h-full object-contain mix-blend-multiply" alt="Product Mockup">
                        
                        <!-- Design Overlay Area -->
                        <div id="design-area" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div id="movable-print" class="w-48 h-48 border-[3px] border-dashed border-primary pointer-events-auto cursor-move hidden flex items-center justify-center overflow-hidden bg-white/40 backdrop-blur-sm">
                                <img id="uploaded-preview" src="" class="max-w-full max-h-full object-contain">
                                <!-- Resize Handle -->
                                <div id="resize-handle" class="absolute bottom-0 right-0 w-4 h-4 bg-black cursor-nwse-resize"></div>
                            </div>
                        </div>

                        <!-- Badge -->
                        <div class="absolute top-8 left-8">
                            <span class="bg-neon-yellow border-[3px] border-black px-5 py-2 rounded-full text-xs font-black shadow-[4px_4px_0px_0px_#000] uppercase tracking-widest">Live Editor ⚡</span>
                        </div>
                    </div>

                    <!-- Mini Gallery -->
                    <div class="flex gap-6 mt-8 overflow-x-auto pb-4 no-scrollbar">
                        <button class="w-24 h-24 rounded-3xl border-[3px] border-primary chunky-btn overflow-hidden flex-shrink-0 bg-white p-1">
                            <img src="https://m.media-amazon.com/images/I/71u92K3cXML._AC_UX679_.jpg" class="w-full h-full object-cover rounded-2xl">
                        </button>
                        <button class="w-24 h-24 rounded-3xl border-[3px] border-black chunky-btn overflow-hidden flex-shrink-0 bg-white p-1 opacity-40 hover:opacity-100 transition-opacity">
                            <img src="https://m.media-amazon.com/images/I/71u92K3cXML._AC_UX679_.jpg" class="w-full h-full object-cover rounded-2xl transform scale-x-[-1]">
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Logic & Controls -->
            <div class="w-full lg:w-2/5 pb-20">
                <div class="chunky-card p-10 lg:p-12 rounded-[50px] bg-white">
                    <div class="mb-10">
                        <div class="flex items-center gap-2 mb-4">
                             <span class="px-3 py-1 bg-primary text-white text-[10px] font-black uppercase rounded-lg"><?php echo $product['category_name']; ?></span>
                             <span class="px-3 py-1 bg-neon-green text-black text-[10px] font-black uppercase rounded-lg border-[2px] border-black">In Stock</span>
                        </div>
                        <h1 class="text-5xl lg:text-6xl font-black tracking-tighter mb-6 uppercase leading-none"><?php echo $product['name']; ?></h1>
                        
                        <div class="flex items-center gap-6 mb-8">
                            <div class="flex flex-col">
                                <span id="display-price" class="text-4xl font-black text-black"><?php echo format_price($product['discounted_price'] ?? $product['base_price']); ?></span>
                                <?php if($product['discounted_price']): ?>
                                <span class="text-sm text-slate-400 line-through font-bold"><?php echo format_price($product['base_price']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <p class="text-lg font-bold leading-tight mb-10 text-slate-600">
                            <?php echo $product['description']; ?>
                        </p>
                    </div>

                    <!-- Customizer Tools -->
                    <div class="space-y-12">
                        
                        <!-- Color Selector -->
                        <div>
                            <h4 class="font-black mb-6 text-xl uppercase tracking-tighter flex items-center justify-between">
                                Pick A Flavor
                                <span id="selected-color-name" class="text-primary text-sm font-black">Midnight Black</span>
                            </h4>
                            <div class="flex flex-wrap gap-5">
                                <?php foreach($colors as $color): ?>
                                <button class="color-dot w-10 h-10 border-[3px] border-black chunky-btn rounded-full" style="background-color: <?php echo $color['variant_value']; ?>" data-color="<?php echo $color['variant_value']; ?>"></button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Size Selector -->
                        <div>
                            <h4 class="font-black mb-6 text-xl uppercase tracking-tighter flex items-center justify-between">
                                Select Size
                                <a href="#" class="text-accent text-xs font-black uppercase tracking-widest border-b-[2px] border-accent">Size Guide</a>
                            </h4>
                            <div class="grid grid-cols-5 gap-4 size-selector">
                                <?php foreach($sizes as $size): ?>
                                <input type="radio" name="size" id="size-<?php echo $size['variant_value']; ?>" class="hidden" value="<?php echo $size['variant_value']; ?>">
                                <label for="size-<?php echo $size['variant_value']; ?>" class="h-14 border-[3px] border-black rounded-2xl flex items-center justify-center font-black text-lg cursor-pointer hover:bg-neon-yellow transition-all shadow-[4px_4px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                                    <?php echo $size['variant_value']; ?>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Print Customizer -->
                        <div class="bg-background border-[3px] border-black p-8 rounded-[40px] shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)]">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center border-[2px] border-black">
                                    <i data-lucide="palette" class="w-6 h-6 fill-current"></i>
                                </div>
                                <h4 class="font-black text-xl uppercase tracking-tighter">Your Design</h4>
                            </div>
                            
                            <div class="space-y-10">
                                <!-- Print Location -->
                                <div>
                                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Position</p>
                                    <div class="flex gap-3">
                                        <button class="flex-1 py-4 rounded-2xl border-[3px] border-black bg-primary text-white font-black text-xs uppercase tracking-widest shadow-[4px_4px_0px_0px_#000]">Front</button>
                                        <button class="flex-1 py-4 rounded-2xl border-[3px] border-black bg-white text-black font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Back</button>
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="relative">
                                    <input type="file" id="print-upload" class="hidden" accept="image/*">
                                    <label for="print-upload" class="w-full flex flex-col items-center justify-center py-10 border-[3px] border-dashed border-black rounded-3xl cursor-pointer hover:bg-neon-yellow/10 transition-all group">
                                        <i data-lucide="upload-cloud" class="w-12 h-12 text-black mb-4 group-hover:scale-110 transition-transform"></i>
                                        <span class="text-lg font-black uppercase tracking-tighter">Upload Art</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">High Res PNG Recommended</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="flex items-end gap-8">
                            <div class="w-40">
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Quantity</p>
                                <div class="flex items-center bg-white border-[3px] border-black rounded-2xl h-16 p-2 shadow-[4px_4px_0px_0px_#000]">
                                    <button id="qty-minus" class="w-12 h-full flex items-center justify-center hover:bg-slate-100 rounded-xl transition-colors">
                                        <i data-lucide="minus" class="w-5 h-5"></i>
                                    </button>
                                    <input type="number" id="qty-input" value="1" min="1" class="w-full bg-transparent text-center font-black text-xl focus:outline-none">
                                    <button id="qty-plus" class="w-12 h-full flex items-center justify-center hover:bg-slate-100 rounded-xl transition-colors">
                                        <i data-lucide="plus" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-grow pt-8">
                                <div id="bulk-info" class="text-xs font-black text-emerald-600 bg-emerald-50 border-[2px] border-emerald-200 px-4 py-3 rounded-2xl hidden animate-bounce">
                                    🔥 BULK DRIP SAVINGS APPLIED!
                                </div>
                            </div>
                        </div>

                        <!-- Main CTA -->
                        <div class="pt-6">
                            <button id="add-to-cart" class="chunky-btn w-full h-20 bg-black text-white rounded-3xl font-black text-2xl flex items-center justify-center gap-4 hover:bg-primary transition-all">
                                <span>Add To Bag</span>
                                <i data-lucide="shopping-bag" class="w-8 h-8"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Configurator Logic
    const basePrice = <?php echo ($product['discounted_price'] ?? $product['base_price']); ?>;
    const printPrice = 150; // Flat extra for customization
    const bulkRules = <?php echo json_encode($bulk_pricing); ?>;
    
    const qtyInput = document.getElementById('qty-input');
    const displayPrice = document.getElementById('display-price');
    const bulkhead = document.getElementById('bulk-info');
    const printUpload = document.getElementById('print-upload');
    const uploadedPreview = document.getElementById('uploaded-preview');
    const movablePrint = document.getElementById('movable-print');
    
    function calculatePrice() {
        let qty = parseInt(qtyInput.value);
        let currentPrice = basePrice;
        let discount = 0;

        // Check bulk rules
        bulkRules.forEach(rule => {
            if (qty >= rule.min_qty && (rule.max_qty === null || qty <= rule.max_qty)) {
                discount = rule.discount_percentage;
            }
        });

        if (discount > 0) {
            currentPrice = currentPrice * (1 - (discount / 100));
            bulkhead.classList.remove('hidden');
        } else {
            bulkhead.classList.add('hidden');
        }

        // Add customization cost
        if (!movablePrint.classList.contains('hidden')) {
            currentPrice += printPrice;
        }

        displayPrice.innerText = '₹' + (currentPrice * qty).toLocaleString('en-IN', {minimumFractionDigits: 2});
    }

    document.getElementById('qty-plus').addEventListener('click', () => { qtyInput.value++; calculatePrice(); });
    document.getElementById('qty-minus').addEventListener('click', () => { if(qtyInput.value > 1) { qtyInput.value--; calculatePrice(); } });
    qtyInput.addEventListener('change', calculatePrice);

    // Image Upload Preview & Interaction
    printUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                uploadedPreview.src = event.target.result;
                movablePrint.classList.remove('hidden');
                calculatePrice();
                
                // Show notification (simple placeholder)
                console.log("Image uploaded successfully!");
            };
            reader.readAsDataURL(file);
        }
    });

    // Simple Drag & Resize (Logic outline)
    let isDragging = false;
    let currentX;
    let currentY;
    let initialX;
    let initialY;
    let xOffset = 0;
    let yOffset = 0;

    movablePrint.addEventListener('mousedown', dragStart);
    document.addEventListener('mousemove', drag);
    document.addEventListener('mouseup', dragEnd);

    function dragStart(e) {
        initialX = e.clientX - xOffset;
        initialY = e.clientY - yOffset;
        if (e.target === movablePrint || e.target === uploadedPreview) {
            isDragging = true;
        }
    }

    function drag(e) {
        if (isDragging) {
            e.preventDefault();
            currentX = e.clientX - initialX;
            currentY = e.clientY - initialY;
            xOffset = currentX;
            yOffset = currentY;
            setTranslate(currentX, currentY, movablePrint);
        }
    }

    function setTranslate(xPos, yPos, el) {
        el.style.transform = "translate3d(" + xPos + "px, " + yPos + "px, 0)";
    }

    function dragEnd(e) {
        initialX = currentX;
        initialY = currentY;
        isDragging = false;
    }

    // Color Selector highlight
    document.querySelectorAll('.color-dot').forEach(dot => {
        dot.addEventListener('click', function() {
            document.querySelectorAll('.color-dot').forEach(d => d.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selected-color-name').innerText = this.getAttribute('data-color');
            
            // In a real app, we would change the mockup image source here
            // document.getElementById('base-mockup').src = 'mockups/tshirt-' + this.getAttribute('data-color') + '.png';
        });
    });

    // AJAX Add to Cart
    document.getElementById('add-to-cart').addEventListener('click', async () => {
        const btn = document.getElementById('add-to-cart');
        const originalContent = btn.innerHTML;
        
        btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Processing...';
        lucide.createIcons();

        // Simulate API call
        setTimeout(() => {
            btn.classList.replace('bg-black', 'bg-emerald-500');
            btn.innerHTML = '<i data-lucide="check" class="w-5 h-5"></i> Added!';
            lucide.createIcons();
            
            // Update cart count
            const cartCount = document.getElementById('cart-count');
            cartCount.innerText = parseInt(cartCount.innerText) + parseInt(qtyInput.value);
            
            setTimeout(() => {
                btn.classList.replace('bg-emerald-500', 'bg-black');
                btn.innerHTML = originalContent;
                lucide.createIcons();
            }, 2000);
        }, 800);
    });

</script>

<?php require_once 'includes/footer.php'; ?>
