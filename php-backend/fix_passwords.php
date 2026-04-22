<?php
require_once 'config.php';

try {
    // Update all users who have plain text passwords to MD5
    // This is a simple script to fix existing records
    $stmt = $pdo->query("SELECT id, password FROM users");
    $users = $stmt->fetchAll();

    foreach ($users as $user) {
        // If the password is not 32 characters (length of MD5 hash), it's likely plain text or old hash
        if (strlen($user['password']) !== 32) {
            $hashed = md5($user['password']);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->execute([$hashed, $user['id']]);
            echo "Updated user ID " . $user['id'] . " to MD5 password.<br>";
        }
    }
    echo "Done fixing passwords.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
