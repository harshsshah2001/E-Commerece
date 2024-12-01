<?php
session_start();
include('../../conn.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Sanitize and validate inputs
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $price = mysqli_real_escape_string($conn, trim($_POST['price']));
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    // Check if the email exists in the session
    if (empty($email)) {
        echo "Session email not found. Please log in.";
        exit;
    }

    $image = $_FILES['image']['name'];
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($image);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {

        $sql = "INSERT INTO `best_selling_items` (`name`, `image`, `price`) VALUES ('$name', '$image', '$price')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect to the all_orders page
            header('Location: ../all_orders.php');
            exit;
        } else {
            echo "Error inserting data into the database: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading the file. Please try again.";
    }
}



?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #75e4ff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .form-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1s ease;
        }

        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-container input:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.3);
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .form-container button:hover {
            background: linear-gradient(90deg, #2575fc, #6a11cb);
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Add Selling Items</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" placeholder="Enter the price" required>

            <label for="image">Upload Image</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>