<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

const ADMIN_ROLES = ['Super Admin', 'Admin', 'Manager', 'Store Manager', 'Kitchen Admin'];

function respond(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function request_data(): array {
    $data = $_POST;
    $raw = file_get_contents('php://input');
    $json = $raw ? json_decode($raw, true) : null;
    if (is_array($json)) {
        $data = array_merge($data, $json);
    }
    return $data;
}

function request_method(): string {
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
}

function current_user_full(): ?array {
    return $_SESSION['auth_user'] ?? null;
}

function set_current_user(array $user): void {
    $_SESSION['auth_user'] = [
        'id' => (int)$user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'] ?? 'Customer'
    ];
}

function require_login(array $roles = []): array {
    $user = current_user_full();
    if (!$user) {
        respond(['success' => false, 'message' => 'Unauthorized'], 401);
    }
    if ($roles && !in_array($user['role'], $roles, true)) {
        respond(['success' => false, 'message' => 'Access denied'], 403);
    }
    return $user;
}

function require_admin(): array {
    return require_login(ADMIN_ROLES);
}

function password_hash_if_needed(string $password): string {
    if (preg_match('/^\$2y\$/', $password)) {
        return $password;
    }
    return password_hash($password, PASSWORD_DEFAULT);
}

function verify_password_compat(string $plain, string $stored): bool {
    if (preg_match('/^\$2y\$/', $stored)) {
        return password_verify($plain, $stored);
    }
    return md5($plain) === $stored || $plain === $stored;
}

function db_all(string $sql, array $params = []): array {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function db_one(string $sql, array $params = []): ?array {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row ?: null;
}

function db_exec(string $sql, array $params = []): bool {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

function db_insert(string $sql, array $params = []): int {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int)$pdo->lastInsertId();
}

function input(string $key, $default = null) {
    $data = request_data();
    return $data[$key] ?? $default;
}

function query(string $key, $default = null) {
    return $_GET[$key] ?? $default;
}

function paginate_clause(): array {
    $page = max(1, (int)query('page', 1));
    $limit = max(1, min(100, (int)query('limit', 20)));
    $offset = ($page - 1) * $limit;
    return [$limit, $offset, $page];
}

function setting_value(string $key, string $default = ''): string {
    $row = db_one('SELECT setting_value FROM settings WHERE setting_key = ?', [$key]);
    return $row['setting_value'] ?? $default;
}

function upsert_setting_value(string $key, string $value): void {
    db_exec('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)', [$key, $value]);
}

function ensure_table_columns(): void {
    static $done = false;
    if ($done) return;
    $done = true;
    $patches = [
        "ALTER TABLE users ADD COLUMN phone VARCHAR(30) NULL",
        "ALTER TABLE users ADD COLUMN address TEXT NULL",
        "ALTER TABLE menu_items ADD COLUMN slug VARCHAR(180) NULL",
        "ALTER TABLE menu_items ADD COLUMN stock_qty INT NOT NULL DEFAULT 0",
        "ALTER TABLE menu_items ADD COLUMN is_featured TINYINT(1) NOT NULL DEFAULT 0",
        "ALTER TABLE menu_items ADD COLUMN sale_price DECIMAL(10,2) NULL",
        "ALTER TABLE categories ADD COLUMN slug VARCHAR(180) NULL",
        "ALTER TABLE categories ADD COLUMN image_url VARCHAR(255) NULL",
        "ALTER TABLE categories ADD COLUMN status TINYINT(1) NOT NULL DEFAULT 1"
    ];
    foreach ($patches as $sql) {
        try { global $pdo; $pdo->exec($sql); } catch (Throwable $e) {}
    }
}

ensure_table_columns();
