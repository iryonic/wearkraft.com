<?php
// WearKraft.com Configuration
require_once 'security.php';
secure_session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'wearkraft_db');

define('SITE_URL', 'http://localhost/wearkraft.com');
define('SITE_NAME', 'WearKraft.com');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Helper for absolute paths
define('BASE_PATH', dirname(__DIR__));
?>
