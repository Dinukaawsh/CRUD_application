<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "user_management"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="animated-bg"></div> <!-- Animated background layer -->

    <div class="container">
        <h1>User Management</h1>
        <a href="index.html" class="logout-btn">Logout</a>
   <br>
        <a href="create_user.php" class="create1-user1-btn1">Add User</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td><img src='{$row['avatar']}' alt='Avatar'></td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['role']}</td>
                    <td>{$row['status']}</td>
                    <td>   
                    <a href='update.php?id={$row['id']}' class='btn-edit'>Edit</a>
                    <a href='delete.php?id={$row['id']}' class='btn-delete'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7' class='no-users'>No users found. Click 'Add User' to get started!</td></tr>";
    }
    ?>
</tbody>

        </table>
    </div>
</body>
</html>
