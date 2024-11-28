<?php

include('../conn.php');
session_start();

if (!isset($_SESSION['email'])) {
    header('location:login.php');
}


$amount = 0;
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .wishlist-container {
            margin: 50px auto;
            padding: 20px;
            max-width: 90%;
        }

        .wishlist-header {
            text-align: center;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }

        .wishlist-header h2 {
            font-size: 2rem;
            color: #333;
        }

        .wishlist-cards {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 10px;
            scroll-behavior: smooth;
        }

        .wishlist-cards::-webkit-scrollbar {
            height: 8px;
        }

        .wishlist-cards::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 10px;
        }

        .wishlist-cards::-webkit-scrollbar-track {
            background-color: #ccc;
        }

        .wishlist-card {
            flex: 0 0 auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            transition: transform 0.3s ease;
            animation: slideIn 1s ease-out;
        }

        .wishlist-card:hover {
            transform: scale(1.05);
        }

        .wishlist-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .wishlist-card-content {
            padding: 15px;
        }

        .wishlist-card-title {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 10px;
        }

        .wishlist-card-price {
            font-size: 1rem;
            color: #007bff;
            margin-bottom: 15px;
        }

        .wishlist-card-btn {
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .wishlist-card-btn:hover {
            background-color: #0056b3;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h2>Your Wishlist</h2>
        </div>

        <?php
        include('../conn.php');

        // Check if the required parameters are set
        if (isset($_GET["title"]) && isset($_GET["price"]) && isset($_GET["image"])) {
            $title = $_GET["title"];
            $price = $_GET["price"];
            $image = $_GET["image"];
            $email = $_SESSION['email'];

            // Check if the item already exists in the wishlist for the current user
            $check_sql = "SELECT * FROM `wishlist` WHERE `title` = '$title' AND `user_id` = '$email'";
            $check_result = mysqli_query($conn, $check_sql);

            if (mysqli_num_rows($check_result) == 0) {
                // If the item does not exist, insert it into the wishlist
                $sql = "INSERT INTO `wishlist`(`title`, `price`, `image`, `user_id`) VALUES ('$title','$price','$image','$email')";
                mysqli_query($conn, $sql);
            }
        }

        // Retrieve and display all wishlist items for the current user
        $email = $_SESSION['email'];
        $data = "SELECT * FROM `wishlist` WHERE user_id='$email'";
        $results = mysqli_query($conn, $data);

        if (mysqli_num_rows($results) > 0) {

            while ($rows = mysqli_fetch_assoc($results)) {
                $amount = $rows['price'];
                echo ' 
        <div class="wishlist-cards">
            <div class="wishlist-card">
                <img src="../uploads/' . $rows['image'] .  '" alt="Product" style="width: 200px; height: 200px; object-fit: cover;">
                <div class="wishlist-card-content">
                    <h3 class="wishlist-card-title">' . $rows['title'] .   '</h3>
                    <p class="wishlist-card-price">$' . $rows['price'] .  '</p>
                   
                    <a href="wishlist_delete.php?id=' . $rows['id'] . '" style="background-color: dange;">Remove</a>
                  
    <button id="payButton" class="btn btn-dark text-uppercase mt-3" >Pay Now</button>
                    
                    </div>
                    </div>
                    </div>';
            }
        }
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        document.getElementById('payButton').onclick = function(e) {
            var options = {
                "key": "rzp_test_xKpWOmC2HxLD0g", // Enter the Key ID generated from the Dashboard
                "amount": "<?php echo $amount * 100 ?>", // Amount is in currency subunits. Default currency is INR.
                "currency": "INR",
                "name": "Your Company Name",
                "description": "Purchase Description",
                "image": "https://yourdomain.com/your_logo.png",
                "handler": function(response) {
                    alert("Payment successful. Payment ID: " + response.razorpay_payment_id);
                    // Redirect to another page with order ID and amount as query parameters
                    window.location.href = "payment_success.php?amount=" + options.amount + "&order_id=" + response.razorpay_payment_id;
                },
                "prefill": {
                    "name": "John Doe",
                    "email": "john.doe@example.com",
                    "contact": "9999999999"
                },
                "notes": {
                    "address": "Hello World"
                },
                "theme": {
                    "color": "#F37254"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        }
    </script>
</body>

</html>