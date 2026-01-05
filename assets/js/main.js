// Main JavaScript for Orange Website
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation Toggle
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            hamburger.classList.toggle('active');
        });
    }
    
    // Form Validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredInputs = this.querySelectorAll('[required]');
            let valid = true;
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                showNotification('Please fill in all required fields.', 'error');
            }
        });
    });
    
    // Notification System
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => notification.classList.add('show'), 100);
        
        // Close button
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        });
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }
    
    // Add notification styles
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            z-index: 10000;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .notification-success {
            border-left: 4px solid #4CAF50;
        }
        
        .notification-error {
            border-left: 4px solid #F44336;
        }
        
        .notification-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .notification-content i {
            font-size: 1.2rem;
        }
        
        .notification-success .notification-content i {
            color: #4CAF50;
        }
        
        .notification-error .notification-content i {
            color: #F44336;
        }
        
        .notification-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
            font-size: 1rem;
            padding: 0;
        }
    `;
    document.head.appendChild(style);
    
    // Back to Top Button
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '<i class="fas fa-chevron-up"></i>';
    backToTop.className = 'back-to-top';
    backToTop.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        background: var(--primary-orange);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        z-index: 999;
        box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
        transition: all 0.3s ease;
    `;
    
    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    document.body.appendChild(backToTop);
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTop.style.display = 'flex';
        } else {
            backToTop.style.display = 'none';
        }
    });
    
    // Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Image Lazy Loading
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Cookie Consent
    function checkCookieConsent() {
        if (!document.cookie.includes('orange_cookie_consent=true')) {
            const cookieConsent = document.getElementById('cookieConsent');
            if (cookieConsent) {
                setTimeout(() => {
                    cookieConsent.classList.add('show');
                }, 1000);
            }
        }
    }
    
    function acceptCookies() {
        const expiry = new Date();
        expiry.setFullYear(expiry.getFullYear() + 1);
        document.cookie = `orange_cookie_consent=true; expires=${expiry.toUTCString()}; path=/`;
        
        const cookieConsent = document.getElementById('cookieConsent');
        if (cookieConsent) {
            cookieConsent.classList.remove('show');
        }
        
        showNotification('Cookie preferences saved!', 'success');
    }
    
    // Initialize cookie consent check
    checkCookieConsent();
    
    // Global functions
    window.showNotification = showNotification;
    window.acceptCookies = acceptCookies;
    
    // Form input animations
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
    
    // Card hover effects
    document.querySelectorAll('.recipe-card, .feature-card, .resource-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});