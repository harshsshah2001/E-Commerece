<?php

include("../conn.php");
session_start();

if (!isset($_SESSION["email"])) {
    header("Location:Admin_login.php");
    exit;
}

// Check if the ID is valid
if (!isset($_GET["id"]) || empty(trim($_GET["id"]))) {
    die("Invalid Request");
}

$id = intval($_GET["id"]);

// Fetch the user data
$sql = "SELECT * FROM user_register WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) <= 0) {
    die("User Not Found");
}

$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($conn, trim($_POST["name"]));
    $phone = mysqli_real_escape_string($conn, trim($_POST["phone"]));
    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $password = mysqli_real_escape_string($conn, trim($_POST["password"]));
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $image = $_FILES['image']['name'] ?? '';
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image);

    if ($image && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $update_query = "UPDATE user_register 
                         SET name = '$name', email = '$email', phone = '$phone', password = '$hashedPassword', image = '$image' 
                         WHERE id = $id";
    } else {
        $update_query = "UPDATE user_register 
                         SET name = '$name', email = '$email', phone = '$phone', password = '$hashedPassword' 
                         WHERE id = $id";
    }

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        header("Location: allusers.php");
        exit;
    } else {
        echo "User update failed: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form action="edit_user.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <small class="form-text text-muted">Current: <?php echo htmlspecialchars($user['image']); ?></small>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update User</button>
            <a href="allusers.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
