<?php

// initialize php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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
        echo "<script>alert('Invalid email format!'); window.location.href='../Register/register.php';</script>";
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
        echo "<script>alert('User already exists!'); window.location.href='../Register/register.php';</script>";
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
                    echo "<script>alert('$error_message'); window.location.href='../Register/register.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions) . "'); window.location.href='../Register/register.php';</script>";
                exit();
            }
        }
        

        // Prepare and bind the SQL statement using a prepared statement
        $stmt = $conn->prepare("INSERT INTO users (name, mname, lname, email, password, age, contactno, gamegenre, profile_picture) VALUES (?, ?, ?, ?, ?, ?,?,?,?)");
        $stmt->bind_param("sssssssss", $name, $mname, $lname, $email, $hashed_password, $age, $contactno, $gamegenre, $profile_picture_name);

        // Execute the statement
        if ($stmt->execute()) {
            unset($_SESSION["user_id"]);
            
            // Store session variables
            $_SESSION['name'] = $name;
            
            $_SESSION['email'] = $email;
            $_SESSION['profile_picture'] = $profile_picture_name;

        
            // Redirect to a success page or login page


            // get latest insert id
            $latest_id = "SELECT id, email FROM users ORDER BY id desc limit 1";
            $stmt = $conn->prepare($latest_id);
            $stmt->execute();
            $query = $stmt->get_result();
            $row = $query->fetch_assoc();

            sendOTP($row['id'], $row['email'], $conn);

            exit(); // Ensure the script stops executing after redirection
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
}

function sendOTP($id, $email, $conn){
    $otp = rand(1000,9999);
    $_SESSION['user_otp_id'] = $id;
    $stmt = $conn->prepare("INSERT INTO otp (user_id, pin) VALUES (?, ?)");
    $stmt->bind_param("ss", $id, $otp);

    if($stmt->execute())
    {
        sendEmail($otp, $email);
    }

    //redirect to otp form, make otp folder
    header("Location: ../OTP/otp.php");
}

// emailer
function sendEmail($otp, $email){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host     = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jermainealee@gmail.com';
    $mail->Password = 'tikqscfpimxoxvwq';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;

    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );
   
    $mail->setFrom('jermainealee@gmail.com', 'Gacha');
   
    $mail->addAddress($email);

    $mail->Subject = 'OTP';

    $mailContent = "Your pin code is: " . $otp;
    $mail->Body = $mailContent;
    $mail->send();
}

// Close the database connection
$conn->close();

