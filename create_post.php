
<?php
ob_start();
$page_title = "Create Post - Orange Community";
include 'includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config/database.php';
$database = new Database();
$db = $database->getConnection();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $post_type = $_POST['post_type'] ?? 'tip';

    if (empty($title) || empty($content) || empty($category)) {
        $error = 'All fields are required.';
    } else {
        try {
            $stmt = $db->prepare("
                INSERT INTO community_posts (user_id, title, content, category, post_type)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_SESSION['user_id'],
                $title,
                $content,
                $category,
                $post_type
            ]);

            $success = 'Your post has been created successfully!';
            // Clear form by not repopulating

        } catch (PDOException $e) {
            $error = 'Error saving your post. Please try again.';
            error_log("Post Error: " . $e->getMessage());
        }
    }
}
?>

<div class="container" style="margin-top: 30px; max-width: 800px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1>Create New Post</h1>
        <p>Share your culinary tips, questions, or experiences with the community</p>
    </div>

    <?php if ($success): ?>
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            <?= htmlspecialchars($success) ?>
        </div>
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="cookbook.php" style="background: var(--primary-orange); color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; display: inline-block;">
                View Community Posts
            </a>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Post Type</label>
            <select name="post_type" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                <option value="tip" <?= (($_POST['post_type'] ?? 'tip') == 'tip') ? 'selected' : ''; ?>>Cooking Tip</option>
                <option value="recipe" <?= (($_POST['post_type'] ?? '') == 'recipe') ? 'selected' : ''; ?>>Recipe Question</option>
                <option value="question" <?= (($_POST['post_type'] ?? '') == 'question') ? 'selected' : ''; ?>>General Question</option>
                <option value="review" <?= (($_POST['post_type'] ?? '') == 'review') ? 'selected' : ''; ?>>Product Review</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Category</label>
            <input type="text" name="category" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"
                   placeholder="e.g., Baking, Italian, Vegan, Quick Meals"
                   value="<?= htmlspecialchars($_POST['category'] ?? ''); ?>" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Title</label>
            <input type="text" name="title" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"
                   placeholder="Give your post a clear title"
                   value="<?= htmlspecialchars($_POST['title'] ?? ''); ?>" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Content</label>
            <textarea name="content" rows="8" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-family: Arial, sans-serif;"
                      placeholder="Share your thoughts, tips, or questions..."><?= htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
        </div>

        <div style="display: flex; gap: 15px; justify-content: flex-end;">
            <a href="cookbook.php" style="color: #666; text-decoration: none; padding: 10px 20px; border: 1px solid #ddd; border-radius: 6px;">
                Cancel
            </a>
            <button type="submit" style="background: var(--primary-orange); color: white; border: none; padding: 10px 25px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                Publish Post
            </button>
        </div>
    </form>
</div>

<style>
:root {
    --primary-orange: #FF6B00;
}
body {
    background: #f8f9fa;
}
</style>

<?php include 'includes/footer.php'; ?>