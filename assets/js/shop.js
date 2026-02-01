/**
 * WearKraft.com - Shop and Filtering functionality
 */

document.addEventListener('DOMContentLoaded', () => {
    const filterForm = document.getElementById('filter-form');
    const sortSelect = document.getElementById('sort-by');

    if (filterForm) {
        const inputs = filterForm.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', () => filterForm.submit());
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', () => {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sortSelect.value);
            window.location.href = url.toString();
        });
    }

    // Product Card Hover Interactions (Extra polish)
    const productCards = document.querySelectorAll('.chunky-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            // Additional interactions if needed
        });
    });
});
