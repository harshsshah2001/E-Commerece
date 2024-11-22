<?php

include("../../conn.php");
session_start();

if (!isset($_SESSION["admin_email"])) {
    header("Location:Admin_login.php");
    exit;
}

// Check if the ID is valid
if (!isset($_GET["id"]) || empty(trim($_GET["id"]))) {
    die("Invalid Request");
}

$id = intval($_GET["id"]);

// Fetch the user data
$sql = "SELECT * FROM add_arrivals WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) <= 0) {
    die("User Not Found");
}

$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $title = mysqli_real_escape_string($conn, trim($_POST["title"]));
    $price = mysqli_real_escape_string($conn, trim($_POST["price"]));


    $image = $_FILES['image']['name'] ?? '';
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($image);

    if ($image && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $update_query = "UPDATE add_arrivals  
                         SET title = '$title', price = '$price', image = '$image' 
                         WHERE id = $id";
    } else {
        $update_query = "UPDATE  add_arrivals
                         SET title = '$title', price = '$price'
                         WHERE id = $id";
    }

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        header("Location: show_all_Arrivals.php");
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
    <title>Edit Collection Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Collection Item</h2>
        <form action="edit_arrivals.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($user['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($user['price']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">New Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <small class="form-text text-muted">Current: <?php echo htmlspecialchars($user['image']); ?></small>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update Arrival</button>
            <a href="new collection/show_all_collection.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>