<?php
$page_title = "Resources - Orange Food Community";
include 'includes/header.php';
?>

<div class="container main-content">
    <div class="resources-page">
        <!-- Hero Section -->
        <div class="resources-hero">
            <div class="hero-content">
                <h1 class="hero-title">Culinary Resources</h1>
                <p class="hero-subtitle">Master your kitchen skills with our collection of recipes, tutorials, and guides</p>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Resources</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">Free</span>
                        <span class="stat-label">Access</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Available</span>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Professional Kitchen">
            </div>
        </div>

        <!-- Resource Categories -->
        <div class="resource-categories">
            <div class="categories-nav">
                <button class="category-btn active" data-tab="downloads">
                    <i class="fas fa-cloud-download-alt"></i>
                    <span>Downloads</span>
                </button>
                <button class="category-btn" data-tab="tutorials">
                    <i class="fas fa-play-circle"></i>
                    <span>Tutorials</span>
                </button>
                <button class="category-btn" data-tab="guides">
                    <i class="fas fa-book"></i>
                    <span>Guides</span>
                </button>
            </div>

            <!-- Downloads Section -->
            <div class="category-content active" id="downloads">
                <div class="section-header">
                    <h2><i class="fas fa-file-download"></i> Recipe Templates</h2>
                    <p>Download and print beautiful templates for your kitchen</p>
                </div>
                
                <div class="downloads-grid">
                    <div class="download-card">
                        <div class="download-preview" style="background: linear-gradient(135deg, #FFE5CC, #FFD1A4);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="download-info">
                            <h3>Weekly Meal Planner</h3>
                            <p>Plan your meals with this organized weekly template</p>
                            <div class="download-meta">
                                <span><i class="fas fa-file-pdf"></i> PDF • 2MB</span>
                                <span><i class="fas fa-download"></i> 1.2k Downloads</span>
                            </div>
                            <a href="downloads/meal-planner.pdf" class="download-btn" download>
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>

                    <div class="download-card">
                        <div class="download-preview" style="background: linear-gradient(135deg, #FFD8CC, #FFC4A4);">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="download-info">
                            <h3>Recipe Card Template</h3>
                            <p>Elegant cards to record your favorite recipes</p>
                            <div class="download-meta">
                                <span><i class="fas fa-file-pdf"></i> PDF • 1.5MB</span>
                                <span><i class="fas fa-download"></i> 890 Downloads</span>
                            </div>
                            <a href="downloads/recipe-card-template.pdf" class="download-btn" download>
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>

                    <div class="download-card">
                        <div class="download-preview" style="background: linear-gradient(135deg, #CCFFE5, #A4FFD1);">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <div class="download-info">
                            <h3>Grocery Shopping List</h3>
                            <p>Organized checklist for your grocery shopping</p>
                            <div class="download-meta">
                                <span><i class="fas fa-file-pdf"></i> PDF • 1.8MB</span>
                                <span><i class="fas fa-download"></i> 1.5k Downloads</span>
                            </div>
                            <a href="downloads/grocery-list.pdf" class="download-btn" download>
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tutorials Section -->
            <div class="category-content" id="tutorials">
                <div class="section-header">
                    <h2><i class="fas fa-video"></i> Video Tutorials</h2>
                    <p>Watch and learn from professional chefs</p>
                </div>
                
                <div class="tutorials-grid">
                    <div class="tutorial-card">
                        <div class="video-container">
                            <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Knife Skills" class="video-thumb">
                            <div class="play-btn">
                                <i class="fas fa-play"></i>
                            </div>
                            <div class="video-duration">8:24</div>
                        </div>
                        <div class="tutorial-info">
                            <h3>Knife Skills Masterclass</h3>
                            <p>Learn essential cutting techniques for faster, safer cooking</p>
                            <div class="tutor-meta">
                                <span><i class="fas fa-clock"></i> 8 mins</span>
                                <span><i class="fas fa-eye"></i> 24k views</span>
                                <span class="difficulty easy">Beginner</span>
                            </div>
                            <a href="https://www.youtube.com" class="watch-btn" target="_blank">
                                <i class="fas fa-play"></i> Watch Now
                            </a>
                        </div>
                    </div>

                    <div class="tutorial-card">
                        <div class="video-container">
                            <img src="https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Sauce Making" class="video-thumb">
                            <div class="play-btn">
                                <i class="fas fa-play"></i>
                            </div>
                            <div class="video-duration">12:15</div>
                        </div>
                        <div class="tutorial-info">
                            <h3>5 Essential Sauces</h3>
                            <p>Master the mother sauces that transform any dish</p>
                            <div class="tutor-meta">
                                <span><i class="fas fa-clock"></i> 12 mins</span>
                                <span><i class="fas fa-eye"></i> 18k views</span>
                                <span class="difficulty medium">Intermediate</span>
                            </div>
                            <a href="https://www.youtube.com" class="watch-btn" target="_blank">
                                <i class="fas fa-play"></i> Watch Now
                            </a>
                        </div>
                    </div>

                    <div class="tutorial-card">
                        <div class="video-container">
                            <img src="https://images.unsplash.com/photo-1563379926898-05f4575a45d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Baking Techniques" class="video-thumb">
                            <div class="play-btn">
                                <i class="fas fa-play"></i>
                            </div>
                            <div class="video-duration">15:30</div>
                        </div>
                        <div class="tutorial-info">
                            <h3>Perfect Baking Techniques</h3>
                            <p>Essential skills for consistent baking results</p>
                            <div class="tutor-meta">
                                <span><i class="fas fa-clock"></i> 15 mins</span>
                                <span><i class="fas fa-eye"></i> 15k views</span>
                                <span class="difficulty medium">Intermediate</span>
                            </div>
                            <a href="https://www.youtube.com" class="watch-btn" target="_blank">
                                <i class="fas fa-play"></i> Watch Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guides Section -->
            <div class="category-content" id="guides">
                <div class="section-header">
                    <h2><i class="fas fa-graduation-cap"></i> Learning Guides</h2>
                    <p>Comprehensive guides to improve your culinary knowledge</p>
                </div>
                
                <div class="guides-grid">
                    <div class="guide-card">
                        <div class="guide-icon" style="background: linear-gradient(135deg, #E6F7FF, #CCEFFF);">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3>Seasonal Produce Guide</h3>
                        <p>Know what's fresh and when. Complete monthly produce calendar.</p>
                        <ul class="guide-features">
                            <li><i class="fas fa-check-circle"></i> Monthly charts</li>
                            <li><i class="fas fa-check-circle"></i> Storage tips</li>
                            <li><i class="fas fa-check-circle"></i> Recipe suggestions</li>
                        </ul>
                        <a href="guides/seasonal-cooking.pdf" class="guide-action" download>
                            <i class="fas fa-download"></i> Download Guide
                        </a>
                    </div>

                    <div class="guide-card">
                        <div class="guide-icon" style="background: linear-gradient(135deg, #FFF0E6, #FFE5CC);">
                            <i class="fas fa-thermometer-half"></i>
                        </div>
                        <h3>Cooking Temperature Guide</h3>
                        <p>Safe internal temperatures for all types of meat and seafood.</p>
                        <ul class="guide-features">
                            <li><i class="fas fa-check-circle"></i> Meat temperatures</li>
                            <li><i class="fas fa-check-circle"></i> Seafood guide</li>
                            <li><i class="fas fa-check-circle"></i> Safety standards</li>
                        </ul>
                        <a href="guides/cooking-temperatures.pdf" class="guide-action" download>
                            <i class="fas fa-download"></i> Download Guide
                        </a>
                    </div>

                    <div class="guide-card">
                        <div class="guide-icon" style="background: linear-gradient(135deg, #F0FFF4, #E6FFED);">
                            <i class="fas fa-weight"></i>
                        </div>
                        <h3>Measurement Conversion</h3>
                        <p>Quick reference for converting between measurement systems.</p>
                        <ul class="guide-features">
                            <li><i class="fas fa-check-circle"></i> Volume conversions</li>
                            <li><i class="fas fa-check-circle"></i> Weight equivalents</li>
                            <li><i class="fas fa-check-circle"></i> Temperature charts</li>
                        </ul>
                        <a href="guides/measurement-conversion.pdf" class="guide-action" download>
                            <i class="fas fa-download"></i> Download Guide
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="resources-cta">
            <div class="cta-card">
                <div class="cta-content">
                    <h2>Unlock Full Access</h2>
                    <p>Create a free account to access premium resources, save your favorites, and track your progress.</p>
                    <div class="cta-features">
                        <span><i class="fas fa-check"></i> Unlimited Downloads</span>
                        <span><i class="fas fa-check"></i> Progress Tracking</span>
                        <span><i class="fas fa-check"></i> Personalized Recommendations</span>
                    </div>
                </div>
                <div class="cta-action">
                    <a href="register.php" class="cta-btn">
                        <i class="fas fa-user-plus"></i> Join Free Community
                    </a>
                    <p class="cta-note">Already a member? <a href="login.php">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-orange: #FF6B00;
    --orange-light: #FF8E42;
    --orange-dark: #CC5500;
    --orange-bright: #FFA500;
    --orange-subtle: #FFE5CC;
    --gray-light: #f8f9fa;
    --gray-medium: #6c757d;
    --gray-dark: #343a40;
    --success: #28a745;
    --info: #17a2b8;
    --shadow: 0 4px 20px rgba(0,0,0,0.08);
    --shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
    --transition: all 0.3s ease;
}

/* Hero Section */
.resources-hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
    margin-bottom: 4rem;
    padding: 2rem;
    background: linear-gradient(135deg, #fff, var(--orange-subtle));
    border-radius: 20px;
    box-shadow: var(--shadow);
}

.hero-content {
    padding: 1rem;
}

.hero-title {
    font-size: 3rem;
    font-weight: 800;
    color: var(--gray-dark);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.2rem;
    color: var(--gray-medium);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
}

.stat {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-orange);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--gray-medium);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hero-image {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.hero-image img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    transition: var(--transition);
}

.hero-image:hover img {
    transform: scale(1.05);
}

/* Category Navigation */
.categories-nav {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.category-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-medium);
    cursor: pointer;
    transition: var(--transition);
    min-width: 160px;
    justify-content: center;
}

.category-btn.active {
    background: var(--primary-orange);
    border-color: var(--primary-orange);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
}

.category-btn:hover:not(.active) {
    border-color: var(--primary-orange);
    color: var(--primary-orange);
    transform: translateY(-2px);
}

.category-content {
    display: none;
    animation: fadeIn 0.5s ease;
}

.category-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Section Header */
.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2.2rem;
    color: var(--gray-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.section-header p {
    color: var(--gray-medium);
    font-size: 1.1rem;
}

/* Downloads Grid */
.downloads-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.download-card {
    display: grid;
    grid-template-columns: 120px 1fr;
    gap: 1.5rem;
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
    transition: var(--transition);
    border: 1px solid #f1f1f1;
}

.download-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
    border-color: var(--orange-subtle);
}

.download-preview {
    width: 120px;
    height: 120px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: var(--primary-orange);
}

.download-info h3 {
    font-size: 1.3rem;
    color: var(--gray-dark);
    margin-bottom: 0.5rem;
}

.download-info p {
    color: var(--gray-medium);
    margin-bottom: 1rem;
    line-height: 1.5;
}

.download-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.download-meta span {
    font-size: 0.85rem;
    color: var(--gray-medium);
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.download-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--primary-orange);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.download-btn:hover {
    background: var(--orange-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
}

/* Tutorials Grid */
.tutorials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.tutorial-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.tutorial-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.video-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.video-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.tutorial-card:hover .video-thumb {
    transform: scale(1.05);
}

.play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--primary-orange);
    cursor: pointer;
    transition: var(--transition);
}

.play-btn:hover {
    background: var(--primary-orange);
    color: white;
    transform: translate(-50%, -50%) scale(1.1);
}

.video-duration {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.85rem;
}

.tutorial-info {
    padding: 1.5rem;
}

.tutorial-info h3 {
    font-size: 1.3rem;
    color: var(--gray-dark);
    margin-bottom: 0.5rem;
}

.tutorial-info p {
    color: var(--gray-medium);
    margin-bottom: 1rem;
    line-height: 1.5;
}

.tutor-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.tutor-meta span {
    font-size: 0.85rem;
    color: var(--gray-medium);
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.difficulty {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.difficulty.easy {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.difficulty.medium {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.watch-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: transparent;
    color: var(--primary-orange);
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: var(--transition);
    border: 2px solid var(--primary-orange);
}

.watch-btn:hover {
    background: var(--primary-orange);
    color: white;
}

/* Guides Grid */
.guides-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.guide-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.guide-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.guide-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--primary-orange);
    margin: 0 auto 1.5rem;
}

.guide-card h3 {
    font-size: 1.3rem;
    color: var(--gray-dark);
    margin-bottom: 1rem;
}

.guide-card p {
    color: var(--gray-medium);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.guide-features {
    list-style: none;
    padding: 0;
    margin-bottom: 1.5rem;
}

.guide-features li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-medium);
    margin-bottom: 0.5rem;
    justify-content: center;
}

.guide-features li i {
    color: var(--primary-orange);
}

.guide-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: transparent;
    color: var(--primary-orange);
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: var(--transition);
    border: 2px solid var(--primary-orange);
}

.guide-action:hover {
    background: var(--primary-orange);
    color: white;
}

/* CTA Section */
.resources-cta {
    margin-top: 4rem;
}

.cta-card {
    background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
    color: white;
    border-radius: 20px;
    padding: 3rem;
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    align-items: center;
    box-shadow: 0 10px 30px rgba(255, 107, 0, 0.3);
}

.cta-content h2 {
    font-size: 2.2rem;
    margin-bottom: 1rem;
    color: white;
}

.cta-content p {
    font-size: 1.1rem;
    opacity: 0.95;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.cta-features {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.cta-features span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
}

.cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: white;
    color: var(--primary-orange);
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.1rem;
    transition: var(--transition);
    border: 2px solid white;
    justify-content: center;
}

.cta-btn:hover {
    background: transparent;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
}

.cta-note {
    margin-top: 1rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

.cta-note a {
    color: white;
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 992px) {
    .resources-hero {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .hero-stats {
        justify-content: center;
    }
    
    .downloads-grid,
    .tutorials-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
    
    .cta-card {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .category-btn {
        min-width: 140px;
        padding: 0.75rem 1.5rem;
    }
    
    .download-card {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .download-preview {
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }
    
    .cta-features {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2.2rem;
    }
    
    .categories-nav {
        flex-direction: column;
        align-items: center;
    }
    
    .category-btn {
        width: 100%;
        max-width: 300px;
    }
    
    .section-header h2 {
        font-size: 1.8rem;
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryBtns = document.querySelectorAll('.category-btn');
    const categoryContents = document.querySelectorAll('.category-content');
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Update active button
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update active content
            categoryContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === tabId) {
                    content.classList.add('active');
                }
            });
            
            // Add smooth scroll
            const categorySection = document.querySelector('.resource-categories');
            categorySection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    
    // Video play button functionality
    document.querySelectorAll('.play-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.tutorial-card');
            const link = card.querySelector('.watch-btn');
            if (link) {
                window.open(link.href, '_blank');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>