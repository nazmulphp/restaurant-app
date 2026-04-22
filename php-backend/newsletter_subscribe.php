<?php
require_once __DIR__ . '/bootstrap.php';
$data = request_data();
$email = trim((string)($data['email'] ?? ''));
if ($email === '') {
    respond(['success' => false, 'message' => 'Email is required'], 422);
}
db_exec('INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)', [$email]);
respond(['success' => true, 'message' => 'Thanks for joining our newsletter']);
