<?php
require_once 'includes/db.php';

// Clear existing
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
mysqli_query($conn, "TRUNCATE TABLE categories");
mysqli_query($conn, "TRUNCATE TABLE products");
mysqli_query($conn, "TRUNCATE TABLE product_variants");
mysqli_query($conn, "TRUNCATE TABLE product_images");
mysqli_query($conn, "TRUNCATE TABLE bulk_pricing");
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

// Categories
db_query("INSERT INTO categories (name, slug) VALUES ('T-Shirts', 't-shirts'), ('Hoodies', 'hoodies'), ('Sweatshirts', 'sweatshirts'), ('Uppers', 'uppers')");

$tshirt_id = db_fetch_one("SELECT id FROM categories WHERE slug='t-shirts'")['id'];
$hoodie_id = db_fetch_one("SELECT id FROM categories WHERE slug='hoodies'")['id'];

// Products
db_query("INSERT INTO products (category_id, name, slug, description, base_price, discounted_price, featured) VALUES 
(?, 'Classic Heavyweight Tee', 'classic-heavyweight-tee', 'Premium 240 GSM organic cotton t-shirt with a relaxed fit.', 999.00, 799.00, 1),
(?, 'Essential Oversized Hoodie', 'essential-oversized-hoodie', 'Ultra-soft fleece hoodie designed for maximum comfort and style.', 2499.00, 1999.00, 1)", 
[$tshirt_id, $hoodie_id]);

$p1_id = db_fetch_one("SELECT id FROM products WHERE slug='classic-heavyweight-tee'")['id'];
$p2_id = db_fetch_one("SELECT id FROM products WHERE slug='essential-oversized-hoodie'")['id'];

// Variants - Sizes
foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size) {
    db_query("INSERT INTO product_variants (product_id, variant_type, variant_value) VALUES (?, 'size', ?)", [$p1_id, $size]);
    db_query("INSERT INTO product_variants (product_id, variant_type, variant_value) VALUES (?, 'size', ?)", [$p2_id, $size]);
}

// Variants - Colors
foreach(['#000000', '#FFFFFF', '#FF0000', '#0000FF'] as $color) {
    db_query("INSERT INTO product_variants (product_id, variant_type, variant_value) VALUES (?, 'color', ?)", [$p1_id, $color]);
    db_query("INSERT INTO product_variants (product_id, variant_type, variant_value) VALUES (?, 'color', ?)", [$p2_id, $color]);
}

// Bulk Pricing
db_query("INSERT INTO bulk_pricing (product_id, min_qty, max_qty, discount_percentage) VALUES 
(?, 1, 9, 0), (?, 10, 49, 15), (?, 50, 99, 25), (?, 100, NULL, 40)", 
[$p1_id, $p1_id, $p1_id, $p1_id]);

echo "Seed data inserted successfully!";
?>
