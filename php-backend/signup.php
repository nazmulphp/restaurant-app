<?php
require_once __DIR__ . '/bootstrap.php';

$data = request_data();
$name = trim((string)($data['name'] ?? ''));
$email = trim((string)($data['email'] ?? ''));
$password = trim((string)($data['password'] ?? ''));
$requestedRole = trim((string)($data['role'] ?? ''));
$currentUser = current_user_full();

if ($name === '' || $email === '' || $password === '') {
    respond(['success' => false, 'message' => 'All fields are required'], 400);
}

$allowedRoles = ['Super Admin', 'Admin', 'Manager', 'Vendor', 'Customer', 'Store Manager', 'Kitchen Admin'];
$role = 'Admin';

if ($requestedRole !== '') {
    if ($currentUser && in_array($currentUser['role'], ['Super Admin', 'Admin'], true) && in_array($requestedRole, $allowedRoles, true)) {
        $role = $requestedRole;
    } elseif (in_array($requestedRole, ['Admin', 'Customer'], true)) {
        $role = $requestedRole;
    }
}

try {
    $id = db_insert('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)', [$name, $email, password_hash_if_needed($password), $role]);
    respond(['success' => true, 'message' => 'Account created successfully', 'user' => ['id' => $id, 'name' => $name, 'email' => $email, 'role' => $role]], 201);
} catch (PDOException $e) {
    if ((string)$e->getCode() === '23000') {
        respond(['success' => false, 'message' => 'Email already exists'], 409);
    }
    respond(['success' => false, 'message' => 'Signup failed'], 500);
}
