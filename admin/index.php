<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'auth.php';

$pageTitle = 'Dashboard';

// Fetch stats
$stats = [
    'total_users' => $db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'total_recipes' => $db->query("SELECT COUNT(*) FROM recipes")->fetchColumn(),
    'total_featured' => $db->query("SELECT COUNT(*) FROM recipes WHERE is_featured = 1")->fetchColumn(),
    'total_contacts' => $db->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn(),
    'unread_contacts' => $db->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn(),
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | Orange Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-orange: #FF6B00;
            --orange-light: #FF8E42;
            --orange-dark: #CC5500;
            --sidebar-bg: #2c3e50;
            --text-light: #ecf0f1;
            --main-bg: #f5f7fa;
            --card-bg: white;
            --shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: var(--main-bg); min-height: 100vh; display: flex; }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: var(--sidebar-bg);
            color: var(--text-light);
            padding: 20px 0;
            transition: all 0.3s ease;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
            top: 0;
            left: 0;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            font-size: 1.3rem;
            font-weight: bold;
            border-bottom: 1px solid #34495e;
        }

        .nav-links {
            list-style: none;
            padding: 0;
        }

        .nav-links li {
            margin: 10px 0;
        }

        .nav-links a {
            color: #bdc3c7;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
        }

        .nav-links a:hover,
        .nav-links a[href="<?= basename($_SERVER['PHP_SELF']) ?>"] {
            background: var(--primary-orange);
            color: white;
        }

        .nav-links i {
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 240px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            position: relative;
        }

        .header h1 {
            color: var(--primary-orange);
            font-size: 1.5rem;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .stat-card h3 {
            color: var(--primary-orange);
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none;
            background: var(--sidebar-bg);
            color: var(--text-light);
            border: none;
            font-size: 1.5rem;
            padding: 10px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1001;
            border-radius: 4px;
        }

        .mobile-toggle i {
            font-size: 1.2rem;
        }

        /* Recent Activity */
        .recent-activity {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        /* ===== MOBILE RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                transform: translateX(-100%);
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 1001;
                box-shadow: 2px 0 10px rgba(0,0,0,0.2);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px 10px;
            }

            .mobile-toggle {
                display: block;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding-top: 60px; /* Make room for toggle */
            }

            .header h1 {
                font-size: 1.3rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card .value {
                font-size: 1.5rem;
            }

            .logout-btn {
                align-self: flex-end;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                padding: 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-card .value {
                font-size: 1.3rem;
            }

            .sidebar-header {
                font-size: 1.1rem;
                padding: 0 15px 15px;
            }

            .nav-links a {
                padding: 10px 15px;
                font-size: 0.9rem;
            }

            .mobile-toggle {
                top: 15px;
                left: 15px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Hamburger Toggle -->
<button class="mobile-toggle" id="mobileToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">Orange Admin</div>
    <ul class="nav-links">
        <li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
        <li><a href="manage-recipes.php"><i class="fas fa-edit"></i> Manage Recipes</a></li>
        <li><a href="cookbook.php"><i class="fas fa-book"></i> Cookbook</a></li>
        <li><a href="community.php"><i class="fas fa-comments"></i> Community</a></li>
        <li><a href="contact-messages.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
        <li><a href="download.php"><i class="fas fa-download"></i> Download</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <div class="header">
        <h1>Dashboard</h1>
        <form method="POST" action="../logout.php" style="display:inline;">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Users</h3>
            <div class="value"><?= $stats['total_users'] ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Recipes</h3>
            <div class="value"><?= $stats['total_recipes'] ?></div>
        </div>
        <div class="stat-card">
            <h3>Featured Recipes</h3>
            <div class="value"><?= $stats['total_featured'] ?></div>
        </div>
        <div class="stat-card">
            <h3>Unread Messages</h3>
            <div class="value"><?= $stats['unread_contacts'] ?>/<?= $stats['total_contacts'] ?></div>
        </div>
    </div>

    <div class="recent-activity">
        <h3>Recent Activity</h3>
        <p>Latest community posts, reviews, and submissions appear here (optional enhancement).</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const mobileToggle = document.getElementById('mobileToggle');

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('active');
            if (sidebar.classList.contains('active')) {
                mainContent.style.marginLeft = '240px';
            } else {
                mainContent.style.marginLeft = '0';
            }
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target) && window.innerWidth <= 768) {
            sidebar.classList.remove('active');
            mainContent.style.marginLeft = '0';
        }
    });

    // Adjust margin on resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active');
            mainContent.style.marginLeft = '240px';
        } else {
            mainContent.style.marginLeft = '0';
        }
    });
});
</script>

</body>
</html>