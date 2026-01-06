<?php
$page_title = "Recipes - Orange";
include 'includes/header.php';

include 'config/database.php';
$database = new Database();
$db = $database->getConnection();

try {
    $query = "SELECT r.*, u.first_name, u.last_name 
              FROM recipes r 
              LEFT JOIN users u ON r.user_id = u.id 
              ORDER BY r.created_at DESC 
              LIMIT 9";

    $stmt = $db->prepare($query);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo '<div class="container">';
    echo '<div class="alert alert-danger">';
    echo '<p>Sorry, there was an error loading recipes.</p>';
    echo '</div>';
    echo '</div>';
    
    $recipes = [];
    include 'includes/footer.php';
    exit();
}
?>

<div class="container">
    <div class="recipes-header">
        <h1>Delicious Recipes</h1>
        <p>Discover amazing recipes from our community</p>
    </div>

    <?php if (count($recipes) > 0): ?>
        <div class="recipes-grid">
            <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-card">
                <div class="recipe-image">
                    <?php if (!empty($recipe['featured_image'])): ?>
                        <img src="<?php echo htmlspecialchars($recipe['featured_image']); ?>" 
                             alt="<?php echo htmlspecialchars($recipe['title']); ?>"
                             onerror="this.src='https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=400&auto=format&fit=crop'">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=400&auto=format&fit=crop" 
                             alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                    <?php endif; ?>
                    
                    <?php if (!empty($recipe['difficulty_level'])): ?>
                        <span class="difficulty <?php echo strtolower($recipe['difficulty_level']); ?>">
                            <?php echo htmlspecialchars($recipe['difficulty_level']); ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <div class="recipe-content">
                    <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                    
                    <p class="recipe-desc">
                        <?php 
                        $desc = !empty($recipe['description']) ? $recipe['description'] : 'A delicious recipe';
                        echo htmlspecialchars(substr($desc, 0, 120)) . (strlen($desc) > 120 ? '...' : ''); 
                        ?>
                    </p>
                    
                    <div class="recipe-meta">
                        <span><i class="fas fa-clock"></i> <?php echo (int)($recipe['cooking_time'] ?? 30); ?> min</span>
                        <span><i class="fas fa-users"></i> <?php echo (int)($recipe['servings'] ?? 4); ?> servings</span>
                    </div>
                    
                    <div class="recipe-author">
                        <i class="fas fa-user"></i> 
                        <?php echo htmlspecialchars($recipe['first_name'] ?? 'Chef'); ?>
                    </div>
                    
                    <a href="recipe-detail.php?id=<?php echo (int)$recipe['id']; ?>" class="view-recipe-btn">
                        View Recipe <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
    <?php else: ?>
        <div class="no-recipes">
            <i class="fas fa-utensils"></i>
            <h3>No Recipes Found</h3>
            <p>Be the first to add a recipe!</p>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="add-recipe.php" class="btn-primary">Add Your First Recipe</a>
            <?php else: ?>
                <a href="register.php" class="btn-primary">Join to Add Recipes</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
:root {
    --primary-orange: #FF6B00;
    --orange-light: #FF8E42;
    --orange-dark: #CC5500;
    --orange-bright: #FFA500;
    --orange-subtle: #FFE5CC;
}

.recipes-header {
    text-align: center;
    padding: 2.5rem 0;
    margin-bottom: 3rem;
    background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
    color: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(255, 107, 0, 0.3);
    margin-top: 20px;
}

.recipes-header h1 {
    color: white;
    font-size: 2.8rem;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.recipes-header p {
    color: rgba(255,255,255,0.95);
    font-size: 1.3rem;
    margin-bottom: 0;
    font-weight: 300;
    max-width: 700px;
    margin: 0 auto;
}

.recipes-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 50px;
}

@media (max-width: 992px) {
    .recipes-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }
}

@media (max-width: 768px) {
    .recipes-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

.recipe-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid #eee;
    display: block;
    border-top: 4px solid var(--primary-orange);
}

.recipe-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    border-color: var(--primary-orange);
}

.recipe-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.recipe-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.recipe-card:hover .recipe-image img {
    transform: scale(1.05);
}

.difficulty {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 6px 15px;
    border-radius: 5px;
    font-size: 0.8rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    z-index: 2;
}

.difficulty.easy { background: #4CAF50; }
.difficulty.medium { background: var(--primary-orange); }
.difficulty.hard { background: #f44336; }

.recipe-content {
    padding: 25px;
}

.recipe-content h3 {
    font-size: 1.3rem;
    color: #333;
    margin: 0 0 15px 0;
    line-height: 1.4;
    font-weight: 600;
}

.recipe-desc {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
    min-height: 4.5em;
}

.recipe-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    color: #777;
    font-size: 0.9rem;
}

.recipe-meta i {
    margin-right: 6px;
    color: var(--primary-orange);
}

.recipe-author {
    color: #555;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    border-top: 1px solid #eee;
    padding-top: 15px;
    margin-bottom: 15px;
}

.recipe-author i {
    color: var(--primary-orange);
}

.view-recipe-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary-orange);
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s;
}

.view-recipe-btn:hover {
    background: var(--orange-dark);
    gap: 12px;
}

.no-recipes {
    text-align: center;
    padding: 80px 30px;
    background: #f8f9fa;
    border-radius: 15px;
    border: 2px dashed #dee2e6;
    margin: 40px 0;
}

.no-recipes i {
    font-size: 4rem;
    color: var(--primary-orange);
    margin-bottom: 25px;
    opacity: 0.8;
}

.no-recipes h3 {
    color: #333;
    margin-bottom: 15px;
    font-size: 2rem;
}

.no-recipes p {
    color: #666;
    margin-bottom: 30px;
    font-size: 1.2rem;
}

.btn-primary {
    display: inline-block;
    background: var(--primary-orange);
    color: white;
    padding: 14px 35px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    font-size: 1.1rem;
}

.btn-primary:hover {
    background: var(--orange-dark);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(255, 107, 0, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.recipe-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>