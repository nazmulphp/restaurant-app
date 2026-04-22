<?php
require_once 'config.php';
require_once 'auth.php';

require_auth(['Super Admin', 'Admin', 'Manager', 'Store Manager']);

try {
    $stats = [];
    $stmt = $pdo->query("SELECT SUM(total_amount) as total FROM orders WHERE DATE(created_at) = CURDATE()");
    $res = $stmt->fetch();
    $stats['salesToday'] = (float)($res['total'] ?? 0);

    $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE status IN ('New', 'Preparing', 'Ready')");
    $res = $stmt->fetch();
    $stats['activeOrders'] = (int)$res['count'];

    $stmt = $pdo->query("SELECT COUNT(*) as count FROM inventory WHERE status IN ('LOW', 'CRITICAL')");
    $res = $stmt->fetch();
    $stats['lowStock'] = (int)$res['count'];

    $stmt = $pdo->query('SELECT name FROM menu_items ORDER BY reviews DESC LIMIT 1');
    $res = $stmt->fetch();
    $stats['topSelling'] = $res['name'] ?? 'N/A';

    $stmt = $pdo->query("SELECT COUNT(*) as count FROM purchase_orders WHERE status = 'SENT'");
    $res = $stmt->fetch();
    $stats['pendingPOs'] = (int)$res['count'];

    json_response($stats);
} catch (PDOException $e) {
    json_response(['error' => 'Database error'], 500);
}
