<?php
include 'auth.php';

$pageTitle = 'User Management';

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    if ($delete_id !== $_SESSION['admin_id']) {
        $db->prepare("DELETE FROM users WHERE id = ? AND is_admin = 0")->execute([$delete_id]);
    }
    header("Location: users.php?deleted=1");
    exit();
}

// Search
$search = $_GET['search'] ?? '';
$condition = '';
$params = [];
if ($search) {
    $condition = "WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
    $params = ["%$search%", "%$search%", "%$search%"];
}

$stmt = $db->prepare("
    SELECT id, first_name, last_name, email, is_admin, created_at 
    FROM users 
    $condition 
    ORDER BY is_admin DESC, created_at DESC
");
$stmt->execute($params);
$users = $stmt->fetchAll();
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

        .mobile-toggle {
            display: none;
            background: var(--sidebar-bg);
            color: var(--text-light);
            border: none;
            font-size: 1.5rem;
            padding: 10px;
            cursor: pointer;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1001;
            border-radius: 4px;
        }

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

        .page-content {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        /* Search Box */
        .search-box {
            margin-bottom: 25px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
           
        }

        .search-box input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 300px;
            flex: 1;
        }

        .search-box button {
            background: var(--primary-orange);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
             margin-top: 10px;
        }

        /* Table */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: var(--shadow);
            border-radius: 8px;
            overflow: hidden;
        }

        .user-table th,
        .user-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .user-table th {
            background: #fafafa;
            color: var(--primary-orange);
        }

        .user-admin td:first-child::after {
            content: " 👑";
            color: var(--primary-orange);
        }

        .actions a {
            margin-right: 10px;
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 600;
        }

        .actions a.delete {
            color: #e74c3c;
        }

        .alert {
            padding: 10px;
            background: #d4edda;
            color: #155724;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        /* ===== MOBILE RESPONSIVE ===== */
        @media (max-width: 768px) {
            .mobile-toggle { display: block; }
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 2px 0 10px rgba(0,0,0,0.2);
            }
            .sidebar.active { transform: translateX(0); }
            .main-content {
                margin-left: 0;
                padding: 20px 10px;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding-top: 60px;
            }
            .header h1 { font-size: 1.3rem; }
            .logout-btn { align-self: flex-end; width: 100%; max-width: 120px; }
            .search-box input { max-width: 100%; }
            .user-table { font-size: 0.9rem; }
            .user-table th, .user-table td {
                padding: 8px;
                font-size: 0.85rem;
            }
            .actions a { font-size: 0.85rem; }
        }

        @media (max-width: 480px) {
            .sidebar { width: 200px; }
            .main-content { padding: 15px; }
            .page-content { padding: 15px; }
            .sidebar-header { font-size: 1.1rem; padding: 0 15px 15px; }
            .nav-links a { padding: 10px 15px; font-size: 0.9rem; }
            .mobile-toggle { top: 15px; left: 15px; padding: 8px; }
            .user-table th, .user-table td {
                padding: 6px;
                font-size: 0.8rem;
            }
            .search-box input { font-size: 0.85rem; }
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
<div class="main-content">
    <div class="header">
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
        <form method="POST" action="../logout.php" style="display:inline;">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="page-content">
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert">User deleted successfully.</div>
        <?php endif; ?>

        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by name or email..." 
                       value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <table class="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr class="<?= $u['is_admin'] ? 'user-admin' : '' ?>">
                    <td><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= date('M j, Y', strtotime($u['created_at'])) ?></td>
                    <td><?= $u['is_admin'] ? 'Admin' : 'User' ?></td>
                    <td class="actions">
                        <?php if (!$u['is_admin'] && $u['id'] !== $_SESSION['admin_id']): ?>
                            <a href="?delete=<?= $u['id'] ?>" class="delete" onclick="return confirm('Delete this user? All their recipes and data will be removed.')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('mobileToggle');

    if (toggle) {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
        });
    }

    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !toggle.contains(e.target) && window.innerWidth <= 768) {
            sidebar.classList.remove('active');
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active');
        }
    });
});
</script>

</body>
</html>