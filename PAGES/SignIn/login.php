<?php
session_start(); // Start session to store user information

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

// Function to display error messages
function display_error_message() {
    if (isset($_SESSION['error_message'])) {
        echo '<div style="color: red;">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Clear the error message after displaying it
    } else {
        echo '<div style="color: blue;">No error message set.</div>'; // Debugging line
    }
}

function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email address"); window.location.href = "signin.php";</script>';
        exit();
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    validate_email($email);

    // Retrieve user data from the database based on the entered email
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['error_message'] = "Database query failed: " . $conn->error;
        header("Location: signin.php");
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $verified = $row['verified'];
        $type = $row['type'];

        // Check if account is verified
        if ($verified != 1) {
            echo '<script>
                alert("Account is not verified. Please check your email for the verification link.");
                window.location.href = "signin.php";
              </script>';
            exit;
        } 
        
        if($type == 'BUYER'){
            echo '<script>
                alert("Invalid email or password");
                window.location.href = "signin.php";
            </script>';
            exit;
        }

        // Verify the entered password against the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Store user data in session for future use (e.g., user dashboard)
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_mname'] = $row['mname'];
            $_SESSION['user_lname'] = $row['lname'];
            $_SESSION['profile_picture'] = $row['profile_picture'];
            
            // Redirect to the user dashboard or another page
            header("Location: ../Profile/display_profile.php");
            exit;
        } else {
            echo '<script>
                alert("Incorrect password");
                window.location.href = "signin.php";
              </script>';
            exit;
        }
    } else {
        echo '<script>
            alert("Invalid email or password");
            window.location.href = "signin.php";
          </script>';
        exit;
    }
}

// Display error message if set
display_error_message();

// Close the database connection
$conn->close();
?>