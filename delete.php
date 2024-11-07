<?php
// Database connection
$servername = "localhost";
$username = "root"; // your username
$password = ""; // your password
$dbname = "user_management"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL to delete a record
    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the user management page
        header("Location: v.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No ID specified.";
}

$conn->close();
?>

