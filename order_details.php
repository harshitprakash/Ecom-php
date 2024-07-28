<?php 
    require ('top.php');

    $id=get_safe_value($con,$_GET['id']);


?>
      
<div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            
        </div>
         <!-- Start Bradcaump area -->
         <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/head.png) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php" style="color:white; font-size:25px; font-family:Ubuntu;">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right" style="color:white; font-size:25px;"></i></span>
                                  <a class="breadcrumb-item" href="categories.php" style="color:white; font-size:25px; font-family:Ubuntu;">MY orders</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
          <!-- wishlist-area start -->
        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-name"><span class="nobr">Order ID</span></th>
                                                <th class="product-add-to-cart"><span class="nobr">QTY</span></th>
                                                <th class="product-add-to-cart"><span class="nobr">price of Product </span></th>
                                                <th class="product-add-to-cart"><span class="nobr">Total price of product</span></th>
                                                <th class="product-price"><span class="nobr">Product</span></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $uid=$_SESSION['id'];
                                            $sql="SELECT 
                                                order_details.*, 
                                                product.name, 
                                                product.image 
                                            FROM 
                                                order_details
                                            JOIN 
                                                `order` ON order_details.order_id = `order`.id
                                            JOIN 
                                                product ON order_details.product_id = product.id
                                            WHERE 
                                                order_details.order_id =$id
                                                AND `order`.user_id = $uid;";
                                            $req=mysqli_query($con,$sql);
                                            $total_price=0;
                                            while($data=mysqli_fetch_assoc($req)){
                                                $price=$data['qty']*$data['price'];
                                            ?>
                                            <tr>
                                                <td class="product-name"><a href="#"><?php echo $data['id']?></a></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['qty']?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['price']?></span></td>
                                                <td class="product-price"><span class="amount"><?php echo $price;$total_price+=$price;?></span></td>
                                                <td class="product-name"><span class="wishlist-in-stock"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$data['image']?>" alt="full-image" style=""><h4><span class="amount"><?php echo $data['name']?></span></h4>
                                                </span></td>

                                            </tr>
                                            <?php }?>
                                            <td class="product-price"></td>
                                            <td class="product-price"></td>
                                            <td class="product-price"><span class="amount">Total</span></td>
                                            <td class="product-price"><span class="amount"><?php echo $total_price?></span></td>
                                            <td class="product-price"></td>

                                        </tbody>
                                       
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wishlist-area end -->

<?php include "footer.php"; ?>
