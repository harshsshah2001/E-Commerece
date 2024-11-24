<?php
session_start();
include("navbar.php");
include('../conn.php');

// Check if the admin is logged in
if (!isset($_SESSION["admin_name"])) {
    header("Location: Admin_login.php");
    exit;
}

// Handle Search
$searchQuery = ""; // Initialize search query
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, trim($_GET['search']));
    $sql = "SELECT * FROM user_register WHERE name LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%' OR phone LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT * FROM user_register";
}
$result = mysqli_query($conn, $sql);

// Handle bulk delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
    if (isset($_POST['user_ids']) && is_array($_POST['user_ids'])) {
        $userIds = implode(',', array_map('intval', $_POST['user_ids'])); // Sanitize IDs
        $deleteQuery = "DELETE FROM user_register WHERE id IN ($userIds)";
        if (mysqli_query($conn, $deleteQuery)) {
            $status = 'deleted';
        } else {
            $status = 'error';
        }
    } else {
        $status = 'no_selection';
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?status=$status");
    exit;
}

// Check for status in the URL for status messages
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">User List</h2>


        <!-- Search Form -->
        <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="<?= htmlspecialchars($searchQuery); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>  

        </form>

        <!-- User Table -->
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Delete</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><input type="checkbox" name="user_ids[]" value="<?= $row['id']; ?>"></td>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row["name"]); ?></td>
                                <td><?= htmlspecialchars($row["email"]); ?></td>
                                <td><?= htmlspecialchars($row["phone"]); ?></td>
                                <td>
                                    <img src='../uploads/<?= htmlspecialchars($row['image']); ?>' alt='User Image' style='width: 50px; height: 50px;'>
                                </td>
                                <td>
                                    <a href='edit_user.php?id=<?= $row['id']; ?>' class='btn btn-sm btn-warning'>Edit</a>
                                    <a href='delete_user.php?id=<?= $row['id']; ?>' class='btn btn-sm btn-danger'>Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <button type="submit" name="delete_selected" class="btn btn-danger">Delete Selected</button>
        </form>
    </div>
</body>

</html>
