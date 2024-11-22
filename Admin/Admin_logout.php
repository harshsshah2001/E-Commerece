<?php


session_unset($_SESSION["admin_email"]);
session_unset($_SESSION["admin_name"]);

// Redirect to the login page
header("Location: Admin_login.php");
exit;
