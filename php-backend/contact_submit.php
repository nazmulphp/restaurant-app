<?php
require_once __DIR__ . '/bootstrap.php';
$data = request_data();
$name = trim((string)($data['name'] ?? ''));
$email = trim((string)($data['email'] ?? ''));
$message = trim((string)($data['message'] ?? ''));
if ($name === '' || $email === '' || $message === '') {
    respond(['success' => false, 'message' => 'Please fill all required fields'], 422);
}
$id = db_insert('INSERT INTO contact_messages (name, email, message, status) VALUES (?, ?, ?, ?)', [$name, $email, $message, 'New']);
respond(['success' => true, 'message' => 'Your message has been sent', 'id' => $id]);
