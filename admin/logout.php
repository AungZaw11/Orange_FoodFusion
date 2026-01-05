<?php
session_start();
// Clear admin session
unset($_SESSION['admin_id']);
// Optional: Destroy entire session
session_destroy();
header('Location: index.php');
exit();
?>