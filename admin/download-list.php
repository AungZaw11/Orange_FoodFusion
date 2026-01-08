<?php
include 'auth.php';
$pageTitle = 'Download History';

// Fetch all downloads with user info
$stmt = $db->prepare("
    SELECT rd.*, u.first_name, u.last_name, u.email
    FROM resource_downloads rd
    JOIN users u ON rd.user_id = u.id
    ORDER BY rd.last_downloaded DESC
");
$stmt->execute();
$downloads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
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

        .nav-links a[href="download-list.php"] {
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
        }

        /* Desktop Table */
        .download-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: var(--shadow);
            border-radius: 8px;
            overflow: hidden;
        }

        .download-table th,
        .download-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .download-table th {
            background: #fafafa;
            color: var(--primary-orange);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: #666;
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

        /* Mobile Card View */
        .download-card {
            display: none;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            margin-bottom: 15px;
            border: 1px solid #eee;
        }

        .download-card h4 {
            margin: 0 0 10px 0;
            color: var(--primary-orange);
        }

        .download-card p {
            margin: 5px 0;
            font-size: 0.9rem;
            color: #666;
        }

        .download-card .actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        /* Responsive Design */
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
            .download-table { display: none; }
            .download-card { display: block; }
            .download-card .user-info {
                display: block;
            }
            .download-card .user-avatar {
                width: 25px;
                height: 25px;
                font-size: 0.7rem;
            }
            .download-card p {
                font-size: 0.85rem;
            }
            .download-card .actions a {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar { width: 200px; }
            .main-content { padding: 15px; }
            .page-content { padding: 15px; }
            .sidebar-header { font-size: 1.1rem; }
            .nav-links a { padding: 10px 15px; font-size: 0.9rem; }
            .mobile-toggle { top: 15px; left: 15px; }
        }
    </style>
</head>
<body>

<button class="mobile-toggle" id="mobileToggle">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">Orange Admin</div>
    <ul class="nav-links">
        <li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
        <li><a href="manage-recipes.php"><i class="fas fa-edit"></i> Manage Recipes</a></li>
        <li><a href="cookbook.php"><i class="fas fa-book"></i> Cookbook</a></li>
        <li><a href="community.php"><i class="fas fa-comments"></i> Community</a></li>
        <li><a href="contact-messages.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
        <li><a href="download-list.php" ><i class="fas fa-download"></i> Download Lists</a></li>
        <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
        <form method="POST" action="../logout.php" style="display:inline;">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="page-content">
        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by user or resource..." 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Desktop Table -->
        <table class="download-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Resource</th>
                    <th>Downloads</th>
                    <th>Last Downloaded</th>
                    <th>IP Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($downloads as $d): ?>
                <tr>
                    <td class="user-info">
                        <div class="user-avatar">
                            <?= strtoupper(substr($d['first_name'], 0, 1) . substr($d['last_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <strong><?= htmlspecialchars($d['first_name'] . ' ' . $d['last_name']) ?></strong><br>
                            <small><?= htmlspecialchars($d['email']) ?></small>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($d['resource_name']) ?></td>
                    <td><?= $d['download_count'] ?></td>
                    <td><?= date('M j, Y g:i A', strtotime($d['last_downloaded'])) ?></td>
                    <td><?= htmlspecialchars($d['ip_address']) ?></td>
                    <td class="actions">
                        <a href="#" onclick="confirmDelete(<?= $d['id'] ?>)" class="delete">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Mobile Card View -->
        <?php foreach ($downloads as $d): ?>
        <div class="download-card">
            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($d['first_name'], 0, 1) . substr($d['last_name'], 0, 1)) ?>
                </div>
                <div>
                    <strong><?= htmlspecialchars($d['first_name'] . ' ' . $d['last_name']) ?></strong><br>
                    <small><?= htmlspecialchars($d['email']) ?></small>
                </div>
            </div>
            <p><strong>Resource:</strong> <?= htmlspecialchars($d['resource_name']) ?></p>
            <p><strong>Downloads:</strong> <?= $d['download_count'] ?></p>
            <p><strong>Last Downloaded:</strong> <?= date('M j, Y g:i A', strtotime($d['last_downloaded'])) ?></p>
            <p><strong>IP:</strong> <?= htmlspecialchars($d['ip_address']) ?></p>
            <div class="actions">
                <a href="#" onclick="confirmDelete(<?= $d['id'] ?>)" class="delete">Delete</a>
            </div>
        </div>
        <?php endforeach; ?>
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

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this download record?')) {
        // You can add AJAX here for deletion
        alert('Record deleted!');
        // location.reload(); // Uncomment to refresh after deletion
    }
}
</script>

</body>
</html>