<?php
require_once '../config/database.php';
include 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['export_type'] ?? '';

    // Set headers for download
    header('Content-Type: text/csv');
    switch ($type) {
        case 'recipes':
            header('Content-Disposition: attachment; filename="orange_recipes_' . date('Y-m-d') . '.csv"');
            $fields = ['ID', 'Title', 'Author', 'Cuisine', 'Diet', 'Difficulty', 'Cooking Time (min)', 'Servings', 'Featured', 'Created'];
            $stmt = $pdo->query("
                SELECT r.id, r.title, CONCAT(u.first_name, ' ', u.last_name) as author,
                       r.cuisine_type, r.dietary_preference, r.difficulty_level,
                       r.cooking_time, r.servings, r.is_featured, r.created_at
                FROM recipes r
                JOIN users u ON r.user_id = u.id
                ORDER BY r.created_at DESC
            ");
            break;
        case 'contacts':
            header('Content-Disposition: attachment; filename="orange_contacts_' . date('Y-m-d') . '.csv"');
            $fields = ['ID', 'Name', 'Email', 'Subject', 'Message', 'Read', 'Date'];
            $stmt = $pdo->query("
                SELECT id, name, email, subject, message, is_read, created_at
                FROM contact_messages
                ORDER BY created_at DESC
            ");
            break;
        case 'users':
            header('Content-Disposition: attachment; filename="orange_users_' . date('Y-m-d') . '.csv"');
            $fields = ['ID', 'Name', 'Email', 'Admin', 'Created'];
            $stmt = $pdo->query("
                SELECT id, CONCAT(first_name, ' ', last_name) as name, email, is_admin, created_at
                FROM users
                ORDER BY created_at DESC
            ");
            break;
        default:
            die('Invalid export type.');
    }

    $output = fopen('php://output', 'w');
    fputcsv($output, $fields);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Clean and format
        $row = array_map(function($value) {
            if (is_bool($value)) return $value ? 'Yes' : 'No';
            if (is_null($value)) return '';
            return str_replace(["\r", "\n"], ' ', $value); // Prevent CSV break
        }, $row);
        fputcsv($output, $row);
    }

    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Download Reports | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root { --primary-orange: #FF6B00; }
        body { font-family: Arial; background: #f5f7fa; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; padding: 0 20px; }
        .header h1 { color: var(--primary-orange); text-align: center; margin-bottom: 30px; }
        .export-card {
            background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .export-card h3 {
            margin-bottom: 15px; color: var(--primary-orange);
        }
        .export-card p { margin-bottom: 20px; color: #666; }
        .btn {
            display: block; width: 100%; padding: 12px;
            background: var(--primary-orange); color: white; border: none;
            border-radius: 4px; font-size: 1rem; cursor: pointer;
            text-align: center; text-decoration: none;
        }
        .btn:hover { background: var(--orange-dark); }
        form { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Download Reports</h1>
        </div>

        <div class="export-card">
            <h3><i class="fas fa-utensils"></i> Recipes Export</h3>
            <p>Download all recipes with author, cuisine, time, and more.</p>
            <form method="POST">
                <input type="hidden" name="export_type" value="recipes">
                <button type="submit" class="btn">Download Recipes CSV</button>
            </form>
        </div>

        <div class="export-card">
            <h3><i class="fas fa-envelope"></i> Contact Messages</h3>
            <p>Export all user inquiries and messages.</p>
            <form method="POST">
                <input type="hidden" name="export_type" value="contacts">
                <button type="submit" class="btn">Download Contacts CSV</button>
            </form>
        </div>

        <div class="export-card">
            <h3><i class="fas fa-users"></i> User List</h3>
            <p>Export registered users (emails, names, admin status).</p>
            <form method="POST">
                <input type="hidden" name="export_type" value="users">
                <button type="submit" class="btn">Download Users CSV</button>
            </form>
        </div>
    </div>
</body>
</html>