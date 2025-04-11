<?php
session_start();
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['newpassword'];

    // Validate new password
    if (empty($newPassword)) {
        $_SESSION['error_message'] = "New password is required.";
        header("Location: updateprofile.php");
        exit;
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the user's password in the database
    $sql = "UPDATE users SET password=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error_message'] = "Database query failed: " . $conn->error;
        header("Location: updateprofile.php");
        exit;
    }

    $stmt->bind_param("ss", $hashedPassword, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Your password has been updated successfully.";
        header("Location: ../SignIn/signin.html");
        exit;
    } else {
        $_SESSION['error_message'] = "Failed to update password. Please try again.";
        header("Location: updateprofile.php");
        exit;
    }
}
?>
