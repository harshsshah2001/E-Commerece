<?php

include('../conn.php');
session_start();

if (!isset($_SESSION['email'])) {
    header('location:login.php');
}

$amount = 0;
$user_id = $_SESSION['email'];

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
        .wishlist-card {
            flex: 0 0 auto;
            display: flex;
            /* Ensures the card's content is laid out horizontally */
            align-items: center;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 600px;
            /* Adjust card width */
            transition: transform 0.3s ease;
            animation: slideIn 1s ease-out;
            padding: 10px;
        }

        .wishlist-card img {
            flex-shrink: 0;
            /* Prevent image from shrinking */
            width: 150px;
            /* Fixed image width */
            height: 150px;
            /* Fixed image height */
            object-fit: cover;
            border-radius: 10px;
            margin-right: 15px;
        }

        .wishlist-card-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Align text vertically in the remaining space */
            padding: 0;
            margin: 0;
        }

        .wishlist-card-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .wishlist-card-price {
            font-size: 1.2rem;
            color: #007bff;
            margin-bottom: 10px;
        }

        .wishlist-card-btn {
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: inline-block;
            margin-top: 10px;
        }
    </style>

</head>

<body>
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h2>Your Wishlist</h2>
            <?php
            $name = $_SESSION["name"];
            ?>
            <div>Your Name is : <?php echo $name; ?></div>
        </div>


        <div class="col-md-3">

            <form action="" method="get">
                <div class="card shadow mt-3">
                    <div class="card-header">

                    </div>
                    <h5>Filter
                        <button type="submit" class="btn btn-primary btn-sm float-end">Search</button>
                        <button type="submit" name="clear_filter" value="1" class="btn btn-secondary btn-sm">Clear Filter</button>

                    </h5>

                    <div class="card-body">

                        <hr>

                        <div>
                            <input type="checkbox" name="checkbox" value="100-200">
                            <label>100-200</label>
                        </div>
                        <div>
                            <input type="checkbox" name="checkbox" value="200-300">
                            <label>200-300</label>
                        </div>
                        <div>
                            <input type="checkbox" name="checkbox" value="300-400">
                            <label>300-400</label>
                        </div>

                    </div>

                </div>
            </form>
        </div>





        <?php

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            // Check if the "Clear Filter" button was clicked
            if (isset($_GET['clear_filter'])) {
                // Display all items when "Clear Filter" is clicked
                $query = "SELECT * FROM wishlist WHERE user_id = '$user_id'";
                $fetchalldata = mysqli_query($conn, $query);

                if (mysqli_num_rows($fetchalldata) > 0) {
                    while ($rowings = mysqli_fetch_assoc($fetchalldata)) {
                        $amount = $rowings['price'];
                        echo ' 
<div class="wishlist-card">
<img src="../uploads/' . $rowings['image'] . '" alt="Product" style="width: 200px; height: 200px; object-fit: cover;">
<div class="wishlist-card-content">
    <h3 class="wishlist-card-title">' . $rowings['title'] . '</h3>
    <p class="wishlist-card-price">$' . $rowings['price'] . '</p>
    <a href="wishlist_delete.php?id=' . $rowings['id'] . '" style="background-color: danger;">Remove</a>
    <button class="payButton btn btn-dark text-uppercase mt-3" 
            data-amount="' . htmlspecialchars($rowings['price'] * 100) . '" 
            data-title="' . htmlspecialchars($rowings['title']) . '">
        Pay Now
    </button>
</div>
</div>';
                    }
                } else {
                    echo "<p>No items found in your wishlist.</p>";
                }
            } elseif (isset($_GET['checkbox']) && !empty($_GET['checkbox'])) {
                // Handle the price range filter logic
                $str = $_GET['checkbox'];
                $arr = explode("-", $str);

                if (count($arr) == 2) {
                    $minPrice = intval($arr[0]);
                    $maxPrice = intval($arr[1]);

                    $qu = "SELECT * FROM wishlist WHERE price >= $minPrice AND price <= $maxPrice AND user_id = '$user_id'";
                    $fetch = mysqli_query($conn, $qu);

                    if ($fetch) {
                        if (mysqli_num_rows($fetch) > 0) {
                            while ($rowing = mysqli_fetch_assoc($fetch)) {
                                $amount = $rowing['price'];
                                echo ' 
    <div class="wishlist-card">
        <img src="../uploads/' . $rowing['image'] . '" alt="Product" style="width: 200px; height: 200px; object-fit: cover;">
        <div class="wishlist-card-content">
            <h3 class="wishlist-card-title">' . $rowing['title'] . '</h3>
            <p class="wishlist-card-price">$' . $rowing['price'] . '</p>
            <a href="wishlist_delete.php?id=' . $rowing['id'] . '" style="background-color: danger;">Remove</a>
            <button class="payButton btn btn-dark text-uppercase mt-3" 
                    data-amount="' . htmlspecialchars($rowing['price'] * 100) . '" 
                    data-title="' . htmlspecialchars($rowing['title']) . '">
                Pay Now
            </button>
        </div>
    </div>';
                            }
                        } else {
                            echo "<p>No items found in the selected price range.</p>";
                        }
                    } else {
                        echo "<p>Error fetching data: " . mysqli_error($conn) . "</p>";
                    }
                }
            } else {
                echo "<p>Please select a price range.</p>";
            }
        }


        ?>

        <div class="wishlist-cards"> <!-- This div now wraps all the cards -->
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





            ?>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButtons = document.querySelectorAll('.payButton');

            payButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    const amount = this.getAttribute('data-amount'); // Retrieve the amount
                    const title = this.getAttribute('data-title'); // Retrieve the product title

                    var options = {
                        "key": "rzp_test_xKpWOmC2HxLD0g", // Enter the Key ID generated from the Dashboard
                        "amount": amount, // Amount is in currency subunits. Default currency is INR.
                        "currency": "INR",
                        "name": "Your Company Name",
                        "description": `Purchase for ${title}`, // Dynamically set the description
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
                });
            });
        });
    </script>


</body>

</html>