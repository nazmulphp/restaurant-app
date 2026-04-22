<?php
require_once __DIR__ . '/bootstrap.php';

$method = request_method();
$data = request_data();
if ($method === 'POST' && !empty($data['_method'])) {
    $method = strtoupper((string)$data['_method']);
}

try {
    if ($method === 'GET') {
        $user = current_user_full();
        if ($user && !in_array($user['role'], ADMIN_ROLES, true)) {
            $items = db_all('SELECT * FROM orders WHERE customer_id = ? OR customer_email = ? ORDER BY id DESC', [$user['id'], $user['email']]);
            respond(['success' => true, 'items' => $items]);
        }
        require_admin();
        $items = db_all('SELECT * FROM orders ORDER BY id DESC');
        respond(['success' => true, 'items' => $items]);
    }

    require_admin();

    if ($method === 'POST') {
        $customerName = trim((string)($data['customer_name'] ?? ''));
        $totalAmount = (float)($data['total_amount'] ?? 0);
        if ($customerName === '' || $totalAmount <= 0) {
            respond(['success' => false, 'message' => 'Customer name and total amount are required'], 422);
        }
        $id = db_insert('INSERT INTO orders (customer_name, customer_email, customer_phone, delivery_address, total_amount, status, source, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [$customerName, trim((string)($data['customer_email'] ?? '')), trim((string)($data['customer_phone'] ?? '')), trim((string)($data['delivery_address'] ?? '')), $totalAmount, trim((string)($data['status'] ?? 'New')), trim((string)($data['source'] ?? 'Web')), trim((string)($data['payment_status'] ?? 'Pending'))]);
        respond(['success' => true, 'message' => 'Order added', 'id' => $id]);
    }

    if ($method === 'PUT') {
        $id = (int)($data['id'] ?? 0);
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Order id is required'], 422);
        }
        $old = db_one('SELECT status FROM orders WHERE id = ?', [$id]);
        db_exec('UPDATE orders SET customer_name=?, customer_email=?, customer_phone=?, delivery_address=?, total_amount=?, status=?, source=?, payment_status=? WHERE id=?', [trim((string)($data['customer_name'] ?? '')), trim((string)($data['customer_email'] ?? '')), trim((string)($data['customer_phone'] ?? '')), trim((string)($data['delivery_address'] ?? '')), (float)($data['total_amount'] ?? 0), trim((string)($data['status'] ?? 'New')), trim((string)($data['source'] ?? 'Web')), trim((string)($data['payment_status'] ?? 'Pending')), $id]);
        $admin = current_user_full();
        db_insert('INSERT INTO order_status_logs (order_id, old_status, new_status, note, changed_by) VALUES (?, ?, ?, ?, ?)', [$id, $old['status'] ?? null, trim((string)($data['status'] ?? 'New')), trim((string)($data['note'] ?? '')), $admin['id'] ?? null]);
        respond(['success' => true, 'message' => 'Order updated']);
    }

    if ($method === 'DELETE') {
        $id = (int)($data['id'] ?? query('id', 0));
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Order id is required'], 422);
        }
        db_exec('DELETE FROM orders WHERE id = ?', [$id]);
        respond(['success' => true, 'message' => 'Order deleted']);
    }

    respond(['success' => false, 'message' => 'Method not allowed'], 405);
} catch (PDOException $e) {
    respond(['success' => false, 'message' => 'Database error'], 500);
}
