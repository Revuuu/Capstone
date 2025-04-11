<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $sql = "SELECT * FROM `thread` WHERE buyer_id = ? AND seller_id = ? AND account_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('iii', $data["buyer_id"], $data["seller_id"], $data["account_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sql = "SELECT thread.`id`, thread.`buyer_id`, thread.`seller_id`, thread.`account_id`, CONCAT(users.`name`, ' ', users.`mname`, ' ', users.`lname`) as seller_name, accounts.`title` FROM thread INNER JOIN users ON thread.`seller_id` = users.`id` INNER JOIN accounts ON thread.`account_id` = accounts.`id` WHERE thread.`id` = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $row['id']);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo json_encode($row);

                $stmt->close();
                return;
            }
        }

        $sql = "INSERT INTO `thread` (`buyer_id`, `seller_id`, `account_id`) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("iii", $data["buyer_id"], $data["seller_id"], $data["account_id"]);

        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $sql = "SELECT thread.`id`, thread.`buyer_id`, thread.`seller_id`, thread.`account_id`, CONCAT(users.`name`, ' ', users.`mname`, ' ', users.`lname`) as seller_name, accounts.`title` FROM thread INNER JOIN users ON thread.`seller_id` = users.`id` INNER JOIN accounts ON thread.`account_id` = accounts.`id` WHERE thread.`id` = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo json_encode($row);
            } else {
                echo json_encode(null);
            }
        } else {
            echo json_encode(0);
        }

        $stmt->close();
    }

   
    $db->close();
?>