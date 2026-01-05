<?php
$page_title = "My Profile - Orange";
include 'includes/header.php';
include 'includes/auth.php';
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$database = new Database();
$db = $database->getConnection();

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check for logout success message
if (isset($_GET['message']) && $_GET['message'] === 'logout_success') {
    $logout_success = true;
} else {
    $logout_success = false;
}
?>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <h1>Profile</h1>
        </div>
        
        <?php if ($logout_success): ?>
            <div class="alert alert-success" style="margin-bottom: 20px;">
                Logout successful! You have been signed out.
            </div>
        <?php endif; ?>
        
        <div class="profile-info-section">
            <div class="profile-avatar">
                <div class="avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            
            <div class="profile-details">
                <h2><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Member Since</div>
                    <div class="detail-value"><?php echo date('F d, Y', strtotime($user['created_at'])); ?></div>
                </div>
            </div>
        </div>
        
        <div class="profile-actions">
            <a href="logout.php" class="btn btn-logout" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>

<style>
:root {
    --primary-orange: #FF6B00;
    --orange-light: #FF8E42;
    --orange-dark: #CC5500;
    --bg-gradient: linear-gradient(135deg, #FFF8F0, #FFE5CC);
    --success-color: #4CAF50;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: var(--bg-gradient);
    min-height: 100vh;
}

.profile-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(255, 107, 0, 0.1);
    padding: 40px;
    width: 100%;
    max-width: 500px;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.profile-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-logo {
    margin-bottom: 20px;
}

.auth-logo span {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-orange);
    letter-spacing: -0.5px;
}

.profile-header h1 {
    color: #333;
    font-size: 1.8rem;
    margin-bottom: 8px;
    font-weight: 600;
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 0.95rem;
    text-align: center;
}

.alert-success {
    background: #f0f9f0;
    color: #2e7d32;
    border: 1px solid #c8e6c9;
}

.profile-info-section {
    margin-bottom: 30px;
    text-align: center;
}

.profile-avatar {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
}

.avatar-placeholder {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #FFE5CC, #FFD4A8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-orange);
    font-size: 2.5rem;
    border: 4px solid white;
    box-shadow: 0 5px 15px rgba(255, 107, 0, 0.2);
}

.profile-details h2 {
    color: #333;
    font-size: 1.5rem;
    margin-bottom: 20px;
    font-weight: 600;
}

.detail-item {
    margin-bottom: 15px;
    padding: 12px;
    background: #F8F9FA;
    border-radius: 8px;
    text-align: left;
}

.detail-label {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 5px;
    font-weight: 500;
}

.detail-value {
    font-size: 1rem;
    color: #333;
    font-weight: 500;
}

.profile-actions {
    text-align: center;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #F0F0F0;
}

.btn-logout {
    background: #6c757d;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-width: 150px;
}

.btn-logout:hover {
    background: #5a6268;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
}

@media (max-width: 480px) {
    .profile-card {
        padding: 30px 20px;
        border-radius: 12px;
    }
    
    .auth-logo span {
        font-size: 1.8rem;
    }
    
    .profile-header h1 {
        font-size: 1.6rem;
    }
    
    .avatar-placeholder {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .profile-details h2 {
        font-size: 1.3rem;
    }
}

/* Logout modal styles */
.logout-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    padding: 30px;
    border-radius: 16px;
    max-width: 400px;
    width: 90%;
    text-align: center;
    animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-icon {
    font-size: 3rem;
    color: var(--primary-orange);
    margin-bottom: 20px;
}

.modal-title {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
}

.modal-message {
    color: #666;
    margin-bottom: 25px;
    font-size: 1rem;
    line-height: 1.5;
}

.modal-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.modal-btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
    min-width: 100px;
}

.modal-btn-cancel {
    background: #F8F9FA;
    color: #333;
    border: 1px solid #E0E0E0;
}

.modal-btn-cancel:hover {
    background: #E0E0E0;
}

.modal-btn-confirm {
    background: var(--primary-orange);
    color: white;
}

.modal-btn-confirm:hover {
    background: var(--orange-dark);
}

/* Success toast */
.success-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--success-color);
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 1001;
    animation: slideIn 0.3s ease, slideOut 0.3s ease 2.7s;
    transform: translateX(0);
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutModal = document.createElement('div');
    logoutModal.className = 'logout-modal';
    logoutModal.innerHTML = `
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3 class="modal-title">Logout</h3>
            <p class="modal-message">Are you sure you want to logout from your account?</p>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-cancel" id="cancelLogout">Cancel</button>
                <button class="modal-btn modal-btn-confirm" id="confirmLogout">Logout</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(logoutModal);
    
    logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        logoutModal.style.display = 'flex';
    });
    
    document.getElementById('cancelLogout').addEventListener('click', function() {
        logoutModal.style.display = 'none';
    });
    
    document.getElementById('confirmLogout').addEventListener('click', function() {
        // Create success toast
        const successToast = document.createElement('div');
        successToast.className = 'success-toast';
        successToast.innerHTML = `
            <i class="fas fa-check-circle"></i>
            <span>Logout successful!</span>
        `;
        document.body.appendChild(successToast);
        
        // Hide modal
        logoutModal.style.display = 'none';
        
        // Redirect to logout page after a brief delay
        setTimeout(function() {
            window.location.href = 'logout.php';
        }, 500);
    });
    
    // Close modal when clicking outside
    logoutModal.addEventListener('click', function(e) {
        if (e.target === logoutModal) {
            logoutModal.style.display = 'none';
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && logoutModal.style.display === 'flex') {
            logoutModal.style.display = 'none';
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>