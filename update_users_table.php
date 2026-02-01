<?php
require_once 'includes/db.php';
// Add saved_address column if not exists
$check = db_fetch_one("SHOW COLUMNS FROM users LIKE 'saved_address'");
if (!$check) {
    db_query("ALTER TABLE users ADD COLUMN saved_address TEXT DEFAULT NULL, ADD COLUMN saved_city VARCHAR(100), ADD COLUMN saved_zip VARCHAR(20), ADD COLUMN saved_phone VARCHAR(20)");
    echo "Columns added successfully";
} else {
    echo "Columns already exist";
}
?>
