<?php
require_once __DIR__ . '/bootstrap.php';
$method = request_method();
$data = request_data();
if ($method === 'GET' && query('validate')) {
    $code = trim((string)query('validate'));
    $amount = (float)query('amount', 0);
    $coupon = db_one('SELECT * FROM coupons WHERE code = ? AND status = 1', [$code]);
    if (!$coupon) respond(['success' => false, 'message' => 'Invalid coupon'], 404);
    if ($coupon['expires_at'] && strtotime($coupon['expires_at']) < time()) respond(['success' => false, 'message' => 'Coupon expired'], 422);
    if ($amount < (float)$coupon['min_order_amount']) respond(['success' => false, 'message' => 'Minimum order amount not met'], 422);
    $discount = $coupon['discount_type'] === 'percent' ? ($amount * ((float)$coupon['discount_value'] / 100)) : (float)$coupon['discount_value'];
    respond(['success' => true, 'coupon' => $coupon, 'discount' => round(min($discount, $amount), 2)]);
}
if ($method === 'GET') respond(['success' => true, 'items' => db_all('SELECT * FROM coupons ORDER BY id DESC')]);
require_admin();
if ($method === 'POST' && empty($data['id'])) {
    $id = db_insert('INSERT INTO coupons (code, title, discount_type, discount_value, min_order_amount, max_uses, starts_at, expires_at, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [trim((string)$data['code']), trim((string)$data['title']), trim((string)($data['discount_type'] ?? 'fixed')), (float)($data['discount_value'] ?? 0), (float)($data['min_order_amount'] ?? 0), ($data['max_uses'] ?? null) !== '' ? (int)$data['max_uses'] : null, ($data['starts_at'] ?? null) ?: null, ($data['expires_at'] ?? null) ?: null, (int)($data['status'] ?? 1)]);
    respond(['success' => true, 'id' => $id]);
}
$id = (int)($data['id'] ?? query('id', 0));
if ($method === 'PUT' || ($method === 'POST' && ($data['_method'] ?? '') === 'PUT')) {
    db_exec('UPDATE coupons SET code=?, title=?, discount_type=?, discount_value=?, min_order_amount=?, max_uses=?, starts_at=?, expires_at=?, status=? WHERE id=?', [trim((string)$data['code']), trim((string)$data['title']), trim((string)($data['discount_type'] ?? 'fixed')), (float)($data['discount_value'] ?? 0), (float)($data['min_order_amount'] ?? 0), ($data['max_uses'] ?? null) !== '' ? (int)$data['max_uses'] : null, ($data['starts_at'] ?? null) ?: null, ($data['expires_at'] ?? null) ?: null, (int)($data['status'] ?? 1), $id]);
    respond(['success' => true]);
}
db_exec('DELETE FROM coupons WHERE id = ?', [$id]);
respond(['success' => true]);
