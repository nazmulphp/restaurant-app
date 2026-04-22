<?php
require_once __DIR__ . '/bootstrap.php';
$user = require_login();
$data = request_data();
$method = request_method();

if ($method === 'GET') {
    $full = db_one('SELECT id, name, email, role, phone, address, created_at FROM users WHERE id = ?', [$user['id']]);
    respond(['success' => true, 'user' => $full]);
}

if (($data['action'] ?? '') === 'change_password') {
    $current = (string)($data['current_password'] ?? '');
    $new = (string)($data['new_password'] ?? '');
    $dbUser = db_one('SELECT * FROM users WHERE id = ?', [$user['id']]);
    if (!$dbUser || !verify_password_compat($current, $dbUser['password'])) {
        respond(['success' => false, 'message' => 'Current password is wrong'], 422);
    }
    db_exec('UPDATE users SET password = ? WHERE id = ?', [password_hash_if_needed($new), $user['id']]);
    respond(['success' => true, 'message' => 'Password changed']);
}

$name = trim((string)($data['name'] ?? $user['name']));
$phone = trim((string)($data['phone'] ?? ''));
$address = trim((string)($data['address'] ?? ''));
db_exec('UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?', [$name, $phone, $address, $user['id']]);
$_SESSION['auth_user']['name'] = $name;
respond(['success' => true, 'message' => 'Profile updated']);
