<?php
require_once __DIR__ . '/bootstrap.php';
$user = require_login();
$method = request_method();
$data = request_data();
if ($method === 'GET') {
    $items = db_all('SELECT w.id, w.menu_item_id, m.name, m.price, m.image_url, m.description FROM wishlists w JOIN menu_items m ON m.id = w.menu_item_id WHERE w.user_id = ? ORDER BY w.id DESC', [$user['id']]);
    respond(['success' => true, 'items' => $items]);
}
$productId = (int)($data['menu_item_id'] ?? $data['product_id'] ?? query('menu_item_id', 0));
if ($method === 'POST') {
    db_exec('INSERT IGNORE INTO wishlists (user_id, menu_item_id) VALUES (?, ?)', [$user['id'], $productId]);
    respond(['success' => true, 'message' => 'Added to wishlist']);
}
db_exec('DELETE FROM wishlists WHERE user_id = ? AND menu_item_id = ?', [$user['id'], $productId]);
respond(['success' => true, 'message' => 'Removed from wishlist']);
