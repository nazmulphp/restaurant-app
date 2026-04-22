<?php
require_once __DIR__ . '/bootstrap.php';
$data = request_data();
$orderId = (int)($data['order_id'] ?? 0);
$method = trim((string)($data['payment_method'] ?? ''));
$status = trim((string)($data['payment_status'] ?? 'Paid'));
if ($orderId < 1 || $method === '') {
    respond(['success' => false, 'message' => 'Order id and payment method are required'], 422);
}
try {
    db_exec("UPDATE orders SET payment_status = ?, status = CASE WHEN status = 'New' THEN 'Preparing' ELSE status END WHERE id = ?", [$status, $orderId]);
    db_exec('UPDATE payment_transactions SET payment_method = ?, payment_status = ?, transaction_ref = ? WHERE order_id = ?', [$method, $status, trim((string)($data['transaction_ref'] ?? '')), $orderId]);
    db_exec('INSERT INTO order_status_logs (order_id, old_status, new_status, note, changed_by) VALUES (?, ?, ?, ?, ?)', [$orderId, 'New', 'Preparing', 'Payment completed', current_user_full()['id'] ?? null]);
    respond(['success' => true, 'message' => 'Payment completed successfully', 'order_number' => 'CB-' . str_pad((string)$orderId, 6, '0', STR_PAD_LEFT), 'payment_method' => $method]);
} catch (Throwable $e) {
    respond(['success' => false, 'message' => $e->getMessage()], 500);
}
