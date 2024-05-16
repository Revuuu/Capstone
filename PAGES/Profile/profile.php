<?php
// Start the session (if not already started)
session_start();


// Check if user is logged in by verifying if session data exists
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
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
  <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
  <p>Your Email: <?php echo $_SESSION['user_email']; ?></p>
  <?php if (isset($_SESSION['user_name'])): ?>
      <p>Your Name: <?php echo $_SESSION['user_name']; ?></p>
      
  <?php endif; ?>
</body>
</html>

<?php
} else {
  // Redirect to login page if session data is missing
  header("Location: signin.html");
  exit;
}
?>
