<?php 
    require ('top.php');
    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
         
        
        $sql="SELECT * from cart where user_id=$id";
        $res=mysqli_query($con,$sql);
    
        if(isset($_GET['type']) && $_GET['type'] != ''){
            $type=get_safe_value($con,$_GET['type']);
            $id = get_safe_value($con,$_GET['id']);
    
            if($type =='delete'){
                $delete_sql="DELETE from cart WHERE id=$id ";
                $req= mysqli_query($con,$delete_sql);
                echo '<script>window.location.href = "cart.php";</script>';
            }
        }
    }
    else{
        echo '<script>window.location.href = "login.php?error=Please%20Login,%20Before%20Adding%20items%20into%20cart.";</script>';
    }
    
    $total= 0;
   


   
?>

<div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
           
        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">shopping cart</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
         
        <div class="cart-main-area ptb--100 bg__white">
            <div class="container">
            <?php  if (isset($_GET['success'])) {
                            $success_message = $_GET['success'];
                            echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($success_message) . '</div>';
                        }
             ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="#">               
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">products</th>
                                            <th class="product-name">name of products</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Amount</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                         while($row = mysqli_fetch_assoc($res)){?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['product_image']?>" alt="product img" style="height:100px;"/></a></td>
                                            <td class="product-name"><a href="#"></a>
                                                <ul  class="pro__prize">
                                                    <li><?php echo $row['product_name']?></li>
                                                </ul>
                                            </td>
                                            <td class="product-price"><span class="amount"><?php echo $row['product_price']?></span></td>
                                            <form action="">
                                                <?php if(isset($_GET['update'])){?>
                                                    <input type="text" name="product_qty" value="<?php echo $row['product_qty']?>">
                                                <?php }else{?>
                                                    <td class="product-price"><span class="amount"><?php echo $row['product_qty']?></span></td>
                                                <?php }?>
                                            </form>
                                            <td class="product-subtotal"><?php echo $amount =$row['product_price']*$row['product_qty'];$total+=$amount;?></td>
                                            <td class="product-remove">
                                                <a href="#" onclick="return confirmDelete(<?php echo $row['id']; ?>)">
                                                    <i class="icon-trash icons"></i>
                                                </a>
                                            </td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                  
                                        
                                            <th class="product-thumbnail"></th>
                                            <th class="product-name"></th>
                                            <th class="product-price"></th>
                                            <th class="product-quantity">Total Amount</th>
                                            <th class="product-subtotal"><?php echo $total; ?></th>
                                            <th class="product-remove"></th>
                                   
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
                                        <div class="buttons-cart">
                                            <a href="index.php">Continue Shopping</a>
                                        </div>
                                        <div class="buttons-cart checkout--btn">
                                            <a href="?edit=<?php echo $row=['product _qty']?>">update Quantity</a>
                                            <a href="checkout.php">checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->
        <!-- End Banner Area -->
    


<?php include "footer.php"; ?>
