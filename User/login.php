<?php
include("../conn.php");
require '../vendor/autoload.php'; // Adjust the path if needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check for user existence
    $sql = "SELECT * FROM user_register WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $hashedPassword = $user["password"];
        // we take a name form darabse 
        $name = $user["name"];
        // Verify password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;

            // email code 
            function smtp_mailer($to, $subject, $msg)
            {
                try {
                    // Initialize PHPMailer
                    $email = $_SESSION['email'];
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 587;
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';

                    // Set Gmail credentials
                    $mail->Username = "hs6648279@gmail.com";  // Your Gmail address
                    $mail->Password = "";    // Your Gmail App Password
                    $mail->setFrom("$email", "Harsh Shah"); // Sender details

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
                    $mail->send();
                } catch (Exception $e) {
                    return "Mailer Error: " . $mail->ErrorInfo;
                }
            }
            $msg = '
            <h1 style="color: blue;">Welcome to Our Platform!</h1>
            <p style="color: gray; font-size: 16px;">
                Thank you for joining us. We are excited to have you on board. 
                Please feel free to explore and get started.
            </p>
        ';
            $attachmentPath = "../uploads/cat-item1.jpg"; // Update the path as needed

            // Debug: Verify email address
            $email = isset($_SESSION['email']) ? $_SESSION['email'] : "recipient_email@example.com";

            // Call the function to send email
            echo smtp_mailer($email, 'Test Subject', $msg, $attachmentPath);
        }
        header('Location: ../index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1s ease-in-out;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
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
    </style>
</head>

<body>
    <div class="login-card">
        <h3 class="text-center mb-4">Login</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                <small class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
