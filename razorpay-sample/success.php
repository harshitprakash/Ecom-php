<?php
require('../admin/connection.inc.php');
if(isset($_SESSION['id'],$_SESSION['user_id'])){
    $id=$_SESSION['id'];
    $order_status= 'pending';
    $added_on=date('y-m-d h:i:s');
    $payment_status='success';

    if($payment_status == 'success' ){


        if (isset($_SESSION['user_id'], $_SESSION['address'], $_SESSION['city'], $_SESSION['pincode'], $_SESSION['payment_type'], $_SESSION['price'])) {
            $user_id=$_SESSION['user_id'];
            $address=$_SESSION['address'];
            $city=$_SESSION['city'];
            $pincode=$_SESSION['pincode'];
            $payment_type=$_SESSION['payment_type'];
            $price=$_SESSION['price'];

            unset($_SESSION['user_id']);
            unset($_SESSION['address']);
            unset($_SESSION['city']);
            unset($_SESSION['pincode']);
            unset($_SESSION['payment_type']);
            unset($_SESSION['price']);

            mysqli_query($con,"INSERT INTO `order` (user_id, address, city, pincode, payment_type, total_price, payment_status, order_status, added_on)
            VALUES ('$user_id', '$address', '$city', '$pincode', '$payment_type', '$price', '$payment_status', '$order_status', '$added_on')");
        
        }
        

        $order_id=mysqli_insert_id($con);

        $sql="SELECT * from cart where user_id=$id";
            $res=mysqli_query($con,$sql);
            $data=array();
            while($row=mysqli_fetch_assoc($res)){
                $data[]=$row;
            }

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
}else{
    header('Location:../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        .icon {
            color: #4caf50;
            font-size: 60px;
            margin-bottom: 20px;
        }
        h1 {
            color: #4caf50;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            margin-bottom: 20px;
        }
        .button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Payment Successful!</h1>
        <p>Thank you for your payment. Your transaction was successful.</p>
        <a href="../index.php" class="button">Back to Home</a>
    </div>
</body>
</html>
