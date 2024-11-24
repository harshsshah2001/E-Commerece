<?php
session_start();
include('../conn.php');

$error = ""; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verify_otp"])) {
    $otp = mysqli_real_escape_string($conn, $_POST["otp"]);

    // Fetch OTP for verification
    $sql = "SELECT `otp` FROM `user_register` WHERE otp='$otp'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_otp = $row['otp'];

        // Compare OTPs
        if ($otp === $stored_otp) {
            // Redirect to login on success
            header('Location: login.php?status=verified');
            exit;
        } else {
            $error = "Invalid OTP. Please try again.";
        }
    } else {
        $error = "No OTP found. Please request a new OTP.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
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

        .otp-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <div class="otp-container">
        <h3 class="text-center mb-4">OTP Verification</h3>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="otp" class="form-label">Enter OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" maxlength="6" required>
            </div>
            <button type="submit" name="verify_otp" class="btn btn-primary w-100">Verify OTP</button>
        </form>
        <div class="text-center mt-3">
            <p class="text-muted">Didn't receive OTP? <a href="resend_otp.php" class="text-decoration-none">Resend</a></p>
        </div>
    </div>
</body>

</html>