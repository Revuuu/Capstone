<?php
session_start();
include 'config.php';

$thread_id = $_GET['thread_id'];

$messages_query = "SELECT chats.*, users.name FROM chats 
                   JOIN users ON chats.sender_id = users.id 
                   WHERE chats.thread_id = ? 
                   ORDER BY chats.created_at ASC";
$stmt = $conn->prepare($messages_query);
$stmt->bind_param("i", $thread_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
echo json_encode($messages);

$stmt->close();
$conn->close();
?>
