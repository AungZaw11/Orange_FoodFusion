<?php
session_start();
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        // ✅ Use $db from Database class
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("SELECT id, email, password, is_admin FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['is_admin'] && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Orange</title>
    <style>
        :root { --primary-orange: #FF6B00; }
        body { font-family: Arial, sans-serif; background: #f9f9f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 350px; }
        .login-box h2 { color: var(--primary-orange); text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { width: 100%; background: var(--primary-orange); color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #CC5500; }
        .error { color: red; text-align: center; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="admin@orange.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>