<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $sql = "SELECT * FROM users where id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $data["user_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo json_encode($row);
        } else {
            echo json_encode("Error");
        }
        
        $stmt->close();
    }

    $db->close();
?>