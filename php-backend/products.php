<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method();
$data = request_data();

if ($method === 'GET') {
    [$limit, $offset, $page] = paginate_clause();
    $where = ['1=1'];
    $params = [];
    if (($category = query('category_id'))) { $where[] = 'm.category_id = ?'; $params[] = (int)$category; }
    if (($search = trim((string)query('search', ''))) !== '') { $where[] = '(m.name LIKE ? OR m.description LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
    if (query('featured') === '1') { $where[] = 'm.is_featured = 1'; }
    if (query('available') === '1') { $where[] = 'm.is_available = 1'; }
    $sql = 'SELECT m.*, c.name AS category_name FROM menu_items m LEFT JOIN categories c ON c.id = m.category_id WHERE ' . implode(' AND ', $where) . ' ORDER BY m.id DESC LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
    $items = db_all($sql, $params);
    respond(['success' => true, 'page' => $page, 'items' => $items]);
}

if ($method === 'POST') {
    require_admin();
    $id = db_insert('INSERT INTO menu_items (category_id, name, description, price, sale_price, image_url, is_available, rating, reviews, slug, stock_qty, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
        (int)($data['category_id'] ?? 0), trim((string)($data['name'] ?? '')), trim((string)($data['description'] ?? '')), (float)($data['price'] ?? 0),
        ($data['sale_price'] ?? null) !== '' ? (float)$data['sale_price'] : null, trim((string)($data['image_url'] ?? '')), (int)($data['is_available'] ?? 1),
        (float)($data['rating'] ?? 4.5), (int)($data['reviews'] ?? 0), trim((string)($data['slug'] ?? '')), (int)($data['stock_qty'] ?? 0), (int)($data['is_featured'] ?? 0)
    ]);
    respond(['success' => true, 'id' => $id, 'message' => 'Product created']);
}

require_admin();
$id = (int)($data['id'] ?? query('id', 0));
if ($id <= 0) respond(['success' => false, 'message' => 'Product id required'], 422);
if ($method === 'PUT' || ($method === 'POST' && ($data['_method'] ?? '') === 'PUT')) {
    db_exec('UPDATE menu_items SET category_id=?, name=?, description=?, price=?, sale_price=?, image_url=?, is_available=?, slug=?, stock_qty=?, is_featured=? WHERE id=?', [
        (int)($data['category_id'] ?? 0), trim((string)($data['name'] ?? '')), trim((string)($data['description'] ?? '')), (float)($data['price'] ?? 0),
        ($data['sale_price'] ?? null) !== '' ? (float)$data['sale_price'] : null, trim((string)($data['image_url'] ?? '')), (int)($data['is_available'] ?? 1), trim((string)($data['slug'] ?? '')), (int)($data['stock_qty'] ?? 0), (int)($data['is_featured'] ?? 0), $id
    ]);
    respond(['success' => true, 'message' => 'Product updated']);
}
db_exec('DELETE FROM menu_items WHERE id = ?', [$id]);
respond(['success' => true, 'message' => 'Product deleted']);
