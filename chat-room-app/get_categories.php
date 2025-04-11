<?php
include('db_connect.php');

$query = "SELECT category from accounts WHERE seller_id=? GROUP BY category";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$categories = $stmt->get_result();

$games = [];

while ($row = $categories->fetch_assoc()) {
    array_push($games, $row);
}

?>