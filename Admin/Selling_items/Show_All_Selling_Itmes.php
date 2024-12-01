<?php

session_start();
include('../../conn.php');
include('./navbar.php');

$email = $_SESSION["email"];
$sql = "SELECT * FROM `best_selling_items`";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items Table</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        .container {
            width: 80%;
            margin: 50px auto;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #fff;
        }

        /* Hover effect on table rows */
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Image styling */
        img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
                font-size: 14px;
            }

            th,
            td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Items Table</h2>
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Action's</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row["name"]); ?></td>

                                <td>
                                    <img src="../../../uploads/<?php echo ($row['image']); ?>" alt="" style="width: 50px; height: 50px;">
                                </td>
                                <td><?= htmlspecialchars($row["price"]); ?></td>
                                <td>
                                    <a href="edit__selling_items.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete_selling_items.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger">
                                        <i class="fas fa-edit"></i> Delete
                                    </a>
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
            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">

    </div>
</body>

</html>