<?php
// Ensure session starts before any output
session_start();
require '../vendor/autoload.php'; // Adjust the path if needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include database connection
include('../conn.php');

// Generate a 5-digit OTP
$otp = substr(str_shuffle("0123456789"), 0, 5);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Sanitize and retrieve form inputs
    $name = mysqli_real_escape_string($conn, trim($_POST["name"]));
    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $phone = mysqli_real_escape_string($conn, trim($_POST["phone"]));
    $password = mysqli_real_escape_string($conn, trim($_POST["password"]));
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $image = $_FILES['image']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image);

    // Check if the email is already registered
    $emailCheckQuery = "SELECT `email` FROM `user_register` WHERE email='$email'";
    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        echo "<p style='color: red;'>Email is already registered!</p>";
    } else {
        // Move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $current_date = date('Y-m-d H:i:s');

            // Insert user details into the database with OTP and default status
            $insertQuery = "INSERT INTO `user_register`(`name`, `email`, `phone`, `image`, `password`, `created_at`, `otp`) 
                            VALUES ('$name', '$email', '$phone', '$image', '$hashedPassword', '$current_date', '$otp')";
            $insertResult = mysqli_query($conn, $insertQuery);

            if ($insertResult) {
                // Send OTP via email
                $msg = "
                    <h1 style='color: red;'>Welcome to Our Harsh HUB!</h1>
                    <p style='color: gray; font-size: 16px;'>
                        Thank you for joining us. Your OTP for account verification is: <strong>$otp</strong>
                    </p>";

                if (smtp_mailer($email, 'Account Verification OTP', $msg)) {
                    echo "<p style='color: green;'>OTP has been sent to your email. Please verify your account.</p>";

                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 1000); 
                    </script>";
                } else {
                    echo "<p style='color: red;'>Failed to send OTP email.</p>";
                }
            } else {
                echo "<p style='color: red;'>Error in registration.</p>";
            }
        } else {
            echo "<p style='color: red;'>File upload failed.</p>";
        }
    }
}

// Function to send email
function smtp_mailer($to, $subject, $msg)
{

    try {

        $email = $_POST['email'];

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // Set Gmail credentials
        $mail->Username = "hs6648279@gmail.com";  // Replace with your Gmail address
        $mail->Password = "hmdh jshj qqcf aqzt"; // Replace with your Gmail App Password
        $mail->setFrom($email, "Harsh Shah"); // Replace with your sender details

        // Email details
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->addAddress($to);

        // SMTP options for compatibility
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Send email
        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Here</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
        }

        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 25px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 91, 187, 0.3);
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2>Register Here</h2>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" name="name" id="exampleInputName" placeholder="Enter Name">
                <small id="nameHelp" class="form-text">Your Name</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPhone">Phone</label>
                <input type="number" class="form-control" name="phone" id="exampleInputPhone" placeholder="Enter Phone Number">
                <small id="phoneHelp" class="form-text">Your Phone Number</small>
            </div>
            <div class="form-group">
                <label for="exampleImage">Profile Image</label>
                <input type="file" class="form-control-file" name="image" id="exampleImage">
                <small id="imageHelp" class="form-text">Upload a profile picture</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                <small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Agree to terms and conditions</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>