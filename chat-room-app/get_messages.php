<?php

include('db_connect.php');

$query = "SELECT content, is_seller FROM chat WHERE thread_id=? ORDER BY id ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_GET['thread_id']);
$stmt->execute();
$chats = $stmt->get_result();

$messages = [];

while ($row = $chats->fetch_assoc()) {
    array_push($messages, $row);
}

?>