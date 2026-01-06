<?php
ob_start(); 
$page_title = "Community - Orange";
include 'includes/header.php';
include 'config/database.php';

// Check login status safely
$is_logged_in = isset($_SESSION['user_id']);
$first_name = $is_logged_in ? ($_SESSION['user_first_name'] ?? 'Friend') : 'Guest';

$database = new Database();
$db = $database->getConnection();

// Get community stats
$stats_query = "SELECT 
                COUNT(DISTINCT user_id) as total_members,
                COUNT(*) as total_posts,
                COUNT(DISTINCT category) as active_categories
                FROM community_posts";
$stats_stmt = $db->query($stats_query);
$stats = $stats_stmt->fetch(PDO::FETCH_ASSOC);

// Get recent posts (limit to 3)
$posts_query = "SELECT cp.*, u.first_name, u.last_name 
                FROM community_posts cp 
                JOIN users u ON cp.user_id = u.id 
                ORDER BY cp.created_at DESC 
                LIMIT 3";
$posts_stmt = $db->query($posts_query);
$recent_posts = $posts_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container main-content">
    <div class="community-page">
        <!-- Hero Section -->
        <div class="community-hero">
            <div class="hero-content">
                <h1 class="hero-title">Welcome To Orange Community</h1>
                <p class="hero-subtitle">Join thousands of food lovers sharing recipes, tips, and culinary adventures</p>
                <div class="hero-stats">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">2000+</span>
                            <span class="stat-label">Active Discussions</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">4500+</span>
                            <span class="stat-label">Topics</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Cooking Community">
            </div>
        </div>

        <!-- Main Content -->
        <div class="community-main">
            <!-- Share Section -->
            <section class="share-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <div>
                        <h2>Share Your Culinary Journey</h2>
                        <p>Join the conversation and inspire others with your food stories</p>
                    </div>
                </div>

                <div class="share-card">
                    <div class="card-content">
                        <?php if ($is_logged_in): ?>
                            <?php $initial = strtoupper(substr($first_name, 0, 1)); ?>
                            <div class="user-welcome">
                                <div class="user-avatar">
                                    <span><?php echo htmlspecialchars($initial); ?></span>
                                </div>
                                <div class="welcome-text">
                                    <h3>Welcome back, <?php echo htmlspecialchars($first_name); ?>!</h3>
                                    <p>Ready to share your latest culinary creation?</p>
                                </div>
                            </div>
                            <a href="create_post.php" class="create-post-btn">
                                <i class="fas fa-plus-circle"></i>
                                Create New Post
                            </a>
                        <?php else: ?>
                            <div class="auth-prompt">
                                <div class="prompt-icon">
                                    <i class="fas fa-comment-medical"></i>
                                </div>
                                <h3>Join the Conversation</h3>
                                <p>Login to share recipes, ask questions, and connect with fellow food enthusiasts</p>
                                <div class="auth-buttons">
                                    <a href="login.php" class="btn btn-login">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login to Post
                                    </a>
                                    <a href="register.php" class="btn btn-join">
                                        <i class="fas fa-user-plus"></i>
                                        Join Community
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Recent Discussions -->
            <section class="discussions-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div>
                        <h2>Recent Community Cook Tips</h2>
                        <p>See what our community is talking about</p>
                    </div>
                </div>

                <div class="discussions-grid">
                    <?php if (!empty($recent_posts)): ?>
                        <?php foreach ($recent_posts as $index => $post): ?>
                            <div class="discussion-card" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                                <div class="card-header">
                                    <div class="author-info">
                                        <div class="author-avatar">
                                            <?php 
                                            $first = substr($post['first_name'], 0, 1);
                                            $last = substr($post['last_name'], 0, 1);
                                            $initials = strtoupper($first . $last);
                                            ?>
                                            <span><?php echo htmlspecialchars($initials); ?></span>
                                        </div>
                                        <div class="author-details">
                                            <h4><?php echo htmlspecialchars($post['first_name'] . ' ' . $post['last_name']); ?></h4>
                                            <span class="post-time"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                                        </div>
                                    </div>
                                    <span class="category-badge">
                                        <?php echo ($post['category'] == 'tip') ? 'Cook Tip' : htmlspecialchars(ucfirst($post['category'])); ?>
                                    </span>
                                </div>
                                
                                <h3 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p class="post-excerpt"><?php echo htmlspecialchars(substr($post['content'], 0, 120)); ?>...</p>
                                
                                <div class="post-stats">
                                    <span class="stat"><i class="far fa-comment"></i> 12</span>
                                    <span class="stat"><i class="far fa-heart"></i> 24</span>
                                    <span class="stat"><i class="far fa-eye"></i> 156</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-discussions">
                            <i class="fas fa-comments"></i>
                            <h3>Be the first to start a discussion!</h3>
                            <p>Share your first recipe or cooking question with the community</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="view-all-container">
                    <a href="#" class="view-all-btn">
                        Browse All Cook Tips
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </section>

            <!-- Features Section -->
            <section class="features-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h2>Why Join Our Community?</h2>
                        <p>Discover what makes our food community special</p>
                    </div>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3>Recipe Sharing</h3>
                        <p>Share your favorite recipes and discover new ones from home cooks worldwide</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3>Cooking Challenges</h3>
                        <p>Participate in monthly challenges and showcase your culinary creativity</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <h3>Live Sessions</h3>
                        <p>Join cooking demonstrations and Q&A sessions with expert chefs</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- === Rest of your CSS/JS remains unchanged === -->
<style>
:root {
    --primary-orange: #FF6B00;
    --orange-light: #FF8E42;
    --orange-dark: #CC5500;
    --orange-gradient: linear-gradient(135deg, #FF6B00, #FF8E42);
    --orange-subtle: #FFE5CC;
    --orange-pale: #FFF3E8;
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

.community-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.community-hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    margin-bottom: 60px;
    padding: 50px;
    background: linear-gradient(135deg, #fff, var(--orange-pale));
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-lg);
    animation: fadeIn 0.8s ease;
}

.hero-content {
    animation: slideInLeft 0.8s ease;
}

.hero-title {
    font-size: 2.8rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 16px;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.2rem;
    color: var(--gray-600);
    margin-bottom: 40px;
    line-height: 1.6;
}

.hero-stats {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    min-width: 220px;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
}

.stat-icon {
    width: 56px;
    height: 56px;
    background: var(--orange-gradient);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-800);
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--gray-500);
    margin-top: 4px;
    font-weight: 500;
}

.hero-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-xl);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}

.section-icon {
    width: 60px;
    height: 60px;
    background: var(--orange-gradient);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    flex-shrink: 0;
}

.section-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 8px;
}

.section-header p {
    font-size: 1.1rem;
    color: var(--gray-600);
}

.share-section {
    margin-bottom: 60px;
}

.share-card {
    background: linear-gradient(135deg, var(--primary-orange), var(--orange-dark));
    border-radius: var(--border-radius-lg);
    padding: 40px;
    color: white;
    box-shadow: var(--shadow-xl);
    transition: var(--transition);
}

.share-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 25px 50px -12px rgba(255, 107, 0, 0.4);
}

.card-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    width: 100%;
    min-height: 200px;
}

.user-welcome {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    flex: 1;
    text-align: center;
}

.user-welcome .welcome-text {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.user-welcome h3,
.user-welcome p {
    text-align: center;
    width: 100%;
}

.user-avatar {
    width: 70px;
    height: 70px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary-orange);
}

.welcome-text h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.welcome-text p {
    font-size: 1.1rem;
    opacity: 0.9;
}

.create-post-btn {
    background: white;
    color: var(--primary-orange);
    padding: 16px 32px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: var(--transition);
    white-space: nowrap;
}

.create-post-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
}

.auth-prompt {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 20px;
    width: 100%;
}

.prompt-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin-bottom: 24px;
    color: white;
}

.auth-prompt h3 {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 12px;
    color: white;
    width: 100%;
}

.auth-prompt p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 30px;
    line-height: 1.6;
    color: white;
    width: 100%;
    max-width: 600px;
}

.auth-buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
    width: 100%;
}

.btn {
    padding: 14px 28px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: var(--transition);
}

.btn-login {
    background: white;
    color: var(--primary-orange);
}

.btn-join {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.discussions-section {
    margin-bottom: 60px;
}

.discussions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.discussion-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease forwards;
    border: 1px solid var(--gray-100);
}

.discussion-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.author-avatar {
    width: 50px;
    height: 50px;
    background: var(--orange-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    font-weight: 600;
}

.author-details h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-800);
    margin-bottom: 2px;
}

.post-time {
    font-size: 0.85rem;
    color: var(--gray-500);
}

.category-badge {
    background: var(--orange-subtle);
    color: var(--primary-orange);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.post-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--gray-800);
    margin-bottom: 15px;
    line-height: 1.4;
}

.post-excerpt {
    color: var(--gray-600);
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 0.95rem;
}

.post-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--gray-100);
}

.stat {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--gray-500);
    font-size: 0.9rem;
}

.stat i {
    color: var(--primary-orange);
}

.read-more-btn {
    color: var(--primary-orange);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: gap 0.3s ease;
}

.read-more-btn:hover {
    gap: 12px;
}

.no-discussions {
    text-align: center;
    padding: 60px 40px;
    color: var(--gray-500);
}

.no-discussions i {
    font-size: 4rem;
    color: var(--gray-300);
    margin-bottom: 20px;
}

.no-discussions h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: var(--gray-600);
}

.view-all-container {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid var(--gray-100);
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: var(--primary-orange);
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 14px 32px;
    border: 2px solid var(--primary-orange);
    border-radius: 50px;
    transition: var(--transition);
}

.view-all-btn:hover {
    background: var(--primary-orange);
    color: white;
    gap: 15px;
}

.features-section {
    margin-bottom: 60px;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.feature-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 40px 30px;
    text-align: center;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
    border: 1px solid var(--gray-100);
}

.feature-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-xl);
    border-color: var(--orange-subtle);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: var(--orange-gradient);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    margin: 0 auto 24px;
}

.feature-card h3 {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--gray-800);
    margin-bottom: 16px;
}

.feature-card p {
    color: var(--gray-600);
    line-height: 1.6;
    font-size: 1rem;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes fadeInUp {
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 1024px) {
    .community-hero {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 40px;
        padding: 40px 30px;
    }
    .hero-stats { justify-content: center; }
    .card-content { flex-direction: column; }
    .user-welcome { flex-direction: column; text-align: center; margin-bottom: 20px; }
}

@media (max-width: 768px) {
    .hero-title { font-size: 2.2rem; }
    .hero-stats { flex-direction: column; align-items: center; }
    .stat-card { min-width: 100%; }
    .discussions-grid, .features-grid { grid-template-columns: 1fr; }
    .auth-buttons { flex-direction: column; align-items: center; }
    .btn { min-width: 200px; justify-content: center; }
}

@media (max-width: 480px) {
    .community-hero, .share-card, .discussion-card, .feature-card { padding: 30px 20px; }
    .hero-title { font-size: 1.8rem; }
    .section-header { flex-direction: column; text-align: center; gap: 15px; }
    .section-header h2 { font-size: 1.6rem; }
    .auth-prompt h3 { font-size: 1.5rem; }
    .auth-prompt p { font-size: 1rem; }
    .btn { padding: 12px 20px; font-size: 0.95rem; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Safe animation initialization
    setTimeout(() => {
        document.querySelectorAll('.stat-card, .discussion-card, .feature-card, .share-card')
            .forEach(el => {
                el.style.transition = 'transform 0.3s, box-shadow 0.3s';
            });
    }, 500);
});
</script>

<?php include 'includes/footer.php'; ?>