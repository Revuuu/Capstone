<?php
session_start();

// Database credentials
$servername = "localhost"; // or "127.0.0.1"
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "user_registration"; // your database name

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
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./styles/updateprofile.module.css">
<link rel="stylesheet" href="../../CSS/styles.css">
<title>Update Password</title>
</head>
<body>
    <nav class="row">
      <div class="left-div">
        <div class="img-container">
          <img src="../../ASSETSGACHA/GACHA LOGO-REVISED.png">
        </div>
        <p>GACHA</p>
      </div>
      <div class="right-div">
        <div>
          <a href="../../index.html">Home</a>
        </div>
        <div>
          <a href="../ContactUs/contactus.html">Contact Us</a>
        </div>
        <div>
          <a href="../SignIn/signin.html"><img src="../../ASSETSGACHA/PROFILE BUTTON REVISED.png"></a>
        </div>
      </div>                        
    </nav>

    <div class="container">
      <form action="updateprofile.php" method="POST">
        <div class="form-group1">
            <div> 
                <label for="email">Email:</label>
            </div>
            <div>
                <input type="email" id="email" name="email" required placeholder="E.g: JuanDelaCruz123@gmail.com">
            </div>
        </div>
        <div class="form-group1">
            <div> 
                <label for="newpassword">New Password:</label>
            </div>
            <div>
                <input type="password" id="newpassword" name="newpassword" required>
            </div>
        </div>
        <br>
        <div class="update-btn">
            <button type="submit">Update Password</button>
        </div>
      </form>    
    </div>
    <?php
    if (isset($_SESSION['error_message'])) {
        echo '<div class="error">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    ?>
  </body>
</html>