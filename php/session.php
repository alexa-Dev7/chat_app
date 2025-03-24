<?php
session_start();
$sessionFile = '../data/sessions.json';
$sessions = file_exists($sessionFile) ? json_decode(file_get_contents($sessionFile), true) : [];

if (isset($_COOKIE['session'])) {
    foreach ($sessions as $user => $token) {
        if ($token === $_COOKIE['session']) {
            $_SESSION['username'] = $user;
            break;
        }
    }
}
?>
