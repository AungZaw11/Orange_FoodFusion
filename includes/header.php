<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = $page_title ?? 'Orange - Food Community';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Header Styles - Updated with Orange theme */
        :root {
            --primary-orange: #FF6B00;
            --orange-light: #FF8E42;
            --orange-dark: #CC5500;
            --orange-bright: #FFA500;
            --orange-subtle: #FFE5CC;
        }
        
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        /* Updated Logo Styles - Orange theme */
        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-orange);
        }

        .logo i {
            color: var(--primary-orange);
        }

        .logo span {
            color: var(--primary-orange);
        }

        .logo:hover {
            color: var(--orange-dark);
        }

        .logo:hover span {
            color: var(--orange-dark);
        }

        .nav-links {
            display: flex;
            list-style: none;
            align-items: center;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-orange);
        }

        .btn-login {
            padding: 0.5rem 1.5rem;
            border: 2px solid var(--primary-orange);
            border-radius: 5px;
            color: var(--primary-orange);
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--primary-orange);
            color: white;
        }

        .btn-register {
            padding: 0.5rem 1.5rem;
            background: var(--primary-orange);
            color: white;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: var(--orange-dark);
        }

        /* Mobile Navigation */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: #333;
            margin: 2px 0;
            transition: 0.3s;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }
            
            .nav-links {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                flex-direction: column;
                background: white;
                padding: 2rem;
                transition: 0.3s;
            }
            
            .nav-links.active {
                left: 0;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar container">
            <a href="index.php" class="logo">
                <i class="fas fa-orange"></i>
                <span>Orange</span>
            </a>
            
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="cookbook.php">Community</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="resource.php">Resources</a></li>
                <li><a href="educational.php">Educational</a></li>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="user-menu">
                        <a href="profile.php">
                            <i class="fas fa-user"></i>
                            <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Profile'); ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li><a href="login.php" class="btn-login">Login</a></li>
                    <li><a href="register.php" class="btn-register">Register</a></li>
                <?php endif; ?>
            </ul>
            
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <script>
    // Simple JavaScript without interfering with links
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');
        
        if (hamburger && navLinks) {
            hamburger.addEventListener('click', function() {
                navLinks.classList.toggle('active');
            });
        }
        
        // Make sure all links work
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Allow all links to work normally
                return true;
            });
        });
    });
    </script>