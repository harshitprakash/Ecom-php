<?php 
    require ('top.php');
    $id=$_SESSION['id'];

    $start=0;
    $rows_per_page=10;
    $record ="SELECT * FROM `order`";
    $result = $con->query($record);
    if ($result->num_rows > 0) {
       // Output number of rows
       $nr_of_rows = $result->num_rows;
   }
    $pages=ceil($nr_of_rows/$rows_per_page);
    if(isset($_GET['page-nr'])){
       $page=$_GET['page-nr']-1;
       $start = $page*$rows_per_page;
    }

    $sql="SELECT * FROM `order` where user_id=$id LIMIT $start,$rows_per_page";
    $req=mysqli_query($con,$sql);
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
                                            
                                            while($data=mysqli_fetch_assoc($req)){
                                            ?>
                                            <tr>
                                                <td class="product-name"><a href="#"><?php echo $data['id']?></a></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['payment_type']?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['order_status']?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['payment_status']?></span></td>

                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $data['address']?></span></td>
                                                <td class="product-price"><span class="amount"><?php echo $data['added_on']?></span></td>
                                                <td class=""><a class="btn btn-info" href="order_details.php?id=<?php echo $data['id']?>">View Item</a></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                       
                                    </table>
                                </div>
                        <?php if($nr_of_rows >$rows_per_page){?> 
                            <div class=" container" style="margin-top:10px;">
                                <h5>Page no.<?php if(isset($_GET['page-nr'])){echo $_GET['page-nr'];}else{echo $page=1;}; ?> of <?php echo $pages?></h5>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li><a class="page-link text-danger" href="?page-nr=1">First page</a></li>
                                    <?php 
                                            if(isset($_GET['page-nr']) && $_GET['page-nr']>1 ){ ?>
                                        <li class="page-item"><a class="page-link text-danger" href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a></li>
                                        <?php }?>
                                                <?php for($counter=1;$counter<=$pages; $counter ++){ ?>
                                        <li class="page-item"><a class="page-link text-danger" href="?page-nr=<?php echo $counter?>"><?php echo $counter?></a></li>
                                                <?php }?>
                                                <?php if (!isset($_GET['page-nr'])) {?>
                                                <!-- <a class="page-link" href="?page-nr=2">Next</a> -->
                                                <?php
                                            } else {
                                                // If 'page-nr' is set
                                                $currentPage = $_GET['page-nr'];

                                                if ($currentPage >= $pages) {
                                                    // If current page is the last page or greater than the last page, show 'NEXT' link disabled or with no link
                                                    
                                                } else {
                                                    // Otherwise, show 'Next' link pointing to the next page number
                                                    ?>
                                                    <li><a class="page-link text-danger" href="?page-nr=<?php echo $currentPage + 1 ?>">Next</a></li>
                                                    <?php
                                                }
                                            }
                                        ?> 
                                        <li><a class="page-link text-danger" href="?page-nr=<?php echo $pages?>">Last page</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        <?php }?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wishlist-area end -->

<?php include "footer.php"; ?>
