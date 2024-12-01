<?php
session_start();
include('../conn.php');

$user_id = $_SESSION['email'];

// Check for required GET parameters
if (isset($_GET['name'], $_GET['price'], $_GET['image'])) {
    $name = htmlspecialchars($_GET['name']);
    $price = htmlspecialchars($_GET['price']);
    $image = htmlspecialchars($_GET['image']);
} else {
    echo "Product details missing!";
    exit;
}

$email = $_SESSION['email'] ?? null;
if (!$email) {
    echo "User not logged in!";
    exit;
}

// Check if the item already exists in the wishlist or we find data
$check_sql = "SELECT * FROM `best_selling_items` WHERE `name` = '$name' AND `user_id` = '$email'";
$result = mysqli_query($conn, $check_sql);

if (!$result) {
    echo "Error in query: " . mysqli_error($conn);
    exit;
}

if (mysqli_num_rows($result) == 0) {
    // Insert the product into the wishlist
    $insert = "INSERT INTO `best_selling_items`(`name`, `image`, `price`, `user_id`) VALUES ('$name', '$image', '$price', '$email')";
    if (!mysqli_query($conn, $insert)) {
        echo "Error inserting into wishlist: " . mysqli_error($conn);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <style>
        /* Buy Now Button */
        .btn-danger {
            background-color: #ff5722;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-danger:hover {
            background-color: #e64a19;
            transform: scale(1.05);
        }
    </style>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>
    <h1 style="display: flex; justify-content: center; color: blue; margin-bottom: 20px;">
        You can Buy from this page
    </h1>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButtons = document.querySelectorAll('.payButton');

            payButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    const amount = this.getAttribute('data-amount'); // Retrieve the amount
                    const title = this.getAttribute('data-title'); // Retrieve the product title

                    var options = {
                        "key": "rzp_test_xKpWOmC2HxLD0g", // Enter the Key ID generated from the Dashboard
                        "amount": amount, // Amount in currency subunits
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

    <?php
    // Display all items when "Clear Filter" is clicked
    $query = "SELECT * FROM best_selling_items WHERE user_id = '$user_id'";
    $fetchalldata = mysqli_query($conn, $query);

    if (mysqli_num_rows($fetchalldata) > 0) {
        while ($rowings = mysqli_fetch_assoc($fetchalldata)) {
            $image = htmlspecialchars($rowings['image']);
            $name = htmlspecialchars($rowings['name']);
            $price = htmlspecialchars($rowings['price']);
            $amount = $price * 100;

            echo '
            <div class="swiper-slide">
                <div class="product-item image-zoom-effect link-effect">
                    <div class="image-holder" style="display: flex; align-items: center; gap: 20px; background-color: #f8f9fa; border-radius: 10px; padding: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease;">
                    
                        <!-- Product Image -->
                        <a href="index.html" style="flex-shrink: 0;">
                            <img src="../uploads/' . $image . '" alt="' . $name . '" class="product-image img-fluid" style="width: 150px; height: 150px; border-radius: 10px; object-fit: cover;">
                        </a>
    
                        <!-- Product Content -->
                        <div style="flex: 1;">
                            <h5 class="text-uppercase fs-5 mt-3" style="margin: 0; font-weight: bold; color: #333;">
                                <a href="index.html" style="text-decoration: none; color: #007bff;">' . htmlspecialchars($rowings['name']) . '</a>
                            </h5>
                            <p style="margin: 10px 0; color: #666;">A stunning one-piece for any occasion.</p>
                        </div>
                            <p class="text-decoration-none" data-after="Add to cart" style="color: #28a745; font-size: 1.2rem; font-weight: bold;">₹' . htmlspecialchars($rowings['price']) . '</p>
                        </div>
    
                        <!-- Wishlist & Action Buttons -->
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                            <a href="./User/cart.php" class="btn-icon btn-wishlist" style="text-decoration: none; color: #dc3545; font-size: 1.5rem;">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#heart"></use>
                                    </svg>
                                    </a>
                                    </div>
                                    <button class="payButton btn btn-danger" data-amount="' . $amount . '" data-title="' . $name . '" style="padding: 10px 20px; border-radius: 5px; font-size: 0.9rem; cursor: pointer;">Buy Now</button>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p>No items found in your wishlist.</p>';
    }

    ?>
</body>

</html>