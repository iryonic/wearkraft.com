/**
 * WearKraft.com - Global functionality
 */

document.addEventListener('DOMContentLoaded', () => {
    // Initialize Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Header scroll effect
    const header = document.getElementById('main-header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // Mobile Bottom Nav Active State logic (if needed beyond PHP)
    const mobileLinks = document.querySelectorAll('.mobile-nav a');
    const currentPath = window.location.pathname;

    mobileLinks.forEach(link => {
        if (link.getAttribute('href') !== '#' && currentPath.includes(link.getAttribute('href'))) {
            // Priority is given to active state via JS if PHP logic is delayed
            // though we mostly handle this in footer.php
        }
    });

    // Sidebar Cart Toggles
    const cartBtn = document.getElementById('open-cart');
    const cartBtnMobile = document.getElementById('open-cart-mobile');
    const sideCart = document.getElementById('side-cart');
    const cartOverlay = document.getElementById('cart-overlay');
    const closeCartBtn = document.getElementById('close-cart');

    window.toggleCart = function (open = true) {
        if (!sideCart || !cartOverlay) return;
        if (open) {
            sideCart.classList.remove('translate-x-full', 'pointer-events-none');
            // Ensure opacity implies visibility in Tailwind context if needed, but translate handles visibility mostly for drawer
            // For overlay:
            cartOverlay.classList.remove('opacity-0', 'pointer-events-none');
            // document.body.classList.add('overflow-hidden'); // Removed to prevent mobile header glitch
            if (window.Cart && typeof window.Cart.refreshSideCart === 'function') {
                window.Cart.refreshSideCart();
            }
        } else {
            sideCart.classList.add('translate-x-full');
            // Add pointer-events-none back when closing to prevent blocking
            cartOverlay.classList.add('opacity-0', 'pointer-events-none');
            // document.body.classList.remove('overflow-hidden');
        }
    };

    if (cartBtn) cartBtn.addEventListener('click', (e) => { e.preventDefault(); window.toggleCart(true); });
    if (cartBtnMobile) cartBtnMobile.addEventListener('click', (e) => { e.preventDefault(); window.toggleCart(true); });
    if (closeCartBtn) closeCartBtn.addEventListener('click', () => window.toggleCart(false));
    if (cartOverlay) cartOverlay.addEventListener('click', () => window.toggleCart(false));

    // Mobile Menu Toggles
    const openMenuBtn = document.getElementById('open-mobile-menu');
    const closeMenuBtn = document.getElementById('close-mobile-menu');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

    function toggleMobileMenu(open = true) {
        if (!mobileMenuDrawer || !mobileMenuOverlay) return;
        if (open) {
            mobileMenuDrawer.classList.remove('-translate-x-full');
            mobileMenuOverlay.classList.remove('opacity-0', 'pointer-events-none');
            // document.body.classList.add('overflow-hidden');
        } else {
            mobileMenuDrawer.classList.add('-translate-x-full');
            mobileMenuOverlay.classList.add('opacity-0', 'pointer-events-none');
            // document.body.classList.remove('overflow-hidden');
        }
    }

    if (openMenuBtn) openMenuBtn.addEventListener('click', () => toggleMobileMenu(true));
    if (closeMenuBtn) closeMenuBtn.addEventListener('click', () => toggleMobileMenu(false));
    if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', () => toggleMobileMenu(false));

    // Search Modal Toggles
    const openSearchBtn = document.getElementById('open-search');
    const searchModal = document.getElementById('search-modal');
    const closeSearchBtn = document.getElementById('close-search');
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    function toggleSearch(open = true) {
        if (!searchModal) return;
        if (open) {
            searchModal.classList.remove('opacity-0', 'pointer-events-none');
            // document.body.classList.add('overflow-hidden');
            setTimeout(() => searchInput && searchInput.focus(), 300);
        } else {
            searchModal.classList.add('opacity-0', 'pointer-events-none');
            // document.body.classList.remove('overflow-hidden');
        }
    }

    if (openSearchBtn) openSearchBtn.addEventListener('click', () => toggleSearch(true));
    if (closeSearchBtn) closeSearchBtn.addEventListener('click', () => toggleSearch(false));

    // Live Search Logic
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            const query = e.target.value;
            if (query.length < 2) {
                if (searchResults) searchResults.innerHTML = '';
                return;
            }

            searchTimeout = setTimeout(() => {
                const apiUrl = window.SITE_URL ? `${window.SITE_URL}/ajax/search_handler.php` : '/ajax/search_handler.php';
                fetch(`${apiUrl}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        renderSearchResults(data);
                    })
                    .catch(err => console.error('Search error:', err));
            }, 300);
        });
    }

    function renderSearchResults(products) {
        if (!searchResults) return;
        if (products.length === 0) {
            searchResults.innerHTML = '<div class="col-span-full py-20 text-center font-black uppercase tracking-widest opacity-30">No drops matched your hunt.</div>';
            return;
        }

        const baseUrl = window.SITE_URL || '';
        searchResults.innerHTML = products.map(p => `
            <a href="product.php?id=${p.id}" class="chunky-card group rounded-2xl overflow-hidden bg-white hover:-rotate-1 transition-transform">
                <div class="aspect-square bg-gray-100 border-b-[3px] border-black overflow-hidden">
                    <img src="${baseUrl}/assets/images/products/${p.main_image || 'placeholder.jpg'}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-4">
                    <h4 class="font-black uppercase text-xs truncate">${p.name}</h4>
                    <p class="font-black text-primary italic">₹${parseFloat(p.base_price).toLocaleString()}</p>
                </div>
            </a>
        `).join('');
    }

    // Toast Notification System
    window.showToast = (message, type = 'success') => {
        const toast = document.createElement('div');
        toast.className = `fixed top-24 left-1/2 -translate-x-1/2 z-[10000] px-8 py-4 border-[3px] border-black rounded-2xl font-black uppercase text-xs tracking-widest shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-300 translate-y-[-100px] opacity-0 pointer-events-none`;

        if (type === 'success') {
            toast.classList.add('bg-neon-green', 'text-black');
        } else if (type === 'error') {
            toast.classList.add('bg-accent', 'text-white');
        } else {
            toast.classList.add('bg-neon-yellow', 'text-black');
        }

        toast.innerHTML = `<div class="flex items-center gap-3">
            <span class="toast-icon"></span>
            <span>${message}</span>
        </div>`;

        document.body.appendChild(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.remove('translate-y-[-100px]', 'opacity-0');
        }, 10);

        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-y-[-100px]', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

}); // End DOMContentLoaded

// Password Toggle Functionality (Global)
window.togglePassword = function (inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;

    // Simple icon toggle/color change
    if (input.type === 'password') {
        input.type = 'text';
        btn.classList.add('text-black');
        btn.classList.remove('text-slate-400');
    } else {
        input.type = 'password';
        btn.classList.remove('text-black');
        btn.classList.add('text-slate-400');
    }
};

// Password Strength Checker (Global)
window.checkPasswordStrength = function (password) {
    const reqLength = document.getElementById('req-length');
    const reqNumber = document.getElementById('req-number');
    const reqUpper = document.getElementById('req-upper');
    const reqSpecial = document.getElementById('req-special');

    if (!reqLength) return; // Not on register page
    if (typeof lucide === 'undefined') return;

    const updateStatus = (element, valid) => {
        const icon = element.querySelector('svg') || element.querySelector('i');

        if (valid) {
            // Valid State
            element.classList.remove('border-slate-200', 'bg-slate-50', 'text-slate-400');
            element.classList.add('border-black', 'bg-neon-green', 'text-black', 'shadow-sm'); // Chunky valid style

            // Just basic icon manipulation if we can't fully re-render lucide easily
            // Note: In a real React/Vue app we'd swap the icon component. 
            // Here we can try to simplistic approach or rely on class change indicating state
            if (icon) icon.style.opacity = '1';
        } else {
            // Invalid State
            element.classList.add('border-slate-200', 'bg-slate-50', 'text-slate-400');
            element.classList.remove('border-black', 'bg-neon-green', 'text-black', 'shadow-sm');
            if (icon) icon.style.opacity = '0.5';
        }
    };

    updateStatus(reqLength, password.length >= 8);
    updateStatus(reqNumber, /\d/.test(password));
    updateStatus(reqUpper, /[A-Z]/.test(password));
    updateStatus(reqSpecial, /[!@#$%^&*(),.?":{}|<>]/.test(password));
};
