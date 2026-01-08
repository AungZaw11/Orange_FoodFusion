<?php
$page_title = "Orange - Fresh Food Community";
include 'includes/header.php';
include 'includes/functions.php';
$featured_recipes = getFeaturedRecipes(6);
?>
<!-- Hero Section with Slider -->
<section class="hero-section">
<div class="slider-container">
<div class="slider">
<!-- Slide 1 - Main hero -->
<div class="slide active">
<img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=1400&auto=format&fit=crop&q=80"
alt="Delicious Food">
<div class="slide-overlay"></div>
<div class="slide-content">
<h1 class="hero-title">Welcome to <span class="highlight">Orange</span></h1>
<p class="hero-subtitle">Where food lovers connect, share, and create amazing recipes together</p>
<div class="hero-buttons">
<a href="recipes.php" class="btn btn-explore">
<i class="fas fa-utensils"></i> Explore Recipes
</a>
<button class="btn btn-join" onclick="openModal()">
<i class="fas fa-user-plus"></i> Join Free
</button>
</div>
</div>
</div>
<!-- Slide 2 - Community -->
<div class="slide">
<img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=1400&auto=format&fit=crop&q=80"
alt="Food Community">
<div class="slide-overlay"></div>
<div class="slide-content">
<h1 class="hero-title">Join Our <span class="highlight">Community</span></h1>
<p class="hero-subtitle">Share your recipes, learn from others, and grow together</p>
</div>
</div>
<!-- Slide 3 - Healthy -->
<div class="slide">
<img src="https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=1400&auto=format&fit=crop&q=80"
alt="Healthy Food">
<div class="slide-overlay"></div>
<div class="slide-content">
<h1 class="hero-title">Fresh & <span class="highlight">Healthy</span></h1>
<p class="hero-subtitle">Discover nutritious recipes for a healthier lifestyle</p>
</div>
</div>
</div>
<!-- Slider Navigation -->
<div class="slider-nav">
<div class="dots">
<span class="dot active"></span>
<span class="dot"></span>
<span class="dot"></span>
</div>
</div>
</div>
</section>

<!-- Modal Popup -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Join Orange Community</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="registerForm">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <button type="submit" class="btn btn-register">Create Account</button>
            </form>
        </div>
        <div class="modal-footer">
            <p>Already have an account? <a href="login.php">Sign in</a></p>
        </div>
    </div>
</div>

<!-- Stats Section -->
<section class="stats-section">
<div class="container">
<div class="stats-grid">
<div class="stat-item">
<div class="stat-number">5000+</div>
<div class="stat-label">Recipes</div>
</div>
<div class="stat-item">
<div class="stat-number">3000+</div>
<div class="stat-label">Community Members</div>
</div>
<div class="stat-item">
<div class="stat-number">2000+</div>
<div class="stat-label">Active Discussions</div>
</div>
<div class="stat-item">
<div class="stat-number">4500+</div>
<div class="stat-label">Cook Tips</div>
</div>
</div>
</div>
</section>
<!-- Features Section -->
<section class="features-section">
<div class="container">
<div class="section-header">
<h2>Why Choose <span class="highlight">Orange</span>?</h2>
<p>Everything you need for your culinary journey</p>
</div>
<div class="features-grid">
<div class="feature-card">
<div class="feature-icon">
<i class="fas fa-book-open"></i>
</div>
<h3>Recipe Collection</h3>
<p>Thousands of fresh recipes from different cuisines around the world</p>
<div class="feature-badges">
<span class="badge">Step-by-step</span>
<span class="badge">Clear instructions</span>
<span class="badge">Video tutorials</span>
</div>
</div>
<div class="feature-card">
<div class="feature-icon">
<i class="fas fa-users"></i>
</div>
<h3>Active Community</h3>
<p>Connect with food lovers, share tips, and get inspired daily</p>
<div class="feature-badges">
<span class="badge">Share recipes</span>
<span class="badge">Join discussions</span>
<span class="badge">Get feedback</span>
</div>
</div>
<div class="feature-card">
<div class="feature-icon">
<i class="fas fa-star"></i>
</div>
<h3>Cook Tips & Tricks</h3>
<p>Learn professional techniques from experienced home cooks</p>
<div class="feature-badges">
<span class="badge">Cooking techniques</span>
<span class="badge">Time-saving tips</span>
<span class="badge">Ingredient guides</span>
</div>
</div>
</div>
</div>
</section>
<!-- Featured Recipes Section -->
<section class="recipes-section">
<div class="container">
<div class="section-header">
<h2>Featured <span class="highlight">Recipes</span></h2>
<p>Discover our most popular recipes from the community</p>
</div>
<div class="recipes-grid">
<?php if ($featured_recipes && count($featured_recipes) > 0): ?>
<?php
// Sample recipes with UNIQUE Unsplash images (all different)
$sample_recipes = [
[
'id' => 1,
'title' => 'Classic Margherita Pizza',
'description' => 'Traditional Italian pizza with fresh basil and mozzarella cheese',
'image_url' => 'https://images.unsplash.com/photo-1604068549290-dea0e4a305ca?w=400&h=300&fit=crop&q=80&auto=format',
'prep_time' => '30',
'author' => 'Chef Maria',
'difficulty' => 'Medium'
],
[
'id' => 2,
'title' => 'Avocado Toast with Poached Eggs',
'description' => 'Healthy breakfast with creamy avocado and perfectly poached eggs',
'image_url' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=400&h=300&fit=crop&q=80&auto=format',
'prep_time' => '15',
'author' => 'Chef Alex',
'difficulty' => 'Easy'
],
[
'id' => 3,
'title' => 'Beef Wellington',
'description' => 'Classic British dish with tender beef wrapped in puff pastry',
'image_url' => 'https://images.unsplash.com/photo-1559715745-e1b33a271c8f?w=400&h=300&fit=crop&q=80&auto=format',
'prep_time' => '120',
'author' => 'Chef Gordon',
'difficulty' => 'Hard'
],
[
'id' => 4,
'title' => 'Vegetable Stir Fry',
'description' => 'Quick and healthy vegetable stir fry with Asian flavors',
'image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=300&fit=crop&q=80&auto=format',
'prep_time' => '20',
'author' => 'Chef Lisa',
'difficulty' => 'Easy'
],
[
'id' => 5,
'title' => 'Chocolate Lava Cake',
'description' => 'Decadent chocolate cake with a molten center',
'image_url' => 'https://images.unsplash.com/photo-1565800295-6ba3d5e5c7c4?w=400&h=300&fit=crop&q=80&auto=format',
'prep_time' => '45',
'author' => 'Chef Pierre',
'difficulty' => 'Medium'
],
[
'id' => 6,
'title' => 'Mediterranean Salad',
'description' => 'Fresh salad with Mediterranean ingredients and olive oil dressing',
'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&h=300&fit=crop&q=80&auto=format',
'prep_time' => '15',
'author' => 'Chef Sophia',
'difficulty' => 'Easy'
]
];
// Use database recipes or sample recipes
$recipes_to_display = (count($featured_recipes) > 0 && isset($featured_recipes[0]['title'])) ? $featured_recipes : $sample_recipes;
// SIMPLIFIED VERSION - Just use the image_url directly
foreach ($recipes_to_display as $index => $recipe):
// Safely get recipe data with fallbacks
$id = $recipe['id'] ?? $index + 1;
$title = htmlspecialchars($recipe['title'] ?? 'Delicious Recipe');
$description = htmlspecialchars($recipe['description'] ?? 'A tasty recipe from our community');
$prep_time = $recipe['prep_time'] ?? '30';
$author = htmlspecialchars($recipe['author'] ?? 'Community Member');
$difficulty = $recipe['difficulty'] ?? 'Medium';
// Get image - use image_url if exists, otherwise use fallback
if (isset($recipe['image_url']) && !empty($recipe['image_url'])) {
$image = $recipe['image_url'];
} else {
// Fallback images for each type
$fallback_images = [
'pizza' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400&h=300&fit=crop&q=80',
'avocado' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=400&h=300&fit=crop&q=80',
'beef' => 'https://images.unsplash.com/photo-1559715745-e1b33a271c8f?w=400&h=300&fit=crop&q=80',
'vegetable' => 'https://images.unsplash.com/photo-1546069901-dc8d074b6a58?w=400&h=300&fit=crop&q=80',
'chocolate' => 'https://images.unsplash.com/photo-1565800295-6ba3d5e5c7c4?w=400&h=300&fit=crop&q=80',
'salad' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&h=300&fit=crop&q=80'
];
$image_found = false;
foreach ($fallback_images as $key => $fallback_image) {
if (stripos(strtolower($title), $key) !== false) {
$image = $fallback_image;
$image_found = true;
break;
}
}
if (!$image_found) {
// Default food image
$image = 'https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=400&h=300&fit=crop&q=80';
}
}
?>
<div class="recipe-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
<div class="recipe-image">
<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" loading="lazy"
onerror="this.src='https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=400&h=300&fit=crop&q=80'">
<div class="recipe-overlay">
<a href="recipe-detail.php?id=<?php echo $id; ?>" class="view-recipe">
<i class="fas fa-eye"></i> View Recipe
</a>
</div>
<div class="difficulty-badge <?php echo strtolower($difficulty); ?>">
<?php echo $difficulty; ?>
</div>
</div>
<div class="recipe-info">
<h3><?php echo $title; ?></h3>
<div class="recipe-meta">
<span class="meta-item">
<i class="fas fa-clock"></i>
<span><?php echo $prep_time; ?> min</span>
</span>
<span class="meta-item">
<i class="fas fa-user"></i>
<span><?php echo $author; ?></span>
</span>
<span class="meta-item">
<i class="fas fa-fire"></i>
<span><?php echo $difficulty; ?></span>
</span>
</div>
<p class="recipe-description"><?php echo substr($description, 0, 80); ?>...</p>
<div class="recipe-actions">
<a href="recipe-detail.php?id=<?php echo $id; ?>" class="btn-cook">
<i class="fas fa-utensils"></i>
<span>Cook Now</span>
</a>
<button class="btn-save" data-recipe-id="<?php echo $id; ?>">
<i class="far fa-heart"></i>
</button>
</div>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="no-recipes">
<div class="no-recipes-icon">
<i class="fas fa-utensils"></i>
</div>
<h3>No Featured Recipes Yet</h3>
<p>Be the first to share your recipe with the community!</p>
<a href="add-recipe.php" class="btn-add-recipe">
<i class="fas fa-plus"></i> Add Your Recipe
</a>
</div>
<?php endif; ?>
</div>
<div class="view-all-container" data-aos="fade-up">
<a href="recipes.php" class="view-all-btn">
View All Recipes
<i class="fas fa-arrow-right"></i>
</a>
</div>
</div>
</section>
<!-- Community Preview Section -->
<section class="community-preview">
<div class="container">
<div class="community-content">
<div class="community-text" data-aos="fade-right">
<h2>Join Our Growing <span class="highlight">Community</span></h2>
<p>Connect with thousands of food lovers sharing their passion for cooking. Whether you're a beginner or a pro chef, there's a place for you here.</p>
<div class="community-features">
<div class="feature" data-aos="fade-up" data-aos-delay="100">
<div class="feature-icon-circle">
<i class="fas fa-comments"></i>
</div>
<div class="feature-text">
<h4>Active Discussions</h4>
<p>Join daily conversations about food and cooking</p>
</div>
</div>
<div class="feature" data-aos="fade-up" data-aos-delay="200">
<div class="feature-icon-circle">
<i class="fas fa-trophy"></i>
</div>
<div class="feature-text">
<h4>Cooking Challenges</h4>
<p>Participate in weekly cooking competitions</p>
</div>
</div>
<div class="feature" data-aos="fade-up" data-aos-delay="300">
<div class="feature-icon-circle">
<i class="fas fa-book"></i>
</div>
<div class="feature-text">
<h4>Cooking Tutorials</h4>
<p>Learn from step-by-step video guides</p>
</div>
</div>
<div class="feature" data-aos="fade-up" data-aos-delay="400">
<div class="feature-icon-circle">
<i class="fas fa-video"></i>
</div>
<div class="feature-text">
<h4>Live Sessions</h4>
<p>Watch live cooking demonstrations</p>
</div>
</div>
</div>
<a href="cookbook.php" class="btn btn-community" data-aos="fade-up" data-aos-delay="500">
<i class="fas fa-users"></i> Visit Community
</a>
</div>
<div class="community-image" data-aos="fade-left">
<img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Food Community">
</div>
</div>
</div>
</section>
<!-- Newsletter Section -->
<section class="newsletter-section">
<div class="container">
<div class="newsletter-content" data-aos="fade-up">
<div class="newsletter-icon">
<i class="fas fa-envelope-open-text"></i>
</div>
<h2>Stay Updated</h2>
<p>Subscribe to our newsletter for weekly recipes, cooking tips, and community updates</p>
<form class="newsletter-form">
<div class="form-group">
<input type="email" placeholder="Your email address" required>
<button type="submit" class="btn-subscribe">
<i class="fas fa-paper-plane"></i> Subscribe
</button>
</div>
<p class="form-note">No spam, just delicious updates. Unsubscribe anytime.</p>
</form>
</div>
</div>
</section>
<!-- CTA Section -->
<section class="cta-section">
<div class="container">
<div class="cta-content" data-aos="fade-up">
<h2>Ready to Start Your <span class="highlight">Culinary Journey</span>?</h2>
<p>Join thousands of food lovers sharing their culinary creations and discover new recipes every day</p>
<div class="cta-actions">
<a href="recipes.php" class="btn btn-light">
<i class="fas fa-utensils"></i>
Browse Recipes
</a>
<?php if (!isset($_SESSION['user_id'])): ?>
<button class="btn btn-outline-light" onclick="openModal()">
<i class="fas fa-user-plus"></i>
Create Free Account
</button>
<?php else: ?>
<a href="add-recipe.php" class="btn btn-outline-light">
<i class="fas fa-plus"></i>
Share Your Recipe
</a>
<?php endif; ?>
</div>
</div>
</div>
</section>
<!-- AOS CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
:root {
--primary-orange: #FF6B00;
--orange-light: #FF8E42;
--orange-dark: #CC5500;
--orange-gradient: linear-gradient(135deg, #FF6B00, #FF8E42);
--orange-subtle: rgba(255, 107, 0, 0.1);
--orange-pale: #FFF3E8;
--success: #10B981;
--info: #3B82F6;
--warning: #F59E0B;
--error: #EF4444;
--gray-50: #f9fafb;
--gray-100: #f3f4f6;
--gray-200: #e5e7eb;
--gray-300: #d1d5db;
--gray-400: #9ca3af;
--gray-500: #6b7280;
--gray-600: #4b5563;
--gray-700: #374151;
--gray-800: #1f2937;
--shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
--shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
--shadow-lg: 0 10px 25px -5px rgba(0,0,0,0.1);
--shadow-xl: 0 20px 40px -10px rgba(0,0,0,0.15);
--border-radius: 12px;
--border-radius-lg: 20px;
--transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    animation: fadeIn 0.3s ease;
    overflow-y: auto;
}

.modal-content {
    background-color: white;
    margin: 0; /* Remove margin */
    padding: 0;
    border-radius: var(--border-radius-lg);
    width: 100%; /* Full width */
    max-width: 500px;
    box-shadow: var(--shadow-xl);
    position: relative;
    animation: slideIn 0.3s ease;
    max-height: 90vh;
    overflow-y: auto;
    /* Center horizontally on desktop */
    margin: 0 auto;
    /* On mobile, use 95% width */
}

.modal-header {
    padding: 20px 25px;
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
    color: white;
    border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.close {
    color: white;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: var(--transition);
}

.close:hover {
    color: #f8f9fa;
    transform: scale(1.1);
}

.modal-body {
    padding: 25px;
    max-height: 60vh;
    overflow-y: auto;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--gray-700);
}

.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--gray-300);
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    box-sizing: border-box;
}

.form-group input:focus {
    outline: none;
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.1);
}

.btn-register {
    background: var(--orange-gradient);
    color: white;
    border: none;
    padding: 14px 25px;
    border-radius: var(--border-radius);
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: var(--transition);
}

.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 0, 0.3);
}

.modal-footer {
    padding: 15px 25px 25px;
    text-align: center;
    border-top: 1px solid var(--gray-200);
}

.modal-footer p {
    margin: 0;
    color: var(--gray-600);
}

.modal-footer a {
    color: var(--primary-orange);
    text-decoration: none;
    font-weight: 600;
}

.modal-footer a:hover {
    text-decoration: underline;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Hero Section */
.hero-section {
position: relative;
height: 600px;
overflow: hidden;
border-radius: 0 0 30px 30px;
box-shadow: var(--shadow-lg);
}
.slider-container {
position: relative;
width: 100%;
height: 100%;
}
.slider {
position: relative;
width: 100%;
height: 100%;
}
.slide {
position: absolute;
width: 100%;
height: 100%;
opacity: 0;
transition: opacity 1s ease;
}
.slide.active {
opacity: 1;
}
.slide img {
width: 100%;
height: 100%;
object-fit: cover;
transform: scale(1.1);
transition: transform 8s ease;
}
.slide.active img {
transform: scale(1);
}
.slide-overlay {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: linear-gradient(135deg, rgba(0,0,0,0.6), rgba(255, 107, 0, 0.4));
}
.slide-content {
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
text-align: center;
color: white;
width: 100%;
padding: 0 20px;
z-index: 2;
}
.hero-title {
font-size: 3.5rem;
font-weight: 800;
margin-bottom: 20px;
line-height: 1.2;
text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}
.highlight {
color: #FFD700;
position: relative;
display: inline-block;
}
.highlight::after {
content: '';
position: absolute;
bottom: 5px;
left: 0;
width: 100%;
height: 8px;
background: var(--orange-gradient);
opacity: 0.7;
z-index: -1;
border-radius: 4px;
}
.hero-subtitle {
font-size: 1.3rem;
max-width: 600px;
margin: 0 auto 30px;
line-height: 1.6;
opacity: 0.95;
font-weight: 300;
}
.hero-buttons {
display: flex;
gap: 20px;
justify-content: center;
flex-wrap: wrap;
}
.btn {
padding: 16px 36px;
border-radius: 50px;
font-weight: 600;
text-decoration: none;
display: inline-flex;
align-items: center;
gap: 12px;
transition: var(--transition);
font-size: 1.1rem;
border: none;
cursor: pointer;
position: relative;
overflow: hidden;
}
.btn::before {
content: '';
position: absolute;
top: 0;
left: -100%;
width: 100%;
height: 100%;
background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
transition: left 0.5s ease;
}
.btn:hover::before {
left: 100%;
}
.btn-explore {
background: var(--orange-gradient);
color: white;
box-shadow: 0 4px 20px rgba(255, 107, 0, 0.4);
}
.btn-join {
background: rgba(255, 255, 255, 0.15);
color: white;
border: 2px solid rgba(255, 255, 255, 0.3);
backdrop-filter: blur(10px);
}
.btn-explore:hover {
transform: translateY(-3px);
box-shadow: 0 8px 30px rgba(255, 107, 0, 0.5);
}
.btn-join:hover {
background: rgba(255, 255, 255, 0.25);
transform: translateY(-3px);
border-color: rgba(255, 255, 255, 0.5);
}
.slider-nav {
position: absolute;
bottom: 40px;
left: 50%;
transform: translateX(-50%);
z-index: 3;
}
.dots {
display: flex;
gap: 15px;
}
.dot {
width: 14px;
height: 14px;
border-radius: 50%;
background: rgba(255, 255, 255, 0.5);
cursor: pointer;
transition: var(--transition);
border: 2px solid transparent;
}
.dot.active {
background: white;
transform: scale(1.3);
border-color: var(--primary-orange);
}
/* Stats Section */
.stats-section {
padding: 80px 0;
background: linear-gradient(135deg, var(--gray-50), var(--orange-pale));
position: relative;
overflow: hidden;
}
.stats-section::before {
content: '';
position: absolute;
top: 0;
left: 0;
right: 0;
height: 4px;
background: var(--orange-gradient);
}
.stats-grid {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
gap: 30px;
max-width: 1200px;
margin: 0 auto;
}
.stat-item {
text-align: center;
padding: 40px 30px;
background: white;
border-radius: var(--border-radius-lg);
box-shadow: var(--shadow-md);
transition: var(--transition);
border: 2px solid transparent;
position: relative;
}
.stat-item::before {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 5px;
background: var(--orange-gradient);
border-radius: 5px 5px 0 0;
opacity: 0;
transition: opacity 0.3s ease;
}
.stat-item:hover {
transform: translateY(-10px);
box-shadow: var(--shadow-xl);
border-color: var(--orange-subtle);
}
.stat-item:hover::before {
opacity: 1;
}
.stat-number {
font-size: 2.8rem;
font-weight: 800;
color: var(--primary-orange);
margin-bottom: 10px;
line-height: 1;
background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}
.stat-label {
font-size: 1.1rem;
color: var(--gray-700);
font-weight: 600;
text-transform: uppercase;
letter-spacing: 0.5px;
}
/* Section Header */
.section-header {
text-align: center;
margin-bottom: 60px;
}
.section-header h2 {
font-size: 2.8rem;
font-weight: 800;
color: var(--gray-800);
margin-bottom: 20px;
line-height: 1.2;
}
.section-header p {
font-size: 1.2rem;
color: var(--gray-600);
max-width: 600px;
margin: 0 auto;
line-height: 1.6;
}
/* Features Section */
.features-section {
padding: 100px 0;
background: white;
position: relative;
}
.features-grid {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
gap: 30px;
}
.feature-card {
background: white;
border-radius: var(--border-radius-lg);
padding: 40px 30px;
text-align: center;
box-shadow: var(--shadow-md);
transition: var(--transition);
border: 2px solid transparent;
position: relative;
overflow: hidden;
}
.feature-card::before {
content: '';
position: absolute;
top: 0;
left: 0;
right: 0;
height: 4px;
background: var(--orange-gradient);
transform: translateY(-100%);
transition: transform 0.3s ease;
}
.feature-card:hover {
transform: translateY(-10px);
box-shadow: var(--shadow-xl);
border-color: var(--orange-subtle);
}
.feature-card:hover::before {
transform: translateY(0);
}
.feature-icon {
width: 90px;
height: 90px;
background: var(--orange-gradient);
border-radius: 25px;
display: flex;
align-items: center;
justify-content: center;
color: white;
font-size: 2.8rem;
margin: 0 auto 30px;
transition: var(--transition);
box-shadow: 0 10px 20px rgba(255, 107, 0, 0.3);
}
.feature-card:hover .feature-icon {
transform: rotate(10deg) scale(1.1);
}
.feature-card h3 {
font-size: 1.5rem;
color: var(--gray-800);
margin-bottom: 15px;
font-weight: 700;
}
.feature-card p {
color: var(--gray-600);
line-height: 1.6;
margin-bottom: 25px;
font-size: 1rem;
}
.feature-badges {
display: flex;
gap: 10px;
justify-content: center;
flex-wrap: wrap;
}
.badge {
padding: 6px 14px;
background: var(--orange-subtle);
color: var(--primary-orange);
border-radius: 20px;
font-size: 0.85rem;
font-weight: 600;
transition: var(--transition);
}
.feature-card:hover .badge {
background: var(--primary-orange);
color: white;
}
/* Recipes Section */
.recipes-section {
padding: 100px 0;
background: linear-gradient(135deg, var(--gray-50), white);
}
.recipes-grid {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
gap: 30px;
margin-bottom: 50px;
}
.recipe-card {
background: white;
border-radius: var(--border-radius-lg);
overflow: hidden;
box-shadow: var(--shadow-md);
transition: var(--transition);
border: 2px solid transparent;
position: relative;
}
.recipe-card:hover {
transform: translateY(-10px);
box-shadow: var(--shadow-xl);
border-color: var(--orange-subtle);
}
.recipe-image {
position: relative;
height: 220px;
overflow: hidden;
}
.recipe-image img {
width: 100%;
height: 100%;
object-fit: cover;
transition: transform 0.5s ease;
}
.recipe-card:hover .recipe-image img {
transform: scale(1.1);
}
.recipe-overlay {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: rgba(0, 0, 0, 0.6);
display: flex;
align-items: center;
justify-content: center;
opacity: 0;
transition: opacity 0.3s ease;
}
.recipe-card:hover .recipe-overlay {
opacity: 1;
}
.view-recipe {
color: white;
text-decoration: none;
font-weight: 600;
display: flex;
align-items: center;
gap: 10px;
padding: 12px 24px;
background: var(--orange-gradient);
border-radius: 25px;
transition: var(--transition);
}
.view-recipe:hover {
transform: scale(1.05);
box-shadow: 0 4px 15px rgba(255, 107, 0, 0.4);
}
.difficulty-badge {
position: absolute;
top: 15px;
right: 15px;
padding: 6px 15px;
border-radius: 20px;
font-size: 0.8rem;
font-weight: 700;
color: white;
z-index: 2;
}
.difficulty-badge.easy {
background: var(--success);
}
.difficulty-badge.medium {
background: var(--warning);
}
.difficulty-badge.hard {
background: var(--error);
}
.recipe-info {
padding: 25px;
}
.recipe-info h3 {
font-size: 1.4rem;
color: var(--gray-800);
margin-bottom: 15px;
font-weight: 700;
line-height: 1.3;
}
.recipe-meta {
display: flex;
gap: 20px;
margin-bottom: 15px;
flex-wrap: wrap;
}
.meta-item {
display: flex;
align-items: center;
gap: 6px;
color: var(--gray-600);
font-size: 0.9rem;
font-weight: 500;
}
.meta-item i {
color: var(--primary-orange);
font-size: 0.9rem;
}
.recipe-description {
color: var(--gray-600);
line-height: 1.6;
margin-bottom: 20px;
font-size: 0.95rem;
display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
}
.recipe-actions {
display: flex;
justify-content: space-between;
align-items: center;
}
.btn-cook {
background: var(--orange-gradient);
color: white;
padding: 12px 25px;
border-radius: 25px;
text-decoration: none;
font-weight: 600;
display: flex;
align-items: center;
gap: 10px;
transition: var(--transition);
flex: 1;
margin-right: 15px;
justify-content: center;
}
.btn-cook:hover {
transform: translateY(-2px);
box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
}
.btn-save {
width: 50px;
height: 50px;
background: white;
border: 2px solid var(--gray-300);
color: var(--gray-400);
border-radius: 50%;
font-size: 1.2rem;
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
transition: var(--transition);
}
.btn-save:hover {
border-color: var(--primary-orange);
color: var(--primary-orange);
transform: scale(1.1);
}
.btn-save.active {
background: var(--primary-orange);
border-color: var(--primary-orange);
color: white;
}
.no-recipes {
text-align: center;
padding: 60px 40px;
grid-column: 1 / -1;
}
.no-recipes-icon {
width: 100px;
height: 100px;
background: var(--orange-subtle);
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
font-size: 3rem;
color: var(--primary-orange);
margin: 0 auto 25px;
}
.no-recipes h3 {
font-size: 1.8rem;
color: var(--gray-800);
margin-bottom: 15px;
font-weight: 700;
}
.no-recipes p {
color: var(--gray-600);
margin-bottom: 30px;
font-size: 1.1rem;
}
.btn-add-recipe {
background: var(--orange-gradient);
color: white;
padding: 15px 35px;
border-radius: 25px;
text-decoration: none;
font-weight: 600;
display: inline-flex;
align-items: center;
gap: 10px;
transition: var(--transition);
}
.btn-add-recipe:hover {
transform: translateY(-3px);
box-shadow: 0 8px 25px rgba(255, 107, 0, 0.3);
}
.view-all-container {
text-align: center;
}
.view-all-btn {
display: inline-flex;
align-items: center;
gap: 12px;
color: var(--primary-orange);
text-decoration: none;
font-weight: 700;
font-size: 1.1rem;
padding: 16px 40px;
border: 2px solid var(--primary-orange);
border-radius: 50px;
transition: var(--transition);
position: relative;
overflow: hidden;
}
.view-all-btn::before {
content: '';
position: absolute;
top: 0;
left: -100%;
width: 100%;
height: 100%;
background: var(--orange-gradient);
transition: left 0.3s ease;
z-index: -1;
}
.view-all-btn:hover {
color: white;
gap: 15px;
}
.view-all-btn:hover::before {
left: 0;
}
/* Community Preview */
.community-preview {
padding: 100px 0;
background: white;
}
.community-content {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 80px;
align-items: center;
}
.community-text h2 {
font-size: 2.8rem;
color: var(--gray-800);
margin-bottom: 25px;
line-height: 1.2;
}
.community-text p {
color: var(--gray-600);
line-height: 1.6;
margin-bottom: 40px;
font-size: 1.1rem;
}
.community-features {
display: flex;
flex-direction: column;
gap: 20px;
margin-bottom: 40px;
}
.feature {
display: flex;
align-items: center;
gap: 20px;
padding: 20px;
background: var(--gray-50);
border-radius: var(--border-radius);
transition: var(--transition);
border: 2px solid transparent;
}
.feature:hover {
transform: translateX(10px);
background: white;
border-color: var(--orange-subtle);
box-shadow: var(--shadow-md);
}
.feature-icon-circle {
width: 60px;
height: 60px;
background: var(--orange-gradient);
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
color: white;
font-size: 1.5rem;
flex-shrink: 0;
}
.feature-text h4 {
font-size: 1.2rem;
color: var(--gray-800);
margin-bottom: 5px;
font-weight: 600;
}
.feature-text p {
color: var(--gray-600);
margin: 0;
font-size: 0.95rem;
}
.btn-community {
background: var(--orange-gradient);
color: white;
padding: 16px 40px;
border-radius: 50px;
text-decoration: none;
display: inline-flex;
align-items: center;
gap: 12px;
font-weight: 700;
transition: var(--transition);
box-shadow: 0 4px 20px rgba(255, 107, 0, 0.3);
}
.btn-community:hover {
transform: translateY(-3px);
box-shadow: 0 8px 30px rgba(255, 107, 0, 0.4);
gap: 15px;
}
.community-image {
border-radius: var(--border-radius-lg);
overflow: hidden;
box-shadow: var(--shadow-xl);
position: relative;
}
.community-image::before {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: var(--orange-gradient);
opacity: 0.1;
z-index: 1;
}
.community-image img {
width: 100%;
height: 500px;
object-fit: cover;
transition: transform 0.8s ease;
}
.community-image:hover img {
transform: scale(1.05);
}
/* Newsletter Section */
.newsletter-section {
padding: 100px 0;
background: linear-gradient(135deg, var(--gray-50), var(--orange-pale));
text-align: center;
}
.newsletter-content {
max-width: 700px;
margin: 0 auto;
}
.newsletter-icon {
width: 100px;
height: 100px;
background: var(--orange-gradient);
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
color: white;
font-size: 3rem;
margin: 0 auto 30px;
box-shadow: 0 10px 25px rgba(255, 107, 0, 0.3);
}
.newsletter-content h2 {
font-size: 2.5rem;
color: var(--gray-800);
margin-bottom: 20px;
font-weight: 700;
}
.newsletter-content p {
color: var(--gray-600);
margin-bottom: 40px;
font-size: 1.1rem;
line-height: 1.6;
}
.newsletter-form {
max-width: 500px;
margin: 0 auto;
}
.newsletter-form .form-group {
display: flex;
gap: 10px;
margin-bottom: 15px;
}
.newsletter-form input {
flex: 1;
padding: 16px 25px;
border: 2px solid var(--gray-300);
border-radius: 50px;
font-size: 1rem;
transition: var(--transition);
}
.newsletter-form input:focus {
outline: none;
border-color: var(--primary-orange);
box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.1);
}
.btn-subscribe {
background: var(--orange-gradient);
color: white;
border: none;
padding: 16px 35px;
border-radius: 50px;
font-weight: 600;
cursor: pointer;
display: flex;
align-items: center;
gap: 10px;
transition: var(--transition);
}
.btn-subscribe:hover {
transform: translateY(-2px);
box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
}
.form-note {
font-size: 0.9rem;
color: var(--gray-500);
line-height: 1.6;
}
/* CTA Section */
.cta-section {
padding: 100px 0;
background: linear-gradient(135deg, var(--primary-orange), var(--orange-dark));
color: white;
text-align: center;
position: relative;
overflow: hidden;
}
.cta-section::before {
content: '';
position: absolute;
top: 0;
left: 0;
right: 0;
bottom: 0;
background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.05)"/></svg>');
background-size: cover;
}
.cta-content {
position: relative;
z-index: 2;
}
.cta-content h2 {
font-size: 3rem;
margin-bottom: 25px;
font-weight: 800;
line-height: 1.2;
text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}
.cta-content p {
font-size: 1.3rem;
opacity: 0.95;
max-width: 700px;
margin: 0 auto 50px;
line-height: 1.6;
font-weight: 300;
}
.cta-actions {
display: flex;
gap: 25px;
justify-content: center;
flex-wrap: wrap;
}
.btn-light {
background: white;
color: var(--primary-orange);
box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
}
.btn-outline-light {
background: transparent;
border: 2px solid white;
color: white;
box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
}
.btn-light:hover {
background: #f8f9fa;
transform: translateY(-3px);
box-shadow: 0 8px 30px rgba(255, 255, 255, 0.3);
}
.btn-outline-light:hover {
background: white;
color: var(--primary-orange);
transform: translateY(-3px);
box-shadow: 0 8px 30px rgba(255, 255, 255, 0.2);
}
/* Responsive Design */
@media (max-width: 1200px) {
.hero-title {
font-size: 3rem;
}
.community-content {
gap: 50px;
}
}
@media (max-width: 992px) {
.hero-section {
height: 550px;
}
.hero-title {
font-size: 2.5rem;
}
.hero-subtitle {
font-size: 1.1rem;
}
.community-content {
grid-template-columns: 1fr;
gap: 40px;
}
.community-text {
text-align: center;
}
.feature {
max-width: 400px;
margin: 0 auto;
}
.section-header h2 {
font-size: 2.2rem;
}
}
@media (max-width: 768px) {
.hero-section {
height: 500px;
}
.hero-title {
font-size: 2.2rem;
}
.hero-buttons {
flex-direction: column;
align-items: center;
gap: 15px;
}
.btn {
width: 100%;
max-width: 300px;
justify-content: center;
}
.stats-grid {
grid-template-columns: repeat(2, 1fr);
}
.features-grid,
.recipes-grid {
grid-template-columns: 1fr;
}
.newsletter-form .form-group {
flex-direction: column;
}
.btn-subscribe {
justify-content: center;
}
.cta-actions {
flex-direction: column;
align-items: center;
}
.cta-content h2 {
font-size: 2.2rem;
}
.cta-content p {
font-size: 1.1rem;
}
/* Mobile Modal Fixes */
.modal-content {
    width: 95%;
    max-width: none;
    margin: 2.5% auto;
    max-height: 95vh;
}
.modal-body {
    max-height: 65vh;
}
}
@media (max-width: 576px) {
.hero-section {
height: 450px;
}
.hero-title {
font-size: 1.8rem;
}
.hero-subtitle {
font-size: 1rem;
}
.stats-grid {
grid-template-columns: 1fr;
}
.stat-number {
font-size: 2.2rem;
}
.section-header h2 {
font-size: 1.8rem;
}
.community-features .feature {
flex-direction: column;
text-align: center;
gap: 15px;
}
.feature-icon-circle {
width: 50px;
height: 50px;
font-size: 1.2rem;
}
}
</style>
<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
// Initialize AOS
AOS.init({
duration: 800,
once: true,
offset: 100
});
// Slider functionality
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
let currentSlide = 0;
let slideInterval;
function showSlide(index) {
slides.forEach(slide => slide.classList.remove('active'));
dots.forEach(dot => dot.classList.remove('active'));
slides[index].classList.add('active');
dots[index].classList.add('active');
currentSlide = index;
}
function nextSlide() {
currentSlide = (currentSlide + 1) % slides.length;
showSlide(currentSlide);
}
function startSlider() {
slideInterval = setInterval(nextSlide, 5000);
}
function stopSlider() {
clearInterval(slideInterval);
}
dots.forEach((dot, index) => {
dot.addEventListener('click', () => {
showSlide(index);
stopSlider();
startSlider();
});
});
const slider = document.querySelector('.slider-container');
slider.addEventListener('mouseenter', stopSlider);
slider.addEventListener('mouseleave', startSlider);
startSlider();
// Save button functionality
document.querySelectorAll('.btn-save').forEach(btn => {
btn.addEventListener('click', function() {
const recipeId = this.getAttribute('data-recipe-id');
const icon = this.querySelector('i');
this.classList.toggle('active');
if (this.classList.contains('active')) {
icon.classList.remove('far');
icon.classList.add('fas');
// Add to favorites (AJAX call here)
console.log(`Saved recipe ${recipeId}`);
} else {
icon.classList.remove('fas');
icon.classList.add('far');
// Remove from favorites (AJAX call here)
console.log(`Removed recipe ${recipeId} from favorites`);
}
});
});
// Newsletter form submission
const newsletterForm = document.querySelector('.newsletter-form');
if (newsletterForm) {
newsletterForm.addEventListener('submit', function(e) {
e.preventDefault();
const submitBtn = this.querySelector('.btn-subscribe');
const originalText = submitBtn.innerHTML;
const email = this.querySelector('input').value;
// Show loading state
submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
submitBtn.disabled = true;
// Simulate API call
setTimeout(() => {
submitBtn.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
submitBtn.style.background = 'var(--success)';
this.reset();
// Reset button after 2 seconds
setTimeout(() => {
submitBtn.innerHTML = originalText;
submitBtn.style.background = '';
submitBtn.disabled = false;
}, 2000);
}, 1500);
});
}
// Add hover effect to feature cards
const featureCards = document.querySelectorAll('.feature-card');
featureCards.forEach(card => {
card.addEventListener('mouseenter', function() {
const icon = this.querySelector('.feature-icon');
icon.style.transform = 'rotate(10deg) scale(1.1)';
});
card.addEventListener('mouseleave', function() {
const icon = this.querySelector('.feature-icon');
icon.style.transform = 'rotate(0) scale(1)';
});
});
});

// Modal functions
function openModal() {
    document.getElementById('registerModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('registerModal').style.display = 'none';
}

// Close modal if clicked outside content
window.onclick = function(event) {
    const modal = document.getElementById('registerModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

// Form submission
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Add your form submission logic here
    alert('Registration form submitted!');
    closeModal();
});

// Mobile optimization - Adjust modal width
function adjustModalWidth() {
    const modalContent = document.querySelector('.modal-content');
    if (window.innerWidth <= 768) {
        modalContent.style.width = '95%';
        modalContent.style.maxWidth = 'none';
        modalContent.style.margin = '2.5% auto';
    } else {
        modalContent.style.width = '90%';
        modalContent.style.maxWidth = '500px';
        modalContent.style.margin = '5% auto';
    }
}

// Adjust modal width on resize
window.addEventListener('resize', adjustModalWidth);

// Initial adjustment
adjustModalWidth();
</script>
<?php include 'includes/footer.php'; ?>