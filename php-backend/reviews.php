<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method();
$data = request_data();
if ($method === 'GET') {
    $productId = (int)query('menu_item_id', 0);
    $status = query('status', 'Approved');
    $sql = 'SELECT * FROM product_reviews WHERE 1=1';
    $params = [];
    if ($productId) { $sql .= ' AND menu_item_id = ?'; $params[] = $productId; }
    if ($status !== 'all') { $sql .= ' AND status = ?'; $params[] = $status; }
    $sql .= ' ORDER BY id DESC';
    respond(['success' => true, 'items' => db_all($sql, $params)]);
}
if ($method === 'POST' && empty($data['admin_update'])) {
    $user = current_user_full();
    $id = db_insert('INSERT INTO product_reviews (menu_item_id, user_id, customer_name, customer_email, rating, review_text, status) VALUES (?, ?, ?, ?, ?, ?, ?)', [
        (int)($data['menu_item_id'] ?? 0), $user['id'] ?? null, trim((string)($data['customer_name'] ?? ($user['name'] ?? 'Guest'))), trim((string)($data['customer_email'] ?? ($user['email'] ?? 'guest@example.com'))),
        max(1, min(5, (int)($data['rating'] ?? 5))), trim((string)($data['review_text'] ?? '')), 'Pending'
    ]);
    respond(['success' => true, 'id' => $id, 'message' => 'Review submitted']);
}
require_admin();
$id = (int)($data['id'] ?? query('id', 0));
if ($method === 'PUT' || ($method === 'POST' && !empty($data['admin_update']))) {
    db_exec('UPDATE product_reviews SET status = ?, rating = ?, review_text = ? WHERE id = ?', [trim((string)($data['status'] ?? 'Approved')), max(1, min(5, (int)($data['rating'] ?? 5))), trim((string)($data['review_text'] ?? '')), $id]);
    respond(['success' => true]);
}
db_exec('DELETE FROM product_reviews WHERE id = ?', [$id]);
respond(['success' => true]);
