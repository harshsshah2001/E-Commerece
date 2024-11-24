
<?php

include('../conn.php');

session_start();

// Get order ID and amount from the URL query parameters
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 'No Order ID';
$amount = isset($_GET['amount']) ? $_GET['amount'] : 'No Amount';
$amount_in_inr = $amount / 100;

$userName = isset($_SESSION['name']) ? $_SESSION['name'] : 'No username';
try {

    // Insert payment details into the database
    $stmt = mysqli_query($conn, "INSERT INTO payment (name, order_id, amount) VALUES ('$userName', '$order_id', '$amount_in_inr')");

    if ($stmt) {
        echo "<h1>Payment Successful</h1>";
        echo "<p>Order ID: " . htmlspecialchars($order_id) . "</p>";
        echo "<p>Amount: ₹" . htmlspecialchars($amount_in_inr) . "</p>";
        echo "<p>Username: " . htmlspecialchars($userName) . "</p>";
    } else {
        echo "Error: Could not save payment details.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
