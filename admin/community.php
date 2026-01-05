<?php
include 'auth.php';
$pageTitle = 'Community';

// Handle delete
if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM community_posts WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: community.php?deleted=1");
    exit();
}

// Search
$search = $_GET['search'] ?? '';
$condition = '';
$params = [];
if ($search) {
    $condition = "WHERE title LIKE ? OR content LIKE ? OR category LIKE ?";
    $params = ["%$search%", "%$search%", "%$search%"];
}

$stmt = $db->prepare("
    SELECT p.*, u.first_name, u.last_name, u.email
    FROM community_posts p
    JOIN users u ON p.user_id = u.id
    $condition
    ORDER BY p.created_at DESC
");
$stmt->execute($params);
$posts = $stmt->fetchAll();
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
        .nav-links a[href="community.php"] {
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

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 300px;
        }

        .post-card {
            background: white;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid #FF6B00;
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .post-title {
            font-size: 1.2rem;
            margin: 5px 0;
            color: #333;
        }

        .post-meta {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .post-content {
            color: #333;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .post-type {
            display: inline-block;
            background: #e0e0e0;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.85rem;
            text-transform: capitalize;
        }

        .actions a {
            margin-right: 10px;
            color: #FF6B00;
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
            .post-card { padding: 12px; }
            .post-title { font-size: 1.1rem; }
            .search-box input { max-width: 100%; }
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
            <div class="alert">Post deleted successfully.</div>
        <?php endif; ?>

        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="Search posts by title, content, or category..." 
                       value="<?= htmlspecialchars($search) ?>">
            </form>
        </div>

        <?php if (empty($posts)): ?>
            <p>No community posts yet.</p>
        <?php else: ?>
            <?php foreach ($posts as $p): ?>
                <div class="post-card">
                    <div class="post-header">
                        <span><?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?></span>
                        <span><?= date('M j, Y', strtotime($p['created_at'])) ?></span>
                    </div>
                    <div class="post-title"><?= htmlspecialchars($p['title']) ?></div>
                    <div class="post-meta">
                        Type: <span class="post-type"><?= htmlspecialchars($p['post_type']) ?></span> |
                        Category: <?= htmlspecialchars($p['category'] ?? '—') ?> |
                        Likes: <?= $p['likes'] ?> | Comments: <?= $p['comments'] ?>
                    </div>
                    <div class="post-content"><?= nl2br(htmlspecialchars(substr($p['content'], 0, 200))) ?>...</div>
                    <div class="actions">
                        <a href="?delete=<?= $p['id'] ?>" class="delete" onclick="return confirm('Delete this post?')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
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