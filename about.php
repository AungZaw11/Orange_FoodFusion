<?php
$page_title = "About Us - Orange Food Community";
include 'includes/header.php';
?>

<div class="container main-content">
    <div class="about-page">
        <!-- Simple Hero -->
        <div class="simple-hero">
            <h1>About Orange</h1>
            <p class="hero-description">A community where food lovers share, learn, and connect</p>
        </div>

        <!-- Mission Statement -->
        <div class="simple-section">
            <div class="section-card">
                <h2>Our Mission</h2>
                <p>To create a welcoming platform where everyone can share food heritage, learn new skills, and build meaningful connections through cooking.</p>
            </div>
        </div>

        <!-- Our Story -->
        <div class="simple-section">
            <h2 class="section-title">Our Story</h2>
            <div class="story-grid">
                <div class="story-item">
                    <div class="story-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3>Started in 2022</h3>
                    <p>Began as a passion project by food enthusiasts wanting to create a space for genuine culinary exchange.</p>
                </div>
                
                <div class="story-item">
                    <div class="story-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Growing Together</h3>
                    <p>Evolved into a thriving platform with thousands of members sharing authentic recipes from around the world.</p>
                </div>
                
                <div class="story-item">
                    <div class="story-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Global Community</h3>
                    <p>Now connecting food lovers from 80+ countries in a vibrant, supportive community.</p>
                </div>
            </div>
        </div>

        <!-- Community Stats -->
        <div class="stats-section">
            <h2 class="section-title">Our Community</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">10,000+</span>
                    <span class="stat-label">Members</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5,000+</span>
                    <span class="stat-label">Recipes</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">195+</span>
                    <span class="stat-label">Countries</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">15,000+</span>
                    <span class="stat-label">Discussions</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">8,000+</span>
                    <span class="stat-label">Resources</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">3,000+</span>
                    <span class="stat-label">Educational</span>
                </div>
            </div>
        </div>

        <!-- Our Values -->
        <div class="simple-section">
            <h2 class="section-title">Our Values</h2>
            <div class="values-list">
                <div class="value-item">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h3>Authenticity</h3>
                        <p>We celebrate genuine culinary traditions and personal food stories</p>
                    </div>
                </div>
                
                <div class="value-item">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h3>Inclusivity</h3>
                        <p>Everyone is welcome regardless of skill level or background</p>
                    </div>
                </div>
                
                <div class="value-item">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h3>Collaboration</h3>
                        <p>We believe in sharing knowledge and learning together</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple CTA -->
        <div class="simple-cta">
            <h2>Join Our Community</h2>
            <p>Start sharing recipes, learning new skills, and connecting with food lovers worldwide</p>
            <div class="cta-buttons">
                <a href="register.php" class="btn-primary">
                    <i class="fas fa-user-plus"></i> Create Free Account
                </a>
                <a href="cookbook.php" class="btn-secondary">
                    Explore Community
                </a>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-orange: #FF6B00;
    --orange-light: #FF8E42;
    --orange-dark: #CC5500;
    --orange-subtle: #FFE5CC;
    --gray-light: #f8f9fa;
    --gray-medium: #6c757d;
    --gray-dark: #343a40;
}

/* Reset & Base */
.about-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Simple Hero */
.simple-hero {
    text-align: center;
    padding: 60px 20px;
    margin-bottom: 40px;
    background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
    color: white;
    border-radius: 10px;
}

.simple-hero h1 {
    font-size: 2.5rem;
    margin-bottom: 15px;
    font-weight: 700;
}

.hero-description {
    font-size: 1.2rem;
    opacity: 0.95;
    max-width: 600px;
    margin: 0 auto;
}

/* Simple Sections */
.simple-section {
    margin-bottom: 60px;
}

.section-title {
    text-align: center;
    font-size: 2rem;
    color: var(--gray-dark);
    margin-bottom: 40px;
    font-weight: 600;
}

.section-card {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-left: 5px solid var(--primary-orange);
}

.section-card h2 {
    color: var(--primary-orange);
    margin-bottom: 20px;
    font-size: 1.8rem;
}

.section-card p {
    color: var(--gray-medium);
    line-height: 1.6;
    font-size: 1.1rem;
}

/* Story Grid */
.story-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.story-item {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    text-align: center;
    transition: transform 0.3s ease;
}

.story-item:hover {
    transform: translateY(-5px);
}

.story-icon {
    width: 70px;
    height: 70px;
    background: var(--primary-orange);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 20px;
}

.story-item h3 {
    color: var(--gray-dark);
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.story-item p {
    color: var(--gray-medium);
    line-height: 1.6;
}

/* Stats Section */
.stats-section {
    background: var(--gray-light);
    padding: 60px 20px;
    margin: 60px 0;
    border-radius: 10px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    max-width: 800px;
    margin: 0 auto;
}

.stat-item {
    text-align: center;
    padding: 20px;
}

.stat-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-orange);
    margin-bottom: 10px;
}

.stat-label {
    color: var(--gray-dark);
    font-weight: 600;
    font-size: 1.1rem;
}

/* Values List */
.values-list {
    max-width: 800px;
    margin: 0 auto;
}

.value-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.value-item i {
    color: var(--primary-orange);
    font-size: 1.5rem;
    margin-top: 5px;
}

.value-item h3 {
    color: var(--gray-dark);
    margin-bottom: 10px;
    font-size: 1.3rem;
}

.value-item p {
    color: var(--gray-medium);
    line-height: 1.6;
}

/* Simple CTA */
.simple-cta {
    text-align: center;
    background: linear-gradient(135deg, var(--primary-orange), var(--orange-dark));
    color: white;
    padding: 60px 30px;
    border-radius: 10px;
    margin-top: 60px;
}

.simple-cta h2 {
    font-size: 2rem;
    margin-bottom: 20px;
}

.simple-cta p {
    font-size: 1.1rem;
    opacity: 0.95;
    max-width: 600px;
    margin: 0 auto 30px;
    line-height: 1.6;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary, .btn-secondary {
    padding: 15px 30px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: white;
    color: var(--primary-orange);
}

.btn-primary:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .simple-hero {
        padding: 40px 20px;
    }
    
    .simple-hero h1 {
        font-size: 2rem;
    }
    
    .hero-description {
        font-size: 1.1rem;
    }
    
    .section-card {
        padding: 30px 20px;
    }
    
    .story-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .value-item {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple fade-in animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    // Animate story items
    document.querySelectorAll('.story-item').forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = `all 0.5s ease ${index * 0.1}s`;
        observer.observe(item);
    });
    
    // Animate stats
    document.querySelectorAll('.stat-item').forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'scale(0.9)';
        item.style.transition = `all 0.5s ease ${index * 0.1}s`;
        observer.observe(item);
    });
});
</script>

<?php include 'includes/footer.php'; ?>