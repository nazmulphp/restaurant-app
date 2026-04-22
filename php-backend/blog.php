<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method();
$data = request_data();
if ($method === 'GET') {
    $type = query('type', 'posts');
    if ($type === 'categories') {
        respond(['success' => true, 'items' => db_all('SELECT * FROM blog_categories ORDER BY name')]);
    }
    $status = query('status', 'published');
    $where = '1=1'; $params = [];
    if ($status !== 'all') { $where .= ' AND p.status = ?'; $params[] = $status; }
    if (($slug = query('slug'))) { $where .= ' AND p.slug = ?'; $params[] = $slug; }
    $items = db_all('SELECT p.*, c.name AS category_name FROM blog_posts p LEFT JOIN blog_categories c ON c.id = p.category_id WHERE ' . $where . ' ORDER BY COALESCE(p.published_at, p.created_at) DESC', $params);
    respond(['success' => true, 'items' => $items]);
}
require_admin();
$type = $data['type'] ?? 'posts';
if ($type === 'categories') {
    if ($method === 'POST' && empty($data['id'])) {
        $id = db_insert('INSERT INTO blog_categories (name, slug, status) VALUES (?, ?, ?)', [trim((string)$data['name']), trim((string)$data['slug']), (int)($data['status'] ?? 1)]);
        respond(['success' => true, 'id' => $id]);
    }
    $id = (int)($data['id'] ?? query('id', 0));
    if ($method === 'PUT' || ($method === 'POST' && ($data['_method'] ?? '') === 'PUT')) { db_exec('UPDATE blog_categories SET name=?, slug=?, status=? WHERE id=?', [trim((string)$data['name']), trim((string)$data['slug']), (int)($data['status'] ?? 1), $id]); respond(['success' => true]); }
    db_exec('DELETE FROM blog_categories WHERE id=?', [$id]); respond(['success' => true]);
}
if ($method === 'POST' && empty($data['id'])) {
    $id = db_insert('INSERT INTO blog_posts (category_id, title, slug, excerpt, content, image_url, status, is_featured, seo_title, seo_description, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [(int)($data['category_id'] ?? 0) ?: null, trim((string)$data['title']), trim((string)$data['slug']), trim((string)($data['excerpt'] ?? '')), trim((string)($data['content'] ?? '')), trim((string)($data['image_url'] ?? '')), trim((string)($data['status'] ?? 'draft')), (int)($data['is_featured'] ?? 0), trim((string)($data['seo_title'] ?? '')), trim((string)($data['seo_description'] ?? '')), ($data['published_at'] ?? null) ?: null]);
    respond(['success' => true, 'id' => $id]);
}
$id = (int)($data['id'] ?? query('id', 0));
if ($method === 'PUT' || ($method === 'POST' && ($data['_method'] ?? '') === 'PUT')) { db_exec('UPDATE blog_posts SET category_id=?, title=?, slug=?, excerpt=?, content=?, image_url=?, status=?, is_featured=?, seo_title=?, seo_description=?, published_at=? WHERE id=?', [(int)($data['category_id'] ?? 0) ?: null, trim((string)$data['title']), trim((string)$data['slug']), trim((string)($data['excerpt'] ?? '')), trim((string)($data['content'] ?? '')), trim((string)($data['image_url'] ?? '')), trim((string)($data['status'] ?? 'draft')), (int)($data['is_featured'] ?? 0), trim((string)($data['seo_title'] ?? '')), trim((string)($data['seo_description'] ?? '')), ($data['published_at'] ?? null) ?: null, $id]); respond(['success' => true]); }
db_exec('DELETE FROM blog_posts WHERE id=?', [$id]); respond(['success' => true]);
