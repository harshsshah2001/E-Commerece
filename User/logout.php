<?php
$_SESSION['name'] = "";
$_SESSION['email'] = "";

// Redirect to the login page
header("Location: login.php");
exit;
