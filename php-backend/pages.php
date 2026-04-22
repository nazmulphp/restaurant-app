<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method(); $data = request_data();
if ($method === 'GET') {
    if (($key = query('page_key'))) {
        respond(['success' => true, 'item' => db_one('SELECT * FROM pages WHERE page_key = ?', [$key])]);
    }
    respond(['success' => true, 'items' => db_all('SELECT * FROM pages ORDER BY page_title')]);
}
require_admin();
if ($method === 'POST' && empty($data['id'])) { $id = db_insert('INSERT INTO pages (page_key, page_title, content, seo_title, seo_description, status) VALUES (?, ?, ?, ?, ?, ?)', [trim((string)$data['page_key']), trim((string)$data['page_title']), trim((string)($data['content'] ?? '')), trim((string)($data['seo_title'] ?? '')), trim((string)($data['seo_description'] ?? '')), (int)($data['status'] ?? 1)]); respond(['success' => true, 'id' => $id]); }
$id = (int)($data['id'] ?? query('id', 0)); if ($method === 'PUT' || ($method === 'POST' && ($data['_method'] ?? '') === 'PUT')) { db_exec('UPDATE pages SET page_key=?, page_title=?, content=?, seo_title=?, seo_description=?, status=? WHERE id=?', [trim((string)$data['page_key']), trim((string)$data['page_title']), trim((string)($data['content'] ?? '')), trim((string)($data['seo_title'] ?? '')), trim((string)($data['seo_description'] ?? '')), (int)($data['status'] ?? 1), $id]); respond(['success' => true]); } db_exec('DELETE FROM pages WHERE id=?', [$id]); respond(['success' => true]);
