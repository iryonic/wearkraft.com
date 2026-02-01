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
        <!-- Main Product Section -->
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 mb-24">
            
            <!-- Left: Configurator Preview (Sticky on Desktop) -->
            <div class="w-full lg:w-3/5">
                <div class="lg:sticky lg:top-24">
                    <!-- Preview Container -->
                    <!-- Preview Container -->
                    <div id="mockup-container" class="relative aspect-square lg:aspect-[4/3] xl:aspect-[16/10] chunky-card rounded-[40px] md:rounded-[60px] overflow-hidden flex items-center justify-center p-8 md:p-12 bg-white sticky top-0">
                        <img id="base-mockup" src="https://m.media-amazon.com/images/I/71u92K3cXML._AC_UX679_.jpg" class="w-full h-full object-contain mix-blend-multiply" alt="Product Mockup">
                        
                        <!-- Design Overlay Area -->
                        <div id="design-area" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div id="movable-print" class="w-40 h-40 md:w-48 md:h-48 border-[3px] border-dashed border-primary pointer-events-auto cursor-move hidden flex items-center justify-center overflow-hidden bg-white/40 backdrop-blur-sm touch-none">
                                <img id="uploaded-preview" src="" class="max-w-full max-h-full object-contain">
                                <!-- Resize Handle -->
                                <div id="resize-handle" class="absolute bottom-0 right-0 w-6 h-6 bg-black cursor-nwse-resize z-20 border-2 border-white"></div>
                            </div>
                        </div>

                        <!-- Badge -->
                        <div class="absolute top-4 left-4 md:top-8 md:left-8">
                            <span class="bg-neon-yellow border-[3px] border-black px-4 py-2 md:px-5 md:py-2 rounded-full text-[10px] md:text-xs font-black shadow-[3px_3px_0px_0px_#000] uppercase tracking-widest">Live Editor ⚡</span>
                        </div>
                    </div>

                    <!-- Mini Gallery -->
                    <div class="flex gap-4 mt-8 overflow-x-auto pb-4 no-scrollbar">
                         <?php foreach($images as $img): ?>
                        <button class="w-20 h-20 md:w-24 md:h-24 rounded-3xl border-[3px] border-black chunky-btn overflow-hidden flex-shrink-0 bg-white p-1 hover:border-primary transition-colors">
                            <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo $img['image_path']; ?>" class="w-full h-full object-cover rounded-2xl">
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Right: Logic & Controls -->
            <div class="w-full lg:w-2/5">
                <div class="chunky-card p-6 md:p-10 lg:p-12 rounded-[40px] md:rounded-[50px] bg-white">
                    <div class="mb-8 md:mb-10">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                             <span class="px-3 py-1 bg-primary text-white text-[10px] font-black uppercase rounded-lg shadow-[2px_2px_0px_0px_#000]"><?php echo $product['category_name']; ?></span>
                             <span class="px-3 py-1 bg-neon-green text-black text-[10px] font-black uppercase rounded-lg border-[2px] border-black shadow-[2px_2px_0px_0px_#000]">In Stock</span>
                             <!-- Rating Badge -->
                             <?php $rating_data = get_average_rating($product['id']); ?>
                             <div class="flex items-center gap-1 ml-auto">
                                <i data-lucide="star" class="w-4 h-4 fill-primary text-primary"></i>
                                <span class="font-black text-sm"><?php echo $rating_data['average']; ?></span>
                                <span class="text-xs text-slate-400 font-bold">(<?php echo $rating_data['count']; ?>)</span>
                             </div>
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tighter mb-4 uppercase leading-[0.9]"><?php echo $product['name']; ?></h1>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex flex-col">
                                <span id="display-price" class="text-3xl md:text-4xl font-black text-black"><?php echo format_price($product['discounted_price'] ?? $product['base_price']); ?></span>
                                <?php if($product['discounted_price']): ?>
                                <span class="text-sm text-slate-400 line-through font-bold"><?php echo format_price($product['base_price']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <p class="text-base md:text-lg font-bold leading-tight mb-8 text-slate-600">
                            <?php echo $product['description']; ?>
                        </p>
                    </div>

                    <!-- Customizer Tools -->
                    <div class="space-y-8 md:space-y-12">
                        
                        <!-- Color Selector -->
                        <div>
                            <h4 class="font-black mb-4 text-lg md:text-xl uppercase tracking-tighter flex items-center justify-between">
                                Pick A Flavor
                                <span id="selected-color-name" class="text-primary text-xs md:text-sm font-black">Unknown</span>
                            </h4>
                            <div class="flex flex-wrap gap-4">
                                <?php $i=0; foreach($colors as $color): ?>
                                <button class="color-dot w-10 h-10 border-[3px] border-black chunky-btn rounded-full <?php echo $i===0?'active ring-2 ring-offset-2 ring-black':''; ?>" style="background-color: <?php echo $color['variant_value']; ?>" data-color="<?php echo $color['variant_value']; ?>"></button>
                                <?php $i++; endforeach; ?>
                            </div>
                        </div>

                        <!-- Size Selector -->
                        <div>
                            <h4 class="font-black mb-4 text-lg md:text-xl uppercase tracking-tighter flex items-center justify-between">
                                Select Size
                                <a href="#" class="text-accent text-[10px] md:text-xs font-black uppercase tracking-widest border-b-[2px] border-accent">Size Guide</a>
                            </h4>
                            <div class="grid grid-cols-4 md:grid-cols-5 gap-3 size-selector">
                                <?php $j=0; foreach($sizes as $size): ?>
                                <input type="radio" name="size" id="size-<?php echo $size['variant_value']; ?>" class="hidden peer" value="<?php echo $size['variant_value']; ?>" <?php echo $j===0?'checked':''; ?>>
                                <label for="size-<?php echo $size['variant_value']; ?>" class="h-12 md:h-14 border-[3px] border-black rounded-xl md:rounded-2xl flex items-center justify-center font-black text-base md:text-lg cursor-pointer hover:bg-neon-yellow transition-all shadow-[3px_3px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none peer-checked:bg-neon-yellow peer-checked:translate-x-[2px] peer-checked:translate-y-[2px] peer-checked:shadow-none">
                                    <?php echo $size['variant_value']; ?>
                                </label>
                                <?php $j++; endforeach; ?>
                            </div>
                        </div>

                        <!-- Print Customizer -->
                        <div class="bg-slate-50 border-[3px] border-black p-6 md:p-8 rounded-[30px] md:rounded-[40px] shadow-[6px_6px_0px_0px_rgba(0,0,0,0.05)]">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center border-[2px] border-black flex-shrink-0">
                                    <i data-lucide="palette" class="w-5 h-5 fill-current"></i>
                                </div>
                                <h4 class="font-black text-lg md:text-xl uppercase tracking-tighter">Your Design</h4>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Print Location -->
                                <div>
                                    <p class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Position</p>
                                    <div class="flex gap-3">
                                        <button class="flex-1 py-3 md:py-4 rounded-xl md:rounded-2xl border-[3px] border-black bg-primary text-white font-black text-[10px] md:text-xs uppercase tracking-widest shadow-[3px_3px_0px_0px_#000]">Front</button>
                                        <button class="flex-1 py-3 md:py-4 rounded-xl md:rounded-2xl border-[3px] border-black bg-white text-black font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Back</button>
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="relative">
                                    <input type="file" id="print-upload" class="hidden" accept="image/*">
                                    <label for="print-upload" class="w-full flex flex-col items-center justify-center py-8 md:py-10 border-[3px] border-dashed border-black rounded-3xl cursor-pointer hover:bg-neon-yellow/10 transition-all group bg-white">
                                        <i data-lucide="upload-cloud" class="w-10 h-10 md:w-12 md:h-12 text-black mb-4 group-hover:scale-110 transition-transform"></i>
                                        <span class="text-base md:text-lg font-black uppercase tracking-tighter">Upload Art</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 text-center px-4">Support PNG, JPG</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="flex flex-col md:flex-row md:items-end gap-6 md:gap-8">
                            <div class="w-full md:w-40">
                                <p class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Quantity</p>
                                <div class="flex items-center bg-white border-[3px] border-black rounded-2xl h-14 md:h-16 p-2 shadow-[4px_4px_0px_0px_#000]">
                                    <button id="qty-minus" class="w-10 md:w-12 h-full flex items-center justify-center hover:bg-slate-100 rounded-xl transition-colors">
                                        <i data-lucide="minus" class="w-5 h-5"></i>
                                    </button>
                                    <input type="number" id="qty-input" value="1" min="1" class="w-full bg-transparent text-center font-black text-xl focus:outline-none">
                                    <button id="qty-plus" class="w-10 md:w-12 h-full flex items-center justify-center hover:bg-slate-100 rounded-xl transition-colors">
                                        <i data-lucide="plus" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-grow md:pb-2">
                                <div id="bulk-info" class="text-[10px] md:text-xs font-black text-emerald-600 bg-emerald-50 border-[2px] border-emerald-200 px-4 py-3 rounded-xl hidden animate-bounce">
                                    🔥 BULK PRICE APPLIED!
                                </div>
                            </div>
                        </div>

                        <!-- Main CTA -->
                        <div class="pt-2 sticky bottom-4 z-30 lg:relative lg:bottom-auto lg:z-auto">
                            <button id="add-to-cart" class="chunky-btn w-full h-16 md:h-20 bg-black text-white rounded-2xl md:rounded-3xl font-black text-lg md:text-2xl flex items-center justify-center gap-4 hover:bg-primary hover:text-white transition-all shadow-[6px_6px_0px_0px_#ccfd32] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                                <span>Add To Bag</span>
                                <i data-lucide="shopping-bag" class="w-6 h-6 md:w-8 md:h-8"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 Reviews Section -->
        <?php 
        $reviews = get_product_reviews($product['id']); 
        $rating_summary = get_average_rating($product['id']);
        ?>
        <div class="mb-24 scroll-mt-24" id="reviews">
            <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tighter mb-8 md:mb-12 flex items-center gap-4">
                Community Reviews
                <span class="text-sm bg-black text-white px-3 py-1 rounded-full align-middle"><?php echo $rating_summary['count']; ?></span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                <!-- Rating Summary Box -->
                <div class="col-span-1">
                    <div class="bg-black text-white p-8 md:p-10 rounded-[32px] md:rounded-[40px] text-center border-[3px] border-black shadow-[8px_8px_0px_0px_#ccfd32]">
                        <h3 class="text-6xl md:text-8xl font-black tracking-tighter mb-4 text-neon-yellow"><?php echo $rating_summary['average']; ?></h3>
                        <div class="flex justify-center gap-1 mb-6">
                             <?php for($k=1; $k<=5; $k++): ?>
                             <i data-lucide="star" class="w-6 h-6 <?php echo $k <= round($rating_summary['average']) ? 'fill-neon-yellow text-neon-yellow' : 'text-gray-700'; ?>"></i>
                             <?php endfor; ?>
                        </div>
                        <p class="text-white/60 font-bold uppercase tracking-widest text-sm">Based on <?php echo $rating_summary['count']; ?> reviews</p>
                        
                        <button onclick="document.getElementById('review-modal').classList.remove('hidden')" class="w-full mt-8 py-4 bg-white text-black font-black uppercase tracking-widest rounded-2xl hover:bg-neon-yellow transition-colors">Write a Review</button>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="md:col-span-2 space-y-6">
                    <?php if(empty($reviews)): ?>
                        <div class="p-12 border-[3px] border-dashed border-gray-300 rounded-[32px] text-center">
                            <p class="text-slate-400 font-bold text-lg">No reviews yet. Be the first to verify the drip! 💧</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($reviews as $review): ?>
                        <div class="bg-white p-6 md:p-8 rounded-[32px] border-[3px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center font-black border-[2px] border-black">
                                        <?php echo substr($review['full_name'], 0, 1); ?>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-sm uppercase"><?php echo $review['full_name']; ?></h4>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase"><?php echo date('M d, Y', strtotime($review['created_at'])); ?></p>
                                    </div>
                                </div>
                                <div class="flex gap-1">
                                    <?php for($star=1; $star<=5; $star++): ?>
                                    <i data-lucide="star" class="w-4 h-4 <?php echo $star <= $review['rating'] ? 'fill-primary text-primary' : 'text-slate-200'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="font-bold text-slate-700 leading-relaxed">"<?php echo $review['review_text']; ?>"</p>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Review Modal -->
        <div id="review-modal" class="fixed inset-0 z-50 hidden">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="this.parentElement.classList.add('hidden')"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg p-4">
                <div class="bg-white rounded-[32px] p-8 md:p-10 border-[3px] border-black shadow-[8px_8px_0px_0px_#ccfd32] relative">
                    <button onclick="document.getElementById('review-modal').classList.add('hidden')" class="absolute top-4 right-4 w-10 h-10 bg-black text-white rounded-full flex items-center justify-center hover:rotate-90 transition-transform">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                    
                    <h3 class="text-3xl font-black uppercase tracking-tighter mb-6">Drop Your Review</h3>
                    
                    <form id="review-form" onsubmit="submitReview(event)">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        
                        <div class="mb-6">
                            <label class="block font-black text-xs uppercase tracking-widest mb-2">Rating</label>
                            <div class="flex gap-2" id="star-input">
                                <?php for($i=1; $i<=5; $i++): ?>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="rating" value="<?php echo $i; ?>" class="hidden peer" required>
                                    <i data-lucide="star" class="w-8 h-8 text-slate-200 fill-slate-200 peer-checked:text-neon-yellow peer-checked:fill-neon-yellow peer-hover:text-neon-yellow transition-colors"></i>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block font-black text-xs uppercase tracking-widest mb-2">Your Thoughts</label>
                            <textarea name="review_text" rows="4" class="w-full bg-slate-50 border-[3px] border-black rounded-2xl p-4 font-bold focus:outline-none focus:border-primary" placeholder="Tell us about the drip..." required></textarea>
                        </div>

                        <button type="submit" class="w-full py-4 bg-black text-white font-black uppercase tracking-widest rounded-2xl hover:bg-primary transition-colors">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 🔥 Similar Products (Slider) -->
        <?php 
        $similar_products = get_similar_products($product['category_id'], $product['id']); 
        if(!empty($similar_products)):
        ?>
        <div class="mb-20">
            <div class="flex items-end justify-between mb-10">
                <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter">You May Also Like</h2>
                <div class="flex gap-2">
                    <button class="sim-prev w-12 h-12 border-[3px] border-black bg-white rounded-xl flex items-center justify-center hover:bg-neon-yellow transition-all"><i data-lucide="chevron-left"></i></button>
                    <button class="sim-next w-12 h-12 border-[3px] border-black bg-white rounded-xl flex items-center justify-center hover:bg-neon-yellow transition-all"><i data-lucide="chevron-right"></i></button>
                </div>
            </div>
            
            <div class="swiper similarSwiper overflow-visible">
                <div class="swiper-wrapper">
                    <?php foreach($similar_products as $sim): ?>
                    <div class="swiper-slide">
                        <div class="chunky-card group rounded-[32px] overflow-hidden bg-white border h-full flex flex-col">
                            <div class="relative aspect-square overflow-hidden bg-gray-50 border-b-2 border-black">
                                <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo $sim['main_image']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-black uppercase tracking-tight mb-2 truncate"><?php echo $sim['name']; ?></h3>
                                    <p class="text-xl font-black text-primary"><?php echo format_price($sim['base_price']); ?></p>
                                </div>
                                <a href="product.php?slug=<?php echo $sim['slug']; ?>" class="mt-4 w-full py-3 bg-black text-white rounded-xl font-black uppercase text-xs tracking-widest flex items-center justify-center gap-2 hover:bg-primary transition-all">
                                    View <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Similar Products Swiper
        new Swiper('.similarSwiper', {
            slidesPerView: 1.2,
            spaceBetween: 20,
            navigation: {
                nextEl: '.sim-next',
                prevEl: '.sim-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2.2, spaceBetween: 24 },
                1024: { slidesPerView: 4, spaceBetween: 30 }
            }
        });
    });
</script>
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

    // Real AJAX Add to Cart
    document.getElementById('add-to-cart').addEventListener('click', () => {
        const btn = document.getElementById('add-to-cart');
        const productId = <?php echo $product['id']; ?>;
        const quantity = parseInt(qtyInput.value);
        
        // Get Options
        const selectedColor = document.querySelector('.color-dot.active')?.dataset.color;
        const selectedSize = document.querySelector('input[name="size"]:checked')?.value;
        const customImage = uploadedPreview.getAttribute('src');
        
        const options = {
            color: selectedColor,
            size: selectedSize,
            custom_image: customImage && !customImage.includes('window.SITE_URL') ? customImage : null
        };

        if(!selectedSize) {
            alert('Please select a size!');
            return;
        }

        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Processing...';
        lucide.createIcons();

        // Use the centralized Cart object
        if (typeof window.Cart !== 'undefined') {
            window.Cart.addToCart(productId, quantity, options);
            
            // Revert button after short delay
            setTimeout(() => {
                btn.innerHTML = originalContent;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }, 1000);
        } else {
            console.error('Cart JS not loaded');
            btn.innerHTML = 'Error';
        }
    });

    // Review Logic
    function submitReview(e) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        
        btn.innerText = 'Posting...';
        btn.disabled = true;

        const formData = new FormData(form);
        
        fetch('ajax/review_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                btn.innerText = 'Success!';
                btn.classList.add('bg-green-500');
                if(window.showToast) window.showToast('Review posted! Refreshing...', 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                if(window.showToast) window.showToast(data.message, 'error');
                btn.innerText = originalText;
                btn.disabled = false;
                
                if(data.message.includes('login')) {
                     window.location.href = 'login.php';
                }
            }
        })
        .catch(err => {
            console.error(err);
            btn.innerText = originalText;
            btn.disabled = false;
        });
    }

    // Star Rating Hover Effect Logic
    const stars = document.querySelectorAll('#star-input label');
    stars.forEach((star, index) => {
        star.addEventListener('mouseover', () => {
             stars.forEach((s, i) => {
                 const icon = s.querySelector('i');
                 if (i <= index) {
                     icon.classList.add('text-neon-yellow', 'fill-neon-yellow');
                     icon.classList.remove('text-slate-200', 'fill-slate-200');
                 } else {
                     icon.classList.remove('text-neon-yellow', 'fill-neon-yellow');
                     icon.classList.add('text-slate-200', 'fill-slate-200');
                 }
             });
        });
        
        star.addEventListener('click', () => {
             // Let the radio selection handle the permanent state, just reset hover listeners if needed
             // Actually CSS peer-checked handles the click state mostly, but we can enforce it
        });
    });
    
    document.getElementById('star-input').addEventListener('mouseleave', () => {
         // Reset to trusted state (checked ratio)
         const checked = document.querySelector('input[name="rating"]:checked');
         if(checked) {
             const val = parseInt(checked.value) - 1;
             stars.forEach((s, i) => {
                 const icon = s.querySelector('i');
                 if (i <= val) {
                     icon.classList.add('text-neon-yellow', 'fill-neon-yellow');
                     icon.classList.remove('text-slate-200', 'fill-slate-200');
                 } else {
                     icon.classList.remove('text-neon-yellow', 'fill-neon-yellow');
                     icon.classList.add('text-slate-200', 'fill-slate-200');
                 }
             });
         } else {
             stars.forEach(s => {
                 const icon = s.querySelector('i');
                 icon.classList.remove('text-neon-yellow', 'fill-neon-yellow');
                 icon.classList.add('text-slate-200', 'fill-slate-200');
             });
         }
    });

</script>

<?php require_once 'includes/footer.php'; ?>
