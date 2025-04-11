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

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $sql = "SELECT * FROM otp WHERE user_id = ? AND pin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['user_otp_id'], $_POST['otp']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        verifyUser($conn);
        unset($_SESSION['user_otp_id']);
        header("Location: ../Signin/signin.php");
    } else {
        header("Location: otp.php");
    }
}

function verifyUser($conn)
{
    $sql = "UPDATE users SET verified=1 WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user_otp_id']);
    $stmt->execute();
}
?>