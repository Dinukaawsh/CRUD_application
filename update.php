<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="./css/update.css">
</head>
<body>
    <div class="container">
        <h1>Update User Details</h1>
        <?php
// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Database connection
    $conn = new mysqli("localhost", "root", "", "user_management");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user data based on ID
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found.");
    }
} else {
    // Handle missing 'id' parameter
    die("User ID is missing in the URL.");
}
?>

        
        <form action="a.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="Only user" <?php if($user['role'] == 'Only user') echo 'selected'; ?>>Only user</option>
                    <option value="Subscriber" <?php if($user['role'] == 'Subscriber') echo 'selected'; ?>>Subscriber</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Active" <?php if($user['status'] == 'Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if($user['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <?php if ($user['avatar']): ?>
                    <div class="avatar-preview">
                        <img src="<?php echo $user['avatar']; ?>" alt="Avatar">
                    </div>
                <?php endif; ?>
                <input type="file" id="avatar" name="avatar" accept="image/*">
            </div>
            <button type="submit">Update User</button>
        </form>
       
    </div>
</body>
</html>
