<?php
// Start the session (if not already started)
session_start();

// Check if user is logged in by verifying if session data exists
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
    // Include your database connection code here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_registration";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user data including profile picture from the database
    $sql = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $profile_picture = $row['profile_picture'];

        if (!empty($profile_picture)) {
            // Set the path to the profile picture
            $profile_picture_path = '../Register/assets/uploads/' . $profile_picture;
        } else {
            $profile_picture_path = 'img/photo/default.jpg'; // Default image
        }
    } else {
        $profile_picture_path = 'img/photo/default.jpg'; // Default image
    }
    // Close database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to login page if session data is missing
    header("Location: signin.html");
    exit;
}
?>
