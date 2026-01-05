<!-- Cookie Consent Banner -->
<div id="cookie-banner" class="cookie-banner" style="display: none;">
    <div class="cookie-content">
        <p>We use essential cookies to keep our site running and improve your experience. By continuing, you agree to our 
            <a href="cookie-policy.php" class="cookie-link">Cookie Policy</a>.
        </p>
        <button id="accept-cookies" class="accept-btn">Accept</button>
    </div>
</div>

<!-- Footer -->
<footer class="footer-simple">
    <div class="container">
        <div class="footer-main">
            <!-- Left: Brand -->
            <div class="footer-left">
                <div class="brand-logo">
                    <i class="fas fa-pepper-hot"></i>
                    <span>Orange</span>
                </div>
                <p class="tagline">Fresh food for fresh minds</p>
            </div>
            
            <!-- Right: Legal Links -->
            <div class="footer-right">
                <div class="legal-links">
                    <a href="privacy-policy.php">Privacy</a>
                    <a href="cookie-policy.php">Cookie</a>
                    <a href="disclaimer.php">Disclaimer</a>
                    <a href="contact.php">Contact</a>
                </div>
                
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="copyright-bar">
            <p>&copy; <?php echo date('Y'); ?> Orange Food Community. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
/* Orange Theme Variables */
:root {
    --primary-orange: #FF6B00;
    --orange-light: #FF8E42;
    --orange-dark: #CC5500;
    --orange-bright: #FFA500;
    --orange-subtle: #FFE5CC;
}

/* === COOKIE BANNER === */
.cookie-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: var(--orange-subtle);
    border-top: 1px solid var(--primary-orange);
    padding: 15px 20px;
    z-index: 1000;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
}

.cookie-content {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    gap: 15px;
}

.cookie-content p {
    margin: 0;
    color: #555;
    font-size: 0.9rem;
}

.cookie-link {
    color: var(--primary-orange);
    text-decoration: underline;
}

.cookie-link:hover {
    color: var(--orange-dark);
}

.accept-btn {
    background: var(--primary-orange);
    color: white;
    border: none;
    padding: 6px 16px;
    border-radius: 4px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background 0.3s;
}

.accept-btn:hover {
    background: var(--orange-dark);
}

/* === FOOTER === */
.footer-simple {
    background: var(--orange-subtle);
    padding: 30px 0 15px;
    margin-top: 50px;
    border-top: 2px solid var(--primary-orange);
}

.footer-main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 20px;
}

.footer-left {
    flex: 1;
    min-width: 200px;
}

.brand-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}

.brand-logo i {
    font-size: 1.5rem;
    color: var(--primary-orange);
}

.brand-logo span {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--orange-dark);
}

.tagline {
    color: #666;
    font-size: 0.9rem;
    margin: 0;
    font-style: italic;
}

.footer-right {
    text-align: right;
}

.legal-links {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    justify-content: flex-end;
    flex-wrap: wrap;
}

.legal-links a {
    color: #666;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s;
}

.legal-links a:hover {
    color: var(--primary-orange);
}

.social-icons {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.social-icons a {
    color: #666;
    font-size: 1rem;
    transition: color 0.3s;
}

.social-icons a:hover {
    color: var(--primary-orange);
}

.copyright-bar {
    text-align: center;
    padding-top: 15px;
    border-top: 1px solid rgba(255, 107, 0, 0.2);
    color: #888;
    font-size: 0.85rem;
}

.copyright-bar p {
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-main {
        flex-direction: column;
        text-align: center;
        gap: 25px;
    }
    
    .footer-right {
        text-align: center;
        width: 100%;
    }
    
    .legal-links {
        justify-content: center;
    }
    
    .social-icons {
        justify-content: center;
    }

    .cookie-content {
        flex-direction: column;
        text-align: center;
    }

    .accept-btn {
        width: 100%;
        max-width: 200px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const banner = document.getElementById('cookie-banner');
    const acceptBtn = document.getElementById('accept-cookies');

    if (!localStorage.getItem('cookiesAccepted')) {
        banner.style.display = 'block';
    }

    acceptBtn.addEventListener('click', function () {
        localStorage.setItem('cookiesAccepted', 'true');
        banner.style.display = 'none';
    });
});
</script>