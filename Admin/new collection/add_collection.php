<?php
include('../../conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] = "POST" && isset($_POST["submit"])) {

    $title = mysqli_real_escape_string($conn, trim($_POST["title"]));
    $paragraph = mysqli_real_escape_string($conn, trim($_POST["paragraph"]));

    $image = $_FILES['image']['name'];
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($image);


    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO `add_collection`(`title`, `paragraph`, `image`) VALUES ('$title','$paragraph','$image')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('location:../allusers.php');
            exit;
        } else {
            echo "Data Not Inserted";
        }
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .form-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 50px auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-header h2 {
            font-weight: bold;
            color: #343a40;
        }

        .btn-custom {
            background-color: #007bff;
            color: #fff;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Create New Post</h2>
            </div>
            <form action="add_collection.php" method="POST" enctype="multipart/form-data">
                <!-- Title Field -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                </div>

                <!-- Paragraph Field -->
                <div class="form-group">
                    <label for="paragraph">Paragraph</label>
                    <textarea class="form-control" id="paragraph" name="paragraph" rows="4" placeholder="Write your paragraph here..." required></textarea>
                </div>

                <!-- Image Upload Field -->
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-custom">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>