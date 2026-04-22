<?php
require_once __DIR__ . '/bootstrap.php';

require_admin();
$method = request_method();
$data = request_data();
if ($method === 'POST' && !empty($data['_method'])) {
    $method = strtoupper((string)$data['_method']);
}

try {
    if ($method === 'GET') {
        $items = db_all('SELECT id, name, email, role, phone, address, created_at FROM users ORDER BY id DESC');
        respond(['success' => true, 'items' => $items]);
    }

    if ($method === 'POST') {
        $name = trim((string)($data['name'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $password = (string)($data['password'] ?? '');
        $role = trim((string)($data['role'] ?? 'Admin'));
        $phone = trim((string)($data['phone'] ?? ''));
        $address = trim((string)($data['address'] ?? ''));

        if ($name === '' || $email === '' || $password === '') {
            respond(['success' => false, 'message' => 'Name, email and password are required'], 422);
        }

        $id = db_insert(
            'INSERT INTO users (name, email, password, role, phone, address) VALUES (?, ?, ?, ?, ?, ?)',
            [$name, $email, password_hash_if_needed($password), $role, $phone, $address]
        );
        respond(['success' => true, 'message' => 'User added', 'id' => $id]);
    }

    if ($method === 'PUT') {
        $id = (int)($data['id'] ?? 0);
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'User id is required'], 422);
        }
        $old = db_one('SELECT * FROM users WHERE id = ?', [$id]);
        if (!$old) {
            respond(['success' => false, 'message' => 'User not found'], 404);
        }

        $name = trim((string)($data['name'] ?? $old['name']));
        $email = trim((string)($data['email'] ?? $old['email']));
        $role = trim((string)($data['role'] ?? $old['role']));
        $phone = trim((string)($data['phone'] ?? ($old['phone'] ?? '')));
        $address = trim((string)($data['address'] ?? ($old['address'] ?? '')));
        $password = (string)($data['password'] ?? '');

        if ($password !== '') {
            db_exec('UPDATE users SET name=?, email=?, role=?, phone=?, address=?, password=? WHERE id=?', [$name, $email, $role, $phone, $address, password_hash_if_needed($password), $id]);
        } else {
            db_exec('UPDATE users SET name=?, email=?, role=?, phone=?, address=? WHERE id=?', [$name, $email, $role, $phone, $address, $id]);
        }
        respond(['success' => true, 'message' => 'User updated']);
    }

    if ($method === 'DELETE') {
        $id = (int)($data['id'] ?? query('id', 0));
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'User id is required'], 422);
        }
        $current = current_user_full();
        if ($current && (int)$current['id'] === $id) {
            respond(['success' => false, 'message' => 'You cannot delete your own account'], 422);
        }
        db_exec('DELETE FROM users WHERE id = ?', [$id]);
        respond(['success' => true, 'message' => 'User deleted']);
    }

    respond(['success' => false, 'message' => 'Method not allowed'], 405);
} catch (PDOException $e) {
    if ((string)$e->getCode() === '23000') {
        respond(['success' => false, 'message' => 'Email already exists'], 409);
    }
    respond(['success' => false, 'message' => 'Database error'], 500);
}
