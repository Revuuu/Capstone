<?php
// Database credentials
$servername = "localhost"; // or "127.0.0.1"
$username = "root"; // default XAMPP MySQL username
$password = ""; // default XAMPP MySQL password is empty
$dbname = "user_registration"; // the name of the database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['code'])) {
    $activation_code = $conn->real_escape_string($_GET['code']);

    // Update user status to active
    $sql = "UPDATE users SET is_active = 1 WHERE activation_code = '$activation_code'";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "Your email has been verified successfully!";
        } else {
            echo "Invalid activation code.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No activation code provided.";
}

$conn->close();
