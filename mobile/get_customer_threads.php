<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $sql = "SELECT thread.`id`, thread.`buyer_id`, thread.`seller_id`, thread.`account_id`, CONCAT(users.`name`, ' ', users.`mname`, ' ', users.`lname`) as seller_name, accounts.`title` FROM thread INNER JOIN users ON thread.`seller_id` = users.`id` INNER JOIN accounts ON thread.`account_id` = accounts.`id` WHERE thread.`buyer_id` = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $data["buyer_id"]);
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