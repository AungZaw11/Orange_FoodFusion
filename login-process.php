<?php
// Start output buffering immediately to prevent "headers already sent" errors
ob_start();

session_start();

// Include database config
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Initialize login counter
$counter = $_SESSION['login_counter'] ?? 0;

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    header("Location: login.php");
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Check if user is currently blocked
if (isset($_SESSION['login_blocked_until']) && $_SESSION['login_blocked_until'] > time()) {
    ob_end_clean();
    header("Location: loginTimer.php");
    exit();
}

// Validate input
if (empty($email) || empty($password)) {
    $counter++;
    $_SESSION['login_counter'] = $counter;
    if ($counter >= 3) {
        $_SESSION['login_blocked_until'] = time() + 180; // Block for 3 minutes
        ob_end_clean();
        header("Location: loginTimer.php");
    } else {
        $_SESSION['error'] = "Email and password are required. Attempts: $counter";
        ob_end_clean();
        header("Location: login.php");
    }
    exit();
}

try {
    // Secure query with prepared statement
    $stmt = $db->prepare("SELECT id, first_name, last_name, password, is_admin FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // ✅ Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['is_admin'] = (bool) $user['is_admin'];

        // Clear security-related session data
        unset($_SESSION['login_counter']);
        unset($_SESSION['login_blocked_until']);

        // Redirect based on role
        if ($user['is_admin']) {
            $_SESSION['success'] = "Admin login successful!";
            ob_end_clean();
            header("Location: admin/index.php");
        } else {
            $_SESSION['success'] = "Login successful!";
            ob_end_clean();
            header("Location: index.php");
        }
        exit();
    } else {
        // ❌ Login failed
        $counter++;
        $_SESSION['login_counter'] = $counter;
        if ($counter >= 3) {
            $_SESSION['login_blocked_until'] = time() + 180;
            ob_end_clean();
            header("Location: loginTimer.php");
        } else {
            $_SESSION['error'] = "Invalid email or password. Attempts: $counter";
            ob_end_clean();
            header("Location: login.php");
        }
        exit();
    }
} catch (PDOException $e) {
    error_log("Login DB Error: " . $e->getMessage());
    $_SESSION['error'] = "System error. Please try again later.";
    ob_end_clean();
    header("Location: login.php");
    exit();
}
?>