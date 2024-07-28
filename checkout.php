<?php 
    require ('top.php');    
    // Include the Razorpay PHP library
    require('razorpay-sample/razorpay-php/Razorpay.php');
    use Razorpay\Api\Api;

    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
    
        $sql="SELECT * from cart where user_id=$id";
        $res=mysqli_query($con,$sql);
        $data=array();
        while($row=mysqli_fetch_assoc($res)){
            $data[]=$row;
        }
        $check=mysqli_num_rows($res);
        if($check>0){
            if(isset($_GET['type']) && $_GET['type'] != ''){
                $type=get_safe_value($con,$_GET['type']);
                $cart_id = get_safe_value($con,$_GET['id']);
        
                if($type =='delete'){
                    $delete_sql="DELETE from cart WHERE id=$cart_id ";
                    $req= mysqli_query($con,$delete_sql);
                    echo '<script>window.location.href = "checkout.php";</script>';
                }
            }
        }
        else{
            echo '<script>window.location.href = "cart.php";</script>';
        }
    }else{
            echo '<script>window.location.href = "login.php?error=Please%20Login,%20Before%20Adding%20items%20into%20cart.";</script>';
        }
        $total= 0;
        $total_price=0;
        foreach($data as $list){
            $price=$list['product_price']*$list['product_qty'];$total_price+=$price;
        }
        if(isset($_POST['submit'])){
            $user_id=get_safe_value($con,$_SESSION['id']);
            $address=get_safe_value($con,$_POST['address']);
            $city=get_safe_value($con,$_POST['city']);
            $pincode=get_safe_value($con,$_POST['pincode']);
            $payment_type=get_safe_value($con,$_POST['payment_type']);
            $payment_status = 'pending';

            if($payment_type == 'upi'){
                $_SESSION['user_id']=$user_id;
                $_SESSION['address']=$address;
                $_SESSION['city']=$city;
                $_SESSION['pincode']=$pincode;
                $_SESSION['payment_type']=$payment_type;
                $_SESSION['price']=$price;
            }
            if($payment_type == 'cod'){
                    $payment_status = 'pending';
            }
            $order_status= 'pending';
            $added_on=date('y-m-d h:i:s');

        
            if($payment_type == 'cod'){
                    mysqli_query($con,"INSERT INTO `order` (user_id, address, city, pincode, payment_type, total_price, payment_status, order_status, added_on)
                    VALUES ('$user_id', '$address', '$city', '$pincode', '$payment_type', '$price', '$payment_status', '$order_status', '$added_on')");
        
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
        
                echo '<script>window.location.href = "thanku.php";</script>';
            }


            if($payment_type == 'upi'){
                
                // Initialize Razorpay with your key and secret
                $api_key = 'rzp_test_wSirrieZoS3azs';
                $api_secret = '3kPVVR7nGOMFFFa7vQJ6O2S6';

                $api = new Api($api_key, $api_secret);
                // Create an order
                $order = $api->order->create([
                    'amount' => $total_price*100, // amount in paise (100 paise = 1 rupee)
                    'currency' => 'INR',
                    'receipt' => 'order_receipt_12asa3'
                ]);
                // Get the order ID
                $order_id = $order->id;

                // Set your callback URL
                $callback_url = "http://localhost/php-project/razorpay-sample/success.php?id=" . $_SESSION['user_id'];

                // Include Razorpay Checkout.js library
                echo '<script src="https://checkout.razorpay.com/v1/checkout.js"></script>';

                // Create a payment button with Checkout.js
                echo '<button onclick="startPayment()">Pay with Razorpay</button>';

                // Add a script to handle the payment
                echo '<script>
                    function startPayment() {
                        var options = {
                            key: "' . $api_key . '",
                            amount: ' . $order->amount . ',
                            currency: "' . $order->currency . '",
                            name: "Future Fashion",
                            description: "Payment for your order",
                            image: "https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png",
                            order_id: "' . $order_id . '",
                            theme:
                            {
                                "color": "#738276"
                            },
                            callback_url: "' . $callback_url . '"
                        };
                        var rzp = new Razorpay(options);
                        rzp.open();
                    }
                </script>';
            }
            // if(isset($_SESSION['payment_status'])){
              
            //     $payment_status=$_SESSION['payment_status'];
            //     unset($_SESSION['payment_status']);
            // }
        
           
        }
        

   
?>
<!-- cart-main-area start -->
<div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                    <form action="#" method="POST">

                                        <div class="accordion__title">
                                            Address Information
                                        </div>
                                        <div class="accordion__body">
                                            <div class="bilinfo">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="single-input">
                                                                <input type="text" name="address" placeholder="Address" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="single-input">
                                                                <input type="text" name="city" placeholder="City/State"  required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="single-input">
                                                                <input type="number" name="pincode" placeholder="Post code/ zip"  required>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="accordion__title">
                                            payment information
                                        </div>
                                        <div class="accordion__body">
                                            <div class="paymentinfo">
                                            <label>
                                                <input type="radio" name="payment_type" value="cod"  required>
                                                COD
                                            </label><br>
                                            <label>
                                                <input type="radio" name="payment_type" value="upi"  required>
                                                UPI
                                            </label><br>
                                            </div>
                                            <button class="btn btn-danger" name="submit">Submit</button>
                                        </div>
                                    

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-details">
                            <h5 class="order-details__title">Your Order</h5>
                            <div class="order-details__item">
                                <?php foreach($data as $list){?>
                                <div class="single-item">
                                    <div class="single-item__thumb">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['product_image']?>" alt="ordered item">
                                    </div>
                                    <div class="single-item__content">
                                        <a href="#"><?php echo $list['product_name']?></a>
                                        <a href="#"><?php echo $list['product_qty']?></a>
                                        <span class="price"><?php echo $price=$list['product_price']*$list['product_qty'];$total+=$price?></span>
                                    </div>
                                    <div class="single-item__remove">
                                        <a href="?type=delete&id=<?php echo $list['id']?>"><i class="zmdi zmdi-delete"></i></a>
                                    </div>
                                </div>
                                
                                <?php }?>
                            </div>
                            <div class="ordre-details__total">
                                <h5>Order total</h5>
                                <span class="price"><?php echo $total?></span>  
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->
<?php include "footer.php"; ?>
