<?php
require_once __DIR__ . '/helpers.php';
$orderId = isset($_GET['order_id']) ? (int) $_GET['order_id'] : 0;
if ($orderId < 1) {
    json_response(['success' => false, 'message' => 'Invalid order id.'], 422);
}

try {
    $orderStmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
    $orderStmt->execute([$orderId]);
    $order = $orderStmt->fetch();
    if (!$order) {
        json_response(['success' => false, 'message' => 'Order not found.'], 404);
    }

    $itemsStmt = $pdo->prepare("SELECT oi.*, m.name, m.image_url
        FROM order_items oi
        LEFT JOIN menu_items m ON m.id = oi.menu_item_id
        WHERE oi.order_id = ?");
    $itemsStmt->execute([$orderId]);

    json_response([
        'success' => true,
        'order' => $order,
        'items' => $itemsStmt->fetchAll(),
    ]);
} catch (Throwable $e) {
    json_response(['success' => false, 'message' => $e->getMessage()], 500);
}
