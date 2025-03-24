<?php
session_start();
include 'session.php';

$messagesFile = '../data/messages.json';
$messages = file_exists($messagesFile) ? json_decode(file_get_contents($messagesFile), true) : [];

$chatWith = $_GET['chat_with'] ?? '';

if ($chatWith && isset($messages[$_SESSION['username']][$chatWith])) {
    foreach ($messages[$_SESSION['username']][$chatWith] as $msg) {
        echo "<div class='" . ($msg['sender'] === $_SESSION['username'] ? "sent" : "received") . "'>" . htmlspecialchars($msg['message']) . "</div>";
    }
}
?>
