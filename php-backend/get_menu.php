<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT m.*, c.name as category_name 
        FROM menu_items m 
        JOIN categories c ON m.category_id = c.id 
        WHERE m.is_available = TRUE
    ");
    $menu = $stmt->fetchAll();
    echo json_encode($menu);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
