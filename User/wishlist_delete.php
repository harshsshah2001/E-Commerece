<?php

include('../conn.php');

if ($_GET["id"]) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM wishlist WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header('location:wishlist.php');
    } else {
        echo "error";
    }
} else {
    echo "error";
}
