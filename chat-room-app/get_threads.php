<?php 

include('db_connect.php');

$query = "SELECT CONCAT(users.name, ' ', users.mname, ' ', users.lname) as customer, thread.id as thread_id FROM thread INNER JOIN users ON thread.buyer_id=users.id INNER JOIN accounts ON thread.account_id=accounts.id WHERE users.type = 'BUYER' AND accounts.category=? AND thread.seller_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $_GET['game'], $_SESSION['user_id']);
$stmt->execute();
$threads = $stmt->get_result();

$chats = [];

while ($row = $threads->fetch_assoc()) {
    array_push($chats, $row);
}
?>