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
    }
    else {
        echo '<div style="color: blue;">No error message set.</div>'; // Debugging line
    }
}

function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Invalid email address';
        header('Location: your_form_page.php'); // Redirect back to the form page
        exit();
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve user data from the database based on the entered email
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    // $sql = mysqli_query($conn,"SELECT * FROM users WHERE email='?".$_POST['email']."' and password='".md5($_POST['password'])."'");
    // $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['error_message'] = "Database query failed: " . $conn->error;
        header("Location: signin.html");
        exit;
    }

    // echo '<script> alert ("jerry")</script>';

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the entered password against the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Store user data in session for future use (e.g., user dashboard)
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];

            // Redirect to the user dashboard or another page
            header("Location: ../Profile/profile.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Invalid email or password"; // Set error message
            header("Location: signin.html"); // Redirect back to the sign-in page
            exit;   
        }
    } else {
        $_SESSION['error_message'] = "Invalid email or password"; // Set error message
        header("Location: signin.html"); // Redirect back to the sign-in page
        exit;
    }
}

// Display error message if set
display_error_message();

// Close the database connection
$conn->close();
?>
