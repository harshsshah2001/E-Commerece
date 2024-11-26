<?php
session_start();
require('../conn.php');
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['order_id']) && isset($_GET['amount'])) {
    $order_id = $_GET['order_id'];
    $amount = $_GET['amount'];
    $email = $_SESSION['email'];

    // Craft the email content
    $msg = "
    <h1 style='color: red;'>Welcome to Our Harsh HUB!</h1>
    <p style='color: gray; font-size: 16px;'>
        Thank you for your order. Your payment of ₹" . ($amount / 100) . " has been received. Order ID: $order_id.
    </p>";

    // Attempt to send the email
    if (smtp_mailer($email, 'Order Confirmation', $msg)) {
        echo "<p style='color: green;'>Confirmation email has been sent to your email: $email.</p>";
    } else {
        echo "<p style='color: red;'>Failed to send the confirmation email.</p>";
    }
} else {
    echo '<h1>Payment was not successful</h1>';
}

// Function to send email
function smtp_mailer($to, $subject, $msg)
{
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // Set Gmail credentials
        $mail->Username = "hs6648279@gmail.com";  // Replace with your Gmail address
        $mail->Password = "hmdh jshj qqcf aqzt"; // Replace with your Gmail App Password
        $mail->setFrom('hs6648279@gmail.com', "Harsh Shah"); // Replace with your sender details

        // Email details
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->addAddress($to);

        // SMTP options for compatibility
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Send email
        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
?>



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
                "amount": "<?php echo $amount * 100 ?>", // Amount is in currency subunits
                "currency": "INR",
                "name": "Your Company Name",
                "description": "Purchase Description",
                "image": "https://yourdomain.com/your_logo.png",
                "handler": function(response) {
                    // Redirect to success page with order ID and amount as query parameters
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
        };
    </script>
</body>

</html>