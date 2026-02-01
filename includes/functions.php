<?php
require_once __DIR__ . '/db.php';

function get_setting($key) {
    $result = db_fetch_one("SELECT setting_value FROM settings WHERE setting_key = ?", [$key]);
    return $result ? $result['setting_value'] : null;
}

function format_price($amount) {
    return '₹' . number_format($amount, 2);
}

function redirect($url) {
    if (!headers_sent()) {
        header("Location: $url");
    } else {
        echo '<script type="text/javascript">window.location.href="' . $url . '";</script>';
        echo '<noscript><meta http-equiv="refresh" content="0;url=' . $url . '" /></noscript>';
    }
    exit();
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function generate_order_number() {
    return 'WK-' . strtoupper(substr(uniqid(), -8));
}

function get_cart_count() {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $result = db_fetch_one("SELECT SUM(quantity) as count FROM cart WHERE user_id = ?", [$user_id]);
    } else {
        $session_id = session_id();
        $result = db_fetch_one("SELECT SUM(quantity) as count FROM cart WHERE session_id = ?", [$session_id]);
    }
    return $result['count'] ?? 0;
}

function merge_cart($user_id) {
    $session_id = session_id();
    
    // Get guest items
    $guest_items = db_fetch_all("SELECT * FROM cart WHERE session_id = ? AND user_id IS NULL", [$session_id]);
    
    foreach ($guest_items as $item) {
        // Check if item already exists in user cart
        $existing = db_fetch_one("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?", [$user_id, $item['product_id']]);
        
        if ($existing) {
            $new_qty = $existing['quantity'] + $item['quantity'];
            db_query("UPDATE cart SET quantity = ? WHERE id = ?", [$new_qty, $existing['id']]);
            db_query("DELETE FROM cart WHERE id = ?", [$item['id']]);
        } else {
            db_query("UPDATE cart SET user_id = ?, session_id = NULL WHERE id = ?", [$user_id, $item['id']]);
        }
    }
}

// SEO Helpers
function get_meta_title($page_title = "") {
    $site_name = get_setting('site_name');
    return $page_title ? "$page_title | $site_name" : $site_name;
}

function get_latest_products($limit = 8) {
    return db_fetch_all("
        SELECT p.*, pi.image_path as main_image 
        FROM products p 
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE p.status = 'active' 
        ORDER BY p.created_at DESC 
        LIMIT ?
    ", [$limit]);
}

function get_active_categories() {
    return db_fetch_all("SELECT * FROM categories WHERE status = 'active' ORDER BY name ASC");
}

function get_active_reels($limit = 10) {
    return db_fetch_all("SELECT * FROM reels WHERE status = 'active' ORDER BY created_at DESC LIMIT ?", [$limit]);
}

function get_active_testimonials($limit = 6) {
    return db_fetch_all("SELECT * FROM testimonials WHERE status = 'active' ORDER BY created_at DESC LIMIT ?", [$limit]);
}

function get_product_reviews($product_id) {
    return db_fetch_all("
        SELECT r.*, u.full_name, u.email 
        FROM product_reviews r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.product_id = ? 
        ORDER BY r.created_at DESC
    ", [$product_id]);
}

function get_average_rating($product_id) {
    $result = db_fetch_one("SELECT AVG(rating) as avg_rating, COUNT(*) as count FROM product_reviews WHERE product_id = ?", [$product_id]);
    return [
        'average' => round($result['avg_rating'] ?? 0, 1),
        'count' => $result['count']
    ];
}

function get_similar_products($category_id, $exclude_id, $limit = 4) {
    return db_fetch_all("
        SELECT p.*, pi.image_path as main_image 
        FROM products p 
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE p.category_id = ? AND p.id != ? AND p.status = 'active'
        ORDER BY rand() 
        LIMIT ?
    ", [$category_id, $exclude_id, $limit]);
}
?>
