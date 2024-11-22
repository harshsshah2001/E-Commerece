<?php

// session_start();

$name = "";
if (isset($_SESSION["admin_name"])) {
    $name = $_SESSION["admin_name"];
} else {
    echo "Session Error";
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:rgb(89, 227, 202);">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>0
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto"> <!-- Centering links using mx-auto -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" style="color:black;font-size:larger;" href="./allusers.php">All Users</a>
                    </li>




                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="collectionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:black;font-size:larger;">
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
                        <a class="nav-link dropdown-toggle" href="#" id="collectionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:black;font-size:larger;">
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

                </ul>
                <p style="color:black;font-size:larger;margin-right: 20px;margin-top: 13px;">Hello ! <?php echo "$name"; ?></p>
                <a href='Admin_logout.php' class='btn btn-danger'>Logout</a>
            </div>
        </div>
    </nav>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>