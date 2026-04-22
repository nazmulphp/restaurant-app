<?php
require_once __DIR__ . '/bootstrap.php';
$action = query('action', 'me');
$data = request_data();

if ($action === 'register' && request_method() === 'POST') {
    $name = trim((string)($data['name'] ?? ''));
    $email = trim((string)($data['email'] ?? ''));
    $password = (string)($data['password'] ?? '');
    if ($name === '' || $email === '' || $password === '') {
        respond(['success' => false, 'message' => 'Name, email, and password are required'], 422);
    }
    if (db_one('SELECT id FROM users WHERE email = ?', [$email])) {
        respond(['success' => false, 'message' => 'Email already exists'], 409);
    }
    $id = db_insert('INSERT INTO users (name, email, password, role, phone, address) VALUES (?, ?, ?, ?, ?, ?)', [
        $name, $email, password_hash_if_needed($password), 'Customer', trim((string)($data['phone'] ?? '')), trim((string)($data['address'] ?? ''))
    ]);
    $user = db_one('SELECT id, name, email, role FROM users WHERE id = ?', [$id]);
    set_current_user($user);
    respond(['success' => true, 'message' => 'Registration successful', 'user' => $user]);
}

if ($action === 'login' && request_method() === 'POST') {
    $email = trim((string)($data['email'] ?? ''));
    $password = (string)($data['password'] ?? '');
    $user = db_one('SELECT * FROM users WHERE email = ?', [$email]);
    if (!$user || !verify_password_compat($password, $user['password'])) {
        respond(['success' => false, 'message' => 'Invalid email or password'], 401);
    }
    set_current_user($user);
    respond(['success' => true, 'message' => 'Login successful', 'user' => current_user_full()]);
}

if ($action === 'logout') {
    $_SESSION = [];
    session_destroy();
    respond(['success' => true, 'message' => 'Logged out']);
}

if ($action === 'forgot' && request_method() === 'POST') {
    $email = trim((string)($data['email'] ?? ''));
    respond(['success' => true, 'message' => 'Reset flow placeholder created', 'email' => $email]);
}

$user = current_user_full();
respond(['success' => true, 'user' => $user]);
