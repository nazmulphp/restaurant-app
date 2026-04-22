<?php
header('Content-Type: text/plain');

$host = 'localhost';
$db   = 'u144473119_buger';
$user = 'u144473119_buger';
$pass = 'Nazmul/163311013$';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $stmt = $pdo->query("SELECT id, name, email, role FROM users LIMIT 5");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>