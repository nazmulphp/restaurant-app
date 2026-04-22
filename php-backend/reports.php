<?php
require_once __DIR__ . '/bootstrap.php';
require_admin();
$type = query('type', 'dashboard');
if ($type === 'sales') {
    $rows = db_all('SELECT DATE(created_at) AS report_date, COUNT(*) AS total_orders, SUM(total_amount) AS total_sales FROM orders GROUP BY DATE(created_at) ORDER BY report_date DESC LIMIT 30');
    respond(['success' => true, 'items' => $rows]);
}
if ($type === 'products') {
    $rows = db_all('SELECT m.id, m.name, COALESCE(SUM(oi.quantity),0) AS total_qty, COALESCE(SUM(oi.quantity * oi.price_at_time),0) AS revenue FROM menu_items m LEFT JOIN order_items oi ON oi.menu_item_id = m.id GROUP BY m.id, m.name ORDER BY revenue DESC');
    respond(['success' => true, 'items' => $rows]);
}
$stats = [
    'total_orders' => (int)(db_one('SELECT COUNT(*) c FROM orders')['c'] ?? 0),
    'total_sales' => (float)(db_one('SELECT COALESCE(SUM(total_amount),0) s FROM orders WHERE payment_status = "Paid"')['s'] ?? 0),
    'total_customers' => (int)(db_one('SELECT COUNT(*) c FROM users WHERE role = "Customer"')['c'] ?? 0),
    'total_products' => (int)(db_one('SELECT COUNT(*) c FROM menu_items')['c'] ?? 0),
    'pending_reservations' => (int)(db_one('SELECT COUNT(*) c FROM reservations WHERE status = "Pending"')['c'] ?? 0),
    'pending_reviews' => (int)(db_one('SELECT COUNT(*) c FROM product_reviews WHERE status = "Pending"')['c'] ?? 0)
];
respond(['success' => true, 'stats' => $stats]);
