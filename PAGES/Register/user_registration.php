<?php
// Start the session
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

// Process registration form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $contactno = $_POST['contactno'];
    $gamegenre = $_POST['gamegenre'];

    // Check if user already exists
    $select = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind the SQL statement using a prepared statement
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, age, contactno, gamegenre) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $hashed_password, $age, $contactno, $gamegenre);

        // Execute the statement
        if ($stmt->execute()) {
            // Store session variables
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;

            // Redirect to a success page or login page
            header("Location: ../Signin/signin.html");
            exit(); // Ensure the script stops executing after redirection
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
