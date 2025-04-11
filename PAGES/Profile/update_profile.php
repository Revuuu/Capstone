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
    $name = $_POST['name'];
    $mname = $_POST['middlename']; // Corrected field name
    $lname = $_POST['lastname']; // Corrected field name
    $age = $_POST['age'];
    $contactno = $_POST['contactno'];
    $gamegenre = $_POST['gamegenre'];


   

    // Update the user's profile in the database
    $sql = "UPDATE users SET name=?, mname=?, lname=?, age=?, contactno=?, gamegenre=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error_message'] = "Database query failed: " . $conn->error;
     
        exit;
    }

    $stmt->bind_param("sssssss", $name, $mname, $lname, $age, $contactno, $gamegenre, $email);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Your profile has been updated successfully.";
        header("Location: ../SignIn/signin.html");
        exit;
    } else {
        $_SESSION['error_message'] = "Failed to update profile. Please try again.";
        header("Location: update_profile.php");
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
<title>Update Profile</title>
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
      <form action="update_profile.php" method="POST">
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
                <label for="firstname">First Name:</label>
            </div>
            <div>
                <input type="text" id="name" name="name" required>
            </div>
        </div>
        <div class="form-group1">
            <div> 
                <label for="middlename">Middle Name:</label>
            </div>
            <div>
                <input type="text" id="middlename" name="middlename" required>
            </div>
        </div>
        <div class="form-group1">
            <div> 
                <label for="lastname">Last Name:</label>
            </div>
            <div>
                <input type="text" id="lastname" name="lastname" required>
            </div>
        </div>
        <div class="form-group1">
            <div> 
                <label for="age">Age:</label>
            </div>
            <div>
                <input type="number" id="age" name="age" required>
            </div>
        </div>
        <div class="form-group1">
            <div> 
                <label for="contactno">Contact Number:</label>
            </div>
            <div>
                <input type="text" id="contactno" name="contactno" required>
            </div>
        </div>
        <div class="form-group1">
            <div> 
                <label for="gamegenre">Favorite Game Genre:</label>
            </div>
            <div>
                <input type="text" id="gamegenre" name="gamegenre" required>
            </div>
        </div>
      
        <br>
        <div class="update-btn">
            <button type="submit">Update Profile</button>
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