<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $sql = "SELECT * FROM chat WHERE thread_id = ? ORDER BY created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $data["thread_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $array = array();
            while($row = $result->fetch_assoc()) {
                array_push($array, $row);
            }
            echo json_encode($array);
        } else {
            echo json_encode(array());
        }
        
        $stmt->close();
    }

    $db->close();
?>