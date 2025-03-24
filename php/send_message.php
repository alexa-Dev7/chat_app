<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_POST['user']) || !isset($_POST['message'])) {
    exit();
}

$dataFile = '../data/messages.json';
$messages = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

$from = $_SESSION['username'];
$to = $_POST['user'];
$text = $_POST['message'];
$timestamp = time();

$messages[] = compact('from', 'to', 'text', 'timestamp');

file_put_contents($dataFile, json_encode($messages, JSON_PRETTY_PRINT));
?>
