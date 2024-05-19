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

// List of valid TLDs
$valid_tlds = ['com', 'org', 'net', 'edu', 'gov', 'mil', 'int', 'co', 'io', 'biz', 'info', 'me', 'us', 'uk', 'ca', 'de', 'fr', 'au', 'jp', 'cn', 'br', 'in', 'ru', 'kr', 'za', 'mx', 'es', 'it', 'nl', 'se', 'no', 'fi', 'dk', 'pl', 'ch', 'at', 'be', 'nz'];

// Function to validate the TLD of the email
function is_valid_tld($email, $valid_tlds) {
    $domain = substr(strrchr($email, "."), 1);
    return in_array($domain, $valid_tlds);
}

// Process registration form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   

    // $name = $_POST['name'];
    // $mname = $_POST['mname'];
    // $lname = $_POST['lname'];
    // $email = $_POST['email'];
    // $password = $_POST['password'];
    // $age = $_POST['age'];
    // $contactno = $_POST['contactno'];
    // $gamegenre = $_POST['gamegenre'];

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $mname = isset($_POST['mname']) ? $_POST['mname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $contactno = isset($_POST['contactno']) ? $_POST['contactno'] : '';
    $gamegenre = isset($_POST['gamegenre']) ? $_POST['gamegenre'] : '';


    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !is_valid_tld($email, $valid_tlds)) {
        echo "<script>alert('Invalid email format!'); window.location.href='../Register/register.html';</script>";
        exit(); // Stop further execution
    }

    // Check if user already exists
    $select = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($select);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists
        echo "<script>alert('User already exists!'); window.location.href='../Register/register.html';</script>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $profile_picture_name = '';

        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
            $file_name = $_FILES['profile_picture']['name'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($file_extension, $allowedfileExtensions)) {
                $profile_picture_name = uniqid() . '.' . $file_extension; // Generate unique file name
                $upload_dir = 'assets/uploads/';
                $dest_path = $upload_dir . $profile_picture_name;

                if (!move_uploaded_file($file_tmp_path, $dest_path)) {
                    $error_message = 'Error uploading file. Check if the uploads directory is writable.';
                    if (!is_writable($upload_dir)) {
                        $error_message .= ' Directory is not writable.';
                    }
                    echo "<script>alert('$error_message'); window.location.href='../Register/register.html';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions) . "'); window.location.href='../Register/register.html';</script>";
                exit();
            }
        }
        

        // Prepare and bind the SQL statement using a prepared statement
        $stmt = $conn->prepare("INSERT INTO users (name, mname, lname, email, password, age, contactno, gamegenre, profile_picture) VALUES (?, ?, ?, ?, ?, ?,?,?,?)");
        $stmt->bind_param("sssssssss", $name, $mname, $lname, $email, $hashed_password, $age, $contactno, $gamegenre, $profile_picture_name);


        // Execute the statement
        if ($stmt->execute()) {
            // Store session variables
            $_SESSION['name'] = $name;
            
            $_SESSION['email'] = $email;
            $_SESSION['profile_picture'] = $profile_picture_name;

        
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