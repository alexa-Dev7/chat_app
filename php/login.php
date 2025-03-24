<?php
session_start();
$userFile = '../data/users.json';
$sessionFile = '../data/sessions.json';

$users = file_exists($userFile) ? json_decode(file_get_contents($userFile), true) : [];
$sessions = file_exists($sessionFile) ? json_decode(file_get_contents($sessionFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['username'] = $username;
        $token = bin2hex(random_bytes(16)); // Generate session token
        $sessions[$username] = $token;
        file_put_contents($sessionFile, json_encode($sessions, JSON_PRETTY_PRINT));
        setcookie("session", $token, time() + (86400 * 30), "/"); // 30-day cookie
        header("Location: chat.php");
        exit();
    } else {
        echo "Invalid login!";
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
<a href="register.php">Register</a>
