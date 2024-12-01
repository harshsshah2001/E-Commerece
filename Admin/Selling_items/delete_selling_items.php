<?php

session_start();

include('../../conn.php');

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $sql = "DELETE FROM `best_selling_items` WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location:../../allusers.php');
    }
}
