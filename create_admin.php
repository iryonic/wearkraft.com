<?php
require_once 'includes/db.php';

$email = 'admin@wearkraft.com';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
$role = 'admin';
$name = 'System Admin';

// Check if admin exists
$existing = db_fetch_one("SELECT * FROM users WHERE email = ?", [$email]);

if ($existing) {
    // Update password
    db_query("UPDATE users SET password = ?, role = ? WHERE email = ?", [$hash, $role, $email]);
    echo "Admin user updated.<br>";
} else {
    // Create new
    db_query("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)", [$name, $email, $hash, $role]);
    echo "Admin user created.<br>";
}

echo "Email: $email<br>";
echo "Password: $password<br>";
?>
