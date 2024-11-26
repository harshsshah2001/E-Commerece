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
                <label for="email" class="form-label">New Password</label>
                <input type="number" class="form-control" id="email" name="newpassword" placeholder="Enter Your Password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"></label>
                <input type="number" class="form-control" id="email" name="retypepassword" placeholder="Re-Type Password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
    </div>
</body>

</html>