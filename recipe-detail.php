<?php
$page_title = "Recipe Detail - Orange";
include 'includes/header.php';

include 'config/database.php';

// Get recipe ID from URL
$recipe_id = $_GET['id'] ?? null;

if (!$recipe_id || !is_numeric($recipe_id)) {
    echo '<div class="container"><div class="alert alert-danger">Invalid recipe ID.</div></div>';
    include 'includes/footer.php';
    exit();
}

$database = new Database();
$db = $database->getConnection();

try {
    // Fetch recipe + author (without profile_image)
    $query = "
        SELECT r.*, u.first_name, u.last_name
        FROM recipes r
        LEFT JOIN users u ON r.user_id = u.id
        WHERE r.id = ?
        LIMIT 1
    ";
    $stmt = $db->prepare($query);
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        echo '<div class="container"><div class="alert alert-warning">Recipe not found.</div></div>';
        include 'includes/footer.php';
        exit();
    }

} catch (PDOException $e) {
    echo '<div class="container"><div class="alert alert-danger">Error loading recipe.</div></div>';
    include 'includes/footer.php';
    exit();
}
?>

<div class="container recipe-detail-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" style="margin: 20px 0;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="recipes.php">Recipes</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($recipe['title']) ?></li>
        </ol>
    </nav>

    <div class="recipe-header">
        <h1><?= htmlspecialchars($recipe['title']) ?></h1>
        <div class="recipe-meta-top">
            <span class="difficulty <?= strtolower($recipe['difficulty_level'] ?? 'easy') ?>">
                <?= htmlspecialchars($recipe['difficulty_level'] ?? 'Easy') ?>
            </span>
            <span><i class="fas fa-clock"></i> <?= (int)($recipe['cooking_time'] ?? 30) ?> min</span>
            <span><i class="fas fa-users"></i> <?= (int)($recipe['servings'] ?? 4) ?> servings</span>
            <?php if (!empty($recipe['cuisine_type'])): ?>
                <span><i class="fas fa-globe-americas"></i> <?= htmlspecialchars($recipe['cuisine_type']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="recipe-main">
        <!-- Recipe Image -->
        <div class="recipe-image-container">
            <?php if (!empty($recipe['featured_image'])): ?>
                <img src="<?= htmlspecialchars($recipe['featured_image']) ?>" 
                     alt="<?= htmlspecialchars($recipe['title']) ?>"
                     class="recipe-main-image"
                     onerror="this.src='https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=800&auto=format&fit=crop';">
            <?php else: ?>
                <img src="https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=800&auto=format&fit=crop" 
                     alt="<?= htmlspecialchars($recipe['title']) ?>"
                     class="recipe-main-image">
            <?php endif; ?>
        </div>

        <!-- Recipe Info (Author only - no avatar) -->
        <div class="recipe-info">
            <div class="author-card">
                <div class="author-info">
                    <h4>By <?= htmlspecialchars($recipe['first_name'] . ' ' . $recipe['last_name']) ?></h4>
                    <p>Published <?= date('F j, Y', strtotime($recipe['created_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <?php if (!empty($recipe['description'])): ?>
        <div class="recipe-section">
            <h2>About this recipe</h2>
            <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
        </div>
    <?php endif; ?>

    <!-- Ingredients -->
    <div class="recipe-section">
        <h2>Ingredients</h2>
        <div class="ingredients-list">
            <?php
            $ingredients = trim($recipe['ingredients']);
            if (!empty($ingredients)) {
                $lines = preg_split('/\r\n|\r|\n/', $ingredients);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (!empty($line)) {
                        echo '<div class="ingredient-item">' . htmlspecialchars($line) . '</div>';
                    }
                }
            }
            ?>
        </div>
    </div>

    <!-- Instructions -->
    <div class="recipe-section">
        <h2>Instructions</h2>
        <div class="instructions-list">
            <?php
            $instructions = trim($recipe['instructions']);
            if (!empty($instructions)) {
                $steps = preg_split('/\r\n|\r|\n/', $instructions);
                foreach ($steps as $index => $step) {
                    $step = trim($step);
                    if (!empty($step)) {
                        echo '<div class="instruction-step">';
                        echo '<span class="step-number">' . ($index + 1) . '</span>';
                        echo '<div class="step-content">' . htmlspecialchars($step) . '</div>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
    </div>

    <!-- Back to Recipes -->
    <div class="back-link">
        <a href="recipes.php">&larr; Back to All Recipes</a>
    </div>
</div>

<style>
.recipe-detail-container {
    margin-top: 20px;
    margin-bottom: 50px;
}

.breadcrumb {
    background: none;
    padding: 0;
    font-size: 0.95rem;
}

.breadcrumb a {
    color: var(--primary-orange);
    text-decoration: none;
}

.recipe-header {
    margin-bottom: 30px;
}

.recipe-header h1 {
    font-size: 2.2rem;
    color: #333;
    margin-bottom: 15px;
}

.recipe-meta-top {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.recipe-meta-top span {
    background: #f8f9fa;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 6px;
    color: #555;
}

.recipe-meta-top .difficulty {
    background: var(--primary-orange);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
}

.recipe-main {
    display: flex;
    gap: 30px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.recipe-image-container {
    flex: 1;
    min-width: 300px;
}

.recipe-main-image {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.recipe-info {
    flex: 1;
    min-width: 250px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.author-card {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.author-info h4 {
    margin: 0 0 5px 0;
    font-size: 1.2rem;
    color: #333;
}

.author-info p {
    margin: 0;
    color: #777;
    font-size: 0.95rem;
}

.recipe-section {
    margin-bottom: 40px;
}

.recipe-section h2 {
    color: var(--primary-orange);
    margin-bottom: 20px;
    font-size: 1.8rem;
    border-bottom: 2px solid var(--orange-subtle);
    padding-bottom: 10px;
}

.ingredients-list {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
}

.ingredient-item {
    padding: 8px 0;
    border-bottom: 1px dashed #ddd;
    line-height: 1.5;
}

.ingredient-item:last-child {
    border-bottom: none;
}

.instructions-list {
    background: white;
    border: 1px solid #eee;
    border-radius: 10px;
    overflow: hidden;
}

.instruction-step {
    display: flex;
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.instruction-step:last-child {
    border-bottom: none;
}

.step-number {
    background: var(--primary-orange);
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-right: 15px;
    font-weight: bold;
    font-size: 0.9rem;
}

.step-content {
    line-height: 1.6;
    color: #444;
}

.back-link {
    text-align: center;
    margin-top: 30px;
}

.back-link a {
    color: var(--primary-orange);
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .recipe-main {
        flex-direction: column;
    }

    .recipe-header h1 {
        font-size: 1.8rem;
    }

    .recipe-meta-top {
        gap: 10px;
        font-size: 0.85rem;
    }

    .instruction-step {
        flex-direction: column;
        gap: 10px;
    }

    .step-number {
        align-self: flex-start;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Optional: Add smooth scrolling or other interactivity
});
</script>

<?php include 'includes/footer.php'; ?>