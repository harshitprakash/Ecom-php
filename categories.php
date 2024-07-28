<?php 
    require('top.php');
    $error='';

    if (isset($_GET['id'])) {
        $cat_id = mysqli_real_escape_string($con, $_GET['id']);
        $get_product=get_product($con,'','',$cat_id);
        $sql="SELECT * FROM categories where id=$cat_id AND status =1";
        $res = mysqli_query($con, $sql);
        $row=mysqli_fetch_assoc($res);
    } else {
        echo "Category ID is not set or invalid."; // Handle case where category ID is not provided
    }
?>


<div class="body__overlay"></div>
        
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/head.png) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html" style="color:white; font-size:25px; font-family:Old Standard TT">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right" style="color:white; font-size:25px;"></i></span>
                                  <span class="breadcrumb-item active" style="color:white; font-size:25px; font-family:Ubuntu;"><?php echo $row['categories']?></span>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html" style="color:white; font-size:25px; font-family:Old Standard TT">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right" style="color:white; font-size:25px;"></i></span>
                                  <span class="breadcrumb-item active" style="color:white; font-size:25px; font-family:Ubuntu;"><?php echo $row['categories']?></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Grid -->
        <section class="htc__product__grid bg__white ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="htc__product__rightidebar">
                           
                            <!-- Start Product View -->

                            <div class="row">
                                <div class="shop__grid__view__wrap">
                                    <div class="col-lg-12 text-center text-danger">
                                        <h3 style="font-family:monospace;">Fashion <?php echo $row['categories']?></h3>
                                    </div>
                                    <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
                                        <!-- Start Single Product -->
                                         <?php
                                         if(empty($get_product)){
                                            echo '<div style="color: red; font-size: 20px; text-align:center;">';
                                            echo "SORRY CATEGORY IS EMPTY. Click here for";echo '<a href="index.php"> Continue Shopping</a>';
                                            echo '</div>';
                                         } 
                                         else{
                                           
                                         
                                         foreach($get_product as $list){ ?>
                                        <div class="col-md-4 col-lg-3 col-sm-6 col-xs-6">
                                            <div class="category">
                                                
                                                <div class="image-container">
                                                    <a href="product-details.php?id=<?php echo $list['id']?>">
                                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images"class="resized-image" >
                                                    </a>
                                                </div>
                                                
                                                <div class="fr__product__inner">
                                                    <h4><a href="product-details.php?id=<?php echo $list['id']?>"><?php echo $list['name']?></a></h4>
                                                    <ul class="fr__pro__prize">
                                                        <li class="old__prize"><?php echo $list['mrp']?></li>
                                                        <li><?php echo $list['price']?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }}?>
                                        <!-- End Single Product -->
                                    
                                    </div>
                                   
                                </div>
                            </div>
                            <!-- End Product View -->
                        </div>
                        
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- End Product Grid -->
        <!-- Start Brand Area -->
        <div class="htc__brand__area bg__cat--4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ht__brand__inner">
                            <ul class="brand__list owl-carousel clearfix">
                                <li><a href="#"><img src="images/brand/1.png" alt="brand images"></a></li>
                                <li><a href="#"><img src="images/brand/2.png" alt="brand images"></a></li>
                                <li><a href="#"><img src="images/brand/3.png" alt="brand images"></a></li>
                                <li><a href="#"><img src="images/brand/4.png" alt="brand images"></a></li>
                                <li><a href="#"><img src="images/brand/5.png" alt="brand images"></a></li>
                                <li><a href="#"><img src="images/brand/5.png" alt="brand images"></a></li>
                                <li><a href="#"><img src="images/brand/1.png" alt="brand images"></a></li>
                                <li><a href="#"><img src="images/brand/2.png" alt="brand images"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Brand Area -->
        <!-- Start Banner Area -->
        <div class="htc__banner__area">
            <ul class="banner__list owl-carousel owl-theme clearfix">
                <li><a href="product-details.html"><img src="images/banner/bn-3/1.jpg" alt="banner images"></a></li>
                <li><a href="product-details.html"><img src="images/banner/bn-3/2.jpg" alt="banner images"></a></li>
                <li><a href="product-details.html"><img src="images/banner/bn-3/3.jpg" alt="banner images"></a></li>
                <li><a href="product-details.html"><img src="images/banner/bn-3/4.jpg" alt="banner images"></a></li>
                <li><a href="product-details.html"><img src="images/banner/bn-3/5.jpg" alt="banner images"></a></li>
                <li><a href="product-details.html"><img src="images/banner/bn-3/6.jpg" alt="banner images"></a></li>
                <li><a href="product-details.html"><img src="images/banner/bn-3/1.jpg" alt="banner images"></a></li>
                <li><a href="product-details.html"><img src="images/banner/bn-3/2.jpg" alt="banner images"></a></li>
            </ul>
        </div>
        <!-- End Banner Area -->
         
<?php require('footer.php'); ?>