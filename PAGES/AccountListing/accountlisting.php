<?php
// Start the session
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process registration form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';

    $uploaded_images = [];

    if (isset($_FILES['profile_pictures']) && $_FILES['profile_pictures']['error'][0] === UPLOAD_ERR_OK) {
        $file_count = count($_FILES['profile_pictures']['name']);
        $upload_dir = 'assets/uploads/';

        for ($i = 0; $i < $file_count; $i++) {
            $file_tmp_path = $_FILES['profile_pictures']['tmp_name'][$i];
            $file_name = $_FILES['profile_pictures']['name'][$i];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($file_extension, $allowedfileExtensions)) {
                $unique_file_name = uniqid() . '.' . $file_extension;
                $dest_path = $upload_dir . $unique_file_name;

                if (move_uploaded_file($file_tmp_path, $dest_path)) {
                    $uploaded_images[] = $unique_file_name;
                } else {
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
    }

    // Convert the array of uploaded images to a JSON string
    $uploaded_images_json = json_encode($uploaded_images);

    // Prepare and bind the SQL statement using a prepared statement
    $stmt = $conn->prepare("INSERT INTO accounts (title, category, description, price, account_pictures) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssis", $title, $category, $description, $price, $uploaded_images_json);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Account registered successfully!'); window.location.href='../Register/register.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='../Register/register.html';</script>";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
