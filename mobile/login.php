<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM users WHERE email = ? and password = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ss", $email, md5($password));
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            echo json_encode($row);
        } else {
            echo "Error";
        }

        $stmt->close();
    }
    
    $db->close();
?>