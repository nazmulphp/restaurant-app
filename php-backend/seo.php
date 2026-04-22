<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method(); $data = request_data();
if ($method === 'GET') {
    if (($route = query('route_key'))) { respond(['success' => true, 'item' => db_one('SELECT * FROM seo_meta WHERE route_key = ?', [$route])]); }
    respond(['success' => true, 'items' => db_all('SELECT * FROM seo_meta ORDER BY route_key')]);
}
require_admin();
if ($method === 'POST' && empty($data['id'])) { $id = db_insert('INSERT INTO seo_meta (route_key, meta_title, meta_description, canonical_url, og_title, og_description, og_image) VALUES (?, ?, ?, ?, ?, ?, ?)', [trim((string)$data['route_key']), trim((string)($data['meta_title'] ?? '')), trim((string)($data['meta_description'] ?? '')), trim((string)($data['canonical_url'] ?? '')), trim((string)($data['og_title'] ?? '')), trim((string)($data['og_description'] ?? '')), trim((string)($data['og_image'] ?? ''))]); respond(['success' => true, 'id' => $id]); }
$id = (int)($data['id'] ?? query('id', 0)); if ($method === 'PUT' || ($method === 'POST' && ($data['_method'] ?? '') === 'PUT')) { db_exec('UPDATE seo_meta SET route_key=?, meta_title=?, meta_description=?, canonical_url=?, og_title=?, og_description=?, og_image=? WHERE id=?', [trim((string)$data['route_key']), trim((string)($data['meta_title'] ?? '')), trim((string)($data['meta_description'] ?? '')), trim((string)($data['canonical_url'] ?? '')), trim((string)($data['og_title'] ?? '')), trim((string)($data['og_description'] ?? '')), trim((string)($data['og_image'] ?? '')), $id]); respond(['success' => true]); } db_exec('DELETE FROM seo_meta WHERE id=?', [$id]); respond(['success' => true]);
