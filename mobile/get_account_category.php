<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $sql = "SELECT category FROM accounts";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $array = array();
            while($row = $result->fetch_assoc()) {
                array_push($array, $row['category']);
            }
            echo json_encode(array_unique($array));
        } else {
            echo json_encode(array());
        }
    }

    $db->close();
?>