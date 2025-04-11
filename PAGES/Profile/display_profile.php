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
    $sql = "SELECT * FROM users WHERE id = ?";
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

        // Set session variables for additional user data
        $_SESSION['user_age'] = $row['age']; // Assuming 'age' is the correct column name
        $_SESSION['user_contactno'] = $row['contactno']; // Assuming 'contactno' is the correct column name
        $_SESSION['user_gamegenre'] = $row['gamegenre']; // Assuming 'gamegenre' is the correct column name
    } else {
        $profile_picture_path = 'img/photo/default.jpg'; // Default image
    }

    // Close database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to login page if session data is missing
    header("Location: update_profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../../PAGES/Profile/styles/profile.module.css">
    <link rel="stylesheet" href="../../CSS/styles.css">

</head>
<body>
    <nav class="row">
        <div class="left-div">
            <div class="img-container">
                <img src="../../ASSETSGACHA/GACHA LOGO-REVISED.png" alt="GACHA Logo">
            </div>
            <p>GACHA</p>
        </div>
        <div class="right-div">
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        
        <form id="profileForm" action="update_profile.php" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">First Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" readonly>
            
                <label for="mname">Middle Name:</label>
                <input type="text" id="mname" name="mname" value="<?php echo isset($_SESSION['user_mname']) ? htmlspecialchars($_SESSION['user_mname']) : 'N/A'; ?>" readonly>
          
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo isset($_SESSION['user_lname']) ? htmlspecialchars($_SESSION['user_lname']) : 'N/A'; ?>" readonly>
    
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" readonly>
            
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo isset($_SESSION['user_age']) ? htmlspecialchars($_SESSION['user_age']) : 'N/A'; ?>" readonly>
            
                <label for="contactno">Contact No.:</label>
                <input type="tel" id="contactno" name="contactno" value="<?php echo isset($_SESSION['user_contactno']) ? htmlspecialchars($_SESSION['user_contactno']) : 'N/A'; ?>" readonly>
            
                <label for="gamegenre">Game Genre:</label>
                <input type="text" id="gamegenre" name="gamegenre" value="<?php echo isset($_SESSION['user_gamegenre']) ? htmlspecialchars($_SESSION['user_gamegenre']) : 'N/A'; ?>" readonly>
            
                <label for="profile_picture">Profile Picture:</label>
                <?php if (!empty($profile_picture_path) && file_exists($profile_picture_path)): ?>
                    <img src="<?php echo htmlspecialchars($profile_picture_path); ?>" alt="Profile Picture" class="profile-picture">
                <?php else: ?>
                    <p>No profile picture uploaded</p>
                <?php endif; ?>
            </div>
        </form>

        <div class="profile-btn">
            <a href="../../PAGES/AccountListing/accountlisting.html">
                <img src="../../ASSETSGACHA/ADD BUTTON REVISED.png" class="add-button" alt="Add Button">
            </a>
        </div>
        
        <!-- New Button to go to the Chat Page -->
        <div class="chat-btn">
           <a href="../../chat-room-app/index.php">
                <button type="button" class="chat-button">Go to Chat</button>
            </a>
        </div>
        
    </div>
</body>
</html>