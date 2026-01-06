<?php
include 'auth.php';
$pageTitle = 'Edit Recipe';

// Get recipe ID
$recipe_id = $_GET['id'] ?? null;

if (!$recipe_id || !is_numeric($recipe_id)) {
    header('Location: manage-recipes.php?error=invalid_recipe');
    exit();
}

// Fetch recipe data
$stmt = $db->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    header('Location: manage-recipes.php?error=recipe_not_found');
    exit();
}

// Handle form submission
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $ingredients = trim($_POST['ingredients'] ?? '');
        $instructions = trim($_POST['instructions'] ?? '');
        $cooking_time = (int)($_POST['cooking_time'] ?? 0);
        $servings = (int)($_POST['servings'] ?? 1);
        $difficulty = $_POST['difficulty'] ?? 'Easy';
        $cuisine_type = trim($_POST['cuisine_type'] ?? '');
        $dietary = trim($_POST['dietary_preference'] ?? '');
        $is_featured = isset($_POST['is_featured']);
        $category_ids = $_POST['categories'] ?? [];

        // Validate required fields
        if (empty($title) || empty($ingredients) || empty($instructions)) {
            throw new Exception('Title, ingredients, and instructions are required.');
        }

        // Handle image upload
        $image_path = $recipe['featured_image']; // Keep old image by default

        if (!empty($_FILES['featured_image']['name'])) {
            $upload_dir = '../uploads/recipes/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $file = $_FILES['featured_image'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array(strtolower($ext), $allowed)) {
                throw new Exception('Only JPG, PNG, or WebP images are allowed.');
            }

            $filename = 'recipe_' . time() . '_' . uniqid() . '.' . $ext;
            $target = $upload_dir . $filename;

            if (!move_uploaded_file($file['tmp_name'], $target)) {
                throw new Exception('Failed to upload image.');
            }

            // Delete old image if it exists
            if ($recipe['featured_image'] && file_exists($recipe['featured_image'])) {
                unlink($recipe['featured_image']);
            }

            $image_path = 'uploads/recipes/' . $filename;
        }

        // Update recipe
        $stmt = $db->prepare("
            UPDATE recipes 
            SET title = ?, description = ?, ingredients = ?, instructions = ?, cooking_time = ?, servings = ?, 
                difficulty_level = ?, cuisine_type = ?, dietary_preference = ?, featured_image = ?, is_featured = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $title,
            $description,
            $ingredients,
            $instructions,
            $cooking_time,
            $servings,
            $difficulty,
            $cuisine_type,
            $dietary,
            $image_path,
            $is_featured ? 1 : 0,
            $recipe_id
        ]);

        // Update categories
        $db->prepare("DELETE FROM recipe_categories WHERE recipe_id = ?")->execute([$recipe_id]);

        if (!empty($category_ids)) {
            $stmt = $db->prepare("INSERT INTO recipe_categories (recipe_id, category_id) VALUES (?, ?)");
            foreach ($category_ids as $cat_id) {
                $stmt->execute([$recipe_id, (int)$cat_id]);
            }
        }

        $message = 'Recipe updated successfully!';
        // Clear form by not repopulating fields

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
} else {
    // Pre-populate form with current data
    $title = $recipe['title'];
    $description = $recipe['description'];
    $ingredients = $recipe['ingredients'];
    $instructions = $recipe['instructions'];
    $cooking_time = $recipe['cooking_time'];
    $servings = $recipe['servings'];
    $difficulty = $recipe['difficulty_level'];
    $cuisine_type = $recipe['cuisine_type'];
    $dietary = $recipe['dietary_preference'];
    $is_featured = $recipe['is_featured'];

    // Fetch current categories
    $stmt = $db->prepare("SELECT category_id FROM recipe_categories WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);
    $current_categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle) ?> | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-orange: #FF6B00;
            --orange-light: #FF8E42;
            --orange-dark: #CC5500;
            --sidebar-bg: #2c3e50;
            --text-light: #ecf0f1;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f7fa; }
        .container { max-width: 900px; margin: 20px auto; padding: 0 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header h1 { color: var(--primary-orange); }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: bold; }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: Arial, sans-serif;
        }
        textarea.form-control { min-height: 100px; }
        .checkbox-group { display: flex; align-items: center; gap: 8px; }
        .btn {
            background: var(--primary-orange); color: white; padding: 10px 20px;
            border: none; border-radius: 4px; cursor: pointer; font-size: 1rem;
        }
        .btn:hover { background: var(--orange-dark); }
        .category-list { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px; }
        .category-item { display: flex; align-items: center; gap: 5px; }
        .back-link {
            color: var(--primary-orange); text-decoration: none; display: inline-block; margin-bottom: 20px;
        }
        .back-link:hover { text-decoration: underline; }
        
        /* Image preview */
        .image-preview {
            margin: 15px 0;
            max-width: 100%;
        }
        .image-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .image-preview p {
            margin-top: 5px;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="manage-recipes.php" class="back-link">&larr; Back to Recipes</a>
        <div class="header">
            <h1>Edit Recipe</h1>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"><?= htmlspecialchars($description) ?></textarea>
            </div>

            <div class="form-group">
                <label>Ingredients *</label>
                <textarea name="ingredients" class="form-control" placeholder="• 2 cups flour&#10;• 1 tsp salt&#10;• 1 cup water" required><?= htmlspecialchars($ingredients) ?></textarea>
            </div>

            <div class="form-group">
                <label>Instructions *</label>
                <textarea name="instructions" class="form-control" placeholder="1. Mix dry ingredients&#10;2. Add water gradually&#10;3. Bake at 350°F for 30 minutes" required><?= htmlspecialchars($instructions) ?></textarea>
            </div>

            <!-- Current Image Preview -->
            <?php if (!empty($recipe['featured_image'])): ?>
                <div class="form-group image-preview">
                    <label>Current Image</label>
                    <img src="../<?= htmlspecialchars($recipe['featured_image']) ?>" alt="Current Recipe Image">
                    <p>Upload a new image to replace this one.</p>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Featured Image</label>
                <input type="file" name="featured_image" accept="image/*" class="form-control">
                <small>Recommended: 800x600px (JPG, PNG, WebP)</small>
            </div>

            <div class="form-group">
                <label>Cooking Time (minutes)</label>
                <input type="number" name="cooking_time" class="form-control" min="1" value="<?= $cooking_time ?>">
            </div>

            <div class="form-group">
                <label>Servings</label>
                <input type="number" name="servings" class="form-control" min="1" value="<?= $servings ?>">
            </div>

            <div class="form-group">
                <label>Difficulty</label>
                <select name="difficulty" class="form-control">
                    <option value="Easy" <?= $difficulty === 'Easy' ? 'selected' : '' ?>>Easy</option>
                    <option value="Medium" <?= $difficulty === 'Medium' ? 'selected' : '' ?>>Medium</option>
                    <option value="Hard" <?= $difficulty === 'Hard' ? 'selected' : '' ?>>Hard</option>
                </select>
            </div>

            <div class="form-group">
                <label>Cuisine Type</label>
                <input type="text" name="cuisine_type" class="form-control" value="<?= htmlspecialchars($cuisine_type) ?>" placeholder="e.g., Italian, Mexican">
            </div>

            <div class="form-group">
                <label>Dietary Preference</label>
                <input type="text" name="dietary_preference" class="form-control" value="<?= htmlspecialchars($dietary) ?>" placeholder="e.g., Vegetarian, Vegan, Gluten-Free">
            </div>

            <div class="form-group">
                <label>Categories</label>
                <div class="category-list">
                    <?php
                    $categories = $db->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
                    foreach ($categories as $cat): ?>
                        <div class="category-item">
                            <input type="checkbox" name="categories[]" value="<?= $cat['id'] ?>" id="cat-<?= $cat['id'] ?>"
                                   <?= in_array($cat['id'], $current_categories) ? 'checked' : '' ?>>
                            <label for="cat-<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="is_featured" id="is_featured" <?= $is_featured ? 'checked' : '' ?>>
                    <label for="is_featured">Mark as Featured Recipe</label>
                </div>
            </div>

            <button type="submit" class="btn">Update Recipe</button>
        </form>
    </div>
</body>
</html>