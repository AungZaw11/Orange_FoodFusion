<?php 
session_start(); // ✅ Must be at the very top

// Check if user is blocked
if (!isset($_SESSION['login_blocked_until']) || $_SESSION['login_blocked_until'] <= time()) {
    // If not blocked, redirect to login
    header("Location: login.php");
    exit();
}

// Calculate remaining time (300 seconds = 5 minutes)
$remaining_time = $_SESSION['login_blocked_until'] - time();
if ($remaining_time <= 0) {
    // If time is up, redirect to login
    unset($_SESSION['login_blocked_until']);
    unset($_SESSION['login_counter']);
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login Blocked - FoodFusion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 450px;
            text-align: center;
            animation: slideIn 0.5s ease;
        }
        .card h2 {
            color: #d9534f;
            margin-bottom: 15px;
            font-size: 2rem;
        }
        .card p {
            font-size: 1.2rem;
            margin: 0 0 20px 0;
            color: #666;
        }
        #Timer {
            font-size: 1.4rem;
            color: #333;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-primary {
            background: #FF6B00;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.3);
        }
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .lock-icon {
            font-size: 4rem;
            color: #d9534f;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <i class="fas fa-lock lock-icon"></i>
        <h2>Login is blocked</h2>
        <p>Too many failed login attempts. Please wait before trying again.</p>
        <div id="Timer"></div>
        <p><i class="fas fa-info-circle"></i> This is to protect your account from unauthorized access.</p>
        <a href="index.php" class="btn btn-primary">
            <i class="fas fa-home me-2"></i> Go to Home
        </a>
    </div>

    <script>
        // Get remaining time from PHP
        let totalSeconds = <?php echo $remaining_time; ?>;
        const display = document.getElementById('Timer');

        const timer = setInterval(() => {
            totalSeconds--;
            const mins = Math.floor(totalSeconds / 60);
            const secs = totalSeconds % 60;
            display.innerHTML = `${mins}m ${secs}s remaining`;

            if (totalSeconds <= 0) {
                clearInterval(timer);
                // Redirect to login when timer finishes
                window.location.href = 'login.php';
            }
        }, 1000);
    </script>
</body>
</html>