<?php
require_once __DIR__ . '/bootstrap.php';

require_login(['Super Admin', 'Admin', 'Manager', 'Vendor']);
$method = request_method();
$data = request_data();
if ($method === 'POST' && !empty($data['_method'])) {
    $method = strtoupper((string)$data['_method']);
}

try {
    if ($method === 'GET') {
        respond(['success' => true, 'items' => db_all('SELECT * FROM suppliers ORDER BY id DESC')]);
    }

    if ($method === 'POST') {
        $name = trim((string)($data['name'] ?? ''));
        if ($name === '') {
            respond(['success' => false, 'message' => 'Supplier name is required'], 422);
        }
        $id = db_insert('INSERT INTO suppliers (name, contact_person, phone, email, category, status, delivery_days) VALUES (?, ?, ?, ?, ?, ?, ?)', [$name, trim((string)($data['contact_person'] ?? '')), trim((string)($data['phone'] ?? '')), trim((string)($data['email'] ?? '')), trim((string)($data['category'] ?? '')), trim((string)($data['status'] ?? 'ACTIVE')), trim((string)($data['delivery_days'] ?? ''))]);
        respond(['success' => true, 'message' => 'Supplier added', 'id' => $id]);
    }

    if ($method === 'PUT') {
        $id = (int)($data['id'] ?? 0);
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Supplier id is required'], 422);
        }
        db_exec('UPDATE suppliers SET name=?, contact_person=?, phone=?, email=?, category=?, status=?, delivery_days=? WHERE id=?', [trim((string)($data['name'] ?? '')), trim((string)($data['contact_person'] ?? '')), trim((string)($data['phone'] ?? '')), trim((string)($data['email'] ?? '')), trim((string)($data['category'] ?? '')), trim((string)($data['status'] ?? 'ACTIVE')), trim((string)($data['delivery_days'] ?? '')), $id]);
        respond(['success' => true, 'message' => 'Supplier updated']);
    }

    if ($method === 'DELETE') {
        $id = (int)($data['id'] ?? query('id', 0));
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Supplier id is required'], 422);
        }
        db_exec('DELETE FROM suppliers WHERE id = ?', [$id]);
        respond(['success' => true, 'message' => 'Supplier deleted']);
    }

    respond(['success' => false, 'message' => 'Method not allowed'], 405);
} catch (PDOException $e) {
    respond(['success' => false, 'message' => 'Database error'], 500);
}
