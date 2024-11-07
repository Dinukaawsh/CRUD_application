<?php
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "user_management"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ''; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $checkUserQuery = "SELECT * FROM register_data WHERE name='$name'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        // User already exists
        $message = "User with this name is already registered. Please choose a different name.";
    } else {
        // Proceed to register the user
        $sql = "INSERT INTO register_data (name, password) VALUES ('$name', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./css/styles2.css">
</head>
<body>
    <div class="form-container">
        <form action="registration.php" method="POST">
            <h2>Create your Account</h2>
            <?php if ($message): ?>
                <div class="error-message"><?php echo $message; ?></div>
            <?php endif; ?>
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Register</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
