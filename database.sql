-- WearKraft.com Database Schema

CREATE DATABASE IF NOT EXISTS wearkraft_db;
USE wearkraft_db;

-- 1. Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('user', 'admin', 'affiliate') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Categories Table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    image VARCHAR(255),
    description TEXT,
    parent_id INT DEFAULT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- 3. Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    base_price DECIMAL(10, 2) NOT NULL,
    discounted_price DECIMAL(10, 2),
    sku VARCHAR(50) UNIQUE,
    stock_quantity INT DEFAULT 0,
    is_customizable BOOLEAN DEFAULT TRUE,
    featured BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- 4. Product Variants (Color, Size, Fabric)
CREATE TABLE product_variants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    variant_type ENUM('size', 'color', 'fabric') NOT NULL,
    variant_value VARCHAR(100) NOT NULL,
    price_modifier DECIMAL(10, 2) DEFAULT 0.00,
    stock_count INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 5. Product Images
CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    image_path VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 6. Bulk Pricing Slabs
CREATE TABLE bulk_pricing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    min_qty INT NOT NULL,
    max_qty INT,
    discount_percentage DECIMAL(5, 2),
    fixed_price DECIMAL(10, 2),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 7. Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_number VARCHAR(20) UNIQUE NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    shipping_address TEXT NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    order_status ENUM('placed', 'processing', 'printing', 'shipped', 'delivered', 'cancelled') DEFAULT 'placed',
    payment_method VARCHAR(50),
    razorpay_order_id VARCHAR(100),
    razorpay_payment_id VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 8. Order Items (Including customization data)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    custom_image VARCHAR(255), -- Path to uploaded custom print
    custom_design_data JSON, -- Stores position, scale, rotation
    print_location VARCHAR(50), -- Front, Back, Sleeve
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 9. Cart Table (Server-side persistence)
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL, -- NULL for guests (linked via session_id)
    session_id VARCHAR(100),
    product_id INT,
    quantity INT DEFAULT 1,
    custom_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 10. Coupons Table
CREATE TABLE coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_type ENUM('percentage', 'fixed') NOT NULL,
    discount_value DECIMAL(10, 2) NOT NULL,
    min_order_amount DECIMAL(10, 2) DEFAULT 0,
    expiry_date DATE,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- 11. Affiliates Table
CREATE TABLE affiliates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    affiliate_code VARCHAR(50) UNIQUE NOT NULL,
    commission_rate DECIMAL(5, 2) DEFAULT 10.00,
    total_earned DECIMAL(10, 2) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 12. Site Settings
CREATE TABLE settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT
);

INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'WearKraft.com'),
('contact_email', 'support@wearkraft.com'),
('currency', 'INR'),
('maintenance_mode', 'off'),
('announcement_text', 'Free shipping on orders above ₹999! Special Bulk pricing available.');
