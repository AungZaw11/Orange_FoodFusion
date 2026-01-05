<?php
$page_title = "Contact Us - Orange";
include 'includes/header.php';
include 'config/database.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        
        if ($stmt->execute([$name, $email, $subject, $message])) {
            $success = "Thank you for your message! We'll get back to you within 24 hours.";
            $_POST = [];
        } else {
            $error = "Sorry, there was an error sending your message. Please try again.";
        }
    }
}
?>

<div class="container main-content">
    <div class="contact-page">
        <!-- Hero Section -->
        <div class="contact-hero">
            <div class="hero-content">
                <h1 class="hero-title">Get in Touch</h1>
                <p class="hero-subtitle">Have questions? We're here to help. Reach out anytime.</p>
                <div class="contact-stats">
                    <div class="stat">
                        <i class="fas fa-clock"></i>
                        <span><strong>24h</strong> Response Time</span>
                    </div>
                    <div class="stat">
                        <i class="fas fa-headset"></i>
                        <span><strong>Support</strong> 7 Days a Week</span>
                    </div>
                    <div class="stat">
                        <i class="fas fa-users"></i>
                        <span><strong>Community</strong> Driven</span>
                    </div>
                    <div class="stat">
                        <i class="fas fa-message"></i>
                        <span><strong>Follow</strong> Follow Our Social</span>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Customer Support">
            </div>
        </div>

        <!-- Main Content -->
        <div class="contact-wrapper">
            <!-- Contact Form Section -->
            <div class="contact-form-section">
                <div class="section-header">
                    <h2><span class="highlight">Send us</span> a Message</h2>
                    <p>Fill out the form below and we'll respond as soon as possible</p>
                </div>
                
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="modern-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" name="name" class="modern-input" 
                                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                       placeholder="Your Full Name" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" class="modern-input" 
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                       placeholder="Your Email Address" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-with-icon">
                            <i class="fas fa-tag"></i>
                            <input type="text" name="subject" class="modern-input" 
                                   value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>" 
                                   placeholder="Message Subject" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="textarea-with-icon">
                            <i class="fas fa-comment"></i>
                            <textarea name="message" class="modern-textarea" rows="5" 
                                      placeholder="How can we help you? Please provide as much detail as possible..." required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <span class="btn-text">Send Message</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>

            <!-- Contact Info Section -->
            <div class="contact-info-section">
                <div class="info-card">
                    <div class="info-header">
                        <h3><i class="fas fa-map-marker-alt"></i> Visit Our Office</h3>
                        <div class="map-container">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2378.571472055433!2d-2.9680543!3d53.4291534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487b21636a7fbfc9%3A0x3f2a9be8e4fa6dac!2s141%20Walton%20Rd%2C%20Walton%2C%20Liverpool%20L4%204AH%2C%20UK!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s" 
                                width="100%" 
                                height="200" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <div class="address-details">
                            <p><strong>Orange Food Community</strong></p>
                            <p>141 Walton Rd, Walton</p>
                            <p>Liverpool L4 4AH</p>
                            <p>United Kingdom</p>
                        </div>
                    </div>
                    
                    <div class="contact-channels">
                        <div class="channel">
                            <div class="channel-icon email">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <div class="channel-info">
                                <h4>Email Us</h4>
                                <p>hello@orange.com</p>
                                <p>support@orange.com</p>
                            </div>
                        </div>
                        
                        <div class="channel">
                            <div class="channel-icon phone">
                                <i class="fas fa-phone-volume"></i>
                            </div>
                            <div class="channel-info">
                                <h4>Call Us</h4>
                                <p>+44 151 555 1234</p>
                                <p class="channel-note">Mon-Fri, 9AM-6PM GMT</p>
                            </div>
                        </div>
                        
                        <div class="channel">
                            <div class="channel-icon support">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="channel-info">
                                <h4>Live Support</h4>
                                <p>Chat with our team</p>
                                <p class="channel-note">Available 24/7</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-section">
                        <h4><i class="fas fa-share-alt"></i> Follow Us</h4>
                        <div class="social-grid">
                            <a href="#" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="#" class="social-btn twitter">
                                <i class="fab fa-twitter"></i>
                                <span>Twitter</span>
                            </a>
                            <a href="#" class="social-btn instagram">
                                <i class="fab fa-instagram"></i>
                                <span>Instagram</span>
                            </a>
                            <a href="#" class="social-btn youtube">
                                <i class="fab fa-youtube"></i>
                                <span>YouTube</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section">
            <div class="section-header center">
                <h2>Frequently Asked <span class="highlight">Questions</span></h2>
                <p>Quick answers to common questions</p>
            </div>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>How quickly will I receive a response?</h4>
                    </div>
                    <div class="faq-answer">
                        <p>We typically respond to all inquiries within 24 hours during business days. For urgent matters, please call our support line.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>Do you offer cooking classes?</h4>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! We offer both in-person and online cooking classes. Check our Events page for the current schedule and registration details.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>Can I contribute recipes to Orange?</h4>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely! We love community contributions. You can submit recipes through your account dashboard for review by our culinary team.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>Is Orange free to use?</h4>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, our basic membership is completely free. We offer premium features for advanced users, but most content remains free.</p>
                    </div>
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
    --orange-gradient: linear-gradient(135deg, #FF6B00, #FF8E42);
    --gray-light: #f8f9fa;
    --gray-medium: #6c757d;
    --gray-dark: #343a40;
    --success: #10B981;
    --error: #EF4444;
    --shadow: 0 4px 20px rgba(0,0,0,0.08);
    --shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
    --transition: all 0.3s ease;
}

/* Hero Section */
.contact-hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
    margin-bottom: 4rem;
    padding: 3rem;
    background: linear-gradient(135deg, #fff, var(--orange-subtle));
    border-radius: 20px;
    box-shadow: var(--shadow);
}

.hero-content {
    padding: 1rem;
}

.hero-title {
    font-size: 3.2rem;
    font-weight: 800;
    color: var(--gray-dark);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-title .highlight {
    color: var(--primary-orange);
}

.hero-subtitle {
    font-size: 1.3rem;
    color: var(--gray-medium);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.contact-stats {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.stat i {
    color: var(--primary-orange);
    font-size: 1.2rem;
}

.stat span {
    font-size: 0.95rem;
    color: var(--gray-dark);
}

.stat strong {
    color: var(--primary-orange);
}

.hero-image {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
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

/* Contact Wrapper */
.contact-wrapper {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 3rem;
    margin-bottom: 4rem;
}

@media (max-width: 992px) {
    .contact-wrapper {
        grid-template-columns: 1fr;
    }
}

/* Form Section */
.contact-form-section {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.contact-form-section:hover {
    box-shadow: var(--shadow-hover);
}

.section-header h2 {
    font-size: 2.2rem;
    color: var(--gray-dark);
    margin-bottom: 0.5rem;
}

.section-header p {
    color: var(--gray-medium);
    margin-bottom: 2rem;
}

.highlight {
    color: var(--primary-orange);
    position: relative;
}

.highlight::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 3px;
    background: var(--orange-gradient);
    border-radius: 2px;
}

.center {
    text-align: center;
}

/* Alerts */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    animation: slideIn 0.5s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
    color: var(--success);
    border-left: 4px solid var(--success);
}

.alert-error {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
    color: var(--error);
    border-left: 4px solid var(--error);
}

.alert i {
    font-size: 1.2rem;
}

/* Form Styles */
.modern-form {
    margin-top: 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 576px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 1.5rem;
}

.input-with-icon,
.textarea-with-icon {
    position: relative;
}

.input-with-icon i,
.textarea-with-icon i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary-orange);
    font-size: 1.1rem;
    z-index: 2;
}

.textarea-with-icon i {
    top: 1.5rem;
    transform: none;
}

.modern-input,
.modern-textarea {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    transition: var(--transition);
    background: white;
}

.modern-textarea {
    min-height: 120px;
    resize: vertical;
    padding-top: 1.5rem;
    padding-left: 3rem;
}

.modern-input:focus,
.modern-textarea:focus {
    outline: none;
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.1);
    background: white;
}

.modern-input::placeholder,
.modern-textarea::placeholder {
    color: #9ca3af;
}

.submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2.5rem;
    background: var(--orange-gradient);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.submit-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 107, 0, 0.4);
}

.submit-btn:hover::before {
    left: 100%;
}

/* Contact Info Section */
.contact-info-section {
    position: sticky;
    top: 2rem;
}

.info-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.info-card:hover {
    box-shadow: var(--shadow-hover);
}

.info-header {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid var(--orange-subtle);
}

.info-header h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--gray-dark);
    margin-bottom: 1rem;
    font-size: 1.4rem;
}

.info-header h3 i {
    color: var(--primary-orange);
}

.map-container {
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.address-details {
    padding: 1rem;
    background: var(--gray-light);
    border-radius: 12px;
    font-size: 0.95rem;
    line-height: 1.6;
}

.address-details strong {
    color: var(--primary-orange);
    display: block;
    margin-bottom: 0.5rem;
}

/* Contact Channels */
.contact-channels {
    margin-bottom: 2rem;
}

.channel {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    margin-bottom: 1rem;
    background: var(--gray-light);
    border-radius: 12px;
    transition: var(--transition);
}

.channel:hover {
    background: var(--orange-subtle);
    transform: translateX(5px);
}

.channel-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.channel-icon.email {
    background: linear-gradient(135deg, #FF6B00, #FF8E42);
}

.channel-icon.phone {
    background: linear-gradient(135deg, #10B981, #34D399);
}

.channel-icon.support {
    background: linear-gradient(135deg, #3B82F6, #60A5FA);
}

.channel-info h4 {
    color: var(--gray-dark);
    margin-bottom: 0.25rem;
    font-size: 1.1rem;
}

.channel-info p {
    color: var(--gray-medium);
    font-size: 0.9rem;
    line-height: 1.5;
}

.channel-note {
    font-size: 0.8rem;
    color: #6b7280;
    font-style: italic;
}

/* Social Section */
.social-section {
    padding-top: 1.5rem;
    border-top: 2px solid var(--orange-subtle);
}

.social-section h4 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--gray-dark);
    margin-bottom: 1.25rem;
    font-size: 1.2rem;
}

.social-section h4 i {
    color: var(--primary-orange);
}

.social-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media (max-width: 1200px) {
    .social-grid {
        grid-template-columns: 1fr;
    }
}

.social-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    text-decoration: none;
    transition: var(--transition);
    font-weight: 500;
    border: 2px solid transparent;
}

.social-btn i {
    font-size: 1.2rem;
    width: 20px;
    text-align: center;
}

.social-btn span {
    flex-grow: 1;
    text-align: center;
}

.social-btn.facebook {
    background: rgba(59, 89, 152, 0.1);
    color: #3B5998;
    border-color: rgba(59, 89, 152, 0.2);
}

.social-btn.twitter {
    background: rgba(29, 161, 242, 0.1);
    color: #1DA1F2;
    border-color: rgba(29, 161, 242, 0.2);
}

.social-btn.instagram {
    background: rgba(225, 48, 108, 0.1);
    color: #E1306C;
    border-color: rgba(225, 48, 108, 0.2);
}

.social-btn.youtube {
    background: rgba(255, 0, 0, 0.1);
    color: #FF0000;
    border-color: rgba(255, 0, 0, 0.2);
}

.social-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* FAQ Section */
.faq-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: var(--shadow);
    margin-top: 2rem;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .faq-grid {
        grid-template-columns: 1fr;
    }
}

.faq-item {
    background: var(--gray-light);
    border-radius: 15px;
    padding: 1.5rem;
    transition: var(--transition);
}

.faq-item:hover {
    background: var(--orange-subtle);
    transform: translateY(-2px);
}

.faq-question {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.faq-question i {
    color: var(--primary-orange);
    font-size: 1.2rem;
}

.faq-question h4 {
    color: var(--gray-dark);
    font-size: 1.1rem;
    font-weight: 600;
}

.faq-answer p {
    color: var(--gray-medium);
    line-height: 1.6;
    font-size: 0.95rem;
    padding-left: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-hero {
        grid-template-columns: 1fr;
        padding: 2rem;
        text-align: center;
    }
    
    .contact-stats {
        justify-content: center;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .contact-form-section,
    .info-card,
    .faq-section {
        padding: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.modern-form');
    const submitBtn = contactForm?.querySelector('.submit-btn');
    const btnText = submitBtn?.querySelector('.btn-text');
    
    if (contactForm && submitBtn && btnText) {
        contactForm.addEventListener('submit', function(e) {
            const originalText = btnText.textContent;
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.textContent = 'Sending...';
            submitBtn.style.opacity = '0.8';
            
            // Reset after 3 seconds (in case form submission takes time)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.disabled = false;
                    btnText.textContent = originalText;
                    submitBtn.style.opacity = '1';
                }
            }, 3000);
        });
    }
    
    // FAQ toggle functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const faqItem = this.closest('.faq-item');
            const answer = faqItem.querySelector('.faq-answer');
            
            // Toggle active class
            faqItem.classList.toggle('active');
            
            // Toggle answer visibility with animation
            if (faqItem.classList.contains('active')) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                answer.style.opacity = '1';
                answer.style.paddingTop = '1rem';
            } else {
                answer.style.maxHeight = '0';
                answer.style.opacity = '0';
                answer.style.paddingTop = '0';
            }
        });
    });
    
    // Initialize FAQ answers
    document.querySelectorAll('.faq-answer').forEach(answer => {
        answer.style.maxHeight = '0';
        answer.style.opacity = '0';
        answer.style.overflow = 'hidden';
        answer.style.transition = 'all 0.3s ease';
    });
});
</script>

<?php include 'includes/footer.php'; ?>