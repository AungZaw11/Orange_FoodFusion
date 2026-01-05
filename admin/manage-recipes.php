<?php
include 'auth.php';
$pageTitle = 'Manage Recipes';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $db->prepare("DELETE FROM recipes WHERE id = ?")->execute([$id]);
    header("Location: manage-recipes.php?deleted=1");
    exit();
}

// Search
$search = $_GET['search'] ?? '';
$condition = '';
$params = [];
if ($search) {
    $condition = "WHERE title LIKE ? OR cuisine_type LIKE ? OR dietary_preference LIKE ?";
    $params = ["%$search%", "%$search%", "%$search%"];
}

$stmt = $db->prepare("SELECT r.*, u.first_name, u.last_name FROM recipes r JOIN users u ON r.user_id = u.id $condition ORDER BY r.created_at DESC");
$stmt->execute($params);
$recipes = $stmt->fetchAll();
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

        .nav-links { list-style: none; padding: 0; }
        .nav-links li { margin: 10px 0; }
        .nav-links a {
            color: #bdc3c7;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
        }
        .nav-links a[href="manage-recipes.php"] {
            background: var(--primary-orange);
            color: white;
        }
        .nav-links i { margin-right: 10px; }

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

        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn-primary {
            background: var(--primary-orange);
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
        }

        .search-box input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: var(--shadow);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #fafafa;
            color: var(--primary-orange);
        }

        .featured {
            background: #fff8e1;
        }

        .actions-col a {
            margin-right: 10px;
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 600;
        }

        .delete-link {
            color: #e74c3c;
        }

        .alert {
            padding: 10px;
            background: #d4edda;
            color: #155724;
            border-radius: 4px;
            margin-bottom: 20px;
        }

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
            .actions { flex-direction: column; }
            .search-box input { max-width: 100%; }
            th, td { padding: 8px; font-size: 0.85rem; }
            .actions-col a { font-size: 0.85rem; }
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
        <li><a href="download.php"><i class="fas fa-download"></i> Download</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
        <form method="POST" action="../logout.php">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="page-content">
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert">Recipe deleted successfully.</div>
        <?php endif; ?>

        <div class="actions">
            <a href="add-recipe.php" class="btn-primary">+ Add New Recipe</a>
            <form method="GET" class="search-box">
                <input type="text" name="search" placeholder="Search by title, cuisine, or diet..." 
                       value="<?= htmlspecialchars($search) ?>">
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Recipe</th>
                    <th>Author</th>
                    <th>Cuisine / Diet</th>
                    <th>Time / Servings</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recipes as $r): ?>
                <tr class="<?= $r['is_featured'] ? 'featured' : '' ?>">
                    <td><strong><?= htmlspecialchars($r['title']) ?></strong><br><small><?= substr(htmlspecialchars($r['description'] ?? ''), 0, 60) ?>...</small></td>
                    <td><?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?></td>
                    <td><?= htmlspecialchars($r['cuisine_type'] ?? '') ?><br><?= htmlspecialchars($r['dietary_preference'] ?? '') ?></td>
                    <td><?= $r['cooking_time'] ?? 0 ?> min<br><?= $r['servings'] ?? 0 ?> servings</td>
                    <td><?= $r['is_featured'] ? '✅ Yes' : 'No' ?></td>
                    <td class="actions-col">
                        <a href="edit-recipe.php?id=<?= $r['id'] ?>">Edit</a>
                        <a href="?delete=<?= $r['id'] ?>" class="delete-link" onclick="return confirm('Delete this recipe?')">Delete</a>
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