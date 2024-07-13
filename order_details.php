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
                                                <th class="product-price"><span class="nobr">Payment Type</span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> order status</span></th>
                                                <th class="product-add-to-cart"><span class="nobr">Payment status </span></th>
                                                <th class="product-add-to-cart"><span class="nobr">Address </span></th>
                                                <th class="product-add-to-cart"><span class="nobr">Order Date</span></th>
                                                <th class="product-add-to-cart"><span class="nobr">view Items</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql="SELECT * FROM `order_details` where order_id=$id";
                                            $req=mysqli_query($con,$sql);
                                            while($data=mysqli_fetch_assoc($req)){
                                            ?>
                                            <tr>
                                                <td class="product-name"><a href="#"><?php echo $data['id']?></a></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['payment_type']?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['payment_status']?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['order_status']?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['address']?></span></td>
                                                <td class="product-price"><span class="amount"><?php echo $data['added_on']?></span></td>
                                                <td class=""><a class="btn btn-info" href="product_details.php?id=<?php echo $data['id']?>">View Item</a></td>
                                            </tr>
                                            <?php }?>
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
