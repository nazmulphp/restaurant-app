<?php
require_once __DIR__ . '/config.php';

function json_response(array $payload, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}

function request_json(): array {
    $raw = file_get_contents('php://input');
    if (!$raw) {
        return [];
    }
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

function get_setting(string $key, $default = '') {
    global $pdo;
    static $settings = null;
    if ($settings === null) {
        $settings = [];
        try {
            $stmt = $pdo->query('SELECT setting_key, setting_value FROM settings');
            foreach ($stmt->fetchAll() as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Throwable $e) {
            $settings = [];
        }
    }
    return $settings[$key] ?? $default;
}

function upsert_setting(string $key, string $value): void {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
    $stmt->execute([$key, $value]);
}
