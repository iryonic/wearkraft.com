<?php
require_once '../includes/functions.php';

if (!is_logged_in()) {
    echo json_encode(['success' => false, 'message' => 'Please login to review']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $rating = (int)$_POST['rating'];
    $review_text = trim($_POST['review_text']);
    $user_id = $_SESSION['user_id'];

    if ($rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Invalid rating']);
        exit;
    }

    if (empty($review_text)) {
        echo json_encode(['success' => false, 'message' => 'Please write a review']);
        exit;
    }

    // Check if already reviewed
    $exists = db_fetch_one("SELECT id FROM product_reviews WHERE product_id = ? AND user_id = ?", [$product_id, $user_id]);
    if ($exists) {
        echo json_encode(['success' => false, 'message' => 'You have already reviewed this product']);
        exit;
    }

    $sql = "INSERT INTO product_reviews (product_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
    if (db_query($sql, [$product_id, $user_id, $rating, $review_text])) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error submitting review']);
    }
}
?>
