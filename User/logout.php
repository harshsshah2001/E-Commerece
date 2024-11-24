<?php
session_start();
$_SESSION['name'] = null;
$_SESSION['email'] = null;
// Redirect to the login page
header("Location: ../index.php");
exit;
