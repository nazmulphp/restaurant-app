<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method(); $data = request_data();
if ($method === 'POST' && empty($data['admin_action'])) {
    $id = db_insert('INSERT INTO contact_messages (name, email, message, status) VALUES (?, ?, ?, ?)', [trim((string)$data['name']), trim((string)$data['email']), trim((string)$data['message']), 'New']);
    respond(['success' => true, 'id' => $id, 'message' => 'Message sent']);
}
require_admin();
if ($method === 'GET') { respond(['success' => true, 'items' => db_all('SELECT * FROM contact_messages ORDER BY id DESC')]); }
$id = (int)($data['id'] ?? query('id', 0));
if ($method === 'PUT' || ($method === 'POST' && !empty($data['admin_action']))) { db_exec('UPDATE contact_messages SET status=? WHERE id=?', [trim((string)($data['status'] ?? 'Read')), $id]); respond(['success' => true]); }
db_exec('DELETE FROM contact_messages WHERE id=?', [$id]); respond(['success' => true]);
