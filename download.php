<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=login_required');
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Get resource name from URL
$resource_name = $_GET['file'] ?? '';
$allowed_files = [
    'Weekly Meal Planner.pdf' => 'assets/pdf/Weekly Meal Planner.pdf',
    'Recipe Card Template.pdf' => 'assets/pdf/Recipe Card Template.pdf',
    'Grocery Shopping List.pdf' => 'assets/pdf/Grocery Shopping List.pdf',
    'Seasonal Produce Guide.pdf' => 'assets/pdf/Seasonal Produce Guide.pdf',
    'Cooking Temperature Guide.pdf' => 'assets/pdf/Cooking Temperature Guide.pdf',
    'Measurement Conversion.pdf' => 'assets/pdf/Measurement Conversion.pdf'
];

// Validate file exists
if (!isset($allowed_files[$resource_name])) {
    header('HTTP/1.0 404 Not Found');
    exit('File not found');
}

$file_path = $allowed_files[$resource_name];
if (!file_exists($file_path)) {
    header('HTTP/1.0 404 Not Found');
    exit('File not found');
}

// Log the download
$stmt = $db->prepare("
    INSERT INTO resource_downloads 
    (user_id, resource_name, ip_address, user_agent)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    download_count = download_count + 1,
    last_downloaded = CURRENT_TIMESTAMP
");
$stmt->execute([
    $_SESSION['user_id'],
    $resource_name,
    $_SERVER['REMOTE_ADDR'] ?? '',
    $_SERVER['HTTP_USER_AGENT'] ?? ''
]);

// Force download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
header('Content-Length: ' . filesize($file_path));
readfile($file_path);
exit();
?>