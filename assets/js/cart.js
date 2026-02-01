/**
 * WearKraft.com - Cart and Checkout functionality
 */

const Cart = {
    addToCart: function (productId, quantity = 1, options = {}) {
        const formData = new FormData();
        formData.append('action', 'add_to_cart');
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        if (options) formData.append('options', JSON.stringify(options));

        fetch(`${window.SITE_URL}/ajax/cart_handler.php`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.updateCount(data.total_count);

                    // Open sidebar cart automatically
                    const sideCart = document.getElementById('side-cart');
                    const overlay = document.getElementById('cart-overlay');
                    if (sideCart && overlay) {
                        sideCart.classList.add('open');
                        overlay.classList.add('open');
                        document.body.classList.add('no-scroll');
                    }
                    this.refreshSideCart();

                    if (window.showToast) window.showToast('Added to bag! 🎒');
                } else {
                    if (window.showToast) window.showToast(data.message || 'Error', 'error');
                }
            })
            .catch(error => console.error('Cart Error:', error));
    },

    updateCount: function (count) {
        const countBadges = document.querySelectorAll('#cart-count');
        countBadges.forEach(b => b.innerText = count);
    },

    refreshSideCart: function () {
        const container = document.getElementById('side-cart-items');
        const subtotalEl = document.getElementById('side-cart-subtotal');
        if (!container) return;

        fetch(`${window.SITE_URL}/ajax/cart_handler.php?action=get_cart`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (subtotalEl) subtotalEl.innerText = data.formatted_subtotal;
                    this.renderSideCart(data.items, container);
                }
            });
    },

    renderSideCart: function (items, container) {
        if (items.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full opacity-30">
                    <i data-lucide="shopping-bag" class="w-16 h-16 mb-4"></i>
                    <p class="font-black uppercase text-sm tracking-widest">Bag is empty</p>
                </div>`;
            if (typeof lucide !== 'undefined') lucide.createIcons();
            return;
        }

        container.innerHTML = items.map(item => `
            <div class="flex gap-4 mb-6 pb-6 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                <div class="w-20 h-20 bg-gray-100 rounded-xl border-[2px] border-black overflow-hidden flex-shrink-0">
                    <img src="${window.SITE_URL}/assets/images/products/${item.main_image || 'placeholder.jpg'}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-black uppercase text-xs truncate mb-1">${item.name}</h4>
                        <div class="flex items-center gap-2">
                             <span class="text-xs font-bold opacity-50">QTY:</span>
                             <div class="flex items-center gap-2">
                                <button onclick="Cart.updateQuantity(${item.cart_id}, ${item.quantity - 1})" class="w-5 h-5 border border-black rounded flex items-center justify-center text-[10px] hover:bg-black hover:text-white transition-colors">-</button>
                                <span class="text-xs font-black">${item.quantity}</span>
                                <button onclick="Cart.updateQuantity(${item.cart_id}, ${item.quantity + 1})" class="w-5 h-5 border border-black rounded flex items-center justify-center text-[10px] hover:bg-black hover:text-white transition-colors">+</button>
                             </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-black text-sm italic">₹${parseFloat(item.effective_price || item.discounted_price || item.base_price).toLocaleString()}</span>
                        <button onclick="Cart.removeFromCart(${item.cart_id})" class="text-[10px] font-bold uppercase tracking-widest text-accent hover:underline">Remove</button>
                    </div>
                </div>
            </div>
        `).join('');
    },

    updateQuantity: function (itemId, newQty) {
        const formData = new FormData();
        formData.append('action', 'update_quantity');
        formData.append('item_id', itemId);
        formData.append('quantity', newQty);

        fetch(`${window.SITE_URL}/ajax/cart_handler.php`, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.updateCount(data.total_count);
                    this.refreshSideCart();
                    if (window.location.pathname.includes('cart.php')) window.location.reload();
                }
            });
    },

    removeFromCart: function (itemId) {
        const formData = new FormData();
        formData.append('action', 'remove_item');
        formData.append('item_id', itemId);

        fetch(`${window.SITE_URL}/ajax/cart_handler.php`, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.updateCount(data.total_count);
                    this.refreshSideCart();
                    if (window.location.pathname.includes('cart.php')) window.location.reload();
                }
            });
    }
};

// Global listener for Add to Cart buttons
document.addEventListener('click', (e) => {
    const addToCartBtn = e.target.closest('.add-to-cart-btn');
    if (addToCartBtn) {
        e.preventDefault();
        const productId = addToCartBtn.dataset.productId;
        Cart.addToCart(productId);
    }
});
