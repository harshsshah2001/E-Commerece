<?php

session_start();
include('../conn.php');
include('navbar.php');

if (!isset($_SESSION['admin_email'])) {
    // Redirect to login page if the session is not set
    header('Location: Admin_login.php');
    exit();
}

// $sql = "SELECT * FROM `payment`";
// $result = mysqli_query($conn, $sql);

$searchQuery = "";
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['searchsubmit'])) {
    $searchQuery = mysqli_real_escape_string($conn, trim($_GET['searchsubmit']));
    $searchdata = "SELECT * FROM payment WHERE name LIKE '%$searchQuery%' OR name LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%' OR order_id LIKE '%$searchQuery%'";
} else {
    $searchdata = "SELECT * FROM payment";
}
$searchresult = mysqli_query($conn, $searchdata);


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .table-container {
            margin: 50px auto;
            max-width: 900px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .table {
            margin: 0;
        }

        .table th {
            /* background-color: #007bff; */
            color: black;
            text-align: center;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .caption {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>

<body>
    <form class="form-inline my-lg-0 mt-5px" style="margin-left: 200px;" method="get" action="">
        <input class="form-control mr-sm-2" name="searchsubmit" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <div class="container">
        <div class="table-container">
            <h1 class="caption">List of Users</h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Order_ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $email = $_SESSION['email'];
                    if (mysqli_num_rows($searchresult) > 0) {
                        while ($row = mysqli_fetch_assoc($searchresult)) {
                            echo '<tr>
                                <th scope="row">' . htmlspecialchars($row['id']) . '</th>
                                <td>' . htmlspecialchars($row['name']) . '</td>
                                <td>' . htmlspecialchars($row['email']) . '</td>
                                <td>' . htmlspecialchars($row['amount']) . '</td>
                                <td>' . htmlspecialchars($row['order_id']) . '</td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center">No records found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>