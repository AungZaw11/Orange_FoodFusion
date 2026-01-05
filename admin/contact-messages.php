<?php
include 'auth.php';
$pageTitle = 'Contact Messages';

// Mark as read
if (isset($_GET['mark_read'])) {
    $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?")
        ->execute([(int)$_GET['mark_read']]);
    header("Location: contact-messages.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM contact_messages WHERE id = ?")
        ->execute([(int)$_GET['delete']]);
    header("Location: contact-messages.php?deleted=1");
    exit();
}

$messages = $db->query("SELECT * FROM contact_messages ORDER BY is_read ASC, created_at DESC")->fetchAll();
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
        .nav-links a[href="contact-messages.php"] {
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

        .message-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid #ccc;
        }

        .message-card.unread {
            border-left-color: #FF6B00;
            background: #fff8e1;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .message-subject {
            font-size: 1.1rem;
            margin: 5px 0;
        }

        .message-body {
            margin: 10px 0;
            color: #333;
            line-height: 1.5;
        }

        .message-meta {
            color: #777;
            font-size: 0.9rem;
        }

        .message-actions {
            margin-top: 15px;
        }

        .btn {
            padding: 5px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            display: inline-block;
        }

        .btn-read {
            background: #2ecc71;
            color: white;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
            margin-left: 8px;
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
            .message-card { padding: 15px; }
            .message-actions { margin-top: 10px; }
            .btn { padding: 4px 10px; font-size: 0.85rem; }
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
            <div class="alert">Message deleted successfully.</div>
        <?php endif; ?>

        <?php if (empty($messages)): ?>
            <p>No messages yet.</p>
        <?php else: ?>
            <?php foreach ($messages as $m): ?>
                <div class="message-card <?= $m['is_read'] ? '' : 'unread' ?>">
                    <div class="message-header">
                        <span><?= htmlspecialchars($m['name']) ?></span>
                        <span><?= date('M j, Y g:i A', strtotime($m['created_at'])) ?></span>
                    </div>
                    <div class="message-subject"><?= htmlspecialchars($m['subject']) ?></div>
                    <div class="message-meta">From: <?= htmlspecialchars($m['email']) ?></div>
                    <div class="message-body"><?= nl2br(htmlspecialchars($m['message'])) ?></div>
                    <div class="message-actions">
                        <?php if (!$m['is_read']): ?>
                            <a href="?mark_read=<?= $m['id'] ?>" class="btn btn-read">Mark as Read</a>
                        <?php endif; ?>
                        <a href="?delete=<?= $m['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this message?')">Delete</a>
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