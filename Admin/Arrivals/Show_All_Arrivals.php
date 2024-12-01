<?php

session_start();
include('../../conn.php');


if (!isset($_SESSION["admin_name"])) {
    header("location:../Admin_login.php");
}
$name = "";
if (isset($_SESSION["admin_name"])) {
    $name = $_SESSION["admin_name"];
} else {
    echo "Session Error";
}


$sql = "SELECT * FROM `add_arrivals`";
$result = mysqli_query($conn, $sql);
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
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:rgb(89, 227, 202);">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>0
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto"> <!-- Centering links using mx-auto -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" style="color:black;font-size:larger;margin-right:20px;" href="../allusers.php">All Users</a>
                    </li>




                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="collectionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:black;font-size:larger;margin-right:20px;">
                            Collection
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="collectionDropdown">
                            <li>
                                <a class="dropdown-item" href="new collection/add_collection.php">Add_New_Collection</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="new collection/show_all_collections.php">Show_All_Collection</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="collectionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:black;font-size:larger;margin-right:20px;">
                            Arrivals
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="collectionDropdown">
                            <li>
                                <a class="dropdown-item" href="Arrivals/Add_New_Arrivals.php">Add_New_Arrivals</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="Arrivals/Show_All_Arrivals.php">Show_All_Arrivals</a>
                            </li>
                        </ul>
                    </li>

                    <a class="nav-link" href="all_orders.php" id="collectionDropdown" role="button" aria-expanded="false" style="color:black;font-size:larger; margin-right:20px;">
                        All_Orders
                    </a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="collectionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:black;font-size:larger;margin-right:20px;">
                            Selling Items
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="collectionDropdown">
                            <li>
                                <a class="dropdown-item" href="Selling_items/Add_New_Selling_Items.php">Add_New_Selling_Items</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="Selling_items//Show_All_Selling_Itmes.php">Show_All_Selling_Items</a>
                            </li>
                        </ul>
                    </li>


                </ul>
                <p style="color:black;font-size:larger;margin-right: 20px;margin-top: 13px;">Hello ! <?php echo "$name"; ?></p>
                <a href='Admin_logout.php' class='btn btn-danger'>Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">New Collection List</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Paragraph</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row["title"]); ?></td>
                            <td><?= htmlspecialchars($row["price"]); ?></td>
                            <td>
                                <img src="../../images/<?php echo htmlspecialchars($row['image']); ?>" alt="" style="width: 50px; height: 50px;">
                            </td>
                            <td>
                                <a href="edit_arrivals.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_arrivals.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">No users found</td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

    <!-- Include JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript to handle the delete button click
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `delete_user.php?id=${userId}`;
                    }
                });
            });
        });
    </script>
</body>

</html>





?>