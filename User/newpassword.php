<?php

session_start();
include('../conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $newpassword = mysqli_real_escape_string($conn, $_POST["newpassword"]);
    $retypepassword = mysqli_real_escape_string($conn, $_POST["retypepassword"]);
    $email = $_SESSION['email'];

    if ($newpassword === $retypepassword) {
        $sql = "SELECT `password` FROM `user_register` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            // Hash the new password
            $hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $updateQuery = "UPDATE `user_register` SET `password` = '$hashedpassword' WHERE `email` = '$email'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                echo "<script>
                        alert('Password updated successfully. Please log in with your new password.');
                        window.location.href = 'login.php'; // Redirect to login page
                      </script>";
            } else {
                echo "<h4 style='color: red;'>Failed to update password. Please try again.</h4>";
            }
        } else {
            echo "<h4 style='color: red;'>User not found in our records.</h4>";
        }
    } else {
        echo "<h1 style='color: red;'>Passwords do not match. Please try again.</h1>";
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .forgot-password-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <div class="forgot-password-container">
        <h3 class="text-center mb-4">New Password</h3>
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="text" class="form-label">New Password</label>
                <input type="text" class="form-control" id="email" name="newpassword" placeholder="Enter Your Password" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label"></label>
                <input type="text" class="form-control" id="email" name="retypepassword" placeholder="Re-Type Password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</body>

</html>