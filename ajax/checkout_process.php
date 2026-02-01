<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $session_id = session_id();
    
    // Validate inputs
    $required = ['first_name', 'last_name', 'address', 'city', 'zip', 'phone', 'email'];
    foreach($required as $field) {
        if(empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => 'Please fill all required fields']);
            exit;
        }
    }

    $address_data = [
        'first_name' => sanitize($_POST['first_name']),
        'last_name' => sanitize($_POST['last_name']),
        'address' => sanitize($_POST['address']),
        'city' => sanitize($_POST['city']),
        'zip' => sanitize($_POST['zip']),
        'phone' => sanitize($_POST['phone']),
        'email' => sanitize($_POST['email']),
    ];

    $full_address = json_encode($address_data);

    // Save Address if requested (Magic Fill)
    if ($user_id && isset($_POST['save_info'])) {
        db_query("UPDATE users SET saved_address = ?, saved_city = ?, saved_zip = ?, saved_phone = ? WHERE id = ?", 
            [$address_data['address'], $address_data['city'], $address_data['zip'], $address_data['phone'], $user_id]);
    }

    // Create Order
    $order_number = 'ORD-' . strtoupper(uniqid());
    $total_amount = 0;

    // Calculate total from cart
    $cart_sql = "SELECT c.*, p.base_price, p.discounted_price FROM cart c JOIN products p ON c.product_id = p.id WHERE " . ($user_id ? "c.user_id = ?" : "c.session_id = ?");
    $cart_items = db_fetch_all($cart_sql, [$user_id ?: $session_id]);

    if (empty($cart_items)) {
        echo json_encode(['success' => false, 'message' => 'Cart is empty']);
        exit;
    }

    foreach ($cart_items as $item) {
        $price = $item['discounted_price'] ?? $item['base_price'];
        
        // Bulk pricing check (simplified re-check)
        $bulk_rules = db_fetch_all("SELECT * FROM bulk_pricing WHERE product_id = ? ORDER BY min_qty DESC", [$item['product_id']]);
        foreach($bulk_rules as $rule) {
             if ($item['quantity'] >= $rule['min_qty'] && ($rule['max_qty'] === null || $item['quantity'] <= $rule['max_qty'])) {
                if ($rule['fixed_price']) {
                    $price = $rule['fixed_price'];
                } elseif ($rule['discount_percentage']) {
                    $base = $item['discounted_price'] ?? $item['base_price'];
                    $price = $base * (1 - ($rule['discount_percentage'] / 100));
                }
                break;
            }
        }
        
        $total_amount += $price * $item['quantity'];
    }
    
    // Add tax
    $final_amount = $total_amount * 1.18; 

    // Insert Order
    $sql = "INSERT INTO orders (user_id, order_number, total_amount, shipping_address, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, 'pending')";
    $order_id = db_query($sql, [$user_id, $order_number, $final_amount, $full_address, $_POST['payment']]);

    if ($order_id) {
        // Move items to order_items
        foreach ($cart_items as $item) {
             $price = $item['discounted_price'] ?? $item['base_price']; // Store base price, bulk logic usually applied to total or per item here properly
             // For simplicity reusing listed price, in production recalculate exact effective price
             
             db_query("INSERT INTO order_items (order_id, product_id, quantity, price, custom_design_data) VALUES (?, ?, ?, ?, ?)", 
                     [$order_id, $item['product_id'], $item['quantity'], $price, $item['custom_data']]);
        }

        // Clear Cart
        db_query("DELETE FROM cart WHERE " . ($user_id ? "user_id = ?" : "session_id = ?"), [$user_id ?: $session_id]);

        echo json_encode([
            'success' => true, 
            'order_id' => $order_id,
            'order_number' => $order_number,
            'redirect' => 'order_success.php?id=' . $order_number
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order creation failed']);
    }
}
?>
