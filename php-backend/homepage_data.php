<?php
require_once __DIR__ . '/bootstrap.php';
try {
    $featured = db_all("SELECT m.id, m.name, m.description, COALESCE(m.sale_price, m.price) AS price, m.image_url, m.rating, m.reviews, c.name AS category_name
        FROM menu_items m
        LEFT JOIN categories c ON c.id = m.category_id
        WHERE m.is_available = TRUE
        ORDER BY m.is_featured DESC, m.rating DESC, m.reviews DESC, m.created_at DESC
        LIMIT 8");
    $stats = [
        'total_menu_items' => (int)(db_one("SELECT COUNT(*) c FROM menu_items WHERE is_available = TRUE")['c'] ?? 0),
        'orders_today' => (int)(db_one("SELECT COUNT(*) c FROM orders WHERE DATE(created_at) = CURDATE()")['c'] ?? 0),
        'total_orders' => (int)(db_one("SELECT COUNT(*) c FROM orders")['c'] ?? 0),
        'total_sales' => (float)(db_one("SELECT COALESCE(SUM(total_amount), 0) s FROM orders WHERE payment_status = 'Paid'")['s'] ?? 0),
    ];
    $banners = db_all('SELECT * FROM banners WHERE status = 1 AND banner_group = ? ORDER BY sort_order, id', ['homepage']);
    $testimonials = db_all("SELECT * FROM testimonials WHERE status = 'Published' ORDER BY id DESC LIMIT 6");
    $posts = db_all("SELECT id, title, slug, excerpt, image_url, published_at FROM blog_posts WHERE status = 'published' ORDER BY COALESCE(published_at, created_at) DESC LIMIT 3");
    respond(['success' => true, 'featured' => $featured, 'stats' => $stats, 'banners' => $banners, 'testimonials' => $testimonials, 'posts' => $posts]);
} catch (Throwable $e) {
    respond(['success' => false, 'message' => $e->getMessage()], 500);
}
