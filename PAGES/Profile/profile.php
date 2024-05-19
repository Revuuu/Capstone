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

// Debugging output
// echo "Profile Picture Path: " . $profile_picture_path . "<br>";

// $absolute_path = $_SERVER['DOCUMENT_ROOT'] . '/Capstone/PAGES/Register/assets/uploads/66495042b6bac.jpg';
// if (file_exists($absolute_path)) {
//     // File exists
//     echo "File exists!<br>";
// } else {
//     // File does not exist
//     echo "File does not exist!<br>";
// }



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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../styles/profile.module.css">
  <link rel="stylesheet" href="../../CSS/styles.css">
  <title>User Profile</title>
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
        <a href="logout.php">Logout</a>
      </div>
    </div>                       
  </nav>
  
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
  <p>Your Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
  <?php if (isset($_SESSION['user_name'])): ?>
      <p>Your Name: <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
  <?php endif; ?>
<<<<<<< HEAD
  <?php if (isset($_SESSION['user_mname'])): ?>
      <p>Your Middle Name: <?php echo htmlspecialchars($_SESSION['user_mname']); ?></p>
  <?php else: ?>
      <p>No middle name</p>
  <?php endif; ?>
  <?php if (isset($_SESSION['user_lname'])): ?>
      <p>Your Last Name: <?php echo htmlspecialchars($_SESSION['user_lname']); ?></p>
  <?php endif; ?>
  <?php if (!empty($profile_picture_path)): ?>
    <!-- <p>Your Profile Picture Path: <?php echo htmlspecialchars($profile_picture_path); ?></p>  -->
    <p>Your Profile Picture:</p>

    <?php if (file_exists($profile_picture_path)): ?>
      <img src="<?php echo htmlspecialchars($profile_picture_path); ?>" alt="Profile Picture" style="width: 150px; height: auto;">

 

    <?php else: ?>
        <p>Error loading profile picture. Please try again later.</p>
    <?php endif; ?>
<?php else: ?>
    <p>No profile picture uploaded</p>
<?php endif; ?>


=======


<?php if (isset($_SESSION['user_mname'])): ?>
    <p>Your Middle Name:<?php echo $_SESSION['user_mname']; ?></p>
<?php else: ?>
  <p>No middle name</p>
<?php endif; ?>
<?php if (isset($_SESSION['user_lname'])): ?>
    <p>Your Last Name:<?php echo $_SESSION['user_lname']; ?></p>
<?php endif; ?>



>>>>>>> 6b1c8b0c8bf518974246b69a26c300f840f29f95
</body>
</html>
