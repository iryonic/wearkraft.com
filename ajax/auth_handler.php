<?php
// includes/ajax_auth.php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$action = $_POST['action'] ?? '';

if ($action === 'check_email') {
    $email = sanitize($_POST['email']);
    $user = db_fetch_one("SELECT id FROM users WHERE email = ?", [$email]);
    echo json_encode(['exists' => (bool)$user]);
}
?>
