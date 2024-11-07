<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <link rel="stylesheet" href="./css/update.css">
</head>

<?php
// Database connection
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "user_management"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $status = $conn->real_escape_string($_POST['status']);
    $avatar = null;

    // Handle avatar upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        // Get file details
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Valid file extensions
        $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Sanitize and upload file
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $newFileName;
            
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $avatar = $dest_path;
            } else {
                echo 'Error moving file to upload directory.';
            }
        } else {
            echo 'Invalid file type. Allowed types: ' . implode(', ', $allowedfileExtensions);
        }
    }

    // Update query
    if ($avatar) {
        $sql = "UPDATE users SET name='$name', email='$email', role='$role', status='$status', avatar='$avatar' WHERE id=$id";
    } else {
        $sql = "UPDATE users SET name='$name', email='$email', role='$role', status='$status' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<div class='message-box success'>";
        echo "<p>User updated successfully!</p>";
        echo "<p><a href='v.php?id=$id'>Go back</a></p>";
        echo "</div>";
    } else {
        echo "<div class='message-box error'>";
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        echo "<p><a href='v.php?id=$id'>Go back</a></p>";
        echo "</div>";
    }
    
    
}

$conn->close();
?>