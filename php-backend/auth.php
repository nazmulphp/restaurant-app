<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

function json_response(array $data, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function get_json_input(): array {
    $raw = file_get_contents('php://input');
    if (!$raw) {
        return [];
    }

    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function current_user(): ?array {
    return $_SESSION['auth_user'] ?? null;
}

function login_user(array $user): void {
    $_SESSION['auth_user'] = [
        'id' => (int)$user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role']
    ];
}

function require_auth(array $roles = []): array {
    $user = current_user();

    if (!$user) {
        json_response(['error' => 'Unauthorized'], 401);
    }

    if (!empty($roles) && !in_array($user['role'], $roles, true)) {
        json_response(['error' => 'Access denied'], 403);
    }

    return $user;
}

function logout_user(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
