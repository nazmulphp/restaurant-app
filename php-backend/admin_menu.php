<?php
require_once __DIR__ . '/bootstrap.php';

require_admin();
$method = request_method();
$data = request_data();
if ($method === 'POST' && !empty($data['_method'])) {
    $method = strtoupper((string)$data['_method']);
}

try {
    if ($method === 'GET') {
        $items = db_all('SELECT m.*, c.name AS category_name FROM menu_items m LEFT JOIN categories c ON c.id = m.category_id ORDER BY m.id DESC');
        respond(['success' => true, 'items' => $items]);
    }

    if ($method === 'POST') {
        $name = trim((string)($data['name'] ?? ''));
        $price = (float)($data['price'] ?? 0);
        if ($name === '' || $price <= 0) {
            respond(['success' => false, 'message' => 'Name and price are required'], 422);
        }
        $id = db_insert(
            'INSERT INTO menu_items (category_id, name, description, price, image_url, is_available, slug, stock_qty, is_featured, sale_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['category_id'] !== '' ? (int)($data['category_id'] ?? 0) : null,
                $name,
                trim((string)($data['description'] ?? '')),
                $price,
                trim((string)($data['image_url'] ?? '')),
                (int)($data['is_available'] ?? 1),
                trim((string)($data['slug'] ?? '')),
                (int)($data['stock_qty'] ?? 0),
                (int)($data['is_featured'] ?? 0),
                ($data['sale_price'] ?? '') !== '' ? (float)$data['sale_price'] : null
            ]
        );
        respond(['success' => true, 'message' => 'Menu item added', 'id' => $id]);
    }

    if ($method === 'PUT') {
        $id = (int)($data['id'] ?? 0);
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Menu item id is required'], 422);
        }
        db_exec(
            'UPDATE menu_items SET category_id=?, name=?, description=?, price=?, image_url=?, is_available=?, slug=?, stock_qty=?, is_featured=?, sale_price=? WHERE id=?',
            [
                $data['category_id'] !== '' ? (int)($data['category_id'] ?? 0) : null,
                trim((string)($data['name'] ?? '')),
                trim((string)($data['description'] ?? '')),
                (float)($data['price'] ?? 0),
                trim((string)($data['image_url'] ?? '')),
                (int)($data['is_available'] ?? 1),
                trim((string)($data['slug'] ?? '')),
                (int)($data['stock_qty'] ?? 0),
                (int)($data['is_featured'] ?? 0),
                ($data['sale_price'] ?? '') !== '' ? (float)$data['sale_price'] : null,
                $id
            ]
        );
        respond(['success' => true, 'message' => 'Menu item updated']);
    }

    if ($method === 'DELETE') {
        $id = (int)($data['id'] ?? query('id', 0));
        if ($id <= 0) {
            respond(['success' => false, 'message' => 'Menu item id is required'], 422);
        }
        db_exec('DELETE FROM menu_items WHERE id = ?', [$id]);
        respond(['success' => true, 'message' => 'Menu item deleted']);
    }

    respond(['success' => false, 'message' => 'Method not allowed'], 405);
} catch (PDOException $e) {
    respond(['success' => false, 'message' => 'Database error'], 500);
}
