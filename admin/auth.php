<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Check if user is admin
require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare("SELECT is_admin FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !$user['is_admin']) {
    session_destroy();
    header('Location: ../login.php?error=unauthorized');
    exit();
}
?>