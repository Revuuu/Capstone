<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];

$threads_query = "SELECT * FROM threads WHERE seller_id = ?";
$stmt = $conn->prepare($threads_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$threads = [];
while ($row = $result->fetch_assoc()) {
    $threads[] = $row;
}
echo json_encode($threads);

$stmt->close();
$conn->close();
?>
