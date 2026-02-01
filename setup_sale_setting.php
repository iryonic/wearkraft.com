<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Check if sale_end_time exists
$exists = db_fetch_one("SELECT * FROM settings WHERE setting_key = 'sale_end_time'");

if (!$exists) {
    // Default to 24 hours from now
    $future_date = date('Y-m-d H:i:s', strtotime('+24 hours'));
    db_query("INSERT INTO settings (setting_key, setting_value) VALUES ('sale_end_time', ?)", [$future_date]);
    echo "Inserted sale_end_time setting: $future_date";
} else {
    echo "sale_end_time already exists: " . $exists['setting_value'];
}
?>
