<?php
session_start();
$_SESSION["admin_email"] = null;
$_SESSION["admin_name"] = null;
// Redirect to the login page
header("Location: Admin_login.php");
exit;
