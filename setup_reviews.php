<?php
require_once 'includes/db.php';

// Create product_reviews table
$sql = "CREATE TABLE IF NOT EXISTS product_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (mysqli_query($conn, $sql)) {
    echo "Table product_reviews created successfully.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Insert some dummy reviews if empty
$check = db_fetch_one("SELECT COUNT(*) as count FROM product_reviews");
if ($check['count'] == 0) {
    // Get a product and user to link to
    $product = db_fetch_one("SELECT id FROM products LIMIT 1");
    $user = db_fetch_one("SELECT id FROM users LIMIT 1");
    
    if ($product && $user) {
        $pid = $product['id'];
        $uid = $user['id'];
        $reviews = [
            [$pid, $uid, 5, "Absolutely love the quality! The fabric feels premium and the print is super sharp."],
            [$pid, $uid, 4, "Great fit, slightly oversized just how I like it. Fast shipping too."],
            [$pid, $uid, 5, "Best purchase I've made in a while. 10/10 would recommend."]
        ];
        
        foreach ($reviews as $r) {
            db_query("INSERT INTO product_reviews (product_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)", $r);
        }
        echo "Inserted dummy reviews.<br>";
    }
}
?>
