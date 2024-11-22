<?php
session_start();
include("navbar.php");
include('../conn.php');

// Check if the admin is logged in
if (!isset($_SESSION["admin_name"])) {
    header("Location: Admin_login.php");
    exit;
}

// Fetch user data
$sql = "SELECT * FROM user_register";
$result = mysqli_query($conn, $sql);

// Check for status in the URL for SweetAlert notifications
$status = isset($_GET['status']) ? $_GET['status'] : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">User List</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
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
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row["name"]); ?></td>
                            <td><?= htmlspecialchars($row["email"]); ?></td>
                            <td><?= htmlspecialchars($row["phone"]); ?></td>
                            <td>
                                <img src='../uploads/<?= htmlspecialchars($row['image']); ?>' alt='User Image' style='width: 50px; height: 50px;'>
                            </td>
                            <td>
                                <a href='edit_user.php?id=<?= $row['id']; ?>' class='btn btn-sm btn-warning'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                                <button class='btn btn-sm btn-danger delete-btn' data-id='<?= $row['id']; ?>'>
                                    <i class='fas fa-trash'></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Handle delete action with SweetAlert
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Perform AJAX request
                            fetch(`delete_user.php?id=${userId}`, {
                                    method: 'GET'
                                })
                                .then(response => response.text())
                                .then(data => {
                                    if (data.trim() === "success") {
                                        Swal.fire('Deleted!', 'The user has been deleted.', 'success').then(() => {
                                            location.reload(); // Reload the page
                                        });
                                    } else {
                                        Swal.fire('Error!', 'Failed to delete the user.', 'error');
                                    }
                                });
                        }
                    });
                });
            });

            // Display SweetAlert based on the status query parameter
            const status = '<?= $status; ?>';
            if (!status === 'deleted') {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'User has been deleted successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else if (status === 'error') {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was a problem deleting the user. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
</body>

</html>