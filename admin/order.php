<?php
    require('top.inc.php');
    require('admin_auth.php');

    auth();
   $text="";
   $start=0;
   $rows_per_page=10;
   if(isset($_GET['order_status'])){
    if($_GET['order_status']=='shipped'){
        $status='shipped';
    }
    if($_GET['order_status']=='delivered'){
        $status='delivered';
    }
        $order_id=$_GET['order_id'];
        $sql="UPDATE `order` SET order_status = '$status' WHERE id=$order_id";
        $req=mysqli_query($con,$sql);
        $msg= "Status has been updated to $status";
    }
   if(isset($_POST['text']) && $_POST['text'] != ''){
      $text=get_safe_value($con,$_POST['text']);

      $search_text = '%' . $text . '%';
      

      $record ="SELECT 
               `order`.*, 
               admin_users.username, 
               product.name
            FROM 
               `order`
            JOIN 
               admin_users ON `order`.user_id = admin_users.id
            JOIN 
               order_details ON `order`.id = order_details.order_id
            JOIN 
               product ON order_details.product_id = product.id
            WHERE 
               admin_users.username LIKE '$search_text'OR order.order_status LIKE '$search_text' OR order.payment_status LIKE '$search_text'";
      $result = $con->query($record);
      if ($result->num_rows > 0) {
         // Output number of rows
         $nr_of_rows = $result->num_rows;
         echo $nr_of_rows;

      }
      $pages=ceil($nr_of_rows/$rows_per_page);
      if(isset($_GET['page-nr'])){
         $page=$_GET['page-nr']-1;
         $start = $page*$rows_per_page;
      }

      $sql="SELECT 
      `order`.*, 
      admin_users.username, 
      product.name
   FROM 
      `order`
   JOIN 
      admin_users ON `order`.user_id = admin_users.id
   JOIN 
      order_details ON `order`.id = order_details.order_id
   JOIN 
      product ON order_details.product_id = product.id
   WHERE 
      admin_users.username LIKE '$search_text'OR order.order_status LIKE '$search_text' OR order.payment_status LIKE '$search_text'
      LIMIT $start,$rows_per_page";

      // $res=mysqli_query($con,$sql);


      $res=mysqli_query($con,$sql);
      
     
   }
else{
   
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
                $id=$_SESSION['id'];
                $sql="SELECT 
                        `order`.*, 
                        admin_users.username, 
                        product.name
                     FROM 
                        `order`
                     JOIN 
                        admin_users ON `order`.user_id = admin_users.id
                     JOIN 
                        order_details ON `order`.id = order_details.order_id
                     JOIN 
                        product ON order_details.product_id = product.id LIMIT $start,$rows_per_page";
                        $res=mysqli_query($con,$sql);

                       
}


            
?>
<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card ">
               <div class="card-body row">
                  <div class="col-sm-3">
                     <h2 class="box-title">All Orders </h2>
                  </div>
                  <div class="col-sm-7 d-flex justify-content-end">
                  <form class="form-inline" method="POST">
                     <input type="text" class="form-control" name="text" placeholder="Search" value="<?php  echo $text; ?>">
                     <button type="submit" class="btn btn-danger" name="search">
                        <i class="fa fa-search"></i>
                     </button>
                  </form>

                  </div>
                  <div class="col-sm-2 d-flex justify-content-end">
                     <a href="manage_product.php" type="button" class="btn btn-primary">Add Product</a>
                  </div>
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">Order Id</th>
                              <th class="text-center">User Name</th>
                                  <th class="text-center">Address</th>
                              <th class="text-center">City</th>
                              <th class="text-center">pincode</th>
                              <th class="text-center">Payment type</th>
                              <th class="text-center">Total Price</th>
                              <th class="text-center">Payment Status</th>
                              <th class="text-center">Order Status</th>
                              <th class="text-center">Action</th>

                           </tr>
                        </thead>
                        <tbody>
                           <?php while($row = mysqli_fetch_assoc($res)){?>
                           <tr>
                              <td class="text-center"><?php echo $row['id']?></td>
                              <td class="text-center"><?php echo $row['username']?></td>
                              <td class="text-center"><?php echo $row['address']?></td>
                              <td class="text-center"><?php echo $row['city']?></td>
                              <td class="text-center"><?php echo $row['pincode']?></td>
                              <td class="text-center"><?php echo $row['payment_type']?></td>
                              <td class="text-center"><?php echo $row['total_price']?></td>
                              <td class="text-center"><?php echo $row['payment_status']?></td>
                              <td class="text-center"><?php echo $row['order_status']?></td>
                              <td class="text-center">
                                 <?php $order_id = $row['id'];
                                 if($row['order_status']=='shipped'){
                                    echo "<a href='order.php?order_status=delivered&order_id=$order_id' class='btn btn-success'>Delivered</a>";
                                 }
                                 if($row['order_status']=='pending'){
                                    echo "<a href='order.php?order_status=shipped&order_id=$order_id' class='btn btn-warning'>Shipped</a>";
                                 }
                                    ?>

                                      
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
                  <?php if($nr_of_rows >$rows_per_page){
                  ?> 
               <div class=" container">
                 showing 1 of <?php echo $pages?>

                  <nav aria-label="Page navigation example">
                     <ul class="pagination">
                        <li><a class="page-link text-danger" href="?page-nr-1">First page</a></li>
                     <?php 
                              if(isset($_GET['page-nr']) && $_GET['page-nr']>1 ){ ?>
                        <li class="page-item"><a class="page-link text-danger" href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a></li>
                           <?php }?>
                                 <?php for($counter=1;$counter<=$pages; $counter ++){ ?>
                        <li class="page-item"><a class="page-link text-danger" href="?page-nr=<?php echo $counter?>"><?php echo $counter?></a></li>
                                 <?php }?>
                                 <?php if (!isset($_GET['page-nr'])) {?>
                                 <a class="page-link text-danger" href="?page-nr=2">Next</a>
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
</div>

<?php
require('footer.inc.php');
?>