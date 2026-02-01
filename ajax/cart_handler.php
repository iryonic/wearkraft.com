<?php
require_once '../includes/functions.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$session_id = session_id();

header('Content-Type: application/json');

if ($action === 'add_to_cart') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)($_POST['quantity'] ?? 1);
    $options = $_POST['options'] ?? null;

    // Check if item already exists
    $existing = db_fetch_one("SELECT id, quantity FROM cart WHERE product_id = ? AND " . ($user_id ? "user_id = ?" : "session_id = ?"), [$product_id, $user_id ?: $session_id]);

    if ($existing) {
        $new_qty = $existing['quantity'] + $quantity;
        db_query("UPDATE cart SET quantity = ? WHERE id = ?", [$new_qty, $existing['id']]);
    } else {
        db_query("INSERT INTO cart (user_id, session_id, product_id, quantity, custom_data) VALUES (?, ?, ?, ?, ?)", 
                [$user_id, $session_id, $product_id, $quantity, $options]);
    }

    echo json_encode([
        'success' => true, 
        'total_count' => get_cart_count(),
        'message' => 'Added to bag'
    ]);
    exit;
}

if ($action === 'get_cart') {
    $sql = "SELECT c.id as cart_id, c.quantity, p.*, 
            (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as main_image 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE " . ($user_id ? "c.user_id = ?" : "c.session_id = ?");
    
    $items = db_fetch_all($sql, [$user_id ?: $session_id]);
    $subtotal = 0;
    
    foreach($items as &$item) {
        // Default price
        $price = $item['discounted_price'] ?: $item['base_price'];
        
        // Check for bulk pricing
        $bulk_rules = db_fetch_all("SELECT * FROM bulk_pricing WHERE product_id = ? ORDER BY min_qty DESC", [$item['id']]);
        
        foreach($bulk_rules as $rule) {
            if ($item['quantity'] >= $rule['min_qty'] && ($rule['max_qty'] === null || $item['quantity'] <= $rule['max_qty'])) {
                if ($rule['fixed_price']) {
                    $price = $rule['fixed_price'];
                } elseif ($rule['discount_percentage']) {
                    $original_price = $item['discounted_price'] ?: $item['base_price'];
                    $price = $original_price * (1 - ($rule['discount_percentage'] / 100));
                }
                break; // Apply best match (highest min_qty first due to DESC order)
            }
        }
        
        $item['effective_price'] = $price;
        $subtotal += $price * $item['quantity'];
    }

    echo json_encode([
        'success' => true,
        'items' => $items,
        'subtotal' => $subtotal,
        'formatted_subtotal' => format_price($subtotal)
    ]);
    exit;
}

if ($action === 'remove_item') {
    $cart_id = (int)$_POST['item_id'];
    db_query("DELETE FROM cart WHERE id = ?", [$cart_id]);
    echo json_encode(['success' => true, 'total_count' => get_cart_count()]);
    exit;
}

if ($action === 'update_quantity') {
    $cart_id = (int)$_POST['item_id'];
    $quantity = (int)$_POST['quantity'];
    if ($quantity > 0) {
        db_query("UPDATE cart SET quantity = ? WHERE id = ?", [$quantity, $cart_id]);
    } else {
        db_query("DELETE FROM cart WHERE id = ?", [$cart_id]);
    }
    echo json_encode(['success' => true, 'total_count' => get_cart_count()]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
?>
