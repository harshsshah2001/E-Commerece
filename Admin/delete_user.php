<?php
include("../conn.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM user_register WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header('location:allusers.php');
    } else {
        echo "error";
    }
} else {
    echo "error";
}