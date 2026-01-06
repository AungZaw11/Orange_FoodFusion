<?php
include 'auth.php';
$pageTitle = 'Cookbook';

// Handle toggle featured
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $current = $db->prepare("SELECT is_featured FROM recipes WHERE id = ?");
    $current->execute([$id]);
    $featured = $current->fetchColumn();
    
    $db->prepare("UPDATE recipes SET is_featured = ? WHERE id = ?")
        ->execute([$featured ? 0 : 1, $id]);
    
    header("Location: cookbook.php");
    exit();
}

$recipes = $db->query("
    SELECT r.*, u.first_name, u.last_name 
    FROM recipes r 
    JOIN users u ON r.user_id = u.id 
    WHERE r.is_featured = 1 
    ORDER BY r.created_at DESC
")->fetchAll();
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
        .nav-links a[href="cookbook.php"] {
            background: #FF6B00;
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
            color: #FF6B00;
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

        .back-link {
            color: #FF6B00;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }

        .recipe-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .recipe-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .recipe-body {
            padding: 15px;
        }

        .recipe-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .recipe-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .recipe-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-small {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .btn-remove {
            background: #e74c3c;
            color: white;
        }

        .btn-edit {
            background: #3498db;
            color: white;
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
            .recipe-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
            .recipe-img { height: 140px; }
            .recipe-title { font-size: 1rem; }
        }

        @media (max-width: 480px) {
            .sidebar { width: 200px; }
            .main-content { padding: 15px; }
            .page-content { padding: 15px; }
            .sidebar-header { font-size: 1.1rem; }
            .nav-links a { padding: 10px 15px; font-size: 0.9rem; }
            .mobile-toggle { top: 15px; left: 15px; }
            .recipe-grid {
                grid-template-columns: 1fr;
            }
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
        <li><a href="download.list.php"><i class="fas fa-download"></i> Download Lists</a></li>
        <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
        <a href="index.php" class="back-link">&larr; Back to Dashboard</a>
        <a href="manage-recipes.php" style="background: #FF6B00; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 0.9rem; float: right;">Manage All Recipes</a>
        <div style="clear: both; margin-bottom: 20px;"></div>

        <?php if (empty($recipes)): ?>
            <p>No featured recipes yet. Go to <a href="manage-recipes.php">Manage Recipes</a> to feature some!</p>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $r): ?>
                    <div class="recipe-card">
                        <?php if (!empty($r['featured_image'])): ?>
                            <img src="../<?= htmlspecialchars($r['featured_image']) ?>" 
                                 alt="<?= htmlspecialchars($r['title']) ?>" 
                                 class="recipe-img"
                                 onerror="this.parentElement.innerHTML='<div style=&quot;background:#eee;height:160px;display:flex;align-items:center;justify-content:center;color:#999;&quot;>No Image</div>';">
                        <?php else: ?>
                            <div style="background: #eee; height: 160px; display: flex; align-items: center; justify-content: center; color: #999;">
                                No Image
                            </div>
                        <?php endif; ?>
                        <div class="recipe-body">
                            <div class="recipe-title"><?= htmlspecialchars($r['title']) ?></div>
                            <div class="recipe-meta">
                                by <?= htmlspecialchars($r['first_name']) ?><br>
                                <?= htmlspecialchars($r['cuisine_type']) ?> • <?= htmlspecialchars($r['difficulty_level']) ?>
                            </div>
                            <div class="recipe-actions">
                                <a href="?toggle=<?= $r['id'] ?>" class="btn-small btn-remove" onclick="return confirm('Remove from cookbook?')">Remove</a>
                                <a href="edit-recipe.php?id=<?= $r['id'] ?>" class="btn-small btn-edit">Edit</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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