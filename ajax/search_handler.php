<?php
require_once '../includes/functions.php';

$query = $_GET['q'] ?? '';
$results = [];

if (strlen($query) >= 2) {
    $results = db_fetch_all("
        SELECT p.*, pi.image_path as main_image 
        FROM products p 
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE (p.name LIKE ? OR p.description LIKE ?) AND p.status = 'active'
        LIMIT 8
    ", ["%$query%", "%$query%"]);
}

header('Content-Type: application/json');
echo json_encode($results);
?>
