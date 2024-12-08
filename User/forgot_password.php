<!-- my code -->
<?php
session_start();
include('../conn.php');

require '../vendor/autoload.php'; // Adjust the path if needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$otp = substr(str_shuffle("0123456789"), 0, 5);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    // Check if the email exists
    $emailcheck = "SELECT email FROM user_register WHERE email = '$email'";
    $emailresult = mysqli_query($conn, $emailcheck);

    if (mysqli_num_rows($emailresult) > 0) {
        $insertQuery = "INSERT INTO password_reset(`email`,`otp`) VALUES ('$email','$otp')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            $msg = "Your password RESET OTP is: <strong>$otp</strong>";
            if (smtp_mailer($email, 'Forgot Password OTP', $msg)) {
                echo "<script>
                        alert('Password Reset Link Sent to Your Email.');
                        
                      </script>";
            } else {
                echo "<p style='color: red;'>Failed to send OTP email.</p>";
            }
        } else {
            echo "<p style='color: red;'>Failed to generate OTP. Please try again.</p>";
        }
    } else {
        echo "<p style='color: green;'>OTP already sent to your email. Please check your inbox.</p>";
    }
} else {
    echo "<p style='color: red;'>Email not found in our records.</p>";
}

if (isset($_POST["otp"])) {
    $userOtp = mysqli_real_escape_string($conn, $_POST["otp"]);
    $otpcheck = "SELECT otp FROM password_reset WHERE email = '$email' AND otp = '$userOtp'";
    $otpresult = mysqli_query($conn, $otpcheck);

    if (mysqli_num_rows($otpresult) > 0) {

        // Redirect to the new password page
        $_SESSION['email'] = $email; // Save the email in the session for the reset process
        header('Location: newpassword.php');
        exit;
    } else {
        echo "<h4 style='color: red;'>Invalid OTP. Please try again.</h4>";
    }
}


function smtp_mailer($to, $subject, $msg)
{
    try {
        $email = $_POST["email"];

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->Username = "hs6648279@gmail.com";
        $mail->Password = "";
        $mail->setFrom($email, "Harsh Shah");
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->addAddress($to);

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
?>

<!-- //my Code  -->
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
        <h3 class="text-center mb-4">Forgot Password</h3>
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Enter your email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])): ?>
                <div class="mb-3">
                    <label for="otp" class="form-label">OTP</label>
                    <input type="number" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                </div>
            <?php endif; ?>

            <button type="submit" name="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
    </div>
</body>

</html>
