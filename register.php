<?php
// Start output buffering at the very beginning
ob_start();

$page_title = "Register - Orange Food Community";

// Include required files
require_once 'includes/auth.php';
require_once 'config/database.php';

// If already logged in, redirect to home
if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

// Initialize variables
$error = '';
$success = '';
$first_name = '';
$last_name = '';
$email = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate all fields
    $valid = true;
    
    if (empty($first_name)) {
        $error = "First name is required.";
        $valid = false;
    } elseif (strlen($first_name) < 2) {
        $error = "First name must be at least 2 characters.";
        $valid = false;
    } elseif (empty($last_name)) {
        $error = "Last name is required.";
        $valid = false;
    } elseif (strlen($last_name) < 2) {
        $error = "Last name must be at least 2 characters.";
        $valid = false;
    } elseif (empty($email)) {
        $error = "Email is required.";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
        $valid = false;
    } elseif (empty($password)) {
        $error = "Password is required.";
        $valid = false;
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
        $valid = false;
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
        $valid = false;
    }
    
    // If validation passed, check database
    if ($valid) {
        try {
            // Connect to database
            $database = new Database();
            $db = $database->getConnection();
            
            // Check if email already exists
            $query = "SELECT id FROM users WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $error = "Email already registered. Please use a different email.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $query = "INSERT INTO users (first_name, last_name, email, password, created_at) 
                          VALUES (:first_name, :last_name, :email, :password, NOW())";
                
                $stmt = $db->prepare($query);
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
                
                if ($stmt->execute()) {
                    // Registration successful
                    $success = "Registration successful! Redirecting to login page...";
                    
                    // Clear output buffer and redirect
                    ob_end_clean();
                    
                    // Store success message in session for login page
                    session_start();
                    $_SESSION['registration_success'] = true;
                    $_SESSION['success_message'] = "Registration successful! You can now login.";
                    
                    header('Location: login.php');
                    exit();
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

// Include header after all processing
include 'includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <span>Orange</span>
            </div>
            <h1>Create Account</h1>
            <p class="auth-subtitle">Join our community today</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="auth-form" id="registerForm">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <div class="input-group">
                        <input type="text" name="first_name" class="form-control" 
                               placeholder="Enter first name"
                               value="<?php echo htmlspecialchars($first_name); ?>"
                               required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <div class="input-group">
                        <input type="text" name="last_name" class="form-control" 
                               placeholder="Enter last name"
                               value="<?php echo htmlspecialchars($last_name); ?>"
                               required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" 
                           placeholder="Enter email address"
                           value="<?php echo htmlspecialchars($email); ?>"
                           required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" 
                           placeholder="Create password"
                           id="password"
                           required>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="form-hint">
                    Must be at least 8 characters
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" name="confirm_password" class="form-control" 
                           placeholder="Confirm password"
                           id="confirmPassword"
                           required>
                    <button type="button" class="password-toggle" id="toggleConfirmPassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="password-match" id="passwordMatch">
                    Passwords match
                </div>
            </div>
            
            <button type="submit" class="btn btn-auth btn-block" id="submitBtn">
                Create Account
            </button>
            
            <div class="auth-footer">
                <p class="auth-text">
                    Already have an account? 
                    <a href="login.php" class="auth-link">Sign in here</a>
                </p>
                <a href="index.php" class="back-home">
                    <i class="fas fa-arrow-left"></i> Back to home
                </a>
            </div>
        </form>
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

.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.auth-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(255, 107, 0, 0.1);
    padding: 40px;
    width: 100%;
    max-width: 450px;
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

.auth-header {
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

.auth-header h1 {
    color: #333;
    font-size: 1.8rem;
    margin-bottom: 8px;
    font-weight: 600;
}

.auth-subtitle {
    color: #666;
    font-size: 0.95rem;
    margin: 0;
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 0.95rem;
    text-align: center;
}

.alert-success {
    background: #f0f9f0;
    color: #2e7d32;
    border: 1px solid #c8e6c9;
}

.alert-error {
    background: #fff0f0;
    color: #c62828;
    border: 1px solid #ffcdd2;
}

.auth-form {
    margin-top: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 6px;
    color: #333;
    font-weight: 500;
    font-size: 0.9rem;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #E0E0E0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
    background: white;
    height: 48px;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
}

.form-hint {
    margin-top: 6px;
    font-size: 0.8rem;
    color: #666;
}

.password-toggle {
    position: absolute;
    right: 10px;
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    font-size: 1rem;
    padding: 6px 10px;
    border-radius: 4px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
}

.password-toggle:hover {
    background: #f0f0f0;
    color: var(--primary-orange);
}

.password-match {
    margin-top: 6px;
    font-size: 0.8rem;
    color: #4CAF50;
    opacity: 0;
    transition: all 0.2s;
}

.password-match.visible {
    opacity: 1;
}

.btn-auth {
    background: var(--primary-orange);
    color: white;
    border: none;
    padding: 14px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
    height: 48px;
    margin-top: 10px;
}

.btn-auth:hover {
    background: var(--orange-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 107, 0, 0.2);
}

.auth-footer {
    text-align: center;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #F0F0F0;
}

.auth-text {
    color: #666;
    margin-bottom: 15px;
    font-size: 0.95rem;
}

.auth-link {
    color: var(--primary-orange);
    text-decoration: none;
    font-weight: 600;
}

.auth-link:hover {
    text-decoration: underline;
}

.back-home {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #666;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s;
    padding: 8px 16px;
    border-radius: 6px;
    background: #f8f8f8;
    border: 1px solid #e0e0e0;
}

.back-home:hover {
    color: var(--primary-orange);
    background: #f0f0f0;
    border-color: #ddd;
}

.back-home i {
    font-size: 0.9rem;
}

@media (max-width: 480px) {
    .auth-card {
        padding: 30px 20px;
        border-radius: 12px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .auth-logo span {
        font-size: 1.8rem;
    }
    
    .auth-header h1 {
        font-size: 1.6rem;
    }
}

/* Loading state */
.btn-auth:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-auth.loading {
    position: relative;
    color: transparent;
}

.btn-auth.loading::after {
    content: '';
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
    const passwordMatch = document.getElementById('passwordMatch');
    const registerForm = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Toggle password visibility
    togglePasswordBtn.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        const icon = this.querySelector('i');
        if (type === 'password') {
            icon.className = 'fas fa-eye';
        } else {
            icon.className = 'fas fa-eye-slash';
        }
    });
    
    toggleConfirmPasswordBtn.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        const icon = this.querySelector('i');
        if (type === 'password') {
            icon.className = 'fas fa-eye';
        } else {
            icon.className = 'fas fa-eye-slash';
        }
    });
    
    // Check password match
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (confirmPassword.length === 0) {
            passwordMatch.classList.remove('visible');
            return;
        }
        
        if (password === confirmPassword && password.length > 0) {
            passwordMatch.classList.add('visible');
        } else {
            passwordMatch.classList.remove('visible');
        }
    }
    
    // Event listeners
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    
    // Form submission
    registerForm.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        // Validate password length
        if (password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters.');
            return;
        }
        
        // Check password match
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match.');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = '';
    });
    
    // Initialize checks on page load
    if (passwordInput.value) {
        checkPasswordMatch();
    }
});
</script>

<?php 
// End output buffering and flush content
ob_end_flush();
include 'includes/footer.php'; 
?>