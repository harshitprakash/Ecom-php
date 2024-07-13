<?php 
    require ('top.php');
     
    if(isset($_GET['id'])){
        $product_id=mysqli_real_escape_string($con,$_GET['id']);
        $sql = "SELECT product.*, categories.categories 
        FROM product
        JOIN categories ON product.categories_id = categories.id
        WHERE product.status = 1 AND product.id = $product_id";
            $res = mysqli_query($con, $sql);
            $data = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row;
            }
             

            $id=$data[0]['categories_id'];
            $sql2="SELECT * from product where categories_id=$id AND status=1 ORDER BY id DESC LIMIT 4";
            $res2=mysqli_query($con,$sql2);
            $data2=array();
            while ($row = mysqli_fetch_assoc($res2)) {
                $data2[] = $row;
            }

            
         }
         else{
            
         }
         $error='';
         
if(isset($_POST['add_to_cart'])) {
    $product_image=get_safe_value($con,$_POST['product_image']);
    $product_id=get_safe_value($con,$_POST['product_id']);
    $product_name=get_safe_value($con,$_POST['product_name']);
    $product_price=get_safe_value($con,$_POST['product_price']);
    $product_qty=get_safe_value($con,$_POST['qty']);
    
    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];

                $sql="SELECT * FROM cart WHERE product_id='$product_id' and user_id=$id";
            $res=mysqli_query($con,$sql);
            $check=mysqli_num_rows($res);
            
            if($check>0)
            {
            $error="Product exist in cart";
            }
            else{
                $add=mysqli_query($con,"INSERT into cart(product_id,product_name,product_price,product_qty,user_id,product_image)VALUES('$product_id','$product_name','$product_price','$product_qty','$id','$product_image')");

                $msg = "Item Added to cart";
                echo '<script>window.location.href = "cart.php?success=item%20Added%20into%20your%20cart."</script>';
                die();
            }
    }
    else{
        
        $error="Please login first for adding product into cart. ";
        echo '<script>window.location.href = "login.php?error=Please%20Login,%20Before%20Adding%20items%20into%20cart.";</script>';
        die();

    }
   

}
        
   

?>
      
<div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            
        </div>
        <!-- End Offset Wrapper -->
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
                                  <a class="breadcrumb-item" href="categories.php?id=<?php echo $data[0]['categories_id']?>"style="color:white; font-size:25px; font-family:Ubuntu;"><?php echo $data[0]['categories']?></a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"style="color:white; font-size:25px;"></i></span>
                                  <span class="breadcrumb-item active"style="color:white; font-size:25px; font-family:Ubuntu;"><?php echo $data[0]['name']?></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <?php foreach($data as $product_list){?>
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$product_list['image']?>" alt="full-image">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                                
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $product_list['name']?></h2>
                                <ul  class="pro__prize">
                                    <li class="old__prize">MRP: <?php echo $product_list['mrp']?></li>
                                    <li>Price: <?php echo $product_list['price']?></li>
                                </ul>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
                                    <?php if ($product_list['qty'] >= 1) { ?>
                                            <p><span>Availability:</span> In Stock <?php echo $product_list['qty']?></p>
                                        <?php } else { ?>
                                            <p><span>Availability:</span> Out of Stock</p>
                                        <?php } ?>

                                    </div>
                                    <div class="sin__desc align--left" style="margin-bottom:20px;">
                                        <p><span>Category</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="#"><?php echo $product_list['categories']?></a></li>
                                        </ul>
                                    </div>
                                    
                                    <ul class="pro__details__tab" role="tablist">
                                        <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">description</a></li>
                                    </ul>
                                    <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                        <div class="pro__tab__content__inner">
                                            <p><?php echo $data['0']['description'] ?></p>
                                        </div>
                                    </div>
                                    
                                    <form action="" method="POST">
                                            <input type="hidden" name="product_image" value="<?php echo $product_list['image']; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $product_list['id']; ?>">
                                            <input type="hidden" name="product_name" value="<?php echo $product_list['name']; ?>">
                                            <input type="hidden" name="product_price" value="<?php echo $product_list['price']; ?>">
                                            <div class="sin__desc align--left" style="margin-bottom:20px;">
                                                <p><span>Qty: </span></p>
                                                <select name="qty" id="" class="form-control">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>

                                                </select>
                                            </div>
                                        <div class="fr__list__btn" style="margin-top:20px;">
                                            <button name="add_to_cart" class="fr__btn">Add to cart</button>
                                        </div>
                                        <?php
                                            if (!empty($error)){?>
                                                    <div class="alert alert-danger" role="alert">
                                                        <h4 class="text-danger">
                                                            <?php echo $error; ?>
                                                        </h4>
                                                    </div>
                                        <?php } ?>
                                    </form>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- End Product Details Top -->
        </section>
        <!-- End Product Details Area -->
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        
                        <!-- End List And Grid View -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            
                            <!-- End Single Content -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Start Product Area -->
        <section class="htc__product__area--2 pb--100 product-details-res">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">New Arrivals</h2>
                            <p>But I must explain to you how all this mistaken idea</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__wrap clearfix">
                        <!-- Start Single Product -->
                       <?php 
                       foreach($data2 as $list){ ?>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <div class="category">
                                <div class="ht__cat__thumb">
                                    <a href="product-details.php?id=<?php echo $list['id']?>">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images">
                                    </a>
                                </div>
                                <div class="fr__hover__info">
                                    <ul class="product__action">
                                        <li><a href="wishlist.html"><i class="icon-heart icons"></i></a></li>

                                        <li><a href="cart.html"><i class="icon-handbag icons"></i></a></li>

                                        <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                    </ul>
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
                    <?php }?>
                        <!-- End Single Product -->
                        
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Area -->
        <!-- End Banner Area -->

<?php include "footer.php"; ?>
