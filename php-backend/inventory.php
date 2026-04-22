<?php
require_once __DIR__ . '/bootstrap.php';

require_login(['Super Admin', 'Admin', 'Manager', 'Store Manager']);
$method = request_method();
$data = request_data();
if ($method === 'POST' && !empty($data['_method'])) {
    $method = strtoupper((string)$data['_method']);
}

try {
    if ($method === 'GET') {
        respond(['success' => true, 'items' => db_all('SELECT * FROM inventory ORDER BY id DESC')]);
    }

    if ($method === 'POST') {
        $name = trim((string)($data['item_name'] ?? ''));
        if ($name === '') {
            respond(['success' => false, 'message' => 'Item name is required'], 422);
        }
        $id = db_insert('INSERT INTO inventory (item_name, current_stock, min_stock, unit, status) VALUES (?, ?, ?, ?, ?)', [$name, (int)($data['current_stock'] ?? 0), (int)($data['min_stock'] ?? 0), trim((string)($data['unit'] ?? 'units')), trim((string)($data['status'] ?? 'OK'))]);
        respond(['success' => true, 'message' => 'Inventory item added', 'id' => $id]);
    }

    if ($method === 'PUT') {
        $id = (int)($data['id'] ?? 0);
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Inventory id is required'], 422);
        }
        db_exec('UPDATE inventory SET item_name=?, current_stock=?, min_stock=?, unit=?, status=? WHERE id=?', [trim((string)($data['item_name'] ?? '')), (int)($data['current_stock'] ?? 0), (int)($data['min_stock'] ?? 0), trim((string)($data['unit'] ?? 'units')), trim((string)($data['status'] ?? 'OK')), $id]);
        respond(['success' => true, 'message' => 'Inventory item updated']);
    }

    if ($method === 'DELETE') {
        $id = (int)($data['id'] ?? query('id', 0));
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Inventory id is required'], 422);
        }
        db_exec('DELETE FROM inventory WHERE id = ?', [$id]);
        respond(['success' => true, 'message' => 'Inventory item deleted']);
    }

    respond(['success' => false, 'message' => 'Method not allowed'], 405);
} catch (PDOException $e) {
    respond(['success' => false, 'message' => 'Database error'], 500);
}
