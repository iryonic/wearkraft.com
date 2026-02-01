/**
 * WearKraft.com - Cart and Checkout functionality
 */

window.Cart = {
    updateTimeout: null,

    addToCart: function (productId, quantity = 1, options = {}) {
        console.log('Adding to cart:', productId, quantity);
        // Show loading via header icon or button state if accessible
        const btn = document.querySelector(`.add-to-cart-btn[data-product-id="${productId}"]`);
        const originalText = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>';
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

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
                    if (window.toggleCart) {
                        window.toggleCart(true);
                    }
                    this.refreshSideCart();

                    if (window.showToast) window.showToast('Added to bag! 🎒');
                } else {
                    if (window.showToast) window.showToast(data.message || 'Error', 'error');
                }
            })
            .catch(error => {
                console.error('Cart Error:', error);
                if (window.showToast) window.showToast('Server error', 'error');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            });
    },

    updateCount: function (count) {
        const countBadges = document.querySelectorAll('.cart-count-badge');
        countBadges.forEach(b => {
            b.innerText = count;
            // Animate badge
            b.classList.remove('animate-bounce');
            void b.offsetWidth; // trigger reflow
            b.classList.add('animate-bounce');
        });
    },

    refreshSideCart: function () {
        const container = document.getElementById('side-cart-items');
        const subtotalEl = document.getElementById('side-cart-subtotal');
        if (!container) return;

        // Add subtle loading opacity
        container.classList.add('opacity-50', 'pointer-events-none');

        // Added timestamp to prevent caching
        const timestamp = new Date().getTime();
        fetch(`${window.SITE_URL}/ajax/cart_handler.php?action=get_cart&t=${timestamp}`)
            .then(res => res.json())
            .then(data => {
                console.log('Cart data received:', data);
                if (data.success) {
                    if (subtotalEl) subtotalEl.innerText = data.formatted_subtotal;
                    this.renderSideCart(data.items, container);
                }
            })
            .catch(err => {
                console.error('Refresh Cart Error:', err);
            })
            .finally(() => {
                container.classList.remove('opacity-50', 'pointer-events-none');
            });
    },

    renderSideCart: function (items, container) {
        if (!items || items.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full opacity-30 select-none">
                    <i data-lucide="shopping-bag" class="w-16 h-16 mb-4"></i>
                    <p class="font-black uppercase text-sm tracking-widest">Bag is empty</p>
                </div>`;
            if (typeof lucide !== 'undefined') lucide.createIcons();
            return;
        }

        container.innerHTML = items.map(item => `
            <div class="flex gap-4 mb-6 pb-6 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0 relative group" id="cart-item-${item.cart_id}">
                <div class="w-20 h-20 bg-gray-100 rounded-xl border-[2px] border-black overflow-hidden flex-shrink-0">
                    <img src="${window.SITE_URL}/assets/images/products/${item.main_image || 'placeholder.jpg'}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-black uppercase text-xs truncate mb-1"><a href="product.php?id=${item.id}" class="hover:text-primary transition-colors">${item.name}</a></h4>
                        <div class="flex items-center gap-2">
                             <span class="text-xs font-bold opacity-50">QTY:</span>
                             <div class="flex items-center gap-2">
                                <button onclick="window.Cart.updateQuantity(${item.cart_id}, ${item.quantity - 1})" class="w-6 h-6 border-[2px] border-black rounded flex items-center justify-center text-[10px] hover:bg-black hover:text-white transition-colors active:scale-90 disabled:opacity-50">-</button>
                                <span class="text-xs font-black min-w-[20px] text-center">${item.quantity}</span>
                                <button onclick="window.Cart.updateQuantity(${item.cart_id}, ${item.quantity + 1})" class="w-6 h-6 border-[2px] border-black rounded flex items-center justify-center text-[10px] hover:bg-black hover:text-white transition-colors active:scale-90 disabled:opacity-50">+</button>
                             </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-black text-sm italic">₹${parseFloat(item.effective_price || item.discounted_price || item.base_price).toLocaleString()}</span>
                        <button onclick="window.Cart.removeFromCart(${item.cart_id})" class="text-[10px] font-bold uppercase tracking-widest text-accent hover:underline flex items-center gap-1">
                            <i data-lucide="trash-2" class="w-3 h-3"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

        if (typeof lucide !== 'undefined') lucide.createIcons();
    },

    updateQuantity: function (itemId, newQty) {
        if (newQty < 1) {
            this.removeFromCart(itemId);
            return;
        }

        const itemRow = document.getElementById(`cart-item-${itemId}`);
        if (itemRow) itemRow.classList.add('opacity-50', 'pointer-events-none');

        clearTimeout(this.updateTimeout);
        this.updateTimeout = setTimeout(() => {
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
                        if (window.location.pathname.includes('cart.php') || window.location.pathname.includes('checkout.php')) {
                            window.location.reload();
                        }
                    }
                })
                .catch(() => {
                    if (itemRow) itemRow.classList.remove('opacity-50', 'pointer-events-none');
                });
        }, 300);
    },

    removeFromCart: function (itemId) {
        if (!confirm('Remove this item?')) return;

        const itemRow = document.getElementById(`cart-item-${itemId}`);
        if (itemRow) itemRow.classList.add('opacity-30', 'pointer-events-none');

        const formData = new FormData();
        formData.append('action', 'remove_item');
        formData.append('item_id', itemId);

        fetch(`${window.SITE_URL}/ajax/cart_handler.php`, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.updateCount(data.total_count);
                    this.refreshSideCart();
                    if (window.location.pathname.includes('cart.php') || window.location.pathname.includes('checkout.php')) {
                        window.location.reload();
                    }
                    if (window.showToast) window.showToast('Item removed');
                }
            })
            .catch(err => {
                if (itemRow) itemRow.classList.remove('opacity-30', 'pointer-events-none');
            });
    }
};

// Global listener for Add to Cart buttons
document.addEventListener('click', (e) => {
    const addToCartBtn = e.target.closest('.add-to-cart-btn');
    if (addToCartBtn) {
        e.preventDefault();
        const productId = addToCartBtn.dataset.productId;
        window.Cart.addToCart(productId);
    }
});
