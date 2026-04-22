<?php
header('Content-Type: application/json');
require_once 'config.php';
try {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
    $categories = $stmt->fetchAll();
    echo json_encode($categories);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error']);
}
?>
