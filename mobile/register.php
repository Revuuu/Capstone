<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $sql = "INSERT INTO `users` (`name`, `mname`, `lname`, `email`, `password`, `type`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssssss", $data["name"], $data["mname"], $data["lname"], $data["email"], md5($data["password"]), $data["type"]);

        if ($stmt->execute()) {
            echo json_encode("Success");
        } else {
            echo json_encode("Error");
        }
        $stmt->close();
    }
    
    $db->close();
?>