<?php
session_start();
$dataFile = '../data/users.json';
$users = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (!isset($users[$username])) {
        $users[$username] = ['password' => $password];
        file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));
        echo "Registration successful!";
    } else {
        echo "Username already exists!";
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>
<a href="login.php">Login</a>
