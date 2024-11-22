<?php

$host = 'localhost';
$database = 'E-commerece PHP';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $database);


if (!$conn) {
    die('MySQL connection error: ' . mysqli_connect_error());
}

// echo 'Connection successful!';

?>
