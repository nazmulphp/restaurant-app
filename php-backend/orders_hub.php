<?php
require_once 'config.php';
require_once 'auth.php';

require_auth(['Super Admin', 'Admin', 'Manager', 'Store Manager', 'Kitchen Admin']);

try {
    $stmt = $pdo->query('SELECT * FROM orders ORDER BY created_at DESC LIMIT 10');
    $orders = $stmt->fetchAll();
    json_response($orders);
} catch (PDOException $e) {
    json_response(['error' => 'Database error'], 500);
}
