<?php
session_start();
include 'session.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$users = file_exists('../data/users.json') ? json_decode(file_get_contents('../data/users.json'), true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="chat_app/php/styles.css">
    <script>
        let currentChat = "";

        function loadChat(user) {
            currentChat = user;
            document.getElementById("chat-title").innerText = "Chat with " + user;
            fetchMessages();
        }

        function fetchMessages() {
            if (!currentChat) return;
            fetch("load_chat.php?user=" + currentChat)
                .then(response => response.text())
                .then(data => document.getElementById("chat-box").innerHTML = data);
        }

        function sendMessage() {
            let message = document.getElementById("message").value;
            if (!message) return;
            fetch("send_message.php", {
                method: "POST",
                body: new URLSearchParams({ user: currentChat, message: message })
            }).then(() => {
                document.getElementById("message").value = "";
                fetchMessages();
            });
        }

        setInterval(fetchMessages, 1000);
    </script>
</head>
<body>
    <div class="container">
        <div class="users-list">
            <h3>Users</h3>
            <?php foreach (array_keys($users) as $user) {
                if ($user !== $_SESSION['username']) {
                    echo "<button onclick='loadChat(\"$user\")'>$user</button>";
                }
            } ?>
        </div>
        <div class="chat-window">
            <h3 id="chat-title">Select a user to chat</h3>
            <div id="chat-box"></div>
            <input type="text" id="message" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</body>
</html>
