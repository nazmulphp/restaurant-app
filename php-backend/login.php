<?php
require_once __DIR__ . '/bootstrap.php';

$data = request_data();
$email = trim((string)($data['email'] ?? ''));
$password = trim((string)($data['password'] ?? ''));

if ($email === '' || $password === '') {
    respond(['success' => false, 'message' => 'Email and password are required'], 400);
}

try {
    $user = db_one('SELECT id, name, email, password, role FROM users WHERE email = ? LIMIT 1', [$email]);
    if (!$user || !verify_password_compat($password, $user['password'])) {
        respond(['success' => false, 'message' => 'Invalid email or password'], 401);
    }

    set_current_user($user);
    respond([
        'success' => true,
        'message' => 'Login successful',
        'token' => session_id(),
        'user' => [
            'id' => (int)$user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ]
    ]);
} catch (PDOException $e) {
    respond(['success' => false, 'message' => 'Database error'], 500);
}
