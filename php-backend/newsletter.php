<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method(); $data = request_data();
if ($method === 'POST' && empty($data['admin_action'])) {
    $email = trim((string)$data['email']);
    db_exec('INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)', [$email]);
    respond(['success' => true, 'message' => 'Subscribed']);
}
require_admin();
if ($method === 'GET') respond(['success' => true, 'items' => db_all('SELECT * FROM newsletter_subscribers ORDER BY id DESC')]);
$id = (int)($data['id'] ?? query('id', 0)); db_exec('DELETE FROM newsletter_subscribers WHERE id=?', [$id]); respond(['success' => true]);
