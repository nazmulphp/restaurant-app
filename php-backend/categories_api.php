<?php
require_once __DIR__ . '/bootstrap.php';

$method = request_method();
$data = request_data();
if ($method === 'POST' && !empty($data['_method'])) {
    $method = strtoupper((string)$data['_method']);
}

try {
    if ($method === 'GET') {
        respond(['success' => true, 'items' => db_all('SELECT id, name, COALESCE(slug, "") AS slug, COALESCE(image_url, "") AS image_url, COALESCE(status, 1) AS status, created_at FROM categories ORDER BY id DESC')]);
    }

    require_admin();

    if ($method === 'POST') {
        $name = trim((string)($data['name'] ?? ''));
        if ($name === '') {
            respond(['success' => false, 'message' => 'Category name is required'], 422);
        }
        $slug = trim((string)($data['slug'] ?? ''));
        $imageUrl = trim((string)($data['image_url'] ?? ''));
        $status = (int)($data['status'] ?? 1);
        $id = db_insert('INSERT INTO categories (name, slug, image_url, status) VALUES (?, ?, ?, ?)', [$name, $slug, $imageUrl, $status]);
        respond(['success' => true, 'message' => 'Category added', 'id' => $id]);
    }

    if ($method === 'PUT') {
        $id = (int)($data['id'] ?? 0);
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Category id is required'], 422);
        }
        db_exec('UPDATE categories SET name=?, slug=?, image_url=?, status=? WHERE id=?', [trim((string)($data['name'] ?? '')), trim((string)($data['slug'] ?? '')), trim((string)($data['image_url'] ?? '')), (int)($data['status'] ?? 1), $id]);
        respond(['success' => true, 'message' => 'Category updated']);
    }

    if ($method === 'DELETE') {
        $id = (int)($data['id'] ?? query('id', 0));
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Category id is required'], 422);
        }
        $inUse = db_one('SELECT id FROM menu_items WHERE category_id = ? LIMIT 1', [$id]);
        if ($inUse) {
            respond(['success' => false, 'message' => 'This category has menu items. Remove them first.'], 422);
        }
        db_exec('DELETE FROM categories WHERE id=?', [$id]);
        respond(['success' => true, 'message' => 'Category deleted']);
    }

    respond(['success' => false, 'message' => 'Method not allowed'], 405);
} catch (PDOException $e) {
    if ((string)$e->getCode() === '23000') {
        respond(['success' => false, 'message' => 'Category already exists'], 409);
    }
    respond(['success' => false, 'message' => 'Database error'], 500);
}
