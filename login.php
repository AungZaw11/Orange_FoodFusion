<?php
session_start();

// Check if blocked
if (isset($_SESSION['login_blocked_until']) && $_SESSION['login_blocked_until'] > time()) {
    header("Location: loginTimer.php");
    exit();
}

// Get messages
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';

// Clear messages after display
unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Orange Food Community</title>
    <style>
        :root {
            --primary-orange: #FF6B00;
            --bg-gradient: linear-gradient(135deg, #FFF8F0, #FFE5CC);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .auth-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(255, 107, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }
        .auth-header h1 {
            color: #333;
            text-align: center;
            margin-bottom: 8px;
            font-size: 1.8rem;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.95rem;
        }
        .alert-error {
            background: #fff0f0;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        .alert-success {
            background: #f0f9f0;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #E0E0E0;
            border-radius: 8px;
            font-size: 0.95rem;
        }
        .btn-auth {
            background: var(--primary-orange);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        .btn-auth:hover {
            background: #CC5500;
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <h1>Welcome Back</h1>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="login-process.php">
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn-auth">Sign In</button>
    </form>
</div>

</body>
</html>