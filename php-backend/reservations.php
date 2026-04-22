<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method();
$data = request_data();
if ($method === 'GET') {
    if (current_user_full() && in_array(current_user_full()['role'], ADMIN_ROLES, true)) {
        respond(['success' => true, 'items' => db_all('SELECT * FROM reservations ORDER BY reservation_date DESC, reservation_time DESC')]);
    }
    respond(['success' => true, 'items' => []]);
}
if ($method === 'POST' && empty($data['id'])) {
    $id = db_insert('INSERT INTO reservations (name, email, phone, reservation_date, reservation_time, guest_count, special_note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [trim((string)$data['name']), trim((string)$data['email']), trim((string)$data['phone']), trim((string)$data['reservation_date']), trim((string)$data['reservation_time']), (int)($data['guest_count'] ?? 1), trim((string)($data['special_note'] ?? '')), 'Pending']);
    respond(['success' => true, 'id' => $id, 'message' => 'Reservation created']);
}
require_admin();
$id = (int)($data['id'] ?? query('id', 0));
if ($method === 'PUT' || ($method === 'POST' && ($data['_method'] ?? '') === 'PUT')) {
    db_exec('UPDATE reservations SET status=?, special_note=? WHERE id=?', [trim((string)$data['status']), trim((string)($data['special_note'] ?? '')), $id]);
    respond(['success' => true]);
}
db_exec('DELETE FROM reservations WHERE id=?', [$id]);
respond(['success' => true]);
