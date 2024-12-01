<?php
session_start();
include('../../conn.php');

if (!isset($_SESSION["email"])) {
    header('Location:../Admin_login.php');
}

$id = intval($_GET["id"]);
// first check id is available 
$sql = "SELECT * FROM `best_selling_items` WHERE id=$id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) < 0) {
    echo "Item Not found";
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($conn, trim($_POST["name"]));
    $price = mysqli_real_escape_string($conn, trim($_POST["price"]));

    $image = $_FILES['image']['name'];
    $target_dir = "../../uploads";
    $target_file = $target_dir . basename($image);

    if ($image && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $update_query = "UPDATE `best_selling_items` SET `name`='$name',`image`='$image',`price`='$price' WHERE id=$id";
    } else {
        $update_query = "UPDATE `best_selling_items` SET `name`='$name',`price`='$price' WHERE id=$id";
    }
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        header("Location: Show_All_Selling_Itmes.php");
        exit;
    } else {
        echo "User update failed: " . mysqli_error($conn);
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Selling Items</title>
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
        <h2>Submit Your Details</h2>
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