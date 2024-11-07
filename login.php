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

session_start();
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM register_data WHERE name='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: v.php"); // Redirect to the dashboard or another page
            exit;
        } else {
            $errorMessage = "Invalid password!";
        }
    } else {
        $errorMessage = "No user found with that Name!";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/styles3.css"><!-- Link to your CSS file -->
</head>
<body>
    <div class="login-container">
        <form method="post" action="login.php">
            <h2> Login</h2>
            <input type="text" id="name" name="name" placeholder="Name"required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button><br><br>
            <p>Don't have an account? <a href="registration.php">Create your Account</a></p>
        </form>
    </div>

    <?php if ($errorMessage): ?>
    <div class="modal" id="errorModal">
        <div class="modal-content">
            <p><?php echo $errorMessage; ?></p>
            <button onclick="closeModal()">Go Back</button>
        </div>
    </div>
    <script>
        function closeModal() {
            document.getElementById('errorModal').style.display = 'none';
        }
    </script>
    <?php endif; ?>
</body>
</html>

