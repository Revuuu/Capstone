<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../SignIn/login.php");
    exit;
}

include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat UI</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container { display: flex; }
        .threads { width: 25%; border-right: 1px solid #ccc; padding: 10px; }
        .messages { width: 75%; padding: 20px; }
        .message.buyer { text-align: left; }
        .message.seller { text-align: right; }
        .thread { cursor: pointer; padding: 5px; border-bottom: 1px solid #ddd; }
        .thread:hover { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="threads" id="threads">
            <!-- Threads will be populated here -->
        </div>
        <div class="messages" id="messages">
            <!-- Messages will be populated here -->
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchThreads();
        });

        function fetchThreads() {
            fetch('fetch_threads.php')
                .then(response => response.json())
                .then(data => {
                    let threadsContainer = document.getElementById('threads');
                    threadsContainer.innerHTML = '';
                    data.forEach(thread => {
                        let threadElement = document.createElement('div');
                        threadElement.className = 'thread';
                        threadElement.innerText = thread.title;
                        threadElement.addEventListener('click', () => fetchMessages(thread.id));
                        threadsContainer.appendChild(threadElement);
                    });
                })
                .catch(error => console.error('Error fetching threads:', error));
        }

        function fetchMessages(thread_id) {
            fetch(`fetch_messages.php?thread_id=${thread_id}`)
                .then(response => response.json())
                .then(data => {
                    let messagesContainer = document.getElementById('messages');
                    messagesContainer.innerHTML = '';
                    data.forEach(message => {
                        let messageElement = document.createElement('div');
                        messageElement.className = 'message ' + message.type;
                        messageElement.innerText = `${message.name}: ${message.message}`;
                        messagesContainer.appendChild(messageElement);
                    });
                })
                .catch(error => console.error('Error fetching messages:', error));
        }
    </script>
</body>
</html>
