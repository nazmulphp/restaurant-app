<?php
require_once __DIR__ . '/bootstrap.php';
$data = request_data();
$items = $data['items'] ?? [];
if (!is_array($items) || count($items) === 0) {
    respond(['success' => false, 'message' => 'Your cart is empty.'], 422);
}
$user = current_user_full();
$couponCode = trim((string)($data['coupon_code'] ?? ''));
$deliveryFee = (float)($data['delivery_fee'] ?? 0);
$paymentMethod = trim((string)($data['payment_method'] ?? 'cash'));

try {
    $pdo->beginTransaction();
    $subtotal = 0;
    $itemStmt = $pdo->prepare('SELECT id, name, price, sale_price FROM menu_items WHERE id = ?');
    $itemsToSave = [];
    foreach ($items as $item) {
        $itemStmt->execute([(int)($item['id'] ?? 0)]);
        $row = $itemStmt->fetch();
        if (!$row) continue;
        $qty = max(1, (int)($item['quantity'] ?? 1));
        $price = $row['sale_price'] !== null ? (float)$row['sale_price'] : (float)$row['price'];
        $subtotal += $price * $qty;
        $itemsToSave[] = ['id' => (int)$row['id'], 'qty' => $qty, 'price' => $price];
    }
    if (!$itemsToSave) {
        throw new RuntimeException('No valid items found');
    }

    $discount = 0;
    $couponId = null;
    if ($couponCode !== '') {
        $coupon = db_one('SELECT * FROM coupons WHERE code = ? AND status = 1', [$couponCode]);
        if ($coupon) {
            if (!$coupon['expires_at'] || strtotime($coupon['expires_at']) >= time()) {
                if ($subtotal >= (float)$coupon['min_order_amount']) {
                    $discount = $coupon['discount_type'] === 'percent' ? ($subtotal * ((float)$coupon['discount_value'] / 100)) : (float)$coupon['discount_value'];
                    $discount = min($discount, $subtotal);
                    $couponId = (int)$coupon['id'];
                }
            }
        }
    }

    $tax = (float)($data['tax_amount'] ?? 0);
    $total = max(0, $subtotal - $discount + $deliveryFee + $tax);

    $orderId = db_insert('INSERT INTO orders (customer_id, customer_name, customer_email, customer_phone, delivery_address, total_amount, status, source, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
        $user['id'] ?? null,
        trim((string)($data['customer_name'] ?? ($user['name'] ?? 'Guest Customer'))),
        trim((string)($data['customer_email'] ?? ($user['email'] ?? 'guest@example.com'))),
        trim((string)($data['customer_phone'] ?? '')),
        trim((string)($data['delivery_address'] ?? 'Pickup')),
        $total,
        'New',
        'Web',
        in_array($paymentMethod, ['cash', 'cod'], true) ? 'Pending' : 'Pending'
    ]);

    foreach ($itemsToSave as $entry) {
        db_exec('INSERT INTO order_items (order_id, menu_item_id, quantity, price_at_time) VALUES (?, ?, ?, ?)', [$orderId, $entry['id'], $entry['qty'], $entry['price']]);
    }

    db_insert('INSERT INTO payment_transactions (order_id, payment_method, transaction_ref, amount, payment_status, payload_json) VALUES (?, ?, ?, ?, ?, ?)', [
        $orderId, $paymentMethod, trim((string)($data['transaction_ref'] ?? '')), $total, 'Pending', json_encode(['coupon_code' => $couponCode, 'discount' => $discount, 'delivery_fee' => $deliveryFee, 'tax_amount' => $tax])
    ]);

    if ($couponId) {
        db_exec('UPDATE coupons SET used_count = used_count + 1 WHERE id = ?', [$couponId]);
        db_exec('INSERT INTO coupon_usages (coupon_id, order_id, user_id, amount_saved) VALUES (?, ?, ?, ?)', [$couponId, $orderId, $user['id'] ?? null, $discount]);
    }

    db_exec('INSERT INTO order_status_logs (order_id, old_status, new_status, note, changed_by) VALUES (?, ?, ?, ?, ?)', [$orderId, null, 'New', 'Order placed', $user['id'] ?? null]);
    $pdo->commit();

    respond([
        'success' => true,
        'message' => 'Order placed successfully',
        'orderId' => $orderId,
        'orderNumber' => 'CB-' . str_pad((string)$orderId, 6, '0', STR_PAD_LEFT),
        'subtotal' => round($subtotal, 2),
        'discount' => round($discount, 2),
        'delivery_fee' => round($deliveryFee, 2),
        'tax_amount' => round($tax, 2),
        'total_amount' => round($total, 2)
    ]);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    respond(['success' => false, 'message' => $e->getMessage()], 500);
}
