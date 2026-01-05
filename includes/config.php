<?php
// Site Configuration
define('SITE_NAME', 'Orange');
define('SITE_URL', 'http://localhost/orange');
define('SITE_EMAIL', 'contact@orange.com');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'orange_food');
define('DB_USER', 'root');
define('DB_PASS', '');

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('America/New_York');
?>