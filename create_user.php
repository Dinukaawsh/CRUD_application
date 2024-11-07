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
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $status = $conn->real_escape_string($_POST['status']);

    // Handle avatar upload
    $avatar = null;
    $upload_dir = 'uploads/';

    // Ensure the upload directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatar = $upload_dir . basename($_FILES['avatar']['name']);
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar)) {
            // File successfully uploaded
        } else {
            echo "<p>There was an error moving the file to the upload directory. Please make sure the upload directory is writable by the web server.</p>";
            $avatar = null; // Reset avatar to null if upload failed
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO users (name, email, role, status, avatar) 
            VALUES ('$name', '$email', '$role', '$status', '$avatar')";

if ($conn->query($sql) === TRUE) {
    echo "<div class='notification success'>
            <p>User created successfully!</p>
            <a href='v.php' class='btn-back'>Go Back</a>
          </div>";
} else {
    echo "<div class='notification error'>
            <p>Error: " . $sql . "<br>" . $conn->error . "</p>
            <a href='v.php' class='btn-back'>Go Back</a>
          </div>";
}


}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <link rel="stylesheet" href="./css/user_css.css">
</head>
<body>
    <div class="container">
        <h1>Create New User</h1>
        <form action="create_user.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="Only user">Only user</option>
                    <option value="Subscriber">Subscriber</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
            </div>
            <button type="submit">Create User</button>
        </form>
    </div>
</body>
</html>

