<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare("
    SELECT resource_name, download_count, last_downloaded
    FROM resource_downloads
    WHERE user_id = ?
    ORDER BY last_downloaded DESC
");
$stmt->execute([$_SESSION['user_id']]);
$downloads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>My Downloads</h2>
    <table>
        <thead>
            <tr>
                <th>Resource</th>
                <th>Downloads</th>
                <th>Last Downloaded</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($downloads as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['resource_name']) ?></td>
                <td><?= $d['download_count'] ?></td>
                <td><?= date('M j, Y g:i A', strtotime($d['last_downloaded'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>