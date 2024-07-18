<?php
// Include the Razorpay PHP library
require('razorpay-php/Razorpay.php');
session_start();

use Razorpay\Api\Api;

// Initialize Razorpay with your key and secret
$api_key = 'rzp_test_Y2wy8t1wD1AFaA';
$api_secret = 'zSqRMpIa2ljBBpkieFYGmfLa';

$api = new Api($api_key, $api_secret);

// Check if payment is successful
$success = true;

$error = null;

// Get the payment ID and the signature from the callback
$payment_id = $_POST['razorpay_payment_id'];
$razorpay_signature = $_POST['razorpay_signature'];

try {
    // Verify the payment
    $attributes = array(
        'razorpay_order_id' => $_POST['razorpay_order_id'],
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature' => $razorpay_signature
    );
    $api->utility->verifyPaymentSignature($attributes);
} catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
    $success = false;
    $error = 'Razorpay Signature Verification Failed';
}

if ($success) {
    // Payment is successful, update your database or perform other actions

    // Fetch the payment details
    $payment = $api->payment->fetch($payment_id);

    // You can access payment details like $payment->amount, $payment->status, etc.
    $amount_paid = $payment->amount / 100; // Convert amount from paise to rupees

    $_SESSION['payment_status']='success';

    echo "Payment Successful! Amount: $amount_paid INR";

    $_SESSION['user_id'];
    $_SESSION['address'];
    $_SESSION['city'];
    $_SESSION['pincode'];
    $_SESSION['payment_type'];

    $order_status= 'pending';
    $added_on=date('y-m-d h:i:s');

    if($payment_type == 'cod' || $payment_status == 'success' ){
        mysqli_query($con,"INSERT INTO `order` (user_id, address, city, pincode, payment_type, total_price, payment_status, order_status, added_on)
        VALUES ('$user_id', '$address', '$city', '$pincode', '$payment_type', '$total_price', '$payment_status', '$order_status', '$added_on')");

        $order_id=mysqli_insert_id($con);

        foreach($data as $item){
            $product_id =$item['product_id'];
            $qty =$item['product_qty'];
            $price =$item['product_price'];

            mysqli_query($con,"INSERT INTO `order_details` (order_id, product_id, qty, price)
            VALUES ('$order_id', '$product_id', '$qty', '$price')");
        }
        $delete_sql = "DELETE FROM cart WHERE user_id = $id";
        mysqli_query($con,$delete_sql);

        // echo '<script>window.location.href = "thanku.php";</script>';
    }

} else {
    // Payment failed, handle accordingly
    echo "Payment Failed! Error: $error";
}
?>
