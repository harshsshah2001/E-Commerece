<!DOCTYPE html>
<html>
<?php
$amount = 10;
?>

<head>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>
    <button id="payButton">Pay Now</button>

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