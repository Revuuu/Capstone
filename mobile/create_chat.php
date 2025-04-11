<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $sql = "INSERT INTO `chat` (`thread_id`, `creator_id`, `content`) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("iis", $data["thread_id"], $data["creator_id"], $data["content"]);

        if ($stmt->execute()) {
            echo json_encode("Success");
        } else {
            echo json_encode("Error");
        }
        $stmt->close();
    }
    
    $db->close();
?>