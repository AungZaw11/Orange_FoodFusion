<?php
// includes/functions.php

// Include database configuration
require_once __DIR__ . '/../config/database.php';

/**
 * Get database connection
 */
function getDBConnection() {
    static $db = null;
    if ($db === null) {
        $database = new Database();
        $db = $database->getConnection();
    }
    return $db;
}

/**
 * Get featured recipes
 */
function getFeaturedRecipes($limit = 6) {
    $db = getDBConnection();
    
    try {
        $query = "SELECT r.*, u.first_name, u.last_name 
                  FROM recipes r 
                  LEFT JOIN users u ON r.user_id = u.id 
                  WHERE r.is_featured = 1 
                  ORDER BY r.created_at DESC 
                  LIMIT ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getFeaturedRecipes: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all recipes
 */
function getAllRecipes($limit = 12) {
    $db = getDBConnection();
    
    try {
        $query = "SELECT r.*, u.first_name, u.last_name 
                  FROM recipes r 
                  LEFT JOIN users u ON r.user_id = u.id 
                  ORDER BY r.created_at DESC 
                  LIMIT ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getAllRecipes: " . $e->getMessage());
        return [];
    }
}

/**
 * Sanitize input
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return $data;
}

/**
 * Validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Format date
 */
function formatDate($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}

/**
 * Truncate text
 */
function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

/**
 * Get recipe by ID
 */
function getRecipeById($id) {
    $db = getDBConnection();
    
    try {
        $query = "SELECT r.*, u.first_name, u.last_name, u.profile_image 
                  FROM recipes r 
                  LEFT JOIN users u ON r.user_id = u.id 
                  WHERE r.id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getRecipeById: " . $e->getMessage());
        return null;
    }
}

/**
 * Get recipe count
 */
function getRecipeCount() {
    $db = getDBConnection();
    
    try {
        $query = "SELECT COUNT(*) as count FROM recipes";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    } catch (PDOException $e) {
        error_log("Database error in getRecipeCount: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get user count
 */
function getUserCount() {
    $db = getDBConnection();
    
    try {
        $query = "SELECT COUNT(*) as count FROM users";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    } catch (PDOException $e) {
        error_log("Database error in getUserCount: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get categories
 */
function getCategories() {
    $db = getDBConnection();
    
    try {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getCategories: " . $e->getMessage());
        return [];
    }
}

/**
 * Get difficulty levels
 */
function getDifficultyLevels() {
    return ['Easy', 'Medium', 'Hard'];
}

/**
 * Get cuisine types
 */
function getCuisineTypes() {
    return [
        'Italian', 'Mexican', 'Chinese', 'Indian', 'Japanese',
        'Thai', 'French', 'Mediterranean', 'American', 'Middle Eastern'
    ];
}

/**
 * Get dietary preferences
 */
function getDietaryPreferences() {
    return [
        'Vegetarian', 'Vegan', 'Gluten-Free', 'Dairy-Free', 
        'Keto', 'Paleo', 'Low-Carb', 'High-Protein'
    ];
}

/**
 * Check if user liked recipe
 */
function isRecipeLiked($user_id, $recipe_id) {
    $db = getDBConnection();
    
    try {
        $query = "SELECT COUNT(*) as count FROM recipe_likes WHERE user_id = ? AND recipe_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$user_id, $recipe_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    } catch (PDOException $e) {
        error_log("Database error in isRecipeLiked: " . $e->getMessage());
        return false;
    }
}

/**
 * Get recipe likes count
 */
function getRecipeLikesCount($recipe_id) {
    $db = getDBConnection();
    
    try {
        $query = "SELECT COUNT(*) as count FROM recipe_likes WHERE recipe_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$recipe_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    } catch (PDOException $e) {
        error_log("Database error in getRecipeLikesCount: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get recipe comments
 */
function getRecipeComments($recipe_id) {
    $db = getDBConnection();
    
    try {
        $query = "SELECT c.*, u.first_name, u.last_name, u.profile_image 
                  FROM recipe_comments c 
                  JOIN users u ON c.user_id = u.id 
                  WHERE c.recipe_id = ? AND c.parent_id IS NULL 
                  ORDER BY c.created_at DESC";
        $stmt = $db->prepare($query);
        $stmt->execute([$recipe_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getRecipeComments: " . $e->getMessage());
        return [];
    }
}

/**
 * Get saved recipes for user
 */
function getSavedRecipes($user_id) {
    $db = getDBConnection();
    
    try {
        $query = "SELECT r.*, u.first_name, u.last_name 
                  FROM saved_recipes sr 
                  JOIN recipes r ON sr.recipe_id = r.id 
                  JOIN users u ON r.user_id = u.id 
                  WHERE sr.user_id = ? 
                  ORDER BY sr.saved_at DESC";
        $stmt = $db->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getSavedRecipes: " . $e->getMessage());
        return [];
    }
}

/**
 * Generate slug from string
 */
function generateSlug($string) {
    $string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    $string = strtolower(trim($string));
    $string = preg_replace('/\s+/', '-', $string);
    return $string;
}

/**
 * Redirect with message
 */
function redirect($url, $type = '', $message = '') {
    if ($type && $message) {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'text' => $message
        ];
    }
    header('Location: ' . $url);
    exit();
}

/**
 * Get flash message
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

/**
 * Display flash message
 */
function displayFlashMessage() {
    $message = getFlashMessage();
    if ($message) {
        $type = $message['type'];
        $text = $message['text'];
        $icon = $type === 'success' ? 'check-circle' : 'exclamation-circle';
        echo "<div class='alert alert-$type'>
                <i class='fas fa-$icon'></i>
                $text
              </div>";
    }
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require login
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit();
    }
}

/**
 * Get current user
 */
function getCurrentUser() {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    
    $db = getDBConnection();
    
    try {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getCurrentUser: " . $e->getMessage());
        return null;
    }
}
?>