<?php
include('../../conn.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM add_collection WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header('location:show_all_collections.php');
    } else {
        echo "error";
    }
} else {
    echo "error";
}
