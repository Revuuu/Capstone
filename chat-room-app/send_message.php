<?php

include('db_connect.php');

$stmt = $conn->prepare("INSERT INTO chat (thread_id, creator_id, content, is_seller) VALUES (?,?,?,1)");
$stmt->bind_param("sss", $_POST['thread_id'], $_SESSION['user_id'], $_POST['message']);

if($stmt->execute())
{
    header("Location: chats.php?thread_id=" . $_POST['thread_id']);
}

?>